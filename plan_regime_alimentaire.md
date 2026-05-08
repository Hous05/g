# Projet : Application de sélection de régime alimentaire

## Thème

Mise en place d'une application permettant de sélectionner un régime alimentaire adapté selon les objectifs de l'utilisateur.

L'utilisateur renseigne ses informations personnelles et de santé, notamment le genre, la taille et le poids. Le système calcule et affiche son indice de masse corporelle (IMC), puis propose des régimes alimentaires et des activités sportives adaptées à ses objectifs.

## Technologies

- PHP avec le framework CodeIgniter
- HTML / CSS
- JavaScript et AJAX
- Base de données MySQL ou PostgreSQL
- Export PDF

## Données minimales

- 5 utilisateurs
- 15 codes de recharge pour le porte-monnaie
- 5 régimes
- 5 activités sportives

## Fonctionnalités Front Office

- Inscription et connexion des utilisateurs
- Inscription séparée en 2 pages :
  - Informations personnelles : nom, email, genre, etc.
  - Informations de santé : taille, poids, etc.
- Complétion du profil utilisateur
- Calcul et affichage de l'IMC
- Choix d'un objectif parmi :
  - Augmenter son poids
  - Réduire son poids
  - Atteindre son IMC idéal
- Suggestion de régimes et d'activités sportives selon l'objectif et la durée
- Export du programme en PDF
- Ajout d'argent dans le porte-monnaie via un code
- Option Gold payée en une seule fois
- Remise de 15% sur tous les régimes pour les utilisateurs Gold

## Amélioration UX des formulaires web

- Affichage de messages d'erreur clairs pour les champs invalides
- Style CSS visible pour le champ actif
- Affichage et masquage du mot de passe
- Validation JavaScript côté client
- Version mobile CSS des formulaires
- Tests utilisateurs pour vérifier la compréhension et la facilité d'utilisation

## Proposition pour l'option Gold

- Prix proposé : 50 000 Ar
- Paiement : débit du porte-monnaie utilisateur
- Accès : valable à vie après activation
- Avantage : 15% de remise automatique sur tous les régimes

## Fonctionnalités Back Office

- Page d'authentification administrateur au démarrage
- Tableau de bord avec statistiques
- Graphes et tableaux croisés
- CRUD des régimes
- Gestion des prix des régimes selon la durée
- Gestion de la variation de poids possible pour chaque régime
- Gestion de la composition des régimes :
  - Pourcentage de viande
  - Pourcentage de poisson
  - Pourcentage de volaille
- CRUD des activités sportives
- Validation des codes de recharge du porte-monnaie
- CRUD des paramètres nécessaires

## Organisation des tâches

