<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($product['name']) ?> — Price Comparison</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/compare_price.css">
</head>
<body>

<?php include "header.php"; ?>

<main>
<div class="container">
<div class="page-wrap">

    <!-- BREADCRUMB (only shown when coming from recommend) -->
    <?php
    $showBreadcrumb = false;
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referrer = basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
        if ($referrer === 'recommend_entry.php' || $referrer === 'recommend.php') {
            $showBreadcrumb = true;
        }
    }
    ?>
    <?php if ($showBreadcrumb): ?>
    <div class="breadcrumb">
        <a href="index.php">Home</a> <span>›</span>
        <a href="skin_analysis.php">Analyze</a> <span>›</span>
        <a href="analyze.php">Analysis Results</a> <span>›</span>
        <a href="recommend_entry.php">Recommended Products</a> <span>›</span>
        <span>Compare Prices</span>
    </div>
    <?php else: ?>
    <div class="breadcrumb">
        <a href="<?= htmlspecialchars($back) ?>"><?= htmlspecialchars($back_label) ?></a>
    </div>
    <?php endif; ?>

    <!-- ==================== TOP GRID ==================== -->
    <div class="top-grid">

        <!-- PRODUCT IMAGE -->
        <div class="img-card">
            <?php if (!empty($prices)): ?>
            <span class="img-badge">Best from RM <?= number_format($bestPrice, 2) ?></span>
            <?php endif; ?>
            <img
                src="<?= !empty($product['image_url']) ? htmlspecialchars($product['image_url']) : 'assets/images/default.png' ?>"
                alt="<?= htmlspecialchars($product['name']) ?>">
            <button
                class="btn-wish-lg <?= $isWishlisted ? 'saved' : '' ?>"
                onclick="toggleWish(this, <?= (int)$product['id'] ?>)"
                aria-label="Wishlist">
                <?= $isWishlisted ? '♥' : '♡' ?>
            </button>
        </div>

        <!-- PRODUCT INFO -->
        <div class="info-panel">
            <div>
                <div class="prod-brand-lg"><?= htmlspecialchars($product['brand']) ?></div>
                <h1 class="prod-name-lg"><?= htmlspecialchars($product['name']) ?></h1>
            </div>

            <p class="prod-desc-lg"><?= htmlspecialchars($product['description']) ?></p>

            <!-- Skin tags -->
            <?php if ($concerns || $skinTypes || $skinTones): ?>
            <div class="tags-row">
                <?php foreach ($concerns  as $c): ?>
                    <span class="stag stag-concern">🎯 <?= ucfirst(htmlspecialchars($c)) ?></span>
                <?php endforeach; ?>
                <?php foreach ($skinTypes as $t): ?>
                    <span class="stag stag-type">💧 <?= ucfirst(htmlspecialchars($t)) ?> skin</span>
                <?php endforeach; ?>
                <?php foreach ($skinTones as $tn): ?>
                    <span class="stag stag-tone">🎨 <?= ucfirst(htmlspecialchars($tn)) ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- BEST PRICE HERO -->
            <?php if (!empty($prices)): ?>
            <div class="best-price-hero">
                <div class="bph-left">
                    <div class="label">Best Price Available</div>
                    <div class="price">RM <?= number_format($bestPrice, 2) ?></div>
                    <div class="store">
                        <?= $storeIcons[$prices[0]['store_name']] ?? '🏪' ?>
                        <?= htmlspecialchars($prices[0]['store_name']) ?>
                        &nbsp;·&nbsp; Updated <?= timeSince($prices[0]['last_checked'] ?? '') ?>
                    </div>
                </div>
                <div class="bph-right">
                    <?php if ($savings > 0): ?>
                    <span class="savings-badge">💰 Save up to RM <?= number_format($savings, 2) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($prices[0]['url'])): ?>
                    <a href="<?= htmlspecialchars($prices[0]['url']) ?>" target="_blank" rel="noopener" class="btn-buy-best">
                        Buy Now
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div><!-- /.top-grid -->

    <!-- ==================== SAVINGS SUMMARY BAR ==================== -->
    <?php if ($savings > 0 && count($prices) > 1): ?>
    <div class="savings-bar">
        <span class="sb-icon">💡</span>
        <div class="sb-text">
            Buying from <strong><?= htmlspecialchars($prices[0]['store_name']) ?></strong>
            instead of <strong><?= htmlspecialchars(end($prices)['store_name']) ?></strong>
            saves you <strong>RM <?= number_format($savings, 2) ?></strong>
            — that's <?= round(($savings / $worstPrice) * 100) ?>% cheaper.
        </div>
        <button class="sb-share" onclick="copyLink()">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
            Share
        </button>
    </div>
    <?php endif; ?>

    <!-- ==================== PRICE COMPARISON TABLE ==================== -->
    <div class="sec-head">
        <h2 class="sec-title">Price Comparison</h2>
        <?php if (!empty($prices)): ?>
        <span class="sec-badge"><?= count($prices) ?> store<?= count($prices) != 1 ? 's' : '' ?></span>
        <?php endif; ?>
    </div>

    <div class="price-table-wrap">
        <?php if (!empty($prices)): ?>
        <table class="price-table">
            <thead>
                <tr>
                    <th>Store</th>
                    <th>Price</th>
                    <th>vs Cheapest</th>
                    <th>Last Updated</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($prices as $i => $p):
                $isBest   = ($i === 0);
                $isWorst  = ($i === count($prices) - 1);
                $diff     = (float)$p['price'] - $bestPrice;
                $storeClr = $storeColors[$p['store_name']] ?? '#9ca3af';
            ?>
            <tr class="<?= $isBest ? 'best-row' : '' ?>">
                <td>
                    <div class="store-cell">
                        <span class="store-dot" style="background:<?= $storeClr ?>"></span>
                        <span class="store-name-txt"><?= htmlspecialchars($p['store_name']) ?></span>
                        <?php if ($isBest): ?><span class="best-tag">Best</span><?php endif; ?>
                    </div>
                </td>
                <td>
                    <span class="price-cell <?= $isBest ? 'cheapest' : ($isWorst ? 'priciest' : '') ?>">
                        RM <?= number_format((float)$p['price'], 2) ?>
                    </span>
                </td>
                <td>
                    <?php if ($isBest): ?>
                    <span class="diff-cell saving">✓ Cheapest</span>
                    <?php else: ?>
                    <span class="diff-cell extra">+RM <?= number_format($diff, 2) ?> more</span>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="updated-cell"><?= timeSince($p['last_checked'] ?? '') ?></span>
                </td>
                <td>
                    <?php if (!empty($p['url'])): ?>
                    <a href="<?= htmlspecialchars($p['url']) ?>" target="_blank" rel="noopener"
                       class="btn-visit <?= $isBest ? 'primary' : '' ?>">
                        <?= $isBest ? 'Buy Now' : 'Visit Store' ?>
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                    <?php else: ?>
                    <span class="no-link">No link</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="no-prices">
            <div class="ni">🏷️</div>
            <p>No store prices listed yet for this product.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- ==================== INGREDIENTS ==================== -->
    <?php if (!empty($ingredients)): ?>
    <div class="ing-section">
        <div class="sec-head">
            <h2 class="sec-title">Ingredients</h2>
            <span class="sec-badge"><?= count($ingredients) ?> listed</span>
        </div>
        <?php include __DIR__ . '/partials/ingredients_grid.php'; ?>
    </div>
    <?php endif; ?>

    <!-- ==================== SIMILAR PRODUCTS ==================== -->
    <?php if (!empty($similar)): ?>
    <div class="similar-section">
        <div class="sec-head">
            <h2 class="sec-title">Also Good for <?= !empty($concerns) ? ucfirst(htmlspecialchars($concerns[0])) : '' ?></h2>
            <span class="sec-badge"><?= count($similar) ?> products</span>
        </div>
        <?php include __DIR__ . '/partials/similar_grid.php'; ?>
    </div>
    <?php endif; ?>

</div><!-- /.page-wrap -->
</div><!-- /.container -->
</main>

<?php include "footer.php"; ?>
<script src="assets/js/compare_price.js"></script>
</body>
</html>