<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// $firstName = $_SESSION['user']['first_name'];
$user = $_SESSION['user'] ?? null;

require_once '../../controllers/CategoryController.php';

$categoryController = new CategoryController();
$categories = $categoryController->fetchCategories();

?>



<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="../../../public/css/output.css" rel="stylesheet">

  <!--Icons from fontawsome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>FurniScape</title>

</head>
<body>
  <header class="bg-beige text-black p-2 font-semibold"> 
    
    <div class="bg-background-gray max-w-7xl mx-auto px-4 py-1 flex justify-between items-center">
      <div class="text-lg font-semibold text-black">
        <?php if ($user && $user['role'] === 'customer'): ?>
          <!-- XSS Protection -->
          Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!
        <?php else: ?>
            Welcome to FurniScape!
        <?php endif; ?>
      </div>

      <div class="flex md:flex-row flex-col gap-2">
        <?php if ($user && $user['role'] === 'customer'): ?>
          <a href="/FurniScape/app/views/customer/viewOrder.php" class="bg-brown hover:bg-btn-hover-brown text-beige font-semibold py-2 px-4 mr-3 rounded transition">
            My Profile
          </a>

          <a href="/FurniScape/public/logout.php" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition">
            Logout
          </a>
        <?php endif; ?>
      </div>


    </div>

    <div class="container mx-auto grid grid-cols-3 grid-rows-2 gap-2 item-center relative">

    <!-- Logo -->
    <div class="row-span-2 flex item-center">
      <a href="../customer/home.php">
      <img src="../../../public/images/logoPNG.png" alt="FurniScape Logo" class="h-30 w-auto" >
      </a>
    </div>

    <!-- Navigation section 1 -->
    <nav class="col-span-1 flex justify-center items-center py-3.5">

      <!-- <ul  id="navLinks" class="hidden md:flex flex-col md:flex-row md:space-x-8 md:static md:w-auto z-10">
        <li><a href="#" class="hover:underline">HOME</a></li>
        <li><a href="#" class="hover:underline">CATEGORIES</a></li>
        <li><a href="#" class="hover:underline">ABOUT US</a></li>
        <li><a href="#" class="hover:underline">SERVICES</a></li>
      </ul> -->

      <ul  id="navLinks" class="hidden md:flex flex-col md:flex-row md:space-x-8 md:static md:w-auto absolute top-20 right-4 w-72 bg-beige md:bg-transparent shadow-lg md:shadow-none rounded-md md:rounded-none p-4 md:p-0 space-y-4 md:space-y-0 z-30">
        <li><a href="../customer/home.php" class="hover:underline">HOME</a></li>
        <li class="relative group"><a href="#" class="hover:underline flex items-center gap-1">CATEGORIES  <i class="fa-solid fa-angle-down"></i></a>
          <ul class="absolute left-0 mt-2 w-60 bg-beige border-brown-1 shadow-lg rounded-md text-black text-sm hidden group-hover:block md:group-hover:block z-40 group-focus-within:block">
            <!-- <li class="px-4 py-2 hover:bg-gray-200 cursor-pointer">Livingroom Furniture</li> -->
            <?php foreach ($categories as $category): ?>
              <li class="px-4 py-2 hover:bg-gray-200 cursor-pointer z-40">
                <a href="/FurniScape/app/views/customer/categoryProducts.php?category_id=<?= $category['category_id'] ?>">
                  <?= htmlspecialchars($category['category_name']) ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>
        <li><a href="../customer/aboutUs.php" class="hover:underline">ABOUT US</a></li>
        <li><a href="../customer/services.php" class="hover:underline">SERVICES</a></li>
      </ul>

      <!-- Hamburger Button (Only visible on small screens)  -->
      <button id="menuBar" class="md:hidden text-2xl absolute top-4 right-4">
        <i class="fa-solid fa-bars" id="menuIcon"></i>
        <!-- <i class="fa-solid fa-xmark"></i> -->
      </button>

    </nav>

    <!-- Hidden search bar -->
    <!-- <div id="searchBar" class="md:col-start-2 md:row-start-2 col-start-2 row-start-1 hidden justify-center items-center space-x-6"> -->
      <form action="" method="GET"class="md:col-start-2 md:row-start-2 col-start-2 row-start-1 hidden justify-center items-center space-x-6" id="searchBar">
        <!-- <input type="search" name="search" placeholder="Search our furniture collection..." class="w-full px-4 py-2 border border-black rounded-full focus:outline-none focus:ring-2 focus:ring-black bg-background-gray"> -->
        <input type="search" name="search" placeholder="Search our furniture collection..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" class="w-full px-4 py-2 border border-black rounded-full focus:outline-none focus:ring-2 focus:ring-black bg-background-gray">
        <button class="btn bg-black text-beige py-2 px-4 rounded-full font-montserrat font-light" type="submit">Search</button>
      </form>

    <!-- </div> -->

    <!-- Navigation section 2 -->
    <div class="col-start-3 row-start-2 flex justify-end items-center space-x-6 text-3xl">
      <a href="#" title="SEARCH FOR PRODUCTS" id="searchIcon"><i class="fa-solid fa-magnifying-glass"></i></a>
      <a href="../customer/cart.php" title="MY CART"><i class="fa-solid fa-cart-shopping"></i></a>
      <a href="../customer/customerLogin.php" title="LOGIN/ REGISTER"><i class="fa-solid fa-user"></i></a>
    </div>

    </div>
  </header>


  <!-- JavaScript code -->
  <script>

    document.addEventListener('DOMContentLoaded',function(){
      const searchIcon = document.querySelector('#searchIcon');
      const searchBar = document.querySelector('#searchBar');
      const menuBar = document.querySelector('#menuBar');
      const navLinks = document.querySelector('#navLinks');
      const menuIcon = document.querySelector('#menuIcon');
      // const closeIcon = document.querySelector('.fa-xmark'); 
      const categoryMenu = document.querySelector('.group > a');
      const dropdown = document.querySelector('.group ul');

      let isMenuOpen = false;

      //Hidden search bar visibility
      if (searchIcon && searchBar){
        searchIcon.addEventListener('click',() => {
          searchBar.classList.toggle('hidden');
          searchBar.classList.toggle('flex');
        });
      }

      //Navigation menu bar on small screens 
      if (menuBar && navLinks){
        menuBar.addEventListener('click', () => {
          isMenuOpen = !isMenuOpen;
          navLinks.classList.toggle('hidden');
          navLinks.classList.toggle('flex');

          if(isMenuOpen){
            menuIcon.classList.remove('fa-bars');
            menuIcon.classList.add('fa-xmark');
          }
          else{
            menuIcon.classList.remove('fa-xmark');
            menuIcon.classList.add('fa-bars');
          }

        });
      }

      // Dropdown visibility for CATEGORIES on mobile
      if (categoryMenu && dropdown) {
        categoryMenu.addEventListener('click', (e) => {
          if (window.innerWidth < 768) {
            e.preventDefault(); // Prevent navigation
            dropdown.classList.toggle('hidden');
          }
        });
      }

    });

  </script>

</body>
</html>