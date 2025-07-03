<?php
class Transaction {
    private $conn;
    private $table = 'transactions';

    public $id;
    public $type;
    public $amount;
    public $category;
    public $note;
    public $date;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all transactions
    public function read() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get single transaction by ID
    public function read_single($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }

    // Create new transaction
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (type, amount, category, note, date)
                  VALUES (:type, :amount, :category, :note, :date)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':note', $this->note);
        $stmt->bindParam(':date', $this->date);

        return $stmt->execute();
    }

    // Update transaction
    public function update($id) {
        $query = "UPDATE " . $this->table . " SET
                  type = :type,
                  amount = :amount,
                  category = :category,
                  note = :note,
                  date = :date
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':note', $this->note);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Delete single transaction
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Delete all transactions
    public function delete_all() {
        $query = "DELETE FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }
}
?>
