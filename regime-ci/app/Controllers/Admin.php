<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Admin extends BaseController
{
    public function login()
    {
        $error = null;

        if (strtolower($this->request->getMethod()) === 'post') {
            $admin = (new AdminModel())->where('email', trim((string) $this->request->getPost('email')))->first();

            if ($admin && password_verify((string) $this->request->getPost('mot_de_passe'), $admin['mot_de_passe'])) {
                $this->session->set('admin_id', (int) $admin['id']);
                return redirect()->to(site_url('admin/dashboard'));
            }

            $error = 'Identifiants administrateur invalides.';
        }

        return view('back/auth/login', ['title' => 'Admin', 'error' => $error]);
    }

    public function dashboard()
    {
        if (!$this->session->get('admin_id')) {
            return redirect()->to(site_url('admin/login'));
        }

        return view('back/dashboard/index', [
            'title' => 'Tableau de bord',
            'stats' => (new AdminModel())->stats(),
        ]);
    }

    public function logout()
    {
        $this->session->remove('admin_id');
        return redirect()->to(site_url('admin/login'));
    }
}
