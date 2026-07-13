<?php
declare(strict_types=1);
require_once __DIR__ . "/Settings.php";


    function GetAllBranches_DataAccess(string $Order = "ASC", int $Limit = -1, int $Offset = -1)
    {
        $Connection = null;
        $Results = [];

        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return [];
            }

            // Validate order direction
            $Order = strtoupper($Order);
            if (!in_array($Order, ["ASC", "DESC"])) 
            {
                $Order = "ASC";
            }

            // Base query with ORDER BY
            $Sql = "SELECT * FROM branches  ORDER BY BranchName $Order";
            $CountSql = "SELECT COUNT(*) AS TotalBranchesNum FROM branches ";

            // Add limit/offset if provided
            if ($Limit != -1 && $Offset != -1) 
            {
                $Sql .= " LIMIT " . intval($Limit) . " OFFSET " . intval($Offset);
            }

            // Execute main query
            $Stmt = $Connection->prepare($Sql);
            $Stmt->execute();
            $Results['Branches'] = $Stmt->fetchAll(PDO::FETCH_ASSOC);

            // Execute count query
            $Stmt2 = $Connection->prepare($CountSql);
            $Stmt2->execute();
            $Results['TotalBranchesNum'] = $Stmt2->fetch(PDO::FETCH_ASSOC)['TotalBranchesNum'];

            return $Results;

        } 
        catch (PDOException $e) 
        {
            return [];
        } 
        finally 
        {
            $Connection = null;
        }
    }

    function SearchBranchesByName_DataAccess(string $BranchName,  string $Order = "ASC",  int $Limit = -1,    int $Offset = -1)
    {
     
        $Connection = null;
        $Results = [];

        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return [];
            }

            $SearchTerm = "%$BranchName%";



            // Base query with ORDER BY
            $Sql = "SELECT * FROM branches 
                    WHERE BranchName LIKE :BranchName
                    ORDER BY BranchName $Order";

            $CountSql = "SELECT COUNT(*) AS TotalBranchesNum 
                        FROM branches 
                        WHERE BranchName LIKE :BranchName";

            // Add limit/offset if provided
            if ($Limit != -1 && $Offset != -1) 
            {
                $Sql .= " LIMIT " . intval($Limit) . " OFFSET " . intval($Offset);
            }

            // Fetch results
            $Stmt = $Connection->prepare($Sql);
            $Stmt->bindParam(":BranchName", $SearchTerm);
            $Stmt->execute();
            $Results['Branches'] = $Stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch count
            $Stmt2 = $Connection->prepare($CountSql);
            $Stmt2->bindParam(":BranchName", $SearchTerm);
            $Stmt2->execute();
            $Results['TotalBranchesNum'] = $Stmt2->fetch(PDO::FETCH_ASSOC)['TotalBranchesNum'];

            return $Results;

        } 
        catch (PDOException $e) 
        {
            return [];
        } 
        finally 
        {
            $Connection = null;
        }
    }


    /**
     * 
	 * return:  if the `BranchId` is exist return Branch info as `array`, if it does not exist return `false`, if there is an error return `null`
     */
    function GetBranchByBranchId_DataAccess(int $BranchId)
    {
     

        $Connection = null;

        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return null;
            }

         
            $Sql = "SELECT * FROM branches 
                    WHERE BranchId = :BranchId";

            $Stmt = $Connection->prepare($Sql);
            $Stmt->bindParam(":BranchId", $BranchId);
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


   /**
    * /
    * @param mixed $BranchInfo
    * @return bool|string|null
    *  if inesrt a row will return BranchId, if no insert a row will return 0 
    */
   function AddNewBranch_DataAccess($BranchInfo)       
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
                "INSERT INTO branches
                            (BranchName, BranchImgName)
                        VALUES
                        (
                            :BranchName,
                            :BranchImgName
                        )
                        "
            );
            $Stmt->bindValue(":BranchName", $BranchInfo["BranchName"]);
            $Stmt->bindValue(":BranchImgName", $BranchInfo["BranchImgName"]);
            $Stmt->execute();


            $BranchId = $Connection->lastInsertId();  

            return $BranchId; //if no insert row return 0
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
   function UpdateBranchByBranchId_DataAccess(int $BranchId, $UpdatedBranchInfo)       
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
            "    UPDATE  branches
                        SET
                            BranchName= :BranchName,
                            BranchImgName=:BranchImgName
                        WHERE BranchId = :BranchId
                    "
            );
            $Stmt->bindValue(":BranchId", $BranchId);
            $Stmt->bindValue(":BranchName", $UpdatedBranchInfo["BranchName"]);
            $Stmt->bindValue(":BranchImgName", $UpdatedBranchInfo["BranchImgName"]);
            $Stmt->execute();



        return $BranchId; 
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
   function DeleteBranchByBranchId_DataAccess(int $BranchId)       
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
            "DELETE FROM branches
                    WHERE BranchId = :BranchId"
            );
            $Stmt->bindValue(":BranchId", $BranchId);
            $Stmt->execute();



        return $BranchId; 
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