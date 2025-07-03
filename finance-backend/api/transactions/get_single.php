<?php
header("Access-Control-Allow-Origin: https://ornate-nasturtium-e736ab.netlify.app");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

// Handle preflight OPTIONS request
if (<?php
// ✅ Set CORS and headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// ✅ Load database connection
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
SERVER['REQUEST_METHOD'] === 'OPTIONS') {
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
