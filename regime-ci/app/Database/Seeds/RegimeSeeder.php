<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RegimeSeeder extends Seeder
{
    public function run(): void
    {
        $password = '$2y$12$fNok4W9F4yaTxMNgIr5YjuOnmtNtIax4SX/y2ACAf419OQvUi2mOm';

        $this->db->table('objectifs')->ignore(true)->insertBatch([
            [
                'id' => 1,
                'code' => 'augmenter',
                'libelle' => 'Augmenter son poids',
                'description' => 'Programme avec apport calorique progressif.',
            ],
            [
                'id' => 2,
                'code' => 'reduire',
                'libelle' => 'Réduire son poids',
                'description' => 'Programme avec déficit calorique contrôlé.',
            ],
            [
                'id' => 3,
                'code' => 'ideal',
                'libelle' => 'Atteindre son IMC idéal',
                'description' => 'Programme équilibré selon la zone IMC normale.',
            ],
        ]);

        $this->db->table('admins')->ignore(true)->insert([
            'nom' => 'Administrateur',
            'email' => 'admin@regime.test',
            'mot_de_passe' => $password,
        ]);

        $this->db->table('utilisateurs')->ignore(true)->insertBatch([
            [
                'id' => 1,
                'nom' => 'Hery Rakoto',
                'email' => 'hery@example.com',
                'mot_de_passe' => $password,
                'genre' => 'homme',
                'date_naissance' => '1998-04-12',
                'est_gold' => 0,
            ],
            [
                'id' => 2,
                'nom' => 'Miora Rabe',
                'email' => 'miora@example.com',
                'mot_de_passe' => $password,
                'genre' => 'femme',
                'date_naissance' => '2001-09-20',
                'est_gold' => 1,
            ],
            [
                'id' => 3,
                'nom' => 'Tiana Andry',
                'email' => 'tiana@example.com',
                'mot_de_passe' => $password,
                'genre' => 'homme',
                'date_naissance' => '1995-01-18',
                'est_gold' => 0,
            ],
            [
                'id' => 4,
                'nom' => 'Noro Fanja',
                'email' => 'noro@example.com',
                'mot_de_passe' => $password,
                'genre' => 'femme',
                'date_naissance' => '1999-07-03',
                'est_gold' => 0,
            ],
            [
                'id' => 5,
                'nom' => 'Lova Kanto',
                'email' => 'lova@example.com',
                'mot_de_passe' => $password,
                'genre' => 'autre',
                'date_naissance' => '1997-11-30',
                'est_gold' => 1,
            ],
        ]);

        $this->db->table('profils_sante')->ignore(true)->insertBatch([
            ['utilisateur_id' => 1, 'taille_cm' => 174, 'poids_kg' => 62, 'age' => 28, 'imc' => 20.48, 'objectif_id' => 1, 'poids_cible_kg' => 68],
            ['utilisateur_id' => 2, 'taille_cm' => 162, 'poids_kg' => 78, 'age' => 24, 'imc' => 29.72, 'objectif_id' => 2, 'poids_cible_kg' => 65],
            ['utilisateur_id' => 3, 'taille_cm' => 181, 'poids_kg' => 85, 'age' => 31, 'imc' => 25.95, 'objectif_id' => 2, 'poids_cible_kg' => 78],
            ['utilisateur_id' => 4, 'taille_cm' => 158, 'poids_kg' => 48, 'age' => 26, 'imc' => 19.23, 'objectif_id' => 1, 'poids_cible_kg' => 53],
            ['utilisateur_id' => 5, 'taille_cm' => 170, 'poids_kg' => 68, 'age' => 29, 'imc' => 23.53, 'objectif_id' => 3, 'poids_cible_kg' => 67],
        ]);

        $this->db->table('regimes')->ignore(true)->insertBatch([
            ['id' => 1, 'objectif_id' => 1, 'nom' => 'Prise de masse équilibrée', 'description' => 'Repas riches en protéines, féculents complets et collations nutritives.', 'duree_jours' => 30, 'prix' => 120000, 'variation_poids_kg' => 2.50, 'viande_pct' => 35, 'poisson_pct' => 25, 'volaille_pct' => 40, 'actif' => 1],
            ['id' => 2, 'objectif_id' => 2, 'nom' => 'Déficit calorique doux', 'description' => 'Menus contrôlés avec légumes, protéines maigres et réduction du sucre.', 'duree_jours' => 30, 'prix' => 100000, 'variation_poids_kg' => -2.00, 'viande_pct' => 25, 'poisson_pct' => 40, 'volaille_pct' => 35, 'actif' => 1],
            ['id' => 3, 'objectif_id' => 3, 'nom' => 'Équilibre IMC', 'description' => 'Programme stable pour revenir progressivement vers un IMC normal.', 'duree_jours' => 30, 'prix' => 110000, 'variation_poids_kg' => -1.00, 'viande_pct' => 30, 'poisson_pct' => 35, 'volaille_pct' => 35, 'actif' => 1],
            ['id' => 4, 'objectif_id' => 2, 'nom' => 'Sèche active', 'description' => 'Régime hypocalorique plus sportif pour perte de poids encadrée.', 'duree_jours' => 45, 'prix' => 150000, 'variation_poids_kg' => -4.00, 'viande_pct' => 20, 'poisson_pct' => 45, 'volaille_pct' => 35, 'actif' => 1],
            ['id' => 5, 'objectif_id' => 1, 'nom' => 'Renforcement nutritionnel', 'description' => 'Augmentation saine des calories avec suivi de poids hebdomadaire.', 'duree_jours' => 45, 'prix' => 155000, 'variation_poids_kg' => 4.00, 'viande_pct' => 40, 'poisson_pct' => 20, 'volaille_pct' => 40, 'actif' => 1],
        ]);

        $this->db->table('activites_sportives')->ignore(true)->insertBatch([
            ['id' => 1, 'objectif_id' => 1, 'nom' => 'Musculation débutant', 'description' => 'Séances full body avec charges progressives.', 'frequence_semaine' => 3, 'duree_minutes' => 45, 'calories_estimees' => 220, 'actif' => 1],
            ['id' => 2, 'objectif_id' => 2, 'nom' => 'Marche rapide', 'description' => 'Cardio doux et régulier adapté à la perte de poids.', 'frequence_semaine' => 5, 'duree_minutes' => 40, 'calories_estimees' => 260, 'actif' => 1],
            ['id' => 3, 'objectif_id' => 3, 'nom' => 'Fitness équilibré', 'description' => 'Mélange cardio et renforcement léger.', 'frequence_semaine' => 4, 'duree_minutes' => 35, 'calories_estimees' => 240, 'actif' => 1],
            ['id' => 4, 'objectif_id' => 2, 'nom' => 'HIIT modéré', 'description' => 'Intervalles courts pour brûler plus de calories.', 'frequence_semaine' => 3, 'duree_minutes' => 25, 'calories_estimees' => 320, 'actif' => 1],
            ['id' => 5, 'objectif_id' => 1, 'nom' => 'Renforcement poids du corps', 'description' => 'Exercices progressifs pour stimuler la masse musculaire.', 'frequence_semaine' => 4, 'duree_minutes' => 30, 'calories_estimees' => 180, 'actif' => 1],
        ]);

        $this->db->table('regime_activite')->ignore(true)->insertBatch([
            ['regime_id' => 1, 'activite_id' => 1],
            ['regime_id' => 1, 'activite_id' => 5],
            ['regime_id' => 2, 'activite_id' => 2],
            ['regime_id' => 2, 'activite_id' => 4],
            ['regime_id' => 3, 'activite_id' => 3],
            ['regime_id' => 4, 'activite_id' => 4],
            ['regime_id' => 5, 'activite_id' => 1],
            ['regime_id' => 5, 'activite_id' => 5],
        ]);

        $this->db->table('codes_recharge')->ignore(true)->insertBatch([
            ['code' => 'REG-1000-A1', 'montant' => 1000],
            ['code' => 'REG-2000-A2', 'montant' => 2000],
            ['code' => 'REG-5000-A3', 'montant' => 5000],
            ['code' => 'REG-10000-A4', 'montant' => 10000],
            ['code' => 'REG-15000-A5', 'montant' => 15000],
            ['code' => 'REG-20000-A6', 'montant' => 20000],
            ['code' => 'REG-25000-A7', 'montant' => 25000],
            ['code' => 'REG-30000-A8', 'montant' => 30000],
            ['code' => 'REG-35000-A9', 'montant' => 35000],
            ['code' => 'REG-40000-B1', 'montant' => 40000],
            ['code' => 'REG-45000-B2', 'montant' => 45000],
            ['code' => 'REG-50000-B3', 'montant' => 50000],
            ['code' => 'REG-75000-B4', 'montant' => 75000],
            ['code' => 'REG-100000-B5', 'montant' => 100000],
            ['code' => 'REG-125000-B6', 'montant' => 125000],
        ]);

        $this->db->table('portefeuilles')->ignore(true)->insertBatch([
            ['utilisateur_id' => 1, 'solde' => 0],
            ['utilisateur_id' => 2, 'solde' => 35000],
            ['utilisateur_id' => 3, 'solde' => 15000],
            ['utilisateur_id' => 4, 'solde' => 0],
            ['utilisateur_id' => 5, 'solde' => 50000],
        ]);

        $this->db->table('parametres')->ignore(true)->insertBatch([
            ['cle' => 'prix_gold', 'valeur' => '50000', 'description' => 'Prix de l option Gold en Ariary'],
            ['cle' => 'remise_gold_pct', 'valeur' => '15', 'description' => 'Remise appliquée aux utilisateurs Gold'],
            ['cle' => 'imc_min_normal', 'valeur' => '18.5', 'description' => 'Seuil bas IMC normal'],
            ['cle' => 'imc_max_normal', 'valeur' => '24.9', 'description' => 'Seuil haut IMC normal'],
        ]);
    }
}
