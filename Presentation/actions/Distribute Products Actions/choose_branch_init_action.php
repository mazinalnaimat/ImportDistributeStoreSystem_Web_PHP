<?php
require_once __DIR__ . "/../../includes/auth.php";

require_once __DIR__ . "/../../../Business/Branch.php";



// Initialize session vars for branches
$_SESSION['PageVars']['Branches'] = GetAllBranches_Business()['Branches'];
$_SESSION['PageVars']['NumberOfItemsPerPage'] =8;
$_SESSION['PageVars']['OrderDir'] ="ASC";
$_SESSION['PageVars']['View'] = 'cards';