| Ligne | Catégorie | Module | Nom page | Description | Type | Estimation | Temps passé | Reste à faire | Avancement | Qui | Status |
|---:|---|---|---|---|---|---:|---:|---:|---:|---|---|
| 1 | Analyse | Cadrage projet | Documentation | Rédiger le thème, les objectifs, les fonctionnalités et les données minimales du projet. | Documentation | 2h | 0h | 2h | 0% | A définir | A faire |
| 2 | Base de données | Modélisation | MCD / SQL | Concevoir les tables utilisateurs, profils santé, objectifs, régimes, activités, codes, porte-monnaie, paiements et option Gold. | Conception | 6h | 0h | 6h | 0% | A définir | A faire |
| 3 | Base de données | Initialisation | Script SQL | Créer les scripts de création de tables et insérer les données minimales : 5 utilisateurs, 15 codes, 5 régimes, 5 activités. | Développement | 5h | 0h | 5h | 0% | A définir | A faire |
| 4 | Back Office | Authentification admin | Login admin | Créer la page de connexion administrateur et sécuriser l'accès au back office. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 5 | Front Office | Authentification utilisateur | Inscription étape 1 | Créer la première page d'inscription pour les informations personnelles : nom, email, mot de passe, genre, etc. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 6 | Front Office | Authentification utilisateur | Inscription étape 2 | Créer la deuxième page d'inscription pour les informations de santé : taille, poids, âge et données utiles au calcul IMC. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 7 | Front Office | Authentification utilisateur | Login utilisateur | Créer la page de connexion utilisateur avec gestion de session. | Développement | 3h | 0h | 3h | 0% | A définir | A faire |
| 8 | Front Office | Profil utilisateur | Profil | Permettre à l'utilisateur de compléter et modifier ses informations personnelles et de santé. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 9 | Front Office | Santé | IMC | Calculer et afficher l'indice de masse corporelle à partir du poids et de la taille. | Développement | 3h | 0h | 3h | 0% | A définir | A faire |
| 10 | Front Office | Objectifs | Choix objectif | Permettre à l'utilisateur de choisir un objectif : augmenter le poids, réduire le poids ou atteindre l'IMC idéal. | Développement | 3h | 0h | 3h | 0% | A définir | A faire |
| 11 | Front Office | Recommandation | Suggestions | Suggérer les régimes et activités sportives nécessaires selon l'objectif, l'IMC et la durée. | Développement | 7h | 0h | 7h | 0% | A définir | A faire |
| 12 | Front Office | Programme | Détail programme | Afficher le régime conseillé, l'activité sportive, la durée, le prix et l'évolution estimée du poids. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 13 | Front Office | Export | Export PDF | Générer un PDF contenant le programme alimentaire et sportif proposé à l'utilisateur. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 14 | Front Office | Porte-monnaie | Recharge | Permettre à l'utilisateur de rajouter de l'argent dans son porte-monnaie en entrant un code valide. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 15 | Front Office | Gold | Activation Gold | Permettre à l'utilisateur d'acheter l'option Gold en une seule fois via son porte-monnaie. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 16 | Front Office | Gold | Remise Gold | Appliquer automatiquement 15% de remise sur tous les régimes pour les utilisateurs Gold. | Développement | 3h | 0h | 3h | 0% | A définir | A faire |
| 17 | Back Office | Tableau de bord | Dashboard | Créer un tableau de bord avec statistiques, graphes et tableaux croisés. | Développement | 7h | 0h | 7h | 0% | A définir | A faire |
| 18 | Back Office | Régimes | Liste régimes | Afficher la liste des régimes avec recherche, détails, prix et durée. | Développement | 3h | 0h | 3h | 0% | A définir | A faire |
| 19 | Back Office | Régimes | Formulaire régime | Créer, modifier et supprimer les régimes. | Développement | 5h | 0h | 5h | 0% | A définir | A faire |
| 20 | Back Office | Régimes | Prix par durée | Gérer les prix variables des régimes selon la durée. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 21 | Back Office | Régimes | Variation poids | Définir la variation de poids possible pour chaque régime sur une durée donnée. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 22 | Back Office | Régimes | Composition régime | Définir les pourcentages de viande, poisson et volaille pour chaque régime. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 23 | Back Office | Activités sportives | Liste activités | Afficher la liste des activités sportives avec recherche et détails. | Développement | 3h | 0h | 3h | 0% | A définir | A faire |
| 24 | Back Office | Activités sportives | Formulaire activité | Créer, modifier et supprimer les activités sportives. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 25 | Back Office | Codes | Validation codes | Valider les codes de recharge du porte-monnaie et suivre leur statut. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 26 | Back Office | Codes | CRUD codes | Créer, modifier, supprimer et consulter les codes de recharge. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 27 | Back Office | Paramètres | CRUD paramètres | Gérer les paramètres nécessaires : prix Gold, seuils IMC, remises, durées, valeurs par défaut. | Développement | 5h | 0h | 5h | 0% | A définir | A faire |
| 28 | Front Office | AJAX | Interactions dynamiques | Utiliser AJAX pour les validations, suggestions, recharges de code et mises à jour sans rechargement complet. | Développement | 5h | 0h | 5h | 0% | A définir | A faire |
| 29 | UI / UX | Interface | Layout général | Créer les interfaces HTML/CSS du front office et du back office. | Intégration | 7h | 0h | 7h | 0% | A définir | A faire |
| 30 | Tests | Validation | Tests fonctionnels | Tester les parcours : inscription, login, IMC, objectif, suggestion, PDF, recharge, Gold et CRUD back office. | Test | 6h | 0h | 6h | 0% | A définir | A faire |
| 31 | Livraison | Finalisation | Rapport / Démo | Préparer la démonstration, vérifier les données minimales et finaliser la documentation. | Livraison | 3h | 0h | 3h | 0% | A définir | A faire |
| 32 | UI / UX | Formulaires | Messages d'erreur | Afficher des messages d'erreur compréhensibles sous les champs invalides ou obligatoires. | Intégration | 2h | 0h | 2h | 0% | A définir | A faire |
| 33 | UI / UX | Formulaires | Champ actif | Ajouter un style CSS visible sur le champ actif pour améliorer la navigation au clavier et la lisibilité. | Intégration | 2h | 0h | 2h | 0% | A définir | A faire |
| 34 | UI / UX | Formulaires | Mot de passe | Ajouter une option pour afficher ou masquer le mot de passe dans les formulaires de login et d'inscription. | Développement | 2h | 0h | 2h | 0% | A définir | A faire |
| 35 | Front Office | Formulaires | Validation JS | Ajouter une validation JavaScript côté client pour les champs email, mot de passe, taille, poids et champs obligatoires. | Développement | 4h | 0h | 4h | 0% | A définir | A faire |
| 36 | UI / UX | Responsive | Version mobile CSS | Adapter les formulaires à l'affichage mobile avec des champs lisibles, boutons accessibles et espacements corrects. | Intégration | 4h | 0h | 4h | 0% | A définir | A faire |
| 37 | Tests | UX | Tests utilisateurs | Réaliser des tests utilisateurs sur les formulaires pour repérer les blocages et améliorer l'expérience. | Test | 3h | 0h | 3h | 0% | A définir | A faire |
| 38 | Documentation | Référence UX | tp_formulaire_ux.md | Documenter les améliorations UX ajoutées depuis le TP formulaire UX du 2026-05-04. | Documentation | 1h | 0h | 1h | 0% | A définir | A faire |

## Total estimé

150h
