<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel">
    <h1>Détail du programme</h1>
    <?php if (!$program): ?>
        <p>Aucun programme cree pour le moment. Choisissez un objectif puis une suggestion.</p>
        <a class="button" href="<?= site_url('objective') ?>">Voir les suggestions</a>
    <?php else: ?>
        <div class="summary">
            <p><strong>Objectif :</strong> <?= esc($program['objectif']) ?></p>
            <p><strong>Régime :</strong> <?= esc($program['regime_nom']) ?></p>
            <p><?= esc($program['regime_description']) ?></p>
            <p><strong>Activité :</strong> <?= esc($program['activite_nom']) ?>, <?= (int) $program['frequence_semaine'] ?> fois/semaine, <?= (int) $program['duree_minutes'] ?> min</p>
            <p><strong>Duree :</strong> <?= (int) $program['duree_jours'] ?> jours</p>
            <p><strong>Prix :</strong> <?= number_format((float) $program['prix'], 0, ',', ' ') ?> Ar</p>
            <p><strong>Evolution estimée :</strong> <?= esc($program['poids_depart_kg']) ?> kg vers <?= esc($program['poids_estime_kg']) ?> kg</p>
        </div>
        <div class="actions">
            <a class="button" href="<?= site_url('program/export') ?>">Exporter en PDF</a>
        </div>
    <?php endif; ?>
</section>
<?= $this->endSection() ?>