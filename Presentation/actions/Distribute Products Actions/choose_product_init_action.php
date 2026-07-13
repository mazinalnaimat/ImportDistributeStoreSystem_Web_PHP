<?php
require_once __DIR__ . "/../../includes/auth.php";

require_once __DIR__ . "/../../../Business/PurchasedProduct.php";



$PurchasedProducts = GetAllPurchasedProducts_Business(Limit:8, Offset:0);
$_SESSION["PageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
$_SESSION["PageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
$_SESSION['PageVars']['NumberOfItemsPerPage'] = 8;
$_SESSION["PageVars"]["ViewMode"] = 'Cards';


?>
