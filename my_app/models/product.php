<?php
class Product {
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $price;
    public $quantity;
    public $description; // Properti baru

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new product
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, price=:price, quantity=:quantity, description=:description";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":description", $this->description);

        return $stmt->execute();
    }

    // Read all products
    public function read() {
        $query = "SELECT id, name, price, quantity, description FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update a product
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name=:name, price=:price, quantity=:quantity, description=:description WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // Delete a product
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    // Get a single product by ID
    public function getProductById($id) {
        $query = "SELECT id, name, price, quantity, description FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
