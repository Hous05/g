<?php /** @var array<int, array<string, mixed>> $activities */ ?>
<?php /** @var string|null $search */ ?>
<?php /** @var string|null $statut */ ?>
<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Gestion des Activites Sportives</h1>
    <a href="<?= site_url('admin/activities/create') ?>" class="button">+ Ajouter une activite</a>
</div>

<?php if (session()->getFlashdata('message')): ?>
    <p class="success"><?= esc((string) session()->getFlashdata('message')) ?></p>
<?php endif; ?>

<form method="get" style="display: flex; gap: 10px; align-items: center; margin-bottom: 16px; flex-wrap: wrap;">
    <input type="text" name="q" placeholder="Rechercher une activite" value="<?= esc($search ?? '') ?>" style="width: 220px;">
    <select name="statut" style="width: 180px;">
        <option value="">Tous les statuts</option>
        <option value="1" <?= ($statut ?? '') === '1' ? 'selected' : '' ?>>Actif</option>
        <option value="0" <?= ($statut ?? '') === '0' ? 'selected' : '' ?>>Inactif</option>
    </select>
    <button type="submit" class="button">Filtrer</button>
    <a href="<?= site_url('admin/activities') ?>" class="button secondary">Reinitialiser</a>
</form>

<table>
    <thead>
        <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
            <th style="padding: 12px; text-align: left;">ID</th>
            <th style="padding: 12px; text-align: left;">Nom</th>
            <th style="padding: 12px; text-align: left;">Objectif</th>
            <th style="padding: 12px; text-align: left;">Frequence</th>
            <th style="padding: 12px; text-align: left;">Duree (min)</th>
            <th style="padding: 12px; text-align: left;">Calories (est.)</th>
            <th style="padding: 12px; text-align: left;">Statut</th>
            <th style="padding: 12px; text-align: left;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($activities as $a): ?>
            <tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 12px;"><?= $a['id'] ?></td>
                <td style="padding: 12px;"><strong><?= esc((string) $a['nom']) ?></strong></td>
                <td style="padding: 12px;"><?= esc((string) $a['objectif_libelle']) ?></td>
                <td style="padding: 12px;"><?= $a['frequence_semaine'] ?>x / sem</td>
                <td style="padding: 12px;"><?= $a['duree_minutes'] ?> min</td>
                <td style="padding: 12px;"><?= $a['calories_estimees'] ?> kcal</td>
                <td style="padding: 12px;">
                    <?php if ((int) $a['actif'] === 1): ?>
                        <span style="background:#d4edda; color:#155724; padding:3px 8px; border-radius:4px; font-size:12px;">Actif</span>
                    <?php else: ?>
                        <span style="background:#f8d7da; color:#721c24; padding:3px 8px; border-radius:4px; font-size:12px;">Inactif</span>
                    <?php endif; ?>
                </td>
                <td style="padding: 12px;" class="actions-cell">
                    <a href="<?= site_url('admin/activities/edit/' . $a['id']) ?>" class="action-btn edit">Modifier</a>
                    <a href="<?= site_url('admin/activities/delete/' . $a['id']) ?>" class="action-btn delete" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>