<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ingredient Safety Checker</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/ingredient.css">
</head>

<body>

<?php include "header.php"; ?>

<main class="container">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <span>›</span>
        <span>Ingredient Checker</span>
    </div>

    <!-- PAGE HERO -->
    <div class="ingredient-hero">
        <h2>Ingredient Safety Checker</h2>
        <p>Search any skincare ingredient to check its safety rating and notes.</p>
    </div>

    <!-- SEARCH FORM -->
    <div class="ingredient-search-wrap">
        <form method="post" class="ingredient-form">
            <input
                name="ingredient"
                placeholder="e.g. Niacinamide, Retinol, Fragrance..."
                value="<?= isset($query) ? htmlspecialchars($query) : '' ?>"
                required>
            <button type="submit">Check</button>
        </form>
    </div>

    <!-- RESULTS -->
    <?php if ($results !== null): ?>

        <?php if (empty($results)): ?>

            <div class="ingredient-empty">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <circle cx="18" cy="18" r="11" stroke="#111" stroke-width="2.5"/>
                    <path d="M27 27l7 7" stroke="#111" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M14 18h8M18 14v8" stroke="#111" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <p>No results found for "<strong><?= htmlspecialchars($query) ?></strong>".<br>Try a different spelling or ingredient name.</p>
            </div>

        <?php else: ?>

            <div class="results-header">
                <h3>Results</h3>
                <span class="results-count"><?= count($results) ?> found</span>
            </div>

            <?php foreach ($results as $r): ?>
                <?php include __DIR__ . '/partials/ingredient_card.php'; ?>
            <?php endforeach; ?>

        <?php endif; ?>

    <?php endif; ?>

</main>

<?php include "footer.php"; ?>

</body>
</html>