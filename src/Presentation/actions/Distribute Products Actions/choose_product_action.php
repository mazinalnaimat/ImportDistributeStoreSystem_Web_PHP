<?php
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../../Business/PurchasedProduct.php";





function GoBack()
{
    unset($_SESSION["ProductsPageVars"]);
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/Export%20Products%20Screens/Distribute%20Products/distribute_product.php");
    exit;

}

function SetViewMode(string $ViewMode)
{
    if($ViewMode =="Cards")
    {
        $_SESSION["ProductsPageVars"]["ViewMode"] = $ViewMode;
    }
    else if($ViewMode=="Table")
    {
        $_SESSION["ProductsPageVars"]["ViewMode"] = $ViewMode;

    }
}

function SearchBranchesByBranchName(string $TextSearch)
{   
    $NumberOfItemsPerPage= $_SESSION["ProductsPageVars"]['NumberOfItemsPerPage']??8;
    $ColName = $_SESSION["ProductsPageVars"]['ColNameForOrderBy'] ?? '';
    $OrderDir = $_SESSION["ProductsPageVars"]['OrderDir']??"ASC" ;
    $_SESSION["ProductsPageVars"]['PurchasedProductsPageNumber']  = 1;
    $AvailableProductFilter = isset($_SESSION["ProductsPageVars"]['AvailableProductFilter'])
    ? AvailableProductFilter::from($_SESSION["ProductsPageVars"]['AvailableProductFilter'])
    : AvailableProductFilter::All;

    if($TextSearch == "")
    {
        $PurchasedProducts = GetAllPurchasedProducts_Business(ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter,Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["ProductsPageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["ProductsPageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
    else
    {
        $PurchasedProducts = SearchPurchasedProductsByName_Business(PurchasedProductName: $TextSearch, ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["ProductsPageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["ProductsPageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
    $_SESSION["ProductsPageVars"]['SearchText'] = $TextSearch;
}
function SetPurchasedProductsNumPerPage(int $NumberOfItemsPerPage)
{
    $ColName = $_SESSION["ProductsPageVars"]['ColNameForOrderBy'] ?? '';
    $OrderDir = $_SESSION["ProductsPageVars"]['OrderDir']??"ASC" ;
    $_SESSION["ProductsPageVars"]['NumberOfItemsPerPage'] = $NumberOfItemsPerPage;
    $AvailableProductFilter = isset($_SESSION["ProductsPageVars"]['AvailableProductFilter'])
    ? AvailableProductFilter::from($_SESSION["ProductsPageVars"]['AvailableProductFilter'])
    : AvailableProductFilter::All;    $_SESSION["ProductsPageVars"]['PurchasedProductsPageNumber']  = 1;
    $TextSearch = $_SESSION["ProductsPageVars"]['SearchText']??'';

    if($TextSearch == '')
    {
        $PurchasedProducts = GetAllPurchasedProducts_Business(ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter,Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["ProductsPageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["ProductsPageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
    else
    {
        $PurchasedProducts = SearchPurchasedProductsByName_Business(PurchasedProductName: $TextSearch, ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["ProductsPageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["ProductsPageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
}

function OrderPurchasedProductsByColName(string $ColName)
{    
    $NumberOfItemsPerPage= $_SESSION["ProductsPageVars"]['NumberOfItemsPerPage'];
    $OrderDir = $_SESSION["ProductsPageVars"]['OrderDir']??"ASC" ;
    $AvailableProductFilter = isset($_SESSION["ProductsPageVars"]['AvailableProductFilter'])
    ? AvailableProductFilter::from($_SESSION["ProductsPageVars"]['AvailableProductFilter'])
    : AvailableProductFilter::All;    $_SESSION["ProductsPageVars"]['PurchasedProductsPageNumber']  = 1;
    $_SESSION["ProductsPageVars"]['ColNameForOrderBy'] = $ColName;
    $TextSearch = $_SESSION["ProductsPageVars"]['SearchText']??'';

    if($TextSearch == '')
    {
        $PurchasedProducts = GetAllPurchasedProducts_Business(ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter,Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["ProductsPageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["ProductsPageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
    else
    {
        $PurchasedProducts = SearchPurchasedProductsByName_Business(PurchasedProductName: $TextSearch, ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["ProductsPageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["ProductsPageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
}

function SetOrderDirOfPurchasedProducts(string $OrderDir)
{    
    $NumberOfItemsPerPage= $_SESSION["ProductsPageVars"]['NumberOfItemsPerPage'];
    $ColName = $_SESSION["ProductsPageVars"]['ColNameForOrderBy'] ?? '';
    $AvailableProductFilter = isset($_SESSION["ProductsPageVars"]['AvailableProductFilter'])
    ? AvailableProductFilter::from($_SESSION["ProductsPageVars"]['AvailableProductFilter'])
    : AvailableProductFilter::All;    $_SESSION["ProductsPageVars"]['PurchasedProductsPageNumber']  = 1;
    $_SESSION["ProductsPageVars"]['OrderDir'] = $OrderDir;
    $TextSearch = $_SESSION["ProductsPageVars"]['SearchText']??'';

    if($TextSearch == '')
    {
        $PurchasedProducts = GetAllPurchasedProducts_Business(ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter,Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["ProductsPageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["ProductsPageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
    else
    {
        $PurchasedProducts = SearchPurchasedProductsByName_Business(PurchasedProductName: $TextSearch, ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["ProductsPageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["ProductsPageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
}

function  SetPurchasedProductsPageNumber(int $PageNumber)
{
    $_SESSION["ProductsPageVars"]['PurchasedProductsPageNumber']  = $PageNumber;
    $NumberOfItemsPerPage= $_SESSION["ProductsPageVars"]['NumberOfItemsPerPage']??8;
    $ColName = $_SESSION["ProductsPageVars"]['ColNameForOrderBy'] ?? '';
    $OrderDir = $_SESSION["ProductsPageVars"]['OrderDir']??"ASC" ;
    $AvailableProductFilter = isset($_SESSION["ProductsPageVars"]['AvailableProductFilter'])
    ? AvailableProductFilter::from($_SESSION["ProductsPageVars"]['AvailableProductFilter'])
    : AvailableProductFilter::All;    $TextSearch = $_SESSION["ProductsPageVars"]['SearchText']??'';

    if($TextSearch == '')
    {
        $PurchasedProducts = GetAllPurchasedProducts_Business(ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter, Limit:$NumberOfItemsPerPage, Offset: $NumberOfItemsPerPage * ($PageNumber-1));
        $_SESSION["ProductsPageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["ProductsPageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }
    else
    {
        $PurchasedProducts = SearchPurchasedProductsByName_Business(PurchasedProductName: $TextSearch, ColName: $ColName, Order: $OrderDir, AvailableProductFilter: $AvailableProductFilter, Limit:$NumberOfItemsPerPage, Offset: $NumberOfItemsPerPage * ($PageNumber-1));
        $_SESSION["ProductsPageVars"]['PurchasedProducts'] = $PurchasedProducts['PurchasedProducts'];
        $_SESSION["ProductsPageVars"]['TotalSearchResultNumber'] = $PurchasedProducts['TotalPurchasedProductsNum'];
    }

}

function ShowProductDetails(int $ProductId)
{
    $_SESSION["ProductsPageVars"]['PurchasedProductDetailsId'] = GetPurchasedProductByPurchasedProductId_Business($ProductId);
}

function CloseProductDetailsModal()
{
    unset($_SESSION["ProductsPageVars"]['PurchasedProductDetailsId']);
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

    $_SESSION["ProductsPageVars"]['AvailableProductFilter'] = $Enum->value;
    SearchBranchesByBranchName($_SESSION["ProductsPageVars"]['SearchText']??'');
}

function ChoosePurchasedProduct()
{
    $_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct'] = GetPurchasedProductByPurchasedProductId_Business($_GET['product_id']);
    GoBack();
}

function Redirect()
{
    header('Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/Export%20Products%20Screens/Distribute%20Products/choose_product.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "GET") 
{

    if(isset($_GET['back']))
    {
        GoBack();
    }

    else if(isset($_GET['view_mode']))
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
        SetOrderDirOfPurchasedProducts($_GET['order_dir']);
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

    else if (isset($_GET["choose_product"]))
    {
        ChoosePurchasedProduct();
    }

   Redirect();

}

