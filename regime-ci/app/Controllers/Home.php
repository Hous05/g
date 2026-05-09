<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if ($this->session->get('user_id')) {
            return redirect()->to(site_url('profile'));
        }

        return view('front/home', ['title' => 'Accueil']);
    }
}