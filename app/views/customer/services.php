<!-- SESSION VALIDATION (To protect page) -->
<?php
// session_start();
// if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    // header("Location: /FurniScape/app/views/customer/customerLogin.php");
    // exit;
// }
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
    <section class="overflow-hidden py-2">
    <img src="../../../public/images/servicesHeroImage.png" alt="About Us Page Image" class="w-full max-w-none object-cover">
    </section>

    <section class="flex flex-col">
        <div class="flex justify-start">
            <img src="../../../public/images/service1.png" alt="SERVICE 01" class="w-1/2 h-auto">
        </div>
        <div class="flex justify-end">
            <img src="../../../public/images/service2.png" alt="SERVICE 02" class="w-1/2 h-auto">
        </div>
        <div class="flex justify-start">
            <img src="../../../public/images/service3.png" alt="SERVICE 03" class="w-1/2 h-auto">
        </div>
    </section>

    <h1 class="heading-style">INTERIOR DESIGN CONSULTATION</h1>

    <!-- Book Cosultation section -->
    <section class="action-section">
        <img src="../../../public/images/img3.jpg" alt="Interior design consultation" class="action-img">
        <div class="action-div">
            <h1 class="heading-style">Need expert advice ?</h1>

            <p class="action-p">Talk to our design specialists and get personalized recommendations.</p>

            <a class="action-a" href="consultationForm.php">BOOK A COSULTATION</a>
        </div>
    </section>





<?php include "../layout/footer.php"?>
    
</body>
</html>