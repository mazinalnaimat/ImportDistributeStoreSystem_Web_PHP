<?php
require_once __DIR__ . "/../includes/auth.php";

require_once __DIR__ . "/../../Business/Business_Utils.php";
require_once __DIR__ . "/../../Business/PurchasedProduct.php";



function GoBack()
{ 
    unset($_SESSION['PageVars']);
    header("Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/dashboard.php");
    exit;
}
   
function UploadProductImgToTempFolder($InputName)
{
    if(isset($_SESSION['PageVars']['AddNewProductInfo']['AddProductImg'] ))
    {
        DeleteImageFromFolder_Business($_SESSION['PageVars']['AddNewProductInfo']['AddProductImg'],  "temp");
    }

    $ErrorCode = 0;
    $UserErrorMsg = "";
    $ImgName = UploadImgToFolder_Business($InputName, "temp",ErrorCode: $ErrorCode);
    
    if($ImgName==false)
    {
        switch ($ErrorCode)
        {
            case 1:
            case 8:
                $UserErrorMsg = "لم يتم رفع الصورة";
                break;
            case 2:
                $UserErrorMsg = "لم يتم رفع الصورة<br> 
                                 الرجاء اختيار صورة أخرى";
                break;

            case 3:
                $UserErrorMsg = "يجب أن لا يتجاوز حجم الصورة 
                                2MB";
                break;
            case 4:
                $UserErrorMsg="من فضلك استخدم صورة من ضمن الإمتدادات التالية:<br>
                                jpg, jpeg, png, webp.";
                break;
            case 5:
            case 6:
            case 7:
                $UserErrorMsg = "من فضلك ارفع ملف من نوع صورة فقط";
                break;
            default:
                $UserErrorMsg = "";
        }
        $_SESSION['PageVars']['AddNewProductInfo']['ProductImgUploadError'] = $UserErrorMsg ; 
        unset($_SESSION['PageVars']['AddNewProductInfo']['AddProductImg']);

    }
    else
    {
        $_SESSION['PageVars']['AddNewProductInfo']['AddProductImg']  =$ImgName;
    }
}
function AddNewProduct()
{
    if(!isset( $_SESSION['PageVars']['AddNewProductInfo']['AddProductImg']))
    {
        $_SESSION['PageVars']['AddNewProductInfo']['ProductImgUploadError'] = 'الرجاء اختيار صورة للمنتج !!!';
    }
    else
    {
        if($NewPurchasedProductId = AddNewPurchasedProduct_Business( $_SESSION['PageVars']['AddNewProductInfo']))
        {
            $ProductImgName  = $_SESSION['PageVars']['AddNewProductInfo']['AddProductImg'];
            MoveImgToAnotherFolder_Business($ProductImgName, "temp", "products");
            unset($_SESSION['PageVars']['AddNewProductInfo']);
        }
        $_SESSION['PageVars']['NewPurchasedProductId'] = $NewPurchasedProductId;

        
    }
}

function AddNewProductAgain()
{
    unset($_SESSION['PageVars']['AddNewProductInfo']);
    unset($_SESSION['PageVars']['NewPurchasedProductId']);
}

function ProcessPostFormSubmission() 
{
    if (isset($_POST['go_back'])) 
    {
        GoBack();
    }

    else if (!empty($_FILES['product_image']['name']))
    {
        //to save input tags in HTML value when change the img 
        $_SESSION['PageVars']['AddNewProductInfo']['Name'] = $_POST['product_name'];
        $_SESSION['PageVars']['AddNewProductInfo']['Quantity'] = !empty($_POST['product_quantity'])? (int)$_POST['product_quantity'] :null;
        $_SESSION['PageVars']['AddNewProductInfo']['ImportArrivalDateTime'] = $_POST['product_import_date_time'];
        $_SESSION['PageVars']['AddNewProductInfo']['PurchasePrice'] = !empty($_POST['product_purchase_price'])? (float)$_POST['product_purchase_price'] :null;
        $_SESSION['PageVars']['AddNewProductInfo']['BaseSellingPrice'] = !empty($_POST['product_base_selling_price'])? (float)$_POST['product_base_selling_price'] :null;
        $_SESSION['PageVars']['AddNewProductInfo']['Details'] = trim($_POST['product_details']);
        $_SESSION['PageVars']['AddNewProductInfo']['SupplierName'] = trim($_POST['supplier_name']);

        $InputName = "product_image";
        UploadProductImgToTempFolder($InputName);
    }

    else if (isset($_POST['add_product']))
    {        
        //to save input tags in HTML value when the save operation has error 
        $_SESSION['PageVars']['AddNewProductInfo']['Name'] = $_POST['product_name'];
        $_SESSION['PageVars']['AddNewProductInfo']['Quantity'] = !empty($_POST['product_quantity'])? (int)$_POST['product_quantity'] :null;
        $_SESSION['PageVars']['AddNewProductInfo']['ImportArrivalDateTime'] = $_POST['product_import_date_time'];
        $_SESSION['PageVars']['AddNewProductInfo']['PurchasePrice'] = !empty($_POST['product_purchase_price'])? (float)$_POST['product_purchase_price'] :null;
        $_SESSION['PageVars']['AddNewProductInfo']['BaseSellingPrice'] = !empty($_POST['product_base_selling_price'])? (float)$_POST['product_base_selling_price'] :null;
        $_SESSION['PageVars']['AddNewProductInfo']['Details'] = trim($_POST['product_details']);
        $_SESSION['PageVars']['AddNewProductInfo']['SupplierName'] = trim($_POST['supplier_name']);

        AddNewProduct();

    }
    else if (isset($_POST['main_screen']))
    {        

        GoBack();

    }
    else if (isset($_POST['add_new_product_again']))
    {        
        AddNewProductAgain();
    }

    
}

function Redirect()
{
    $Redirect = $_SERVER['HTTP_REFERER'] ?? '/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/import_products_view.php';
    header("Location: ". $Redirect);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    ProcessPostFormSubmission();
    Redirect();
} 
