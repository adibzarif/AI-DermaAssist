<?php // Expects: $ingredients ?>
<div class="ing-grid">
    <?php foreach ($ingredients as $ing): ?>
    <div class="ing-card">
        <div class="ing-name">
            <span class="safety-dot dot-<?= htmlspecialchars($ing['safety'] ?? 'unknown') ?>"></span>
            <?= htmlspecialchars($ing['name']) ?>
        </div>
        <?php if (!empty($ing['notes'])): ?>
        <div class="ing-note"><?= htmlspecialchars($ing['notes']) ?></div>
        <?php endif; ?>
        <?php if (!empty($ing['treats'])): ?>
        <div class="ing-treats treats-good">✓ Treats: <?= htmlspecialchars($ing['treats']) ?></div>
        <?php endif; ?>
        <?php if (!empty($ing['avoids'])): ?>
        <div class="ing-treats treats-bad">⚠ Caution for: <?= htmlspecialchars($ing['avoids']) ?></div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>