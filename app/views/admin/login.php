<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <link href="../../../public/css/output.css" rel="stylesheet">

    <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>FurniScape Admin Login</title>
</head>

<body>

    <section class=" relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-no-repeat bg-center h-screen">
    <!-- <section class=" relative bg-[url('../../public/images/loginback.png')] bg-cover bg-center min-h-screen overflow-hidden flex items-center justify-center"> -->

    <?php include "../layout/adminHeader.php"?>

    <?php include "../layout/flash.php"?>
    
        <!------------------------------ LOGIN SECTION -------------------------------------------->
        <div class="absolute bg-beige/80 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 p-8 mt-15 rounded-lg shadow-lg w-full md:max-w-lg">
        <!-- <div class="bg-beige/80 p-8 rounded-lg shadow-lg w-full max-w-lg" id="loginForm" > -->
            <!-- LOGIN -->
            <h2 class="font-lustria font-semibold text-3xl text-center p-3">LOGIN</h2>
            <!-- <form action="/FurniScape/app/controllers/AuthController.php" id="login-form" method="POST"> -->
            <form action="/FurniScape/public/index.php?route=adminLogin" id="login-form" method="POST">
            <div class="relative mb-4 mt-5">
                    <!-- <label for="email">Email</label> -->
                    <!-- <input type="hidden" name="role" value="admin"> -->
                    <i class="fa-solid fa-envelope absolute z-10 left-5 top-2.5 text-black"></i>
                    <input type="email" name="email" id="email" placeholder="Enter your Email" required class="border border-black-400 rounded-full py-1 px-9 ml-2 mr-2 w-full">
                </div>
                <div class="relative mb-4">
                    <!-- <label for="password">Password</label> -->
                    <i class="fa-solid fa-lock absolute z-10 left-5 top-2.5 text-black"></i>
                    <input type="password" name="password" id="password" placeholder="Enter your Password" required class="border border-black-400 rounded-full py-1 px-9 ml-2 mr-2 w-full">
                </div>
                <button type="submit" class="bg-brown text-2xl font-montserrat text-beige font-bold py-3.5 px-7 rounded-full mx-auto block mb-4 cursor-pointer hover:bg-btn-hover-brown">LOGIN</button>

            </form>
        </div>

    </section>
    
    
</body>
</html>