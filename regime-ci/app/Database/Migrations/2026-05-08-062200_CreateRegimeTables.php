<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRegimeTables extends Migration
{
    public function up(): void
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS admins (
              id INT AUTO_INCREMENT PRIMARY KEY,
              nom VARCHAR(100) NOT NULL,
              email VARCHAR(160) NOT NULL UNIQUE,
              mot_de_passe VARCHAR(255) NOT NULL,
              created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS objectifs (
              id INT AUTO_INCREMENT PRIMARY KEY,
              code VARCHAR(40) NOT NULL UNIQUE,
              libelle VARCHAR(120) NOT NULL,
              description TEXT NULL
            ) ENGINE=InnoDB
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS utilisateurs (
              id INT AUTO_INCREMENT PRIMARY KEY,
              nom VARCHAR(120) NOT NULL,
              email VARCHAR(160) NOT NULL UNIQUE,
              mot_de_passe VARCHAR(255) NOT NULL,
              genre ENUM('homme', 'femme', 'autre') NOT NULL,
              date_naissance DATE NULL,
              est_gold TINYINT(1) NOT NULL DEFAULT 0,
              created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS profils_sante (
              id INT AUTO_INCREMENT PRIMARY KEY,
              utilisateur_id INT NOT NULL UNIQUE,
              taille_cm DECIMAL(5,2) NOT NULL,
              poids_kg DECIMAL(5,2) NOT NULL,
              age INT NOT NULL,
              imc DECIMAL(5,2) NOT NULL,
              objectif_id INT NULL,
              poids_cible_kg DECIMAL(5,2) NULL,
              updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              CONSTRAINT fk_profils_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
              CONSTRAINT fk_profils_objectif FOREIGN KEY (objectif_id) REFERENCES objectifs(id) ON DELETE SET NULL
            ) ENGINE=InnoDB
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS regimes (
              id INT AUTO_INCREMENT PRIMARY KEY,
              objectif_id INT NOT NULL,
              nom VARCHAR(140) NOT NULL,
              description TEXT NOT NULL,
              duree_jours INT NOT NULL,
              prix DECIMAL(12,2) NOT NULL,
              variation_poids_kg DECIMAL(5,2) NOT NULL,
              viande_pct DECIMAL(5,2) NOT NULL DEFAULT 0,
              poisson_pct DECIMAL(5,2) NOT NULL DEFAULT 0,
              volaille_pct DECIMAL(5,2) NOT NULL DEFAULT 0,
              actif TINYINT(1) NOT NULL DEFAULT 1,
              CONSTRAINT fk_regimes_objectif FOREIGN KEY (objectif_id) REFERENCES objectifs(id)
            ) ENGINE=InnoDB
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS activites_sportives (
              id INT AUTO_INCREMENT PRIMARY KEY,
              objectif_id INT NOT NULL,
              nom VARCHAR(140) NOT NULL,
              description TEXT NOT NULL,
              frequence_semaine INT NOT NULL,
              duree_minutes INT NOT NULL,
              calories_estimees INT NOT NULL,
              actif TINYINT(1) NOT NULL DEFAULT 1,
              CONSTRAINT fk_activites_objectif FOREIGN KEY (objectif_id) REFERENCES objectifs(id)
            ) ENGINE=InnoDB
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS regime_activite (
              regime_id INT NOT NULL,
              activite_id INT NOT NULL,
              PRIMARY KEY (regime_id, activite_id),
              CONSTRAINT fk_ra_regime FOREIGN KEY (regime_id) REFERENCES regimes(id) ON DELETE CASCADE,
              CONSTRAINT fk_ra_activite FOREIGN KEY (activite_id) REFERENCES activites_sportives(id) ON DELETE CASCADE
            ) ENGINE=InnoDB
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS codes_recharge (
              id INT AUTO_INCREMENT PRIMARY KEY,
              code VARCHAR(40) NOT NULL UNIQUE,
              montant DECIMAL(12,2) NOT NULL,
              statut ENUM('disponible', 'utilise', 'expire') NOT NULL DEFAULT 'disponible',
              utilisateur_id INT NULL,
              used_at DATETIME NULL,
              created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
              CONSTRAINT fk_codes_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET NULL
            ) ENGINE=InnoDB
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS portefeuilles (
              id INT AUTO_INCREMENT PRIMARY KEY,
              utilisateur_id INT NOT NULL UNIQUE,
              solde DECIMAL(12,2) NOT NULL DEFAULT 0,
              updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              CONSTRAINT fk_portefeuilles_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
            ) ENGINE=InnoDB
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS paiements (
              id INT AUTO_INCREMENT PRIMARY KEY,
              utilisateur_id INT NOT NULL,
              type_paiement ENUM('regime', 'gold', 'recharge') NOT NULL,
              montant DECIMAL(12,2) NOT NULL,
              reference VARCHAR(120) NULL,
              created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
              CONSTRAINT fk_paiements_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
            ) ENGINE=InnoDB
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS programmes (
              id INT AUTO_INCREMENT PRIMARY KEY,
              utilisateur_id INT NOT NULL,
              regime_id INT NOT NULL,
              activite_id INT NOT NULL,
              objectif_id INT NOT NULL,
              duree_jours INT NOT NULL,
              prix DECIMAL(12,2) NOT NULL,
              poids_depart_kg DECIMAL(5,2) NOT NULL,
              poids_estime_kg DECIMAL(5,2) NOT NULL,
              created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
              CONSTRAINT fk_programmes_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
              CONSTRAINT fk_programmes_regime FOREIGN KEY (regime_id) REFERENCES regimes(id),
              CONSTRAINT fk_programmes_activite FOREIGN KEY (activite_id) REFERENCES activites_sportives(id),
              CONSTRAINT fk_programmes_objectif FOREIGN KEY (objectif_id) REFERENCES objectifs(id)
            ) ENGINE=InnoDB
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS parametres (
              cle VARCHAR(80) PRIMARY KEY,
              valeur VARCHAR(180) NOT NULL,
              description VARCHAR(255) NULL
            ) ENGINE=InnoDB
        ");
    }

    public function down(): void
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        foreach ([
            'programmes',
            'paiements',
            'portefeuilles',
            'codes_recharge',
            'profils_sante',
            'regime_activite',
            'activites_sportives',
            'regimes',
            'utilisateurs',
            'admins',
            'objectifs',
            'parametres',
        ] as $table) {
            $this->db->query("DROP TABLE IF EXISTS {$table}");
        }
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }
}
