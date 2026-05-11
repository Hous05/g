<?php /** @var array<string, mixed>|null $program */ ?>
<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel">
    <h1>Détail du programme</h1>
    <?php if (!$program): ?>
        <p>Aucun programme cree pour le moment. Choisissez un objectif puis une suggestion.</p>
        <a class="button" href="<?= site_url('objective') ?>">Voir les suggestions</a>
    <?php else: ?>
        <div class="summary">
            <p><strong>Objectif :</strong> <?= esc((string) ($program['objectif'] ?? '')) ?></p>
            <p><strong>Régime :</strong> <?= esc((string) ($program['regime_nom'] ?? '')) ?></p>
            <p><?= esc((string) ($program['regime_description'] ?? '')) ?></p>
            <p><strong>Activité :</strong> <?= esc((string) ($program['activite_nom'] ?? '')) ?>, <?= (int) ($program['frequence_semaine'] ?? 0) ?> fois/semaine, <?= (int) ($program['duree_minutes'] ?? 0) ?> min</p>
            <p><strong>Duree :</strong> <?= (int) $program['duree_jours'] ?> jours</p>
            <p><strong>Prix :</strong> <?= number_format((float) $program['prix'], 0, ',', ' ') ?> Ar</p>
            <p><strong>Evolution estimée :</strong> <?= esc((string) ($program['poids_depart_kg'] ?? '')) ?> kg vers <?= esc((string) ($program['poids_estime_kg'] ?? '')) ?> kg</p>
        </div>
        <div class="actions">
            <a class="button" href="<?= site_url('program/export') ?>">Exporter en PDF</a>
        </div>
    <?php endif; ?>
</section>
<?= $this->endSection() ?>