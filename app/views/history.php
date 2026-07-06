<!DOCTYPE html>
<html>
<head>
    <title>Analysis History — AI DermaAssist</title>
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

    .history-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 14px; margin-bottom: 28px; }

    .history-card { background: var(--white); border: 1px solid var(--border); border-radius: 10px; padding: 20px; transition: border-color 0.15s; }
    .history-card:hover { border-color: #bbb; }

    .history-date { font-size: 11px; color: var(--muted); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.05em; }

    .badge-row { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 16px; }
    .badge { padding: 3px 8px; border: 1px solid var(--border); border-radius: 4px; font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em; }

    .score-row { display: flex; align-items: center; gap: 10px; padding: 7px 0; border-bottom: 1px solid var(--border); font-size: 12px; }
    .score-row:last-child { border-bottom: none; }
    .score-name { color: var(--muted); width: 80px; flex-shrink: 0; }
    .score-bar-wrap { flex: 1; height: 3px; background: #eee; border-radius: 10px; overflow: hidden; }
    .score-bar-fill { height: 100%; border-radius: 10px; }
    .score-pct { width: 34px; text-align: right; font-size: 12px; font-weight: 500; }

    .empty-state { background: var(--white); border: 1px solid var(--border); border-radius: 10px; padding: 52px 32px; text-align: center; }
    .empty-state h3 { font-size: 16px; font-weight: 600; margin-bottom: 6px; }
    .empty-state p { font-size: 13px; color: var(--muted); }

    .pagination { display: flex; gap: 6px; }
    .page { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); border-radius: 6px; font-size: 12px; color: var(--muted); text-decoration: none; font-weight: 500; transition: all 0.15s; background: var(--white); }
    .page:hover { border-color: #111; color: var(--text); }
    .page.active { background: #111; border-color: #111; color: #fff; }
    </style>
</head>
<body>
<div class="layout">

    <?php require 'partials/sidebar.php'; ?>

    <div class="main">
        <h1 class="page-title">Analysis History</h1>
        <p class="page-sub">A record of all your AI skin analyses.</p>

        <?php
        $perPage = 6; $pageNum = $_GET['p'] ?? 1;
        $total = count($history); $totalPages = ceil($total / $perPage);
        $start = ($pageNum - 1) * $perPage; $data = array_slice($history, $start, $perPage);
        ?>

        <?php if(empty($data)): ?>
            <div class="empty-state">
                <h3>No analyses yet</h3>
                <p>Complete your first scan to see results here.</p>
            </div>
        <?php else: ?>

        <div class="history-grid">
            <?php foreach($data as $h):
                $json = json_decode($h['result_json'], true);
                $scores = $json['problem_scores'] ?? [];
                $colors = ['acne'=>'#ec4899','darkspots'=>'#f59e0b','redness'=>'#ef4444','wrinkles'=>'#3b82f6'];
            ?>
            <div class="history-card">
                <div class="history-date"><i class="fa fa-calendar" style="margin-right:4px;"></i><?= date('d M Y · H:i', strtotime($h['created_at'])) ?></div>
                <div class="badge-row">
                    <span class="badge"><?= ucfirst($h['skintype']) ?></span>
                    <span class="badge"><?= ucfirst($h['skintone']) ?></span>
                </div>
                <?php foreach($scores as $name => $score):
                    $pct = round($score * 100);
                    $color = $colors[strtolower($name)] ?? '#999';
                ?>
                <div class="score-row">
                    <span class="score-name"><?= ucfirst($name) ?></span>
                    <div class="score-bar-wrap"><div class="score-bar-fill" style="width:<?= $pct ?>%;background:<?= $color ?>;"></div></div>
                    <span class="score-pct"><?= $pct ?>%</span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>

        <?php if($totalPages > 1): ?>
        <div class="pagination">
            <?php for($i=1; $i<=$totalPages; $i++): ?>
                <a href="profile.php?page=history&p=<?= $i ?>" class="page <?= $i==$pageNum?'active':'' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
