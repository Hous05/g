<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<div class="panel" style="max-width: 800px; margin: 0 auto;">
    <h1><?= esc($title) ?></h1>
    
    <form action="" method="post" style="display: flex; flex-direction: column; gap: 20px; margin-top: 20px;">
        
        <table>
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="padding: 10px; text-align: left;">Cle</th>
                    <th style="padding: 10px; text-align: left;">Description</th>
                    <th style="padding: 10px; text-align: left;">Valeur</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($params as $p): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 10px; font-family: monospace;"><strong><?= esc($p['cle']) ?></strong></td>
                    <td style="padding: 10px; color: #666; font-size: 14px;"><?= esc($p['description']) ?></td>
                    <td style="padding: 10px;">
                        <input type="text" name="<?= esc($p['cle']) ?>" value="<?= esc($p['valeur']) ?>" required>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="margin-top: 20px; text-align: right;">
            <button type="submit" class="button">Enregistrer les modifications</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
