<!-- Fixed Header -->



<header class="fixed-top">
    <div class="container custom-header">

        <!-- Logo -->
        <div class="alofoq-logo">
            <img src="/Project%20Files/Basic%20Version/Presentation/assests/imgs/ALOFOQ red Logo.png">
        </div>

        <!-- Center: Title -->
        <div class="title" >
            <a  href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard Screens/dashboard.php">نظام إدارة الاستيراد والتوزيع</a>
        </div>

        <!-- Right: User -->
        <div class="user-options">
             <?php  if (isset($_SESSION['CurrentUser'])): ?>
                <div class="dropdown">
                    <a class="dropdown-toggle user-link d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
    
                        <img src="<?=$_SESSION['CurrentUser']['UserImgPath'] ?>" 
                            alt="User" 
                            >

                        مرحباً <?= htmlspecialchars($_SESSION['CurrentUser']['UserName']) ?>
                    </a>


                    <ul class="dropdown-menu dropdown-menu-end text-end">
                        <li>
                            <a class="dropdown-item" href="/Project%20Files/Basic%20Version/Presentation/Screens/User Profile Screens/show_user_info.php">
                                👤 المعلومات الشخصية
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item" href="/Project%20Files/Basic%20Version/Presentation/Screens/User Profile Screens/edit_user_info.php">
                                ✏️ تعديل المعلومات
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

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

    <?php  if (isset($_SESSION['CurrentUser'])): ?>
        <nav class="top-nav">
            <div class="container nav-container"></div>
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
                        aria-expanded="false"
                        >
                            <i class="bi bi-sliders"></i>
                            الخيارات
                        </a>

                        <ul class="dropdown-menu text-end dropdown-menu-dark">

                            <li>
                                <a href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/import_products.php" class="dropdown-item">
                                    <i class="bi bi-box-seam  mb-3 text-danger"></i>
                                    <span class="card-title">بضائع مستوردة</span>
                                </a>
                            </li>

                            
                            <li>
                                <a href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/export_products.php" class="dropdown-item">
                                    <i class="bi bi-box-arrow-up-right  mb-3 text-danger"></i>
                                    <span class="card-title">بضائع مصدرة إلى الفروع</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/branches.php" class="dropdown-item">
                                    <i class="bi bi-building  mb-3 text-danger"></i>
                                    <span class="card-title">فروعنا</span>
                                </a>
                            </li>
                            <li>
                                <a href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/statistics.php" class="dropdown-item">
                                    <i class="bi bi-bar-chart-line  mb-3 text-danger"></i>
                                    <span class="card-title">احصائية</span>
                                </a>
                            </li>

                            <li>
                                <a href="/Project%20Files/Basic%20Version/Presentation/Screens/Dashboard%20Screens/search.php" class="dropdown-item">
                                    <i class="bi bi-search  mb-3 text-danger"></i>
                                    <span class="card-title">البحث</span>
                                </a>
                            </li>


                           
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="/Project%20Files/Basic%20Version/Presentation/Screens/contact.php" class="nav-item-content">
                            <i class="bi bi-telephone"></i> 
                            تواصل معنا
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/Project%20Files/Basic%20Version/Presentation/Screens/about.php" class="nav-item-content">
                            <i class="bi bi-people"></i>
                            من نحن
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif;?>


</header>
