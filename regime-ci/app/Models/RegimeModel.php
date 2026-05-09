<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table            = 'regimes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'objectif_id',
        'nom',
        'description',
        'duree_jours',
        'prix',
        'variation_poids_kg',
        'viande_pct',
        'poisson_pct',
        'volaille_pct',
        'actif'
    ];

    public function getWithObjectif($id = null)
    {
        $builder = $this->select('regimes.*, objectifs.libelle as objectif_libelle')
                        ->join('objectifs', 'objectifs.id = regimes.objectif_id');
        if ($id) {
            return $builder->where('regimes.id', $id)->first();
        }
        return $builder->findAll();
    }
}