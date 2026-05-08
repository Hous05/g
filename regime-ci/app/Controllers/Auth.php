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
                'nom' => 'required|min_length[2]',
                'email' => 'required|valid_email|is_unique[utilisateurs.email]',
                'mot_de_passe' => 'required|min_length[6]',
                'genre' => 'required|in_list[homme,femme,autre]',
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
                'taille_cm' => 'required|decimal|greater_than[80]|less_than[250]',
                'poids_kg' => 'required|decimal|greater_than[25]|less_than[300]',
                'age' => 'required|integer|greater_than[10]|less_than[100]',
            ];

            if ($this->validate($rules)) {
                (new HealthModel())->saveProfile($userId, $this->request->getPost());
                return redirect()->to(site_url('objective'));
            }

            $errors = $this->validator->getErrors();
        }

        return view('front/auth/register_step2', ['title' => 'Santé', 'errors' => $errors]);
    }

    public function login()
    {
        $error = null;

        if (strtolower($this->request->getMethod()) === 'post') {
            $user = (new UserModel())->where('email', trim((string) $this->request->getPost('email')))->first();

            if ($user && password_verify((string) $this->request->getPost('mot_de_passe'), $user['mot_de_passe'])) {
                $this->session->set('user_id', (int) $user['id']);
                return redirect()->to(site_url('profile'));
            }

            $error = 'Email ou mot de passe incorrect.';
        }

        return view('front/auth/login', ['title' => 'Connexion', 'error' => $error]);
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
