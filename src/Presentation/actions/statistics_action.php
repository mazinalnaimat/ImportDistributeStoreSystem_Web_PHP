<?php
require_once __DIR__ . "/../includes/auth.php";



function  GoBack()
{
    unset($_SESSION["PageVars"]);
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard Screens/dashboard.php");
    exit;

}

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    // Go back
    if (isset($_GET['go_back']))
    {   
        GoBack();  
   
    }

}

?>