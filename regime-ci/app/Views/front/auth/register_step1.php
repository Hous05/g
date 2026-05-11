<?php /** @var array $errors */ ?>
<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel narrow">
    <h1>Inscription</h1>
    <form method="post" class="form" data-validate>
        <label>Nom
            <input name="nom" autocomplete="name" value="<?= esc(old('nom')) ?>" required>
            <?php if (!empty($errors['nom'])): ?>
                <span class="field-error"><?= esc((string) $errors['nom']) ?></span>
            <?php endif; ?>
        </label>
        <label>Email
            <input type="email" name="email" autocomplete="email" value="<?= esc(old('email')) ?>" required>
            <?php if (!empty($errors['email'])): ?>
                <span class="field-error"><?= esc((string) $errors['email']) ?></span>
            <?php endif; ?>
        </label>
        <label>Mot de passe
            <span class="password-field">
                <input type="password" name="mot_de_passe" autocomplete="new-password" minlength="6" required>
                <button type="button" data-toggle-password>Voir</button>
            </span>
            <?php if (!empty($errors['mot_de_passe'])): ?>
                <span class="field-error"><?= esc((string) $errors['mot_de_passe']) ?></span>
            <?php endif; ?>
        </label>
        <label>Genre
            <select name="genre" required>
                <option value="homme">Homme</option>
                <option value="femme">Femme</option>
                <option value="autre">Autre</option>
            </select>
            <?php if (!empty($errors['genre'])): ?>
                <span class="field-error"><?= esc((string) $errors['genre']) ?></span>
            <?php endif; ?>
        </label>
        <label>Date de naissance
            <input type="date" name="date_naissance" value="<?= esc(old('date_naissance')) ?>">
        </label>
        <button class="button" type="submit">Continuer</button>
    </form>
</section>
<?= $this->endSection() ?>