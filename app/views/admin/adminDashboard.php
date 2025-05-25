<!-- SESSION VALIDATION (To protect page) -->
<?php
if (session_status() === PHP_SESSION_NONE ){
    session_start();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /FurniScape/app/views/admin/login.php");
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

    <title>FurniScape Admin Dashboard</title>
</head>

<body class=" relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-center h-screen">
    
<?php include "../layout/adminHeader.php"?>

    <!-- <section class=" relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-center h-screen p-6"> -->

    <h1 class="text-4xl font-lustria text-center p-4 font-bold mt-3"> ADMIN DASHBOARD </h1>

        <section class=" flex items-center justify-center flex-row">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 w-full max-w-4xl px-6">
            <a href="productManagement.php" class="admin-button">MANAGE PRODUCTS</a>
            <a href="orderManagement.php" class="admin-button">MANAGE ORDERS</a>
            <a href="consultationManagement.php" class="admin-button">MANAGE CONSULTATION</a>
            <a href="userManagement.php" class="admin-button">MANAGE USERS</a>
            <a href="contentManagement.php" class="admin-button">MANAGE CONTENT</a>
            <a href="/FurniScape/public/logout.php" class="admin-button">LOGOUT</a>
            <!-- <a href="/FurniScape/public/logout.php" class="bg-brown font-montserrat text-beige hover:bg-btn-hover-brown text-3xl py-8 rounded shadow text-center">LOGOUT</a> -->
            </div>

        </section>

    <!-- </section> -->
    
    
</body>
</html>