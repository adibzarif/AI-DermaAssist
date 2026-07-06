<?php
// config.php - DB and app settings
return [
    'db' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'name' => getenv('DB_NAME') ?: 'skin_fyp',
        'user' => getenv('DB_USER') ?: 'root',
        'pass' => getenv('DB_PASS') ?: ''
    ],
    'flask_api' => [
        'url' => getenv('FLASK_API_URL') ?: 'http://127.0.0.1:5000/predict'
    ],
    'uploads_dir' => __DIR__ . '/../../public/uploads'
];
?>