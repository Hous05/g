<?php

namespace App\Controllers;

use App\Models\ActivityModel;
use App\Models\ObjectiveModel;

class AdminActivities extends BaseController
{
    protected $activityModel;

    public function __construct()
    {
        $this->activityModel = new ActivityModel();
    }

    public function index()
    {
        $search = $this->request->getGet('q');
        
        $builder = $this->activityModel->select('activites_sportives.*, objectifs.libelle as objectif_libelle')
                                       ->join('objectifs', 'objectifs.id = activites_sportives.objectif_id');
        
        if ($search) {
            $builder->like('activites_sportives.nom', $search);
        }

        $activities = $builder->findAll();

        return view('back/activities/index', [
            'title' => 'Gestion des Activites',
            'activities' => $activities,
            'search' => $search
        ]);
    }

    public function create()
    {
        $objectifModel = new ObjectiveModel();
        
        if (strtolower($this->request->getMethod()) === 'post') {
            $data = $this->request->getPost();
            $this->activityModel->insert($data);
            return redirect()->to(site_url('admin/activities'))->with('message', 'Activite ajoutee avec succes.');
        }

        return view('back/activities/form', [
            'title' => 'Ajouter une activite',
            'objectifs' => $objectifModel->findAll(),
            'activity' => null
        ]);
    }

    public function edit($id)
    {
        $activity = $this->activityModel->find($id);
        if (!$activity) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $objectifModel = new ObjectiveModel();

        if (strtolower($this->request->getMethod()) === 'post') {
            $data = $this->request->getPost();
            $this->activityModel->update($id, $data);
            return redirect()->to(site_url('admin/activities'))->with('message', 'Activite modifiee.');
        }

        return view('back/activities/form', [
            'title' => 'Modifier une activite',
            'objectifs' => $objectifModel->findAll(),
            'activity' => $activity
        ]);
    }

    public function delete($id)
    {
        // On supprime manuellement les dépendances pour forcer la suppression
        $db = \Config\Database::connect();
        $db->table('programmes')->where('activite_id', $id)->delete();
        $db->table('regime_activite')->where('activite_id', $id)->delete();

        $this->activityModel->delete($id);
        return redirect()->to(site_url('admin/activities'))->with('message', 'Activite et ses dependances ont ete supprimees.');
    }
}