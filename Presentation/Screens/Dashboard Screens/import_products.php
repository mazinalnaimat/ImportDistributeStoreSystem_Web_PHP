<?php
require_once __DIR__ . "/../../includes/auth.php";

require_once __DIR__ . "/../../includes/Presentation_Utils.php";



if (empty($_SESSION['PrePage']) || $_SESSION['PrePage'] != $_SERVER['PHP_SELF']) 
{
    unset($_SESSION['PageVars']);
    $_SESSION['PrePage'] = $_SERVER['PHP_SELF'];
}
$ActionFilePath = "/Project%20Files/Basic%20Version/Presentation/actions/import_products_action.php";

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>بضائع مستوردة - نظام إدارة الاستيراد والتوزيع</title>
        <link rel="icon" type="image/png" href="../../assests/imgs/ALOFOQ logo without text.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../../assests/css/share_style.css">
        <link rel="stylesheet" href="../../assests/css/import_products_screen_style.css">
    </head>

    <body>
        <?php include_once __DIR__ . "/../../includes/header.php"; ?>

        <main class="container">


            <!-- Title-->
            <div class="d-flex align-items-center justify-content-center mb-4">
                <i class="bi bi-box-seam display-4 ms-3 text-danger"></i>
                <h2 class="page-title mb-0 mx-2">بضائع مستوردة</h2>
            </div>




            <?php if(!isset($_SESSION['PageVars']['NewPurchasedProductId']) || $_SESSION['PageVars']['NewPurchasedProductId']== null || $_SESSION['PageVars']['NewPurchasedProductId']== 0):?>
                <!--Back Button  -->
                <div class="d-flex justify-content-between mb-4">
                    <form method="POST" action="<?=$ActionFilePath?>">
                        <button type="submit" name="go_back" class="btn btn-outline-light rounded-pill px-4 btn-sm">
                            <i class="bi bi-arrow-right me-2"></i> رجوع
                        </button>
                    </form>
                </div>
                <!-- Show Error in save new product alert -->
                <?php if(isset($_SESSION['PageVars']['NewPurchasedProductId']) &&($_SESSION['PageVars']['NewPurchasedProductId'] == null || $_SESSION['PageVars']['NewPurchasedProductId']== 0)):?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>حدث خطأ</strong>
                        لم يتم إضافة المنتج !!!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?unset($_SESSION['PageVars']['NewPurchasedProductId']);?>
                <?php endif;?>
                <!-- Add New Product -->
                <div class="container mt-4">
                    <div class="product-form card p-4 shadow-lg border-0">

                        <h4 class="text-center mb-4 text-danger fw-bold">
                            إضافة منتج جديد
                        </h4>

                        <?php
                        $ProductInfo = $_SESSION['PageVars']['AddNewProductInfo']??[];
                        ?>


                        <form method="POST" action="<?=$ActionFilePath?>" enctype="multipart/form-data">
                            <div class="row g-3">

                    
                                <div class="image-upload-wrapper">

                                    <?php if (isset($_SESSION['PageVars']['AddNewProductInfo']['AddProductImg'])): ?>
                                        <!-- Preview image (normal) -->
                                        <div class="preview-container">
                                            <img src="../../../uploads/temp/<?=$_SESSION['PageVars']['AddNewProductInfo']['AddProductImg']?>" 
                                                alt="Img" class="preview-img"> <!-- changed class -->
                                        </div>

                                        <input type="hidden" name="existing_temp_img" value="<?= $_SESSION['PageVars']['AddNewProductInfo']['AddProductImg'] ?>">

                                        <label for="ProductImgInput" class="btn btn-sm btn-outline-danger rounded-pill mt-2">
                                            <i class="bi bi-image-fill me-1"></i> تغيير الصورة
                                        </label>

                                    <?php else: ?>

                                        <!-- Default icon -->
                                        <div class="preview-container">
                                            <i class="bi bi-cloud-arrow-up text-secondary" style="font-size: 3rem;"></i>
                                        </div>

                                        <label for="ProductImgInput" class="custom-file-label">
                                            اضغط هنا لاختيار صورة
                                        </label>

                                    <?php endif; ?>

                                    <input type="file" id="ProductImgInput" name="product_image"
                                        class="hidden-file-input"
                                        accept=".jpg, .jpeg, .png, .webp"
                                        onchange="this.form.submit();" >
                                </div>

                                <?php if(isset($_SESSION['PageVars']['AddNewProductInfo']['ProductImgUploadError'])):?>
                                    
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?= $_SESSION['PageVars']['AddNewProductInfo']['ProductImgUploadError'] ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php unset($_SESSION['PageVars']['AddNewProductInfo']['ProductImgUploadError']);?>
                                <?php endif;?>

                                <div class="col-12 col-md-6">
                                    <label for="product_name" class="form-label text-light">اسم المنتج</label>
                                    <input type="text" id="product_name" name="product_name" class="form-control dark-input" value="<?=$ProductInfo['Name']?? ''?>" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="product_quantity" class="form-label text-light">الكمية</label>
                                    <input type="number" id="product_quantity"  name="product_quantity" class="form-control dark-input" 
                                    value="<?=$ProductInfo['Quantity']??''?>"
                                    required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="product_import_date_time" class="form-label text-light">تاريخ ووقت الاستيراد</label>
                                    <input type="datetime-local" id="product_import_date_time" name="product_import_date_time" class="form-control dark-input" value="<?=$ProductInfo['ImportArrivalDateTime']??''?>" required>
                                </div>


                                <div class="col-12 col-md-6">
                                    <label for="supplier_name" class="form-label text-light">اسم المزود</label>
                                    <input type="text" id="supplier_name"name="supplier_name" class="form-control dark-input" value="<?=$ProductInfo['SupplierName']??''?>" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="product_purchase_price" class="form-label text-light">سعر الشراء</label>
                                    <input type="number" id="product_purchase_price" name="product_purchase_price" step ="0.01" class="form-control dark-input" value="<?= $ProductInfo['PurchasePrice']??'' ?>"
                                    required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="product_base_selling_price" class="form-label text-light">سعر البيع الأساسي</label>
                                    <input type="number" id="product_base_selling_price" name="product_base_selling_price" step ="0.01" class="form-control dark-input" value="<?=$ProductInfo['BaseSellingPrice']??''?>" required>
                                </div>

                                <div class="col-12">
                                    <label for="product_details" class="form-label text-light">تفاصيل</label>
                                    <textarea id="product_details" class="form-control dark-input" name="product_details" rows="4" required><?=$ProductInfo['Details']?? ''?></textarea>
                                </div>



                                <div class="text-center mt-3">
                                    <button type="submit" name="add_product" class="btn btn-danger px-5 py-2 fw-bold">إضافة المنتج</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            <?php else: ?>
                <!-- Success Message Alert -->
                <div class="alert alert-success alert-dismissible fade show shadow-sm p-4 d-flex align-items-center justify-content-between"
                    role="alert"
                    style="border-radius: 15px; font-size: 1.1rem;">

                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 " style="font-size: 1.6rem;"></i>

                        <div class="me-3">
                            <strong class="d-block">تم إضافة المنتج بنجاح </strong>
                            <span class="text-dark">رقم المنتج: 
                                <span class="badge bg-dark text-white px-2">
                                    <?= $_SESSION['PageVars']['NewPurchasedProductId'] ?>
                                </span>
                            </span>
                        </div>
                    </div>

                </div>

                <!--  Buttons -->
                <div class="mt-3 text-center">

                    <form method="POST" action="<?= $ActionFilePath ?>" class="d-inline me-2">
                        <button type="submit" name="main_screen"
                                class="btn btn-outline-light btn-lg px-4 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-house-door-fill me-1"></i>
                            الشاشة الرئيسية
                        </button>
                    </form>

                    <form method="POST" action="<?= $ActionFilePath ?>" class="d-inline">
                        <button type="submit" name="add_new_product_again"
                                class="btn btn-outline-light btn-lg px-4 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-plus-circle me-1"></i>
                            إضافة منتج جديد
                        </button>
                    </form>
                </div>

            <?php endif; ?>

        </main>

        <?php include_once __DIR__ . "/../../includes/footer.php"; ?>



    </body>
</html>
