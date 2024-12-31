<?php
$servername = "localhost";
$username = "sarah";
$password = "Thisisan3xampl3";
$dbname = "seimens_form";

// <!-- // Create connection -->
$conn = new mysqli($servername, $username, $password, $dbname);

// <!-- // Check connection -->
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

<?php phpinfo(); ?>
<?php echo "Hello World"; ?>

