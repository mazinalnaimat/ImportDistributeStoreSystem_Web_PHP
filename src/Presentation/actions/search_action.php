<?php
require_once __DIR__ . "/../includes/auth.php";


require_once __DIR__ . "/../../Business/Branch.php";
require_once __DIR__ . "/../../Business/DistributionProduct.php";


function GoBack()
{
    unset($_SESSION["PageVars"]);
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/dashboard.php");
    exit();

}
function SetSearchMode(string $SearchMode)
{ 
    $_SESSION['PageVars']['SearchMode'] =  $SearchMode;
    if(($_SESSION['PageVars']['SearchMode'] == 'branches') )
    {
        $Result = SearchBranchesByColumnAndValue_Business('','BranchId','ASC', 5, 0);
        $_SESSION['PageVars']['SearchResults'] = $Result['Branches'];
        $_SESSION['PageVars']['TotalSearchResultNumber'] = $Result['TotalBranchesNum'];
        $_SESSION['PageVars']['SearchCriteria'] = ['Search' => '', 'ColName' => 'BranchId', 'Order' => 'ASC'];

    }
    else
    {
        $Result = SearchDistributionProductByColumnAndValue_Business('','DistributionProductId','ASC', 5, 0);
        $_SESSION['PageVars']['SearchResults'] = $Result['DistributionProducts'];
        $_SESSION['PageVars']['TotalSearchResultNumber'] = $Result['TotalDistributionProductsNum'];
        $_SESSION['PageVars']['SearchCriteria'] = ['Search' => '', 'ColName' => 'DistributionProductId', 'Order' => 'ASC'];

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
        $Result = SearchBranchesByColumnAndValue_Business($Search, $ColName, $Order, $ItemsNumberPerPage, $Offset);
        $_SESSION['PageVars']['SearchResults'] = $Result['Branches'];
        $_SESSION['PageVars']['TotalSearchResultNumber'] = $Result['TotalBranchesNum'];
    } 
    else 
    {
        $Result = SearchDistributionProductByColumnAndValue_Business($Search, $ColName, $Order, $ItemsNumberPerPage, $Offset);
        $_SESSION['PageVars']['SearchResults'] = $Result['DistributionProducts'];
        $_SESSION['PageVars']['TotalSearchResultNumber'] = $Result['TotalDistributionProductsNum'];
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

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
   
    // Go back
    if (isset($_GET['go_back']))
    {
        GoBack();
    }

    // Set Search Mode
    if (isset($_GET['set_search_mode'])) 
    {
        SetSearchMode($_GET['set_search_mode']);

    }

    //Search
    elseif (isset($_GET['execute_search']))
    {
        $Search = $_GET['search_text'];
        $ColName = $_GET['search_column'];
        $Order = $_GET['sort_order'];
        Search($Search, $ColName, $Order);

    }

    //Change number of items per page
    else if (isset($_GET['number_items_per_page'])) 
    {
        $NumberItemsPerPage = max(5, (int)$_GET['number_items_per_page']);
        ChangeNumberItemsPerPage($NumberItemsPerPage);        
    
        $Search = $_GET['search_text'];
        $ColName = $_GET['search_column'];
        $Order = $_GET['sort_order'];
        Search($Search, $ColName, $Order);
    }
    
    // change search page 
    else if (isset($_GET['search_page_number'])) 
    {
        $SearchPageNumber = max(1, (int)$_GET['search_page_number']);
        ChangeSearchPageNumber($SearchPageNumber);      


        $Search = $_SESSION['PageVars']['SearchCriteria']['Search'];
        $ColName = $_SESSION['PageVars']['SearchCriteria']['ColName'];
        $Order = $_SESSION['PageVars']['SearchCriteria']['Order'];
        Search($Search, $ColName, $Order);
    }


    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard Screens/search.php");
    exit;
}

?>