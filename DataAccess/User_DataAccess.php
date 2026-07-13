<?php
declare(strict_types=1);
require_once __DIR__ . "/Settings.php";

    function GetUserByUserId_DataAccess(int $UserId)
    {
        $Connection = null;
        $Stmt = null;

        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return null;
            }

            $Stmt = $Connection->prepare
            (
                "SELECT * FROM users WHERE UserId = :UserId"
            );
            $Stmt->bindParam(":UserId", $UserId);
            $Stmt->execute();

            return $Stmt->fetch(PDO::FETCH_ASSOC);

        } 
        catch (PDOException $e)
        {
            return null;

        } 
        finally 
        {
            $Stmt = null;
            $Connection = null;
        }
    }

    function GetUserByUserName_DataAccess(string $UserName)
    {
        $Connection = null;
        $Stmt = null;

        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return null;
            }

            $Stmt = $Connection->prepare
            (
                "SELECT * FROM users WHERE UserName = :UserName"
            );
            $Stmt->bindParam(":UserName", $UserName);
            $Stmt->execute();

            return $Stmt->fetch(PDO::FETCH_ASSOC);

        } 
        catch (PDOException $e)
        {
            return null;

        } 
        finally 
        {
            $Stmt = null;
            $Connection = null;
        }
    }
    
    function GetUserByUserNameAndPass_DataAccess(string $UserName, string $Password)
    {
        $User =GetUserByUserName_DataAccess($UserName);
        
        if($User  != false && $User['Password'] ==  hash('sha256', $Password)) 
        {
            unset($User['Password']);
            return $User;
        }
        return false;

    }
    function GetUserByEmail_DataAccess(string $Email)
    {
           $Connection = null;
        $Stmt = null;

        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return null;
            }

            $Stmt = $Connection->prepare
            (
                "SELECT * FROM vw_full_users_info WHERE Email = :Email"
            );
            $Stmt->bindParam(":Email", $Email);
            $Stmt->execute();

            return $Stmt->fetch(PDO::FETCH_ASSOC);

        } 
        catch (PDOException $e)
        {
            return null;

        } 
        finally 
        {
            $Stmt = null;
            $Connection = null;
        }
    }
    function GetUserByPhone_DataAccess(string $Phone)
    {
           $Connection = null;
        $Stmt = null;

        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return null;
            }

            $Stmt = $Connection->prepare
            (
                "SELECT * FROM vw_full_users_info WHERE Phone = :Phone"
            );
            $Stmt->bindParam(":Phone", $Phone);
            $Stmt->execute();

            return $Stmt->fetch(PDO::FETCH_ASSOC);

        } 
        catch (PDOException $e)
        {
            return null;

        } 
        finally 
        {
            $Stmt = null;
            $Connection = null;
        }
    }
    function UpdateUserPasswordById_DataAccess(int $UserId, string $NewPassword)
    {
        $Connection = null;
        $Stmt = null;

        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return null;
            }

            $Stmt = $Connection->prepare
            (
                "
                UPDATE users
                Set Password = :NewPassword
                where UserId = :UserId
                "
            );
            $Stmt->bindParam(":UserId", $UserId);
            $Stmt->bindParam(":NewPassword", $NewPassword);
            $Stmt->execute();

           return $Stmt->rowCount();

        } 
        catch (PDOException $e)
        {
            return null;

        } 
        finally 
        {
            $Stmt = null;
            $Connection = null;
        }
    }

    function UpdateUserNameAndPersonInfoByUserId_DataAccess(int $UserId, $UpdatedUserInfo, int &$ErrorNum = 0)
    {
        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return null;
            }

            //  Check if the user exists
            $Stmt = $Connection->prepare
            (
                " SELECT PersonId FROM users WHERE UserId = :UserId"
            );
            $Stmt->bindParam(":UserId", $UserId);
            $Stmt->execute();

            $Row = $Stmt->fetch(PDO::FETCH_ASSOC);
            if (!$Row) 
            {
                $ErrorNum = 1;
                return null; // user not found
            }

            //  Check username uniqueness
            $Check = $Connection->prepare
            (
        "SELECT UserId FROM users
                WHERE UserName = :NewUserName AND UserId != :UserId"
            );
            $Check->bindParam(":NewUserName", $UpdatedUserInfo['UserName']);
            $Check->bindParam(":UserId", $UserId);
            $Check->execute();

            if ($Check->fetch(PDO::FETCH_ASSOC)) 
            {
                $ErrorNum = 2;
                return null; // username already used
            }

            // Perform UPDATE
            $Stmt2 = $Connection->prepare
            (
            "UPDATE users 
                    SET 
                        UserName = :NewUserName,
                        FirstName = :FirstName,
                        LastName  = :LastName,
                        DoB = :DoB,
                        Gender = :Gender,
                        Phone = :Phone,
                        Email = :Email,
                        Address = :Address,
                        PersonalImgName = :PersonalImgName
                    WHERE UserId = :UserId
                    "
            );

            $Stmt2->bindParam(":UserId", $UserId);
            $Stmt2->bindParam(":NewUserName", $UpdatedUserInfo['UserName']);
            $Stmt2->bindParam(":FirstName", $UpdatedUserInfo['FirstName']);
            $Stmt2->bindParam(":LastName", $UpdatedUserInfo['LastName']);
            $Stmt2->bindParam(":DoB", $UpdatedUserInfo['DoB']);
            $Stmt2->bindParam(":Gender", $UpdatedUserInfo['Gender']);
            $Stmt2->bindParam(":Phone", $UpdatedUserInfo['Phone']);
            $Stmt2->bindParam(":Email", $UpdatedUserInfo['Email']);
            $Stmt2->bindParam(":Address", $UpdatedUserInfo['Address']);
            $Stmt2->bindParam(":PersonalImgName", $UpdatedUserInfo['PersonalImgName']);

            $Stmt2->execute();
            return $UserId;
        }
        catch (PDOException $e) 
        {
            return null;    
        }
        finally 
        {
            $Stmt = null;
            $Connection = null;
        }
    }



?>