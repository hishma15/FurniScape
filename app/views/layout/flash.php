<?php
// ensures whether the session started from index.php
if (session_status() === PHP_SESSION_NONE ){
    session_start();
}

?>

    <!-- Flash message display -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center max-w-lg mx-auto animate-fade" id="flash-success">
            <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            ?>

        </div>
    <?php endif; ?> 

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-center max-w-lg mx-auto animate-fade" id="flash-error">
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

<script>
    // Auto-hide flash messages after 3 seconds
    setTimeout(() => {
        const success = document.getElementById('flash-success');
        const error = document.getElementById('flash-error');
        if (success) success.style.display = 'none';
        if (error) error.style.display = 'none';
    }, 3000); 
</script>
