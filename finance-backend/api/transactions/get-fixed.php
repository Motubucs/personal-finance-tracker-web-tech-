<?php
$allowed_origins = [
    "https://personal-finance-tracker-web-tech-hkr06lvb1-motubucs-projects.vercel.app",
    "https://personal-finance-tracker-web-tech-91p0s6cj0-motubucs-projects.vercel.app",
    // Add your production domain if you have one
];
if (isset($_SERVER['HTTP_ORIGIN']) && preg_match('/^https:\/\/personal-finance-tracker-web-tech-[a-z0-9]+-motubucs-projects\\.vercel\\.app$/', $_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
} elseif (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

header('Content-Type: application/json');

// ✅ Database - Use production config if available
if (file_exists('../../config/database-production.php') && getenv('APP_ENV') === 'production') {
    require_once '../../config/database-production.php';
    $database = new DatabaseConfig();
    $db = $database->getConnection();
} else {
    require_once '../../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
}

try {
    $database = new Database();
    $db = $database->getConnection();

    // ✅ Get all transactions
    $query = "SELECT id, type, amount, category, note, date FROM transactions ORDER BY date DESC, id DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $transactions = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $transactions[] = [
            'id'       => (int) $row['id'],
            'type'     => $row['type'],
            'amount'   => (float) $row['amount'],
            'category' => $row['category'],
            'note'     => $row['note'],
            'date'     => $row['date']
        ];
    }

    http_response_code(200);
    echo json_encode(['transactions' => $transactions]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Failed to fetch transactions',
        'debug' => $e->getMessage()
    ]);
}
?>
