<?php
require_once __DIR__ . "/../../includes/auth.php";





if (empty($_SESSION['PrePage']) || $_SESSION['PrePage'] != $_SERVER['PHP_SELF']) 
{
    unset($_SESSION['PageVars']);
    $_SESSION['PrePage'] = $_SERVER['PHP_SELF'];
    require_once __DIR__ . "/../../actions/statistics_init_action.php";

}


$ActionFileName = "../../actions/statistics_action.php";

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إحصائية</title>
    <link rel="icon" type="image/png" href="../../assests/imgs/ALOFOQ logo without text.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assests/css/share_style.css">
    <link rel="stylesheet" href="../../assests/css/statistics_screen_style.css">
</head>

<body>
    <?php include_once __DIR__ . "/../../includes/header.php"; ?>

    <main class="container ">
        <!-- Main title of the page -->
        <div class="d-flex align-items-center justify-content-center mb-4">
            <i class="bi bi-bar-chart-line display-4 mb-3 text-danger"></i>
            <h2 class="page-title mb-0 mx-3">احصائية</h2>
        </div>

        <!-- Button to back to previous page -->
        <div class="d-flex justify-content-between mb-4">
            <form method="GET" action=<?=$ActionFileName?>>
                <button type="submit" name="go_back" class="btn btn-outline-light rounded-pill px-4 btn-sm">
                    <i class="bi bi-arrow-right me-2"></i> رجوع
                </button>
            </form>
        </div>

        <?php if (empty($_SESSION['PageVars']['BranchesFinancialSummery'])): ?>

            <div class="text-center text-light my-5 fs-4">
                لا توجد احصائيات لعرضها
            </div>

        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($_SESSION['PageVars']['BranchesFinancialSummery'] ?? [] as $BranchFinancialSummery): 
                    $ImgName = !empty($BranchFinancialSummery['BranchImgName']) 
                                ? $BranchFinancialSummery['BranchImgName'] 
                                : 'default.png';
                    $ImgPath = "../../../uploads/branches/" . $ImgName;
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                    <div class="card hover-card bg-dark text-light border-danger h-100 shadow">
                        
                        <div class="ratio ratio-4x3"> 
                            <img src="<?= $ImgPath ?>" 
                                class="card-img-top p-1" 
                                alt="Branch Image" 
                                style="object-fit: cover; border-radius: 12px;">
                        </div>
                        
                        <div class="card-body p-3 d-flex flex-column">
                            <h6 class="text-center fw-bold text-uppercase mb-3" style="letter-spacing: 1px;">
                                <?= htmlspecialchars($BranchFinancialSummery['BranchName']) ?>
                            </h6>

                            <div class="p-2 rounded bg-secondary bg-opacity-10 border border-secondary border-opacity-25">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small text-secondary">إجمالي الشراء</span>
                                    <span class="fw-bold fs-4 text-light">
                                        <?= number_format($BranchFinancialSummery['TotalPurchasedAmount'], 0) ?>
                                    </span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small text-secondary">إجمالي البيع</span>
                                    <span class="fw-bold fs-4 text-light">
                                        <?= number_format($BranchFinancialSummery['TotalDistributedAmount'], 0) ?>
                                    </span>
                                </div>

                                <hr class="my-2 border-secondary">

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small fw-bold">الربح الصافي</span>
                                    <span class="fw-bolder fs-3 text-success">
                                        <?= number_format($BranchFinancialSummery['TotalDistributedAmount'] - $BranchFinancialSummery['TotalPurchasedAmount'] , 0) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif;?>

    </main>

    <?php include_once __DIR__ . "/../../includes/footer.php"; ?>

</body>

</html>