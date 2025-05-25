
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
<?php

require_once 'C:\xampp\htdocs\FurniScape\app\controllers\CategoryController.php';
$controller = new CategoryController();
$categories = $controller->fetchCategories();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <link href="../../../public/css/output.css" rel="stylesheet">

    <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>FurniScape Admin Manage Content</title>
</head>

<body class=" relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-center h-screen brightness-110 contrast-90">

    <!-- <section class=" relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-center h-full brightness-110 contrast-90"> -->

    <?php include "../layout/adminHeader.php"?>

<!-- Flash message display -->
    <?php include "../layout/flash.php"?>

    <?php include "../layout/adminSideMenu.php"?>

    <div class="ml-52 p-6">
        <h1 class="text-3xl font-lustria text-center"> MANAGE CONTENT</h1>
    </div>
    
    <!-- Create Category Form -->
    <div class="ml-52 p-5 bg-beige/80 rounded-lg shadow-lg max-w-5xl mx-2">
        
        <form action="/FurniScape/app/controllers/CategoryController.php?action=create" method="POST" class="p-6 rounded-lg shadow mb-10" enctype="multipart/form-data">
            <div class="flex md:flex-row flex-col gap-14 mb-5 justify-center">
            <div class="">
                <input type="text" name="category_name" placeholder="Category Name" required class="admin-input">
            </div>
            <div class="">
                <input type="text" name="category_desc" placeholder="Category Description" class="admin-input">
            </div>
            <div class="">
                <input type="file" name="category_image" class="admin-input">
            </div>
            </div>

            <button type="submit" class="bg-brown font-montserrat text-beige font-bold py-2 px-7 rounded-full mx-auto block mb-4 cursor-pointer hover:bg-btn-hover-brown">Add Category</button>

        </form>

        <!-- Display all Categories -->
        <div class="overflow-x-auto overflow-y-auto max-h-[400px]">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Description</th>
                        <th class="border px-4 py-2">Category Image</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($categories as $category): ?>
                    <tr>
                         <form method="POST" action="/FurniScape/app/controllers/CategoryController.php?action=update" enctype="multipart/form-data">
                            <td class="border px-4 py-2">
                                <input type="hidden" name="category_id" value="<?= $category['category_id']; ?>">
                                <input type="hidden" name="existingImage" value="<?= htmlspecialchars($category['category_image']) ?>">
                                <?= $category['category_id']; ?>
                            </td>
                            <td class="border px-4 py-2">
                                <input type="text" name="category_name" value="<?= $category['category_name']; ?>" class="admin-input-table">
                            </td>
                            <td class="border px-4 py-2">
                                <input type="text" name="category_desc" value="<?= $category['category_desc']; ?>" class="admin-input-table">
                            </td>
                            <td class="border px-4 py-2">
                                    <?php
                                    $imagePath = '/FurniScape/public/images/' . $category['category_image'];
                                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                                    echo "<img src='{$imagePath}' width='80' alt='Category Image'>";
                                    } else {
                                    echo "<img src='/FurniScape/public/images/empty.jpg' width='80' alt='Default Image'>";
                                    }
                                    ?>
                                <input type="file" name="category_image" class="admin-input">
                            </td>
                            <td class="border px-4 py-2 space-x-2">
                                <div class="flex flex-row gap-2">
                                    <button type="submit" class="bg-brown text-beige font-semibold px-4 py-2 rounded-full hover:bg-btn-hover-brown cursor-pointer">Update</button>
                                    <a href="/FurniScape/app/controllers/CategoryController.php?delete_id=<?= $category['category_id']; ?>" class="text-red-600 px-4 py-2 rounded-full font-semibold border-red-500 border-2 hover:bg-red-500 hover:text-white" onclick="return confirm('Are you sure?')">Delete</a>
                                </div>
                                
                            </td>
                        </form>

                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>

    



    <!-- </section> -->
    
</body>
</html>