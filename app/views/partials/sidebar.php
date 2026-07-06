<?php $page = $_GET['page'] ?? 'profile'; ?>

<div class="sidebar">

    <div class="sidebar-logo">AI DermaAssist</div>

    <div class="back-home">
        <a href="index.php">
            <i class="fa fa-arrow-left"></i> Back to Home
        </a>
    </div>

    <div class="sidebar-divider"></div>

    <div class="sidebar-user">
        <div class="sidebar-avatar"><?= strtoupper(substr($user['name'],0,1)) ?></div>
        <div>
            <div class="sidebar-name"><?= $user['name'] ?></div>
            <div class="sidebar-email"><?= $user['email'] ?></div>
        </div>
    </div>

    <div class="sidebar-divider"></div>

    <div class="menu-label">Account</div>

    <div class="menu">

        <a href="profile.php?page=profile" class="<?= $page=='profile' ? 'active' : '' ?>">
            <i class="fa fa-user"></i>
            My Profile
        </a>

        <a href="profile.php?page=history" class="<?= $page=='history' ? 'active' : '' ?>">
            <i class="fa fa-chart-line"></i>
            Analysis History
        </a>

        <a href="profile.php?page=wishlist" class="<?= $page=='wishlist' ? 'active' : '' ?>">
            <i class="fa fa-heart"></i>
            Favourite Product
        </a>

        <a href="profile.php?page=shoppinglist" class="<?= $page=='shoppinglist' ? 'active' : '' ?>">
            <i class="fa fa-bag-shopping"></i>
            Shopping List
        </a>

    </div>

    <div class="logout">
        <a href="logout.php">
            <i class="fa fa-sign-out-alt"></i>
            Logout
        </a>
    </div>

</div>