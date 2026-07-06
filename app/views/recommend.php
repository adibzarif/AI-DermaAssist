<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Recommended Products</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/recommend.css">
</head>

<body>

<?php include "header.php"; ?>

<main class="container">

<!-- BREADCRUMB -->
<div class="breadcrumb">
    <a href="index.php">Home</a>
    <span>›</span>
    <a href="skin_analysis.php">Analyze</a>
    <span>›</span>
    <a href="analyze.php">Analysis Results</a>
    <span>›</span>
    <span>Recommended Products</span>
</div>

<h2 class="section-title">Recommended Products</h2>

<div class="actions" style="margin-bottom:20px;">
    <a href="analyze_entry.php" class="back-link">&larr; Back to Analysis Result</a>
</div>

<!-- =============================================
   SECTION 1: By Skin Problem
============================================= -->
<?php if (empty($selected_problems)): ?>
    <p>No significant issues detected.</p>
<?php else: ?>
    <?php foreach ($selected_problems as $problem_name => $score): ?>
        <h3 class="category-title" style="color:black;">
            Products for <?= htmlspecialchars($problem_name) ?>
        </h3>

        <?php $products = $products_by_problem[$problem_name] ?? []; ?>

        <?php if (!$products): ?>
            <p class="empty">No products found.</p>
        <?php else: ?>
            <div class="slider-wrapper" data-slider>
                <button class="slider-btn prev-btn" aria-label="Previous">&#8249;</button>
                <div class="slider-track-outer">
                    <div class="product-grid">
                        <?php foreach ($products as $p):
                            $img       = !empty($p['image_url']) ? $p['image_url'] : 'assets/images/default.png';
                            $priceData = $min_prices[$p['id']] ?? null;
                            $priceVal  = $priceData ? $priceData['price'] : '';
                        ?>
                        <?php include __DIR__ . '/partials/product_card.php'; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button class="slider-btn next-btn" aria-label="Next">&#8250;</button>
                <div class="slider-dots"></div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>


<!-- =============================================
   SECTION 2: By Skin Type
============================================= -->
<h3 class="category-title" style="color:black;">
    Suitable for your skin type: <?= htmlspecialchars($skintype) ?>
</h3>

<?php if ($products_by_type): ?>
    <div class="slider-wrapper" data-slider>
        <button class="slider-btn prev-btn" aria-label="Previous">&#8249;</button>
        <div class="slider-track-outer">
            <div class="product-grid">
                <?php foreach ($products_by_type as $p):
                    $img       = !empty($p['image_url']) ? $p['image_url'] : 'assets/images/default.png';
                    $priceData = $min_prices[$p['id']] ?? null;
                    $priceVal  = $priceData ? $priceData['price'] : '';
                ?>
                <?php include __DIR__ . '/partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <button class="slider-btn next-btn" aria-label="Next">&#8250;</button>
        <div class="slider-dots"></div>
    </div>
<?php else: ?>
    <p class="empty">No products found.</p>
<?php endif; ?>


<!-- =============================================
   SECTION 3: By Skin Tone
============================================= -->
<h3 class="category-title" style="color:black;">
    Best for your skin tone: <?= htmlspecialchars($skintone) ?>
</h3>

<?php if ($products_by_tone): ?>
    <div class="slider-wrapper" data-slider>
        <button class="slider-btn prev-btn" aria-label="Previous">&#8249;</button>
        <div class="slider-track-outer">
            <div class="product-grid">
                <?php foreach ($products_by_tone as $p):
                    $img       = !empty($p['image_url']) ? $p['image_url'] : 'assets/images/default.png';
                    $priceData = $min_prices[$p['id']] ?? null;
                    $priceVal  = $priceData ? $priceData['price'] : '';
                ?>
                <?php include __DIR__ . '/partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <button class="slider-btn next-btn" aria-label="Next">&#8250;</button>
        <div class="slider-dots"></div>
    </div>
<?php else: ?>
    <p class="empty">No products found.</p>
<?php endif; ?>

</main>

<?php include "footer.php"; ?>

<?php include __DIR__ . '/partials/checklist_panel.php'; ?>
<?php include __DIR__ . '/partials/receipt_modal.php'; ?>

<div class="cl-toast" id="cl-toast"></div>

<script src="assets/js/recommend.js"></script>

</body>
</html>