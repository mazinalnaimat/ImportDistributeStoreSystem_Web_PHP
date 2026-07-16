<?php
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../includes/Presentation_Utils.php";


if (empty($_SESSION['PrePage']) || $_SESSION['PrePage'] != $_SERVER['PHP_SELF']) 
{
    unset($_SESSION['PageVars']);
    $_SESSION['PrePage'] = $_SERVER['PHP_SELF'];
}

$UserImgName = $_SESSION['PageVars']['TmpUserImg']
    ?? $_SESSION['CurrentUser']['PersonalImgName']
    ?? '';

$UserImgPath = isset($_SESSION['PageVars']['TmpUserImg'])
    ? "/Project%20Files/Basic%20Version/uploads/temp/$UserImgName"
    :( $UserImgName != ''
    ? "/Project%20Files/Basic%20Version/uploads/users/$UserImgName"
    : "/Project%20Files/Basic%20Version/uploads/users/default.png");

$ActionPathFile = "/Project%20Files/Basic%20Version/Presentation/actions/edit_user_info_action.php";



?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المعلومات الشخصية</title>
    <link rel="icon" type="image/png" href="../../assests/imgs/ALOFOQ logo without text.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assests/css/share_style.css">
    <link rel="stylesheet" href="../../assests/css/user_info_screen_style.css">
    <link rel="stylesheet" href="../../assests/css/edit_user_info_screen_style.css">
    

</head>

