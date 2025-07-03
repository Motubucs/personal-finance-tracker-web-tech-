<?php
// Database configuration for production deployment
class DatabaseConfig {
    // Use environment variables for production
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    
    public function __construct() {
        // Check if we're in production (Railway, Render, etc.)
        if (isset($_ENV['DATABASE_URL'])) {
            // Parse DATABASE_URL (common in cloud platforms)
            $url = parse_url($_ENV['DATABASE_URL']);
            $this->host = $url['host'];
            $this->db_name = ltrim($url['path'], '/');
            $this->username = $url['user'];
            $this->password = $url['pass'];
            $this->port = $url['port'] ?? 3306;
        } else {
            // Local development fallback
            $this->host = $_ENV['DB_HOST'] ?? 'localhost';
            $this->db_name = $_ENV['DB_NAME'] ?? 'personal_finance_tracker';
            $this->username = $_ENV['DB_USERNAME'] ?? 'root';
            $this->password = $_ENV['DB_PASSWORD'] ?? '';
            $this->port = $_ENV['DB_PORT'] ?? 3306;
        }
    }
    
    public function getConnection() {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4";
            
            $pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            
            return $pdo;
        } catch(PDOException $exception) {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => 'Database connection failed',
                'details' => $_ENV['APP_DEBUG'] ? $exception->getMessage() : 'Internal server error'
            ]);
            exit();
        }
    }
}
?>
