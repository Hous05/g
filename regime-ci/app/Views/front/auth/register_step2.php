<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel narrow">
    <h1>Informations de santé</h1>
    <?= view('partials/errors', ['errors' => $errors ?? []]) ?>
    <form method="post" class="form" data-imc-form data-validate>
        <label>Taille en cm
            <input type="number" step="0.01" name="taille_cm" min="80" max="250" required>
        </label>
        <label>Poids en kg
            <input type="number" step="0.01" name="poids_kg" min="25" max="300" required>
        </label>
        <label>Age
            <input type="number" name="age" min="10" max="100" required>
        </label>
        <output class="result" data-imc-result>IMC calculé automatiquement</output>
        <button class="button" type="submit">Choisir mon objectif</button>
    </form>
</section>
<?= $this->endSection() ?>
