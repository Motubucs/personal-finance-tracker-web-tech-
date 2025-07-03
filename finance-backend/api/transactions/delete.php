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
header("Access-Control-Allow-Credentials: true");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

// ✅ Include DB connection
require_once '../../config/database.php';

// ✅ Get raw input and decode
$input = json_decode(file_get_contents('php://input'), true);

// ✅ Validate input
if (!isset($input['id']) || !is_numeric($input['id'])) {
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

    // ✅ Check if transaction exists
    $check_query = "SELECT id FROM transactions WHERE id = :id";
    $check_stmt = $db->prepare($check_query);
    $check_stmt->bindParam(':id', $input['id'], PDO::PARAM_INT);
    $check_stmt->execute();

    if ($check_stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode([
            'error' => true,
            'message' => 'Transaction not found'
        ]);
        exit();
    }

    // ✅ Delete transaction
    $query = "DELETE FROM transactions WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $input['id'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Transaction deleted successfully'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'error' => true,
            'message' => 'Failed to delete transaction'
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
