<?php
session_start();

require_once __DIR__ . '/../app/controllers/SkinAnalysisController.php';

$controller = new SkinAnalysisController();
$controller->index();
