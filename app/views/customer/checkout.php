<?php

// ensures whether the session started from index.php
if (session_status() === PHP_SESSION_NONE ){
    session_start();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header("Location: /FurniScape/app/views/customer/customerLogin.php");
    exit;
}

if (empty($_SESSION['cart'])) {
    header("Location: /FurniScape/app/views/customer/cart.php");
    exit;
}


?>

<?php
// require_once '../../controllers/OrderController.php';
require_once __DIR__ . '/../../controllers/OrderController.php';
// require_once '../../../config/database.php';
require_once __DIR__ . '/../../../config/database.php';

$orderController = new OrderController();

// Fetch the user details array from the controller
$user = $orderController->getUserDetails();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- <link href="../../public/css/output.css" rel="stylesheet"> -->
    <link href="/FurniScape/public/css/output.css" rel="stylesheet">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lustria&display=swap" rel="stylesheet">

    <title>FurniScape | CHECKOUT</title>
</head>
<body>

    <h2 class="heading-style">COMPLETE YOUR PURCHASE</h2>

    <form action="/FurniScape/app/controllers/OrderController.php?action=place_order" method="POST">
        
    <section class="flex flex-col md:flex-row gap-4 p-4"> 

        <div class="md:w-1/2 space-y-4">

            <!-- PERSONAL DETAILS -->
            <div class="bg-beige p-5 m-3 space-y-4">
                <h3 class="text-black font-montserrat tracking-wider text-lg">CONTACT DETAILS</h3>

                <div class="flex items-center space-x-4">
                    <label for="name" class="w-32 text-black">Name:</label>
                    <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['first_name']) ?> <?= htmlspecialchars($user['last_name']) ?>" readonly class="flex-1 p-2 border border-black-400 rounded-full px-9 ml-2 mr-2 bg-gray-100">
                </div>

                <div class="flex items-center space-x-4">
                    <label for="email" class="w-32 text-black">Email:</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" readonly class="flex-1 p-2 border border-black-400 rounded-full px-9 ml-2 mr-2 bg-gray-100">
                </div>

                <div class="flex items-center space-x-4">
                    <label for="phone" class="w-32 text-black">Phone No:</label>
                    <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($user['phone']) ?>" readonly class="flex-1 p-2 border border-black-400 rounded-full px-9 ml-2 mr-2 bg-gray-100">
                </div>
            </div>

            <!-- SHIPPING DETAILS -->
            <div class="bg-beige p-5 m-3 space-y-4">
                <h3 class="text-black font-montserrat tracking-wider text-lg">SHIPPING ADDRESS</h3>

                <div class="flex items-center space-x-4">
                    <label for="home_no" class="w-32 text-sm text-black">Home No:</label>
                    <input type="text" name="home_no" id="home_no" placeholder="Home No" required class="flex-1 p-2 border border-black-400 rounded-full px-9 ml-2 mr-2">
                </div>

                <div class="flex items-center space-x-4">
                    <label for="street" class="w-32 text-sm text-black">Street:</label>
                    <input type="text" name="street" id="street" placeholder="Street" required class="flex-1 p-2 border border-black-400 rounded-full px-9 ml-2 mr-2">
                </div>

                <div class="flex items-center space-x-4">
                    <label for="city" class="w-32 text-sm text-black">City:</label>
                    <input type="text" name="city" id="city" placeholder="City" required class="flex-1 p-2 border border-black-400 rounded-full px-9 ml-2 mr-2">
                </div>
            </div>

        </div>
        

        <div class="bg-black text-beige font-montserrat p-5 m-3 md:w-1/2">
            <h3 class="text-beige font-bold text-center text-lg mb-4">Order Summary</h3>

            <table class="w-full text-left border-separate border-spacing-y-2">
                <thead>
                    <tr class="border-b border-beige">
                        <th class="py-2">Product</th>
                        <th>Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-beige">
                    <?php
                        $subtotal = 0;
                        foreach ($_SESSION['cart'] as $item):
                            $lineTotal = $item['price'] * $item['quantity'];
                            $subtotal += $lineTotal;
                    ?>
                    <tr class="py-3">
                        <td class="py-2"><?= htmlspecialchars($item['product_name']) ?></td>
                        <td class="py-2">LKR <?= number_format($item['price'], 2) ?></td>
                        <td class="py-2 text-center"><?= $item['quantity'] ?></td>
                        <td class="py-2 text-right">LKR <?= number_format($lineTotal, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot class="mt-4 text-end border-t border-beige">
                    <?php
                        $deliveryCharge = 200;
                        $tax = $subtotal * 0.1;
                        $total = $subtotal + $deliveryCharge + $tax;
                    ?>
                    <tr class="border-t border-white">
                        <td colspan="3" class="pt-4 font-medium">Subtotal</td>
                        <td class="pt-4 text-right">LKR <?= number_format($subtotal, 2) ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="py-2 font-medium">Delivery Charge</td>
                        <td class="py-2 text-right">LKR <?= number_format($deliveryCharge, 2) ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="py-2 font-medium">Tax (10%)</td>
                        <td class="py-2 text-right">LKR <?= number_format($tax, 2) ?></td>
                    </tr>
                    <tr class="font-bold border-t border-beige">
                        <td colspan="3" class="pt-4 text-lg">Total</td>
                        <td class="pt-4 text-lg text-right">LKR <?= number_format($total, 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>


    </section>
            <button type="submit" name="checkoutSubmit" class="bg-brown font-montserrat font-semibold text-beige py-4 px-8 rounded-full cursor-pointer hover:bg-btn-hover-brown mb-6 mr-12 float-end">PLACE ORDER</button>

    </form>




    
</body>
</html>