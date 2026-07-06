<?php
require_once __DIR__ . '/../models/Analysis.php';
require_once __DIR__ . '/../services/AiService.php';
require_once __DIR__ . '/../helpers/Database.php';

class AnalyzeController {

    private $model;
    private $ai;

    public function __construct() {
        $config     = include __DIR__ . '/../config/config.php';
        $this->model = new Analysis();
        $this->ai    = new AiService($config['flask_api']['url']);
    }

    // ── POST: receive image, run AI, return JSON ───────────
    public function analyze() {
        header('Content-Type: application/json');

        $dir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $filename = uniqid('img_') . '_' . basename($_FILES['image']['name']);
        $path     = $dir . $filename;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
            echo json_encode(['error' => 'Image upload failed.']);
            exit;
        }

        $result = $this->ai->analyzeImage($path);

        if (isset($result['error'])) {
            $errorMsg = 'AI Error: ' . $result['error'];
            if (isset($result['detail'])) {
                $errorMsg .= ' (' . $result['detail'] . ')';
            }
            if (isset($result['raw'])) {
                $errorMsg .= ' [Raw: ' . substr(strip_tags($result['raw']), 0, 200) . ']';
            }
            echo json_encode(['error' => $errorMsg]);
            exit;
        }

        // Normalize scores to lowercase keys
        $scaled_scores = [];
        foreach ($result['problem_scores'] as $k => $v) {
            $scaled_scores[strtolower($k)] = round($v * 100);
        }
        $result['problem_scores_scaled'] = $scaled_scores;

        $problem  = strtolower(array_keys($result['problem_scores'], max($result['problem_scores']))[0]);
        $skintype = array_keys($result['skintype_scores'], max($result['skintype_scores']))[0];
        $skintone = array_keys($result['skintone_scores'], max($result['skintone_scores']))[0];

        $imageData = base64_encode(file_get_contents($path));

        // Save to session
        $_SESSION['latest_analysis'] = $result;
        $_SESSION['latest_image']    = $imageData;

        if (isset($_SESSION['user_id'])) {
            $this->model->saveAnalysis($_SESSION['user_id'], $problem, $skintype, $skintone, $result);
        } else {
            $_SESSION['pending_scan'] = [
                'problem'     => $problem,
                'skintype'    => $skintype,
                'skintone'    => $skintone,
                'result_json' => $result,
                'image'       => $imageData,
            ];
        }

        echo json_encode($result);
        exit;
    }

    // ── GET: show result page ──────────────────────────────
    public function index() {
        $result    = $_SESSION['latest_analysis'] ?? $_SESSION['pending_scan']['result_json'] ?? null;
        $imageData = $_SESSION['latest_image']    ?? $_SESSION['pending_scan']['image']       ?? null;

        // Normalize scores if missing
        if ($result && isset($result['problem_scores']) && !isset($result['problem_scores_scaled'])) {
            foreach ($result['problem_scores'] as $k => $v) {
                $result['problem_scores_scaled'][strtolower($k)] = round($v * 100);
            }
        }

        $scaled   = $result['problem_scores_scaled'] ?? [];
        $skintype = isset($result['skintype_scores'])
            ? array_keys($result['skintype_scores'], max($result['skintype_scores']))[0]
            : 'unknown';
        $skintone = isset($result['skintone_scores'])
            ? array_keys($result['skintone_scores'], max($result['skintone_scores']))[0]
            : 'unknown';

        $display_scores = [
            'acne'      => $scaled['acne']      ?? 0,
            'darkspots' => $scaled['darkspots'] ?? 0,
            'redness'   => $scaled['redness']   ?? 0,
            'wrinkles'  => $scaled['wrinkles']  ?? 0,
        ];

        require __DIR__ . '/../views/analyze.php';
    }
}
