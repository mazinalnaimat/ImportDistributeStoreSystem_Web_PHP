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
function ShowBranchInfoModal()
{

    $_SESSION['DistributeProductPageVars']['ShowBranchInfoModal'] = true;
}

function CloseBranchInfoModal()
{
    unset($_SESSION['DistributeProductPageVars']['ShowBranchInfoModal']);
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

function DistributeProduct()
{

    if(!isset($_SESSION['DistributeProductPageVars']['SelectedBranch']))
    {
        $_SESSION['DistributeProductPageVars']['ShowWarningSelectBranch'] = true;
    }

    else if (!isset( $_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']))
    {
        $_SESSION['DistributeProductPageVars']['ShowWarningSelectProduct'] = true;

    }
    else if ( $_POST['ExportQuantity']> $_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']['RemainingQuantity'])
    {
        $_SESSION['DistributeProductPageVars']['ShowWarningExceedLimitProductQuantity'] = true;

    }
    else 
    {
        $DistributionProductInfo['PurchasedProductId'] = $_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']['PurchasedProductId'];
        $DistributionProductInfo['Quantity'] = (int)$_POST['ExportQuantity'];
        $DistributionProductInfo['FinalSellingPrice'] = (int)$_POST['FinalSellingPrice'];
        $DistributionProductInfo['BranchId'] = $_SESSION['DistributeProductPageVars']['SelectedBranch']['BranchId'];
        if(($DistributionProductId =AddNewDistributionProduct_Business($DistributionProductInfo)) != null)
        {
            $_SESSION['DistributeProductPageVars']['AddNewDistributionProductStatus'] = true;
            $_SESSION['DistributeProductPageVars']['DistributionProductId'] = $DistributionProductId;
            unset($_SESSION['DistributeProductPageVars']['SelectedBranch']);
            unset($_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']);
        }
        else 
        {
            $_SESSION['DistributeProductPageVars']['AddNewDistributionProductStatus'] = false;
        }
    }
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

    else if (isset($_GET['show_branch_info_modal']))
    {
        ShowBranchInfoModal();
    }

    else if (isset($_GET['close_branch_info_modal']))
    {
        CloseBranchInfoModal();
    }

    else if (isset($_GET['show_product_details_modal']))
    {
        ShowProductDetailsModal();
    }

    else if (isset($_GET['close_product_details_modal']))
    {
        CloseProductDetailsModal();
    }

}

function ProcessPostFormSubmission()
{

    if(isset($_POST['distribute_product']))
    {
        DistributeProduct();

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


