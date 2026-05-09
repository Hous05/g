<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>
<section class="panel">
    <h1>Tableau de bord</h1>
    
    <div class="stats" style="display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 30px;">
        <article class="stat" style="background:#f4f4f4; padding:20px; border-radius:8px; flex:1; min-width:150px;">
            <span>Utilisateurs</span>
            <h2><?= $stats['utilisateurs'] ?></h2>
        </article>
        <article class="stat" style="background:#f4f4f4; padding:20px; border-radius:8px; flex:1; min-width:150px;">
            <span>Regimes</span>
            <h2><?= $stats['regimes'] ?></h2>
        </article>
        <article class="stat" style="background:#f4f4f4; padding:20px; border-radius:8px; flex:1; min-width:150px;">
            <span>Activites</span>
            <h2><?= $stats['activites'] ?></h2>
        </article>
        <article class="stat" style="background:#f4f4f4; padding:20px; border-radius:8px; flex:1; min-width:150px;">
            <span>Codes Dispo</span>
            <h2><?= $stats['codes_disponibles'] ?></h2>
        </article>
        <article class="stat" style="background:#d4edda; padding:20px; border-radius:8px; flex:1; min-width:150px;">
            <span>Revenus Totaux</span>
            <h2><?= number_format($stats['revenus_totaux'], 2, ',', ' ') ?> Ar</h2>
        </article>
    </div>

    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <div style="flex: 2; min-width: 400px; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
            <h3>Évolution des Revenus</h3>
            <canvas id="revenueChart"></canvas>
        </div>
        <div style="flex: 1; min-width: 300px; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
            <h3>Répartition par Genre</h3>
            <canvas id="genderChart"></canvas>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Revenus
    const revData = <?= json_encode($stats['chart_revenus'] ?? []) ?>;
    const revLabels = revData.map(d => d.mois);
    const revValues = revData.map(d => d.total);

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: revLabels,
            datasets: [{
                label: 'Revenus (Ar)',
                data: revValues,
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.2)',
                fill: true,
                tension: 0.3
            }]
        }
    });

    // Genres
    const genData = <?= json_encode($stats['chart_genres'] ?? []) ?>;
    const genLabels = genData.map(d => d.genre);
    const genValues = genData.map(d => d.count);

    new Chart(document.getElementById('genderChart'), {
        type: 'pie',
        data: {
            labels: genLabels,
            datasets: [{
                data: genValues,
                backgroundColor: ['#0d6efd', '#d63384', '#6c757d']
            }]
        }
    });
});
</script>
<?= $this->endSection() ?>