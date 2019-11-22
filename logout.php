<?php
session_start();
session_destroy();
unset($_SESSION['access_token']);
header('Location:index.php');
?>