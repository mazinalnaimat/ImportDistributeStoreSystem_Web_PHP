<?php
require_once __DIR__ . "/../includes/auth.php";

require_once __DIR__ ."/../includes/Presentation_Utils.php";
require_once __DIR__ . "/../../Business/Business_Utils.php";

require_once __DIR__ . "/../../Business/Branch.php";

    $_SESSION['PageVars']['BranchesFinancialSummery'] = GetActiveBranchesFinancialSummery_Business();
    foreach ($_SESSION['PageVars']['BranchesFinancialSummery'] as $key => $BranchFinancialSummery) 
    {
        $_SESSION['PageVars']['BranchesFinancialSummery'][$key]['BranchInfo'] = GetActiveBranchById_Business((int)$BranchFinancialSummery['BranchId']); 
    }
  
?>