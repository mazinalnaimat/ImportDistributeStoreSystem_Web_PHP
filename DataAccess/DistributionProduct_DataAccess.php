<?php
declare(strict_types=1);
require_once __DIR__ . "/Settings.php";




function AddNewDistributionProduct_DataAccess(array $DistributionProductInfo)
{
    $Connection = null;

    try
    {
        if(!isset(
            $DistributionProductInfo['PurchasedProductId'],
            $DistributionProductInfo['BranchId'],
            $DistributionProductInfo['Quantity'],
            $DistributionProductInfo['FinalSellingPrice']))
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
                        (PurchasedProductId, BranchId, Quantity, FinalSellingPrice)
                    VALUES
                        (:PurchasedProductId, :BranchId, :Quantity, :FinalSellingPrice)"
        );
        $InsertStmt->bindValue(":PurchasedProductId",  $DistributionProductInfo['PurchasedProductId']);
        $InsertStmt->bindValue(":BranchId", $DistributionProductInfo['BranchId']);
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