<?php

namespace App\Models;

use CodeIgniter\Model;
use RuntimeException;

class ProgramModel extends Model
{
    protected $table = 'programmes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'utilisateur_id',
        'regime_id',
        'activite_id',
        'objectif_id',
        'duree_jours',
        'prix',
        'poids_depart_kg',
        'poids_estime_kg',
    ];

    public function suggestions(int $objectiveId, int $durationDays = 30): array
    {
        $db = db_connect();
        $regimes = $db->query(
            'SELECT r.*, o.libelle AS objectif
             FROM regimes r
             JOIN objectifs o ON o.id = r.objectif_id
             WHERE r.objectif_id = ? AND r.actif = 1
             ORDER BY ABS(r.duree_jours - ?), r.prix
             LIMIT 3',
            [$objectiveId, $durationDays]
        )->getResultArray();

        $activites = $db->table('activites_sportives')
            ->where('objectif_id', $objectiveId)
            ->where('actif', 1)
            ->orderBy('frequence_semaine', 'DESC')
            ->limit(3)
            ->get()
            ->getResultArray();

        return ['regimes' => $regimes, 'activites' => $activites];
    }

    public function createProgram(int $userId, int $regimeId, int $activityId): int
    {
        $db = db_connect();
        $profile = (new HealthModel())->findByUser($userId);
        $user = (new UserModel())->find($userId);
        $regime = $db->table('regimes')->where('id', $regimeId)->get()->getRowArray();

        if (!$profile || !$user || !$regime) {
            throw new RuntimeException('Profil ou régime introuvable.');
        }

        $price = (float) $regime['prix'];
        if ((int) $user['est_gold'] === 1) {
            $discountRow = $db->table('parametres')->where('cle', 'remise_gold_pct')->get()->getRowArray();
            $discount = (float) ($discountRow['valeur'] ?? 15);
            $price *= (100 - $discount) / 100;
        }

        $programId = (int) $this->insert([
            'utilisateur_id' => $userId,
            'regime_id' => $regimeId,
            'activite_id' => $activityId,
            'objectif_id' => $regime['objectif_id'],
            'duree_jours' => $regime['duree_jours'],
            'prix' => $price,
            'poids_depart_kg' => $profile['poids_kg'],
            'poids_estime_kg' => (float) $profile['poids_kg'] + (float) $regime['variation_poids_kg'],
        ], true);

        return $programId;
    }

    public function latestForUser(int $userId): ?array
    {
        return db_connect()->query(
            'SELECT p.*, r.nom AS regime_nom, r.description AS regime_description,
                    a.nom AS activite_nom, a.description AS activite_description,
                    a.frequence_semaine, a.duree_minutes, o.libelle AS objectif
             FROM programmes p
             JOIN regimes r ON r.id = p.regime_id
             JOIN activites_sportives a ON a.id = p.activite_id
             JOIN objectifs o ON o.id = p.objectif_id
             WHERE p.utilisateur_id = ?
             ORDER BY p.id DESC
             LIMIT 1',
            [$userId]
        )->getRowArray();
    }
}
