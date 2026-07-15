<?php
declare(strict_types=1);
require_once __DIR__ . "/../DataAccess/DistributionProduct_DataAccess.php";

    function SearchDistributionProductByColumnAndValue_Business(string $SearchText,  string $ColName,string $Order = "ASC",  int $Limit = -1,    int $Offset = -1)
    {
        return SearchDistributionProductByColumnAndValue_DataAccess($SearchText, $ColName, $Order, $Limit, $Offset);
    }

    function AddNewDistributionProduct_Business(array $DistributionProductInfo)
    {
        return AddNewDistributionProduct_DataAccess($DistributionProductInfo);
    }
?>