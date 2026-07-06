<?php
// Expects: $r (name, safety, notes)
$safety_class = htmlspecialchars(strtolower(trim($r['safety'])));
?>
<div class="ingredient-card">

    <div class="ingredient-card-strip strip-<?= $safety_class ?>"></div>

    <div class="ingredient-card-body">
        <div class="ingredient-top">
            <div class="ingredient-name"><?= htmlspecialchars($r['name']) ?></div>
            <span class="badge safety-badge <?= $safety_class ?>">
                <?= htmlspecialchars(ucfirst(trim($r['safety']))) ?>
            </span>
        </div>

        <?php if (!empty($r['notes'])): ?>
            <div class="ingredient-notes"><?= htmlspecialchars($r['notes']) ?></div>
        <?php else: ?>
            <div class="ingredient-notes">No additional notes available.</div>
        <?php endif; ?>
    </div>

</div>