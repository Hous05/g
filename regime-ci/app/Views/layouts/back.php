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
        <a href="<?= site_url('/') ?>">Front</a>
        <?php if (session('admin_id')): ?>
            <a href="<?= site_url('admin/logout') ?>">Déconnexion</a>
        <?php endif; ?>
    </nav>
</header>
<main class="page">
    <?= $this->renderSection('content') ?>
</main>
</body>
</html>
