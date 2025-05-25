<!-- SESSION VALIDATION (To protect page) -->
<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header("Location: /FurniScape/app/views/customer/customerLogin.php");
    exit;
}

require_once '../../controllers/CartController.php';

$cartController = new CartController();


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

    <title>FurniScape | SHOPPING CART</title>
</head>
<body>

<?php include "../layout/header.php"?>

    <?php include "../layout/flash.php"?>

    <h2 class="heading-style">YOUR SHOPPING CART</h2>
    
    <section class="m-10">

        <?php if (!empty($_SESSION['cart'])): ?>

        <table class="text-center border-collapse w-full">

            <thead class="bg-brown text-beige">
                <tr>
                    <th class="p-2.5 text-center">PRODUCT</th>
                    <th class="p-2.5 text-center">PRICE</th>
                    <th class="p-2.5 text-center">QUANTITY</th>
                    <th class="p-2.5 text-center">TOTAL</th>
                    <th class="p-2.5 text-center">ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
                ?>
                <tr>
                    <td>
                        <div class="flex flex-col">
                        <img src="/FurniScape/public/images/<?= $item['productImage'] ?>" alt="<?= $item['product_name'] ?>" class="h-30 w-30 object-contain rounded-lg">
                        <span><?= htmlspecialchars($item['product_name']) ?> </span>
                        </div>
                    </td>
                    <td>LKR <?= $item['price'] ?></td>
                    <td class="ml-5">
                        <form action="/FurniScape/app/views/customer/cart.php" method="post" class="flex items-center justify-center">
                            <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                            <button type="submit" name="action" value="decrease" class="px-2 bg-brown rounded-full font-bold text-beige hover:cursor-pointer">-</button>
                            <input type="text" value="<?= $item['quantity'] ?>" class="w-10 text-center  mx-1" readonly>
                            <button type="submit" name="action" value="increase" class="px-2 bg-brown rounded-full font-bold text-beige hover:cursor-pointer">+</button>
                        </form>
                    </td>
                    <td>LKR <?= $subtotal ?></td>
                    <td><a href="/FurniScape/app/controllers/CartController.php?action=remove&id=<?= $item['product_id'] ?>" class="text-red-600 text-xl"><i class="fa-solid fa-trash"></i></a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right font-bold p-4">TOTAL: </td>
                    <td colspan="2" class="font-bold p-4">LKR <?= $total ?></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right p-4">
                        <a href="/FurniScape/app/controllers/CartController.php?action=checkout" class="bg-brown font-montserrat font-semibold text-beige p-4 rounded-full cursor-pointer hover:bg-btn-hover-brown">PROCEED TO CHECKOUT</a>
                    </td>
                </tr>
            </tfoot>

        </table>
        <?php else: ?>
        <img src="../../../public/images/emptycart.jpg" alt="Empty cart image" class="mx-auto">
        <p class="text-center text-gray-600 text-lg font-montserrat tracking-wider">Your cart is empty. Go back and add some furniture!</p>
    </section>
        <?php endif; ?>


<?php include "../layout/footer.php"?>
    
</body>
</html>