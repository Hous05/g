<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'email', 'mot_de_passe'];

    public function stats(): array
    {
        $db = db_connect();

        return [
            'utilisateurs' => (int) $db->table('utilisateurs')->countAllResults(),
            'regimes' => (int) $db->table('regimes')->countAllResults(),
            'activites' => (int) $db->table('activites_sportives')->countAllResults(),
            'codes_disponibles' => (int) $db->table('codes_recharge')->where('statut', 'disponible')->countAllResults(),
            'programmes' => (int) $db->table('programmes')->countAllResults(),
        ];
    }
}
