<?php 
session_start();
if(!isset($_SESSION['username']))
{
header( 'Location: login.php' ); 
}
else
{

//session_unset();
unset($_SESSION["username"]);
unset($_SESSION["userid"]);
unset($_SESSION["Luserid"]);

// EMAIL VERIFICATION SESSION
unset($_SESSION["activation-username"]);
unset($_SESSION["email"]);
unset($_SESSION["activationcode"]);

// Destroy the session.
//session_destroy();

header( 'Location: login.php' );
}
?>