<?php $page = $_GET['page'] ?? 'dashboard'; ?>

<div class="w-64 h-screen bg-[#111c2e] text-slate-300 fixed flex flex-col shadow-xl">

<!-- LOGO -->
<div class="px-4 py-4 border-b border-[#1f2a44]">

    <div class="flex items-center">

        <!-- LOGO -->
        <img
            src="assets/logo.png"
            alt="AI-DermaAssist"
            class="w-[42px] h-[42px] object-contain"
        >

        <!-- LINE -->
        <div class="w-[1px] h-[36px] bg-[#3a4663] mx-3 opacity-60"></div>

        <!-- TEXT -->
        <h1 class="text-white text-[18px] font-semibold tracking-wide">
            AI-DermaAssist
        </h1>

    </div>

</div>

<!-- MENU -->
<nav class="flex-1 px-3 py-4 space-y-1 text-sm overflow-y-auto">

<!-- ================= DASHBOARD ================= -->
<a href="index.php"
class="flex items-center gap-3 px-4 py-3 rounded-lg transition relative
<?= $page=='dashboard' ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?>">
    
    <i class="fas fa-home w-5"></i>
    <span>Dashboard</span>

    <?php if($page=='dashboard'): ?>
    <div class="absolute left-0 top-0 h-full w-1 bg-blue-500 rounded-r"></div>
    <?php endif; ?>
</a>

<!-- ================= PRODUCT DROPDOWN ================= -->
<?php 
$isProductPage = (
    $page=='products' || 
    $page=='productSkinProblem' || 
    $page=='productSkinType' || 
    $page=='productSkinTone'
);
?>

<div>
<button onclick="toggleProductMenu()" 
class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition relative
<?= $isProductPage ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?>">

    <div class="flex items-center gap-3">
        <i class="fas fa-box w-5"></i>
        <span>Product</span>
    </div>

    <span id="productIcon"><?= $isProductPage ? '-' : '+' ?></span>

    <?php if($isProductPage): ?>
    <div class="absolute left-0 top-0 h-full w-1 bg-blue-500 rounded-r"></div>
    <?php endif; ?>
</button>

<div id="productMenu" class="<?= $isProductPage ? '' : 'hidden' ?> ml-6 mt-1 space-y-1">

    <a href="index.php?page=products"
    class="block px-4 py-2 rounded-lg <?= $page=='products' ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?>">
        Product Management
    </a>

    <a href="index.php?page=productSkinProblem"
    class="block px-4 py-2 rounded-lg <?= $page=='productSkinProblem' ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?>">
        Product Skin Problem
    </a>

    <a href="index.php?page=productSkinType"
    class="block px-4 py-2 rounded-lg <?= $page=='productSkinType' ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?>">
        Product Skin Type
    </a>

    <a href="index.php?page=productSkinTone"
    class="block px-4 py-2 rounded-lg <?= $page=='productSkinTone' ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?>">
        Product Skin Tone
    </a>

</div>
</div>

<!-- ================= PRODUCT PRICE ================= -->
<a href="index.php?page=productPrice"
class="flex items-center gap-3 px-4 py-3 rounded-lg transition relative
<?= $page=='productPrice' ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?>">
    
    <i class="fas fa-store w-5"></i>
    <span>Store</span>

    <?php if($page=='productPrice'): ?>
    <div class="absolute left-0 top-0 h-full w-1 bg-blue-500 rounded-r"></div>
    <?php endif; ?>
</a>

<!-- ================= INGREDIENTS DROPDOWN ================= -->
<?php 
$isIngredientPage = ($page=='ingredients' || $page=='productIngredients');
?>

<div>
<button onclick="toggleIngredientMenu()" 
class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition relative
<?= $isIngredientPage ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?>">

    <div class="flex items-center gap-3">
        <i class="fas fa-vial w-5"></i>
        <span>Ingredients</span>
    </div>

    <span id="ingredientIcon"><?= $isIngredientPage ? '-' : '+' ?></span>

    <?php if($isIngredientPage): ?>
    <div class="absolute left-0 top-0 h-full w-1 bg-blue-500 rounded-r"></div>
    <?php endif; ?>
</button>

<div id="ingredientMenu" class="<?= $isIngredientPage ? '' : 'hidden' ?> ml-6 mt-1 space-y-1">

    <a href="index.php?page=ingredients"
    class="<?= $page=='ingredients' ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?> block px-4 py-2 rounded-lg">
        Ingredient Management
    </a>

    <a href="index.php?page=productIngredients"
    class="<?= $page=='productIngredients' ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?> block px-4 py-2 rounded-lg">
        Product Ingredient
    </a>

</div>
</div>

<!-- ================= USERS DROPDOWN ================= -->
<?php 
$isUserPage = ($page=='userManagement' || $page=='userHistory' || $page=='shoppingListHistory');
?>

<div>
<button onclick="toggleUserMenu()" 
class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition relative
<?= $isUserPage ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?>">

    <div class="flex items-center gap-3">
        <i class="fas fa-users w-5"></i>
        <span>Users</span>
    </div>

    <span id="userIcon"><?= $isUserPage ? '-' : '+' ?></span>

    <?php if($isUserPage): ?>
    <div class="absolute left-0 top-0 h-full w-1 bg-blue-500 rounded-r"></div>
    <?php endif; ?>
</button>

<div id="userMenu" class="<?= $isUserPage ? '' : 'hidden' ?> ml-6 mt-1 space-y-1">

    <a href="index.php?page=userManagement"
    class="<?= $page=='userManagement' ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?> block px-4 py-2 rounded-lg">
        User Management
    </a>

    <a href="index.php?page=userHistory"
    class="<?= $page=='userHistory' ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?> block px-4 py-2 rounded-lg">
        User Analysis History
    </a>

    <a href="index.php?page=shoppingListHistory"
    class="<?= $page=='shoppingListHistory' ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' ?> block px-4 py-2 rounded-lg">
        Shopping List History
    </a>

</div>
</div>

</nav>

<!-- ================= LOGOUT ================= -->
<div class="px-3 pb-3">
    <a
        href="../../public/logout.php"
        onclick="return confirm('Are you sure you want to logout?')"
        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm text-red-400
               hover:bg-red-500/10 hover:text-red-300 transition w-full"
    >
        <i class="fas fa-right-from-bracket w-5"></i>
        <span>Logout</span>
    </a>
</div>

<!-- FOOTER -->
<div class="px-4 py-3 text-xs text-gray-600 border-t border-[#1f2a44]">
    © 2026 AI-DermaAssist
</div>

</div>

<!-- ================= JS ================= -->
<script>

function toggleProductMenu(){
    const menu = document.getElementById('productMenu');
    const icon = document.getElementById('productIcon');
    menu.classList.toggle('hidden');
    icon.innerText = menu.classList.contains('hidden') ? '+' : '-';
}

function toggleIngredientMenu(){
    const menu = document.getElementById('ingredientMenu');
    const icon = document.getElementById('ingredientIcon');
    menu.classList.toggle('hidden');
    icon.innerText = menu.classList.contains('hidden') ? '+' : '-';
}

function toggleUserMenu(){
    const menu = document.getElementById('userMenu');
    const icon = document.getElementById('userIcon');
    menu.classList.toggle('hidden');
    icon.innerText = menu.classList.contains('hidden') ? '+' : '-';
}

</script>