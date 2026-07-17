<?php
require_once __DIR__ . "/../../includes/auth.php";

require_once __DIR__ . "/../../../Business/PurchasedProduct.php";



$PurchasedProducts = GetAllPurchasedProducts_Business(Limit:8, Offset:0);
$_SESSION["ProductsPageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
$_SESSION["ProductsPageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
$_SESSION['ProductsPageVars']['NumberOfItemsPerPage'] = 8;
$_SESSION["ProductsPageVars"]["ViewMode"] = 'Cards';


?>
