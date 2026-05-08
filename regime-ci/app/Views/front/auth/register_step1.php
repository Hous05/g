<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel narrow">
    <h1>Inscription</h1>
    <?= view('partials/errors', ['errors' => $errors ?? []]) ?>
    <form method="post" class="form" data-validate>
        <label>Nom
            <input name="nom" value="<?= esc(old('nom')) ?>" required>
        </label>
        <label>Email
            <input type="email" name="email" value="<?= esc(old('email')) ?>" required>
        </label>
        <label>Mot de passe
            <span class="password-field">
                <input type="password" name="mot_de_passe" minlength="6" required>
                <button type="button" data-toggle-password>Voir</button>
            </span>
        </label>
        <label>Genre
            <select name="genre" required>
                <option value="homme">Homme</option>
                <option value="femme">Femme</option>
                <option value="autre">Autre</option>
            </select>
        </label>
        <label>Date de naissance
            <input type="date" name="date_naissance" value="<?= esc(old('date_naissance')) ?>">
        </label>
        <button class="button" type="submit">Continuer</button>
    </form>
</section>
<?= $this->endSection() ?>
