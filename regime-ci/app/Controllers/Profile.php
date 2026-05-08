<?php

namespace App\Controllers;

use App\Models\HealthModel;
use App\Models\ObjectiveModel;
use App\Models\UserModel;

class Profile extends BaseController
{
    public function edit()
    {
        $userId = $this->requireUser();
        $userModel = new UserModel();
        $healthModel = new HealthModel();

        if (strtolower($this->request->getMethod()) === 'post') {
            $userModel->update($userId, [
                'nom' => trim((string) $this->request->getPost('nom')),
                'genre' => $this->request->getPost('genre'),
                'date_naissance' => $this->request->getPost('date_naissance') ?: null,
            ]);

            $healthModel->saveProfile($userId, [
                'taille_cm' => $this->request->getPost('taille_cm'),
                'poids_kg' => $this->request->getPost('poids_kg'),
                'age' => $this->request->getPost('age'),
                'objectif_id' => $this->request->getPost('objectif_id') ?: null,
                'poids_cible_kg' => $this->request->getPost('poids_cible_kg') ?: null,
            ]);

            return redirect()->to(site_url('profile'));
        }

        return view('front/profile/edit', [
            'title' => 'Profil',
            'user' => $userModel->find($userId),
            'profile' => $healthModel->findByUser($userId),
            'objectives' => (new ObjectiveModel())->orderBy('id')->findAll(),
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
