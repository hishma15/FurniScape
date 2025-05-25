<!-- SESSION VALIDATION (To protect page) -->
<?php
if (session_status() === PHP_SESSION_NONE ){
    session_start();
}

if (!isset($_SESSION['pending_admin'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="../../../public/css/output.css" rel="stylesheet">

    <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Verify OTP</title>
</head>
<body class="flex items-center justify-center h-screen bg-gray-300">
    
    <form method="POST" action="/FurniScape/public/index.php?route=verifyOTP" class="bg-beige p-6 rounded shadow-md w-full max-w-sm">
        <h2 class="text-2xl mb-4 font-bold text-center font-lustria text-black">Admin OTP Verification</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="text-red-500 text-sm mb-2"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <input type="text" name="otp" placeholder="Enter 6-digit OTP" class="w-full border px-4 py-2 rounded mb-4" required>
        <button type="submit" class="w-full bg-black text-white px-4 py-2 rounded font-montserrat tracking-widest font-semibold">VERIFY</button>
    </form>

    
</body>
</html>