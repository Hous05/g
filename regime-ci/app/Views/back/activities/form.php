<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
    <h1><?= esc($title) ?></h1>
    
    <form action="" method="post" style="display: flex; flex-direction: column; gap: 15px; margin-top: 20px;">
        
        <div>
            <label style="display:block; margin-bottom:5px; font-weight:bold;">Nom de l'activite</label>
            <input type="text" name="nom" required value="<?= $activity ? esc($activity['nom']) : '' ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div>
            <label style="display:block; margin-bottom:5px; font-weight:bold;">Objectif cible</label>
            <select name="objectif_id" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                <?php foreach($objectifs as $o): ?>
                    <option value="<?= $o['id'] ?>" <?= ($activity && $activity['objectif_id'] == $o['id']) ? 'selected' : '' ?>>
                        <?= esc($o['libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label style="display:block; margin-bottom:5px; font-weight:bold;">Description</label>
            <textarea name="description" required rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"><?= $activity ? esc($activity['description']) : '' ?></textarea>
        </div>

        <div style="display: flex; gap: 15px;">
            <div style="flex: 1;">
                <label style="display:block; margin-bottom:5px; font-weight:bold;">Frequence (/semaine)</label>
                <input type="number" name="frequence_semaine" required value="<?= $activity ? esc($activity['frequence_semaine']) : '' ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div style="flex: 1;">
                <label style="display:block; margin-bottom:5px; font-weight:bold;">Duree par seance (min)</label>
                <input type="number" name="duree_minutes" required value="<?= $activity ? esc($activity['duree_minutes']) : '' ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div style="flex: 1;">
                <label style="display:block; margin-bottom:5px; font-weight:bold;">Calories (est.)</label>
                <input type="number" name="calories_estimees" required value="<?= $activity ? esc($activity['calories_estimees']) : '' ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" style="background: #198754; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Enregistrer</button>
            <a href="<?= site_url('admin/activities') ?>" style="margin-left: 15px; color: #6c757d; text-decoration: none;">Annuler</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>