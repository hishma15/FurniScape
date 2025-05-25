<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <link href="../../../public/css/output.css" rel="stylesheet">

    <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>FurniScape</title>
</head>

<body>

    <aside id="sidebar" class="w-50 h-fit bg-beige text-beige fixed top-0 left-0 flex flex-col shadow-lg z-50 mt-30 pt-4">
    <!-- <aside id="sidebar" class="fixed top-0 left-0 w-60 h-full bg-beige text-brown transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 shadow-lg pt-20"> -->
        <nav class="px-4 py-6 space-y-4 text-lg font-montserrat">
            <a href="../admin/adminDashboard.php" class="admin-sidemenu">
                <i class="fa-solid fa-gauge"></i> Admin Dashboard
            </a>
            <a href="../admin/productManagement.php" class="admin-sidemenu">
                <i class="fa-solid fa-box"></i> Manage Products
            </a>
            <a href="../admin/orderManagement.php" class="admin-sidemenu">
                <i class="fa-solid fa-cart-shopping"></i> Manage Orders
            </a>
            <a href="../admin/consultationManagement.php" class="admin-sidemenu">
                <i class="fa-solid fa-comments"></i> Manage Consultation
            </a>
            <a href="../admin/userManagement.php" class="admin-sidemenu">
                <i class="fa-solid fa-users"></i> Manage Users
            </a>
            <a href="../admin/contentManagement.php" class="admin-sidemenu">
                <i class="fa-solid fa-folder"></i> Manage Content
            </a>
            <a href="../../../public/logout.php" class="admin-sidemenu">
                <i class="fa-solid fa-right-from-bracket"></i> Log out
            </a>
        </nav>
    </aside>

    
</body>
</html>