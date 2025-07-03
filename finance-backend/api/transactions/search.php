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
if (<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../../config/database.php';

// Check if search term is provided
if (!isset($_GET['search']) || empty($_GET['search'])) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => 'Search query is required'
    ]);
    exit();
}

$searchTerm = "%" . $_GET['search'] . "%";

try {
    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT * FROM transactions 
              WHERE category LIKE :search1 
              OR note LIKE :search2 
              ORDER BY date DESC";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':search1', $searchTerm);
    $stmt->bindParam(':search2', $searchTerm);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results && count($results) > 0) {
        http_response_code(200);
        echo json_encode($results);
    } else {
        http_response_code(404);
        echo json_encode([
            'error' => true,
            'message' => 'No transactions found matching your search'
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Search failed',
        'details' => $e->getMessage()
    ]);
}
?>
SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

header('Content-Type: application/json');
require_once '../../config/database.php';

// Check if search term is provided
if (!isset($_GET['search']) || empty($_GET['search'])) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => 'Search query is required'
    ]);
    exit();
}

$searchTerm = "%" . $_GET['search'] . "%";

try {
    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT * FROM transactions 
              WHERE category LIKE :search1 
              OR note LIKE :search2 
              ORDER BY date DESC";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':search1', $searchTerm);
    $stmt->bindParam(':search2', $searchTerm);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results && count($results) > 0) {
        http_response_code(200);
        echo json_encode($results);
    } else {
        http_response_code(404);
        echo json_encode([
            'error' => true,
            'message' => 'No transactions found matching your search'
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Search failed',
        'details' => $e->getMessage()
    ]);
}
?>
