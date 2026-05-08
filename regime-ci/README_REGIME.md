# Application Regime Alimentaire - CodeIgniter 4

Projet CodeIgniter 4 créé avec Composer dans `regime-ci`.

## Portée réalisée

Lignes 1 à 12 du planning :

- documentation/cadrage ;
- base SQL : utilisateurs, profils santé, objectifs, régimes, activités, codes, portefeuille, paiements, option Gold ;
- script SQL avec données minimales ;
- login administrateur ;
- inscription utilisateur en 2 étapes ;
- login utilisateur ;
- profil utilisateur ;
- calcul IMC ;
- choix objectif ;
- recommandations via JavaScript/AJAX ;
- détail programme.

## Installation base

```bash
mysql -u root < database/schema.sql
```

La configuration est dans `.env`.

## Démarrage

```bash
php spark serve
```

Puis ouvrir l'URL affichée par CodeIgniter.

## Comptes de test

Mot de passe commun : `password`

- Admin : `admin@regime.test`
- Utilisateurs : `hery@example.com`, `miora@example.com`, `tiana@example.com`, `noro@example.com`, `lova@example.com`

## Données minimales

- 5 utilisateurs ;
- 15 codes de recharge ;
- 5 régimes ;
- 5 activités sportives.
