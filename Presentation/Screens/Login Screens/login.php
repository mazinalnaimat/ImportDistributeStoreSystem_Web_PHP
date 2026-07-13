<?php

if (session_status() === PHP_SESSION_NONE) 
{
    session_start();
}

if (empty($_SESSION['PrePage']) || $_SESSION['PrePage'] != $_SERVER['PHP_SELF']) 
{
    unset($_SESSION['PageVars']);
    unset($_SESSION['CurrentUser']);
    $_SESSION['PrePage'] = $_SERVER['PHP_SELF'];
}


$ShowConnectYourAdmin = $_SESSION['ShowConnectYourAdmin'] ?? null;
$ShowYourInfoWrong    = $_SESSION['ShowYourInfoWrong'] ?? null;

unset($_SESSION['ShowConnectYourAdmin']);
unset($_SESSION['ShowYourInfoWrong']);

$User = false;

$ActionPath = "/Project%20Files/Basic%20Version/Presentation/actions/login_action.php";


?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نظام إدارة متجر ALOFOQ - تسجيل الدخول</title>
    <link rel="icon" type="image/png" href="/Project%20Files/Basic%20Version/Presentation/assests/imgs/ALOFOQ%20logo%20without%20text.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="/Project%20Files/Basic%20Version/Presentation/assests/css/share_style.css">
    <link rel="stylesheet" href="/Project%20Files/Basic%20Version/Presentation/assests/css/login_screen_style.css">
</head>
<body dir="rtl"> 

    <?php include_once __DIR__ ."/../../includes/header.php";?>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-lg border-0 rounded-4 bg-dark text-light">
            <div class="card-body p-4 p-md-5">

                <div class="text-center mb-4">
                    <h2 class="fw-bold text-danger">نظام إدارة المتجر</h2>
                    <p class="text-secondary mb-0">تسجيل الدخول إلى حسابك</p>
                </div>

                <form method="GET" action=<?=$ActionPath?>>
                    <input type="hidden" name="login">
                    <?php if ($ShowYourInfoWrong): ?>
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>فشل تسجيل الدخول!</strong><br>
                            اسم المستخدم أو كلمة المرور غير صحيحة.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($ShowConnectYourAdmin): ?>
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>نسيت كلمة المرور!</strong><br>
                            تواصل مع المسؤول لإعادة تعيين كلمة المرور.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label">اسم المستخدم</label>
                        <input type="text" name="UserName" class="form-control form-control-lg"
                               placeholder="أدخل اسم المستخدم" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="Password">كلمة المرور</label>
                        <input type="password" id="Password" name="Password" class="form-control form-control-lg"
                               placeholder="أدخل كلمة المرور" required>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-danger btn-lg">
                            <i class="bi bi-box-arrow-in-right me-1"></i> تسجيل الدخول
                        </button>
                    </div>
                </form> 

                <!-- Forgot / Reset -->
                <div class="text-center auth-links mt-3">
                    <form method="GET" action=<?=$ActionPath?> class="d-inline auth-links">
                        <input type="hidden" name="forgot">
                        <button type="submit" class="align-baseline">
                            <i class="bi bi-question-circle"></i> نسيت كلمة المرور
                        </button>
                    </form>

                    <span class="text-secondary d-none d-sm-inline">|</span>
                    <a href="/Project%20Files/Basic%20Version/Presentation/Screens/User Profile Screens/reset_password.php" class="ms-2">
                        <i class="bi bi-arrow-repeat"></i> إعادة تعيين كلمة المرور
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ ."/../../includes/footer.php";?>

</body>
</html>
