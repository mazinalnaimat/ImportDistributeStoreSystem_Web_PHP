<?php
require_once __DIR__ . "/../../Business/User.php";


function CheckUserNameAndPassword($UserName, $Password)
{  

    $User = GetUserByUserNameAndPass_Business($UserName, $Password);

    if ($User)
    {
        $_SESSION['PageVars']['Step'] = 2;
        $_SESSION['PageVars']['UserId'] = $User['UserId'];
        $_SESSION['PageVars']['UserName'] = $UserName;
    }
    else
    {
        if (!isset($_SESSION['CurrentUser']))
            $_SESSION['PageVars']['ErrorMessage'] = "اسم المستخدم أو كلمة المرور غير صحيحة.";
        else
            $_SESSION['PageVars']['ErrorMessage'] = "كلمة المرور غير صحيحة.";
    }
}

function ChangePassword($NewPassword, $ConfirmNewPassword)
{
        $UserId = $_SESSION['PageVars']['UserId'] ?? 0;



        if (strlen($NewPassword) < 8)
        {
            $_SESSION['PageVars']['ErrorMessage'] = "كلمة المرور يجب أن تكون 8 أحرف على الأقل.";
        }
        else if ($NewPassword !== $ConfirmNewPassword)
        {
            $_SESSION['PageVars']['ErrorMessage'] = "كلمتا المرور غير متطابقتين.";
        }
        else if (GetUserByUserNameAndPass_Business($_SESSION['PageVars']['UserName'], $NewPassword) != null)
        {
            $_SESSION['PageVars']['ErrorMessage'] = "لقد أدخلت نفس كلمة المرور الحالية!";
        }
        else
        {
            if (UpdateUserPasswordById_Business($UserId, $NewPassword))
            {
                $_SESSION['PageVars']['Step'] = 3;
            }
            else
            {
                $_SESSION['PageVars']['ErrorMessage'] = "حدث خطأ، حاول لاحقًا.";
            }
        }
}

if ($_SERVER["REQUEST_METHOD"] === "POST")
{

    // Check UserName And Password
    if (isset($_POST['check_user']))
    {
        $UserName = $_POST['UserName'];
        $Password = $_POST['CurrentPassword'];
        CheckUserNameAndPassword($UserName, $Password);

    }

    // Change Password
    else if (isset($_POST['change_password']))
    {
        $NewPassword = $_POST['NewPassword'];
        $ConfirmPassword = $_POST['ConfirmNewPassword'];
        ChangePassword($NewPassword, $ConfirmPassword);

    }

    // Back Step button
    else if (isset($_POST['back']))
    {
        if (($_SESSION['PageVars']['Step'] ?? 1) == 2)
            $_SESSION['PageVars']['Step'] = 1;
        else 
        {
            unset($_SESSION['PageVars']);
            GoBackPage();
            exit;
        }
    }

    //Back to previous page
    else if (isset($_POST['go_back']))
    {
        unset($_SESSION['PageVars']);
        GoBackPage();
        exit;
    }

    $redirect = $_SERVER['HTTP_REFERER'] 
        ?? '/Project%20Files/Basic%20Version/Presentation/Screens/User Profile Screens/reset_password.php';

    header("Location: " . $redirect);
    exit;
}
