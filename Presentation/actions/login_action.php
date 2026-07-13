<?php

require_once __DIR__ . "/../../Business/User.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
    // Forgot password
    if (isset($_POST['action']) && $_POST['action'] === 'forgot') 
    {
        $_SESSION['ShowConnectYourAdmin'] = true;
        header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Login%20Screens/login.php");
        exit;
    }

    // Normal login
    $UserName = $_POST["UserName"] ?? '';
    $Password = $_POST["Password"] ?? '';

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

    // Wrong login
    $_SESSION['ShowYourInfoWrong'] = true;
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Login%20Screens/login.php");
    exit;
}
