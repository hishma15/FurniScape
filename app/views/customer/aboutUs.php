<!-- SESSION VALIDATION (To protect page) -->
<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header("Location: /FurniScape/app/views/customer/customerLogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="../../../public/css/output.css" rel="stylesheet">

    <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>FurniScape | ABOUT US</title>

</head>
<body>

<?php include "../layout/header.php"?>

    <!-- Banner image -->
    <section class="relative overflow-hidden py-2">
    <img src="../../../public/images/aboutusPageBanner.png" alt="About Us Page Image" class="w-full max-w-none object-cover">
    <div class="absolute md:bottom-15 md:right-30 right-5 bottom-5 flex items-end justify-end p-4 md:p-6">
        <a href="services.php" class="absolute bg-brown w-2xs text-center text-beige font-montserrat px-6 py-3 rounded-full shadow-md hover:bg-btn-hover-brown transition">EXPLORE OUR SERVICES</a>
    </div>

    </section>

    <!-- FurniScape Story -->
    <h1 class="heading-style">OUR STORY</h1>
    <div class="bg-beige mt-5 flex md:flex-row flex-col md:h-56mb-7 p-4">
        <p class="md:w-1/2 text-justify font-montserrat p-5 tracking-wider flex items-center">FurniScape started with a simple idea: every home should feel personal and reflect the people living in it.
What began as a small project in a garage — selecting and selling quality furniture to friends and family — has now grown into a full online store for stylish, affordable home décor and furniture.
We saw that most big stores offered the same designs with little personality. We wanted to change that — by curating furniture collections that feel warm, modern, and truly made for everyday living.
Today, FurniScape continues to help people create homes they love, with pieces that combine comfort, quality, and style.</p>
        <img src="../../../public/images/storeImage11.jpg" alt="Store Image" class="md:w-1/2 ">
    </div>

    <!-- FurniScape mission -->
    <h1 class="heading-style">OUR MISSION</h1>
    <div class="bg-beige mt-5 flex md:flex-row flex-col md:h-[22rem] items-center justify-between p-4">
        <Video controls class="md:w-1/2">
            <Source src="../../../public/videos/furnitureStoreVideo.mp4" type="video/mp4"></Source>
        </Video>
        <div class="md:w-1/2 text-left font-montserrat p-5 tracking-wider flex flex-col justify-center space-y-3">
            <p>#Crafting quality, lasting furniture made with care.</p>
            <br>
            <p>#Providing expert advice to help customers make confident choices.</p>
            <br>
            <p>#Ensuring accessibility and elegance for every space, every budget</p>
        </div>
    </div>  
    
    <!-- FurniScape Gallery -->
    <h1 class="heading-style">FURNISCAPE GALLERY</h1>

    <div class="grid grid-col-4 grid-row-2 gap-5 mt-5">
        <img src="../../../public/images/img1.jpg" alt="Image 01" class="col-span-2 row-span-2 h-120 image-gallery-animation">
        <img src="../../../public/images/img2.jpg" alt="Image 02" class="col-start-3 col-end-5 row-start-1 row-end-2 h-60 w-180 image-gallery-animation">
        <img src="../../../public/images/img3.jpg" alt="Image 03" class="col-start-3 row-start-2 image-gallery-animation">
        <img src="../../../public/images/img4.jpg" alt="Image 04" class="col-start-4 row-start-2 image-gallery-animation">

    </div>



<?php include "../layout/footer.php"?>
    
</body>
</html>