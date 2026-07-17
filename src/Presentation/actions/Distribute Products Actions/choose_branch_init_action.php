<?php
require_once __DIR__ . "/../../includes/auth.php";

require_once __DIR__ . "/../../../Business/Branch.php";



// Initialize session vars for branches
$_SESSION['BranchesPageVars']['Branches'] = GetAllBranches_Business()['Branches'];
$_SESSION['BranchesPageVars']['NumberOfItemsPerPage'] =8;
$_SESSION['BranchesPageVars']['OrderDir'] ="ASC";
$_SESSION['BranchesPageVars']['View'] = 'cards';

