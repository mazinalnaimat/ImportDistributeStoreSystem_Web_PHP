<?php
require_once __DIR__ . "/../includes/auth.php";
require_once __DIR__ . "/../../Business/PurchasedProduct.php";


function GoBack()
{
    unset($_SESSION["PageVars"]);
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/export_products.php?");

    exit;

}

function SetViewMode(string $ViewMode)
{
    if($ViewMode =="Cards")
    {
        $_SESSION["PageVars"]["ViewMode"] = $ViewMode;
    }
    else if($ViewMode=="Table")
    {
        $_SESSION["PageVars"]["ViewMode"] = $ViewMode;

    }
}

function SearchBranchesByBranchName(string $TextSearch)
{   
    $NumberOfItemsPerPage= $_SESSION["PageVars"]['NumberOfItemsPerPage']??8;
    $ColName = $_SESSION["PageVars"]['ColNameForOrderBy'] ?? '';
    $OrderDir = $_SESSION["PageVars"]['OrderDir']??"ASC" ;
    $_SESSION["PageVars"]['PurchasedProductsPageNumber']  = 1;
    $AvailableProductFilter = isset($_SESSION["PageVars"]['AvailableProductFilter'])
    ? AvailableProductFilter::from($_SESSION["PageVars"]['AvailableProductFilter'])
    : AvailableProductFilter::All;

    if($TextSearch == "")
    {
        $PurchasedProducts = GetAllPurchasedProducts_Business(ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter,Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
    else
    {
        $PurchasedProducts = SearchPurchasedProductsByName_Business(PurchasedProductName: $TextSearch, ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
    $_SESSION["PageVars"]['SearchText'] = $TextSearch;
}
function SetPurchasedProductsNumPerPage(int $NumberOfItemsPerPage)
{
    $ColName = $_SESSION["PageVars"]['ColNameForOrderBy'] ?? '';
    $OrderDir = $_SESSION["PageVars"]['OrderDir']??"ASC" ;
    $_SESSION["PageVars"]['NumberOfItemsPerPage'] = $NumberOfItemsPerPage;
    $AvailableProductFilter = isset($_SESSION["PageVars"]['AvailableProductFilter'])
    ? AvailableProductFilter::from($_SESSION["PageVars"]['AvailableProductFilter'])
    : AvailableProductFilter::All;    $_SESSION["PageVars"]['PurchasedProductsPageNumber']  = 1;
    $TextSearch = $_SESSION["PageVars"]['SearchText']??'';

    if($TextSearch == '')
    {
        $PurchasedProducts = GetAllPurchasedProducts_Business(ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter,Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
    else
    {
        $PurchasedProducts = SearchPurchasedProductsByName_Business(PurchasedProductName: $TextSearch, ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
}

function OrderPurchasedProductsByColName(string $ColName)
{    
    $NumberOfItemsPerPage= $_SESSION["PageVars"]['NumberOfItemsPerPage'];
    $OrderDir = $_SESSION["PageVars"]['OrderDir']??"ASC" ;
    $AvailableProductFilter = isset($_SESSION["PageVars"]['AvailableProductFilter'])
    ? AvailableProductFilter::from($_SESSION["PageVars"]['AvailableProductFilter'])
    : AvailableProductFilter::All;    $_SESSION["PageVars"]['PurchasedProductsPageNumber']  = 1;
    $_SESSION["PageVars"]['ColNameForOrderBy'] = $ColName;
    $TextSearch = $_SESSION["PageVars"]['SearchText']??'';

    if($TextSearch == '')
    {
        $PurchasedProducts = GetAllPurchasedProducts_Business(ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter,Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
    else
    {
        $PurchasedProducts = SearchPurchasedProductsByName_Business(PurchasedProductName: $TextSearch, ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
}

function SetOrderDirOfPurchasedProdcuts(string $OrderDir)
{    
    $NumberOfItemsPerPage= $_SESSION["PageVars"]['NumberOfItemsPerPage'];
    $ColName = $_SESSION["PageVars"]['ColNameForOrderBy'] ?? '';
    $AvailableProductFilter = isset($_SESSION["PageVars"]['AvailableProductFilter'])
    ? AvailableProductFilter::from($_SESSION["PageVars"]['AvailableProductFilter'])
    : AvailableProductFilter::All;    $_SESSION["PageVars"]['PurchasedProductsPageNumber']  = 1;
    $_SESSION["PageVars"]['OrderDir'] = $OrderDir;
    $TextSearch = $_SESSION["PageVars"]['SearchText']??'';

    if($TextSearch == '')
    {
        $PurchasedProducts = GetAllPurchasedProducts_Business(ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter,Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
    else
    {
        $PurchasedProducts = SearchPurchasedProductsByName_Business(PurchasedProductName: $TextSearch, ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
}

function  SetPurchasedProductsPageNumber(int $PageNumber)
{
    $_SESSION["PageVars"]['PurchasedProductsPageNumber']  = $PageNumber;
    $NumberOfItemsPerPage= $_SESSION["PageVars"]['NumberOfItemsPerPage']??8;
    $ColName = $_SESSION["PageVars"]['ColNameForOrderBy'] ?? '';
    $OrderDir = $_SESSION["PageVars"]['OrderDir']??"ASC" ;
    $AvailableProductFilter = isset($_SESSION["PageVars"]['AvailableProductFilter'])
    ? AvailableProductFilter::from($_SESSION["PageVars"]['AvailableProductFilter'])
    : AvailableProductFilter::All;    $TextSearch = $_SESSION["PageVars"]['SearchText']??'';

    if($TextSearch == '')
    {
        $PurchasedProducts = GetAllPurchasedProducts_Business(ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter, Limit:$NumberOfItemsPerPage, Offset: $NumberOfItemsPerPage * ($PageNumber-1));
        $_SESSION["PageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
    else
    {
        $PurchasedProducts = SearchPurchasedProductsByName_Business(PurchasedProductName: $TextSearch, ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter, Limit:$NumberOfItemsPerPage, Offset: $NumberOfItemsPerPage * ($PageNumber-1));
        $_SESSION["PageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }

}

function ShowProductDetails(int $ProductId)
{
    $_SESSION["PageVars"]['PurchasedProductDetailsId'] = GetPurchasedProductByPurchasedProductId_Business($ProductId);
}

function CloseProductDetailsModal()
{
    unset($_SESSION["PageVars"]['PurchasedProductDetailsId']);
}

function SetAvailableProductFilter(string $AvailableProductFilter)
{


    // Normalize input
    $Value = strtolower($AvailableProductFilter);

    // Convert string to enum (safe)
    $Enum = match ($Value) 
    {
        'available'     => AvailableProductFilter::Available,
        'not_available' => AvailableProductFilter::NotAvailable,
        default         => AvailableProductFilter::All
    };

    $_SESSION["PageVars"]['AvailableProductFilter'] = $Enum->value;
    SearchBranchesByBranchName($_SESSION["PageVars"]['SearchText']??'');
}

function Redirect()
{
    header('Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/Export%20Products%20Screens/Show%20Products/products.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "GET") 
{

    if(isset($_GET['back']))
    {
        GoBack();
    }

    if(isset($_GET['view_mode']))
    {
        SetViewMode($_GET['view_mode']);

    }

    else if(isset($_GET['search_product_name']))
    {
        $SearchText = trim($_GET['search_text']);
        SearchBranchesByBranchName( $SearchText);
    }

    else if(isset($_GET['number_items_per_page']))
    {
        SetPurchasedProductsNumPerPage((int)$_GET['number_items_per_page']);
    } 

    else if(isset($_GET['purchased_products_page_number']))
    {
        SetPurchasedProductsPageNumber((int) $_GET['purchased_products_page_number']);
    }

    else if(isset($_GET['order_by']))
    {
        OrderPurchasedProductsByColName($_GET['order_by']);
    }

    else if(isset($_GET['order_dir']))
    {
        SetOrderDirOfPurchasedProdcuts($_GET['order_dir']);
    }   

    else if(isset($_GET["show_product_details_modal"]))
    {
        ShowProductDetails((int)$_GET['product_id']);
    }

    else if(isset($_GET["close_product_details_modal"]))
    {
        CloseProductDetailsModal();
    }

    else if(isset($_GET["available_product_filter"]))
    {
        SetAvailableProductFilter($_GET["available_product_filter"]);
    }


   Redirect();

}

