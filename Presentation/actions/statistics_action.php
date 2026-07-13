<?php
require_once __DIR__ . "/../includes/auth.php";

require_once __DIR__ ."/../includes/Presentation_Utils.php";



if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
   
    // Go back
    if (isset($_POST['go_back']))
    {
        GoBackPage();
        unset($_SESSION["PageVars"]);
        exit;
    }
    $redirect = $_SERVER['HTTP_REFERER'] ?? "/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard Screens/statistics.php";
    header("Location: " . $redirect);
    exit;
}

?>