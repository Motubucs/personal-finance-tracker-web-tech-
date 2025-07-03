<?php
header("Access-Control-Allow-Origin: https://personal-finance-tracker-web-tech-hkr06lvb1-motubucs-projects.vercel.app");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

header('Content-Type: application/json');

// ✅ Load DB config
require_once '../../config/database.php';

// ✅ Read input data
$data = json_decode(file_get_contents("php://input"));

// ✅ Validate required data
if (
    !isset($data->type) || 
    !isset($data->amount) || 
    !isset($data->category) || 
    !isset($data->date)
) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => 'Missing required fields: type, amount, category, date'
    ]);
    exit();
}

// ✅ Validate values
if (!in_array($data->type, ['income', 'expense'])) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => 'Invalid type. Must be income or expense'
    ]);
    exit();
}

if (!is_numeric($data->amount) || $data->amount <= 0) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => 'Amount must be a positive number'
    ]);
    exit();
}

try {
    $database = new Database();
    $db = $database->getConnection();

    // ✅ Prepare insert query
    $query = "INSERT INTO transactions (type, amount, category, note, date) VALUES (:type, :amount, :category, :note, :date)";
    $stmt = $db->prepare($query);

    // ✅ Bind parameters
    $note = $data->note ?? '';
    $stmt->bindParam(':type', $data->type);
    $stmt->bindParam(':amount', $data->amount);
    $stmt->bindParam(':category', $data->category);
    $stmt->bindParam(':note', $note);
    $stmt->bindParam(':date', $data->date);

    // ✅ Execute query
    if ($stmt->execute()) {
        $newId = $db->lastInsertId();
        
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Transaction created successfully',
            'id' => (int) $newId,
            'transaction' => [
                'id' => (int) $newId,
                'type' => $data->type,
                'amount' => (float) $data->amount,
                'category' => $data->category,
                'note' => $data->note ?? '',
                'date' => $data->date
            ]
        ]);
    } else {
        throw new Exception('Failed to execute insert statement');
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Failed to create transaction',
        'debug' => $e->getMessage()
    ]);
}
?>
