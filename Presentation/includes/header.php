<!-- Fixed Header -->
<header class="fixed-top app-header <?= isset($_SESSION['CurrentUser']) ? 'has-top-nav' : 'header-compact' ?>">
    <div class="container custom-header">

        <!-- Logo -->
        <div class="alofoq-logo">
            <picture class="brand-picture">
                <source
                    media="(max-width: 767.98px)"
                    srcset="/Project%20Files/Basic%20Version/Presentation/assests/imgs/ALOFOQ%20logo%20without%20text.png"
                >
                <img
                    class="brand-logo"
                    src="/Project%20Files/Basic%20Version/Presentation/assests/imgs/ALOFOQ%20red%20Logo.png"
                    alt="ALOFOQ"
                >
            </picture>
        </div>

        <!-- Center: Title -->
        <div class="title">
            <a href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard Screens/dashboard.php">
                نظام إدارة الاستيراد والتوزيع
            </a>
        </div>

        <!-- Right: User -->
        <div class="user-options">
            <?php if (isset($_SESSION['CurrentUser'])): ?>
                <div class="dropdown">
                    <a class="dropdown-toggle user-link d-flex align-items-center gap-2"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <img src="<?= $_SESSION['CurrentUser']['UserImgPath'] ?>" alt="صورة المستخدم">
                        <span class="user-name"><?= htmlspecialchars($_SESSION['CurrentUser']['UserName']) ?></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end text-end">
                        <li>
                            <a class="dropdown-item" href="/Project%20Files/Basic%20Version/Presentation/Screens/User Profile Screens/show_user_info.php">
                                👤 المعلومات الشخصية
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="/Project%20Files/Basic%20Version/Presentation/Screens/User Profile Screens/edit_user_info.php">
                                ✏️ تعديل المعلومات
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="/Project%20Files/Basic%20Version/Presentation/actions/logout_action.php?logout=1">
                                🚪 تسجيل الخروج
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <?php if (isset($_SESSION['CurrentUser'])): ?>
        <nav class="top-nav" aria-label="القائمة الرئيسية">
            <div class="container nav-container">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/dashboard.php" class="nav-item-content">
                            <i class="bi bi-house-door"></i>
                            الرئيسية
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-item-content dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="bi bi-sliders"></i>
                            الخيارات
                        </a>

                        <ul class="dropdown-menu text-end dropdown-menu-dark">
                            <li>
                                <a href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/import_products.php" class="dropdown-item">
                                    <i class="bi bi-box-seam text-danger"></i>
                                    <span class="card-title">بضائع مستوردة</span>
                                </a>
                            </li>
                            <li>
                                <a href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/export_products.php" class="dropdown-item">
                                    <i class="bi bi-box-arrow-up-right text-danger"></i>
                                    <span class="card-title">بضائع مصدرة إلى الفروع</span>
                                </a>
                            </li>
                            <li>
                                <a href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/branches.php" class="dropdown-item">
                                    <i class="bi bi-building text-danger"></i>
                                    <span class="card-title">فروعنا</span>
                                </a>
                            </li>
                            <li>
                                <a href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/statistics.php" class="dropdown-item">
                                    <i class="bi bi-bar-chart-line text-danger"></i>
                                    <span class="card-title">احصائية</span>
                                </a>
                            </li>
                            <li>
                                <a href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/search.php" class="dropdown-item">
                                    <i class="bi bi-search text-danger"></i>
                                    <span class="card-title">البحث</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="/Project%20Files/Basic%20Version/Presentation/Screens/contact_us.php" class="nav-item-content">
                            <i class="bi bi-telephone"></i>
                            تواصل معنا
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/Project%20Files/Basic%20Version/Presentation/Screens/about_us.php" class="nav-item-content">
                            <i class="bi bi-people"></i>
                            من نحن
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>
</header>
