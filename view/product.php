
<?php include '../../view/sidebar_admin.php'; ?> <!-- Include the admin sidebar -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product->getProductName()); ?></title>
    <link rel="stylesheet" href="../css/products.css">
</head>
<body>

<h1><?php echo htmlspecialchars($product->getProductName()); ?></h1>

<div id="left_column">
    <p><img src="<?php echo htmlspecialchars($product->getProductImagePath($app_path)); ?>" 
            alt="<?php echo htmlspecialchars($product->getProductImageAltText()); ?>" /></p>
</div>

<div id="right_column">
    <p><b>List Price:</b> $<?php echo htmlspecialchars($product->getProductPriceFormatted()); ?></p>
    <p><b>Discount:</b> <?php echo htmlspecialchars($product->getProductDiscountPercentFormatted()) . '%'; ?></p>
    <p><b>Your Price:</b> $<?php echo htmlspecialchars($product->getProductDiscountPriceFormatted()); ?></p>
    <p>(You save $<?php echo htmlspecialchars($product->getProductDiscountAmountFormatted()); ?>)</p>
    
    <form action="<?php echo htmlspecialchars($app_path . 'cart'); ?>" method="post">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="productID" value="<?php echo $product->getID(); ?>">
        <b>Quantity:</b>
        <input type="number" name="quantity" value="1" min="1" size="2" required>
        <input type="submit" value="Add to Cart">
    </form>

    <h2 class="no_bottom_margin">Description</h2>
    <?php echo add_tags($product->getProductDescription()); ?>
</div>
</body>
</html>
