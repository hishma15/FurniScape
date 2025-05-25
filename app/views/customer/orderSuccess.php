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

    <!-- <link href="../../public/css/output.css" rel="stylesheet"> -->
     <link href="/FurniScape/public/css/output.css" rel="stylesheet">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lustria&display=swap" rel="stylesheet">

    <title>FurniScape</title>

</head>

<body>

<section class="bg-brown w-full flex flex-col justify-center items-center p-30 mx-0 my-20 text-center gap-8">
    <h2 class="text-3xl font-lustria font-bold">🎉 Your Order has been placed!</h2>
    <p class="text-2xl font-montserrat tracking-wider">Thank you for shopping with FurniScape!</p>
    <a href="/FurniScape/app/views/customer/home.php" class="bg-beige py-5 px-8 rounded-full font-montserrat font-bold text-black hover:bg-gray-200 transition duration-300">BACK TO HOME</a>

</section>


    
</body>
</html>

