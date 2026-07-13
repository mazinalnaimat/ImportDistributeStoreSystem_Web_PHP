<?php
require_once __DIR__ . "/../includes/auth.php";

require_once __DIR__ ."/../includes/Presentation_Utils.php";
require_once __DIR__ . "/../../Business/Business_Utils.php";

require_once __DIR__ . "/../../Business/Branch.php";
require_once __DIR__ . "/../../Business/Distribution.php";



function SetSearchMode(string $SearchMode)
{ 
    $_SESSION['PageVars']['SearchMode'] =  $SearchMode;
    if(($_SESSION['PageVars']['SearchMode'] == 'branches') )
    {
        $Result = SearchBranchesByColumnAndValue_Business('','BranchId','ASC', 5, 0);
        $_SESSION['PageVars']['SearchResults'] = $Result['Rows'];
        $_SESSION['PageVars']['TotalSearchResultNumber'] = $Result['TotalCount'];
        $_SESSION['PageVars']['SearchCriteria'] = ['Search' => '', 'ColName' => 'BranchId', 'Order' => 'ASC'];

    }
    else
    {
        $Result = SearchDistributionsByColumnAndValue_Business('','DistributionId','ASC', 5, 0);
        $_SESSION['PageVars']['SearchResults'] = $Result['Rows'];
        $_SESSION['PageVars']['TotalSearchResultNumber'] = $Result['TotalCount'];
        $_SESSION['PageVars']['SearchCriteria'] = ['Search' => '', 'ColName' => 'DistributionId', 'Order' => 'ASC'];

    }
    $_SESSION['PageVars']['NumberOfItemsPerPage'] = 5;
    $_SESSION['PageVars']['SearchPageNumber'] = 1;

}

function Search($Search, $ColName, $Order)    
{    
    $_SESSION['PageVars']['SearchCriteria'] = ['Search' => $Search, 'ColName' => $ColName, 'Order' => $Order];

    $ItemsNumberPerPage =  (int)($_SESSION['PageVars']['NumberOfItemsPerPage'] ?? 5);
    $SearchPageNumber = (int)($_SESSION['PageVars']['SearchPageNumber'] ?? 1);
    $Offset = ($SearchPageNumber-1) * $ItemsNumberPerPage;


    if ($_SESSION['PageVars']['SearchMode'] == 'branches')
    {
        $Result = SearchBranchesByColumnAndValue_Business($Search,$ColName,$Order, $ItemsNumberPerPage, $Offset);
        $_SESSION['PageVars']['SearchResults'] = $Result['Rows'];
        $_SESSION['PageVars']['TotalSearchResultNumber'] = $Result['TotalCount'];
    } 
    else 
    {
        $Result = SearchDistributionsByColumnAndValue_Business($Search,$ColName,$Order, $ItemsNumberPerPage, $Offset);
        $_SESSION['PageVars']['SearchResults'] = $Result['Rows'];
        $_SESSION['PageVars']['TotalSearchResultNumber'] = $Result['TotalCount'];
    }
}

function  ChangeNumberItemsPerPage($NumberItemsPerPage)
{     
    $_SESSION['PageVars']['NumberOfItemsPerPage'] = $NumberItemsPerPage;
    $_SESSION['PageVars']['SearchPageNumber'] = 1;
}       

function  ChangeSearchPageNumber(int $SearchPageNumber)
{
    $_SESSION['PageVars']['SearchPageNumber'] = $SearchPageNumber;
}  

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
   
    // Go back
    if (isset($_POST['go_back']))
    {
        GoBackPage();
        exit;
    }

    // Set Search Mode
    if (isset($_POST['set_search_mode'])) 
    {
        SetSearchMode($_POST['set_search_mode']);

    }

    //Search
    elseif (isset($_POST['execute_search']))
    {
        $Search = $_POST['search_text'];
        $ColName = $_POST['search_column'];
        $Order = $_POST['sort_order'];
        Search($Search, $ColName, $Order);

    }

    //Change number of items per page
    else if (isset($_POST['number_items_per_page'])) 
    {
        $NumberItemsPerPage = max(5, (int)$_POST['number_items_per_page']);
        ChangeNumberItemsPerPage($NumberItemsPerPage);        
    
        $Search = $_POST['search_text'];
        $ColName = $_POST['search_column'];
        $Order = $_POST['sort_order'];
        Search($Search, $ColName, $Order);
    }
    
    // change search page 
    else if (isset($_POST['search_page_number'])) 
    {
        $SearchPageNumber = max(1, (int)$_POST['search_page_number']);
        ChangeSearchPageNumber($SearchPageNumber );      


        $Search = $_SESSION['PageVars']['SearchCriteria']['Search'];
        $ColName = $_SESSION['PageVars']['SearchCriteria']['ColName'];
        $Order = $_SESSION['PageVars']['SearchCriteria']['Order'];
        Search($Search, $ColName, $Order);
    }


    $redirect = $_SERVER['HTTP_REFERER'] ?? "/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard Screens/search.php";
    header("Location: " . $redirect);
    exit;
}

?>