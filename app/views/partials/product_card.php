<!-- Expects: $p, $img, $priceData, $priceVal, $score (optional) -->
<div class="product-card"
     data-product-id="<?= $p['id'] ?>"
     data-brand="<?= htmlspecialchars($p['brand'], ENT_QUOTES) ?>"
     data-name="<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>"
     data-price="<?= $priceVal ?>"
     data-store="<?= $priceData ? htmlspecialchars($priceData['store'], ENT_QUOTES) : '' ?>"
     data-img="<?= htmlspecialchars($img, ENT_QUOTES) ?>"
     onclick="toggleProduct(this)">

    <div class="card-checkbox-wrap">
        <div class="card-checkbox-icon">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path d="M2 6.5L5.2 10L11 3" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>

    <div class="product-image">
        <img src="<?= $img ?>" alt="<?= htmlspecialchars($p['name']) ?>">
    </div>

    <div class="product-top">
        <div class="product-info">
            <div class="product-brand"><?= htmlspecialchars($p['brand']) ?></div>
            <div class="product-name"><?= htmlspecialchars($p['name']) ?></div>
        </div>
        <?php if (isset($score)): ?>
            <span class="product-tag"><?= $score ?>%</span>
        <?php endif; ?>
    </div>

    <?php if ($priceData): ?>
        <div class="card-price-row">
            <span class="card-price-amount">
                <span class="currency">RM </span><?= number_format($priceData['price'], 2) ?>
            </span>
            <span class="card-price-store">from <?= htmlspecialchars($priceData['store']) ?></span>
        </div>
    <?php else: ?>
        <p class="card-price-tba">Price not available</p>
    <?php endif; ?>

    <p class="product-desc"><?= htmlspecialchars($p['description']) ?></p>

    <a href="compare_price_entry.php?product_id=<?= $p['id'] ?>&source=recommend"
       class="btn" onclick="event.stopPropagation()">
        View Prices &rarr;
    </a>

</div>
