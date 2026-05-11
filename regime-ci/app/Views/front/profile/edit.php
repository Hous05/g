<?php /** @var array<string, mixed> $user */ ?>
<?php /** @var array<string, mixed> $profile */ ?>
<?php /** @var array<int, array<string, mixed>> $objectives */ ?>
<?php /** @var array<string, string> $errors */ ?>
<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel">
    <h1>Profil utilisateur</h1>
    <form method="post" class="form grid" data-imc-form data-validate>
        <label>Nom
            <input name="nom" value="<?= esc((string) ($user['nom'] ?? '')) ?>" required>
            <?php if (!empty($errors['nom'])): ?>
                <span class="field-error"><?= esc($errors['nom']) ?></span>
            <?php endif; ?>
        </label>
        <label>Genre
            <select name="genre" required>
                <?php foreach (['homme' => 'Homme', 'femme' => 'Femme', 'autre' => 'Autre'] as $value => $label): ?>
                    <option value="<?= esc((string) $value) ?>" <?= ($user['genre'] ?? '') === $value ? 'selected' : '' ?>><?= esc((string) $label) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['genre'])): ?>
                <span class="field-error"><?= esc($errors['genre']) ?></span>
            <?php endif; ?>
        </label>
        <label>Date de naissance
            <input type="date" name="date_naissance" value="<?= esc((string) ($user['date_naissance'] ?? '')) ?>">
        </label>
        <label>Taille en cm
            <input type="number" step="0.01" name="taille_cm" min="80" max="250" value="<?= esc((string) ($profile['taille_cm'] ?? '')) ?>" required>
            <?php if (!empty($errors['taille_cm'])): ?>
                <span class="field-error"><?= esc($errors['taille_cm']) ?></span>
            <?php endif; ?>
        </label>
        <label>Poids en kg
            <input type="number" step="0.01" name="poids_kg" min="25" max="300" value="<?= esc((string) ($profile['poids_kg'] ?? '')) ?>" required>
            <?php if (!empty($errors['poids_kg'])): ?>
                <span class="field-error"><?= esc($errors['poids_kg']) ?></span>
            <?php endif; ?>
        </label>
        <label>Age
            <input type="number" name="age" min="10" max="100" value="<?= esc((string) ($profile['age'] ?? '')) ?>" required>
            <?php if (!empty($errors['age'])): ?>
                <span class="field-error"><?= esc($errors['age']) ?></span>
            <?php endif; ?>
        </label>
        <label>Objectif
            <select name="objectif_id">
                <option value="">A définir</option>
                <?php foreach ($objectives as $objective): ?>
                    <option value="<?= (int) $objective['id'] ?>" <?= (int) ($profile['objectif_id'] ?? 0) === (int) $objective['id'] ? 'selected' : '' ?>>
                        <?= esc((string) ($objective['libelle'] ?? '')) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Poids cible
            <input type="number" step="0.01" name="poids_cible_kg" value="<?= esc((string) ($profile['poids_cible_kg'] ?? '')) ?>">
        </label>
        <output class="result" data-imc-result>IMC actuel : <?= esc((string) ($profile['imc'] ?? 'non calcule')) ?></output>
        <button class="button" type="submit">Enregistrer</button>
    </form>
</section>
<?= $this->endSection() ?>