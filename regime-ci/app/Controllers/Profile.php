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
        $errors = [];

        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'nom' => [
                    'rules' => 'required|min_length[2]',
                    'errors' => [
                        'required' => 'Nom obligatoire.',
                        'min_length' => 'Nom trop court (2 caracteres min).',
                    ],
                ],
                'genre' => [
                    'rules' => 'required|in_list[homme,femme,autre]',
                    'errors' => [
                        'required' => 'Genre obligatoire.',
                        'in_list' => 'Genre invalide.',
                    ],
                ],
                'taille_cm' => [
                    'rules' => 'required|decimal|greater_than[80]|less_than[250]',
                    'errors' => [
                        'required' => 'Taille obligatoire.',
                        'decimal' => 'Taille invalide.',
                        'greater_than' => 'Taille trop petite (min 80).',
                        'less_than' => 'Taille trop grande (max 250).',
                    ],
                ],
                'poids_kg' => [
                    'rules' => 'required|decimal|greater_than[25]|less_than[300]',
                    'errors' => [
                        'required' => 'Poids obligatoire.',
                        'decimal' => 'Poids invalide.',
                        'greater_than' => 'Poids trop petit (min 25).',
                        'less_than' => 'Poids trop grand (max 300).',
                    ],
                ],
                'age' => [
                    'rules' => 'required|integer|greater_than[10]|less_than[100]',
                    'errors' => [
                        'required' => 'Age obligatoire.',
                        'integer' => 'Age invalide.',
                        'greater_than' => 'Age trop petit (min 10).',
                        'less_than' => 'Age trop grand (max 100).',
                    ],
                ],
            ];

            if ($this->validate($rules)) {
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

            $errors = $this->validator->getErrors();
        }

        return view('front/profile/edit', [
            'title' => 'Profil',
            'user' => $userModel->find($userId),
            'profile' => $healthModel->findByUser($userId),
            'objectives' => (new ObjectiveModel())->orderBy('id')->findAll(),
            'errors' => $errors,
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