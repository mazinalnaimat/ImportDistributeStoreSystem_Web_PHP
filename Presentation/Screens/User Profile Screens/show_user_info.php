<?php
require_once __DIR__ . "/../../includes/auth.php";

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
    
    <title>الملف الشخصي | ALOFOQ</title>
    <link rel="icon" type="image/png" href="../../assests/imgs/ALOFOQ logo without text.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assests/css/share_style.css">
    <link rel="stylesheet" href="../../assests/css/user_info_screen_style.css">
    
  
</head>

<body>
    <?php include_once __DIR__ . "/../../includes/header.php"; ?>

    <main class="container py-5">
        <div class="row align-items-center mb-5 profile-page-heading">
            <div class="col-4 profile-back-slot">
                <?php if (!empty($_SESSION['page_stack']) && count($_SESSION['page_stack']) > 1): ?>
                    <form method="POST" action="/Project%20Files/Basic%20Version/Presentation/actions/user_info_action.php">
                        <button type="submit" name="go_back" class="btn app-back-button">
                            <i class="bi bi-arrow-right me-2"></i> رجوع
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <div class="col-4 text-center profile-heading-content">
                <i class="bi bi-person-badge-fill display-5 text-danger"></i>
                <h2 class="fw-bold text-white mb-0">الملف الشخصي</h2>
                <div class="title-underline"></div>
            </div>
            <div class="col-4 profile-heading-spacer"></div>
        </div>

        <div class="profile-card shadow-lg border-0">
            <div class="row g-0">
                <div class="col-lg-4 sidebar-section d-flex flex-column align-items-center text-center">
                    <div class="position-relative mb-4">
                        <div class="rounded-circle p-1 border border-danger border-2 shadow-lg">
                            <img src="<?= $_SESSION['CurrentUser']['UserImgPath'] ?>" alt="Profile" class="rounded-circle object-fit-cover" width="160" height="160">
                        </div>
                    </div>
                    <h3 class="fw-bold text-white mb-1">
                        <?= $_SESSION['CurrentUser']['FirstName'] . " " . $_SESSION['CurrentUser']['LastName'] ?>
                    </h3>
                    <p class="text-danger fw-bold mb-4">@<?= $_SESSION['CurrentUser']['UserName'] ?></p>
                    
                    <a href="/Project%20Files/Basic%20Version/Presentation/Screens/User%20Profile%20Screens/edit_user_info.php" class="btn btn-main w-100 rounded-pill py-2 shadow mt-auto">
                        <i class="bi bi-pencil-square me-2"></i> تعديل المعلومات
                    </a>
                </div>

                <div class="col-lg-8 p-4 p-md-5">
                    <div class="d-flex align-items-center mb-4 pb-2 border-bottom border-secondary border-opacity-25">
                        <i class="bi bi-list-stars text-danger fs-4 me-3"></i>
                        <h4 class="mb-0 text-light">بيانات الحساب</h4>
                    </div>

                    <div class="row g-4">
                        <?php 
                        $InfoFields = [
                            ['label' => 'البريد الإلكتروني', 'val' => $_SESSION['CurrentUser']['Email'], 'icon' => 'envelope'],
                            ['label' => 'رقم الهاتف', 'val' => $_SESSION['CurrentUser']['Phone'], 'icon' => 'phone', 'dir' => 'ltr'],
                            ['label' => 'العنوان', 'val' => $_SESSION['CurrentUser']['Address'], 'icon' => 'geo-alt'],
                            ['label' => 'تاريخ الميلاد', 'val' => $_SESSION['CurrentUser']['DoB'], 'icon' => 'calendar-event']
                        ];
                        foreach ($InfoFields as $Field): ?>
                        <div class="col-md-6">
                            <div class="info-block h-100">
                                <span class="input-label"><?= $Field['label'] ?></span>
                                <div class="d-flex align-items-center">
                                    <div class="icon-box me-3">
                                        <i class="bi bi-<?= $Field['icon'] ?> text-danger"></i>
                                    </div>
                                    <span class="text-light fw-medium fs-6" <?= isset($Field['dir']) ? "dir='ltr'" : "" ?>>
                                        <?= $Field['val'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include_once __DIR__ . "/../../includes/footer.php"; ?>
</body>
</html>