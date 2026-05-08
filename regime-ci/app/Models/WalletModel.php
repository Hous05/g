<?php

namespace App\Models;

use CodeIgniter\Model;
use RuntimeException;

class WalletModel extends Model
{
    protected $table = 'portefeuilles';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['utilisateur_id', 'solde'];

    public function getByUser(int $userId): array
    {
        $wallet = $this->where('utilisateur_id', $userId)->first();
        if ($wallet) {
            return $wallet;
        }

        $id = $this->insert(['utilisateur_id' => $userId, 'solde' => 0], true);
        return $this->find($id);
    }

    public function rechargeWithCode(int $userId, string $code): array
    {
        $code = trim($code);
        $db = db_connect();
        $db->transStart();

        $recharge = $db->table('codes_recharge')
            ->where('code', $code)
            ->where('statut', 'disponible')
            ->get()
            ->getRowArray();

        if (!$recharge) {
            $db->transComplete();
            throw new RuntimeException('Code invalide ou déjà utilisé.');
        }

        $wallet = $this->getByUser($userId);
        $newBalance = (float) $wallet['solde'] + (float) $recharge['montant'];

        $this->update($wallet['id'], ['solde' => $newBalance]);
        $db->table('codes_recharge')->where('id', $recharge['id'])->update([
            'statut' => 'utilise',
            'utilisateur_id' => $userId,
            'used_at' => date('Y-m-d H:i:s'),
        ]);
        $db->table('paiements')->insert([
            'utilisateur_id' => $userId,
            'type_paiement' => 'recharge',
            'montant' => $recharge['montant'],
            'reference' => $code,
        ]);

        $db->transComplete();

        return [
            'montant' => (float) $recharge['montant'],
            'solde' => $newBalance,
        ];
    }

    public function activateGold(int $userId): array
    {
        $db = db_connect();
        $user = (new UserModel())->find($userId);
        if (!$user) {
            throw new RuntimeException('Utilisateur introuvable.');
        }
        if ((int) $user['est_gold'] === 1) {
            return ['already_gold' => true, 'solde' => (float) $this->getByUser($userId)['solde']];
        }

        $priceRow = $db->table('parametres')->where('cle', 'prix_gold')->get()->getRowArray();
        $price = (float) ($priceRow['valeur'] ?? 50000);
        $wallet = $this->getByUser($userId);

        if ((float) $wallet['solde'] < $price) {
            throw new RuntimeException('Solde insuffisant pour activer Gold.');
        }

        $db->transStart();
        $newBalance = (float) $wallet['solde'] - $price;
        $this->update($wallet['id'], ['solde' => $newBalance]);
        (new UserModel())->update($userId, ['est_gold' => 1]);
        $db->table('paiements')->insert([
            'utilisateur_id' => $userId,
            'type_paiement' => 'gold',
            'montant' => $price,
            'reference' => 'activation_gold',
        ]);
        $db->transComplete();

        return ['already_gold' => false, 'solde' => $newBalance, 'prix' => $price];
    }
}
