<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'email', 'mot_de_passe', 'genre', 'date_naissance', 'est_gold'];

    public function createUser(array $data): int
    {
        $userId = (int) $this->insert([
            'nom' => $data['nom'],
            'email' => $data['email'],
            'mot_de_passe' => password_hash($data['mot_de_passe'], PASSWORD_DEFAULT),
            'genre' => $data['genre'],
            'date_naissance' => $data['date_naissance'] ?: null,
        ], true);

        db_connect()->table('portefeuilles')->insert([
            'utilisateur_id' => $userId,
            'solde' => 0,
        ]);

        return $userId;
    }
}