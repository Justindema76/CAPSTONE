<?php
class ProductDB {   
    public static function getProductsByCategory($categoryID) {
        $db = Database::getDB();
        $category = CategoryDB::getCategory($categoryID);
        $query = 'SELECT categoryID, productID, productCode, productName, 
                     description, listPrice, discountPercent 
                  FROM products
                  WHERE categoryID = :categoryID
                  ORDER BY productID';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':categoryID', $categoryID);
            $statement->execute();
            
            $rows = $statement->fetchAll();
            $statement->closeCursor();
            
            $products = [];
            foreach ($rows as $row) {
                $products[] = self::loadProduct($row, $category);
            }
            return $products;
        } catch (PDOException $e) {
            Database::displayError($e->getMessage());
        }
    }
    
    // This method isn't used but shows how to use a join to get
    // product and category data with a single call to the database
    public static function getProducts() {
        $db = Database::getDB();
        $query = 'SELECT c.categoryID, categoryName, productID, productCode, 
                     productName, description, listPrice, discountPercent 
                  FROM products aS p
                  JOIN categories AS c
                  ON p.categoryID = c.categoryID
                  ORDER BY productID';
        try {
            $statement = $db->prepare($query);
            $statement->execute();
            
            $rows = $statement->fetchAll();
            $statement->closeCursor();
            
            $products = [];
            foreach ($rows as $row) {
                $category = new Category($row['categoryID'],
                                         $row['categoryName']);
                $products[] = self::loadProduct($row, $category);
            }
            return $products;
        } catch (PDOException $e) {
            Database::displayError($e->getMessage());
        }
    }
    
    private static function loadProduct($row, $category) {
        $product = new Product(
            $category,
            $row['productCode'],
            $row['productName'],
            $row['description'],
            $row['listPrice'],
            $row['discountPercent'],
            $row['stock'] ?? 0 // Ensure stock is handled
        );
        $product->setProductID($row['productID']);
        return $product;
    }
    

    public static function getProduct($productID) {
        $db = Database::getDB();
        $query = 'SELECT categoryID, productID, productCode, productName, 
                     description, listPrice, discountPercent, stock
                  FROM products
                  WHERE productID = :productID';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':productID', $productID);
            $statement->execute();
    
            $row = $statement->fetch();
            $statement->closeCursor();
    
            // Check if the row is not empty
            if ($row) {
                $category = CategoryDB::getCategory($row['categoryID']);
                return self::loadProduct($row, $category);
            }
            return null; // Return null if no product found
        } catch (PDOException $e) {
            Database::displayError($e->getMessage());
        }
    }
    

    public static function addProduct($product) {
        $db = Database::getDB();
        $query = 'INSERT INTO products
                    (categoryID, productCode, productName, description,
                     listPrice, discountPercent, dateAdded)
                 VALUES
                    (:categoryID, :productCode, :productName, :description, :listPrice,
                     :discountPercent, NOW())';
       try {
           $statement = $db->prepare($query);
           $statement->bindValue(':categoryID', 
                   $product->getCategory()->getID());
           $statement->bindValue(':productCode', $product->getCode());
           $statement->bindValue(':productName', $product->getName());
           $statement->bindValue(':description', $product->getDescription());
           $statement->bindValue(':listPrice', $product->getPrice());
           $statement->bindValue(':discountPercent', 
                   $product->getDiscountPercent());
           $statement->execute();
           $statement->closeCursor();

           // Get the last product ID that was automatically generated
           return $db->lastInsertId();
       } catch (PDOException $e) {
           Database::displayError($e->getMessage());
       }
    }
    
    public static function updateProduct($product) {
        $db = Database::getDB();
        $query = 'UPDATE Products
                  SET productName = :name, productCode = :code,
                      description = :description, listPrice = :listPrice,
                      discountPercent = :discountPercent,
                      categoryID = :categoryID
                  WHERE productID = :productID';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':categoryID', 
                   $product->getCategory()->getID());
            $statement->bindValue(':productCode', $product->getCode());
            $statement->bindValue(':productName', $product->getName());
            $statement->bindValue(':description', $product->getDescription());
            $statement->bindValue(':listPrice', $product->getPrice());
            $statement->bindValue(':discountPercent', 
                   $product->getDiscountPercent());
            $statement->bindValue(':productID', $product->getID());
            $statement->execute();
            
            $row_count = $statement->rowCount();
            $statement->closeCursor();
            return $row_count;
        } catch (PDOException $e) {
            Database::displayError($e->getMessage());
        }
    }
    
    public static function deleteProduct($productID) {
        $db = Database::getDB();
        $query = 'DELETE FROM products
                  WHERE productID = :productID';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':productID', $productID);
            $statement->execute();
            
            $row_count = $statement->rowCount();
            $statement->closeCursor();
            return $row_count;
        } catch (PDOException $e) {
            Database::displayError($e->getMessage());
        }
    }
}
?>