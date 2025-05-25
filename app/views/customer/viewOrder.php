<?php
if (session_status() === PHP_SESSION_NONE ){
    session_start();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header("Location: /FurniScape/app/views/customer/customerLogin.php");
    exit;
}

require_once '../../controllers/OrderController.php';
// require_once '../../controllers/AuthController.php';
require_once '../../controllers/ProfileController.php';
require_once '../../controllers/ConsultationController.php';

// $auth = new AuthController();
// $userData = $auth->viewProfile();

$profileController = new ProfileController();
$userData = $profileController->viewProfile();

$orderController = new OrderController();

$consultationController = new ConsultationController();

$userId = $_SESSION['user']['id'];
$orders = $orderController->getOrdersByUserId($userId);

$consultations = $consultationController->getConsultationByUserId($userId);

// require_once '../../controllers/OrderController.php';
// $controller = new OrderController();

// $controller->getOrderItems($order['order_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="../../public/css/output.css" rel="stylesheet">

    <title>FurniScape | My Orders</title>
</head>
<body>

<?php include "../layout/header.php" ?>

    <section class=" relative bg-[url('../../public/images/loginback.png')] bg-cover bg-center min-h-screen">

        <?php include "../layout/flash.php"?>

        <div class="bg-beige/80 p-8 rounded-lg shadow-lg w-full mt-3">

        <!-- Edit Profile Button -->
            <button id="open-edit-profile" class="bg-brown font-montserrat text-beige font-bold py-2 px-7 mb-4 rounded-full cursor-pointer hover:bg-btn-hover-brown">
                Edit Profile
            </button>

            <!-- Edit Profile Popup -->
            <div id="edit-profile-popup" class="hidden fixed bg-brown bg-opacity-50 items-center justify-center z-50 top-0 left-0 md:mx-20 md:my-20">
                <div class="relative bg-beige p-6 rounded-lg shadow-lg m-4 items-center">
                    <span id="close-edit-profile" class="absolute top-2 right-2 text-2xl cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </span>

                    <h2 class="text-2xl text-center font-lustria mb-4">Edit Profile</h2>

                    <form action="/FurniScape/app/controllers/ProfileController.php?action=update_profile" method="POST">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <input type="text" name="first_name" value="<?= htmlspecialchars($userData['first_name']) ?>" placeholder="First Name" class="admin-input" required>
                            <input type="text" name="last_name" value="<?= htmlspecialchars($userData['last_name']) ?>" placeholder="Last Name" class="admin-input" required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <input type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" placeholder="Email" class="admin-input" required>
                            <input type="text" name="phone" value="<?= htmlspecialchars($userData['phone']) ?>" placeholder="Phone" class="admin-input">
                        </div>
                        <textarea name="address" placeholder="Address" class="admin-input mb-4"><?= htmlspecialchars($userData['address']) ?></textarea>
                        <button type="submit" class="bg-brown text-beige font-bold py-2 px-6 rounded-full block mx-auto hover:bg-btn-hover-brown">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>

            <!-- My orders view section -->

            <h1 class="heading-style">MY ORDERS</h1>

            <table class="w-full table-auto border-collapse border border-gray-300 ">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Order ID</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Delivery Date</th>
                        <th class="border px-4 py-2">Items</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="border px-4 py-2"><?= $order['order_id'] ?></td>
                            <td class="border px-4 py-2">LKR <?= number_format($order['total']) ?></td>
                            <td class="border px-4 py-2"><?= ucfirst($order['status']) ?></td>
                            <td class="border px-4 py-2"><?= $order['delivery_date'] ?></td>
                            <td class="border px-4 py-2">
                                <details>
                                    <summary class="cursor-pointer hover:underline">View Items</summary>
                                    <table class="mt-2 w-full border text-sm">
                                        <thead>
                                            <tr>
                                                <th class="border px-2 py-1">Product</th>
                                                <th class="border px-2 py-1">Quantity</th>
                                                <th class="border px-2 py-1">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $items = $orderController->getOrderItems($order['order_id']);
                                            foreach ($items as $item):
                                        ?>
                                            <tr>
                                                <td class="border px-2 py-1"><?= htmlspecialchars($item['product_name']) ?></td>
                                                <td class="border px-2 py-1"><?= $item['quantity'] ?></td>
                                                <td class="border px-2 py-1">LKR <?= number_format($item['price']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </details>
                            </td>
                            <td class="border px-2 py-1">
                                <a href="/FurniScape/app/controllers/OrderController.php?action=delete&order_id=<?= $order['order_id'] ?>" class="text-red-600 text-xl text-center" onclick="return confirm('Are you sure you want to delete this pending order?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- My consultation requests section -->

            <h1 class="heading-style">MY CONSULTATION REQUESTS</h1>

            <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Consultation ID</th>
                        <th class="border px-4 py-2">Preferred Date</th>
                        <th class="border px-4 py-2">Preferred Time</th>
                        <th class="border px-4 py-2">Mode</th>
                        <th class="border px-4 py-2">Topic</th>
                        <th class="border px-4 py-2 whitespace-normal break-words">Description</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultations as $consultation): ?>
                        <tr>
                            <td class="border px-4 py-2"><?= $consultation['id'] ?></td>
                            <td class="border px-4 py-2"><?= $consultation['preferred_date'] ?></td>
                            <td class="border px-4 py-2"><?= $consultation['preferred_time'] ?></td>
                            <td class="border px-4 py-2"><?= $consultation['mode'] ?></td>
                            <td class="border px-4 py-2"><?= $consultation['topic'] ?></td>
                            <td class="border px-4 py-2 whitespace-normal break-words"><?= $consultation['description'] ?></td>
                            <td class="border px-4 py-2"><?= ucfirst($consultation['status']) ?></td>

                            <td class="border px-2 py-1">
                                <a href="/FurniScape/app/controllers/ConsultationController.php?action=delete&delete_id=<?= $consultation['id'] ?>" class="text-red-600 text-xl text-center" onclick="return confirm('Are you sure you want to delete this pending order?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>


        </div>

    </section>

<script>
    const openPopupBtn = document.getElementById("open-edit-profile");
    const popup = document.getElementById("edit-profile-popup");
    const closeBtn = document.getElementById("close-edit-profile");

    openPopupBtn.addEventListener("click", () =>{
        popup.classList.remove("hidden");
        popup.classList.add('flex');
    });

    closeBtn.addEventListener("click", () => {
        popup.classList.add("hidden");
        popup.classList.remove('flex');

    });

</script>

    
</body>
</html>
