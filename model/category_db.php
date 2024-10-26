<?php
class ProductDB {
    private $db; // Database connection

    public function __construct($db) {
        $this->db = $db; // Set the database connection
    }

    public function getProductsByCategory($categoryID) {
        // Prepare and execute the query
        $query = "SELECT * FROM products WHERE categoryID = :categoryID";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':categoryID', $categoryID);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Add other methods as needed
}


?>