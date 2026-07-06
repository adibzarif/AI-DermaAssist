<?php // Expects: $similar ?>
<div class="similar-grid">
    <?php foreach ($similar as $sim): ?>
    <div class="sim-card">
        <div class="sim-img">
            <img
                src="<?= !empty($sim['image_url']) ? htmlspecialchars($sim['image_url']) : 'assets/images/default.png' ?>"
                alt="<?= htmlspecialchars($sim['name']) ?>"
                loading="lazy">
        </div>
        <div class="sim-body">
            <div class="sim-brand"><?= htmlspecialchars($sim['brand']) ?></div>
            <div class="sim-name"><?= htmlspecialchars($sim['name']) ?></div>
            <?php if (!empty($sim['price_min'])): ?>
            <div class="sim-price">from RM <?= number_format($sim['price_min'], 2) ?></div>
            <?php endif; ?>
            <?php if (!empty($sim['store_count'])): ?>
            <div class="sim-stores"><?= (int)$sim['store_count'] ?> store<?= $sim['store_count'] != 1 ? 's' : '' ?></div>
            <?php endif; ?>
            <a href="compare_price_entry.php?product_id=<?= (int)$sim['id'] ?>&source=similar" class="btn-sim">
                Compare Prices
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>