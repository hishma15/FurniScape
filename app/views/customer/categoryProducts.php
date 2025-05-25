<!-- SESSION VALIDATION (To protect page) -->
<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header("Location: /FurniScape/app/views/customer/customerLogin.php");
    exit;
}
 ?> 

<?php

require_once '../../controllers/ProductController.php';
require_once '../../controllers/CategoryController.php';

$productController = new ProductController();
$categoryController = new CategoryController();

$categoryId = $_GET['category_id'] ?? null;

// if (!$categoryId){
//     die("Invalid category.");
// }

// $currentCategory = $categoryController->getCategoryById($categoryId);
// $products = $productController->getProductByCategory($categoryId);
// $products = $productController->fetchProducts();

// Determine what products to load
if ($categoryId){
    $currentCategory = $categoryController->getCategoryById($categoryId);
    $products = $productController->getProductByCategory($categoryId);
}
else{
    $currentCategory = ['category_name' => 'All Products'];
    $products = $productController->fetchProducts();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link href="../../public/css/output.css" rel="stylesheet"> -->
    <link href="/FurniScape/public/css/output.css" rel="stylesheet">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lustria&display=swap" rel="stylesheet">

    <title>FurniScape Products</title>

</head>
<body>

<?php include "../layout/header.php"?>

    <?php include "../layout/flash.php"?>


    <h1 class="heading-style"><?= htmlspecialchars($currentCategory['category_name']) ?></h1>

    <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-6">
    <?php foreach ($products as $product): ?>
    
    <!-- product 1 -->
        <div class="product-div">
            <img src="/FurniScape/public/images/<?= $product['productImage'] ?>" alt="Product Image" class="product-img">
            <h2 class="product-name"> <?= htmlspecialchars($product['product_name']) ?> </h2>
            <P class="product-price">LKR <?= htmlspecialchars($product['price']) ?></P>
            <div class="product-div-btn">
                <!-- <button class="bg-brown font-montserrat text-beige font-semibold py-3.5 px-5 rounded-full cursor-pointer hover:bg-btn-hover-brown">View Details</button> -->
                <button class="product-view-btn">View Details</button>
                <a class="product-addtocart-btn" href="/FurniScape/app/controllers/CartController.php?action=addToCart&id=<?= $product['product_id'] ?>"><i class="fa-solid fa-cart-shopping"></i></a>
            </div>
        </div>
    <?php endforeach; ?>
    </section>
    

<?php include "../layout/footer.php"?>
    
</body>
</html>