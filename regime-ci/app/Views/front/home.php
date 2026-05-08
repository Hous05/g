<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel intro">
    <h1>Application de sélection de régime alimentaire</h1>
    <p>Renseignez votre profil, calculez votre IMC et obtenez un programme alimentaire et sportif adapté à votre objectif.</p>
    <div class="actions">
        <a class="button" href="<?= site_url('register') ?>">Créer un compte</a>
        <a class="button secondary" href="<?= site_url('login') ?>">Se connecter</a>
    </div>
</section>
<?= $this->endSection() ?>
