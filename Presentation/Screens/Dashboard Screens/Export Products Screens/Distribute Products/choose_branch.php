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
    require_once __DIR__ . "/../../../../actions/Distribute Products Actions/choose_branch_init_action.php";
}


$ActionFilePath = "../../../../actions/Distribute Products Actions/choose_branch_action.php";



?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>فروعنا</title>
        <link rel="icon" type="image/png" href="../../../../assests/imgs/ALOFOQ logo without text.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../../../../assests/css/share_style.css">
        <link rel="stylesheet" href="../../../../assests/css/branches_screen_style.css">

    </head>
    <body>
    <?php include_once __DIR__ . "/../../../../includes/header.php"; ?>

    <main class="container">

        <!-- Title -->
        <div class="d-flex align-items-center justify-content-center mb-4">
            <i class="bi bi-building display-4 mb-3 text-danger"></i>
            <h2 class="page-title mb-0 mx-3">
                اختيار الفرع

            </h2>
        </div>



        <!-- Back Button + Toggle View Mode -->
        <div class="d-flex flex-wrap justify-content-between mb-4 gap-2 align-items-center responsive-action-bar">
            <!-- Back Button -->
            <form action="<?=$ActionFilePath?>" method="GET" class="d-inline">
                <button type="submit" name="back" class="btn app-back-button">
                    <i class="bi bi-arrow-right me-2"></i> رجوع
                </button>
            </form>


            <!-- Toggle View Button -->
            <?php $ViewMode = $_SESSION["BranchesPageVars"]['ViewMode'] ?? 'Cards';?>
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
                                <label class="form-label small text-light">اسم الفرع</label>
                                <input type="text" name="search_text"
                                    value="<?= htmlspecialchars($_SESSION['BranchesPageVars']['SearchText'] ?? '') ?>"
                                    class="form-control bg-dark text-light border-secondary"
                                    placeholder="ابحث...">
                            </div>

                            <div>
                                <button name="search_branch_name" class="btn btn-danger px-4 mt-4 fw-bold">
                                    <i class="bi bi-search"></i> بحث
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Right Side Filters -->
                <div class="d-flex flex-wrap gap-3 align-items-center justify-content-end justify-content-md-start responsive-filter-group">
                    <?php $NumberOfItemsPerPage = $_SESSION['BranchesPageVars']['NumberOfItemsPerPage'] ?? 8;
                        $PageNumber = $_SESSION['BranchesPageVars']['BranchesPageNumber'] ?? 1;
                        $TotalResults = $_SESSION['BranchesPageVars']['TotalSearchResultNumber'] ?? 0;
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

                    <!-- Order Direction -->
                    <div>
                        <form method="GET" action="<?= $ActionFilePath ?>">
                            <label class="form-label small text-light">الترتيب</label>
                            <select name="order_dir" class="form-select bg-dark text-light border-secondary"
                                    onchange="this.form.submit()">
                                <?php $OrderDir = $_SESSION['BranchesPageVars']['OrderDir'] ?? 'ASC'; ?>
                                <option value="ASC"  <?= $OrderDir=='ASC'?'selected':'' ?>>تصاعدي</option>
                                <option value="DESC" <?= $OrderDir=='DESC'?'selected':'' ?>>تنازلي</option>
                            </select>
                        </form>
                    </div>



                </div>
            </div>
        </div>


        <?php $Branches = $_SESSION['BranchesPageVars']['Branches'] ?? [];?>

        <!-- Branch Details Modal -->
        <?php if(isset($_SESSION['BranchesPageVars']['BranchDetails'])): ?>
            <?php 

                $Branch = $_SESSION['BranchesPageVars']['BranchDetails'];
                $BranchId = $Branch['BranchId'];
                $BranchImg = $Branch['BranchImgName']?? null;
                $ImgPath = (!empty($Branch['BranchImgName'])) ? "../../../../../uploads/branches/" . $Branch['BranchImgName']
                                : "../../../../assests/imgs/no-image-available.png"
                            ;
            ?>
            <div class="modal show" tabindex="-1" style="display:block; background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content bg-dark text-light border-danger">
                        <div class="modal-header">
                            <h5 class="modal-title">تفاصيل الفرع: <strong><?=$Branch['BranchName']?></strong></h5>
                        </div>

                            <div class="modal-body">

                                <!-- IMAGE PREVIEW -->
                                <div class="mb-4 text-center">
                                    <img src="<?= $ImgPath ?>" class="img-fluid rounded border border-danger modal-feature-image">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">اسم الفرع</label>
                                    <div class="form-control branch-detail">
                                        <?= $Branch['BranchName'] ?? '-' ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">رقم الهاتف</label>
                                    <div class="form-control branch-detail">
                                        <?= $Branch['Phone'] ?? '-' ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">البريد الإلكتروني</label>
                                    <div class="form-control branch-detail">
                                        <?= $Branch['Email'] ?? '-' ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">العنوان</label>
                                    <div class="form-control branch-detail address-detail">
                                        <?= $Branch['Address'] ?? '-' ?>
                                    </div>
                                </div>


                                <input type="hidden" name="branch_id" value="<?= $BranchId ?>">

                                <div class="modal-footer border-danger">
                                <form method="GET" action="<?= $ActionFilePath ?>">
                                    <button type="submit"
                                            name="close_branch_details_modal"
                                            class="btn btn-danger"
                                            formnovalidate>
                                        إغلاق
                                    </button>
                                </form>
                            </div>
                            </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($ViewMode === 'Cards'): ?>
            <!-- Cards View -->
            <?php if (!empty($Branches)): ?>
                <div class="row justify-content-center g-4 mb-5">
                    <?php foreach ($Branches as $Branch): 
                        $BranchId = ($Branch['BranchId'] ?? '');
                        $BranchName = ($Branch['BranchName'] ?? '-');
                        $ImgPath = (!empty($Branch['BranchImgName'])) ? "../../../../../uploads/branches/" . $Branch['BranchImgName'] : "../../../../assests/imgs/no-image-available.png";

                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card text-center h-100 shadow-lg hover-scale rounded-4 border-0" style="background: linear-gradient(145deg, #1c1c1c, #2a2a2a);">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <div class="branches-img-container w-100">
                                        <img src="<?= $ImgPath ?>"  alt="<?= $BranchName; ?>"    class="img-fluid mb-3 rounded-3 shadow-sm branches-card-img">
                                    </div>
                                    <h5 class="card-title text-danger fw-bold mb-2"><?= $BranchName; ?></h5>

                                    <div class="d-flex gap-2 w-100 mt-auto">

                                        <form method="GET" action="<?=$ActionFilePath?>" class="flex-fill">
                                            <input type="hidden" name="branch_id" value="<?=$BranchId?>">
                                            <button type="submit" name="show_branch_details_modal" class="btn btn-outline-info w-100 fw-bold">
                                                تفاصيل
                                            </button>
                                        </form>

                                    </div>
                                    <div class="d-flex gap-2 w-100 mt-auto">

                                        <form method="GET" action="<?=$ActionFilePath?>" class="flex-fill">
                                            <input type="hidden" name="branch_id" value="<?=$BranchId?>">
                                            <button type="submit" name="choose_branch" class="btn btn-outline-danger w-100 fw-bold">
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
                    لا يوجد فروع لعرضها
                </div>
            <?php endif; ?>

        <?php else: ?>
            <!-- Table View -->
            <?php if (!empty($Branches)): ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover text-center align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>صورة</th>
                                <th>اسم الفرع</th>
                                <th colspan="2">الخيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Branches as $Index => $Branch): 
                                $RowIndex = $Offset + $Index + 1;
                                $BranchId = ($Branch['BranchId'] ?? '');
                                $BranchName = ($Branch['BranchName'] ?? '-');
                                $ImgName = $Branch['BranchImgName'] ?? '';
                                $ImgPath = $ImgName && file_exists(__DIR__ . "/../../../../../uploads/branches/" . $ImgName)
                                            ? "../../../../../uploads/branches/" . $ImgName
                                            : "../../../../assests/imgs/no-image-available.png";
                            ?>
                                <tr>
                                    <td><?= $RowIndex; ?></td>
                                    <td class="text-center">
                                        <div class="branches-img-container d-inline-block">
                                            <img src="<?= $ImgPath ?>" alt="<?= $BranchName ?>" class="table-branch-img shadow-sm">
                                        </div>
                                    </td>

                                    <td><?= $BranchName; ?></td>


                                    <td>
                                        <form method="GET" action="<?=$ActionFilePath?>">
                                            <input name="branch_id" value="<?=$BranchId?>" hidden>
                                            <button type="submit" name="show_branch_details_modal" class="btn btn-outline-info w-100 fw-bold">
                                                تفاصيل
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="GET" action="<?=$ActionFilePath?>">
                                            <input name="branch_id" value="<?=$BranchId?>" hidden>
                                            <button type="submit" name="choose_branch" class="btn btn-outline-danger w-100 fw-bold">
                                                اختيار
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
                    لا توجد فروع لعرضها
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if ($TotalPages > 1): ?>
            <nav class="mt-3">
                <ul class="pagination justify-content-center gap-1">
                    
                    <li class="page-item <?= ($PageNumber<= 1) ? 'disabled' : '' ?>">
                        <form method="GET" action="<?=$ActionFilePath?>" class="d-inline m-0 p-0">
                            <input type="hidden" name="branches_page_number" value="<?= max(1, $PageNumber- 1) ?>">
                            <button type="submit" class="page-link btn shadow-none <?= ($PageNumber<= 1) ? 'bg-secondary border-secondary text-white' : 'bg-danger border-danger text-white' ?>" <?= ($PageNumber<= 1) ? 'disabled' : '' ?>>
                                السابق
                            </button>
                        </form>
                    </li>

                    <?php for ($p = 1; $p <= $TotalPages; $p++): ?>
                        <li class="page-item <?= ($p == $PageNumber) ? 'active' : '' ?>">
                            <form method="GET" action="<?=$ActionFilePath?>" class="d-inline m-0 p-0">
                                <input type="hidden" name="branches_page_number" value="<?= $p ?>">
                                <button type="submit" class="page-link btn shadow-none <?= ($p == $PageNumber) ? 'bg-light text-danger fw-bold border-danger' : 'bg-danger text-white border-danger' ?>">
                                    <?= $p ?>
                                </button>
                            </form>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($PageNumber>= $TotalPages) ? 'disabled' : '' ?>">
                        <form method="GET" action="<?=$ActionFilePath?>" class="d-inline m-0 p-0">
                            <input type="hidden" name="branches_page_number" value="<?= min($TotalPages, $PageNumber+ 1) ?>">
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
