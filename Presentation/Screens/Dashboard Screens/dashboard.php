<?php
require_once __DIR__ . "/../../includes/auth.php";

require_once __DIR__ ."/../../includes/Presentation_Utils.php";




if (empty($_SESSION['PrePage']) || $_SESSION['PrePage'] != $_SERVER['PHP_SELF']) 
{
    unset($_SESSION['PageVars']);
    $_SESSION['PrePage'] = $_SERVER['PHP_SELF'];
}
unset($_SESSION['PageVars']);

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>الصفحة الرئيسية</title>
        <link rel="icon" type="image/png" href="../../assests/imgs/ALOFOQ logo without text.png">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <link rel="stylesheet" href="../../assests/css/dashboard_screen_style.css">
        <link rel="stylesheet" href="../../assests/css/share_style.css">
        
    </head>
    <body dir="rtl"> <!-- RTL for Arabic -->
        <?php include_once __DIR__ . "/../../includes/header.php";?>
        <main class="container">
            <h2 class="text-center text-danger mb-4">لوحة التحكم</h2>

            <div class="row g-4  d-flex justify-content-center">

                <!-- 1- Imported Goods -->
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="import_products.php" class="dashboard-card text-decoration-none">
                        <div class="card bg-dark text-light shadow-lg h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-box-seam display-4 mb-3 text-danger"></i>
                                <h5 class="card-title">بضائع مستوردة</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- 2- Exported Goods -->
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="export_products.php" class="dashboard-card text-decoration-none">
                        <div class="card bg-dark text-light shadow-lg h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-box-arrow-up-right display-4 mb-3 text-danger"></i>
                                <h5 class="card-title">بضائع مصدرة إلى الفروع</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- 3- Our Branches -->
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="branches.php" class="dashboard-card text-decoration-none">
                        <div class="card bg-dark text-light shadow-lg h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-building display-4 mb-3 text-danger"></i>
                                <h5 class="card-title">فروعنا</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- 4- Statistics -->
                <div class="col-12 col-md-6 col-lg-6">
                    <a href="statistics.php" class="dashboard-card text-decoration-none">
                        <div class="card bg-dark text-light shadow-lg h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-bar-chart-line display-4 mb-3 text-danger"></i>
                                <h5 class="card-title">احصائية</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- 5- Search -->
                <div class="col-12 col-md-6 col-lg-6">
                    <a href="search.php" class="dashboard-card text-decoration-none">
                        <div class="card bg-dark text-light shadow-lg h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-search display-4 mb-3 text-danger"></i>
                                <h5 class="card-title">البحث</h5>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

        </main>

        <?php include_once __DIR__ . "/../../includes/footer.php";?>
    </body>

</html>