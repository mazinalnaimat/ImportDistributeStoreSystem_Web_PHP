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
    require_once __DIR__ . "/../../../../actions/Distribute Products Actions/choose_product_init_action.php";
}

$ActionFilePath = "../../../../actions/Distribute%20Products%20Actions/choose_product_action.php";



?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>المنتجات</title>
        <link rel="icon" type="image/png" href="../../../../assests/imgs/ALOFOQ logo without text.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../../../../assests/css/share_style.css">
        <link rel="stylesheet" href="../../../../assests/css/products_screen_style.css">

    </head>
    <body>
    <?php include_once __DIR__ . "/../../../../includes/header.php"; ?>

    <main class="container">

        <!-- Title -->
        <div class="d-flex align-items-center justify-content-center mb-4">
            <i class="bi bi-box-seam display-4 mb-3 text-danger"></i>
            <h2 class="page-title mb-0 mx-3">
            <?php 
            $Text = isset($_SESSION['DistributeProductPageVars']['ChoosePurchasedProduct']) ? "اختيار المنتج" : "المنتجات";
            echo($Text);
            ?>
            </h2>
        </div>

        <!-- Back Button + Toggle View Mode-->
        <div class="d-flex flex-wrap justify-content-between mb-4 gap-2 align-items-center responsive-action-bar">
            <form action="<?=$ActionFilePath?>" method="GET" class="d-inline">
                <button type="submit" name="back" class="btn app-back-button">
                    <i class="bi bi-arrow-right me-2"></i> رجوع
                </button>
            </form>


            <!-- Toggle View Button -->
            <?php $ViewMode = $_SESSION["ProductsPageVars"]['ViewMode'] ?? 'Cards';?>
            <form method="GET" action="<?=$ActionFilePath?>" class="d-flex gap-2 align-items-center">
                <?php if ($ViewMode === 'Cards'): ?>
                    <input type="hidden" name="view_mode" value="Table">
                    <button type="submit" class="btn btn-outline-light fw-bold">عرض جدول</button>
                <?php else: ?>
                    <input type="hidden" name="view_mode" value="Cards">
                    <button type="submit" class="btn btn-outline-light fw-bold">عرض بطاقات</button>
                <?php endif; ?>
            </form>
        </div>

        <!-- Controls Row -->
        <div class="container-fluid mb-4">
            <div class="d-flex flex-wrap justify-content-between justify-content-md-start align-items-center gap-3">

                <!-- Search Card -->
                <div class="flex-grow-1 responsive-control-block">
                    <div class="card bg-dark border-secondary text-light shadow-sm p-3" style="border-radius: 14px;">
                        <form method="GET" action="<?= $ActionFilePath ?>" class="d-flex align-items-center gap-3">

                            <div class="flex-grow-1">
                                <label class="form-label small text-light">اسم المنتج</label>
                                <input type="text" name="search_text"
                                    value="<?= htmlspecialchars($_SESSION['ProductsPageVars']['SearchText'] ?? '') ?>"
                                    class="form-control bg-dark text-light border-secondary"
                                    placeholder="ابحث...">
                            </div>

                            <div>
                                <button name="search_product_name" class="btn btn-danger px-4 mt-4 fw-bold">
                                    <i class="bi bi-search"></i> بحث
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Right Side Filters -->
                <div class="d-flex flex-wrap gap-3 align-items-center justify-content-end justify-content-md-start responsive-filter-group">
                    <?php $NumberOfItemsPerPage = $_SESSION['ProductsPageVars']['NumberOfItemsPerPage'] ?? 8;
                        $PageNumber = $_SESSION['ProductsPageVars']['PurchasedProductsPageNumber'] ?? 1;
                        $TotalResults = $_SESSION['ProductsPageVars']['TotalSearchResultNumber'] ?? 0;
                        $TotalPages = max(1, (int)ceil((float)$TotalResults / $NumberOfItemsPerPage));
                        $Offset = ($PageNumber - 1) * $NumberOfItemsPerPage;
                    ?>

                    <!-- Items per page -->
                    <div>
                        <form method="GET" action="<?= $ActionFilePath ?>">
                            <label class="form-label small text-light">عدد العناصر</label>
                            <select name="number_items_per_page"
                                    class="form-select bg-dark text-light border-secondary"
                                    onchange="this.form.submit()">
                                <?php foreach ([8,16,32,64,128] as $n): ?>
                                    <option value="<?= $n ?>" <?= ($NumberOfItemsPerPage == $n ? "selected" : "") ?>>
                                        <?= $n ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>

                    <!-- Order By Column -->
                    <div>
                        <form method="GET" action="<?= $ActionFilePath ?>">
                            <label class="form-label small text-light">ترتيب حسب</label>
                            <select name="order_by" class="form-select bg-dark text-light border-secondary"
                                    onchange="this.form.submit()">
                                <?php $OrderBy = $_SESSION['ProductsPageVars']['ColNameForOrderBy'] ?? 'PurchasedProductName'; ?>
                                <option value="PurchasedProductName" <?= $OrderBy=='PurchasedProductName'?'selected':'' ?>>اسم المنتج</option>
                                <option value="Quantity" <?= $OrderBy=='Quantity'?'selected':'' ?>>الكمية </option>
                                <option value="RemainingQuantity" <?= $OrderBy=='RemainingQuantity'?'selected':'' ?>>الكمية المتاحة</option>
                                <option value="ImportArrivalDate" <?= $OrderBy=='ImportArrivalDate'?'selected':'' ?>>تاريخ وصول المنتج إلى المستودع</option>
                                <option value="PurchasePrice" <?= $OrderBy=='PurchasePrice'?'selected':'' ?>>سعر الشراء</option>
                                <option value="BaseSellingPrice" <?= $OrderBy=='BaseSellingPrice'?'selected':'' ?>>سعر البيع الأساسي</option>
                                <option value="SupplierName" <?= $OrderBy=='SupplierName'?'selected':'' ?>>اسم المورد</option>
                            </select>
                        </form>
                    </div>

                    <!-- Order Direction -->
                    <div>
                        <form method="GET" action="<?= $ActionFilePath ?>">
                            <label class="form-label small text-light">الترتيب</label>
                            <select name="order_dir" class="form-select bg-dark text-light border-secondary"
                                    onchange="this.form.submit()">
                                <?php $OrderDir = $_SESSION['ProductsPageVars']['OrderDir'] ?? 'ASC'; ?>
                                <option value="ASC"  <?= $OrderDir=='ASC'?'selected':'' ?>>تصاعدي</option>
                                <option value="DESC" <?= $OrderDir=='DESC'?'selected':'' ?>>تنازلي</option>
                            </select>
                        </form>
                    </div>

                    <!-- Available Product Filter -->
                    <div>
                        <form method="GET" action="<?= $ActionFilePath ?>">
                            <label class="form-label small text-light">حالة المنتج</label>

                            <select name="available_product_filter" class="form-select bg-dark text-light border-secondary"
                                    onchange="this.form.submit()">

                                <?php $Filter = $_SESSION['ProductsPageVars']['AvailableProductFilter'] ?? 'all'; ?>

                                <option value="all"         <?= $Filter=='all'?'selected':'' ?>>الكل</option>
                                <option value="available"   <?= $Filter=='available'?'selected':'' ?>>المتوفر</option>
                                <option value="not_available"<?= $Filter=='not_available'?'selected':'' ?>>غير المتوفر</option>

                            </select>
                        </form>
                    </div>


                </div>
            </div>
        </div>

        <!-- Product Details Modal -->
        <?php if(isset($_SESSION['ProductsPageVars']['PurchasedProductDetailsId'])): ?>

        <?php 
            $Product = $_SESSION['ProductsPageVars']['PurchasedProductDetailsId'];
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
            $ImgPath = (!empty($Product['ProductImgName'])) ? "../../../../../uploads/products/" . $Product['ProductImgName'] : "../../../../assests/imgs/no-image-available.png";
        ?>

        <!-- AUTO-SHOW MODAL -->
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

                                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-start gap-2">
                                        <span class="fw-bold ms-2 flex-shrink-0 text-nowrap">الاسم:</span>
                                        <span class="flex-grow-1 text-start text-break" style="min-width: 0;"><?= $PurchasedProductName ?></span>
                                    </li>

                                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-start gap-2">
                                        <span class="fw-bold ms-2 flex-shrink-0 text-nowrap">المورد:</span>
                                        <span class="flex-grow-1 text-start text-break" style="min-width: 0;"><?= $SupplierName ?></span>
                                    </li>

                                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-start gap-2">
                                        <span class="fw-bold ms-2 flex-shrink-0 text-nowrap">الكمية:</span>
                                        <span class="flex-grow-1 text-start text-break" style="min-width: 0;"><?= $Quantity ?></span>
                                    </li>

                                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-start gap-2">
                                        <span class="fw-bold ms-2 flex-shrink-0 text-nowrap">المتبقي:</span>
                                        <span class="flex-grow-1 text-start text-break" style="min-width: 0;"><?= $RemainingQuantity ?></span>
                                    </li>

                                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-start gap-2">
                                        <span class="fw-bold ms-2 flex-shrink-0 text-nowrap">تاريخ الوصول:</span>
                                        <span class="flex-grow-1 text-start text-break" style="min-width: 0;"><?= $ArrivalDate ?></span>
                                    </li>

                                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-start gap-2">
                                        <span class="fw-bold ms-2 flex-shrink-0 text-nowrap">سعر الشراء:</span>
                                        <span class="flex-grow-1 text-start text-break" style="min-width: 0;"><?= $PurchasePrice ?></span>
                                    </li>

                                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-start gap-2">
                                        <span class="fw-bold ms-2 flex-shrink-0 text-nowrap">سعر البيع الأساسي:</span>
                                        <span class="flex-grow-1 text-start text-break" style="min-width: 0;"><?= $BaseSellingPrice ?></span>
                                    </li>
                                    
                                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-start gap-2">
                                        <span class="fw-bold ms-2 flex-shrink-0 text-nowrap">الربح:</span>
                                        <span class="flex-grow-1 text-start text-break <?= $ProfitClass ?>" style="min-width: 0;"><?= $Profit ?></span>
                                    </li>

                                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-start gap-2">
                                        <span class="fw-bold ms-2 flex-shrink-0 text-nowrap">الربح الإجمالي:</span>
                                        <span class="flex-grow-1 text-start text-break <?= $ProfitClass ?>" style="min-width: 0;"><?= $Profit * $Quantity ?></span>
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

        <?php $PurchasedProducts = $_SESSION["ProductsPageVars"]['PurchasedProducts'] ?? [];?>
        <?php if ($ViewMode === 'Cards'): ?>
            <!-- Cards View -->
            <?php if (!empty($PurchasedProducts)): ?>
                <div class="row justify-content-center g-4 mb-5">
                    <?php foreach ($PurchasedProducts as $Product): 
                        $PurchasedProductId = ($Product['PurchasedProductId'] ?? '');
                        $PurchasedProductName = ($Product['PurchasedProductName'] ?? '-');
                        $SupplierName = ($Product['SupplierName'] ?? '-');
                        $RemainingQuantity = (int)($Product['RemainingQuantity'] ?? 0);
                        $Quantity = (int)($Product['Quantity'] ?? 0);
                        $PurchasePrice = (float)($Product['PurchasePrice'] ?? 0);
                        $BaseSellingPrice = (float)($Product['BaseSellingPrice'] ?? 0);
                        $Profit = $BaseSellingPrice - $PurchasePrice;
                        $Profit = number_format($Profit, 2);
                        $TotalProfit = $Profit * $Quantity;
                        $PurchasePrice = number_format($PurchasePrice, 2);
                        $BaseSellingPrice = number_format($BaseSellingPrice, 2);
                        $ArrivalDate = ($Product['ImportArrivalDate'] ?? '-');
                        $ImgName = $Product['ProductImgName'] ?? '';
                        $ImgPath = $ImgName && file_exists(__DIR__ . "/../../../../../uploads/products/" . $ImgName)
                                    ? "../../../../../uploads/products/" . $ImgName
                                    : "../../../../assests/imgs/no-image-available.png"; 
                        $ProfitClass = $Profit > 0 ? 'profit-positive' : ($Profit < 0 ? 'profit-negative' : 'profit-zero');
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card text-center h-100 shadow-lg hover-scale rounded-4 border-0" style="background: linear-gradient(145deg, #1c1c1c, #2a2a2a);">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <div class="product-img-container w-100">
                                        <?php if ($RemainingQuantity <= 0): ?>
                                            <div class="unavailable-label">غير متوفر</div>
                                            <img src="<?= $ImgPath ?>" 
                                                alt="<?= $PurchasedProductName; ?>" 
                                                class="img-fluid mb-3 rounded-3 shadow-sm product-card-img unavailable">
                                        <?php else: ?>
                                            <img src="<?= $ImgPath ?>" 
                                                alt="<?= $PurchasedProductName; ?>" 
                                                class="img-fluid mb-3 rounded-3 shadow-sm product-card-img">
                                        <?php endif; ?>
                                    </div>
                                    <h5 class="card-title text-danger fw-bold mb-2"><?= $PurchasedProductName; ?></h5>
                                    <p class="card-text text-light mb-1"><strong>المورد:</strong> <?= $SupplierName; ?></p>
                                    <p class="card-text text-light mb-1"><strong>الكمية :</strong> <?= $Quantity; ?></p>
                                    <p class="card-text text-light mb-1"><strong>المتبقي</strong> <?= $RemainingQuantity; ?></p>
                                    <p class="card-text text-light mb-1"><strong>سعر الشراء:</strong> <?= $PurchasePrice; ?></p>
                                    <p class="card-text text-light mb-1"><strong>سعر البيع الأساسي:</strong> <?= $BaseSellingPrice; ?></p>
                                    <p class="card-text mb-1 <?= $ProfitClass ?>"><strong>الربح:</strong> <?= $Profit; ?></p>
                                    <p class="card-text mb-3 <?= $ProfitClass ?>"><strong>الربح الإجمالي:</strong> <?= $TotalProfit; ?></p>

                                    <div class="d-grid gap-2 w-100 mt-auto">
                                        <!-- Modal trigger -->
                                        <form method="GET" action="<?=$ActionFilePath?>">
                                            <input name="product_id" name="product_id" value="<?=$PurchasedProductId?>" hidden>
                                            <button type="submit" name="show_product_details_modal" class="btn btn-outline-danger w-100 fw-bold">
                                                 التفاصيل
                                            </button>
                                            <button
                                                type="submit"
                                                name="choose_product"
                                                class="btn btn-outline-danger w-100 fw-bold mt-3"
                                                <?= ($RemainingQuantity <= 0) ? 'disabled' : ''; ?>
                                            >
                                                 اختيار
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center text-light my-5 fs-4">
                    لا توجد منتجات لعرضها
                </div>
            <?php endif; ?>

        <?php else: ?>
            <!-- Table View -->
            <?php if (!empty($PurchasedProducts)): ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover text-center align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>صورة</th>
                                <th>اسم المنتج</th>
                                <th>المورد</th>
                                <th>الكمية</th>
                                <th>المتبقي</th>
                                <th>تاريخ الوصول</th>
                                <th>سعر الشراء</th>
                                <th>سعر البيع الأساسي</th>
                                <th>الربح</th>
                                <th>إجمالي الربح</th>
                                <th>الخيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($PurchasedProducts as $Index => $Product): 
                                $RowIndex = $Offset + $Index + 1;
                                $PurchasedProductId = ($Product['PurchasedProductId'] ?? '');
                                $PurchasedProductName = ($Product['PurchasedProductName'] ?? '-');
                                $SupplierName = ($Product['SupplierName'] ?? '-');
                                $RemainingQuantity = (int)($Product['RemainingQuantity'] ?? 0);
                                $Quantity = (int)($Product['Quantity'] ?? 0);
                                $PurchasePrice = (float)($Product['PurchasePrice'] ?? 0);
                                $BaseSellingPrice = (float)($Product['BaseSellingPrice'] ?? 0);
                                $Profit = $BaseSellingPrice - $PurchasePrice;
                                $Profit = number_format($Profit, 2);
                                $PurchasePrice = number_format($PurchasePrice, 2);
                                $BaseSellingPrice = number_format($BaseSellingPrice, 2);
                                $ArrivalDate = ($Product['ImportArrivalDate'] ?? '-');
                                $ImgName = $Product['ProductImgName'] ?? '';
                                $ImgPath = $ImgName && file_exists(__DIR__ . "/../../../../../uploads/products/" . $ImgName)
                                            ? "../../../../../uploads/products/" . $ImgName
                                            : "../../../../assests/imgs/no-image-available.png";
                                $ProfitClass = $Profit > 0 ? 'profit-positive' : ($Profit < 0 ? 'profit-negative' : 'profit-zero');
                            ?>
                                <tr class="<?= $RemainingQuantity <= 0 ? 'not-available-row text-light' : '' ?>">
                                    <td><?= $RowIndex; ?></td>
                                    <td class="text-center">
                                        <div class="product-img-container d-inline-block">
                                            <?php if ($RemainingQuantity <= 0): ?>
                                                <div class="unavailable-label" style="font-size:10px">غير متوفر</div>
                                                <img src="<?= $ImgPath ?>" alt="<?= $PurchasedProductName ?>" class="table-product-img shadow-sm unavailable">
                                            <?php else: ?>
                                                <img src="<?= $ImgPath ?>" alt="<?= $PurchasedProductName ?>" class="table-product-img shadow-sm">
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td><?= $PurchasedProductName; ?></td>
                                    <td style="width: 1%; white-space: nowrap;"><?= $SupplierName; ?></td>
                                    <td><?= $Quantity; ?></td>
                                    <td><?= $RemainingQuantity; ?></td>
                                    <td style="width: 1%; white-space: nowrap;"><?= $ArrivalDate; ?></td>
                                    <td><?= $PurchasePrice; ?></td>
                                    <td><?= $BaseSellingPrice; ?></td>
                                    <td class="<?= $ProfitClass ?>"><?= $Profit; ?></td>
                                    <td class="<?= $ProfitClass ?>"><?= $Profit * $Quantity; ?></td>
                                    <td>
                                        <!-- modal trigger -->
                                        <form method="GET" action="<?=$ActionFilePath?>">
                                            <input name="product_id" value="<?=$PurchasedProductId?>" hidden>
                                            <button type="submit" name="show_product_details_modal" class="btn btn-outline-light w-100 fw-bold">
                                                 التفاصيل
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center text-light my-5 fs-4">
                    لا توجد منتجات لعرضها
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if ($TotalPages > 1): ?>
            <nav class="mt-3">
                <ul class="pagination justify-content-center gap-1">
                    
                    <li class="page-item <?= ($PageNumber<= 1) ? 'disabled' : '' ?>">
                        <form method="GET" action="<?=$ActionFilePath?>" class="d-inline m-0 p-0">
                            <input type="hidden" name="purchased_products_page_number" value="<?= max(1, $PageNumber- 1) ?>">
                            <button type="submit" class="page-link btn shadow-none <?= ($PageNumber<= 1) ? 'bg-secondary border-secondary text-white' : 'bg-danger border-danger text-white' ?>" <?= ($PageNumber<= 1) ? 'disabled' : '' ?>>
                                السابق
                            </button>
                        </form>
                    </li>

                    <?php for ($p = 1; $p <= $TotalPages; $p++): ?>
                        <li class="page-item <?= ($p == $PageNumber) ? 'active' : '' ?>">
                            <form method="GET" action="<?=$ActionFilePath?>" class="d-inline m-0 p-0">
                                <input type="hidden" name="purchased_products_page_number" value="<?= $p ?>">
                                <button type="submit" class="page-link btn shadow-none <?= ($p == $PageNumber) ? 'bg-light text-danger fw-bold border-danger' : 'bg-danger text-white border-danger' ?>">
                                    <?= $p ?>
                                </button>
                            </form>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($PageNumber>= $TotalPages) ? 'disabled' : '' ?>">

                        <form method="GET" action="<?=$ActionFilePath?>" class="d-inline m-0 p-0">
                           <input type="hidden" name="purchased_products_page_number" value="<?= min($TotalPages, $PageNumber+ 1) ?>">

                            <button type="submit" class="page-link btn shadow-none <?= ($PageNumber>= $TotalPages) ? 'bg-secondary border-secondary text-white' : 'bg-danger border-danger text-white' ?>" <?= ($PageNumber>= $TotalPages) ? 'disabled' : '' ?>>
                                التالي
                            </button>
                        </form>
                    </li>

                </ul>
            </nav>
        <?php endif; ?>

    </main>

    <?php include_once __DIR__ . "/../../../../includes/footer.php"; ?>

    </body>
</html>
