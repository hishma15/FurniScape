
<?php
echo "PHP is working!";  // This is a basic test to check if PHP is being processed.
echo password_hash("admin123", PASSWORD_BCRYPT);
?>

<?php
// to get the hashed password.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo password_hash("admin123", PASSWORD_BCRYPT);

?>