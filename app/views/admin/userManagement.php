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

require_once '../../controllers/AdminController.php';
require_once '../../../config/database.php';

$adminController = new AdminController();

// Fetch data for display
$users = $adminController->fetchUsers();

$adminController->delete();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <link href="../../../public/css/output.css" rel="stylesheet">

    <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>FurniScape Admin Manage users</title>
</head>

<body class=" relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-center h-screen brightness-110 contrast-90">

    <!-- <section class=" relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-center h-full brightness-110 contrast-90"> -->

    <?php include "../layout/adminHeader.php"?>

    
    <!-- Flash message display -->
    <?php include "../layout/flash.php"?>

    <?php include "../layout/adminSideMenu.php"?>

    <div class="ml-64 p-5">
        <h1 class="text-3xl font-lustria text-center"> MANAGE USERS</h1>
    </div>

    <div class="ml-52 p-4 bg-beige/80 rounded-lg shadow-lg max-w-5xl m-2">

    <!-- Display All Users -->
    <div class="overflow-x-auto overflow-y-auto max-h-[600px]">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">User Email</th>
                    <th class="border px-4 py-2">Frist Name</th>
                    <th class="border px-4 py-2">Last Name</th>
                    <th class="border px-4 py-2">Phone No</th>
                    <th class="border px-4 py-2">Address</th>
                    <th class="border px-4 py-2">User Role</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <form method="POST" action="/FurniScape/app/controllers/AdminController.php?action=update">
                        <td class="border px-4 py-2">
                            <?= $user['id']; ?>
                        </td>
                        <td class="border px-4 py-2">
                            <?= $user['email']; ?>
                        </td>
                        <td class="border px-4 py-2">
                            <?= $user['first_name']; ?>
                        </td>
                        <td class="border px-4 py-2">
                           <?= $user['last_name']; ?> 
                        </td>
                        <td class="border px-4 py-2">
                            <?= $user['phone']; ?>
                        </td>
                        <td class="border px-4 py-2">
                            <?= $user['address']; ?>
                        </td>
                        <td class="border px-4 py-2">
                            <?= $user['role']; ?>
                        </td>
                        <td class="border px-4 py-2 space-x-2">
                        <div class="flex flex-row gap-4">
                            <a href="/FurniScape/app/views/admin/userManagement.php?delete_id=<?= $user['id']; ?>" class="text-red-600 px-4 py-2 rounded-full font-semibold border-red-500 border-2 hover:bg-red-500 hover:text-white" onclick="return confirm('Are you sure?')">Delete</a>
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