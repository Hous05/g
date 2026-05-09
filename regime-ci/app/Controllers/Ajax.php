<?php

namespace App\Controllers;

use App\Models\HealthModel;
use App\Models\ProgramModel;
use App\Models\WalletModel;
use RuntimeException;

class Ajax extends BaseController
{
    public function imc()
    {
        $imc = HealthModel::calculateImc(
            (float) $this->request->getPost('poids_kg'),
            (float) $this->request->getPost('taille_cm')
        );

        return $this->response->setJSON([
            'imc' => $imc,
            'label' => HealthModel::imcLabel($imc),
        ]);
    }

    public function suggestions()
    {
        return $this->response->setJSON(
            (new ProgramModel())->suggestions(
                (int) $this->request->getPost('objectif_id'),
                (int) ($this->request->getPost('duree_jours') ?: 30)
            )
        );
    }

    public function recharge()
    {
        if (!$this->session->get('user_id')) {
            return $this->response->setStatusCode(401)->setJSON([
                'success' => false,
                'message' => 'Connexion requise.',
            ]);
        }

        try {
            $result = (new WalletModel())->rechargeWithCode(
                (int) $this->session->get('user_id'),
                (string) $this->request->getPost('code')
            );

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Recharge reussie.',
                'montant' => $result['montant'],
                'solde' => $result['solde'],
            ]);
        } catch (RuntimeException $exception) {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}