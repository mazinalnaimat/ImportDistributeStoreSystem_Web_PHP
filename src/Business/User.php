<?php
declare(strict_types=1);
require_once __DIR__ . "/../DataAccess/User_DataAccess.php";

    function GetCustomUserInfo_Business($User)//Internal in this file use function 
    {
        $CustomUserInfo["UserId"]= $User["UserId"];
        $CustomUserInfo["UserName"]= $User["UserName"];
        $CustomUserInfo["FirstName"]= $User["FirstName"];
        $CustomUserInfo["LastName"]= $User["LastName"];
        $CustomUserInfo["Gender"]= $User["Gender"];
        $CustomUserInfo["DoB"]= $User["DoB"];
        $CustomUserInfo["Phone"]= $User["Phone"];
        $CustomUserInfo["Email"]= $User["Email"];
        $CustomUserInfo["Address"]= $User["Address"];
        $CustomUserInfo["PersonalImgName"]= $User["PersonalImgName"];
        return $CustomUserInfo;
    }

    function GetUserById_Business(int $UserId)
    {         
        $User = GetUserByUserId_DataAccess($UserId); 
        if($User)
            return  GetCustomUserInfo_Business($User);
        return $User;
    }


    function GetUserByUserName_Business(string $UserName)
    {         
        
        $User = GetUserByUserName_DataAccess($UserName);
        if($User)
            return  GetCustomUserInfo_Business($User);
        return $User;
    }

    function GetUserByUserNameAndPass_Business(string $UserName, string $Password)
    {
        $Password =hash("sha256", $Password);
        $User = GetUserByUserNameAndPass_DataAccess($UserName, $Password);
        if($User)
            return  GetCustomUserInfo_Business($User);
        return $User;
    }

    function UpdateUserPasswordById_Business(int $UserId, string $NewPassword)
    {
        $NewPassword = hash("sha256", $NewPassword);
        if( UpdateUserPasswordById_DataAccess($UserId, $NewPassword) >0)
            return true;
        return false;
    }
    
    function UpdateUserInfoByUserId_Business(int $UserId, $UpdatedUserInfo, int &$ErrorNum=0)
    {
        return UpdateUserInfoByUserId_DataAccess($UserId, $UpdatedUserInfo, $ErrorNum);
    }


?>