<?php

require_once __DIR__ . "/../../Business/User.php";
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
function Login($UserName, $Password)
{
    $User = GetUserByUserNameAndPass_DataAccess($UserName, $Password);

    if ($User) 
    {
        $_SESSION['CurrentUser'] = $User;

        $userImgName = $_SESSION['CurrentUser']['PersonalImgName'] ?? '';

        $_SESSION['CurrentUser']['UserImgPath'] = $userImgName
            ? "/Project%20Files/Basic%20Version/uploads/users/" . rawurlencode($userImgName)
            : "/Project%20Files/Basic%20Version/uploads/users/default.png";

        header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/dashboard.php");
        exit;
    }
    else
    {
        // Wrong login
        $_SESSION['ShowYourInfoWrong'] = true;
        header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Login%20Screens/login.php");
        exit;
    }

}
function ForgotPassword()
{
    $_SESSION['ShowConnectYourAdmin'] = true;
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Login%20Screens/login.php");
    exit;
}




if ($_SERVER["REQUEST_METHOD"] === "GET") 
{
    if(isset($_GET['login']))
    {
        $UserName = $_GET["UserName"] ?? '';
        $Password = $_GET["Password"] ?? '';
        login($UserName, $Password);

    }

    // Forgot password
    else if (isset($_GET['forgot'])) 
    {
        ForgotPassword();
    }


    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Login%20Screens/login.php");
    exit;
}
