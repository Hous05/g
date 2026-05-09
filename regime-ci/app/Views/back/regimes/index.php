<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Gestion des Regimes</h1>
    <a href="<?= site_url('admin/regimes/create') ?>" class="button">+ Ajouter un regime</a>
</div>

<div style="margin-bottom: 20px;">
    <input type="text" id="searchRegime" placeholder="Rechercher un regime " value="<?= esc($search) ?>" class="panel" style="padding: 10px; width: 100%; max-width: 400px;">
</div>

<table>
    <thead>
        <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
            <th style="padding: 12px; text-align: left;">ID</th>
            <th style="padding: 12px; text-align: left;">Nom</th>
            <th style="padding: 12px; text-align: left;">Objectif</th>
            <th style="padding: 12px; text-align: left;">Duree (j)</th>
            <th style="padding: 12px; text-align: left;">Prix (Ar)</th>
            <th style="padding: 12px; text-align: left;">Poids (kg)</th>
            <th style="padding: 12px; text-align: left;">Composition</th>
            <th style="padding: 12px; text-align: left;">Actions</th>
        </tr>
    </thead>
    <tbody id="regimeTableBody">
        <?php foreach ($regimes as $r): ?>
            <tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 12px;"><?= $r['id'] ?></td>
                <td style="padding: 12px;"><strong><?= esc($r['nom']) ?></strong></td>
                <td style="padding: 12px;"><?= esc($r['objectif_libelle']) ?></td>
                <td style="padding: 12px;"><?= $r['duree_jours'] ?></td>
                <td style="padding: 12px;"><?= number_format((float)$r['prix'], 2, ',', ' ') ?></td>
                <td style="padding: 12px;"><?= ($r['variation_poids_kg'] > 0) ? '+' : '' ?><?= $r['variation_poids_kg'] ?> kg</td>
                <td style="padding: 12px; font-size: 12px;">
                    Viande: <?= $r['viande_pct'] ?>%<br>
                    Poisson: <?= $r['poisson_pct'] ?>%<br>
                    Volaille: <?= $r['volaille_pct'] ?>%
                </td>
                <td style="padding: 12px;" class="actions-cell">
                    <a href="<?= site_url('admin/regimes/edit/' . $r['id']) ?>" class="action-btn edit">Modifier</a>
                    <a href="<?= site_url('admin/regimes/delete/' . $r['id']) ?>" class="action-btn delete" onclick="return confirm('Supprimer ce regime ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
document.getElementById('searchRegime').addEventListener('input', function() {
    let q = this.value;
    
    fetch('<?= site_url('admin/regimes/ajaxList') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
        body: new URLSearchParams({ q: q })
    })
    .then(r => r.json())
    .then(data => {
        let tbody = document.getElementById('regimeTableBody');
        tbody.innerHTML = '';
        data.forEach(r => {
            let row = `<tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 12px;">${r.id}</td>
                <td style="padding: 12px;"><strong>${r.nom}</strong></td>
                <td style="padding: 12px;">${r.objectif_libelle}</td>
                <td style="padding: 12px;">${r.duree_jours}</td>
                <td style="padding: 12px;">${parseFloat(r.prix).toLocaleString('fr-FR')}</td>
                <td style="padding: 12px;">${r.variation_poids_kg > 0 ? '+' : ''}${r.variation_poids_kg} kg</td>
                <td style="padding: 12px; font-size: 12px;">
                    Viande: ${r.viande_pct}%<br>
                    Poisson: ${r.poisson_pct}%<br>
                    Volaille: ${r.volaille_pct}%
                </td>
                <td style="padding: 12px;" class="actions-cell">
                    <a href="<?= site_url('admin/regimes/edit/') ?>${r.id}" class="action-btn edit">Modifier</a>
                    <a href="<?= site_url('admin/regimes/delete/') ?>${r.id}" class="action-btn delete" onclick="return confirm('Supprimer ce regime ?')">Supprimer</a>
                </td>
            </tr>`;
            tbody.innerHTML += row;
        });
    });
});
</script>

<?= $this->endSection() ?>