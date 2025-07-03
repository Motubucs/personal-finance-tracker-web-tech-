<?php
header("Access-Control-Allow-Origin: https://ornate-nasturtium-e736ab.netlify.app");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

// Handle preflight OPTIONS request
if (<?php
// ✅ CORS and headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// ✅ DB config
require_once '../../config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    // ✅ Delete all rows in transactions table
    $query = "DELETE FROM transactions";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $count = $stmt->rowCount();

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => "$count transaction(s) deleted"
    ]);

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

try {
    $database = new Database();
    $db = $database->getConnection();

    // ✅ Delete all rows in transactions table
    $query = "DELETE FROM transactions";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $count = $stmt->rowCount();

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => "$count transaction(s) deleted"
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
?>
