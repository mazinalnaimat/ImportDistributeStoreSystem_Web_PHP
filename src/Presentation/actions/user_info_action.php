<?php
require_once __DIR__ . "/../includes/auth.php";




// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{   



    header("Location: " . $_SERVER['HTTP_REFERER'] ?? "/Project%20Files/Basic%20Version/Presentation/Screens/User Profile Screens/user_info.php");
    exit;
}
