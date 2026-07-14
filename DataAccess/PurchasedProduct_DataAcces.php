<?php
declare(strict_types=1);
require_once __DIR__ . "/Settings.php";
    enum AvailableProductFilter: string 
    {
        case All = 'all';
        case Available = 'available';
        case NotAvailable = 'not_available';
    }


    function GetAllPurchasedProducts_DataAccess(string $ColName = "PurchasedProductName", string $Order = "ASC",  AvailableProductFilter $AvailableProductFilter = AvailableProductFilter::All,int $Limit = -1, int $Offset = -1)
    {
        $AllowedColumns = 
        [
            "PurchasedProductName",
            "Quantity",
            "RemainingQuantity",
            "ImportArrivalDateTime",
            "PurchasePrice",
            "BaseSellingPrice",
            "SupplierName"
        ];

        $Connection = null;
        $Results = [];

        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return [];
            }

            // Validate column name
            if (!in_array($ColName, $AllowedColumns)) 
            {
                $ColName = "PurchasedProductName";
            }

            // Validate order direction
            $Order = strtoupper($Order);
            if (!in_array($Order, ["ASC", "DESC"])) 
            {
                $Order = "ASC";
            }

            // Handle enum filter
            $Where = "";
            switch ($AvailableProductFilter->value) 
            {
                case AvailableProductFilter::Available->value:
                    $Where = "WHERE RemainingQuantity > 0";
                    break;

                case AvailableProductFilter::NotAvailable->value:
                    $Where = "WHERE RemainingQuantity = 0";
                    break;

                default:
                    $Where = "";
            }

            // Base query with ORDER BY
            $Sql = "SELECT * FROM purchased_products $Where ORDER BY $ColName $Order";
            $CountSql = "SELECT COUNT(*) AS TotalPurchasedProductsNum FROM purchased_products $Where";

            // Add limit/offset if provided
            if ($Limit != -1 && $Offset != -1) 
            {
                $Sql .= " LIMIT " . intval($Limit) . " OFFSET " . intval($Offset);
            }

            // Execute main query
            $Stmt = $Connection->prepare($Sql);
            $Stmt->execute();
            $Results['PurchasedProducts'] = $Stmt->fetchAll(PDO::FETCH_ASSOC);

            // Execute count query
            $Stmt2 = $Connection->prepare($CountSql);
            $Stmt2->execute();
            $Results['TotalPurchasedProductsNum'] = $Stmt2->fetch(PDO::FETCH_ASSOC)['TotalPurchasedProductsNum'];

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

    function SearchPurchasedProductsByName_DataAccess(string $PurchasedProductName, string $ColName = "PurchasedProductName", string $Order = "ASC", AvailableProductFilter $AvailableProductFilter = AvailableProductFilter::All,  int $Limit = -1,    int $Offset = -1)
    {
        $AllowedColumns = 
        [
            "PurchasedProductName",
            "Quantity",
            "RemainingQuantity",
            "ImportArrivalDateTime",
            "PurchasePrice",
            "BaseSellingPrice",
            "SupplierName"
        ];

        $Connection = null;
        $Results = [];

        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return [];
            }

            $SearchTerm = "%$PurchasedProductName%";

            // Validate column name
            if (!in_array($ColName, $AllowedColumns)) 
            {
                $ColName = "PurchasedProductName";
            }

            // Validate order direction
            $Order = strtoupper($Order);
            if (!in_array($Order, ["ASC", "DESC"])) 
            {
                $Order = "ASC";
            }

            // Handle enum filter
            $WhereAvailable = "";
            switch ($AvailableProductFilter->value) 
            {
                case AvailableProductFilter::Available->value:
                    $WhereAvailable = "AND RemainingQuantity > 0";
                    break;

                case AvailableProductFilter::NotAvailable->value:
                    $WhereAvailable = "AND RemainingQuantity = 0";
                    break;

                default:
                    $WhereAvailable = "";
            }

            // Base query with ORDER BY
            $Sql = "SELECT * FROM purchased_products 
                    WHERE PurchasedProductName LIKE :PurchasedProductName
                    $WhereAvailable
                    ORDER BY $ColName $Order";

            $CountSql = "SELECT COUNT(*) AS TotalPurchasedProductsNum 
                        FROM purchased_products 
                        WHERE PurchasedProductName LIKE :PurchasedProductName
                        $WhereAvailable";

            // Add limit/offset if provided
            if ($Limit != -1 && $Offset != -1) 
            {
                $Sql .= " LIMIT " . intval($Limit) . " OFFSET " . intval($Offset);
            }

            // Fetch results
            $Stmt = $Connection->prepare($Sql);
            $Stmt->bindParam(":PurchasedProductName", $SearchTerm);
            $Stmt->execute();
            $Results['PurchasedProducts'] = $Stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch count
            $Stmt2 = $Connection->prepare($CountSql);
            $Stmt2->bindParam(":PurchasedProductName", $SearchTerm);
            $Stmt2->execute();
            $Results['TotalPurchasedProductsNum'] = $Stmt2->fetch(PDO::FETCH_ASSOC)['TotalPurchasedProductsNum'];

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
	 * return:  if the `PurchasedProductId` is exist return   Purchased Product info as `array`, if it does not exist return `false`, if there is an error return `null`
     */
    function GetPurchasedProductByPurchasedProductId_DataAccess(int $PurchasedProductId)
    {
     

        $Connection = null;

        try 
        {
            $Connection = Get_PDO_Connection();
            if ($Connection === null) 
            {
                return null;
            }

         
            $Sql = "SELECT * FROM purchased_products 
                    WHERE PurchasedProductId = :PurchasedProductId";

            $Stmt = $Connection->prepare($Sql);
            $Stmt->bindParam(":PurchasedProductId", $PurchasedProductId);
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
    * @param mixed $PurchasedProductInfo
    * @return bool|string|null
    *  if inesrt a row return PurchasedProductId if no insert a row return 0 
    */
   function AddNewPurchasedProduct_DataAccess($PurchasedProductInfo)       
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
                "INSERT INTO purchased_products
                            (PurchasedProductName, Quantity, RemainingQuantity, CreatedDateTime, ImportArrivalDateTime, PurchasePrice, BaseSellingPrice, Details, SupplierName,ProductImgName)
                        VALUES
                        (
                            :PurchasedProductName,
                            :Quantity,
                            :RemainingQuantity,
                            :CreatedDateTime,
                            :ImportArrivalDateTime,
                            :PurchasePrice,
                            :BaseSellingPrice,
                            :Details,
                            :SupplierName,
                            :ProductImgName
                        )
                        "
            );
            $Stmt->bindValue(":PurchasedProductName", $PurchasedProductInfo["Name"]);
            $Stmt->bindValue(":Quantity", $PurchasedProductInfo["Quantity"]);
            $Stmt->bindValue(":RemainingQuantity", $PurchasedProductInfo["Quantity"]);
            
            date_default_timezone_set('Asia/Amman');
            $Stmt->bindValue(":CreatedDateTime", date("Y-m-d H:i:s"));
            
            $Stmt->bindValue(":ImportArrivalDateTime", $PurchasedProductInfo["ImportArrivalDateTime"]);
            $Stmt->bindValue(":PurchasePrice", $PurchasedProductInfo["PurchasePrice"]);
            $Stmt->bindValue(":BaseSellingPrice", $PurchasedProductInfo["BaseSellingPrice"]);
            $Stmt->bindValue(":Details", $PurchasedProductInfo["Details"]);
            $Stmt->bindValue(":SupplierName", $PurchasedProductInfo["SupplierName"]);
            $Stmt->bindValue(":ProductImgName", $PurchasedProductInfo["AddProductImg"]);
            $Stmt->execute();


            $PurchasedProductId = $Connection->lastInsertId();  

            return $PurchasedProductId; //if no insert row return 0
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