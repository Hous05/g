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

        $stats = [
            'utilisateurs' => (int) $db->table('utilisateurs')->countAllResults(),
            'regimes' => (int) $db->table('regimes')->countAllResults(),
            'activites' => (int) $db->table('activites_sportives')->countAllResults(),
            'codes_disponibles' => (int) $db->table('codes_recharge')->where('statut', 'disponible')->countAllResults(),
            'programmes' => (int) $db->table('programmes')->countAllResults(),
            'revenus_totaux' => (float) $db->table('paiements')->selectSum('montant')->get()->getRow()->montant,
        ];

        // Monthly revenue for chart
        $query = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as mois, SUM(montant) as total FROM paiements GROUP BY mois ORDER BY mois ASC LIMIT 12");
        $stats['chart_revenus'] = $query->getResultArray();

        // Users by gender
        $queryGender = $db->query("SELECT genre, COUNT(*) as count FROM utilisateurs GROUP BY genre");
        $stats['chart_genres'] = $queryGender->getResultArray();

        return $stats;
    }
}