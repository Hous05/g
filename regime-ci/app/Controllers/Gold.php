<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\WalletModel;
use RuntimeException;

class Gold extends BaseController
{
    public function index()
    {
        $userId = $this->requireUser();
        $walletModel = new WalletModel();
        $db = db_connect();
        $message = null;
        $error = null;

        if (strtolower($this->request->getMethod()) === 'post') {
            try {
                $result = $walletModel->activateGold($userId);
                $message = $result['already_gold'] ? 'Votre option Gold est déjà active.' : 'Option Gold activée.';
            } catch (RuntimeException $exception) {
                $error = $exception->getMessage();
            }
        }

        $priceRow = $db->table('parametres')->where('cle', 'prix_gold')->get()->getRowArray();
        $discountRow = $db->table('parametres')->where('cle', 'remise_gold_pct')->get()->getRowArray();

        return view('front/gold/index', [
            'title' => 'Gold',
            'user' => (new UserModel())->find($userId),
            'wallet' => $walletModel->getByUser($userId),
            'prixGold' => (float) ($priceRow['valeur'] ?? 50000),
            'remiseGold' => (float) ($discountRow['valeur'] ?? 15),
            'message' => $message,
            'error' => $error,
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
