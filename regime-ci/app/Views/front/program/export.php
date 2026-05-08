<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Programme alimentaire</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="print-page">
<main class="page">
    <section class="panel">
        <h1>Programme alimentaire et sportif</h1>
        <div class="summary">
            <p><strong>Objectif :</strong> <?= esc($program['objectif']) ?></p>
            <p><strong>Régime :</strong> <?= esc($program['regime_nom']) ?></p>
            <p><?= esc($program['regime_description']) ?></p>
            <p><strong>Activité :</strong> <?= esc($program['activite_nom']) ?>, <?= (int) $program['frequence_semaine'] ?> fois/semaine, <?= (int) $program['duree_minutes'] ?> min</p>
            <p><strong>Durée :</strong> <?= (int) $program['duree_jours'] ?> jours</p>
            <p><strong>Prix :</strong> <?= number_format((float) $program['prix'], 0, ',', ' ') ?> Ar</p>
            <p><strong>Evolution estimée :</strong> <?= esc($program['poids_depart_kg']) ?> kg vers <?= esc($program['poids_estime_kg']) ?> kg</p>
        </div>
        <button class="button no-print" onclick="window.print()">Exporter en PDF</button>
    </section>
</main>
</body>
</html>
