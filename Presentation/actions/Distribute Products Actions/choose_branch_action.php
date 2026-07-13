<?php
require_once __DIR__ . "/../../includes/auth.php";

require_once __DIR__ . "/../../../Business/Business_Utils.php";
require_once __DIR__ . "/../../../Business/Branch.php";


function GoBack()
{  

    header(header: "Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/Export%20Products%20Screens/Distribute%20Products/distribute_product.php");  
    exit;
}
function ShowAddNewBranchModal()
{
    $_SESSION['PageVars']['AddNewBranchInfo']['ShowAddNewBranchModal'] = true; 
}
function AddNewBranch($BranchName, $BranchImgName)
{
    $BranchInfo['BranchName']   = $BranchName;
    $BranchInfo['BranchImgName']=$BranchImgName;
    if(AddNewBranch_Business($BranchInfo) !=0)
    {
        $_SESSION['PageVars']['AddNewBranchStatus'] = true;
    }
    else
    {
        $_SESSION['PageVars']['AddNewBranchStatus'] = false;

    }
}
function CloseAddNewBranchModal(?string $TempImgBranchName)
{
    if(($TempImgBranchName) != null)
    {
        DeleteImageFromFolder_Business($TempImgBranchName, "temp");
    }
    unset($_SESSION['PageVars']['AddNewBranchInfo']);
}
function SetViewMode(string $ViewMode)
{
    if($ViewMode =='Cards')
    {
        $_SESSION["PageVars"]['ViewMode'] = $ViewMode;
    }
    else if($ViewMode=='Table')
    {
        $_SESSION["PageVars"]['ViewMode'] = $ViewMode;

    }
}

