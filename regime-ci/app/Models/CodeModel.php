<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeModel extends Model
{
    protected $table            = 'codes_recharge';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'code',
        'montant',
        'statut',
        'utilisateur_id',
        'used_at',
        'created_at'
    ];

    public function generateUniqueCode()
    {
        do {
            $code = 'REG-' . mt_rand(1000, 999999) . '-' . strtoupper(substr(md5(uniqid()), 0, 4));
            $exists = $this->where('code', $code)->first();
        } while ($exists);

        return $code;
    }
}