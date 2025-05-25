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
require_once '../../controllers/ProductController.php';
require_once '../../controllers/CategoryController.php';
require_once '../../../config/database.php';

$productController = new ProductController();
$categoryController = new CategoryController();

// Fetch data for display
$products = $productController->fetchProducts();
$categories = $categoryController->fetchCategories();


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <link href="../../../public/css/output.css" rel="stylesheet">

    <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>FurniScape Admin Manage Products</title>
</head>

<body class=" relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-center h-screen brightness-110 contrast-90">

    <!-- <section class=" relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-center h-full brightness-110 contrast-90"> -->

    <?php include "../layout/adminHeader.php"?>

    <!-- Flash message display -->
    <?php include "../layout/flash.php"?>

    <!--  Flash message display -->
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
    <?php endif; ?>  -->


    <?php include "../layout/adminSideMenu.php"?>

    <div class="ml-64 px-6 py-4">
        <h1 class="text-3xl font-lustria text-center"> MANAGE PRODUCTS</h1>
    </div>


    <!-- Add product Button
    <button id="open-popup-Button" class="bg-brown font-montserrat text-beige font-bold py-2 px-7 rounded-full mx-auto block cursor-pointer hover:bg-btn-hover-brown">Add Product</button> -->

    <!-- POP-UP to add new product -->

    <!-- <div class="hidden fixed bg-brown bg-opacity-50 items-center justify-center ml-64 mr-3 p-3 z-50 w-1/2 top-20 right-38" id="add-new-product"> -->
    <div class="hidden fixed bg-brown bg-opacity-50 items-center justify-center md:ml-52 md:mr-3 p-3 z-50 md:w-1/2 w-full md:top-20 md:right-38" id="add-new-product">
        <div class="relative bg-beige p-6 rounded-lg shadow-lg w-3/4 md:w-full h-fit">
            <span id="close-Button" class="absolute top-2 right-2 text-2xl cursor-pointer"><i class="fa-solid fa-xmark"></i></span>
            <h2 class="text-2xl text-center font-lustria">Add New Product</h2>

            <form action="/FurniScape/app/controllers/ProductController.php?action=create" method="POST" class="p-6 rounded-lg shadow mb-5" enctype="multipart/form-data">  <!--enctype is needed when uploading image-->
            <div class="flex md:flex-row flex-col md:gap-14 md:mb-5 justify-center">
                <div>
                    <input type="text" name="product_name" placeholder="Product Name" required class="admin-input">
                </div>
                <div>
                    <input type="number" name="no_of_stock" placeholder="Stock Quantity" required class="admin-input">
                </div>
            </div>
    
            <div class="flex md:flex-row flex-col md:gap-14 md:mb-5 justify-center">
                <div>
                    <input type="number" name="price" placeholder="Product Price" required class="admin-input">
                </div>
    

                <div>
                    <select name="type" class="admin-input">
                        <option value="Furniture">Furniture</option>
                        <option value="Home-Decor">Home-Decor</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            
            </div>

            <div class="flex md:flex-row flex-col md:gap-14 md:mb-2 justify-center">

                <div>
                    <textarea name="description" placeholder="Product Description" required class="admin-input"></textarea>
                </div>
                <div>
                    <select name="category_id" class="admin-input">
                        <!-- Fetch Categories to populate the dropdown options -->
                        <?php 
                            foreach ($categories as $category){
                                echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
                            }
                        
                        ?>
                    </select>
                </div>                
            
            </div>            

                <div>
                    <input type="file" name="productImage" class="admin-input">

                    <div>
                        <label for="is_featured" class="font-montserrat mb-1">Mark as Featured</label>
                        <input type="checkbox" name="is_featured" class="form-checkbox h-5 w-5 text-brown">
                    </div>
                </div>

                <button type="submit" class="bg-brown font-montserrat text-beige font-bold py-2 px-7 rounded-full mx-auto block cursor-pointer hover:bg-btn-hover-brown">Add Product</button>
            

        </form>
            

        </div>
    </div>


    <!-- Create Product Form -->
    <div class="ml-52 p-4 bg-beige/80 rounded-lg shadow-lg max-w-5xl m-2">
        
    <!-- Add product Button -->
    <button id="open-popup-Button" class="bg-brown font-montserrat text-beige font-bold py-2 px-7 mb-3 rounded-full mx-auto block cursor-pointer hover:bg-btn-hover-brown">Add Product</button>

        <!-- Display All Products -->
        <div class="overflow-x-auto overflow-y-auto max-h-[600px]">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Product Name</th>
                        <th class="border px-4 py-2">Stock</th>
                        <th class="border px-4 py-2">Price</th>
                        <th class="border px-4 py-2">Type</th>
                        <th class="border px-4 py-2">Is Featured</th>
                        <th class="border px-4 py-2">Product Image</th>
                        <th class="border px-4 py-2">Category</th>
                        <th class="border px-4 py-2">Description</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product): ?>
                    <tr>
                         <form method="POST" action="/FurniScape/app/controllers/ProductController.php?action=update" enctype="multipart/form-data"> <!--enctype is needed when uploading image-->
                            <td class="border px-4 py-2">
                                <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                                <input type="hidden" name="existingImage" value="<?= htmlspecialchars($product['productImage']) ?>">
                                <?= $product['product_id']; ?>
                            </td>
                            <td class="border px-4 py-2">
                                <input type="text" name="product_name" value="<?= $product['product_name']; ?>" class="admin-input-table">
                            </td>
                            <td class="border px-4 py-2">
                                <input type="number" name="no_of_stock" value="<?= $product['no_of_stock']; ?>" class="admin-input-table">
                            </td>
                            <td class="border px-4 py-2">
                                <input type="number" name="price" value="<?= $product['price']; ?>" class="admin-input-table">
                            </td>
                            <td class="border px-4 py-2">
                                <select name="type" class="admin-input-table">
                                    <option value="Furniture" <?= $product['type'] === 'Furniture' ? 'selected' : '' ?>>Furniture</option>
                                    <option value="Home-Decor" <?= $product['type'] === 'Home-Decor' ? 'selected' : '' ?>>Home-Decor</option>
                                    <option value="Other" <?= $product['type'] === 'Other' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </td>
                            <td class="border px-4 py-2">
                                 <input type="checkbox" name="is_featured" value="1" <?= $product['is_featured'] ? 'checked' : '' ?>>
                            </td>
                            <td class="border px-4 py-2">
                                    <?php
                                    $imagePath = '/FurniScape/public/images/' . $product['productImage'];
                                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                                    echo "<img src='{$imagePath}' width='80' alt='Product Image'>";
                                    } else {
                                    echo "<img src='/FurniScape/public/images/empty.jpg' width='80' alt='Default Image'>";
                                    }
                                    ?>
                                <!-- <img src="<?= $product['productImage'] ?>" width="80" alt="Product Image"> -->
                                <input type="file" name="productImage" class="admin-input">
                            </td>
                            <td class="border px-4 py-2">
                                <select name="category_id" class="admin-input-table">
                                    <?php 
                                    foreach ($categories as $category){
                                        $selected = $category['category_id'] == $product['category_id'] ? 'selected' : '';
                                        echo "<option value='{$category['category_id']}' {$selected}>{$category['category_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td class="border px-4 py-2">
                                <input type="text" name="description" value="<?= $product['description']; ?>" class="admin-input-table">
                            </td>
                            <td class="border px-4 py-2 space-x-2">
                                <div class="flex flex-row gap-4">
                                    <button type="submit" class="bg-brown text-beige font-semibold px-4 py-2 rounded-full hover:bg-btn-hover-brown cursor-pointer">Update</button>
                                    <a href="/FurniScape/app/controllers/ProductController.php?delete_id=<?= $product['product_id']; ?>" class="text-red-600 px-4 py-2 rounded-full font-semibold border-red-500 border-2 hover:bg-red-500 hover:text-white" onclick="return confirm('Are you sure?')">Delete</a>
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

    <!-- JavaScript for product adding popup -->
    <script>
        
        const addNewProduct = document.getElementById('add-new-product');
        const openPOPUPButton = document.getElementById('open-popup-Button');
        const closePOPUP = document.getElementById('close-Button');

        openPOPUPButton.addEventListener('click', () => {
            addNewProduct.classList.remove('hidden');
            addNewProduct.classList.add('flex');
        });

        closePOPUP.addEventListener('click', () => {
            addNewProduct.classList.add('hidden');
            addNewProduct.classList.remove('flex');
        });

        // Close popup when clicking outside the modal
        // window.addEventListener('click', (event) => {
        //     if (event.target === addNewProduct) {
        //     addNewProduct.classList.add('hidden');
        //     addNewProduct.classList.remove('flex');
        // }
        // });

    </script>
    
</body>
</html>

        <!-- <form action="/FurniScape/app/controllers/ProductController.php?action=create" method="POST" class="p-6 rounded-lg shadow mb-5" enctype="multipart/form-data">  enctype is needed when uploading image -->
            <!-- <div class="flex md:flex-row flex-col gap-14 mb-5 justify-center">
                <div>
                    <input type="text" name="product_name" placeholder="Product Name" required class="admin-input">
                </div>
                <div>
                    <input type="number" name="no_of_stock" placeholder="Stock Quantity" required class="admin-input">
                </div>
                <div>
                    <input type="number" name="price" placeholder="Product Price" required class="admin-input">
                </div>
            </div>
            <div class="flex md:flex-row flex-col gap-14 mb-5 justify-center">

                <div>
                    <select name="type" class="admin-input">
                        <option value="Furniture">Furniture</option>
                        <option value="Home-Decor">Home-Decor</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <textarea name="description" placeholder="Product Description" required class="admin-input"></textarea>
                </div>
                <div>
                    <select name="category_id" class="admin-input">
                        Fetch Categories to populate the dropdown options
                        <?php 
                            foreach ($categories as $category){
                                echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
                            }
                        
                        ?>
                    </select>
                </div>                
            </div>

            <div class="flex md:flex-row flex-col gap-14 mb-2 justify-center">
                <div>
                    <input type="file" name="productImage" class="admin-input">
                </div>
                 <button type="submit" class="bg-brown font-montserrat text-beige font-bold py-2 px-7 rounded-full mx-auto block cursor-pointer hover:bg-btn-hover-brown">Add Product</button>
            </div>            

        </form> -->