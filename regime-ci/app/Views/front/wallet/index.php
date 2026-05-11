<?php /** @var array $wallet */ ?>
<?php /** @var string|null $message */ ?>
<?php /** @var string|null $error */ ?>
<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel narrow">
    <h1>Porte monnaie</h1>
    <p class="balance">Solde : <strong data-wallet-balance><?= number_format((float) $wallet['solde'], 0, ',', ' ') ?></strong> Ar</p>

    <?php if (!empty($message)): ?><p class="success"><?= esc($message) ?></p><?php endif; ?>
    <?php if (!empty($error)): ?><p class="error"><?= esc($error) ?></p><?php endif; ?>

    <form method="post" class="form" data-recharge-form data-validate>
        <label>Code de recharge
            <input name="code" placeholder="REG-50000-B3" required>
        </label>
        <output class="result" data-recharge-result>Entrez un code disponible.</output>
        <button class="button" type="submit">Recharger</button>
    </form>
</section>
<?= $this->endSection() ?>