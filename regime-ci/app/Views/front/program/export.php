<?php /** @var array<string, mixed> $program */ ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Programme alimentaire</title>
    <style>
        body { font-family: dejavusans, sans-serif; font-size: 12px; color: #172026; }
        h1 { font-size: 20px; margin: 0 0 12px; }
        p { margin: 0 0 8px; }
        .section { margin-top: 12px; padding: 12px; border: 1px solid #d9e2e2; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Programme alimentaire et sportif</h1>

    <div class="section">
        <p><span class="label">Objectif :</span> <?= esc((string) ($program['objectif'] ?? '')) ?></p>
        <p><span class="label">Regime :</span> <?= esc((string) ($program['regime_nom'] ?? '')) ?></p>
        <p><?= esc((string) ($program['regime_description'] ?? '')) ?></p>
    </div>

    <div class="section">
        <p><span class="label">Activite :</span> <?= esc((string) ($program['activite_nom'] ?? '')) ?></p>
        <p><span class="label">Frequence :</span> <?= (int) $program['frequence_semaine'] ?> fois/semaine</p>
        <p><span class="label">Duree :</span> <?= (int) $program['duree_minutes'] ?> min</p>
    </div>

    <div class="section">
        <p><span class="label">Duree totale :</span> <?= (int) $program['duree_jours'] ?> jours</p>
        <p><span class="label">Prix :</span> <?= number_format((float) $program['prix'], 0, ',', ' ') ?> Ar</p>
        <p><span class="label">Evolution estimee :</span> <?= esc((string) ($program['poids_depart_kg'] ?? '')) ?> kg vers <?= esc((string) ($program['poids_estime_kg'] ?? '')) ?> kg</p>
    </div>
</body>
</html>