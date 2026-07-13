<?php
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if (!isset($_SESSION['CurrentUser'])) 
{
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Login%20Screens/login.php");
    exit;
}
