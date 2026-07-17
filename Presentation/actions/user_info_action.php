<?php
require_once __DIR__ . "/../includes/auth.php";




// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{   
    // Go back to previous page
    if (isset($_POST['go_back'])) 
    {
        GoBackPage();
        exit;
    }


    header("Location: " . $_SERVER['HTTP_REFERER'] ?? "/Project%20Files/Basic%20Version/Presentation/Screens/User Profile Screens/user_info.php");
    exit;
}
