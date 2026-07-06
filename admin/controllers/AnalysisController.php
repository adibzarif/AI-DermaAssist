<?php
require_once __DIR__ . '/../models/Analysis.php';

class AnalysisController {

    public function index(){
        $db = Database::connect();

        $res = $db->query("SELECT * FROM analysis_history");

        include __DIR__ . '/../views/analysis.php';
    }
}