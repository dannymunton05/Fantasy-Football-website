<?php
// Get tokens
$time = time();
$results = ("SELECT * FROM password_reset WHERE selector = '$selector' AND expires = $expireStr");
$db->get_con()->query($results);
if ( empty( $results ) ) {
    return array('status'=>0,'message'=>'There was an error processing your request. Error Code: 002');
}
$auth_token = $results[0];
$calc = hash('sha256', hex2bin($validator));
// Validate tokens
if ( hash_equals( $calc, $auth_token) )  {
    $user = $email;
    if ( false === $user ) {
        return array('status'=>0,'message'=>'There was an error processing your request. Error Code: 003');
    }
    // Update password
    $update = "UPDATE userinfo (password) VALUES (password_hash($password, PASSWORD_DEFAULT)) WHERE email = '$email'";
    $db->get_con()->query($update);
    // Delete any existing password reset AND remember me tokens for this user
    $delete = "DELETE email FROM password_reset where email = '$email'";
    $db->get_con()->query($delete);
    $delete2 = "DELETE username from auth_tokens where username = $username";
    $db->get_con()->query($delete2);
    if ( $update == true ) {
        // New password. New session.
        session_destroy();
    
        return array('status'=>1,'message'=>'Password updated successfully. <a href="index.php">Login here</a>');
    }
}
?>
</html>