<body>
    <?php include_once __DIR__ . "/../../includes/header.php"; ?>

    <main class="container py-5">
        
        <div class="row align-items-center mb-5">
            <div class="col-4 d-flex justify-content-start">
                <?php if (!empty($_SESSION['page_stack']) && count($_SESSION['page_stack']) > 1): ?>
                    <form method="POST" action="<?= $ActionPathFile ?>">
                        <button type="submit" name="go_back" class="btn btn-outline-light rounded-pill px-4 btn-sm">
                            <i class="bi bi-arrow-right-short"></i> رجوع
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <div class="col-4 text-center">
                <div class="d-inline-block position-relative mb-2">
                    <i class="bi bi-person-gear display-5 text-danger"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.4em;">EDIT</span>
                </div>
                <h2 class="fw-bold text-white mb-0">تعديل الملف الشخصي</h2>
                <div class="mt-2 mx-auto" style="width: 40px; height: 4px; background: #ff4d4d; border-radius: 10px;"></div>
            </div>
            
            <div class="col-4"></div>
        </div>

        <!-- Show Save User Info Status Alert-->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10 col-xl-8">
                <?php if (isset($_SESSION['PageVars']['UpdatedInfoStatus'])): ?>

                    <?php 
                        $status = $_SESSION['PageVars']['UpdatedInfoStatus'];

                        // Define message and icon based on status
                        if ($status == 1) 
                        {
                            $alertClass = "success";
                            $icon = "check-circle";
                            $message = "تم تحديث البيانات بنجاح!";
                        } 
                        else if ($status == 0) 
                        {
                            $alertClass = "warning";
                            $icon = "dash-circle";
                            $message = "لم يتم إجراء أي تغييرات على البيانات.";
                        } 
                        else 
                        { // status == 0 (error)
                            $alertClass = "danger";
                            $icon = "x-circle";
                            $message = "حدث خطأ أثناء تحديث البيانات.";
                        }
                    ?>

                    <div class="alert alert-<?= $alertClass ?> d-flex align-items-center border-0 shadow-sm rounded-4 py-3">
                        <i class="bi bi-<?= $icon ?> fs-4 me-3"></i>
                        <div class="mx-3"><?= $message ?></div>
                    </div>

                    <?php unset($_SESSION['PageVars']['UpdatedInfoStatus']); ?>
                <?php endif; ?>
            </div>
        </div>


        <!-- Show Upload Img Status Alert-->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10 col-xl-8">
                <?php if (isset($_SESSION['PageVars']['UserImgUploadError'])): ?>
                    <div class="alert alert-warning d-flex align-items-center border-0 shadow-sm rounded-4 py-3">
                        <i class="bi bi-exclamation-triangle fs-4 me-3"></i>
                        <div class="mx-5">
                            <strong>حدث خطأ في تحميل الصورة</strong>
                            <br>
                            <span><?=$_SESSION['PageVars']['UserImgUploadError']?></span>
                        </div>
                    </div>
                    <?php unset($_SESSION['PageVars']['UserImgUploadError']); ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="profile-card shadow-lg overflow-hidden">
            <div class="row g-0">
                
                <div class="col-lg-4 sidebar-section d-flex flex-column align-items-center justify-content-center border-start border-secondary border-opacity-25">
                    <form method="POST" enctype="multipart/form-data" action="<?= $ActionPathFile ?>" id="imgForm">
                        <div class="position-relative">
                            <div class="rounded-circle p-1 border border-danger border-2 shadow-lg">
                                <img src="<?= $UserImgPath ?>" class="rounded-circle object-fit-cover" width="160" height="160" alt="Avatar">
                            </div>
                            <label for="imgUpload" class="btn btn-danger rounded-circle position-absolute bottom-0 start-0 p-2 shadow border border-3 border-dark" title="تغيير الصورة">
                                <i class="bi bi-camera-fill"></i>
                                <input type="file" name="temp_image" id="imgUpload" hidden accept=".jpg,.jpeg,.png,.webp" onchange="this.form.submit()">
                            </label>
                        </div>
                        <div class="text-center mt-4">
                            <h5 class="text-white mb-1"><?= $_SESSION['CurrentUser']['FirstName'] ?></h5>
                            <p class="text-secondary small mb-0">تغيير صورة الحساب</p>
                        </div>
                    </form>
                </div>

                <div class="col-lg-8 p-4 p-md-5">
                    <form method="POST" action="<?= $ActionPathFile ?>">
                        <div class="row g-4">
                            <div class="col-12">
                                <span class="input-label">اسم المستخدم</span>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-0 text-danger rounded-end-4"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control custom-input rounded-start-4" name="username" value="<?= $_SESSION['CurrentUser']['UserName'] ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <span class="input-label">الاسم الأول</span>
                                <input type="text" class="form-control custom-input" name="firstname" value="<?= $_SESSION['CurrentUser']['FirstName'] ?>">
                            </div>
                            <div class="col-md-6">
                                <span class="input-label">الاسم الأخير</span>
                                <input type="text" class="form-control custom-input" name="lastname" value="<?= $_SESSION['CurrentUser']['LastName'] ?>">
                            </div>

                            <div class="col-md-6">
                                <span class="input-label">البريد الإلكتروني</span>
                                <input type="email" class="form-control custom-input" name="email" value="<?= $_SESSION['CurrentUser']['Email'] ?>">
                            </div>
                            <div class="col-md-6">
                                <span class="input-label">رقم الهاتف</span>
                                <input type="text" class="form-control custom-input" name="phone" value="<?= $_SESSION['CurrentUser']['Phone'] ?>" dir="ltr">
                            </div>

                            <div class="col-12">
                                <span class="input-label">العنوان الحالي</span>
                                <input type="text" class="form-control custom-input" name="address" value="<?= $_SESSION['CurrentUser']['Address'] ?>">
                            </div>

                            <div class="col-12">
                                <span class="input-label">تاريخ الميلاد</span>
                                <input type="date" class="form-control custom-input" name="dob" value="<?= $_SESSION['CurrentUser']['DoB'] ?>">
                            </div>

                            <div class="col-12 mt-5">
                                <div class="d-flex flex-column flex-sm-row gap-3">
                                    <button type="submit" name="save_info" class="btn btn-save btn-lg rounded-pill px-5 flex-grow-1 text-white">
                                        <i class="bi bi-cloud-arrow-up-fill me-2"></i> حفظ التغييرات
                                    </button>
                                    <a href="/Project%20Files/Basic%20Version/Presentation/Screens/User Profile Screens/reset_password.php" class="btn btn-outline-warning btn-lg rounded-pill px-4 shadow-sm border-2">
                                        <i class="bi bi-key-fill me-2"></i> كلمة المرور
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include_once __DIR__ . "/../../includes/footer.php"; ?>
</body>

</html>