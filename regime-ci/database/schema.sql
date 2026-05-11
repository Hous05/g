CREATE DATABASE IF NOT EXISTS regime_alimentaire
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE regime_alimentaire;

DROP TABLE IF EXISTS programmes;
DROP TABLE IF EXISTS paiements;
DROP TABLE IF EXISTS portefeuilles;
DROP TABLE IF EXISTS codes_recharge;
DROP TABLE IF EXISTS profils_sante;
DROP TABLE IF EXISTS utilisateurs;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS regime_activite;
DROP TABLE IF EXISTS activites_sportives;
DROP TABLE IF EXISTS regimes;
DROP TABLE IF EXISTS objectifs;
DROP TABLE IF EXISTS parametres;

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  mot_de_passe VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE objectifs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(40) NOT NULL UNIQUE,
  libelle VARCHAR(120) NOT NULL,
  description TEXT NULL
) ENGINE=InnoDB;

CREATE TABLE utilisateurs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  mot_de_passe VARCHAR(255) NOT NULL,
  genre ENUM('homme', 'femme', 'autre') NOT NULL,
  date_naissance DATE NULL,
  est_gold TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE profils_sante (
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
) ENGINE=InnoDB;

CREATE TABLE regimes (
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
) ENGINE=InnoDB;

CREATE TABLE activites_sportives (
  id INT AUTO_INCREMENT PRIMARY KEY,
  objectif_id INT NOT NULL,
  nom VARCHAR(140) NOT NULL,
  description TEXT NOT NULL,
  frequence_semaine INT NOT NULL,
  duree_minutes INT NOT NULL,
  calories_estimees INT NOT NULL,
  actif TINYINT(1) NOT NULL DEFAULT 1,
  CONSTRAINT fk_activites_objectif FOREIGN KEY (objectif_id) REFERENCES objectifs(id)
) ENGINE=InnoDB;

