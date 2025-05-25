<?php
// ensures whether the session started from index.php
if (session_status() === PHP_SESSION_NONE ){
    session_start();
}
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

    <title>Login / Register</title>

</head>

<body>
    
<?php include "../layout/header.php"?>

    <section class=" relative bg-[url('../../public/images/loginback.png')] bg-cover bg-center h-screen">
    <!-- <section class=" relative bg-[url('../../public/images/loginback.png')] bg-cover bg-center min-h-screen overflow-hidden flex items-center justify-center"> -->

    <?php include "../layout/flash.php"?>
        <!------------------------------ LOGIN SECTION -------------------------------------------->
        <div class="absolute bg-beige/80 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 p-8 rounded-lg shadow-lg w-full md:max-w-lg" id="loginForm">
        <!-- <div class="bg-beige/80 p-8 rounded-lg shadow-lg w-full max-w-lg" id="loginForm" > -->
            <!-- LOGIN -->
            <div class="text-center">
                <span class="font-montserrat text-black tracking-wider">DON'T HAVE AN ACCOUNT?
                    <a href="customerRegister.php" onClick="changeForm()" class="hover:underline"> Register </a>
                </span>
            </div>
            <h2 class="font-lustria font-semibold text-3xl text-center p-3">LOGIN</h2>
            <form action="/FurniScape/public/index.php?route=login" id="login-form" method="POST">
            <!-- <form action="../../../app/controllers/AuthController.php" id="login-form" method="POST"> -->
            <div class="relative mb-4 mt-5">
                    <!-- <input type="hidden" name="role" value="customer"> -->
                    <!-- <label for="email">Email</label> -->
                    <i class="fa-solid fa-envelope absolute z-10 left-5 top-2.5 text-black"></i>
                    <input type="email" name="email" id="email" placeholder="Enter your Email" required class="border border-black-400 rounded-full py-1 px-9 ml-2 mr-2 w-full">
                </div>
                <div class="relative mb-4">
                    <!-- <label for="password">Password</label> -->
                    <i class="fa-solid fa-lock absolute z-10 left-5 top-2.5 text-black"></i>
                    <input type="password" name="password" id="password" placeholder="Enter your Password" required class="border border-black-400 rounded-full py-1 px-9 ml-2 mr-2 w-full">
                </div>
                <button type="submit" class="bg-brown text-2xl font-montserrat text-beige font-bold py-3.5 px-7 rounded-full mx-auto block mb-4 cursor-pointer hover:bg-btn-hover-brown">LOGIN</button>

                <div>
                    <input type="checkbox" id="login_check">
                    <label for="login_check">Remember Me</label>
                    <label><a href="#">|Forgot password?</a></label>
                </div>
            </form>
        </div>    

    </section>    
    
</body>
</html>