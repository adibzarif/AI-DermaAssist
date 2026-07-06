<!DOCTYPE html>
<html>
<head>
    <title>Shopping List History — AI DermaAssist</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root { --white: #ffffff; --bg: #f7f7f7; --border: #e5e5e5; --text: #111111; --muted: #888888; --green: #2d7a2d; --green-light: #e6f4e6; --sidebar-w: 240px; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; font-size: 14px; }
    .layout { display: flex; min-height: 100vh; }

    /* ── Sidebar (same as other pages) ── */
    .sidebar { width: var(--sidebar-w); background: var(--white); border-right: 1px solid var(--border); padding: 28px 16px; display: flex; flex-direction: column; position: sticky; top: 0; height: 100vh; }
    .sidebar-logo { font-size: 14px; font-weight: 600; color: var(--text); padding: 0 8px; margin-bottom: 32px; }
    .back-home a { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--muted); text-decoration: none; padding: 7px 8px; border-radius: 6px; margin-bottom: 4px; transition: color 0.15s, background 0.15s; }
    .back-home a:hover { color: var(--text); background: var(--bg); }
    .sidebar-divider { border: none; border-top: 1px solid var(--border); margin: 16px 0; }
    .sidebar-user { display: flex; align-items: center; gap: 10px; padding: 0 4px; margin-bottom: 4px; }
    .sidebar-avatar { width: 32px; height: 32px; border-radius: 50%; background: #111; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; flex-shrink: 0; }
    .sidebar-name  { font-size: 13px; font-weight: 500; }
    .sidebar-email { font-size: 11px; color: var(--muted); }
    .menu-label { font-size: 10px; color: var(--muted); padding: 0 8px; margin-bottom: 4px; letter-spacing: 0.06em; text-transform: uppercase; }
    .menu a { display: flex; align-items: center; gap: 10px; padding: 9px 8px; border-radius: 6px; margin-bottom: 1px; text-decoration: none; color: var(--muted); font-size: 13px; transition: color 0.15s, background 0.15s; }
    .menu a i { width: 16px; text-align: center; font-size: 13px; }
    .menu a:hover { color: var(--text); background: var(--bg); }
    .menu .active { color: var(--text); background: var(--bg); font-weight: 500; }
    .logout { margin-top: auto; }
    .logout a { display: flex; align-items: center; gap: 10px; padding: 9px 8px; border-radius: 6px; text-decoration: none; color: #e53e3e; font-size: 13px; transition: background 0.15s; }
    .logout a:hover { background: #fff5f5; }

    /* ── Main ── */
    .main { flex: 1; padding: 40px 48px; max-width: 820px; }
    .page-title { font-size: 20px; font-weight: 600; margin-bottom: 2px; }
    .page-sub { font-size: 13px; color: var(--muted); margin-bottom: 28px; }

    /* ── Session cards ── */
    .sessions { display: flex; flex-direction: column; gap: 12px; }

    .session-card { background: var(--white); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; transition: border-color 0.15s; }
    .session-card:hover { border-color: #bbb; }

    .session-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; cursor: pointer; user-select: none; }
    .session-left { display: flex; align-items: center; gap: 12px; }
    .session-icon { width: 34px; height: 34px; background: var(--green); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .session-icon i { color: #fff; font-size: 13px; }
    .session-date { font-size: 13px; font-weight: 500; }
    .session-meta { font-size: 11px; color: var(--muted); margin-top: 2px; }
    .session-right { display: flex; align-items: center; gap: 16px; }
    .session-total { font-size: 14px; font-weight: 600; color: var(--green); }
    .session-chevron { color: var(--muted); font-size: 11px; transition: transform 0.2s; }
    .session-card.open .session-chevron { transform: rotate(180deg); }

    /* ── Items inside session ── */
    .session-body { display: none; border-top: 1px solid var(--border); }
    .session-card.open .session-body { display: block; }

    .item-row { display: flex; align-items: center; gap: 14px; padding: 14px 20px; border-bottom: 1px solid var(--border); }
    .item-row:last-child { border-bottom: none; }

    .item-img { width: 44px; height: 44px; border-radius: 8px; object-fit: cover; background: var(--bg); flex-shrink: 0; border: 1px solid var(--border); }
    .item-info { flex: 1; min-width: 0; }
    .item-brand { font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 2px; }
    .item-name  { font-size: 13px; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .item-store { display: inline-block; font-size: 10px; color: var(--green); background: var(--green-light); padding: 1px 7px; border-radius: 20px; font-weight: 500; margin-top: 3px; }
    .item-price { font-size: 13px; font-weight: 600; color: var(--green); white-space: nowrap; flex-shrink: 0; }
    .item-price.tba { font-size: 11px; color: var(--muted); font-weight: 400; font-style: italic; }

    /* ── Empty ── */
    .empty-state { background: var(--white); border: 1px solid var(--border); border-radius: 10px; padding: 60px 32px; text-align: center; max-width: 380px; }
    .empty-state h3 { font-size: 16px; font-weight: 600; margin-bottom: 6px; }
    .empty-state p { font-size: 13px; color: var(--muted); margin-bottom: 18px; line-height: 1.5; }
    .btn-scan { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: var(--green); color: #fff; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; transition: opacity 0.15s; }
    .btn-scan:hover { opacity: 0.85; }

    @media (max-width: 680px) { .main { padding: 28px 16px; } }
    </style>
</head>
<body>
<div class="layout">

    <?php require 'partials/sidebar.php'; ?>

    <div class="main">
        <h1 class="page-title">Shopping List History</h1>
        <p class="page-sub">Every list you've saved from your skin analysis recommendations.</p>

        <?php if (empty($sessions)): ?>
            <div class="empty-state">
                <h3>No shopping lists yet</h3>
                <p>Get a skin analysis, pick your recommended products, and save a list to see it here.</p>
                <a href="skin_analysis.php" class="btn-scan">
                    <i class="fa fa-camera"></i> Start a Scan
                </a>
            </div>

        <?php else: ?>
            <div class="sessions">
                <?php foreach ($sessions as $i => $session):
                    $total     = $session['total'] ? 'RM ' . number_format($session['total'], 2) : '—';
                    $itemCount = $session['item_count'];
                    $date      = date('d M Y', strtotime($session['created_at']));
                    $time      = date('h:i A', strtotime($session['created_at']));
                ?>
                <div class="session-card <?= $i === 0 ? 'open' : '' ?>" onclick="toggleSession(this)">

                    <div class="session-header">
                        <div class="session-left">
                            <div class="session-icon"><i class="fa fa-bag-shopping"></i></div>
                            <div>
                                <div class="session-date">List #<?= count($sessions) - $i ?> &mdash; <?= $date ?></div>
                                <div class="session-meta"><?= $time ?> &middot; <?= $itemCount ?> item<?= $itemCount != 1 ? 's' : '' ?></div>
                            </div>
                        </div>
                        <div class="session-right">
                            <div class="session-total"><?= $total ?></div>
                            <i class="fa fa-chevron-down session-chevron"></i>
                        </div>
                    </div>

                    <div class="session-body">
                        <?php foreach ($session['items'] as $item): ?>
                        <div class="item-row">
                            <img class="item-img"
                                 src="<?= htmlspecialchars($item['image_url'] ?? '') ?>"
                                 alt="<?= htmlspecialchars($item['name']) ?>"
                                 onerror="this.src='uploads/default.png'">
                            <div class="item-info">
                                <div class="item-brand"><?= htmlspecialchars($item['brand']) ?></div>
                                <div class="item-name"><?= htmlspecialchars($item['name']) ?></div>
                                <?php if ($item['store_name']): ?>
                                    <span class="item-store">from <?= htmlspecialchars($item['store_name']) ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if ($item['price']): ?>
                                <div class="item-price">RM <?= number_format($item['price'], 2) ?></div>
                            <?php else: ?>
                                <div class="item-price tba">Price varies</div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function toggleSession(card) {
    // Don't collapse if clicking inside item rows (no links but future-proof)
    card.classList.toggle('open');
}
</script>
</body>
</html>
