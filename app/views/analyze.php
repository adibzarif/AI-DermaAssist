<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Analysis Results - AI-DermAssist</title>
<link rel="stylesheet" href="assets/css/style.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    :root {
        --bg-color: #ffffff;
        --card-bg: #fcfcfc;
        --card-border: #cdcdcd;
        --text-primary: #000000;
        --text-secondary: #1c1c1c;
        --accent-blue: #3293f3;
    }
    body {
        background-color: var(--bg-color);
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        margin: 0; padding: 0; padding-top: 120px;
    }
    .container { max-width: 1100px; margin: 0 auto; padding: 40px 20px; }
    .breadcrumb { font-size: 13px; color: var(--text-secondary); margin-bottom: 24px; }
    .breadcrumb a { color: var(--text-secondary); text-decoration: none; }
    .breadcrumb a:hover { color: var(--text-primary); }
    .breadcrumb span { margin: 0 8px; }
    .results-header-wrapper { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
    .main-title { font-size: 28px; font-weight: 700; margin: 0; }
    .subtitle { color: var(--text-secondary); font-size: 14px; margin-top: 6px; }
    .btn-download {
        background: #fff; border: 1px solid var(--card-border); color: var(--text-primary);
        padding: 10px 18px; border-radius: 8px; cursor: pointer; font-weight: 500;
        display: flex; align-items: center; gap: 8px; text-decoration: none; font-size: 13px;
    }
    .grid-top { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }
    .grid-bottom { display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px; margin-bottom: 32px; }
    @media(max-width:768px){ .grid-top,.grid-bottom{ grid-template-columns:1fr; } }
    .card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 12px; padding: 24px; }
    .card-title { font-size: 14px; font-weight: 600; margin: 0 0 20px; display: flex; align-items: center; gap: 10px; }
    .photo-box { display: flex; flex-direction: column; }
    .result-image-container { width:100%; height:250px; border-radius:8px; margin-bottom:16px; display:flex; justify-content:center; align-items:center; overflow:hidden; }
    .result-image { max-width:100%; max-height:100%; object-fit:contain; }
    .secure-badge { background:rgba(16,185,129,0.05); border:1px solid rgba(16,185,129,0.2); color:#10b981; padding:12px; border-radius:8px; font-size:12px; display:flex; align-items:center; gap:10px; }
    .chart-box { position:relative; height:320px; width:100%; display:flex; justify-content:center; align-items:center; }
    .breakdown-row { display:flex; align-items:center; margin-bottom:20px; }
    .breakdown-row:last-child { margin-bottom:0; }
    .label-container { width:110px; display:flex; align-items:center; gap:10px; font-size:13px; color:#555; }
    .color-dot { width:8px; height:8px; border-radius:50%; display:inline-block; }
    .dot-acne      { background:#ec4899; }
    .dot-darkspots { background:#f59e0b; }
    .dot-redness   { background:#ef4444; }
    .dot-wrinkles  { background:#3b82f6; }
    .progress-bar-wrapper { flex-grow:1; background:#e5e7eb; height:6px; border-radius:10px; margin:0 16px; }
    .progress-fill { height:100%; border-radius:10px; }
    .bg-acne      { background:#ec4899; width:<?= $display_scores['acne'] ?>%; }
    .bg-darkspots { background:#f59e0b; width:<?= $display_scores['darkspots'] ?>%; }
    .bg-redness   { background:#ef4444; width:<?= $display_scores['redness'] ?>%; }
    .bg-wrinkles  { background:#3b82f6; width:<?= $display_scores['wrinkles'] ?>%; }
    .score-text { width:60px; text-align:right; font-size:13px; color:#555; }
    .score-text span { color:#000; font-weight:600; }
    .summary-item { margin-bottom:24px; }
    .summary-item label { display:block; color:#888; font-size:11px; text-transform:uppercase; letter-spacing:.05em; margin-bottom:10px; }
    .badge { display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:20px; font-size:13px; font-weight:500; }
    .badge-blue { background:rgba(59,130,246,.08); border:1px solid rgba(59,130,246,.2); color:#3b82f6; }
    .badge-gold { background:rgba(245,158,11,.08); border:1px solid rgba(245,158,11,.2); color:#d97706; }
    .action-container { display:flex; justify-content:center; align-items:center; gap:16px; margin-top:40px; flex-wrap:wrap; }
    .btn-recommend {
        background:#6366f1; color:#fff; padding:14px 28px; border-radius:8px;
        font-weight:600; text-decoration:none; display:inline-flex; align-items:center;
        gap:8px; font-size:14px; transition:background .2s; border:none; cursor:pointer;
    }
    .btn-recommend:hover { background:#4f46e5; }
    .btn-back-analyze {
        background:#fff; color:#374151; padding:14px 28px; border-radius:8px;
        font-weight:600; border:1px solid #d1d5db; display:inline-flex; align-items:center;
        gap:8px; font-size:14px; cursor:pointer; text-decoration:none; transition:background .2s;
    }
    .btn-back-analyze:hover { background:#f9fafb; }
    .action-footer-text { width:100%; text-align:center; font-size:13px; color:#888; margin-top:4px; }

    @media print {
        @page { size: A4 portrait; margin: 20mm 15mm; }
        body { background:#fff !important; color:#111827 !important; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important; }
        header,footer,.breadcrumb,.btn-download,.action-container,.secure-badge { display:none !important; }
        .container { max-width:100% !important; padding:0 !important; margin:0 !important; }
        .card { background:#fff !important; border:1px solid #d1d5db !important; page-break-inside:avoid; }
        .grid-top,.grid-bottom { display:grid !important; grid-template-columns:1fr 1fr !important; gap:20px !important; }
        .progress-bar-wrapper { background:#f3f4f6 !important; }
        .badge-blue { background:#eff6ff !important; border:1px solid #bfdbfe !important; color:#1e40af !important; }
        .badge-gold { background:#fffbeb !important; border:1px solid #fde68a !important; color:#92400e !important; }
    }
</style>
</head>
<body>

<?php include "header.php"; ?>

<main class="container">

    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <span>›</span>
        <a href="skin_analysis_entry.php">Analyze</a>
        <span>›</span>
        <span>Analysis Results</span>
    </div>

    <?php if (!$result): ?>
        <!-- NO RESULT YET -->
        <div style="text-align:center; padding:80px 20px;">
            <h2>No analysis found</h2>
            <p style="color:#888; margin-bottom:32px;">Please complete a face scan first to see your results.</p>
            <a href="skin_analysis_entry.php" class="btn-recommend">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                Start Face Analysis
            </a>
        </div>
    <?php else: ?>

    <div class="results-header-wrapper">
        <div>
            <h1 class="main-title">Analysis Results</h1>
            <p class="subtitle">Your personalized skin analysis powered by advanced AI technology.</p>
        </div>
        <button class="btn-download" onclick="window.print()">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download Report
        </button>
    </div>

    <div class="grid-top">
        <div class="card photo-box">
            <div class="card-title">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><circle cx="12" cy="13" r="3"/></svg>
                Your Photo
            </div>
            <div class="result-image-container">
                <?php if ($imageData): ?>
                    <img src="data:image/jpeg;base64,<?= $imageData ?>" class="result-image" alt="Skin Photo">
                <?php else: ?>
                    <img src="assets/images/default-face.jpg" class="result-image" alt="Skin Photo">
                <?php endif; ?>
            </div>
            <div class="secure-badge">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Image processed securely. Your privacy is our priority.
            </div>
        </div>

        <div class="card">
            <div class="card-title">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z"/><path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                Problem Overview
            </div>
            <div class="chart-box">
                <canvas id="problemChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid-bottom">
        <div class="card">
            <div class="card-title" style="justify-content:space-between; margin-bottom:24px;">
                <span style="display:flex; align-items:center; gap:10px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
                    Skin Concerns Breakdown
                </span>
                <span style="font-size:11px; color:#888; font-weight:normal;">Higher score = more concern</span>
            </div>
            <div class="breakdown-row">
                <div class="label-container"><span class="color-dot dot-acne"></span> Acne</div>
                <div class="progress-bar-wrapper"><div class="progress-fill bg-acne"></div></div>
                <div class="score-text"><span><?= $display_scores['acne'] ?></span> / 100</div>
            </div>
            <div class="breakdown-row">
                <div class="label-container"><span class="color-dot dot-darkspots"></span> Darkspots</div>
                <div class="progress-bar-wrapper"><div class="progress-fill bg-darkspots"></div></div>
                <div class="score-text"><span><?= $display_scores['darkspots'] ?></span> / 100</div>
            </div>
            <div class="breakdown-row">
                <div class="label-container"><span class="color-dot dot-redness"></span> Redness</div>
                <div class="progress-bar-wrapper"><div class="progress-fill bg-redness"></div></div>
                <div class="score-text"><span><?= $display_scores['redness'] ?></span> / 100</div>
            </div>
            <div class="breakdown-row">
                <div class="label-container"><span class="color-dot dot-wrinkles"></span> Wrinkles</div>
                <div class="progress-bar-wrapper"><div class="progress-fill bg-wrinkles"></div></div>
                <div class="score-text"><span><?= $display_scores['wrinkles'] ?></span> / 100</div>
            </div>
        </div>

        <div class="card">
            <div class="card-title">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Summary
            </div>
            <div class="summary-item">
                <label>Skin Type</label>
                <div class="badge badge-blue">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8z"/></svg>
                    <?= ucfirst($skintype) ?>
                </div>
            </div>
            <div class="summary-item">
                <label>Skin Tone</label>
                <div class="badge badge-gold">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <?= ucfirst($skintone) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="action-container">

        <a href="skin_analysis_entry.php?openModal=1" class="btn-back-analyze">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 000 4h6a2 2 0 000-4M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Fill Skin Profile & Product Review
        </a>

        <button id="recommendBtn" class="btn-recommend" onclick="handleRecommendClick()">
            View Recommended Products
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </button>

        <!-- Lock notice banner (hidden by default) -->
        <div id="lockNotice" style="
            display:none; margin-top:12px; padding:12px 18px;
            background:#fffbeb; border:1px solid #fde68a; border-radius:8px;
            color:#92400e; font-size:13px; text-align:center;
        ">
            ⚠️ Please complete your <strong>Skin Profile & Product Review</strong> first to unlock recommendations.
            <br><br>
            <button onclick="openModalToContinue()" style="
                background:#6366f1; color:#fff; border:none; padding:8px 18px;
                border-radius:6px; font-size:13px; font-weight:600; cursor:pointer; margin-top:4px;
            ">Complete Profile Now</button>
        </div>

        <div class="action-footer-text">
            Fill in your skin profile and check product compatibility before viewing recommendations.
        </div>
    </div>

    <?php endif; ?>

</main>

<?php include "footer.php"; ?>

<script>
<?php if ($result): ?>
const ctx = document.getElementById('problemChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'radar',
    data: {
        labels: ['Acne', 'Darkspots', 'Redness', 'Wrinkles'],
        datasets: [{
            label: 'Score',
            data: [<?= $display_scores['acne'] ?>, <?= $display_scores['darkspots'] ?>, <?= $display_scores['redness'] ?>, <?= $display_scores['wrinkles'] ?>],
            backgroundColor: 'rgba(50,147,243,0.25)',
            borderColor: '#3293f3',
            pointBackgroundColor: '#3293f3',
            pointBorderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            r: {
                grid: { color: 'rgba(0,0,0,0.08)' },
                angleLines: { color: 'rgba(0,0,0,0.08)' },
                pointLabels: { color: '#555', font: { size: 11, family: 'Inter', weight: '500' } },
                ticks: { backdropColor: 'transparent', color: '#888', stepSize: 20 },
                suggestedMin: 0, suggestedMax: 100
            }
        }
    }
});

window.onbeforeprint = () => {
    chart.data.datasets[0].borderColor = '#000';
    chart.data.datasets[0].backgroundColor = 'rgba(0,0,0,0.15)';
    chart.data.datasets[0].pointBackgroundColor = '#000';
    chart.options.scales.r.grid.color = '#666';
    chart.options.scales.r.angleLines.color = '#666';
    chart.options.scales.r.pointLabels.color = '#000';
    chart.options.scales.r.ticks.color = '#000';
    chart.update('none');
};
window.onafterprint = () => {
    chart.data.datasets[0].borderColor = '#3293f3';
    chart.data.datasets[0].backgroundColor = 'rgba(50,147,243,0.25)';
    chart.data.datasets[0].pointBackgroundColor = '#3293f3';
    chart.options.scales.r.grid.color = 'rgba(0,0,0,0.08)';
    chart.options.scales.r.angleLines.color = 'rgba(0,0,0,0.08)';
    chart.options.scales.r.pointLabels.color = '#555';
    chart.options.scales.r.ticks.color = '#888';
    chart.update('none');
};
<?php endif; ?>

const isComplete = sessionStorage.getItem('modal_complete') === '1';
const recommendBtn = document.getElementById('recommendBtn');
const lockNotice   = document.getElementById('lockNotice');

if (!isComplete) {
    recommendBtn.style.opacity = '0.5';
    recommendBtn.style.cursor  = 'not-allowed';
}

function handleRecommendClick() {
    if (sessionStorage.getItem('modal_complete') === '1') {
        window.location.href = 'recommend_entry.php';
    } else {
        lockNotice.style.display = 'block';
        lockNotice.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

function openModalToContinue() {
    window.location.href = 'skin_analysis_entry.php?openModal=1';
}
</script>

</body>
</html>
