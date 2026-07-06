<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$loggedIn = isset($_SESSION['user_id']);
?>

<header class="topbar">
    <div class="nav-wrapper">

        <!-- TOP ROW -->
        <div class="nav-top">
            <div class="nav-left">
                <a href="index.php">AI-DermAssist</a> |
                <a href="index.php#customer-service">Customer Service</a> |
                <a href="index.php#faqs">FAQs</a>
            </div>

            <div class="nav-right">
                <?php if($loggedIn): ?>
                    <a href="profile.php">My Account</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login_signup.php">My Account</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- CENTER LOGO -->
        <div class="nav-logo">
            AI-DermaAssist
        </div>

        <!-- MENU -->
        <nav class="nav-menu">

            <a href="index.php">Home</a>
            
            <a href="skin_analysis_entry.php">Analyze</a>

            <!-- PRODUCTS WITH MEGA MENU -->
            <div class="nav-item">
                <a href="all_product.php">Products</a>

                <div class="mega-menu">

                    <div class="menu-col">
                        <h4>By Concern</h4>
                        <a href="all_product.php#acne">Acne</a>
                        <a href="all_product.php#wrinkles">Wrinkles</a>
                        <a href="all_product.php#dark Spots">Dark Spots</a>
                        <a href="all_product.php#redness">Redness</a>

                    </div>

                    <div class="menu-col">
                        <h4>By Skin Type</h4>
                        <a href="all_product.php#normal">Normal</a>
                        <a href="all_product.php#dry">Dry</a>
                        <a href="all_product.php#oily">Oily</a>
                        <a href="all_product.php#combination">Combination</a>
                    </div>
                    
                    <div class="menu-col">
                        <h4>By Skin Tone</h4>
                        <a href="all_product.php#light">Light</a>
                        <a href="all_product.php#mid-light">Mid-Light</a>
                        <a href="all_product.php#mid-dark">Mid-Dark</a>
                        <a href="all_product.php#dark">Dark</a>
                    </div>

                    

                </div>
            </div>

            <a href="productlist_compare.php">Compare Prices</a>
            <a href="ingredient_entry.php">Ingredient Check</a>

            <!-- SEARCH BAR -->
            <form class="search-bar" action="all_product.php#productSection" method="GET">
                <input type="text" name="search" 
       placeholder="Search product..." 
       value="<?= $_GET['search'] ?? '' ?>" 
       required>
                
       
                <button type="submit"></button>
            </form>

        </nav>
    </div>
</header>


<!-- SCROLL SCRIPT (UNCHANGED BUT CLEANED) -->
<script>
let lastScroll = 0;

window.addEventListener("scroll", () => {
    const navbar = document.querySelector(".topbar");
    const currentScroll = window.scrollY;

    if (currentScroll <= 0) {
        navbar.classList.remove("hide");
        return;
    }

    if (currentScroll > lastScroll) {
        navbar.classList.add("hide");
    } else {
        navbar.classList.remove("hide");
    }

    lastScroll = currentScroll;
});
</script>