<!-- SESSION VALIDATION (To protect page) -->
<?php
if (session_status() === PHP_SESSION_NONE ){
    session_start();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /FurniScape/app/views/admin/login.php");
    exit;
}

// require_once '../../controllers/AdminController.php';
// $controller = new AdminController();

require_once '../../controllers/OrderController.php';
$controller = new OrderController();

$orders = $controller->listOrders();
$controller->handleOrderUpdate();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <link href="../../../public/css/output.css" rel="stylesheet">

    <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>FurniScape Admin Manage Orders</title>
</head>

<body class=" relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-center h-screen brightness-110 contrast-90">
    

    <!-- <section class=" relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-center h-full brightness-110 contrast-90"> -->

    <?php include "../layout/adminHeader.php"?>

        <!-- Flash message display -->
    <?php include "../layout/flash.php"?>

    <?php include "../layout/adminSideMenu.php"?>

    <div class="ml-52 p-4">
        <h1 class="text-3xl font-lustria text-center"> MANAGE ORDERS</h1>

        <div class="p-4 bg-beige/80 rounded-lg shadow-lg max-w-5xl m-2">
         <!-- Display All Orders -->
        <div class="overflow-x-auto overflow-y-auto max-h-[600px]">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Order ID</th>
                        <th class="border px-4 py-2">User ID</th>
                        <th class="border px-4 py-2">Address</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Delivery Date</th>
                        <th class="border px-4 py-2">View Items</th>

                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $order): ?>
                    <tr>
                         <form method="POST">
                            <td class="border px-4 py-2">
                                <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                                <?= $order['order_id']; ?>
                            </td>
                            <td class="border px-4 py-2">
                                <?= $order['user_id']; ?>
                            </td>
                            <td class="border px-4 py-2">
                                <?= htmlspecialchars($order['home_no'] . ', ' . $order['street'] . ', ' . $order['city']) ?>
                            </td>
                            <td class="border px-4 py-2">
                                LKR <?= number_format($order['total']) ?>
                            </td>
                            <td class="border px-4 py-2">
                                <select name="status" class="admin-input-table">
                                    <?php foreach (['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'] as $status): ?>
                                    <option value="<?= $status ?>" <?= $order['status'] === $status ? 'selected' : '' ?>><?= $status ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td class="border px-4 py-2">
                                <!-- <input type="date" name="delivery_date" value="<?= date('Y-m-d', strtotime($order['delivery_date'])) ?>" class="border rounded p-1"> -->
                                <input type="date" name="delivery_date" value="<?= $order['delivery_date'] ?>" class="border rounded p-1">
                            </td>
                            
                            <td class="border px-4 py-2">
                                <details>
                                    <summary>View Items</summary>
                                        <table>
                                            <thead>
                                            <tr><th>Product</th><th>Qty</th><th>Price</th></tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $items = $controller->getOrderItems($order['order_id']);
                                                foreach ($items as $item) {
                                                    echo "<tr>";
                                                    echo "<td>{$item['product_name']}</td>";
                                                    echo "<td>{$item['quantity']}</td>";
                                                    echo "<td>\${$item['price']}</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                </details>     
                            </td>
                            
                            <td class="border px-4 py-2 space-x-2">
                                <div class="flex flex-col gap-4">
                                    <!-- <a href="order-details.php?order_id=<?= $order['order_id'] ?>" class="bg-brown text-beige font-semibold px-4 py-2 rounded-full hover:bg-btn-hover-brown cursor-pointer text-center">View Items</a> -->
                                    <button type="submit" class="bg-brown text-beige font-semibold px-4 py-2 rounded-full hover:bg-btn-hover-brown cursor-pointer">Update</button>
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