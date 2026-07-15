<?php
declare(strict_types=1);
require_once __DIR__ . "/Settings.php";
function CheckColNameDistributionProduct(string $ColName)
{
    $ColNames =
            array(
                    "DistributionProductId",
                    "PurchasedProductId",
                    "BranchId",
                    "BranchName",
                    "UserName",
                    "Quantity",
                    "PurchasePrice",
                    "FinalSellingPrice",
                    "Profit"
                 );

    if(in_array($ColName, $ColNames))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function SearchDistributionProductByColumnAndValue_DataAccess(string $SearchText, string $ColName, string $Order = "ASC", int $Limit = -1, int $Offset = -1)
{
    if(!CheckColNameDistributionProduct($ColName))
    {
        return null;
    }

    if(strtoupper($Order) != 'ASC' && strtoupper($Order) != 'DESC')
    {
        return null;
    }

    $Connection = null;
    $Results = [];

    try
    {
        $Connection = Get_PDO_Connection();
        if($Connection === null)
        {
            return [];
        }

        $SearchText = trim($SearchText);
        $SearchTerm = "%$SearchText%";

        if($ColName == "BranchName")
        {
            $Where = "branches.BranchName";
            $OrderBy = "branches.BranchName";
        }
        elseif($ColName == "UserName")
        {
            $Where = "users.UserName";
            $OrderBy = "users.UserName";
        }
        elseif($ColName == "PurchasePrice")
        {
            $Where = "purchased_products.PurchasePrice";
            $OrderBy = "purchased_products.PurchasePrice";
        }
        elseif($ColName == "Profit")
        {
            $Where = "(distribution_products.FinalSellingPrice - purchased_products.PurchasePrice)";
            $OrderBy = "(distribution_products.FinalSellingPrice - purchased_products.PurchasePrice)";
        }
        else
        {
            $Where = "distribution_products.$ColName";
            $OrderBy = "distribution_products.$ColName";
        }

        if($SearchText == "")
        {
            $Sql = "SELECT distribution_products.*,
                           branches.BranchName,
                           users.UserName,
                           purchased_products.PurchasePrice,
                           (distribution_products.FinalSellingPrice - purchased_products.PurchasePrice) AS Profit
                    FROM distribution_products
                    INNER JOIN branches
                    ON distribution_products.BranchId = branches.BranchId
                    LEFT JOIN users
                    ON branches.CreatedUserId = users.UserId
                    INNER JOIN purchased_products
                    ON distribution_products.PurchasedProductId = purchased_products.PurchasedProductId
                    ORDER BY $OrderBy $Order";

            $CountSql = "SELECT COUNT(*) AS TotalCount
                         FROM distribution_products";
        }
        else
        {
            $Sql = "SELECT distribution_products.*,
                           branches.BranchName,
                           users.UserName,
                           purchased_products.PurchasePrice,
                           (distribution_products.FinalSellingPrice - purchased_products.PurchasePrice) AS Profit
                    FROM distribution_products
                    INNER JOIN branches
                    ON distribution_products.BranchId = branches.BranchId
                    LEFT JOIN users
                    ON branches.CreatedUserId = users.UserId
                    INNER JOIN purchased_products
                    ON distribution_products.PurchasedProductId = purchased_products.PurchasedProductId
                    WHERE $Where LIKE :SearchTerm
                    ORDER BY $OrderBy $Order";

            $CountSql = "SELECT COUNT(*) AS TotalCount
                         FROM distribution_products
                         INNER JOIN branches
                         ON distribution_products.BranchId = branches.BranchId
                         LEFT JOIN users
                         ON branches.CreatedUserId = users.UserId
                         INNER JOIN purchased_products
                         ON distribution_products.PurchasedProductId = purchased_products.PurchasedProductId
                         WHERE $Where LIKE :SearchTerm";
        }

        if($Limit != -1 && $Offset != -1)
        {
            $Sql .= " LIMIT " . intval($Limit) . " OFFSET " . intval($Offset);
        }

        $Stmt = $Connection->prepare($Sql);

        if($SearchText != "")
        {
            $Stmt->bindParam(":SearchTerm", $SearchTerm);
        }

        $Stmt->execute();
        $Results['DistributionProducts'] = $Stmt->fetchAll(PDO::FETCH_ASSOC);

        $Stmt2 = $Connection->prepare($CountSql);

        if($SearchText != "")
        {
            $Stmt2->bindParam(":SearchTerm", $SearchTerm);
        }

        $Stmt2->execute();
        $Results['TotalDistributionProductsNum'] = $Stmt2->fetch(PDO::FETCH_ASSOC)['TotalCount'];

        return $Results;
    }
    catch(PDOException $e)
    {
        return [];
    }
    finally
    {
        $Connection = null;
    }
}
    function AddNewDistributionProduct_DataAccess(array $DistributionProductInfo)
    {
        $Connection = null;

        try
        {
            if(!isset(
                $DistributionProductInfo['PurchasedProductId'],
                $DistributionProductInfo['BranchId'],
                $DistributionProductInfo['Quantity'],
                $DistributionProductInfo['FinalSellingPrice'],
                $DistributionProductInfo['ExportToBranchDateTime'],
                ))
            {
                return null;
            }

            $Connection = Get_PDO_Connection();
            if ($Connection === null)
            {
                return null;
            }

            /*  Check Remaining Quantity */
            $CheckStmt = $Connection->prepare
            (
                "SELECT RemainingQuantity
                FROM purchased_products
                WHERE PurchasedProductId = :PurchasedProductId"
            );
            $CheckStmt->bindValue(":PurchasedProductId", $DistributionProductInfo['PurchasedProductId']);
            $CheckStmt->execute();

            $Product = $CheckStmt->fetch(PDO::FETCH_ASSOC);

            if(!$Product)
            {
                return null;
            }

            if($Product['RemainingQuantity'] < $DistributionProductInfo['Quantity'])
            {
                return -1; // not enough stock
            }


            /*  Update Remaining Quantity */

            $UpdateStmt = $Connection->prepare
            (
                "UPDATE purchased_products
                        SET RemainingQuantity = RemainingQuantity - :Quantity
                        WHERE PurchasedProductId = :PurchasedProductId"
            );
            $UpdateStmt->bindValue(":Quantity", $DistributionProductInfo['Quantity']);
            $UpdateStmt->bindValue(":PurchasedProductId", $DistributionProductInfo['PurchasedProductId']);
            $UpdateStmt->execute();


            /* Insert Distribution Product */
            $InsertStmt = $Connection->prepare
            (
                "INSERT INTO distribution_products
                            (PurchasedProductId, BranchId, CreatedDateTime, ExportToBranchDateTime, Quantity, FinalSellingPrice)
                        VALUES
                            (:PurchasedProductId, :BranchId, :CreatedDateTime, :ExportToBranchDateTime,  :Quantity, :FinalSellingPrice)"
            );
            $InsertStmt->bindValue(":PurchasedProductId",  $DistributionProductInfo['PurchasedProductId']);
            $InsertStmt->bindValue(":BranchId", $DistributionProductInfo['BranchId']);

            date_default_timezone_set('Asia/Amman');

            $CurrentDateTime = date('Y-m-d H:i:s');
            $InsertStmt->bindValue(":CreatedDateTime", $CurrentDateTime);

            $InsertStmt->bindValue(":ExportToBranchDateTime", $DistributionProductInfo['ExportToBranchDateTime']);
            $InsertStmt->bindValue(":Quantity", $DistributionProductInfo['Quantity']);
            $InsertStmt->bindValue(":FinalSellingPrice", $DistributionProductInfo['FinalSellingPrice']);
            $InsertStmt->execute();

            return (int)$Connection->lastInsertId();
        }
        catch (PDOException $e)
        {
            return null;
        }
        finally
        {
            $Connection = null;
        }
    }
?>