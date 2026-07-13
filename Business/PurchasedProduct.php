<?php
declare(strict_types=1);
require_once __DIR__ . "/../DataAccess/PurchasedProduct_DataAcces.php";


   function GetAllPurchasedProducts_Business(string $ColName = "PurchasedProductName", AvailableProductFilter $AvailableProductFilter=AvailableProductFilter::All,string $Order = "ASC",int $Limit =-1 , int $Offset =-1 )
   {
      return  GetAllPurchasedProducts_DataAccess(ColName: $ColName,  Order: $Order, AvailableProductFilter: $AvailableProductFilter, Limit: $Limit, Offset: $Offset);
   }

   function SearchPurchasedProductsByName_Business(string $PurchasedProductName,string $ColName = "PurchasedProductName", string $Order = "ASC", AvailableProductFilter $AvailableProductFilter=AvailableProductFilter::All, int $Limit =-1 , int $Offset=-1 )
   {
      return SearchPurchasedProductsByName_DataAccess(PurchasedProductName: $PurchasedProductName, ColName: $ColName,  Order: $Order, AvailableProductFilter: $AvailableProductFilter, Limit:  $Limit, Offset: $Offset);
   }

   function GetPurchasedProductByPurchasedProductId_Business(int $PurchasedProductId)
   {
      return GetPurchasedProductByPurchasedProductId_DataAccess($PurchasedProductId);
   }
   function AddNewPurchasedProduct_Business($PurchasedProductInfo)
   {
        return AddNewPurchasedProduct_DataAccess($PurchasedProductInfo);
   }

?>