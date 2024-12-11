<?php

// Start session
session_start();

// Retrieve session data
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

unset($_SESSION['sessData']);
session_destroy();

header("Location:index.php");

?>