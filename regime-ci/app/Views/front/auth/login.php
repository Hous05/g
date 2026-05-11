<?php /** @var string|null $emailValue */ ?>
<?php /** @var array $errors */ ?>
<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel narrow">
    <h1>Connexion utilisateur</h1>
    <form method="post" class="form" data-validate>
        <label>Email
            <input type="email" name="email" autocomplete="email" value="<?= esc((string) ($emailValue ?? '')) ?>" required>
            <?php if (!empty($errors['email'])): ?>
                <span class="field-error"><?= esc((string) $errors['email']) ?></span>
            <?php endif; ?>
        </label>
        <label>Mot de passe
            <span class="password-field">
                <input type="password" name="mot_de_passe" autocomplete="current-password" required>
                <button type="button" data-toggle-password>Voir</button>
            </span>
            <?php if (!empty($errors['mot_de_passe'])): ?>
                <span class="field-error"><?= esc((string) $errors['mot_de_passe']) ?></span>
            <?php endif; ?>
        </label>
        <button class="button" type="submit">Se connecter</button>
    </form>
</section>
<?= $this->endSection() ?>