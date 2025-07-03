<?php
header("Access-Control-Allow-Origin: https://ornate-nasturtium-e736ab.netlify.app");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
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
