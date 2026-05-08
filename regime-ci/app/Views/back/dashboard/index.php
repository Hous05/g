<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>
<section class="panel">
    <h1>Tableau de bord</h1>
    <div class="stats">
        <?php foreach ($stats as $label => $value): ?>
            <article class="stat">
                <span><?= esc(str_replace('_', ' ', $label)) ?></span>
                <strong><?= (int) $value ?></strong>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
