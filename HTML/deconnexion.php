<?php
session_start();
unset($_SESSION['pseudo']);
unset($_SESISON['mail']);
unset($_SESSION['admin']);
$_SESSION['connecter'] = 0;
header('location: index.php');
exit();
exit;
?>
