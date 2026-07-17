<?php

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}


if (empty($_SESSION['PrePage']) || $_SESSION['PrePage'] != $_SERVER['PHP_SELF']) 
{
    unset($_SESSION['PageVars']);
    $_SESSION['PrePage'] = $_SERVER['PHP_SELF'];
    if(isset($_GET['PrePageName']))
{
    $_SESSION['PageVars']['PrePageName'] = $_GET['PrePageName'];
}
}

$ActionFilePath = "/Project%20Files/Basic%20Version/Presentation/actions/reset_password_action.php";



// var_dump($_SESSION);

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>إعادة تعيين كلمة المرور</title>
        <link rel="icon" type="image/png" href="../../assests/imgs/ALOFOQ logo without text.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../../assests/css/share_style.css">
        <link rel="stylesheet" href="../../assests/css/login_screen_style.css">
    </head>
    <body>

    <?php include __DIR__ . "/../../includes/header.php"; ?>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-lg border-0 rounded-4 bg-dark text-light password-reset-card">
            <div class="card-body p-4 p-md-5">
                <h3 class="text-center text-danger mb-3">إعادة تعيين كلمة المرور</h3>

                <?php if (isset($_SESSION['PageVars']['ErrorMessage'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show text-center">
                        <?= $_SESSION['PageVars']['ErrorMessage'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['PageVars']['ErrorMessage']);?>
                <?php endif; ?>


                <!-- STEP 1 Check UserName and Password -->
                <?php if (($_SESSION['PageVars']['Step'] ?? 1) == 1): ?>
                    <form method="POST" action="<?=$ActionFilePath?>">

                        <label class="form-label">اسم المستخدم</label>
                        <input name="UserName" class="form-control mb-3"
                            value="<?= isset($_SESSION['CurrentUser']) ? $_SESSION['CurrentUser']['UserName'] : '' ?>"
                            <?= isset($_SESSION['CurrentUser']) ? 'readonly' : '' ?>
                            required>

                        <label class="form-label">كلمة المرور الحالية</label>
                        <input name="CurrentPassword" type="password" class="form-control mb-3" required>

                        <div class="d-flex justify-content-between mt-3 flex-row-reverse password-actions">

                            <!-- NEXT button (ENTER triggers this) -->
                            <button type="submit" name="check_user" class="btn btn-danger">
                                التالي
                            </button>

                            <!-- BACK button -->
                            <button type="submit" name="back" class="btn btn-secondary" formnovalidate>
                                ← العودة
                            </button>

                        </div>
                    </form>
                <?php endif; ?>


                <!-- STEP 2 Change Password-->
                <?php if (($_SESSION['PageVars']['Step'] ?? 1) == 2): ?>
                    <form method="POST" action="<?=$ActionFilePath?>">

                        <label class="form-label">كلمة المرور الجديدة</label>
                        <input name="NewPassword" type="password" class="form-control mb-3" required>

                        <label class="form-label">تأكيد كلمة المرور</label>
                        <input name="ConfirmNewPassword" type="password" class="form-control mb-3" required>

                        <div class="d-flex justify-content-between mt-3 flex-row-reverse password-actions">

                            <!-- NEXT button -->
                            <button type="submit" name="change_password" class="btn btn-danger">
                                التالي
                            </button>

                            <!-- BACK button -->
                            <button type="submit" name="back" class="btn btn-secondary" formnovalidate>
                                ← العودة
                            </button>

                        </div>

                    </form>
                <?php endif; ?>


                <!-- STEP 3 -->
                <?php if (($_SESSION['PageVars']['Step']??1) == 3): ?>
                    <div class="text-center">
                        <div class="alert alert-success">تم تغيير كلمة المرور بنجاح!</div>

                        <form method="POST" action="<?=$ActionFilePath?>">
                            <button type="submit" name="go_back" class="btn app-back-button">
                                <i class="bi bi-arrow-right"></i> العودة للصفحة السابقة
                            </button>
                        </form>

                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <?php include __DIR__ . "/../../includes/footer.php"; ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {

        // Find all forms on the page
        document.querySelectorAll("form").forEach(form => {

            // Find NEXT button in the form
            const nextBtn = form.querySelector("button.btn-danger");

            // Apply Enter → NEXT only inside inputs
            if (nextBtn) {
                form.querySelectorAll("input").forEach(input => {
                    input.addEventListener("keydown", function (e) {
                        if (e.key === "Enter") {
                            e.preventDefault();
                            nextBtn.click();
                        }
                    });
                });
            }

        });

    });
    </script>

    </body>
</html>
