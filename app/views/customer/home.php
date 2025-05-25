
<!-- SESSION VALIDATION (To protect page) -->
<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header("Location: /FurniScape/app/views/customer/customerLogin.php");
    exit;
}



require_once '../../controllers/ProductController.php';
require_once '../../controllers/CategoryController.php';

$productController = new ProductController();
$categoryController = new CategoryController();

$categories = $categoryController->fetchCategories();

$featuredProducts = $productController->getFeaturedProducts();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="../../public/css/output.css" rel="stylesheet">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lustria&display=swap" rel="stylesheet">

    <title>FurniScape</title>

    <!--<script src="https://cdntailwindcss.com"></script>-->


</head>

<body>

<?php include "../layout/header.php"?>
    
    <?php include "../layout/flash.php"?>

    <!-- Banner image -->
    <section class="relative overflow-hidden py-2">
        <img src="../../../public/images/bannerImage.png" alt="Landing Page Image" class="w-full max-w-none object-cover">

        <!-- CTA Button -->
        <div class="absolute inset-0 flex items-center justify-center z-10">
            <a href="categoryProducts.php" class="bg-white text-black font-montserrat font-semibold md:py-4 md:px-10 md:mr-6 md:mt-0 mt-4 py-2 px-2 mr-4 2xl:py-6 2xl:px-18 2xl:mr-10 rounded-lg md:text-xl text-sm shadow-lg border-2 border-black hover:bg-beige">BUY NOW</a>
        </div>

    </section>

    <!-- categories section -->
    <section id="categories">
        
        <!-- <h1 class="font-lustria text-center text-black text-3xl pt-4">SHOP OUR FURNITURE COLLECTION</h1> -->
        <h1 class="heading-style">SHOP OUR FURNITURE COLLECTION</h1>

        <!-- Categories -->
        <div class="flex overflow-x-auto space-x-8 p-5">

            <?php foreach ($categories as $category): ?>
            <div class="home-category">
                <a href="/FurniScape/app/views/customer/categoryProducts.php?category_id=<?= $category['category_id'] ?>">
                    <img src="/FurniScape/public/images/<?= $category['category_image'] ?>" alt="Category Image" class="home-category-img">
                </a>
                <a href="/FurniScape/app/views/customer/categoryProducts.php?category_id=<?= $category['category_id'] ?>" class="home-category-name">
                  <?= htmlspecialchars($category['category_name']) ?>
                </a>
            </div>
            <?php endforeach; ?>

        </div>
        
    </section>

        <!-- signup section -->
    <section class="action-section">
        <img src="../../../public/images/happyCustomerCheckIn.jpg" alt="Happy cutomer" class="action-img">
        <div class="action-div">
            <h1 class="heading-style">Don't have an account ?</h1>

            <p class="action-p">Join now and enjoy exclusive deals, faster checkout and order tracking</p>

            <a class="action-a" href="customerRegister.php">SIGN UP</a>
        </div>
    </section>

    <!-- Featured products -->
    <section>

        <h1 class="heading-style">OUR FEATURED PRODUCTS</h1>

        <!-- <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-6"> -->
        <section class="flex overflow-x-auto space-x-8 p-5">

        <?php foreach ($featuredProducts as $featuredProduct): ?>
    
            <!-- product 1 -->
            <div class="product-div">
                <img src="/FurniScape/public/images/<?= $featuredProduct['productImage'] ?>" alt="Product Image" class="product-img">
                <h2 class="product-name"> <?= htmlspecialchars($featuredProduct['product_name']) ?> </h2>
                <P class="product-price">LKR <?= htmlspecialchars($featuredProduct['price']) ?></P>
                <div class="product-div-btn">
                    <!-- <button class="bg-brown font-montserrat text-beige font-semibold py-3.5 px-5 rounded-full cursor-pointer hover:bg-btn-hover-brown">View Details</button> -->
                    <button class="product-view-btn">View Details</button>
                    <a class="product-addtocart-btn" href="/FurniScape/app/controllers/CartController.php?action=addToCart&id=<?= $featuredProduct['product_id'] ?>"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>

            <!-- product 1 -->
            <!-- <div class="bg-beige p-6 m-4 transform transition duration-300 hover:scale-105 hover:-translate-y-2 hover:shadow-xl rounded-lg">
                <img src="/FurniScape/public/images/<?= $featuredProduct['productImage'] ?>" alt="Product Image" class="w-full h-48 object-contain rounded-lg">
                <h2 class="font-montserrat tracking-wide font-semibold text-black text-center m-2"> <?= htmlspecialchars($featuredProduct['product_name']) ?> </h2>
                <P class="text-black font-montserrat font-medium mb-4">LKR <?= htmlspecialchars($featuredProduct['price']) ?></P>
                <div class="flex flex-row items-center gap-4"> -->
                    <!-- <button class="bg-brown font-montserrat text-beige font-semibold py-3.5 px-5 rounded-full cursor-pointer hover:bg-btn-hover-brown">View Details</button> -->
                    <!-- <button class="bg-brown font-montserrat font-semibold text-beige p-3.5 rounded-full cursor-pointer hover:bg-btn-hover-brown transform transition duration-200 hover:scale-110 active:scale-95">View Details</button>
                    <a class="bg-brown text-beige p-3.5 rounded-full cursor-pointer hover:bg-btn-hover-brown transform transition duration-200 hover:scale-110" href="/FurniScape/app/controllers/CartController.php?action=addToCart&id=<?= $featuredProduct['product_id'] ?>"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div> -->
        <?php endforeach; ?>




        </section>


    </section>

    <!-- Furniscape advantages -->
    <section class="furniscape-advantage">

        <h1 class="heading-style">THE FURNISCAPE ADVANTAGE</h1>

        <div class="flex flex-col flex-wrap md:flex-row justify-center items-center space-x-6 p-5">
                    
            <div class="furniscape-advantage-box">
                <i class="fa-solid fa-truck"></i>
                <p>FAST DELIVERY</p>
            </div>
            <div class="furniscape-advantage-box">
                <i class="fa-solid fa-building-user"></i>
                <p>24/7 SUPPORT</p>
            </div>
            <div class="furniscape-advantage-box">
                <i class="fa-solid fa-award"></i>
                <p>PREMIUM QUALITY</p>
            </div>
            <div class="furniscape-advantage-box">
                <i class="fa-solid fa-infinity"></i>
                <p>ENDLESS CHOICE</p>
            </div>
            
        </div>
        
    </section>

    <!-- Book Cosultation section -->
    <h1 class="heading-style">INTERIOR DESIGN CONSULTATION</h1>

    <section class="action-section">
        <img src="../../../public/images/img3.jpg" alt="Interior design consultation" class="action-img">
        <div class="action-div">
            <h1 class="heading-style">Need expert advice ?</h1>

            <p class="action-p">Talk to our design specialists and get personalized recommendations.</p>

            <a class="action-a" href="consultationForm.php">BOOK A COSULTATION</a>
        </div>
    </section>
    
    <!-- banner section -->
    <section>
        <img src="../../../public/images/furniturebanner2.png" alt="Furniscape Banner" class="w-full h-40">
    </section>

<?php include "../layout/footer.php"?>
    
</body>
</html>