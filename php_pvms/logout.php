<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Log out the user
logoutUser();

// Redirect to login page
header("Location: login.php");
exit;
?>