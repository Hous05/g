<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\ObjectiveModel;

class AdminRegimes extends BaseController
{
    protected $regimeModel;

    public function __construct()
    {
        $this->regimeModel = new RegimeModel();
    }

    public function index()
    {
        $search = $this->request->getGet('q');
        
        $builder = $this->regimeModel->select('regimes.*, objectifs.libelle as objectif_libelle')
                                     ->join('objectifs', 'objectifs.id = regimes.objectif_id');
        
        if ($search) {
            $builder->like('regimes.nom', $search)
                    ->orLike('objectifs.libelle', $search);
        }

        $regimes = $builder->findAll();

        return view('back/regimes/index', [
            'title' => 'Gestion des Regimes',
            'regimes' => $regimes,
            'search' => $search
        ]);
    }

    public function ajaxList()
    {
        $search = $this->request->getPost('q');
        $builder = $this->regimeModel->select('regimes.*, objectifs.libelle as objectif_libelle')
                                     ->join('objectifs', 'objectifs.id = regimes.objectif_id');
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('regimes.nom', $search)
                    ->orLike('objectifs.libelle', $search)
                    ->groupEnd();
        }
        return $this->response->setJSON($builder->findAll());
    }

    public function create()
    {
        $objectifModel = new ObjectiveModel();

        if (strtolower($this->request->getMethod()) === 'post') {
            $data = $this->request->getPost();
            $this->regimeModel->insert($data);
            return redirect()->to(site_url('admin/regimes'))->with('message', 'Regime ajoute avec succes.');
        }

        return view('back/regimes/form', [
            'title' => 'Ajouter un regime',
            'objectifs' => $objectifModel->findAll(),
            'regime' => null
        ]);
    }

    public function edit($id)
    {
        $regime = $this->regimeModel->find($id);
        if (!$regime) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $objectifModel = new ObjectiveModel();

        if (strtolower($this->request->getMethod()) === 'post') {
            $data = $this->request->getPost();
            $this->regimeModel->update($id, $data);
            return redirect()->to(site_url('admin/regimes'))->with('message', 'Regime modifie avec succes.');
        }

        return view('back/regimes/form', [
            'title' => 'Modifier un regime',
            'objectifs' => $objectifModel->findAll(),
            'regime' => $regime
        ]);
    }

    public function delete($id)
    {
        // On supprime manuellement les dépendances pour forcer la suppression
        $db = \Config\Database::connect();
        $db->table('programmes')->where('regime_id', $id)->delete();
        $db->table('regime_activite')->where('regime_id', $id)->delete();

        $this->regimeModel->delete($id);
        return redirect()->to(site_url('admin/regimes'))->with('message', 'Regime et ses dependances ont ete supprimes.');
    }
}