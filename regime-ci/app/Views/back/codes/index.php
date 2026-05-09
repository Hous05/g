<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
    <h1>Gestion des Codes de Recharge</h1>
    
    <div style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h3 style="margin-top: 0;">Generer des codes</h3>
        <form action="<?= site_url('admin/codes/generate') ?>" method="post" style="display: flex; gap: 10px; align-items: center;">
            <input type="number" name="montant" placeholder="Montant (Ar)" required style="width: 120px;">
            <input type="number" name="quantite" placeholder="QtÃƒÂ©" required value="1" min="1" max="50" style="width: 80px;">
            <button type="submit" class="button">Generer</button>
        </form>
    </div>
</div>

<table>
    <thead>
        <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
            <th style="padding: 12px; text-align: left;">ID</th>
            <th style="padding: 12px; text-align: left;">Code</th>
            <th style="padding: 12px; text-align: left;">Montant (Ar)</th>
            <th style="padding: 12px; text-align: left;">Statut</th>
            <th style="padding: 12px; text-align: left;">Utilisé le</th>
            <th style="padding: 12px; text-align: left;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($codes as $c): ?>
            <tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 12px;"><?= $c['id'] ?></td>
                <td style="padding: 12px;"><strong style="font-family: monospace; font-size: 16px;"><?= esc($c['code']) ?></strong></td>
                <td style="padding: 12px;"><?= number_format($c['montant'], 2, ',', ' ') ?></td>
                <td style="padding: 12px;">
                    <?php if($c['statut'] == 'disponible'): ?>
                        <span style="background:#d4edda; color:#155724; padding:3px 8px; border-radius:4px; font-size:12px;">Disponible</span>
                    <?php else: ?>
                        <span style="background:#f8d7da; color:#721c24; padding:3px 8px; border-radius:4px; font-size:12px;">Utilisé</span>
                    <?php endif; ?>
                </td>
                <td style="padding: 12px;"><?= $c['used_at'] ? date('d/m/Y H:i', strtotime($c['used_at'])) : '-' ?></td>
                <td style="padding: 12px;" class="actions-cell">
                    <?php if($c['statut'] == 'disponible'): ?>
                        <a href="<?= site_url('admin/codes/delete/' . $c['id']) ?>" onclick="return confirm('Supprimer ce code ?')" class="action-btn delete">Supprimer</a>
                    <?php else: ?>
                        <span style="color: #ccc;">-</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>