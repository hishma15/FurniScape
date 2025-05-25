<!-- SESSION VALIDATION (To protect page) -->
<?php
if (session_status() === PHP_SESSION_NONE ){
    session_start();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /FurniScape/app/views/admin/login.php");
    exit;
}

require_once '../../controllers/ConsultationController.php';
$controller = new ConsultationController();

$controller->updateStatus(); 
$consultations = $controller->list(); // getAll consultations
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <link href="../../../public/css/output.css" rel="stylesheet">

    <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>FurniScape Admin Manage Consultation</title>
</head>

<body class="relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-center h-screen brightness-110 contrast-90">

    <!-- <section class=" relative bg-[url('../../public/images/admin-back.jpg')] bg-cover bg-center h-full brightness-110 contrast-90"> -->

    <?php include "../layout/adminHeader.php"?>

    <?php include "../layout/flash.php" ?>

    <?php include "../layout/adminSideMenu.php"?>

    <div class="ml-52 p-6">
        <h1 class="text-3xl font-lustria text-center"> MANAGE CONSULTATION</h1>

        <div class="p-4 bg-beige/80 rounded-lg shadow-lg max-w-6xl m-2">
            <div class="overflow-x-auto overflow-y-auto max-h-[600px]">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Consultation ID</th>
                            <th class="border px-4 py-2">User ID</th>
                            <th class="border px-4 py-2">Preferred Date</th>
                            <th class="border px-4 py-2">Preferred Time</th>
                            <th class="border px-4 py-2">Mode</th>
                            <th class="border px-4 py-2">Topic</th>
                            <th class="border px-4 py-2">Description</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultations as $consult): ?>
                        <tr>
                            <form method="POST">
                                <td class="border px-4 py-2">
                                    <input type="hidden" name="consultation_id" value="<?= $consult['id']; ?>" />
                                    <?= $consult['id']; ?>
                                </td>
                                <td class="border px-4 py-2"><?= htmlspecialchars($consult['user_id']); ?></td>
                                <td class="border px-4 py-2"><?= htmlspecialchars($consult['preferred_date']); ?></td>
                                <td class="border px-4 py-2"><?= htmlspecialchars($consult['preferred_time']); ?></td>
                                <td class="border px-4 py-2"><?= htmlspecialchars($consult['mode']); ?></td>
                                <td class="border px-4 py-2"><?= htmlspecialchars($consult['topic']); ?></td>
                                <td class="border px-4 py-2 max-w-xs truncate" title="<?= htmlspecialchars($consult['description']); ?>">
                                    <?= htmlspecialchars($consult['description']); ?>
                                </td>
                                <td class="border px-4 py-2">
                                    <select name="status" class="admin-input-table">
                                        <?php
                                        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
                                        foreach ($statuses as $status):
                                        ?>
                                        <option value="<?= $status ?>" <?= $consult['status'] === $status ? 'selected' : '' ?>><?= $status ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="border px-4 py-2">
                                    <button type="submit" class="bg-brown text-beige font-semibold px-4 py-2 rounded-full hover:bg-btn-hover-brown cursor-pointer">
                                        Update
                                    </button>
                                </td>
                            </form>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    
    



    <!-- </section> -->
    
    
</body>
</html>