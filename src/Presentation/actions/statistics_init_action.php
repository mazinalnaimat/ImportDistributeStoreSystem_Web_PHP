<?php
require_once __DIR__ . "/../includes/auth.php";

require_once __DIR__ . "/../../Business/Statistics.php";


    $_SESSION['PageVars']['BranchesFinancialSummery'] = GetAllBranchesFinancialSummery_Business();
  
?>