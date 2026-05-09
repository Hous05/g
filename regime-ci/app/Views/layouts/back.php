<?php $title = $title ?? 'Back Office'; ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?> - Back Office</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
<header class="topbar admin">
    <a class="brand" href="<?= site_url('admin/dashboard') ?>">Back Office</a>
    <nav>
        <?php if (session('admin_id')): ?>
            <a href="<?= site_url('admin/dashboard') ?>">Tableau de Bord</a>
            <a href="<?= site_url('admin/regimes') ?>">Regimes</a>
            <a href="<?= site_url('admin/activities') ?>">Activites</a>
            <a href="<?= site_url('admin/codes') ?>">Codes</a>
            <a href="<?= site_url('admin/parameters') ?>">Parametres</a>
            <a href="<?= site_url('admin/logout') ?>" class="btn-logout">Deconnexion</a>
        <?php endif; ?>
        <a href="<?= site_url('/') ?>" class="btn-outline" style="margin-left: 15px;">Front</a>
    </nav>
</header>
<main class="page" style="padding: 20px;">
    <?php if (session('message')): ?>
        <div class="success" style="margin-bottom: 20px;">
            <?= esc(session('message')) ?>
        </div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="error" style="margin-bottom: 20px; color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: 15px; border-radius: 4px;">
            <?= esc(session('error')) ?>
        </div>
    <?php endif; ?>
    <?= $this->renderSection('content') ?>
</main>
</body>
</html>