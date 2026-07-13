<?php
require_once __DIR__ . "/../../includes/auth.php";

require_once __DIR__ . "/../../../Business/Business_Utils.php";
require_once __DIR__ . "/../../../Business/Branch.php";


function GoBack()
{  
    unset($_SESSION['BranchesPageVars']);
    header(header: "Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/Export%20Products%20Screens/Distribute%20Products/distribute_product.php");  
    exit;
}

function SetViewMode(string $ViewMode)
{
    if($ViewMode =='Cards')
    {
        $_SESSION['BranchesPageVars']['ViewMode'] = $ViewMode;
    }
    else if($ViewMode=='Table')
    {
        $_SESSION['BranchesPageVars']['ViewMode'] = $ViewMode;

    }
}

function SearchBranchesByBranchName(string $TextSearch)
{   
    $NumberOfItemsPerPage= $_SESSION['BranchesPageVars']['NumberOfItemsPerPage']??8;
    $OrderDir = $_SESSION['BranchesPageVars']['OrderDir']??"ASC" ;
    $_SESSION['BranchesPageVars']['sPageNumber']  = 1;

    if($TextSearch == "")
    {
        $Branches = GetAllBranches_Business($OrderDir, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION['BranchesPageVars']['Branches'] = $Branches['Branches'];
        $_SESSION['BranchesPageVars']['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
    else
    {
        $Branches = SearchBranchesByName_Business($TextSearch,$OrderDir, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION['BranchesPageVars']['Branches'] = $Branches['Branches'];
        $_SESSION['BranchesPageVars']['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
    $_SESSION['BranchesPageVars']['SearchText'] = $TextSearch;
}
function SetBranchesNumPerPage(int $NumberOfItemsPerPage)
{
    
    $OrderDir = $_SESSION['BranchesPageVars']['OrderDir']??"ASC" ;
    $_SESSION['BranchesPageVars']['NumberOfItemsPerPage'] = $NumberOfItemsPerPage;
   
    $_SESSION['BranchesPageVars']['BranchesPageNumber']  = 1;
    $TextSearch = $_SESSION['BranchesPageVars']['SearchText']??'';

    if($TextSearch == "")
    {
        $Branches = GetAllBranches_Business($OrderDir, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION['BranchesPageVars']['Branches'] = $Branches['Branches'];
        $_SESSION['BranchesPageVars']['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
    else
    {
        $Branches = SearchBranchesByName_Business($TextSearch,$OrderDir, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION['BranchesPageVars']['Branches'] = $Branches['Branches'];
        $_SESSION['BranchesPageVars']['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
}

function SetOrderDirOfBranches(string $OrderDir)
{    
    $NumberOfItemsPerPage= $_SESSION['BranchesPageVars']['NumberOfItemsPerPage']??8;    
    $_SESSION['BranchesPageVars']['BranchesPageNumber']  = 1;
    $_SESSION['BranchesPageVars']['OrderDir'] = $OrderDir;
    $TextSearch = $_SESSION['BranchesPageVars']['SearchText']??'';

    if($TextSearch == "")
    {
        $Branches = GetAllBranches_Business($OrderDir, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION['BranchesPageVars']['Branches'] = $Branches['Branches'];
        $_SESSION['BranchesPageVars']['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
    else
    {
        $Branches = SearchBranchesByName_Business($TextSearch,$OrderDir, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION['BranchesPageVars']['Branches'] = $Branches['Branches'];
        $_SESSION['BranchesPageVars']['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
}

function  SetBranchesPageNumber(int $PageNumber)
{
    $_SESSION['BranchesPageVars']['BranchesPageNumber']  = $PageNumber;
    $NumberOfItemsPerPage= $_SESSION['BranchesPageVars']['NumberOfItemsPerPage']??8;
    
    $OrderDir = $_SESSION['BranchesPageVars']['OrderDir']??"ASC" ;
   $TextSearch = $_SESSION['BranchesPageVars']['SearchText']??'';

    if($TextSearch == "")
    {
        $Branches = GetAllBranches_Business($OrderDir, Limit:$NumberOfItemsPerPage, Offset: $NumberOfItemsPerPage * ($PageNumber-1));
        $_SESSION['BranchesPageVars']['Branches'] = $Branches['Branches'];
        $_SESSION['BranchesPageVars']['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
    else
    {
        $Branches = SearchBranchesByName_Business($TextSearch,$OrderDir, Limit:$NumberOfItemsPerPage, Offset: $NumberOfItemsPerPage * ($PageNumber-1));
        $_SESSION['BranchesPageVars']['Branches'] = $Branches['Branches'];
        $_SESSION['BranchesPageVars']['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }

}


function Redirect()
{
    header('Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/Export%20Products%20Screens/Distribute%20Products/choose_branch.php');
    exit;
}



if ($_SERVER["REQUEST_METHOD"] === "GET") 
{
    if(isset($_GET["back"]))
    {
        GoBack();
    }
    
    else if(isset($_GET['view_mode']))
    {
        SetViewMode($_GET['view_mode']);
    }

    else if(isset($_GET['search_branch_name']))
    {
        $SearchText = trim($_GET['search_text']);
        SearchBranchesByBranchName( $SearchText);
    }

    else if(isset($_GET['number_items_per_page']))
    {
        SetBranchesNumPerPage((int)$_GET['number_items_per_page']);
    } 

    else if(isset($_GET['branches_page_number']))
    {
        SetBranchesPageNumber((int) $_GET['branches_page_number']);
    }

    else if(isset($_GET['order_dir']))
    {
        SetOrderDirOfBranches($_GET['order_dir']);
    }   

    else if (isset($_GET['choose_branch']))
    {
        $_SESSION['DistributeProductPageVars']['SelectedBranch']= GetBranchByBranchId_Business($_GET['branch_id']);
        GoBack();
    }
    Redirect();
}

?>

