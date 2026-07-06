<?php
// Expects: $p (product array), $userWishlist (array of product IDs)
// Optional query params preserved in links: search, problem, type, tone
$qs = http_build_query(array_filter([
    'search'  => $_GET['search']  ?? null,
    'problem' => $_GET['problem'] ?? null,
    'type'    => $_GET['type']    ?? null,
    'tone'    => $_GET['tone']    ?? null,
]));
$qs = $qs ? '&' . $qs : '';
?>
<div class="product-card">

    <div class="product-image">
        <img src="<?= !empty($p['image_url']) ? $p['image_url'] : 'assets/images/default.png' ?>"
             alt="<?= htmlspecialchars($p['name']) ?>">
    </div>

    <div class="wishlist-btn" data-id="<?= $p['id'] ?>">
        <?= in_array($p['id'], $userWishlist) ? '❤️' : '🤍' ?>
    </div>

    <p class="product-brand"><?= htmlspecialchars($p['brand']) ?></p>

    <div class="product-top">
        <span class="product-name"><?= htmlspecialchars($p['name']) ?></span>
        <span class="product-tag">Trending</span>
    </div>

    <p class="product-desc"><?= htmlspecialchars($p['description']) ?></p>

    <a href="all_product.php?id=<?= $p['id'] ?><?= $qs ?>" class="btn">View</a>

</div>
