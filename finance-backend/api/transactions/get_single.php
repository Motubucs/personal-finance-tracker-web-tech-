<?php
$allowed_origins = [
    "https://personal-finance-tracker-web-tech-hkr06lvb1-motubucs-projects.vercel.app",
    "https://personal-finance-tracker-web-tech-91p0s6cj0-motubucs-projects.vercel.app",
    "https://personal-finance-tracker-web-tech.vercel.app",
    // Add your production domain if you have one
];
if (isset($_SERVER['HTTP_ORIGIN']) && preg_match('/^https:\/\/personal-finance-tracker-web-tech-[a-z0-9]+-motubucs-projects\\.vercel\\.app$/', $_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
} elseif (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

header('Content-Type: application/json');
require_once '../../config/database.php';

// ✅ Validate the ID from query string
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => 'Transaction ID is required and must be a number'
    ]);
    exit();
}

try {
    $database = new Database();
    $db = $database->getConnection();

    // ✅ Query to get one transaction
    $query = "SELECT id, type, amount, category, note, date FROM transactions WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $transaction = [
            'id'       => (int)$row['id'],
            'type'     => $row['type'],
            'amount'   => (float)$row['amount'],
            'category' => $row['category'],
            'note'     => $row['note'],
            'date'     => $row['date']
        ];

        http_response_code(200);
        echo json_encode($transaction);

    } else {
        http_response_code(404);
        echo json_encode([
            'error' => true,
            'message' => 'Transaction not found'
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
?>
