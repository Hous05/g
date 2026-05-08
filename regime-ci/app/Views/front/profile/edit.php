<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>
<section class="panel">
    <h1>Profil utilisateur</h1>
    <form method="post" class="form grid" data-imc-form data-validate>
        <label>Nom
            <input name="nom" value="<?= esc($user['nom'] ?? '') ?>" required>
        </label>
        <label>Genre
            <select name="genre" required>
                <?php foreach (['homme' => 'Homme', 'femme' => 'Femme', 'autre' => 'Autre'] as $value => $label): ?>
                    <option value="<?= esc($value) ?>" <?= ($user['genre'] ?? '') === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Date de naissance
            <input type="date" name="date_naissance" value="<?= esc($user['date_naissance'] ?? '') ?>">
        </label>
        <label>Taille en cm
            <input type="number" step="0.01" name="taille_cm" min="80" max="250" value="<?= esc($profile['taille_cm'] ?? '') ?>" required>
        </label>
        <label>Poids en kg
            <input type="number" step="0.01" name="poids_kg" min="25" max="300" value="<?= esc($profile['poids_kg'] ?? '') ?>" required>
        </label>
        <label>Age
            <input type="number" name="age" min="10" max="100" value="<?= esc($profile['age'] ?? '') ?>" required>
        </label>
        <label>Objectif
            <select name="objectif_id">
                <option value="">A définir</option>
                <?php foreach ($objectives as $objective): ?>
                    <option value="<?= (int) $objective['id'] ?>" <?= (int) ($profile['objectif_id'] ?? 0) === (int) $objective['id'] ? 'selected' : '' ?>>
                        <?= esc($objective['libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Poids cible
            <input type="number" step="0.01" name="poids_cible_kg" value="<?= esc($profile['poids_cible_kg'] ?? '') ?>">
        </label>
        <output class="result" data-imc-result>IMC actuel : <?= esc($profile['imc'] ?? 'non calculé') ?></output>
        <button class="button" type="submit">Enregistrer</button>
    </form>
</section>
<?= $this->endSection() ?>
