<?php

namespace App\Models;

use CodeIgniter\Model;

class HealthModel extends Model
{
    protected $table = 'profils_sante';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'utilisateur_id',
        'taille_cm',
        'poids_kg',
        'age',
        'imc',
        'objectif_id',
        'poids_cible_kg',
    ];

    public function findByUser(int $userId): ?array
    {
        return $this->where('utilisateur_id', $userId)->first();
    }

    public function saveProfile(int $userId, array $data): void
    {
        $payload = [
            'utilisateur_id' => $userId,
            'taille_cm' => (float) $data['taille_cm'],
            'poids_kg' => (float) $data['poids_kg'],
            'age' => (int) $data['age'],
            'imc' => self::calculateImc((float) $data['poids_kg'], (float) $data['taille_cm']),
            'objectif_id' => $data['objectif_id'] ?? null,
            'poids_cible_kg' => $data['poids_cible_kg'] ?? null,
        ];

        $existing = $this->findByUser($userId);
        if ($existing) {
            $this->update($existing['id'], $payload);
            return;
        }

        $this->insert($payload);
    }

    public function setObjective(int $userId, int $objectiveId, ?float $targetWeight): void
    {
        $existing = $this->findByUser($userId);
        if (!$existing) {
            return;
        }

        $this->update($existing['id'], [
            'objectif_id' => $objectiveId,
            'poids_cible_kg' => $targetWeight,
        ]);
    }

    public static function calculateImc(float $weightKg, float $heightCm): float
    {
        if ($heightCm <= 0) {
            return 0;
        }

        $heightM = $heightCm / 100;
        return round($weightKg / ($heightM * $heightM), 2);
    }

    public static function imcLabel(float $imc): string
    {
        if ($imc < 18.5) {
            return 'Insuffisance pondérale';
        }
        if ($imc <= 24.9) {
            return 'Corpulence normale';
        }
        if ($imc <= 29.9) {
            return 'Surpoids';
        }
        return 'Obésité';
    }
}
