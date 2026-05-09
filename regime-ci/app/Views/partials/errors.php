<?php if (!empty($errors)): ?>
    <div class="error-list">
        <?php foreach ($errors as $message): ?>
            <p><?= esc($message) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>