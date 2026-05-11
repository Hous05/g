<?php /** @var array|null $regime */ ?>
<?php /** @var array $objectifs */ ?>
<?php /** @var string|null $title */ ?>
<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
    <h1><?= esc((string) $title) ?></h1>
    
    <form action="" method="post" style="display: flex; flex-direction: column; gap: 15px; margin-top: 20px;">
        
        <div>
            <label style="display:block; margin-bottom:5px; font-weight:bold;">Nom du regime</label>
            <input type="text" name="nom" required value="<?= $regime ? esc((string) $regime['nom']) : '' ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div>
            <label style="display:block; margin-bottom:5px; font-weight:bold;">Objectif cible</label>
            <select name="objectif_id" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                <?php foreach($objectifs as $o): ?>
                    <option value="<?= $o['id'] ?>" <?= ($regime && $regime['objectif_id'] == $o['id']) ? 'selected' : '' ?>>
                        <?= esc((string) $o['libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label style="display:block; margin-bottom:5px; font-weight:bold;">Description</label>
            <textarea name="description" required rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"><?= $regime ? esc((string) $regime['description']) : '' ?></textarea>
        </div>

        <div style="display: flex; gap: 15px;">
            <div style="flex: 1;">
                <label style="display:block; margin-bottom:5px; font-weight:bold;">Duree (jours)</label>
                <input type="number" name="duree_jours" required value="<?= $regime ? esc((string) $regime['duree_jours']) : '' ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                <small style="color: #666;">Impacte le prix variable</small>
            </div>
            <div style="flex: 1;">
                <label style="display:block; margin-bottom:5px; font-weight:bold;">Prix de base (Ar)</label>
                <input type="number" step="0.01" name="prix" required value="<?= $regime ? esc((string) $regime['prix']) : '' ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
        </div>

        <div>
            <label style="display:block; margin-bottom:5px; font-weight:bold;">Variation de poids possible (kg)</label>
            <input type="number" step="0.1" name="variation_poids_kg" required value="<?= $regime ? esc((string) $regime['variation_poids_kg']) : '' ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            <small style="color: #666;">Ex: -2.5 pour une perte, 3 pour un gain</small>
        </div>

        <fieldset style="border: 1px solid #ccc; padding: 15px; border-radius: 4px;">
            <legend style="font-weight: bold; padding: 0 5px;">Composition (%)</legend>
            <div style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label style="display:block; margin-bottom:2px;">Viande</label>
                    <input type="number" step="0.1" name="viande_pct" required value="<?= $regime ? esc((string) $regime['viande_pct']) : '0' ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="flex: 1;">
                    <label style="display:block; margin-bottom:2px;">Poisson</label>
                    <input type="number" step="0.1" name="poisson_pct" required value="<?= $regime ? esc((string) $regime['poisson_pct']) : '0' ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="flex: 1;">
                    <label style="display:block; margin-bottom:2px;">Volaille</label>
                    <input type="number" step="0.1" name="volaille_pct" required value="<?= $regime ? esc((string) $regime['volaille_pct']) : '0' ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>
        </fieldset>

        <div>
            <label style="display:block; margin-bottom:5px; font-weight:bold;">Statut</label>
            <select name="actif" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                <option value="1" <?= ($regime && $regime['actif'] == 1) ? 'selected' : '' ?>>Actif</option>
                <option value="0" <?= ($regime && $regime['actif'] == 0) ? 'selected' : '' ?>>Inactif</option>
            </select>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" style="background: #198754; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Enregistrer</button>
            <a href="<?= site_url('admin/regimes') ?>" style="margin-left: 15px; color: #6c757d; text-decoration: none;">Annuler</a>
        </div>
    </form>
</div>

<script>
// Validation AJAX (Optionnelle, juste pour s'assurer que le total = 100%)
document.querySelector('form').addEventListener('submit', function(e) {
    let v = parseFloat(document.querySelector('[name="viande_pct"]').value);
    let p = parseFloat(document.querySelector('[name="poisson_pct"]').value);
    let vo = parseFloat(document.querySelector('[name="volaille_pct"]').value);
    
    // Check if total is valid (optional depending on rules, assuming max 100%)
    if ((v + p + vo) > 100) {
        e.preventDefault();
        alert('Le total des pourcentages de composition dépasse 100%.');
    }
});
</script>
<?= $this->endSection() ?>