<div class="ml-64 p-8 bg-gray-100 min-h-screen">

<h1 class="text-2xl font-semibold mb-6">Dashboard</h1>

<!-- TOP CARDS -->
<div class="grid grid-cols-3 gap-6 mb-8">

    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-gray-500 text-sm">Total Users</p>
        <h2 class="text-2xl font-bold mt-2"><?= $totalUsers ?></h2>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-gray-500 text-sm">Total Products</p>
        <h2 class="text-2xl font-bold mt-2"><?= $totalProducts ?></h2>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-gray-500 text-sm">Total Analysis</p>
        <h2 class="text-2xl font-bold mt-2"><?= $totalAnalysis ?></h2>
    </div>

</div>

<!-- CHART + CARD -->
<div class="grid grid-cols-3 gap-6">

    <!-- CHART -->
    <div class="col-span-2 bg-white p-6 rounded-2xl shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Skin Problem Trend</h2>
        <canvas id="chart"></canvas>
    </div>

    <!-- SIDE CARD -->
    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white p-6 rounded-2xl shadow-sm flex flex-col justify-between">

        <div>
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                <i class="fa fa-chart-line text-white text-lg"></i>
            </div>

            <h3 class="text-lg font-semibold mb-2">Insights</h3>

            <p class="text-sm opacity-80 leading-relaxed mb-6">
                Monitor user skin trends and product performance across all sessions.
            </p>
        </div>

        <!-- STATS MINI ROW -->
        <div class="grid grid-cols-2 gap-3 mb-6">
            <div class="bg-white/15 rounded-xl p-3">
                <p class="text-xs opacity-70 mb-1">Users</p>
                <p class="text-xl font-bold"><?= $totalUsers ?></p>
            </div>
            <div class="bg-white/15 rounded-xl p-3">
                <p class="text-xs opacity-70 mb-1">Analysis</p>
                <p class="text-xl font-bold"><?= $totalAnalysis ?></p>
            </div>
        </div>

        <button
            onclick="openInsightsDrawer()"
            class="w-full bg-white text-blue-600 font-semibold text-sm py-2.5 rounded-xl
                   hover:bg-blue-50 active:scale-95 transition-all duration-150 flex items-center justify-center gap-2"
        >
            View Details
            <i class="fa fa-arrow-right text-xs"></i>
        </button>

    </div>

</div>

</div>

<!-- ===================== INSIGHTS DRAWER ===================== -->
<!-- BACKDROP -->
<div
    id="drawerBackdrop"
    onclick="closeInsightsDrawer()"
    class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0"
></div>

<!-- DRAWER PANEL -->
<div
    id="insightsDrawer"
    class="fixed top-0 right-0 h-full w-[420px] bg-white z-50 shadow-2xl
           translate-x-full transition-transform duration-300 ease-in-out
           flex flex-col overflow-hidden"
