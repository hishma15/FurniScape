<?php
if (session_status() === PHP_SESSION_NONE ){
    session_start();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header("Location: /FurniScape/app/views/customer/customerLogin.php");
    exit;
}

require_once '../../controllers/ConsultationController.php';
require_once '../../../config/database.php';

$consultationController = new ConsultationController();

// Fetch the user details array from the controller
$user = $consultationController->getUserDetails();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="../../public/css/output.css" rel="stylesheet">

    <!-- FontAwesome & Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Lustria&display=swap" rel="stylesheet">

    <title>Book Consultation</title>

</head>
<body>

<?php include "../layout/header.php" ?>

<section class="relative bg-[url('../../public/images/loginback.png')] bg-cover bg-center min-h-screen flex items-center justify-center">
    <!-- FORM -->
    <div class="bg-beige/80 p-8 rounded-lg shadow-lg w-full md:max-w-xl">
        <h2 class="font-lustria font-semibold text-3xl text-center mb-6">LETS DESIGN YOUR DREAM SPACE</h2>

        <form action="/FurniScape/app/controllers/ConsultationController.php?action=bookConsultation" method="POST">

            <div class="mb-4">
                <label for="name" class="block mb-1 text-sm font-semibold">Full Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?>" placeholder="Name" readonly class="border border-black-400 rounded-full py-2 px-10 w-full">
            </div>

            <div class="mb-4">
                <label for="email" class="block mb-1 text-sm font-semibold">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" placeholder="Email" readonly class="border border-black-400 rounded-full py-2 px-10 w-full">
            </div>

            <div class="mb-4">
                <label for="phone" class="block mb-1 text-sm font-semibold">Phone No</label>
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="Phone" class="border border-black-400 rounded-full py-2 px-10 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 text-sm font-semibold">Preferred Date</label>
                <input type="date" name="preferred_date" required class="border border-black-400 rounded-full py-2 px-4 w-full">
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-semibold">Preferred Time</label>
                <input type="time" name="preferred_time" required class="border border-black-400 rounded-full py-2 px-4 w-full">
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-semibold">Consultation Mode</label>
                <select name="mode" required class="border border-black-400 rounded-full py-2 px-4 w-full">
                    <option value="">-- Select Mode --</option>
                    <option value="in_store">In-store</option>
                    <option value="phone_call">Phone Call</option>
                    <option value="video_call">Video Call</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-semibold">Topic</label>
                <input type="text" name="topic" placeholder="Topic of Consultation" required class="border border-black-400 rounded-full py-2 px-4 w-full">
            </div>

            <div class="mb-6">
                <label class="block mb-1 text-sm font-semibold">Description</label>
                <textarea name="description" placeholder="Describe your consultation need..." rows="4" required class="border border-black-400 rounded-xl py-2 px-4 w-full"></textarea>
            </div>

            <button type="submit" class="bg-brown text-white text-xl font-semibold rounded-full py-3 px-6 w-full hover:bg-btn-hover-brown">
                Book Consultation
            </button>
        </form>
    </div>

</section>


    
</body>
</html>