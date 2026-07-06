<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Search Products</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include "header.php"; ?>

<main>

    <!-- HERO -->
    <section class="hero">
        <img src="assets/images/pricecomparison.jpg" class="hero-bg">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Compare Product Prices</h1>
            <p>Find the best deals across multiple sellers</p>
        </div>
    </section>

    <div class="container">

        <!-- SEARCH FORM -->
        <section class="section">
            <h2 class="section-title">Find Product</h2>
            <p class="muted">Search for a product and compare prices instantly.</p>

            <form method="get" class="product-search-form">
                <input
                    type="text"
                    name="q"
                    placeholder="Search product..."
                    value="<?= htmlspecialchars($search) ?>"
                    autofocus>
                <button class="btn" type="submit">Search</button>
            </form>
        </section>

        <!-- RESULTS -->
        <section class="section">

            <?php if ($search === ''): ?>
                <p class="empty">Start by searching a product above.</p>

            <?php elseif (empty($rows)): ?>
                <p class="empty">No products found.</p>

            <?php else: ?>
                <div class="product-grid">
                    <?php foreach ($rows as $r): ?>
                    <div class="product-card">

                        <div class="product-image">
                            <img
                                src="<?= !empty($r['image_url']) ? $r['image_url'] : 'assets/images/default.png' ?>"
                                alt="<?= htmlspecialchars($r['name']) ?>">
                        </div>

                        <div class="product-top">
                            <div class="product-info">
                                <div class="product-brand"><?= htmlspecialchars($r['brand']) ?></div>
                                <div class="product-name"><?= htmlspecialchars($r['name']) ?></div>
                            </div>
                            <span class="product-tag">Compare</span>
                        </div>

                        <p class="product-desc"><?= htmlspecialchars($r['description']) ?></p>

                        <a href="compare_price_entry.php?product_id=<?= $r['id'] ?>&source=list" class="btn">
                            Compare Prices →
                        </a>

                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </section>

    </div>

</main>

<?php include "footer.php"; ?>

</body>
</html>
