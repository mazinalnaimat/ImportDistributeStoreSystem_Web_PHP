<?php
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../../Business/Business_Utils.php";

if (empty($_SESSION['PrePage']) || $_SESSION['PrePage'] != $_SERVER['PHP_SELF']) 
{
    unset($_SESSION['PageVars']);
    $_SESSION['PrePage'] = $_SERVER['PHP_SELF'];
    require_once __DIR__ . "/../../actions/branches_init_action.php";

}



$ActionFilePath = "../../actions/branches_action.php";



?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>فروعنا</title>
        <link rel="icon" type="image/png" href="../../assests/imgs/ALOFOQ logo without text.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../../assests/css/share_style.css">
        <link rel="stylesheet" href="../../assests/css/branches_screen_style.css">

    </head>
    <body>
    <?php include_once __DIR__ . "/../../includes/header.php"; ?>

    <main class="container">

        <!-- Title -->
        <div class="d-flex align-items-center justify-content-center mb-4">
            <i class="bi bi-building display-4 mb-3 text-danger"></i>
            <h2 class="page-title mb-0 mx-3">
                <?php 
                $Text = isset($_SESSION['DistributeProductPageVars']['ChooseBranch']) ? 
                "اختيار الفرع":
                "فروعنا"; 
                echo($Text);
                ?>

            </h2>
        </div>

        <!-- Show Add New Branch Status -->
        <?php if(isset($_SESSION['PageVars']['AddNewBranchStatus'])): ?>
            <?php if($_SESSION['PageVars']['AddNewBranchStatus'] == true): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ تم إضافة  الفرع بنجاح
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php else: ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ❌ فشل في إضافة  الفرع
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php unset($_SESSION['PageVars']['AddNewBranchStatus']); ?>
        <?php endif; ?>

        <!-- Show Edit Branch Status -->
        <?php if(isset($_SESSION['PageVars']['UpdatedBranchStatus'])): ?>
            <?php if($_SESSION['PageVars']['UpdatedBranchStatus'] == 1): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ تم التعديل على  الفرع بنجاح
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_SESSION['PageVars']['UpdatedBranchStatus'] == 0): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    ⚠️ لم يتم إجراء أي تغيير على بيانات الفرع
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php else: ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ❌ فشل في تعديل الفرع
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php unset($_SESSION['PageVars']['UpdatedBranchStatus']); ?>
        <?php endif; ?>

        <!-- Show Delete Branch Status -->
        <?php if(isset($_SESSION['PageVars']['DeleteBranchStatus'])): ?>
            <?php if($_SESSION['PageVars']['DeleteBranchStatus'] == 1): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ تم حذف الفرع بنجاح
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php else: ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ❌ فشل في حذف الفرع
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php unset($_SESSION['PageVars']['DeleteBranchStatus']); ?>
        <?php endif; ?>

        <!-- Back Button + Toggle View Mode + Add New Branch -->
        <div class="d-flex flex-wrap justify-content-between mb-4 gap-2 align-items-center">
            <!-- Back Button -->
            <form action="<?=$ActionFilePath?>" method="POST" class="d-inline">
                <button type="submit" name="back" class="btn btn-outline-light rounded-pill px-4 btn-sm">
                    <i class="bi bi-arrow-right me-2"></i> رجوع
                </button>
            </form>

        <?php if(!isset($_SESSION['DistributeProductPageVars']['ChooseBranch'])):?>
            <!-- Add New Branch Button -->
            <form action="<?=$ActionFilePath?>" method="POST" class="d-inline">
                <button type="submit" name="show_add_new_branch_modal" 
                    class="btn btn-gradient btn-danger rounded-pill px-5 py-2 fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-plus-lg"></i> إضافة فرع جديد
                </button>
            </form>
        <?php endif;?>

            <!-- Toggle View Button -->
            <?php $ViewMode = $_SESSION["PageVars"]['ViewMode'] ?? 'Cards';?>
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

        <!-- Add New Branch Modal -->
        <?php if(isset($_SESSION['PageVars']['AddNewBranchInfo']['ShowAddNewBranchModal'])): ?>

            <?php 
                $TempName  = $_SESSION['PageVars']['AddNewBranchInfo']['BranchName']  ?? '';
                $TempImage = $_SESSION['PageVars']['AddNewBranchInfo']['TempBranchImg']   ?? null;

                $ImgPath = $TempImage
                    ? "../../../uploads/temp/" . $TempImage
                    : "../../assests/imgs/no-image-available.png";
            ?>
                
            <div class="modal show" tabindex="-1" style="display:block; background:rgba(0,0,0,0.6);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-light border-danger">

                        <div class="modal-header border-danger">
                            <h5 class="modal-title text-danger fw-bold">
                                إضافة فرع جديد
                            </h5>
                        </div>

                        <div class="modal-body">
                            <form method="POST" action="<?= $ActionFilePath?>" enctype="multipart/form-data">

                                <input name="add_new_branch_input" value="1" hidden><!-- we use this input with add img in this modal  -->

                                <div class="mb-3">
                                    <label class="form-label text-white-50">صورة الفرع</label>
                                    <?php if (isset($_SESSION['PageVars']['AddNewBranchInfo']['BranchImgUploadError'])): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>حدث خطأ في رفع الصورة:</strong>
                                            <br>
                                            <?= $_SESSION['PageVars']['AddNewBranchInfo']['BranchImgUploadError'] ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <?php unset($_SESSION['PageVars']['AddNewBranchInfo']['BranchImgUploadError']);?>
                                    <?php endif; ?>

                                    <div class="image-upload-wrapper">
                                        <?php if (isset($_SESSION['PageVars']['AddNewBranchInfo']['TempBranchImg'])): ?>
                                            <div class="preview-container">
                                                <img src="<?=$ImgPath?>" 
                                                    alt="Img Of Branch" 
                                                    class="preview-circle">
                                            </div>
                                            
                                            <input type="hidden" name="existing_temp_img" value="<?= $_SESSION['PageVars']['AddNewBranchInfo']['TempBranchImg'] ?>">
                                            
                                            <label for="BranchImgInput" class="btn btn-sm btn-outline-danger rounded-pill">
                                                <i class="bi bi-image-fill me-1"></i> تغيير الصورة
                                            </label>
                                        <?php else: ?>
                                            <div class="preview-container">
                                                <i class="bi bi-cloud-arrow-up text-secondary" style="font-size: 3rem;"></i>
                                            </div>
                                            <label for="BranchImgInput" class="custom-file-label">
                                                اضغط هنا لاختيار صورة
                                            </label>
                                        <?php endif; ?>
                                        <input type="file" id="BranchImgInput" name="temp_branch_image" 
                                            class="hidden-file-input" accept=".jpg,.jpeg,.png,.webp"
                                            onchange="this.form.submit()"> 
                                            </div>
                                </div>

                                <!-- Branch Name -->
                                <label class="form-label">اسم الفرع</label>
                                <input type="text" class="form-control bg-dark text-light border-secondary"
                                    name="new_branch_name"
                                    value="<?= htmlspecialchars($TempName) ?>"
                                    required>

                                <!-- Footer -->
                                <div class="modal-footer border-danger">
                                    <button type="submit" name="close_add_new_branch_modal" 
                                            class="btn btn-outline-danger" formnovalidate>
                                        إلغاء
                                    </button>
                                    <button type="submit" name="add_new_branch" 
                                            class="btn btn-danger">
                                        حفظ الفرع
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


        <?php endif; ?>



        <!-- Controls Row -->
        <div class="container-fluid mb-4">
            <div class="d-flex flex-wrap justify-content-between justify-content-md-start align-items-center gap-3">

                <!-- Search Card -->
                <div class="flex-grow-1" style="min-width: 250px;">
                    <div class="card bg-dark border-secondary text-light shadow-sm p-3" style="border-radius: 14px;">
                        <form method="POST" action="<?= $ActionFilePath ?>" class="d-flex align-items-center gap-3">

                            <div class="flex-grow-1">
                                <label class="form-label small text-light">اسم الفرع</label>
                                <input type="text" name="search_text"
                                    value="<?= htmlspecialchars($_SESSION['PageVars']['SearchText'] ?? '') ?>"
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
                <div class="d-flex flex-wrap gap-3 align-items-center justify-content-end justify-content-md-start" style="min-width: 250px;">
                    <?php $NumberOfItemsPerPage = $_SESSION['PageVars']['NumberOfItemsPerPage'] ?? 8;
                        $PageNumber = $_SESSION['PageVars']['BranchesPageNumber'] ?? 1;
                        $TotalResults = $_SESSION['PageVars']['TotalSearchResultNumber'] ?? 0;
                        $TotalPages = max(1, (int)ceil((float)$TotalResults / $NumberOfItemsPerPage));
                        $Offset = ($PageNumber - 1) * $NumberOfItemsPerPage;
                    ?>

                    <!-- Items per page -->
                    <div>
                        <form method="POST" action="<?= $ActionFilePath ?>">
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
                        <form method="POST" action="<?= $ActionFilePath ?>">
                            <label class="form-label small text-light">الترتيب</label>
                            <select name="order_dir" class="form-select bg-dark text-light border-secondary"
                                    onchange="this.form.submit()">
                                <?php $OrderDir = $_SESSION['PageVars']['OrderDir'] ?? 'ASC'; ?>
                                <option value="ASC"  <?= $OrderDir=='ASC'?'selected':'' ?>>تصاعدي</option>
                                <option value="DESC" <?= $OrderDir=='DESC'?'selected':'' ?>>تنازلي</option>
                            </select>
                        </form>
                    </div>



                </div>
            </div>
        </div>


        <?php $Branches = $_SESSION['PageVars']['Branches'] ?? [];?>

        <!-- Edit Branch Modal -->
        <?php if(isset($_SESSION['PageVars']['EditBranchInfo'])): ?>
            <?php 

                $Branch = $_SESSION['PageVars']['EditBranchInfo'];
                $BranchId = $Branch['BranchId'];
                $BranchName = ($Branch['BranchName'] ?? '-');
                $TempBranchImg = $_SESSION['PageVars']['EditBranchInfo']['TempBranchImg']?? null;
                $ImgPath = (!empty($TempBranchImg))? "../../../uploads/temp/" . $TempBranchImg :
                            ( 
                                (!empty($Branch['BranchImgName'])) ? "../../../uploads/branches/" . $Branch['BranchImgName']
                                : "../../assests/imgs/no-image-available.png"
                            );
            ?>
            <div class="modal show" tabindex="-1" style="display:block; background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-light border-danger">
                        <div class="modal-header">
                            <h5 class="modal-title">تعديل الفرع: <strong><?=$Branch['BranchName']?></strong></h5>
                        </div>

                        <div class="modal-body">



                            <!-- IMAGE PREVIEW -->
                            <div class="mb-3 text-center">
                                <img src="<?= $ImgPath ?>" class="w-100 mb-3" style="height:400px; object-fit:cover;">
                            </div>

                            <?php if (isset($_SESSION['PageVars']['EditBranchInfo']['BranchImgUploadError'])): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>حدث خطأ في رفع الصورة:</strong>
                                        <br>
                                        <?= $_SESSION['PageVars']['EditBranchInfo']['BranchImgUploadError'] ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php unset($_SESSION['PageVars']['EditBranchInfo']['BranchImgUploadError']);?>
                            <?php endif; ?>

                            <form method="POST" action="<?=$ActionFilePath?>" enctype="multipart/form-data" class="mb-3">
                                
                                <input name="edit_branch_input" value="1" hidden><!-- we use this input with change the img in this modal -->
                                <div class="d-flex justify-content-center">
                                    <input type="hidden" name="branch_id" value="<?= (int) ($_SESSION['PageVars']['SelectedBranch']['BranchId'] ?? 0) ?>">

                                    <label class="btn btn-outline-danger">
                                        تغيير الصورة
                                        <input type="file" name="temp_branch_image" accept=".jpg,.jpeg,.png,.webp" hidden onchange="this.form.submit()">
                                    </label>
                                </div>


                                <div class="mt-3 mb-3">
                                    <label class="form-label">اسم الفرع</label>
                                    <input type="text" name="updated_branch_name" class="form-control" 
                                        value="<?= $BranchName ?>"
                                        required
                                    >
                                </div>


                                <!-- hidden to ensure action knows which branch we edit -->
                                <input type="hidden" name="branch_id" value="<?=$BranchId?>">

                                <div class="modal-footer border-danger">
                                    <button type="submit" name="close_edit_branch_modal" class="btn btn-danger" formnovalidate>إلغاء</button>
                                    <button type="submit" name="save_edit_branch" class="btn btn-danger">حفظ التعديل</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

       <!-- Delete Branch Modal  -->
        <?php if(isset($_SESSION['PageVars']['DeleteBranch'])): ?>
            <div class="modal show" tabindex="-1" style="display:block; background-color: rgba(0,0,0,0.6);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-light border border-2 border-danger rounded-3 shadow-lg">

                        <!-- HEADER -->
                        <div class="modal-header border-danger">
                            <h5 class="modal-title text-danger fw-bold">
                                ⚠️ تأكيد حذف الفرع
                            </h5>
                        </div>

                        <!-- BODY -->
                        <div class="modal-body text-center">

                            <div class="py-3">
                                <div class="fs-5 mb-3">
                                    هل أنت متأكد أنك تريد حذف الفرع:
                                </div>

                                <div class="fs-4 fw-bold text-danger">
                                    <?= $_SESSION['PageVars']['DeleteBranch']['BranchName'] ?>
                                </div>
                            </div>

                            <div class="alert alert-danger text-center fw-bold">
                                ⚠️ هذا الإجراء لا يمكن التراجع عنه!
                            </div>

                        </div>

                        <!-- FOOTER -->
                        <div class="modal-footer justify-content-between border-danger">

                            <form method="POST" action="<?= $ActionFilePath ?>" class="m-0">
                                <button type="submit" name="close_delete_branch_modal" 
                                        class="btn btn-outline-danger px-4">
                                    إلغاء
                                </button>
                            </form>

                            <form method="POST" action="<?= $ActionFilePath ?>" class="m-0">
                                <input type="hidden" name="branch_id" 
                                    value="<?= $_SESSION['PageVars']['DeleteBranch']['BranchId'] ?>">
                                <button type="submit" name="delete_branch" 
                                        class="btn btn-danger px-4">
                                    حذف الفرع
                                </button>
                            </form>

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
                        $ImgPath = (!empty($Branch['BranchImgName'])) ? "../../../uploads/branches/" . $Branch['BranchImgName'] : "../../assests/imgs/no-image-available.png";

                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card text-center h-100 shadow-lg hover-scale rounded-4 border-0" style="background: linear-gradient(145deg, #1c1c1c, #2a2a2a);">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <div class="branches-img-container w-100">
                                        <img src="<?= $ImgPath ?>"  alt="<?= $BranchName; ?>"    class="img-fluid mb-3 rounded-3 shadow-sm branches-card-img">
                                    </div>
                                    <h5 class="card-title text-danger fw-bold mb-2"><?= $BranchName; ?></h5>

                                    <div class="d-flex gap-2 w-100 mt-auto">

                                        <?php if(!isset($_SESSION['DistributeProductPageVars']['ChooseBranch'])):?>
                                            <form method="POST" action="<?=$ActionFilePath?>" class="flex-fill">
                                                <input type="hidden" name="branch_id" value="<?=$BranchId?>">
                                                <button type="submit" name="show_edit_branch_modal" class="btn btn-outline-warning w-100 fw-bold">
                                                    تعديل
                                                </button>
                                            </form>

                                            <form method="POST" action="<?=$ActionFilePath?>" class="flex-fill">
                                                <input type="hidden" name="branch_id" value="<?=$BranchId?>">
                                                <button type="submit" name="show_delete_branch_modal" class="btn btn-outline-danger w-100 fw-bold">
                                                    حذف
                                                </button>
                                            </form>
                                        <?php else:?>
                                            <form method="POST" action="<?=$ActionFilePath?>" class="flex-fill">
                                                <input type="hidden" name="branch_id" value="<?=$BranchId?>">
                                                <button type="submit" name="choose_branch" class="btn btn-outline-danger w-100 fw-bold">
                                                    اختيار
                                                </button>
                                            </form>
                                        <?php endif;?>

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
                                $ImgPath = $ImgName && file_exists(__DIR__ . "/../../../uploads/branches/" . $ImgName)
                                            ? "../../../uploads/branches/" . $ImgName
                                            : "../../assests/imgs/no-image-available.png";
                            ?>
                                <tr>
                                    <td><?= $RowIndex; ?></td>
                                    <td class="text-center">
                                        <div class="branches-img-container d-inline-block">
                                            <img src="<?= $ImgPath ?>" alt="<?= $BranchName ?>" class="table-branch-img shadow-sm">
                                        </div>
                                    </td>

                                    <td><?= $BranchName; ?></td>


                                    <?php if(!isset($_SESSION['DistributeProductPageVars']['ChooseBranch'])):?>
                                        <td>
                                            <form method="POST" action="<?=$ActionFilePath?>">
                                                <input name="branch_id" value="<?=$BranchId?>" hidden>
                                                <button type="submit" name="show_edit_branch_modal" class="btn btn-outline-warning w-100 fw-bold">
                                                    تعديل
                                                </button>
                                            </form>
                                        </td>

                                        <td>
                                            <form method="POST" action="<?=$ActionFilePath?>">
                                                <input name="branch_id" value="<?=$BranchId?>" hidden>
                                                <button type="submit" name="show_delete_branch_modal" class="btn btn-outline-danger w-100 fw-bold">
                                                    حذف
                                                </button>
                                            </form>
                                        </td>
                                    <?php else:?>
                                        <td>
                                            <form method="POST" action="<?=$ActionFilePath?>">
                                                <input name="branch_id" value="<?=$BranchId?>" hidden>
                                                <button type="submit" name="choose_branch" class="btn btn-outline-danger w-100 fw-bold">
                                                    اختيار
                                                </button>
                                            </form>
                                        </td>
                                    <?php endif;?>

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
                        <form method="POST" action="<?=$ActionFilePath?>" class="d-inline m-0 p-0">
                            <input type="hidden" name="branches_page_number" value="<?= max(1, $PageNumber- 1) ?>">
                            <button type="submit" class="page-link btn shadow-none <?= ($PageNumber<= 1) ? 'bg-secondary border-secondary text-white' : 'bg-danger border-danger text-white' ?>" <?= ($PageNumber<= 1) ? 'disabled' : '' ?>>
                                السابق
                            </button>
                        </form>
                    </li>

                    <?php for ($p = 1; $p <= $TotalPages; $p++): ?>
                        <li class="page-item <?= ($p == $PageNumber) ? 'active' : '' ?>">
                            <form method="POST" action="<?=$ActionFilePath?>" class="d-inline m-0 p-0">
                                <input type="hidden" name="branches_page_number" value="<?= $p ?>">
                                <button type="submit" class="page-link btn shadow-none <?= ($p == $PageNumber) ? 'bg-light text-danger fw-bold border-danger' : 'bg-danger text-white border-danger' ?>">
                                    <?= $p ?>
                                </button>
                            </form>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($PageNumber>= $TotalPages) ? 'disabled' : '' ?>">
                        <form method="POST" action="<?=$ActionFilePath?>" class="d-inline m-0 p-0">
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

    <?php include_once __DIR__ . "/../../includes/footer.php"; ?>

    </body>
</html>
