<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Gestion des Activites Sportives</h1>
    <a href="<?= site_url('admin/activities/create') ?>" class="button">+ Ajouter une activite</a>
</div>

<table>
    <thead>
        <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
            <th style="padding: 12px; text-align: left;">ID</th>
            <th style="padding: 12px; text-align: left;">Nom</th>
            <th style="padding: 12px; text-align: left;">Objectif</th>
            <th style="padding: 12px; text-align: left;">Frequence</th>
            <th style="padding: 12px; text-align: left;">Duree (min)</th>
            <th style="padding: 12px; text-align: left;">Calories (est.)</th>
            <th style="padding: 12px; text-align: left;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($activities as $a): ?>
            <tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 12px;"><?= $a['id'] ?></td>
                <td style="padding: 12px;"><strong><?= esc($a['nom']) ?></strong></td>
                <td style="padding: 12px;"><?= esc($a['objectif_libelle']) ?></td>
                <td style="padding: 12px;"><?= $a['frequence_semaine'] ?>x / sem</td>
                <td style="padding: 12px;"><?= $a['duree_minutes'] ?> min</td>
                <td style="padding: 12px;"><?= $a['calories_estimees'] ?> kcal</td>
                <td style="padding: 12px;" class="actions-cell">
                    <a href="<?= site_url('admin/activities/edit/' . $a['id']) ?>" class="action-btn edit">Modifier</a>
                    <a href="<?= site_url('admin/activities/delete/' . $a['id']) ?>" class="action-btn delete" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>