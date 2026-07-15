<?php
require_once __DIR__ . "/../../includes/auth.php";

require_once __DIR__ . "/../../../Business/DistributionProduct.php";


function GoBack()
{ 
    unset($_SESSION['DistributeProductPageVars']);
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/export_products.php");
    exit;
}

function Redirect()
{
    $Redirect = $_SERVER['HTTP_REFERER'] ?? '/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/Export%20Products%20Screens/distribute_product.php';
    header("Location: ". $Redirect);
    exit;
}


function ChooseBranch()
{   
    $_SESSION['DistributeProductPageVars']['ChooseBranch'] = true;
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/Export%20Products%20Screens/Distribute%20Products/choose_branch.php");
    exit;
}
function ShowBranchDetailsModal()
{

    $_SESSION['DistributeProductPageVars']['ShowBranchDetailsModal'] = true;
}

function CloseBranchDetailsModal()
{
    unset($_SESSION['DistributeProductPageVars']['ShowBranchDetailsModal']);
}
function ChooseProduct()
{
    $_SESSION['DistributeProductPageVars']['ChoosePurchasedProduct'] = true;
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/Export%20Products%20Screens/Distribute%20Products/choose_product.php");
    exit;
}
function ShowProductDetailsModal()
{

   $_SESSION['DistributeProductPageVars']['ShowProductDetailsModal']  = true;
}

function CloseProductDetailsModal()
{
    unset($_SESSION['DistributeProductPageVars']['ShowProductDetailsModal']);
}

function StoreTempDistributeProductValues($ExportToBranchDateTime, $ExportQuantity, $FinalSellingPrice)
{
    $_SESSION['DistributeProductPageVars']['ExportToBranchDateTime'] = $ExportToBranchDateTime;
    $_SESSION['DistributeProductPageVars']['ExportQuantity'] = $ExportQuantity;
    $_SESSION['DistributeProductPageVars']['FinalSellingPrice'] = $FinalSellingPrice;
}
function DistributeProduct($ExportToBranchDateTime, $ExportQuantity, $FinalSellingPrice)
{

    if(!isset($_SESSION['DistributeProductPageVars']['SelectedBranch']))
    {
        $_SESSION['DistributeProductPageVars']['ShowWarningSelectBranch'] = true;
        StoreTempDistributeProductValues($ExportToBranchDateTime, $ExportQuantity, $FinalSellingPrice);

    }

    else if (!isset( $_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']))
    {
        $_SESSION['DistributeProductPageVars']['ShowWarningSelectProduct'] = true;
        StoreTempDistributeProductValues($ExportToBranchDateTime, $ExportQuantity, $FinalSellingPrice);

    }
    else if ( $ExportQuantity> $_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']['RemainingQuantity'])
    {
        $_SESSION['DistributeProductPageVars']['ShowWarningExceedLimitProductQuantity'] = true;
        StoreTempDistributeProductValues($ExportToBranchDateTime, $ExportQuantity, $FinalSellingPrice);
    }
    else 
    {
        $DistributionProductDetails['PurchasedProductId'] = $_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']['PurchasedProductId'];
        $DistributionProductDetails['ExportToBranchDateTime'] = $ExportToBranchDateTime;
        $DistributionProductDetails['Quantity'] = $ExportQuantity;
        $DistributionProductDetails['FinalSellingPrice'] = $FinalSellingPrice;
        $DistributionProductDetails['BranchId'] = $_SESSION['DistributeProductPageVars']['SelectedBranch']['BranchId'];
        if(($DistributionProductId =AddNewDistributionProduct_Business($DistributionProductDetails)) != null)
        {
            $_SESSION['DistributeProductPageVars']['AddNewDistributionProductStatus'] = true;
            $_SESSION['DistributeProductPageVars']['DistributionProductId'] = $DistributionProductId;
            
            unset($_SESSION['DistributeProductPageVars']['SelectedBranch']);
            unset($_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']);

            unset($_SESSION['DistributeProductPageVars']['FinalSellingPrice']);
            unset($_SESSION['DistributeProductPageVars']['ExportToBranchDateTime']);
            unset($_SESSION['DistributeProductPageVars']['ExportQuantity']);
        }
        else 
        {
            $_SESSION['DistributeProductPageVars']['AddNewDistributionProductStatus'] = false;
        }
    }
}

function ShowDistributeProductProfitModal($PurchasePrice, $FinalSellingPrice, $ExportQuantity, $ExportToBranchDateTime)
{
    $_SESSION['DistributeProductPageVars']['DistributeProductProfit'] = ($FinalSellingPrice - $PurchasePrice) *  $ExportQuantity;
    StoreTempDistributeProductValues($ExportToBranchDateTime, $ExportQuantity, $FinalSellingPrice);
}

function CloseDistributeProductProfitModal()
{
  unset($_SESSION['DistributeProductPageVars']['DistributeProductProfit']);
}

function ProcessGetFormSubmission()
{
    if(isset($_GET['back']))
    {
        GoBack();
    }

    else if(isset($_GET['choose_branch']))
    {
        ChooseBranch();
    }

    else if(isset($_GET['choose_product']))
    {
        ChooseProduct();
    }

    else if (isset($_GET['show_branch_details_modal']))
    {
        ShowBranchDetailsModal();
    }

    else if (isset($_GET['close_branch_details_modal']))
    {
        CloseBranchDetailsModal();
    }

    else if (isset($_GET['show_product_details_modal']))
    {
        ShowProductDetailsModal();
    }

    else if (isset($_GET['close_product_details_modal']))
    {
        CloseProductDetailsModal();
    }
    else if(isset($_GET['close_distribute_product_profit_modal']))
    {
        CloseDistributeProductProfitModal();
    }

}

function ProcessPostFormSubmission()
{

    if(isset($_POST['distribute_product']))
    {
        $ExportToBranchDateTime = $_POST['export_date_time'];
        $ExportQuantity= (int)$_POST['export_quantity'];
        $FinalSellingPrice = (float)$_POST['final_selling_price'];
        DistributeProduct($ExportToBranchDateTime, $ExportQuantity, $FinalSellingPrice);

    }
    else if(isset($_POST['show_distribute_product_profit_modal']))
    {        
        $ExportToBranchDateTime = $_POST['export_date_time'];
        $ExportQuantity= (int)$_POST['export_quantity'];
        $PurchasePrice = $_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']['PurchasePrice'];
        $FinalSellingPrice = (float)$_POST['final_selling_price'];
        ShowDistributeProductProfitModal($PurchasePrice ,$FinalSellingPrice, $ExportQuantity, $ExportToBranchDateTime);
    }
}

if ($_SERVER['REQUEST_METHOD'] === "GET")
{
    ProcessGetFormSubmission();
    Redirect();
}

else if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  
    ProcessPostFormSubmission();
    Redirect();
}


