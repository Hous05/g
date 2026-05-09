<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table            = 'activites_sportives';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'objectif_id',
        'nom',
        'description',
        'frequence_semaine',
        'duree_minutes',
        'calories_estimees',
        'actif'
    ];

    public function getWithObjectif($id = null)
    {
        $builder = $this->select('activites_sportives.*, objectifs.libelle as objectif_libelle')
                        ->join('objectifs', 'objectifs.id = activites_sportives.objectif_id');
        if ($id) {
            return $builder->where('activites_sportives.id', $id)->first();
        }
        return $builder->findAll();
    }
}