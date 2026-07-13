<?php
declare(strict_types=1);
require_once __DIR__ . "/Settings.php";

    function GetAllBranchesFinancialSummery_DataAccess()
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
                "SELECT 
                        branches.BranchId, branches.BranchName, branches.BranchImgName,
                        SUM(purchased_products.PurchasePrice * distribution_products.Quantity) AS TotalPurchasedAmount,
                        SUM(distribution_products.FinalSellingPrice * distribution_products.Quantity) AS TotalDistributedAmount
                FROM branches
                join distribution_products
                on branches.BranchId = distribution_products.BranchId
                join purchased_products
                on distribution_products.PurchasedProductId = purchased_products.PurchasedProductId
                GROUP by BranchId"
            );
            $Stmt->execute();

            return $Stmt->fetchAll(PDO::FETCH_ASSOC);

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