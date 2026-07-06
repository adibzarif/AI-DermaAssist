<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
<title>Dashboard</title>
<link rel='stylesheet' href='../../assets/css/style.css'>
</head>

<body>

<header class='topbar'>
    <h1>Dashboard</h1>
    <nav>
        <a href="recommend.php">Products</a>
        <a href="compare.php">Compare</a>
        <a href="ingredient.php">Ingredient Check</a>
        <a href="history.php">History</a>
        <a href="../../logout.php">Logout</a>
    </nav>
</header>

<main class="container">
    <h2>Hello, <?= $_SESSION['user_name'] ?></h2>

    <a href="../../index.php" class="btn">Analyze Face</a>
</main>

</body>
</html>
