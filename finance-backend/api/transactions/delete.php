<?php
header("Access-Control-Allow-Origin: https://ornate-nasturtium-e736ab.netlify.app");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

// Handle preflight OPTIONS request
if (<?php
// ✅ Set proper CORS and content headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type');

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
SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

header('Content-Type: application/json');
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
