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
        $codes = $this->codeModel->orderBy('id', 'DESC')->findAll();

        return view('back/codes/index', [
            'title' => 'Gestion des Codes de Recharge',
            'codes' => $codes
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
        $this->codeModel->delete($id);
        return redirect()->to(site_url('admin/codes'))->with('message', 'Code supprime.');
    }
}
