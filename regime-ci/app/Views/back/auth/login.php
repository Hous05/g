<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<!-- Background décoratif pour bien voir l'effet "blur" et les ombres -->
<div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 10% 20%, rgba(19,121,91,0.05) 0%, transparent 40%), radial-gradient(circle at 90% 80%, rgba(255,193,7,0.05) 0%, transparent 40%); z-index: -1; pointer-events: none;"></div>

<section class="panel narrow login-panel" style="position: relative; z-index: 1;">
    <div style="text-align: center; margin-bottom: 20px;">
        <h1 style="color: var(--primary-dark);">Connexion administrateur</h1>
    </div>
    <?php if (!empty($error)): ?><p class="error"><?= esc($error) ?></p><?php endif; ?>
    <form method="post" class="form">
        <label>Email
            <input type="email" name="email" required value="admin@regime.test">
        </label>
        <label>Mot de passe
            <input type="password" name="mot_de_passe" required>
        </label>
        <div style="margin-top: 10px;">
            <button class="button" type="submit" style="width: 100%; font-size: 16px;">Entrer</button>
        </div>
    </form>
</section>
<?= $this->endSection() ?>