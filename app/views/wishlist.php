<!DOCTYPE html>
<html>
<head>
    <title>Favourite Products — AI DermaAssist</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root { --white: #ffffff; --bg: #f7f7f7; --border: #e5e5e5; --text: #111111; --muted: #888888; --sidebar-w: 240px; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; font-size: 14px; }
    .layout { display: flex; min-height: 100vh; }

    .sidebar { width: var(--sidebar-w); background: var(--white); border-right: 1px solid var(--border); padding: 28px 16px; display: flex; flex-direction: column; position: sticky; top: 0; height: 100vh; }
    .sidebar-logo { font-size: 14px; font-weight: 600; color: var(--text); padding: 0 8px; margin-bottom: 32px; }
    .back-home a { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--muted); text-decoration: none; padding: 7px 8px; border-radius: 6px; margin-bottom: 4px; transition: color 0.15s, background 0.15s; }
    .back-home a:hover { color: var(--text); background: var(--bg); }
    .menu-label { font-size: 10px; color: var(--muted); padding: 0 8px; margin-bottom: 4px; letter-spacing: 0.06em; text-transform: uppercase; }
    .menu a { display: flex; align-items: center; gap: 10px; padding: 9px 8px; border-radius: 6px; margin-bottom: 1px; text-decoration: none; color: var(--muted); font-size: 13px; transition: color 0.15s, background 0.15s; }
    .menu a i { width: 16px; text-align: center; font-size: 13px; }
    .menu a:hover { color: var(--text); background: var(--bg); }
    .menu .active { color: var(--text); background: var(--bg); font-weight: 500; }
    .sidebar-divider { border: none; border-top: 1px solid var(--border); margin: 16px 0; }
    .logout { margin-top: auto; }
    .logout a { display: flex; align-items: center; gap: 10px; padding: 9px 8px; border-radius: 6px; text-decoration: none; color: #e53e3e; font-size: 13px; transition: background 0.15s; }
    .logout a:hover { background: #fff5f5; }

    .main { flex: 1; padding: 40px 48px; }
    .page-title { font-size: 20px; font-weight: 600; margin-bottom: 2px; }
    .page-sub { font-size: 13px; color: var(--muted); margin-bottom: 28px; }

    .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 14px; }

    .product-card { background: var(--white); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; transition: border-color 0.15s; }
    .product-card:hover { border-color: #bbb; }

    .product-img-wrap { width: 100%; aspect-ratio: 1/1; background: var(--bg); overflow: hidden; position: relative; }
    .product-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
    .product-card:hover .product-img-wrap img { transform: scale(1.03); }

    .heart-badge { position: absolute; top: 8px; right: 8px; width: 26px; height: 26px; background: var(--white); border: 1px solid var(--border); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #e53e3e; font-size: 11px; }

    .product-body { padding: 14px; }
    .product-brand { font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 3px; }
    .product-name { font-size: 13px; font-weight: 500; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    .empty-state { background: var(--white); border: 1px solid var(--border); border-radius: 10px; padding: 60px 32px; text-align: center; max-width: 380px; }
    .empty-state h3 { font-size: 16px; font-weight: 600; margin-bottom: 6px; }
    .empty-state p { font-size: 13px; color: var(--muted); margin-bottom: 18px; line-height: 1.5; }
    .btn-explore { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: #111; color: #fff; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; transition: opacity 0.15s; }
    .btn-explore:hover { opacity: 0.8; }
    </style>
</head>
<body>
<div class="layout">

    <?php require 'partials/sidebar.php'; ?>

    <div class="main">
        <h1 class="page-title">Favourite Products</h1>
        <p class="page-sub">Products you've saved for your skincare routine.</p>

        <?php if(empty($wishlist)): ?>
            <div class="empty-state">
                <h3>Nothing saved yet</h3>
                <p>Browse recommended products and save your favourites here.</p>
                <a href="all_product.php" class="btn-explore">Explore Products <i class="fa fa-arrow-right" style="font-size:10px;"></i></a>
            </div>
        <?php else: ?>
        <div class="products">
            <?php foreach($wishlist as $p): ?>
            <div class="product-card">
                <div class="product-img-wrap">
                    <img src="<?= $p['image_url'] ?? 'uploads/default.png' ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                    <div class="heart-badge"><i class="fa fa-heart"></i></div>
                </div>
                <div class="product-body">
                    <div class="product-brand"><?= htmlspecialchars($p['brand']) ?></div>
                    <div class="product-name"><?= htmlspecialchars($p['name']) ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
