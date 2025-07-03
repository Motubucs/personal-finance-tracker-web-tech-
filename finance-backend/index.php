<?php
// Simple index file for Railway deployment
echo "Personal Finance Tracker API - Backend is running!";

// Basic health check
if (isset($_GET['health'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'healthy',
        'timestamp' => date('Y-m-d H:i:s'),
        'message' => 'API is working'
    ]);
}
?>
