<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel narrow">
    <h1>Option Gold</h1>
    <div class="summary">
        <p><strong>Statut :</strong> <?= (int) $user['est_gold'] === 1 ? 'Gold actif' : 'Non actif' ?></p>
        <p><strong>Prix :</strong> <?= number_format($prixGold, 0, ',', ' ') ?> Ar</p>
        <p><strong>Remise :</strong> <?= number_format($remiseGold, 0, ',', ' ') ?>% sur les régimes</p>
        <p><strong>Solde :</strong> <?= number_format((float) $wallet['solde'], 0, ',', ' ') ?> Ar</p>
    </div>

    <?php if (!empty($message)): ?><p class="success"><?= esc($message) ?></p><?php endif; ?>
    <?php if (!empty($error)): ?><p class="error"><?= esc($error) ?></p><?php endif; ?>

    <?php if ((int) $user['est_gold'] !== 1): ?>
        <form method="post">
            <button class="button" type="submit">Activer Gold</button>
        </form>
    <?php endif; ?>
</section>
<?= $this->endSection() ?>
