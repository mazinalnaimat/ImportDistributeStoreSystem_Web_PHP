
<?php
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../../Business/Business_Utils.php";




if (empty($_SESSION['PrePage']) || $_SESSION['PrePage'] != $_SERVER['PHP_SELF']) 
{
    unset($_SESSION['PageVars']);
    $_SESSION['PrePage'] = $_SERVER['PHP_SELF'];
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>بضائع مصدرة</title>
        <link rel="icon" type="image/png" href="../../assests/imgs/ALOFOQ logo without text.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../../assests/css/share_style.css">
        <link rel="stylesheet" href="../../assests/css/export_products_screen_style.css">
    </head>
    <body>
        <?php include_once __DIR__ . "/../../includes/header.php"; ?>

        <main class="container ">

            <!-- Title -->
            <div class="d-flex align-items-center justify-content-center mb-4">
                <i class="bi bi-box-arrow-up-right display-4 mb-3 text-danger"></i>
                <h2 class="page-title mb-0 mx-3">بضائع مصدرة</h2>
            </div>

            <!-- Back Button  -->
            <div class="d-flex justify-content-between mb-4">
                <a href="dashboard.php" class="btn btn-outline-light rounded-pill px-4 btn-sm">
                    <i class="bi bi-arrow-right me-2"></i> رجوع
                </a>
            </div>

            <div class="row justify-content-center g-4">

                <!-- Card 1: Products -->
                <div class="col-md-4">
                    <a href="Export Products Screens/Show Products/products.php" class="text-decoration-none">
                        <div class="card text-center h-100 shadow-sm hover-scale">
                            <div class="card-body">
                                <i class="bi bi-box-seam text-danger display-4 mb-3"></i>
                                <h5 class="card-title text-danger">المنتجات في المخزون</h5>
                                <p class="card-text text-light">عرض كل المنتجات المتاحة في المخزون وإدارتها.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Distribution place -->
                <div class="col-md-4">
                    <a href="Export Products Screens/Export Products/distribute_product.php" class="text-decoration-none">
                        <div class="card text-center h-100 shadow-sm hover-scale">
                            <div class="card-body">
                                <i class="bi bi-truck text-danger display-4 mb-3"></i>
                                <h5 class="card-title text-danger">تصدير منتج</h5>
                                <p class="card-text text-light">اختيار مكان التوزيع والمتنج للتصدير.</p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

        </main>

        <?php include_once __DIR__ . "/../../includes/footer.php"; ?>

    </body>
</html>