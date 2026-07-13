<?php
require_once __DIR__ . "/../includes/auth.php";


// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['logout'])) 
{
    // Destroy session and redirect to login page
    session_unset();
    session_destroy();

    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Login Screens/login.php");
    exit;
}
