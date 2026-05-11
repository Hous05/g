<?php /** @var array<int, array<string, mixed>> $codes */ ?>
<?php /** @var string|null $search */ ?>
<?php /** @var string|null $statut */ ?>
<?= $this->extend('layouts/back') ?>
<?= $this->section('content') ?>

<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; gap: 20px; flex-wrap: wrap;">
    <h1>Gestion des Codes de Recharge</h1>

    <div style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h3 style="margin-top: 0;">Generer des codes</h3>
        <form action="<?= site_url('admin/codes/generate') ?>" method="post" style="display: flex; gap: 10px; align-items: center;">
            <input type="number" name="montant" placeholder="Montant (Ar)" required style="width: 120px;">
            <input type="number" name="quantite" placeholder="Quantite" required value="1" min="1" max="50" style="width: 90px;">
            <button type="submit" class="button">Generer</button>
        </form>
    </div>
</div>

<?php if (session()->getFlashdata('message')): ?>
    <p class="success"><?= esc((string) session()->getFlashdata('message')) ?></p>
<?php endif; ?>

<form method="get" style="display: flex; gap: 10px; align-items: center; margin-bottom: 16px; flex-wrap: wrap;">
    <input type="text" name="q" placeholder="Rechercher un code" value="<?= esc($search ?? '') ?>" list="code-suggestions" style="width: 220px;">
    <select name="statut" style="width: 180px;">
        <option value="">Tous les statuts</option>
        <option value="disponible" <?= ($statut ?? '') === 'disponible' ? 'selected' : '' ?>>Disponible</option>
        <option value="utilise" <?= ($statut ?? '') === 'utilise' ? 'selected' : '' ?>>Utilise</option>
        <option value="expire" <?= ($statut ?? '') === 'expire' ? 'selected' : '' ?>>Expire</option>
    </select>
    <button type="submit" class="button">Filtrer</button>
    <a href="<?= site_url('admin/codes') ?>" class="button secondary">Reinitialiser</a>
</form>

<datalist id="code-suggestions">
    <?php foreach ($codes as $c): ?>
        <option value="<?= esc((string) $c['code']) ?>"></option>
    <?php endforeach; ?>
</datalist>

<table>
    <thead>
        <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
            <th style="padding: 12px; text-align: left;">ID</th>
            <th style="padding: 12px; text-align: left;">Code</th>
            <th style="padding: 12px; text-align: left;">Montant (Ar)</th>
            <th style="padding: 12px; text-align: left;">Statut</th>
            <th style="padding: 12px; text-align: left;">Utilisateur</th>
            <th style="padding: 12px; text-align: left;">Utilise le</th>
            <th style="padding: 12px; text-align: left;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($codes as $c): ?>
            <tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 12px;"><?= $c['id'] ?></td>
                <td style="padding: 12px;"><strong style="font-family: monospace; font-size: 16px;"><?= esc((string) $c['code']) ?></strong></td>
                <td style="padding: 12px;"><?= number_format($c['montant'], 2, ',', ' ') ?></td>
                <td style="padding: 12px;">
                    <?php if($c['statut'] == 'disponible'): ?>
                        <span style="background:#d4edda; color:#155724; padding:3px 8px; border-radius:4px; font-size:12px;">Disponible</span>
                    <?php elseif ($c['statut'] == 'expire'): ?>
                        <span style="background:#fff3cd; color:#856404; padding:3px 8px; border-radius:4px; font-size:12px;">Expire</span>
                    <?php else: ?>
                        <span style="background:#f8d7da; color:#721c24; padding:3px 8px; border-radius:4px; font-size:12px;">Utilisé</span>
                    <?php endif; ?>
                </td>
                <td style="padding: 12px;">
                    <?php if (!empty($c['utilisateur_email'])): ?>
                        <?= esc((string) ($c['utilisateur_nom'] ?? '')) ?> (<?= esc((string) $c['utilisateur_email']) ?>)
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td style="padding: 12px;"><?= $c['used_at'] ? date('d/m/Y H:i', strtotime($c['used_at'])) : '-' ?></td>
                <td style="padding: 12px;" class="actions-cell">
                    <?php if($c['statut'] == 'disponible'): ?>
                        <form action="<?= site_url('admin/codes/status/' . $c['id']) ?>" method="post" style="display: inline-block;">
                            <input type="hidden" name="statut" value="expire">
                            <button class="action-btn" onclick="return confirm('Marquer ce code comme expire ?')">Expirer</button>
                        </form>
                        <a href="<?= site_url('admin/codes/delete/' . $c['id']) ?>" onclick="return confirm('Supprimer ce code ?')" class="action-btn delete">Supprimer</a>
                    <?php elseif ($c['statut'] == 'expire'): ?>
                        <form action="<?= site_url('admin/codes/status/' . $c['id']) ?>" method="post" style="display: inline-block;">
                            <input type="hidden" name="statut" value="disponible">
                            <button class="action-btn" onclick="return confirm('Reactiver ce code ?')">Reactiver</button>
                        </form>
                    <?php else: ?>
                        <span style="color: #ccc;">-</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>