CREATE TABLE regime_activite (
  regime_id INT NOT NULL,
  activite_id INT NOT NULL,
  PRIMARY KEY (regime_id, activite_id),
  CONSTRAINT fk_ra_regime FOREIGN KEY (regime_id) REFERENCES regimes(id) ON DELETE CASCADE,
  CONSTRAINT fk_ra_activite FOREIGN KEY (activite_id) REFERENCES activites_sportives(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE codes_recharge (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(40) NOT NULL UNIQUE,
  montant DECIMAL(12,2) NOT NULL,
  statut ENUM('disponible', 'utilise', 'expire') NOT NULL DEFAULT 'disponible',
  utilisateur_id INT NULL,
  used_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_codes_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE portefeuilles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  utilisateur_id INT NOT NULL UNIQUE,
  solde DECIMAL(12,2) NOT NULL DEFAULT 0,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_portefeuilles_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE paiements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  utilisateur_id INT NOT NULL,
  type_paiement ENUM('regime', 'gold', 'recharge') NOT NULL,
  montant DECIMAL(12,2) NOT NULL,
  reference VARCHAR(120) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_paiements_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE programmes (
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
) ENGINE=InnoDB;

CREATE TABLE parametres (
  cle VARCHAR(80) PRIMARY KEY,
  valeur VARCHAR(180) NOT NULL,
  description VARCHAR(255) NULL
) ENGINE=InnoDB;

INSERT INTO objectifs (id, code, libelle, description) VALUES
(1, 'augmenter', 'Augmenter son poids', 'Programme avec apport calorique progressif.'),
(2, 'reduire', 'Réduire son poids', 'Programme avec déficit calorique contrôlé.'),
(3, 'ideal', 'Atteindre son IMC idéal', 'Programme équilibré selon la zone IMC normale.');

INSERT INTO admins (nom, email, mot_de_passe) VALUES
('Administrateur', 'admin@regime.test', '$2y$12$fNok4W9F4yaTxMNgIr5YjuOnmtNtIax4SX/y2ACAf419OQvUi2mOm');

INSERT INTO utilisateurs (id, nom, email, mot_de_passe, genre, date_naissance, est_gold) VALUES
(1, 'Hery Rakoto', 'hery@example.com', '$2y$12$fNok4W9F4yaTxMNgIr5YjuOnmtNtIax4SX/y2ACAf419OQvUi2mOm', 'homme', '1998-04-12', 0),
(2, 'Miora Rabe', 'miora@example.com', '$2y$12$fNok4W9F4yaTxMNgIr5YjuOnmtNtIax4SX/y2ACAf419OQvUi2mOm', 'femme', '2001-09-20', 1),
(3, 'Tiana Andry', 'tiana@example.com', '$2y$12$fNok4W9F4yaTxMNgIr5YjuOnmtNtIax4SX/y2ACAf419OQvUi2mOm', 'homme', '1995-01-18', 0),
(4, 'Noro Fanja', 'noro@example.com', '$2y$12$fNok4W9F4yaTxMNgIr5YjuOnmtNtIax4SX/y2ACAf419OQvUi2mOm', 'femme', '1999-07-03', 0),
(5, 'Lova Kanto', 'lova@example.com', '$2y$12$fNok4W9F4yaTxMNgIr5YjuOnmtNtIax4SX/y2ACAf419OQvUi2mOm', 'autre', '1997-11-30', 1);

INSERT INTO profils_sante (utilisateur_id, taille_cm, poids_kg, age, imc, objectif_id, poids_cible_kg) VALUES
(1, 174, 62, 28, 20.48, 1, 68),
(2, 162, 78, 24, 29.72, 2, 65),
(3, 181, 85, 31, 25.95, 2, 78),
(4, 158, 48, 26, 19.23, 1, 53),
(5, 170, 68, 29, 23.53, 3, 67);

INSERT INTO regimes (id, objectif_id, nom, description, duree_jours, prix, variation_poids_kg, viande_pct, poisson_pct, volaille_pct) VALUES
(1, 1, 'Prise de masse équilibrée', 'Repas riches en protéines, féculents complets et collations nutritives.', 30, 120000, 2.50, 35, 25, 40),
(2, 2, 'Déficit calorique doux', 'Menus contrôlés avec légumes, protéines maigres et réduction du sucre.', 30, 100000, -2.00, 25, 40, 35),
(3, 3, 'Équilibre IMC', 'Programme stable pour revenir progressivement vers un IMC normal.', 30, 110000, -1.00, 30, 35, 35),
(4, 2, 'Sèche active', 'Régime hypocalorique plus sportif pour perte de poids encadrée.', 45, 150000, -4.00, 20, 45, 35),
(5, 1, 'Renforcement nutritionnel', 'Augmentation saine des calories avec suivi de poids hebdomadaire.', 45, 155000, 4.00, 40, 20, 40);

INSERT INTO activites_sportives (id, objectif_id, nom, description, frequence_semaine, duree_minutes, calories_estimees) VALUES
(1, 1, 'Musculation débutant', 'Séances full body avec charges progressives.', 3, 45, 220),
(2, 2, 'Marche rapide', 'Cardio doux et régulier adapté à la perte de poids.', 5, 40, 260),
(3, 3, 'Fitness équilibré', 'Mélange cardio et renforcement léger.', 4, 35, 240),
(4, 2, 'HIIT modéré', 'Intervalles courts pour brûler plus de calories.', 3, 25, 320),
(5, 1, 'Renforcement poids du corps', 'Exercices progressifs pour stimuler la masse musculaire.', 4, 30, 180);

INSERT INTO regime_activite (regime_id, activite_id) VALUES
(1, 1), (1, 5), (2, 2), (2, 4), (3, 3), (4, 4), (5, 1), (5, 5);

INSERT INTO codes_recharge (code, montant) VALUES
('REG-1000-A1', 1000), ('REG-2000-A2', 2000), ('REG-5000-A3', 5000),
('REG-10000-A4', 10000), ('REG-15000-A5', 15000), ('REG-20000-A6', 20000),
('REG-25000-A7', 25000), ('REG-30000-A8', 30000), ('REG-35000-A9', 35000),
('REG-40000-B1', 40000), ('REG-45000-B2', 45000), ('REG-50000-B3', 50000),
('REG-75000-B4', 75000), ('REG-100000-B5', 100000), ('REG-125000-B6', 125000);


INSERT INTO portefeuilles (utilisateur_id, solde) VALUES
(1, 0), (2, 35000), (3, 15000), (4, 0), (5, 50000);

INSERT INTO paiements (utilisateur_id, type_paiement, montant, created_at) VALUES
(1, 'gold', 50000, '2025-11-20'),
(2, 'regime', 120000, '2025-12-05'),
(3, 'recharge', 15000, '2026-01-10'),
(4, 'gold', 50000, '2026-02-15'),
(5, 'regime', 150000, '2026-03-25'),
(1, 'regime', 100000, '2026-04-10'),
(2, 'recharge', 30000, '2026-05-02');

INSERT INTO parametres (cle, valeur, description) VALUES
('prix_gold', '50000', 'Prix de l option Gold en Ariary'),
('remise_gold_pct', '15', 'Remise appliquée aux utilisateurs Gold'),
('imc_min_normal', '18.5', 'Seuil bas IMC normal'),
('imc_max_normal', '24.9', 'Seuil haut IMC normal');
