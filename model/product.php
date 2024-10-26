<?php
class Product {
    private int $id;
    private int $stock;

    public function __construct(
        private Category $category,
        private string $productCode,
        private string $productName,
        private string $productDescription,
        private float $productPrice,
        private float $productDiscountPercent,
        int $stock  // Stock added to constructor
    ) {
        $this->stock = $stock;  // Initialize stock in the constructor
    }

    // Getters and setters for stock
    public function getStock(): int {
        return $this->stock;
    }

    public function setStock(int $stock): void {
        $this->stock = $stock;
    }

    // Getters and setters for category
    public function getCategory(): Category {
        return $this->category;
    }

    public function setCategory(Category $category): void {
        $this->category = $category;
    }

    // Getters and setters for ID
    public function getProductID(): int {
        return $this->id;
    }

    public function setProductID(int $id): void {
        $this->id = $id;
    }

    // Getters and setters for product code
    public function getProductCode(): string {
        return $this->productCode;
    }

    public function setProductCode(string $productCode): void {
        $this->productCode = $productCode;
    }

    // Getters and setters for product name
    public function getProductName(): string {
        return $this->productName;
    }

    public function setProductName(string $productName): void {
        $this->productName = $productName;
    }

    // Getters and setters for product description
    public function getProductDescription(): string {
        return $this->productDescription;
    }

    public function setProductDescription(string $productDescription): void {
        $this->productDescription = $productDescription;
    }

    // Getters and setters for product price
    public function getProductPrice(): float {
        return $this->productPrice;
    }

    public function getProductPriceFormatted(): string {
        return number_format($this->productPrice, 2);
    }

    public function setProductPrice(float $productPrice): void {
        $this->productPrice = $productPrice;
    }

    // Getters and setters for discount percent
    public function getProductDiscountPercent(): float {
        return $this->productDiscountPercent;
    }

    public function getProductDiscountPercentFormatted(): string {
        return number_format($this->productDiscountPercent, 0);
    }

    public function setProductDiscountPercent(float $productDiscountPercent): void {
        $this->productDiscountPercent = $productDiscountPercent;
    }

    // Calculate the discount amount
    public function getProductDiscountAmount(): float {
        $discountPercent = $this->getProductDiscountPercent() / 100;
        return $this->productPrice * $discountPercent;
    }

    public function getProductDiscountAmountFormatted(): string {
        return number_format(round($this->getProductDiscountAmount(), 2), 2);
    }

    // Calculate the price after discount
    public function getProductDiscountPrice(): float {
        return $this->productPrice - $this->getProductDiscountAmount();
    }

    public function getProductDiscountPriceFormatted(): string {
        return number_format($this->getProductDiscountPrice(), 2);
    }

    // Image-related methods
    public function getProductImageFilename(): string {
        return $this->productCode . '_m.png';
    }

    public function getProductImagePath(string $appPath): string {
        return $appPath . 'images/' . $this->getProductImageFilename();
    }

    public function getProductImageAltText(): string {
        return 'Image: ' . $this->getProductImageFilename();
    }

    // Retrieve product description for additional uses
    public function getDescription(): string {
        return $this->productDescription;
    }
    public function getCategoryID() {
        return $this->category->getCategoryID(); // Adjust if your category object structure is different
    }

    
}
?>
