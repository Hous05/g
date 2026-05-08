<?php $title = $title ?? 'Regime Alimentaire'; ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?> - Regime Alimentaire</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
<header class="topbar">
    <a class="brand" href="<?= site_url('/') ?>">Regime Alimentaire</a>
    <nav>
        <?php if (session('user_id')): ?>
            <a href="<?= site_url('profile') ?>">Profil</a>
            <a href="<?= site_url('objective') ?>">Objectif</a>
            <a href="<?= site_url('program') ?>">Programme</a>
            <a href="<?= site_url('wallet') ?>">Porte-monnaie</a>
            <a href="<?= site_url('gold') ?>">Gold</a>
            <a href="<?= site_url('logout') ?>">Déconnexion</a>
        <?php else: ?>
            <a href="<?= site_url('register') ?>">Inscription</a>
            <a href="<?= site_url('login') ?>">Connexion</a>
        <?php endif; ?>
        <a href="<?= site_url('admin/login') ?>">Admin</a>
    </nav>
</header>
<main class="page">
    <?= $this->renderSection('content') ?>
</main>
<script>
    window.APP_BASE_URL = '<?= rtrim(site_url(), '/') ?>/';
</script>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
