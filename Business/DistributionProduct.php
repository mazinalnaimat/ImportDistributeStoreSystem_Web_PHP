<?php
declare(strict_types=1);
require_once __DIR__ . "/../DataAccess/DistributionProduct_DataAccess.php";

function AddNewDistributionProduct_Business(array $DistributionProductInfo)
{
    return AddNewDistributionProduct_DataAccess($DistributionProductInfo);
}
?>