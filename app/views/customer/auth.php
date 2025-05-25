<!-- <?php
// // ensures whether the session started from index.php
// if (session_status() === PHP_SESSION_NONE ){
//     session_start();
// }

// // detect form is register or login
// $showRegister = isset($_GET['form']) && $_GET['form'] === 'register';

?> -->

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
    <title>Login / Register</title>
</head>

<body>
    
<?php include "../layout/header.php"?>

    <section class=" relative bg-[url('../../public/images/loginback.png')] bg-cover bg-center h-screen">
    <!-- <section class=" relative bg-[url('../../public/images/loginback.png')] bg-cover bg-center min-h-screen overflow-hidden flex items-center justify-center"> -->

    <!-- Flash message display -->
    <!-- <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center max-w-lg mx-auto">
            <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            ?>

        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-center max-w-lg mx-auto">
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?> -->

        <!------------------------------ LOGIN SECTION -------------------------------------------->
        <div class="absolute bg-beige/80 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 p-8 rounded-lg shadow-lg w-full md:max-w-lg <?php echo $showRegister ? 'hidden' : ''; ?>" id="loginForm" >
        <!-- <div class="bg-beige/80 p-8 rounded-lg shadow-lg w-full max-w-lg" id="loginForm" > -->
            <!-- LOGIN -->
            <div class="text-center">
                <span class="font-montserrat text-black tracking-wider">DON'T HAVE AN ACCOUNT?
                    <a href="#" onClick="changeForm()" class="hover:underline"> Register </a>
                </span>
            </div>
            <h2 class="font-lustria font-semibold text-3xl text-center p-3">LOGIN</h2>
            <form action="/Furniscape/public/index.php?route=login" id="login-form" method="POST">
                <div class="relative mb-4 mt-5">
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


        <!------------------------------------ REGISTER SECTION ------------------------------------------------------>
        <div class="absolute bg-beige/80 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 p-8 rounded-lg shadow-lg hidden w-full md:max-w-xl <?php echo $showRegister ? '' : 'hidden'; ?>" id="registerForm">
        <!-- <div class="bg-beige/80 p-8 rounded-lg shadow-lg w-full max-w-lg hidden" id="registerForm"> -->
            <!-- REGISTER -->
             <div class="text-center">
                <span class="font-montserrat text-black tracking-wider">ALREADY HAVE AN ACCOUNT? 
                    <a href="#" onClick="changeForm()" class="hover:underline"> Login </a>
                </span>
             </div>
            <h2 class="font-lustria font-semibold text-3xl text-center p-3">REGISTER</h2>
            <form action="/furniscape/public/index.php?route=register" id="register-form" method="POST">
                <div class="flex flex-col md:flex-row gap-4 mb-4 mt-5">
                    <div class="relative md:w-1/2">
                        <i class="fa-solid fa-user absolute z-10 left-5 top-2.5 text-black"></i>
                        <input type="text" name="first-name" placeholder="Enter your First Name" required class="border border-black-400 rounded-full py-1 px-9 ml-2 mr-2 w-full">
                    </div>
                    <div class="relative md:w-1/2">
                        <i class="fa-solid fa-user absolute z-10 left-5 top-2.5 text-black"></i>
                        <input type="text" name="last-name" placeholder="Enter your Last Name" required class="border border-black-400 rounded-full py-1 px-9 ml-2 mr-2 w-full">
                    </div>
                </div>
                <div class="relative mb-4 mt-5">
                    <i class="fa-solid fa-envelope absolute z-10 left-5 top-2.5 text-black"></i>
                    <input type="email" name="email" placeholder="Enter your Email" required class="border border-black-400 rounded-full py-1 px-9 ml-2 mr-2 w-full">
                </div>
                 <div class="relative mb-4 mt-5">
                    <i class="fa-solid fa-phone absolute z-10 left-5 top-2.5 text-black"></i>
                    <input type="tel" name="phone" placeholder="Enter your Phone Number" required class="border border-black-400 rounded-full py-1 px-9 ml-2 mr-2 w-full">
                </div>
                <div class="relative mb-4 mt-5">
                    <i class="fa-solid fa-location-dot absolute z-10 left-5 top-2.5 text-black"></i>
                    <input type="text" name="address" placeholder="Enter your Address" required class="border border-black-400 rounded-full py-1 px-9 ml-2 mr-2 w-full">
                </div>
                <div class="flex flex-col md:flex-row gap-4 mb-4 mt-5">
                    <div class="relative md:w-1/2">
                        <i class="fa-solid fa-lock absolute z-10 left-5 top-2.5 text-black"></i>
                        <input type="password" name="password" placeholder="Enter your Password" required class="border border-black-400 rounded-full py-1 px-9 ml-2 mr-2 w-full">
                    </div>
                    <div class="relative md:w-1/2">
                        <i class="fa-solid fa-lock absolute z-10 left-5 top-2.5 text-black"></i>
                        <input type="password" name="confirm-password" placeholder="Confirm your Password" required class="border border-black-400 rounded-full py-1 px-9 ml-2 mr-2 w-full">                        
                    </div>
                </div>

                <button type="submit" class="bg-brown text-2xl font-montserrat text-beige font-bold py-3.5 px-7 rounded-full mx-auto block mb-4 cursor-pointer hover:bg-btn-hover-brown">REGISTER</button>
            </form>
        </div>

    </section>

    <script>
        
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const showLogin = document.getElementById('showLogin');
        const showRegister = document.getElementById('showRegister');

        function changeForm(){
            loginForm.classList.toggle("hidden");
            registerForm.classList.toggle("hidden");
        }

    </script>
    
    
</body>
</html>