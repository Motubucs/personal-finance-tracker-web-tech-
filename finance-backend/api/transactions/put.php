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
