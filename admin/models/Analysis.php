<?php
require_once __DIR__ . '/../config/database.php';

class Analysis {

    public static function count(){
        return Database::connect()
            ->query("SELECT COUNT(*) as total FROM analysis_history")
            ->fetch_assoc()['total'];
    }

    public static function getTrend() {
        $db = Database::connect();
        $res = $db->query("
            SELECT problem, COUNT(*) as total
            FROM analysis_history
            GROUP BY problem
        ");

        $data = [];
        while($row = $res->fetch_assoc()){
            $data[] = $row;
        }

        return $data;
    }
}