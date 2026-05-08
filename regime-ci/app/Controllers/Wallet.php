<?php

namespace App\Controllers;

use App\Models\WalletModel;
use RuntimeException;

class Wallet extends BaseController
{
    public function index()
    {
        $userId = $this->requireUser();
        $walletModel = new WalletModel();
        $message = null;
        $error = null;

        if (strtolower($this->request->getMethod()) === 'post') {
            try {
                $result = $walletModel->rechargeWithCode($userId, (string) $this->request->getPost('code'));
                $message = 'Recharge réussie : +' . number_format($result['montant'], 0, ',', ' ') . ' Ar.';
            } catch (RuntimeException $exception) {
                $error = $exception->getMessage();
            }
        }

        return view('front/wallet/index', [
            'title' => 'Porte-monnaie',
            'wallet' => $walletModel->getByUser($userId),
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
