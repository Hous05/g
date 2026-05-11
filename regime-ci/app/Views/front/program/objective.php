<?php /** @var array<int, array<string, mixed>> $objectives */ ?>
<?php /** @var array<string, mixed> $profile */ ?>
<?php /** @var int|null $durationDays */ ?>
<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel">
    <h1>Choix de l objectif</h1>
    <form method="post" class="form" data-suggestion-form data-validate>
        <label>Objectif
            <select name="objectif_id" required>
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
        <label>Duree souhaitee
            <input type="number" name="duree_jours" value="<?= esc((string) ($durationDays ?? old('duree_jours', '30'))) ?>" min="7" max="120" required>
        </label>
        <button class="button" type="submit">Enregistrer l objectif</button>
    </form>
    <div class="suggestions" data-suggestions></div>
</section>
<?= $this->endSection() ?>