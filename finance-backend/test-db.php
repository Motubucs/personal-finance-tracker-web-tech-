<?php
// Simple database connection test
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$host = 'localhost';
$dbname = 'personal_finance_tracker';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Database connection successful!\n\n";
    
    // Test if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'transactions'");
    if ($stmt->rowCount() > 0) {
        echo "✅ 'transactions' table exists!\n\n";
        
        // Get all transactions
        $stmt = $pdo->query("SELECT * FROM transactions ORDER BY created_at DESC");
        $transactions = $stmt->fetchAll();
        
        echo "📊 Current transactions in database:\n";
        echo "Total count: " . count($transactions) . "\n\n";
        
        foreach ($transactions as $transaction) {
            echo sprintf(
                "ID: %d | Type: %s | Amount: $%.2f | Category: %s | Description: %s | Date: %s | Created: %s\n",
                $transaction['id'],
                $transaction['type'],
                $transaction['amount'],
                $transaction['category'],
                $transaction['note'] ?? 'None',
                $transaction['date'],
                $transaction['created_at']
            );
        }
    } else {
        echo "❌ 'transactions' table does not exist!";
    }
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage();
}
?>