function SearchBranchesByBranchName(string $TextSearch)
{   
    $NumberOfItemsPerPage= $_SESSION['PageVars']['NumberOfItemsPerPage']??8;
    $OrderDir = $_SESSION['PageVars']['OrderDir']??"ASC" ;
    $_SESSION['PageVars']['sPageNumber']  = 1;

    if($TextSearch == "")
    {
        $Branches = GetAllBranches_Business($OrderDir, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['Branches'] = $Branches['Branches'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
    else
    {
        $Branches = SearchBranchesByName_Business($TextSearch,$OrderDir, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['Branches'] = $Branches['Branches'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
    $_SESSION['PageVars']['SearchText'] = $TextSearch;
}
function SetBranchesNumPerPage(int $NumberOfItemsPerPage)
{
    
    $OrderDir = $_SESSION['PageVars']['OrderDir']??"ASC" ;
    $_SESSION['PageVars']['NumberOfItemsPerPage'] = $NumberOfItemsPerPage;
   
    $_SESSION['PageVars']['BranchesPageNumber']  = 1;
    $TextSearch = $_SESSION['PageVars']['SearchText']??'';

    if($TextSearch == "")
    {
        $Branches = GetAllBranches_Business($OrderDir, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['Branches'] = $Branches['Branches'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
    else
    {
        $Branches = SearchBranchesByName_Business($TextSearch,$OrderDir, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['Branches'] = $Branches['Branches'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
}



function SetOrderDirOfPurchasedProdcuts(string $OrderDir)
{    
    $NumberOfItemsPerPage= $_SESSION['PageVars']['NumberOfItemsPerPage']??8;    
    $_SESSION['PageVars']['BranchesPageNumber']  = 1;
    $_SESSION['PageVars']['OrderDir'] = $OrderDir;
    $TextSearch = $_SESSION['PageVars']['SearchText']??'';

    if($TextSearch == "")
    {
        $Branches = GetAllBranches_Business($OrderDir, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['Branches'] = $Branches['Branches'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
    else
    {
        $Branches = SearchBranchesByName_Business($TextSearch,$OrderDir, Limit:$NumberOfItemsPerPage, Offset:0);
        $_SESSION["PageVars"]['Branches'] = $Branches['Branches'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
}

function  SetBranchesPageNumber(int $PageNumber)
{
    $_SESSION['PageVars']['BranchesPageNumber']  = $PageNumber;
    $NumberOfItemsPerPage= $_SESSION['PageVars']['NumberOfItemsPerPage']??8;
    
    $OrderDir = $_SESSION['PageVars']['OrderDir']??"ASC" ;
   $TextSearch = $_SESSION['PageVars']['SearchText']??'';

    if($TextSearch == "")
    {
        $Branches = GetAllBranches_Business($OrderDir, Limit:$NumberOfItemsPerPage, Offset: $NumberOfItemsPerPage * ($PageNumber-1));
        $_SESSION["PageVars"]['Branches'] = $Branches['Branches'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }
    else
    {
        $Branches = SearchBranchesByName_Business($TextSearch,$OrderDir, Limit:$NumberOfItemsPerPage, Offset: $NumberOfItemsPerPage * ($PageNumber-1));
        $_SESSION["PageVars"]['Branches'] = $Branches['Branches'];
        $_SESSION["PageVars"]['TotalSearchResultNumber'] = $Branches['TotalBranchesNum'];
    }

}

function ShowEditBranchModal(int $BranchId)
{
    $_SESSION['PageVars']['EditBranchInfo'] = GetBranchByBranchId_Business($BranchId);
}
/**
 * Summary of UploadBranchImgToTempFolder
 * @param mixed $InputNameInForm in       : put the name of input that use to upload the img in html
 * @param mixed $ImgName         in && out: put the img var to get the name of uploaded img in temp folder
 * @param mixed $ImgUploadError  out      : put the img error var to get the error text if the img does not uploaded
 * @return void
 */
function UploadBranchImgToTempFolder($InputNameInForm, &$ImgName, &$ImgUploadError)
{
    $ErrorCode = 0;

    $NewImgName = UploadImgToFolder_Business($InputNameInForm, "temp", ErrorCode: $ErrorCode);

    if ($NewImgName !== false) 
    {
        if (!empty($ImgName)) 
        {
            DeleteImageFromFolder_Business($ImgName, "temp");
        }

        $ImgName = $NewImgName;
        $ImgUploadError = null;
        return;
    }

    switch ($ErrorCode)
    {
        case 1:
        case 2:
        case 8:
            $UserErrorMsg = "لم يتم رفع الصورة";
            break;
        case 3:
            $UserErrorMsg = "يجب أن لا يتجاوز حجم الصورة 2MB";
            break;
        case 4:
            $UserErrorMsg = "من فضلك استخدم صورة من ضمن الإمتدادات التالية:<br> jpg, jpeg, png, webp.";
            break;
        case 5:
        case 6:
        case 7:
            $UserErrorMsg = "من فضلك ارفع ملف من نوع صورة فقط";
            break;
        default:
            $UserErrorMsg = "";
    }

    $ImgUploadError = $UserErrorMsg;
}


function SaveEditBranchInfo(int $BranchId, string $BranchName)
{ 
    $UpdatedBranchInfo = 
    [
        'BranchName' => $BranchName,
        'BranchImgName'  => $_SESSION['PageVars']['EditBranchInfo']['BranchImgName'] ?? null,

    ];

    if
    (
        $_SESSION['PageVars']['EditBranchInfo']['BranchName'] == $BranchName &&
        !isset($_SESSION['PageVars']['EditBranchInfo']['TempBranchImg'])
    )
    {
        $_SESSION['PageVars']['UpdatedBranchStatus'] = 0;
        return;
    }

    // If a temp image was uploaded earlier, move it to permanent and set final name
    if (isset($_SESSION['PageVars']['EditBranchInfo']['TempBranchImg']))
    {
        $UpdatedBranchInfo['BranchImgName'] = $_SESSION['PageVars']['EditBranchInfo']['TempBranchImg'];
        MoveImgToAnotherFolder_Business($_SESSION['PageVars']['EditBranchInfo']['TempBranchImg'], "temp", "branches");
    }

    // perform database update
    if (UpdateBranchByBranchId_Business($BranchId, $UpdatedBranchInfo) != null)
    {
        // refresh branches list and set success
        SearchBranchesByBranchName(TextSearch: $_SESSION['PageVars']['SearchText']??'');
        $_SESSION['PageVars']['UpdatedBranchStatus'] = 1;
    }
    else
    {
        $_SESSION['PageVars']['UpdatedBranchStatus'] = -1;
    }
    

}
function CloseEditBranchModal()
{
    unset( $_SESSION['PageVars']['EditBranchInfo']);
}

function ShowDeleteBranchModal(int $BranchId)
{
    $_SESSION["PageVars"]['DeleteBranch'] = GetBranchByBranchId_Business($BranchId);
}
function DeleteBranch(int $BranchId)
{
    if(DeleteBranchByBranchId_Business($BranchId) != null)
    {
        $_SESSION['PageVars']['DeleteBranchStatus'] = 1;
    }

    else
    {
        $_SESSION['PageVars']['DeleteBranchStatus'] = -1;

    }

    CloseDeleteBranchModal();
    SearchBranchesByBranchName(TextSearch: $_SESSION['PageVars']['SearchText']??'');
}
function CloseDeleteBranchModal()
{
    unset($_SESSION["PageVars"]['DeleteBranch']);
}
function Redirect()
{
    header('Location: /Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/Export%20Products%20Screens/Distribute%20Products/choose_branch.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{

    if(isset($_POST["back"]))
    {
        GoBack();
    }

    else if (isset($_POST["show_add_new_branch_modal"]))
    {
        ShowAddNewBranchModal();
    }

    else if(!empty($_FILES["temp_branch_image"]["name"]) && isset($_POST['add_new_branch_input']))
    {
        //to save input tags in HTML value when change the img 
        $_SESSION['PageVars']['AddNewBranchInfo']['BranchName'] = trim($_POST['new_branch_name']);

        $InputName = "temp_branch_image";
        $ImgName = $_SESSION['PageVars']['AddNewBranchInfo']['TempBranchImg']?? null;
        $ImgUploadError =$_SESSION['PageVars']['AddNewBranchInfo']['BranchImgUploadError']??null;
        UploadBranchImgToTempFolder($InputName,   $ImgName, $ImgUploadError);
        $_SESSION['PageVars']['AddNewBranchInfo']['TempBranchImg'] = $ImgName;
        $_SESSION['PageVars']['AddNewBranchInfo']['BranchImgUploadError']=  $ImgUploadError;

    }

    else if (isset($_POST["add_new_branch"]))
    {
        $BranchName = $_POST["new_branch_name"];
        if(!isset($_SESSION['PageVars']['AddNewBranchInfo']['TempBranchImg']))
        {
            $_SESSION['PageVars']['AddNewBranchInfo']['BranchImgUploadError'] = 'الرجاء اختيار صورة للفرع!!!';
            
        }
        else
        {
            $BranchImgName = $_SESSION['PageVars']['AddNewBranchInfo']['TempBranchImg'];        

            MoveImgToAnotherFolder_Business($BranchImgName, "temp", "branches");
            AddNewBranch( $BranchName, $BranchImgName);
            SearchBranchesByBranchName('');
            unset( $_SESSION['PageVars']['AddNewBranchInfo']['TempBranchImg']);
            CloseAddNewBranchModal(TempImgBranchName: null);
        }

    }

    else if (isset($_POST["close_add_new_branch_modal"]))
    {
        CloseAddNewBranchModal($_SESSION['PageVars']['AddNewBranchInfo']['TempBranchImg']?? null);
    }

    else if(isset($_POST['search_branch_name']))
    {
        $SearchText = trim($_POST['search_text']);
        SearchBranchesByBranchName( $SearchText);
    }

    else if(isset($_POST['number_items_per_page']))
    {
        SetBranchesNumPerPage((int)$_POST['number_items_per_page']);
    } 

    else if(isset($_POST['branches_page_number']))
    {
        SetBranchesPageNumber((int) $_POST['branches_page_number']);
    }

    else if(isset($_POST['order_dir']))
    {
        SetOrderDirOfPurchasedProdcuts($_POST['order_dir']);
    }   

    else if(isset($_POST['show_edit_branch_modal']))
    {
        ShowEditBranchModal((int)$_POST['branch_id']);
    }   

    else if (!empty($_FILES['temp_branch_image']['name']) && isset($_POST['edit_branch_input']))
    {
        //to save input tags in HTML value when change the img 
        $_SESSION['PageVars']['EditBranchInfo']['BranchName'] = trim($_POST['updated_branch_name']);

        $InputName = "temp_branch_image";
        $ImgName = $_SESSION['PageVars']['EditBranchInfo']['TempBranchImg']?? null;
        $ImgUploadError =$_SESSION['PageVars']['EditBranchInfo']['BranchImgUploadError']??null;
        UploadBranchImgToTempFolder($InputName,   $ImgName, $ImgUploadError);
        $_SESSION['PageVars']['EditBranchInfo']['TempBranchImg'] = $ImgName;
        $_SESSION['PageVars']['EditBranchInfo']['BranchImgUploadError']=  $ImgUploadError;
    }

    else if (isset($_POST['save_edit_branch']))
    {
        $Branch = $_SESSION['PageVars']['EditBranchInfo'];
        $BranchId = $Branch['BranchId'];
        $BranchName = $_POST['updated_branch_name'];
        SaveEditBranchInfo($BranchId, $BranchName);
        CloseEditBranchModal();
    }

    else if(isset($_POST['close_edit_branch_modal']))
    {
        CloseEditBranchModal();
    }   

    else if(isset($_POST['show_delete_branch_modal']))
    {
        ShowDeleteBranchModal((int)$_POST['branch_id']);
    }   

    else if(isset($_POST['delete_branch']))
    {
        DeleteBranch($_SESSION["PageVars"]['DeleteBranch']['BranchId']);
    }   

    else if(isset($_POST['close_delete_branch_modal']))
    {
        CloseDeleteBranchModal();
    }  

    else if (isset($_POST['choose_branch']))
    {
        $_SESSION['PageVars']['SelectedBranch']= GetBranchByBranchId_Business($_POST['branch_id']);
        GoBack();
    }
    Redirect();
}

else if ($_SERVER["REQUEST_METHOD"] === "GET") 
{
    if(isset($_GET['view_mode']))
    {
        SetViewMode($_GET['view_mode']);
    }
    Redirect();
}

?>

