<?php

namespace App\Controllers;

use App\Models\CodeModel;

class AdminCodes extends BaseController
{
    protected $codeModel;

    public function __construct()
    {
        $this->codeModel = new CodeModel();
    }

    public function index()
    {
        $search = trim((string) $this->request->getGet('q'));
        $statut = trim((string) $this->request->getGet('statut'));

        $builder = $this->codeModel
            ->select('codes_recharge.*, utilisateurs.nom AS utilisateur_nom, utilisateurs.email AS utilisateur_email')
            ->join('utilisateurs', 'utilisateurs.id = codes_recharge.utilisateur_id', 'left')
            ->orderBy('codes_recharge.id', 'DESC');

        if ($search !== '') {
            $builder->like('codes_recharge.code', $search);
        }

        if (in_array($statut, ['disponible', 'utilise', 'expire'], true)) {
            $builder->where('codes_recharge.statut', $statut);
        }

        $codes = $builder->findAll();

        return view('back/codes/index', [
            'title' => 'Gestion des Codes de Recharge',
            'codes' => $codes,
            'search' => $search,
            'statut' => $statut,
        ]);
    }

    public function generate()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $montant = (float) $this->request->getPost('montant');
            $quantite = (int) $this->request->getPost('quantite');

            if ($montant > 0 && $quantite > 0) {
                for ($i = 0; $i < $quantite; $i++) {
                    $code = $this->codeModel->generateUniqueCode();
                    $this->codeModel->insert([
                        'code' => $code,
                        'montant' => $montant,
                        'statut' => 'disponible'
                    ]);
                }
                return redirect()->to(site_url('admin/codes'))->with('message', "$quantite codes de $montant Ar generes.");
            }
        }
        return redirect()->to(site_url('admin/codes'))->with('message', 'Erreur de generation.');
    }

    public function delete($id)
    {
        $code = $this->codeModel->find($id);
        if (!$code) {
            return redirect()->to(site_url('admin/codes'))->with('message', 'Code introuvable.');
        }

        if ($code['statut'] === 'utilise') {
            return redirect()->to(site_url('admin/codes'))->with('message', 'Impossible de supprimer un code utilise.');
        }

        $this->codeModel->delete($id);
        return redirect()->to(site_url('admin/codes'))->with('message', 'Code supprime.');
    }

    public function status($id)
    {
        $code = $this->codeModel->find($id);
        if (!$code) {
            return redirect()->to(site_url('admin/codes'))->with('message', 'Code introuvable.');
        }

        if ($code['statut'] === 'utilise') {
            return redirect()->to(site_url('admin/codes'))->with('message', 'Impossible de modifier un code utilise.');
        }

        $statut = (string) $this->request->getPost('statut');
        if (!in_array($statut, ['disponible', 'expire'], true)) {
            return redirect()->to(site_url('admin/codes'))->with('message', 'Statut invalide.');
        }

        $this->codeModel->update($id, ['statut' => $statut]);
        return redirect()->to(site_url('admin/codes'))->with('message', 'Statut mis a jour.');
    }
}
