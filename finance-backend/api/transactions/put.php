<?php
header("Access-Control-Allow-Origin: https://ornate-nasturtium-e736ab.netlify.app");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

// Handle preflight OPTIONS request
if (<?php
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

// ✅ Include database
require_once '../../config/database.php';

// ✅ Read input
$data = json_decode(file_get_contents("php://input"));

// ✅ Validate input
if (
    !isset($data->id) ||
    !isset($data->type) ||
    !isset($data->amount) ||
    !isset($data->category) ||
    !isset($data->date)
) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => 'Missing required fields: id, type, amount, category, date'
    ]);
    exit();
}

// ✅ Assign variables
$id       = (int) $data->id;
$type     = trim($data->type);
$amount   = (float) $data->amount;
$category = trim($data->category);
$note     = isset($data->note) ? trim($data->note) : null;
$date     = trim($data->date);

// ✅ Validate type
if (!in_array($type, ['income', 'expense'])) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => 'Invalid transaction type. Must be income or expense.'
    ]);
    exit();
}

try {
    $database = new Database();
    $db = $database->getConnection();

    // ✅ Prepare update statement
    $query = "UPDATE transactions 
              SET type = :type, amount = :amount, category = :category, note = :note, date = :date 
              WHERE id = :id";

    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':note', $note);
    $stmt->bindParam(':date', $date);

    $stmt->execute();

    // ✅ Check result
    if ($stmt->rowCount() > 0) {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Transaction updated successfully'
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            'error' => true,
            'message' => 'Transaction not found or no change made'
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Failed to update transaction'
        // 'details' => $e->getMessage() // Uncomment for debugging
    ]);
}
?>
SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

header('Content-Type: application/json');
$_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

header('Content-Type: application/json');

// ✅ Include database
require_once '../../config/database.php';

// ✅ Read input
$data = json_decode(file_get_contents("php://input"));

// ✅ Validate input
if (
    !isset($data->id) ||
    !isset($data->type) ||
    !isset($data->amount) ||
    !isset($data->category) ||
    !isset($data->date)
) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => 'Missing required fields: id, type, amount, category, date'
    ]);
    exit();
}

// ✅ Assign variables
$id       = (int) $data->id;
$type     = trim($data->type);
$amount   = (float) $data->amount;
$category = trim($data->category);
$note     = isset($data->note) ? trim($data->note) : null;
$date     = trim($data->date);

// ✅ Validate type
if (!in_array($type, ['income', 'expense'])) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => 'Invalid transaction type. Must be income or expense.'
    ]);
    exit();
}

try {
    $database = new Database();
    $db = $database->getConnection();

    // ✅ Prepare update statement
    $query = "UPDATE transactions 
              SET type = :type, amount = :amount, category = :category, note = :note, date = :date 
              WHERE id = :id";

    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':note', $note);
    $stmt->bindParam(':date', $date);

    $stmt->execute();

    // ✅ Check result
    if ($stmt->rowCount() > 0) {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Transaction updated successfully'
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            'error' => true,
            'message' => 'Transaction not found or no change made'
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Failed to update transaction'
        // 'details' => $e->getMessage() // Uncomment for debugging
    ]);
}
?>
