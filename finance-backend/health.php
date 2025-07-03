<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

header("Content-Type: application/json");
echo json_encode(["message" => "connected successfully"]);

try {
    // Check database connection
    require_once '../config/database-production.php';
    $database = new DatabaseConfig();
    $db = $database->getConnection();
    
    // Test query
    $query = "SELECT 1";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    // Response
    http_response_code(200);
    echo json_encode([
        "status" => "healthy",
        "message" => "Backend API is running",
        "database" => "connected",
        "timestamp" => date("Y-m-d H:i:s"),
        "version" => "1.0.0"
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Health check failed",
        "error" => $e->getMessage(),
        "timestamp" => date("Y-m-d H:i:s")
    ]);
}
?>
