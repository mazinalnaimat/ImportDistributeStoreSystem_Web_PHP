
<?php
require_once __DIR__ . "/../../../../includes/auth.php";
require_once __DIR__ . "/../../../../../Business/Business_Utils.php";



if (empty($_SESSION['PrePage']) || $_SESSION['PrePage'] != $_SERVER['PHP_SELF']) 
{
    foreach ($_SESSION as $key => $value)
    {
        if (str_ends_with($key, 'PageVars')) 
        {
            if (str_starts_with($key,'DistributeProduct'))
            {
                continue;
            }
            unset($_SESSION[$key]);
        }
    }  
    $_SESSION['PrePage'] = $_SERVER['PHP_SELF'];
}

$ActionFilePath= "../../../../actions/Distribute Products Actions/distribute_product_action.php";


?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>تصدير منتج</title>
        <link rel="icon" type="image/png" href="../../../../assests/imgs/ALOFOQ logo without text.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../../../../assests/css/share_style.css">
        <link rel="stylesheet" href="../../../../assests/css/distribute_product_screen_style.css">
    </head>
    <body>
        <?php include_once __DIR__ . "/../../../../includes/header.php"; ?>

        <main class="container">





            <!-- Title -->
            <div class="d-flex align-items-center justify-content-center mb-4">
                <i class="bi bi-truck display-4 mb-3 text-danger"></i>
                <h2 class="page-title mb-0 mx-3">تصدير منتج</h2>
            </div>

            <!-- Back Button -->
            <div class="d-flex flex-wrap justify-content-between mb-4 gap-2 align-items-center">
                <form action="<?=$ActionFilePath?>" method="GET" class="d-inline">
                    <button type="submit" name="back" class="btn btn-outline-light rounded-pill px-4 btn-sm">
                        <i class="bi bi-arrow-right me-2"></i> رجوع
                    </button>
                </form>
            </div>

            <!-- Show Warning must choose branch Alert -->
            <?php if(isset($_SESSION['DistributeProductPageVars']['ShowWarningSelectBranch'])): ?>

            <div class="alert alert-danger alert-dismissible fade show bg-dark text-danger border-danger d-flex align-items-center" role="alert">
                
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span class="me-3">يجب اختيار الفرع قبل متابعة عملية التصدير</span>

                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
            </div>

            <?php unset($_SESSION['DistributeProductPageVars']['ShowWarningSelectBranch']); ?>
            <?php endif; ?>

            <!-- Show Warning must choose product Alert -->
            <?php if(isset($_SESSION['DistributeProductPageVars']['ShowWarningSelectProduct'])): ?>

            <div class="alert alert-danger alert-dismissible fade show bg-dark text-danger border-danger d-flex align-items-center" role="alert">
                
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span class="me-3">يجب اختيار المنتج قبل متابعة عملية التصدير</span>

                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
            </div>

            <?php unset($_SESSION['DistributeProductPageVars']['ShowWarningSelectProduct']); ?>
            <?php endif; ?>

            <!-- Show Warning must product quantity <= availabe quantity in stock Alert -->
            <?php if(isset($_SESSION['DistributeProductPageVars']['ShowWarningExceedLimitProductQuantity'])): ?>

            <div class="alert alert-danger alert-dismissible fade show bg-dark text-danger border-danger d-flex align-items-center" role="alert">
                
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span class="me-3">يجب أن تكون الكمية المصدرة من هذا المنتج أقل أو تساوي</span>
                <span class="me-2"><?=$_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']['RemainingQuantity']?></span>
            </div>

            <?php unset($_SESSION['DistributeProductPageVars']['ShowWarningExceedLimitProductQuantity']); ?>
            <?php endif; ?>

            <!-- Show Distribute Product Status Alert -->
            <?php if(isset($_SESSION['DistributeProductPageVars']['AddNewDistributionProductStatus'])):?>
                <?php if($_SESSION['DistributeProductPageVars']['AddNewDistributionProductStatus'] == true):?>
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between rounded-3 shadow-sm" role="alert">

                        <div class="d-flex align-items-center">

                            <i class="bi bi-check-circle-fill text-success fs-4"></i>

                            <span class="me-3 ms-2">
                                <strong>تم تصدير المنتج بنجاح</strong><br>
                                <small>
                                    رقم المنتج المصدر:
                                    <span class="fw-bold text-success">
                                        <?= $_SESSION['DistributeProductPageVars']['DistributionProductId'] ?>
                                    </span>
                                </small>
                            </span>

                        </div>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

                    </div>

                <?php else:?>"
                    <div class="alert alert-danger alert-dismissible fade show " role="alert">
                        
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span class="me-3">
                            <strong>حدث خطأ </strong>
                            لم يتم إضافة المنتج المراد تصديره
                        </span>

                    </div>
                <?php endif;?>
                <?php unset($_SESSION['DistributeProductPageVars']['AddNewDistributionProductStatus'] );?>
                <?php unset($_SESSION['DistributeProductPageVars']['DistributionProductId'] );?>
            <?php endif;?>

            <!-- Card to distribute prodcut -->
            <div class="distribute-card mt-4 p-3">

                <div class="distribute-header">
                    <h5>تصدير منتج</h5>
                </div>

                <div class="card-body py-3">


                    <!-- Branch -->
                    <div class="mb-4">
                        <label class="form-label text-light">الفرع المختار</label>

                        <div class="modern-select-box">
                            <div class="selected-value">
                                <?= $_SESSION['DistributeProductPageVars']['SelectedBranch']['BranchName'] ?? 'لم يتم اختيار فرع' ?>
                            </div>

                            <form method="GET" action="<?= $ActionFilePath ?>">
                                <div class="d-flex gap-3">
                                
                                    <?php if(isset($_SESSION['DistributeProductPageVars']['SelectedBranch'])):?>
                                    <button class="btn btn-info text-white d-flex align-items-center justify-content-center gap-2"
                                            type="submit"
                                            name="show_branch_details_modal">

                                        <i class="bi bi-info-circle"></i>
                                        <span>تفاصيل</span>

                                    </button>
                                    <?php endif;?>

                                    <button class="btn btn-danger text-white d-flex align-items-center justify-content-center gap-2"
                                    type="submit" name="choose_branch">
                                        <i class="bi bi-arrow-left-right"></i>
                                        <?=isset($_SESSION['DistributeProductPageVars']['SelectedBranch']) ? "تغيير الفرع" : "اختيار الفرع"?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                                        <!-- Branch Details Modal -->
                    <?php if(isset($_SESSION['DistributeProductPageVars']['ShowBranchDetailsModal'])): ?>
                    <?php 

                        $Branch = $_SESSION['DistributeProductPageVars']['SelectedBranch'];
                        $BranchId = $Branch['BranchId'];
                        $BranchName = ($Branch['BranchName'] ?? '-');
                        $ImgPath =  (!empty($Branch['BranchImgName'])) ? "../../../../../uploads/branches/" . $Branch['BranchImgName']
                                        : "../../../../assests/imgs/no-image-available.png"
                                    ;
                    ?>
                    <div class="modal show" tabindex="-1" style="display:block; background-color: rgba(0,0,0,0.5);">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-light border-danger">
                                <div class="modal-header">
                                    <h5 class="modal-title"><strong><?=$Branch['BranchName']?></strong></h5>
                                </div>

                                <div class="modal-body">

                                    <!-- IMAGE PREVIEW -->
                                    <div class="mb-3 text-center">
                                        <img src="<?= $ImgPath ?>" class="w-100 mb-3" style="height:400px; object-fit:cover;">
                                    </div>

                                    <div class="mb-3">
                                        <label class="branch-field-label">اسم الفرع</label>
                                        <div class="form-control branch-field">
                                            <?= $BranchName ?? '-' ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="branch-field-label">رقم الهاتف</label>
                                        <div class="form-control branch-field">
                                            <?= $Branch['Phone'] ?? '-' ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="branch-field-label">البريد الإلكتروني</label>
                                        <div class="form-control branch-field">
                                            <?= $Branch['Email'] ?? '-' ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="branch-field-label">العنوان</label>
                                        <div class="form-control branch-field">
                                            <?= $Branch['Address'] ?? '-' ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-danger">
                                        <form method="GET" action="<?=$ActionFilePath?>" enctype="multipart/form-data" class="mb-3">

                                            <button type="submit" name="close_branch_details_modal" class="btn btn-danger" formnovalidate>إغلاق</button>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Product Details Modal -->
                    <?php if(isset($_SESSION['DistributeProductPageVars']['ShowProductDetailsModal'] )): ?>

                    <?php 
                        $Product = $_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct'];
                        $PurchasedProductId   = $Product['PurchasedProductId'];
                        $PurchasedProductName = $Product['PurchasedProductName'];
                        $SupplierName         = $Product['SupplierName'];
                        $Quantity             = $Product['Quantity'];
                        $RemainingQuantity    = $Product['RemainingQuantity'];
                        $ArrivalDate          = $Product['ImportArrivalDate'];
                        $PurchasePrice = number_format($Product['PurchasePrice'], 2);
                        $BaseSellingPrice  = number_format($Product['BaseSellingPrice'],2);
                        $Profit        = number_format($BaseSellingPrice - $PurchasePrice, 2);
                        $ProductDetails         = $Product['Details'];
                        $ProfitClass = $Profit > 0 ? 'profit-positive' : ($Profit < 0 ? 'profit-negative' : 'profit-zero');


                        // Image fallback
                        $ImgPath = (!empty($Product['ProductImgName'])) 
                                    ? "../../../../../uploads/products/" . $Product['ProductImgName'] 
                                    : "../../../../assests/imgs/no-image-available.png";
                    ?>

                    <div class="modal fade show d-block" id="productModal" tabindex="-1" aria-modal="true" role="dialog" style="background: rgba(0,0,0,0.5);">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content bg-dark text-light">

                                <!-- HEADER -->
                                <div class="modal-header border-0">
                                    <h5 class="modal-title w-100 text-center"><?= $PurchasedProductName ?></h5>
                                </div>

                                <!-- BODY -->
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="product-img-container w-100">
                                                <?php if ($RemainingQuantity <= 0): ?>
                                                    <div class="unavailable-label">غير متوفر</div>
                                                    <img src="<?= $ImgPath ?>" 
                                                        alt="<?= $PurchasedProductName ?>"
                                                        class="modal-img rounded-3 shadow-sm w-100 unavailable"
                                                        onerror="this.src='../../../assests/imgs/no-image-available.png';">
                                                <?php else: ?>
                                                    <img src="<?= $ImgPath?>" 
                                                        alt="<?= $PurchasedProductName ?>"
                                                        class="modal-img rounded-3 shadow-sm w-100"
                                                        onerror="this.src='../../../assests/imgs/no-image-available.png';">
                                                <?php endif; ?>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <ul class="list-group list-group-flush bg-dark">

                                                <li class="list-group-item bg-dark text-light d-flex justify-content-between">
                                                    <span class="fw-bold ms-2">الاسم:</span>
                                                    <span class="flex-fill text-start"><?= $PurchasedProductName ?></span>
                                                </li>

                                                <li class="list-group-item bg-dark text-light d-flex justify-content-between">
                                                    <span class="fw-bold ms-2">المورد:</span>
                                                    <span class="flex-fill text-start"><?= $SupplierName ?></span>
                                                </li>

                                                <li class="list-group-item bg-dark text-light d-flex justify-content-between">
                                                    <span class="fw-bold ms-2">الكمية:</span>
                                                    <span class="flex-fill text-start"><?= $Quantity ?></span>
                                                </li>

                                                <li class="list-group-item bg-dark text-light d-flex justify-content-between">
                                                    <span class="fw-bold ms-2">المتبقي:</span>
                                                    <span class="flex-fill text-start"><?= $RemainingQuantity ?></span>
                                                </li>

                                                <li class="list-group-item bg-dark text-light d-flex justify-content-between">
                                                    <span class="fw-bold ms-2">تاريخ الوصول:</span>
                                                    <span class="flex-fill text-start"><?= $ArrivalDate ?></span>
                                                </li>

                                                <li class="list-group-item bg-dark text-light d-flex justify-content-between">
                                                    <span class="fw-bold ms-2">سعر الشراء:</span>
                                                    <span class="flex-fill text-start"><?= $PurchasePrice ?></span>
                                                </li>

                                                <li class="list-group-item bg-dark text-light d-flex justify-content-between">
                                                    <span class="fw-bold ms-2">سعر البيع الأساسي:</span>
                                                    <span class="flex-fill text-start"><?= $BaseSellingPrice ?></span>
                                                </li>
                                                
                                                <li class="list-group-item bg-dark text-light d-flex justify-content-between">
                                                    <span class="fw-bold ms-2">الربح:</span>
                                                    <span class="flex-fill text-start <?= $ProfitClass ?>"><?= $Profit ?></span>
                                                </li>

                                                <li class="list-group-item bg-dark text-light d-flex justify-content-between">
                                                    <span class="fw-bold ms-2 ">الربح الإجمالي:</span>
                                                    <span class="flex-fill text-start <?= $ProfitClass ?>"><?= $Profit * $Quantity ?></span>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                    <?php if (!empty($ProductDetails)): ?>
                                        <div class="mt-3">
                                            <h6>الوصف</h6>
                                            <p class="small text-light">
                                                <?= $ProductDetails ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <!-- FOOTER -->
                                <div class="modal-footer border-0">
                                    <form method="GET" action="<?= $ActionFilePath ?>">
                                        <button type="submit" name="close_product_details_modal" 
                                                class="btn btn-outline-danger w-100 fw-bold">
                                            إغلاق
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php endif; ?>

                    <!-- Product -->
                    <div class="mb-4">
                        <label class="form-label text-light">المنتج المختار</label>

                        <div class="modern-select-box">
                            <div class="selected-value">
                                <?= $_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']['PurchasedProductName'] ?? 'لم يتم اختيار منتج' ?>
                            </div>

                            
                            <form method="GET" action="<?=$ActionFilePath?>">
                                <div class="d-flex gap-3">

                                    <?php if(isset($_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct'])):?>
                                    <button class="btn btn-info text-white d-flex align-items-center justify-content-center gap-2"
                                            type="submit"
                                            name="show_product_details_modal" >

                                        <i class="bi bi-info-circle"></i>
                                        <span>تفاصيل</span>

                                    </button>
                                    <?php endif;?>

                                    <button class="btn btn-danger text-white d-flex align-items-center justify-content-center gap-2"
                                    type="submit" name="choose_product" >
                                        <i class="bi bi-arrow-left-right"></i>
                                        <?=isset($_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']) ? "تغيير المنتج" : "اختيار المنتج"?>
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                    <form method="POST" action="<?= $ActionFilePath ?>">

                        <?php if(isset($_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct'])):?>

                            <!-- Purchase Price -->
                            <div class="mb-3">
                                <label class="form-label text-light">سعر الشراء</label>
                                <input type="text"
                                    class="modern-input disabled-input"
                                    value="<?= $_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']['PurchasePrice'] ?? 0 ?>"
                                    readonly>
                            </div>

                            <!-- Base Selling Price -->
                            <div class="mb-3">
                                <label class="form-label text-light">سعر البيع الأساسي</label>
                                <input type="text"
                                    class="modern-input disabled-input"
                                    value="<?= $_SESSION['DistributeProductPageVars']['SelectedPurchasedProduct']['BaseSellingPrice'] ?? 0 ?>"
                                    readonly>
                            </div>

                            <!-- Final Selling Price -->
                            <div class="mb-3">
                                <label class="form-label text-light">سعر البيع النهائي</label>
                                <input type="number"
                                    name="FinalSellingPrice"
                                    class="modern-input active-input"
                                    min="1"
                                    step="0.01"
                                    <?php echo isset($_SESSION['DistributeProductPageVars']['FinalSellingPrice']) 
                                            ? 'value="' . $_SESSION['DistributeProductPageVars']['FinalSellingPrice'] . '"' 
                                            : ''; ?>
                                    required>
                            </div>

                            <!-- Quantity -->
                            <div class="mb-3">
                                <label class="form-label text-light">الكمية المراد تصديرها</label>
                                <input type="number"
                                    name="ExportQuantity"
                                    class="modern-input active-input"
                                    min="1"
                                    <?php echo isset($_SESSION['DistributeProductPageVars']['ExportQuantity']) 
                                            ? 'value="' . $_SESSION['DistributeProductPageVars']['ExportQuantity'] . '"' 
                                            : ''; ?>
                                    required>
                            </div>

                        <?php endif;?>

                        <!-- Submit -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" name="distribute_product" class="submit-btn">
                                تصدير المنتج
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </main>

        <?php include_once __DIR__ . "/../../../../includes/footer.php"; ?>

    </body>
</html>