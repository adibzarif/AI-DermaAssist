<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Analysis.php';

class DashboardController {

    public function index(){

        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalAnalysis = Analysis::count();

        $trend = Analysis::getTrend();

        include __DIR__ . '/../views/dashboard.php';
    }
}