<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel narrow">
    <h1>Connexion utilisateur</h1>
    <?php if (!empty($error)): ?><p class="error"><?= esc($error) ?></p><?php endif; ?>
    <form method="post" class="form" data-validate>
        <label>Email
            <input type="email" name="email" required>
        </label>
        <label>Mot de passe
            <span class="password-field">
                <input type="password" name="mot_de_passe" required>
                <button type="button" data-toggle-password>Voir</button>
            </span>
        </label>
        <button class="button" type="submit">Se connecter</button>
    </form>
</section>
<?= $this->endSection() ?>
