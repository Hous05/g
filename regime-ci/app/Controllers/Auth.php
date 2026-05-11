<?php

namespace App\Controllers;

use App\Models\HealthModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function registerStepOne()
    {
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
                'email' => [
                    'rules' => 'required|valid_email|is_unique[utilisateurs.email]',
                    'errors' => [
                        'required' => 'Email obligatoire.',
                        'valid_email' => 'Email invalide.',
                        'is_unique' => 'Email deja utilise.',
                    ],
                ],
                'mot_de_passe' => [
                    'rules' => 'required|min_length[6]',
                    'errors' => [
                        'required' => 'Mot de passe obligatoire.',
                        'min_length' => 'Mot de passe trop court (6 caracteres min).',
                    ],
                ],
                'genre' => [
                    'rules' => 'required|in_list[homme,femme,autre]',
                    'errors' => [
                        'required' => 'Genre obligatoire.',
                        'in_list' => 'Genre invalide.',
                    ],
                ],
            ];

            if ($this->validate($rules)) {
                $userId = (new UserModel())->createUser($this->request->getPost());
                $this->session->set('user_id', $userId);
                return redirect()->to(site_url('register/health'));
            }

            $errors = $this->validator->getErrors();
        }

        return view('front/auth/register_step1', ['title' => 'Inscription', 'errors' => $errors]);
    }

    public function registerStepTwo()
    {
        $userId = $this->requireUser();
        $errors = [];

        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
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
                (new HealthModel())->saveProfile($userId, $this->request->getPost());
                return redirect()->to(site_url('objective'));
            }

            $errors = $this->validator->getErrors();
        }

        return view('front/auth/register_step2', ['title' => 'Sante', 'errors' => $errors]);
    }

    public function login()
    {
        $errors = [];
        $emailValue = 'hery@example.com';

        if (strtolower($this->request->getMethod()) === 'post') {
            $email = trim((string) $this->request->getPost('email'));
            $password = (string) $this->request->getPost('mot_de_passe');
            $emailValue = $email;

            if ($email === '') {
                $errors['email'] = 'Email obligatoire.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email invalide.';
            }

            if ($password === '') {
                $errors['mot_de_passe'] = 'Mot de passe obligatoire.';
            }

            if (!$errors) {
                $user = (new UserModel())->where('email', $email)->first();

                if (!$user) {
                    $errors['email'] = 'Email introuvable.';
                } elseif (!password_verify($password, $user['mot_de_passe'])) {
                    $errors['mot_de_passe'] = 'Mot de passe incorrect.';
                } else {
                    $this->session->set('user_id', (int) $user['id']);
                    return redirect()->to(site_url('profile'));
                }
            }
        }

        return view('front/auth/login', [
            'title' => 'Connexion',
            'errors' => $errors,
            'emailValue' => $emailValue,
        ]);
    }

    public function logout()
    {
        $this->session->remove('user_id');
        return redirect()->to(site_url('login'));
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