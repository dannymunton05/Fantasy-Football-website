<!--Main section -->
<form action="" method="post">
    <input type="text" class="text" name="email" id="email" placeholder="Enter your email address" required>
    <input type="submit" class="submit" onclick="reset_password.php" value="Submit">
</form>
<?php
require_once __DIR__ . '/db_connect.php';
// connecting to db
$db = new DB_CONNECT();
session_start();
$_SESSION["email"] = $_POST["email"];
?>
