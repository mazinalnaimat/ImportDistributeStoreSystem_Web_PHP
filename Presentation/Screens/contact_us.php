<?php
require_once __DIR__ . "/../includes/auth.php";



if (empty($_SESSION['PrePage']) || $_SESSION['PrePage'] != $_SERVER['PHP_SELF']) 
{
    unset($_SESSION['PageVars']);
    $_SESSION['PrePage'] = $_SERVER['PHP_SELF'];
}

$ActionFilePath = "../actions/contact_us_action.php";


?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>البحث</title>
        <link rel="icon" type="image/png" href="../assests/imgs/ALOFOQ logo without text.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        
        <link rel="stylesheet" href="../assests/css/share_style.css">
        <link rel="stylesheet" href="../assests/css/contact_us_screen_style.css">
    </head>

    <body>
        <?php include_once __DIR__ . "/../includes/header.php"; ?>

        <main class="container min-vh-100 d-flex flex-column">
            
            <!-- Title  -->
            <div class="d-flex align-items-center justify-content-center mb-4 mt-4">
                <i class="bi bi-telephone display-4 text-danger"></i>
                <h2 class="page-title mb-0 mx-3 fw-bold">تواصل معنا</h2>
            </div>
            
            <!-- Back Button -->
            <div class="col-auto page-back-slot ">
                <form method="GET" action="<?= $ActionFilePath ?>">
                    <button type="submit" name="go_back" class="btn app-back-button">
                        <i class="bi bi-arrow-right me-2"></i> رجوع
                    </button>
                </form>
            </div> 

            <!-- Add Note Alert Status -->
            <?php if(isset($_SESSION["PageVars"]["NoteStatus"])): ?>
                <?php if($_SESSION['PageVars']['NoteStatus'] == true): ?>
                    <div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                        ✅ تم إضافة  الملاحظة رقم 
                        <?=($_SESSION['PageVars']['NoteId']);?> 
                        بنجاح
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['PageVars']['NoteId']); ?>
                <?php else: ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
                        ❌ فشل في إضافة  الملاحظة
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php unset($_SESSION['PageVars']['NoteStatus']); ?>
            <?php endif; ?> 

            <div class="row mt-4">

                <!-- Contact Information -->
                <div class="col-lg-5 mb-4">
                    <div class="contact-card h-100">

                        <h4 class="mb-4">
                            <i class="bi bi-person-lines-fill text-danger"></i>
                            معلومات التواصل
                        </h4>

                        <div class="contact-item">
                            <i class="bi bi-telephone-fill"></i>
                            <span>075797242518</span>
                        </div>

                        <div class="contact-item">
                            <i class="bi bi-envelope-fill"></i>
                            <span>support@alofoq.com</span>
                        </div>

                        <div class="contact-item">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>الأردن - عمان</span>
                        </div>

                        <div class="contact-item">
                            <i class="bi bi-clock-fill"></i>
                            <span>الأحد - الخميس (8:00 - 4:00)</span>
                        </div>

                    </div>
                </div>



                <!-- Contact Form -->
                <div class="col-lg-7">

                    <div class="contact-card">

                        <h4 class="mb-4">
                            <i class="bi bi-chat-left-text-fill text-danger"></i>
                            أرسل لنا ملاحظة
                        </h4>

                        <form method="POST" action="<?= $ActionFilePath ?>">

                            <div class="mb-3">
                                <label class="form-label">عنوان الملاحظة</label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="note_title"
                                    maxlength="100"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">الملاحظة</label>

                                <textarea
                                    class="form-control"
                                    name="note_text"
                                    rows="6"
                                    required></textarea>
                            </div>

                            <button
                                type="submit"
                                name="add_note"
                                class="btn btn-danger px-5">

                                <i class="bi bi-send-fill"></i>
                                إرسال
                            </button>

                        </form>

                    </div>

                </div>

            </div>
                
        </main>

        <?php include_once __DIR__ . "/../includes/footer.php"; ?>
    </body>
</html>