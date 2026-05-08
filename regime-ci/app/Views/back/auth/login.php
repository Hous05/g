<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>
<section class="panel narrow">
    <h1>Connexion administrateur</h1>
    <?php if (!empty($error)): ?><p class="error"><?= esc($error) ?></p><?php endif; ?>
    <form method="post" class="form">
        <label>Email
            <input type="email" name="email" required value="admin@regime.test">
        </label>
        <label>Mot de passe
            <input type="password" name="mot_de_passe" required>
        </label>
        <button class="button" type="submit">Entrer</button>
    </form>
</section>
<?= $this->endSection() ?>