>
    <!-- HEADER -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 flex-shrink-0">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-blue-100 text-xs font-medium uppercase tracking-widest mb-1">Dashboard</p>
                <h2 class="text-white text-xl font-bold">Insights Overview</h2>
            </div>
            <button
                onclick="closeInsightsDrawer()"
                class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition"
            >
                <i class="fa fa-times text-white text-sm"></i>
            </button>
        </div>
    </div>

    <!-- SCROLLABLE CONTENT -->
    <div class="flex-1 overflow-y-auto p-6 space-y-5 bg-gray-50">

        <!-- STAT CARDS -->
        <div class="grid grid-cols-3 gap-3">

            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">
                <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <i class="fa fa-users text-blue-500 text-sm"></i>
                </div>
                <p class="text-2xl font-bold text-gray-800"><?= $totalUsers ?></p>
                <p class="text-[11px] text-gray-400 mt-0.5">Users</p>
            </div>

            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">
                <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <i class="fa fa-box text-purple-500 text-sm"></i>
                </div>
                <p class="text-2xl font-bold text-gray-800"><?= $totalProducts ?></p>
                <p class="text-[11px] text-gray-400 mt-0.5">Products</p>
            </div>

            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">
                <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <i class="fa fa-microscope text-green-500 text-sm"></i>
                </div>
                <p class="text-2xl font-bold text-gray-800"><?= $totalAnalysis ?></p>
                <p class="text-[11px] text-gray-400 mt-0.5">Analysis</p>
            </div>

        </div>

        <!-- SKIN PROBLEM BREAKDOWN -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-50 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                <h3 class="text-sm font-semibold text-gray-700">Skin Problem Breakdown</h3>
            </div>

            <div class="p-5 space-y-4" id="drawerProblemList">
                <?php
                // Reuse $trend data already fetched by DashboardController
                if(!empty($trend)):
                    // find max for bar width
                    $maxVal = max(array_column($trend, 'total'));
                    $colors = ['bg-blue-400','bg-indigo-400','bg-violet-400','bg-sky-400','bg-cyan-400','bg-teal-400'];
                    $i = 0;
                    foreach($trend as $t):
                        $pct = $maxVal > 0 ? round(($t['total'] / $maxVal) * 100) : 0;
                        $color = $colors[$i % count($colors)];
                        $i++;
                ?>
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-[13px] text-gray-600 capitalize"><?= htmlspecialchars($t['problem']) ?></span>
                        <span class="text-[13px] font-semibold text-gray-800"><?= $t['total'] ?></span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div
                            class="h-full <?= $color ?> rounded-full transition-all duration-700"
                            style="width: <?= $pct ?>%"
                        ></div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <p class="text-sm text-gray-400 text-center py-4">No trend data available.</p>
                <?php endif; ?>
            </div>

        </div>

        <!-- QUICK LINKS -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-50 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                <h3 class="text-sm font-semibold text-gray-700">Quick Navigation</h3>
            </div>

            <div class="p-3 grid grid-cols-2 gap-2">

                <a href="index.php?page=userManagement"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition group">
                    <div class="w-8 h-8 bg-blue-50 group-hover:bg-blue-100 rounded-lg flex items-center justify-center transition">
                        <i class="fa fa-users text-blue-500 text-xs"></i>
                    </div>
                    <span class="text-[13px] text-gray-600 font-medium">Users</span>
                </a>

                <a href="index.php?page=products"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition group">
                    <div class="w-8 h-8 bg-purple-50 group-hover:bg-purple-100 rounded-lg flex items-center justify-center transition">
                        <i class="fa fa-box text-purple-500 text-xs"></i>
                    </div>
                    <span class="text-[13px] text-gray-600 font-medium">Products</span>
                </a>

                <a href="index.php?page=userHistory"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition group">
                    <div class="w-8 h-8 bg-green-50 group-hover:bg-green-100 rounded-lg flex items-center justify-center transition">
                        <i class="fa fa-clock-rotate-left text-green-500 text-xs"></i>
                    </div>
                    <span class="text-[13px] text-gray-600 font-medium">Analysis History</span>
                </a>

                <a href="index.php?page=shoppingListHistory"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition group">
                    <div class="w-8 h-8 bg-amber-50 group-hover:bg-amber-100 rounded-lg flex items-center justify-center transition">
                        <i class="fa fa-bag-shopping text-amber-500 text-xs"></i>
                    </div>
                    <span class="text-[13px] text-gray-600 font-medium">Shopping History</span>
                </a>

                <a href="index.php?page=ingredients"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition group">
                    <div class="w-8 h-8 bg-rose-50 group-hover:bg-rose-100 rounded-lg flex items-center justify-center transition">
                        <i class="fa fa-flask text-rose-500 text-xs"></i>
                    </div>
                    <span class="text-[13px] text-gray-600 font-medium">Ingredients</span>
                </a>

                <a href="index.php?page=productPrice"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition group">
                    <div class="w-8 h-8 bg-teal-50 group-hover:bg-teal-100 rounded-lg flex items-center justify-center transition">
                        <i class="fa fa-store text-teal-500 text-xs"></i>
                    </div>
                    <span class="text-[13px] text-gray-600 font-medium">Stores</span>
                </a>

            </div>
        </div>

    </div>

    <!-- FOOTER -->
    <div class="p-4 border-t border-gray-100 bg-white flex-shrink-0">
        <button
            onclick="closeInsightsDrawer()"
            class="w-full py-2.5 rounded-xl border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition"
        >
            Close
        </button>
    </div>

</div>
<!-- ===================== END DRAWER ===================== -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// ===== CHART =====
const data = <?= json_encode($trend) ?>;
const labels = data.map(d => d.problem);
const values = data.map(d => d.total);

new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Cases',
            data: values,
            backgroundColor: 'rgba(59,130,246,0.15)',
            borderColor: 'rgba(59,130,246,0.8)',
            borderWidth: 2,
            borderRadius: 8,
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' } },
            x: { grid: { display: false } }
        }
    }
});

// ===== DRAWER =====
function openInsightsDrawer(){
    const drawer   = document.getElementById('insightsDrawer');
    const backdrop = document.getElementById('drawerBackdrop');

    backdrop.classList.remove('hidden');
    requestAnimationFrame(() => {
        backdrop.classList.remove('opacity-0');
        drawer.classList.remove('translate-x-full');
    });

    document.body.style.overflow = 'hidden';
}

function closeInsightsDrawer(){
    const drawer   = document.getElementById('insightsDrawer');
    const backdrop = document.getElementById('drawerBackdrop');

    drawer.classList.add('translate-x-full');
    backdrop.classList.add('opacity-0');

    setTimeout(() => {
        backdrop.classList.add('hidden');
        document.body.style.overflow = '';
    }, 300);
}

// ESC key closes drawer
document.addEventListener('keydown', e => {
    if(e.key === 'Escape') closeInsightsDrawer();
});
</script>