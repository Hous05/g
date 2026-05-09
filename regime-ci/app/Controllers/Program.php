<?php

namespace App\Controllers;

use App\Models\HealthModel;
use App\Models\ObjectiveModel;
use App\Models\ProgramModel;

class Program extends BaseController
{
    public function objective()
    {
        $userId = $this->requireUser();

        if (strtolower($this->request->getMethod()) === 'post') {
            (new HealthModel())->setObjective(
                $userId,
                (int) $this->request->getPost('objectif_id'),
                $this->request->getPost('poids_cible_kg') !== '' ? (float) $this->request->getPost('poids_cible_kg') : null
            );
        }

        return view('front/program/objective', [
            'title' => 'Objectif',
            'objectives' => (new ObjectiveModel())->orderBy('id')->findAll(),
            'profile' => (new HealthModel())->findByUser($userId),
        ]);
    }

    public function detail()
    {
        $userId = $this->requireUser();
        $programModel = new ProgramModel();

        if (strtolower($this->request->getMethod()) === 'post') {
            $programModel->createProgram(
                $userId,
                (int) $this->request->getPost('regime_id'),
                (int) $this->request->getPost('activite_id')
            );
        }

        return view('front/program/detail', [
            'title' => 'Programme',
            'program' => $programModel->latestForUser($userId),
        ]);
    }

    public function export()
    {
        $userId = $this->requireUser();
        $program = (new ProgramModel())->latestForUser($userId);

        if (!$program) {
            return redirect()->to(site_url('program'));
        }

        return view('front/program/export', [
            'title' => 'Export programme',
            'program' => $program,
        ]);
    }

    private function requireUser(): int
    {
        if (!$this->session->get('user_id')) {
            redirect()->to(site_url('login'))->send();
            exit;
        }

        return (int) $this->session->get('user_id');
    }
}