<?php
require_once __DIR__ . "/../includes/auth.php";

require_once __DIR__ . "/../../Business/Business_Utils.php";
require_once __DIR__ . "/../../Business/User.php";
require_once __DIR__ ."/../includes/Presentation_Utils.php";




function GoBack()
{
    if(isset( $_SESSION['PageVars']['TmpUserImg']))
    {
        DeleteImageFromFolder_Business( $_SESSION['PageVars']['TmpUserImg'], "temp");
    }
    unset($_SESSION['PageVars']);
    GoBackPage();
    exit;
}
function UploadProductImgToTempFolder($InputName)
{
    


    if(isset($_SESSION['PageVars']['TmpUserImg']))
    {
        DeleteImageFromFolder_Business($_SESSION['PageVars']['TmpUserImg'],  "temp");
    }

    $ErrorCode = 0;
    $UserErrorMsg = "";
    $ImgName = UploadImgToFolder_Business($InputName, "temp",ErrorCode: $ErrorCode);
    
    if($ImgName==false)
    {
        switch ($ErrorCode)
        {
            case 1:
            case 2:
            case 8:
                $UserErrorMsg = "لم يتم رفع الصورة";
                break;
            case 3:
                $UserErrorMsg = "يجب أن لا يتجاوز حجم الصورة 
                                2MB";
                break;
            case 4:
                $UserErrorMsg="من فضلك استخدم صورة من ضمن الإمتدادات التالية:<br>
                                jpg, jpeg, png, webp.";
                break;
            case 5:
            case 6:
            case 7:
                $UserErrorMsg = "من فضلك ارفع ملف من نوع صورة فقط";
                break;
            default:
                $UserErrorMsg = "";
        }
        $_SESSION['PageVars']['UserImgUploadError']= $UserErrorMsg ; 
    }
    else
    {
       $_SESSION['PageVars']['TmpUserImg']  =$ImgName;
    }
}

function SaveUpdatedUserInfo($UpdatedUserInfo)
{

        $existingUser = GetUserByUserName_Business($UpdatedUserInfo['UserName']);
        if (isset($existingUser['UserId']) && $existingUser['UserId'] != $_SESSION['CurrentUser']['UserId'])
        {
            $_SESSION['ShowErrorUserName'] = true;
        }
        else
        {
            if
            (
                $UpdatedUserInfo['UserName']  == $_SESSION['CurrentUser']['UserName'] &&
                $UpdatedUserInfo['FirstName'] == $_SESSION['CurrentUser']['FirstName'] &&
                $UpdatedUserInfo['LastName']  == $_SESSION['CurrentUser']['LastName'] && 
                $UpdatedUserInfo['Email']     == $_SESSION['CurrentUser']['Email'] && 
                $UpdatedUserInfo['Phone']     == $_SESSION['CurrentUser']['Phone'] && 
                $UpdatedUserInfo['Address']   == $_SESSION['CurrentUser']['Address'] && 
                $UpdatedUserInfo['DoB']       == $_SESSION['CurrentUser']['DoB'] && 
                !isset($_SESSION['PageVars']['TmpUserImg'])
            )
            {
                $_SESSION['PageVars']['UpdatedInfoStatus'] = 0;
                return;
            }

            // Move temp image to final
            if (!empty( $_SESSION['PageVars']['TmpUserImg']))
            {
                $UpdatedUserInfo['PersonalImgName'] = $_SESSION['PageVars']['TmpUserImg'];
                MoveImgToAnotherFolder_Business( $_SESSION['PageVars']['TmpUserImg'], "temp", "users");
                unset( $_SESSION['PageVars']['TmpUserImg']);
            }

            // Update DB
            if (UpdateUserInfoByUserId_Business($_SESSION['CurrentUser']['UserId'], $UpdatedUserInfo))
            {
                $_SESSION['CurrentUser'] = GetUserById_Business($_SESSION['CurrentUser']['UserId']);
                $userImgName = $_SESSION['CurrentUser']['PersonalImgName'] ?? '';

                $_SESSION['CurrentUser']['UserImgPath'] = $userImgName
                    ? "/Project%20Files/Basic%20Version/uploads/users/" . rawurlencode($userImgName)
                    : "/Project%20Files/Basic%20Version/uploads/users/default.png";

                $_SESSION['PageVars']['UpdatedInfoStatus'] = 1;

            }
            else 
            {
                $_SESSION['PageVars']['UpdatedInfoStatus'] = -1;
            }
        }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // back button
    if (isset($_POST['go_back']))
    {
        GoBack();
 
    }

    // temp imge upload
    else if (isset($_FILES['temp_image']) && !empty($_FILES['temp_image']['name']))
    {
        UploadProductImgToTempFolder("temp_image");
  
    }

    // Save Info
    else if (isset($_POST['save_info']))
    {
        $UpdatedUserInfo['UserName']  = trim($_POST['username']);
        $UpdatedUserInfo['FirstName'] = trim($_POST['firstname']);
        $UpdatedUserInfo['LastName']  = trim($_POST['lastname']);
        $UpdatedUserInfo['Email']     = trim($_POST['email']);
        $UpdatedUserInfo['Phone']     = trim($_POST['phone']);
        $UpdatedUserInfo['Address']   = trim($_POST['address']);
        $UpdatedUserInfo['DoB']       = trim($_POST['dob']);
        $UpdatedUserInfo['PersonalImgName'] = $_SESSION['CurrentUser']['PersonalImgName'];
        SaveUpdatedUserInfo($UpdatedUserInfo);
    }

    header("Location: ../Screens/User Profile Screens/edit_user_info.php");
    exit;

}

