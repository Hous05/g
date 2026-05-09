<?php

namespace App\Controllers;

use App\Models\ParameterModel;

class AdminParameters extends BaseController
{
    protected $paramModel;

    public function __construct()
    {
        $this->paramModel = new ParameterModel();
    }

    public function index()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $data = $this->request->getPost();
            foreach ($data as $key => $value) {
                // Update only existing parameters to avoid accidental inserts of invalid keys
                if ($this->paramModel->find($key)) {
                    $this->paramModel->update($key, ['valeur' => $value]);
                }
            }
            return redirect()->to(site_url('admin/parameters'))->with('message', 'Parametres mis a jour.');
        }

        $params = $this->paramModel->findAll();

        return view('back/parameters/index', [
            'title' => 'Parametres du systeme',
            'params' => $params
        ]);
    }
}
