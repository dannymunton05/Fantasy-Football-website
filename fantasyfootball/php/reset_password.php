<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Football WorldCup </title>
    <link rel="stylesheet" href="ff.css">
</head>
<body> 
<!--Main section -->
<?php
require_once __DIR__ . '/db_connect.php';
// connecting to db
$db = new DB_CONNECT();
session_start();
$email = $_SESSION["email"];
// Create tokens
$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);
$url = sprintf('%s%s?%s', $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'], http_build_query([
    'selector' => $selector,
    'validator' => bin2hex($token)
]));
// Token expiration
$expires = new DateTime('NOW');
$expires->add(new DateInterval('PT01H')); // 1 hour
$expireStr = date_format($expires,'U');
// Delete any existing tokens for this user
$del = "DELETE FROM password_reset where email = '$email'";
$db->get_con()->query($del);
// Insert reset token into database
$hashValue = hash('sha256', $token);
$sql = "INSERT INTO password_reset (email, selector, token, expires) VALUES ((SELECT email from userinfo WHERE email = '$email'),
 '$selector', '$hashValue', $expireStr)";
$db->get_con()->query($sql);
// Send the email
// Recipient
$to = $email;
// Subject
$subject = 'Your password reset link';
// Message
$message = '<p>We recieved a password reset request. The link to reset your password is below. ';
$message .= 'If you did not make this request, you can ignore this email</p>';
$message .= '<p>Here is your password reset link:</br>';
$message .= sprintf('<a href="%s">%s</a></p>', $url, $url);
$message .= '<p>Thanks!</p>';
// Headers
$headers = "From: " . "danny" . " <" . "210426@esher.ac.uk" . ">\r\n";
$headers .= "Reply-To: " . "" . "\r\n";
$headers .= "Content-type: text/html\r\n";
// Send email
$sent = mail($to, $subject, $message, $headers);
// Check for tokens
$selector = filter_input(INPUT_GET, 'selector');
$validator = filter_input(INPUT_GET, 'validator');
if ( false !== ctype_xdigit( $selector ) && false !== ctype_xdigit( $validator ) ) :
?>
    <form action="reset_process.php" method="post">
        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
        <input type="password" class="text" name="password" placeholder="Enter your new password" required>
        <input type="submit" class="submit" value="Submit">
    </form>
    <p><a href="index.php">Login here</a></p>
<?php endif; ?>
