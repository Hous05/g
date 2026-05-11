<?php /** @var array $errors */ ?>
<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel narrow">
    <h1>Informations de santé</h1>
    <form method="post" class="form" data-imc-form data-validate>
        <label>Taille en cm
            <input type="number" step="0.01" name="taille_cm" min="80" max="250" required>
            <?php if (!empty($errors['taille_cm'])): ?>
                <span class="field-error"><?= esc((string) $errors['taille_cm']) ?></span>
            <?php endif; ?>
        </label>
        <label>Poids en kg
            <input type="number" step="0.01" name="poids_kg" min="25" max="300" required>
            <?php if (!empty($errors['poids_kg'])): ?>
                <span class="field-error"><?= esc((string) $errors['poids_kg']) ?></span>
            <?php endif; ?>
        </label>
        <label>Age
            <input type="number" name="age" min="10" max="100" required>
            <?php if (!empty($errors['age'])): ?>
                <span class="field-error"><?= esc((string) $errors['age']) ?></span>
            <?php endif; ?>
        </label>
        <output class="result" data-imc-result>IMC calculé automatiquement</output>
        <button class="button" type="submit">Choisir mon objectif</button>
    </form>
</section>
<?= $this->endSection() ?>