<?php
require_once __DIR__ . "/../includes/auth.php";

if (empty($_SESSION['PrePage']) || $_SESSION['PrePage'] !== $_SERVER['PHP_SELF']) {
    unset($_SESSION['PageVars']);
    $_SESSION['PrePage'] = $_SERVER['PHP_SELF'];
}

$ActionFilePath = "../actions/about_us_action.php";
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="تعرف على متجر الأفق للإلكترونيات، منتجاتنا، فروعنا، وخدماتنا.">

    <title>من نحن | متجر الأفق</title>

    <link rel="icon" type="image/png" href="../assests/imgs/ALOFOQ logo without text.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../assests/css/share_style.css">
    <link rel="stylesheet" href="../assests/css/about_us_screen_style.css">
</head>

<body>
    <?php include_once __DIR__ . "/../includes/header.php"; ?>

    <main class="about-page">
        <div class="container about-container">

            <section class="about-heading" aria-labelledby="about-page-title">
                <form method="GET" action="<?= htmlspecialchars($ActionFilePath, ENT_QUOTES, 'UTF-8') ?>" class="back-form">
                    <button type="submit" name="go_back" class="back-button app-back-button">
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                        <span>رجوع</span>
                    </button>
                </form>

                <div class="title-group">
                    <div class="title-icon" aria-hidden="true">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <p class="title-eyebrow">تعرفوا علينا أكثر</p>
                        <h1 id="about-page-title" class="page-title">من نحن</h1>
                    </div>
                </div>
            </section>

            <section class="hero-card" aria-label="متجر الأفق للإلكترونيات">
                <img
                    src="../assests/imgs/about/store.png"
                    class="hero-image"
                    alt="واجهة داخلية حديثة لمتجر الأفق للإلكترونيات"
                >
                <div class="hero-overlay" aria-hidden="true"></div>
                <div class="hero-badge">
                    <i class="bi bi-lightning-charge-fill" aria-hidden="true"></i>
                    <span>تقنية تجمع الجودة والابتكار</span>
                </div>
            </section>

            <section class="intro-section">
                <div class="section-heading">
                    <span class="section-kicker">قصة الأفق</span>
                    <h2 class="section-title">مرحبًا بكم في متجر الأفق للإلكترونيات</h2>
                </div>

                <div class="intro-copy">
                    <p>
                        يعد متجر <strong>الأفق للإلكترونيات</strong> أحد المتاجر الرائدة في مجال بيع الأجهزة
                        الإلكترونية والمنزلية، حيث نسعى دائمًا إلى توفير أحدث المنتجات العالمية بأسعار مناسبة،
                        مع خدمة عملاء متميزة وتجربة تسوق سهلة وآمنة.
                    </p>

                    <p>
                        نقدم مجموعة واسعة من أجهزة الحاسوب المكتبية والمحمولة، والهواتف الذكية، والأجهزة اللوحية،
                        بالإضافة إلى الملحقات والإكسسوارات مثل الشواحن، والسماعات، ولوحات المفاتيح، والفأرات،
                        والشاشات، والطابعات، وأجهزة التخزين.
                    </p>

                    <p>
                        كما نوفر تشكيلة كبيرة من الأجهزة المنزلية التي تلبي احتياجات الأسرة، مثل الثلاجات،
                        والغسالات، وأجهزة التلفاز الذكية، والمكيفات، وأجهزة المطبخ المختلفة، مع الحرص على اختيار
                        منتجات موثوقة من أشهر العلامات التجارية العالمية.
                    </p>
                </div>
            </section>

            <section class="categories-section" aria-labelledby="categories-title">
                <div class="section-heading section-heading-center">
                    <span class="section-kicker">أقسامنا الرئيسية</span>
                    <h2 id="categories-title" class="section-title">كل ما تحتاجه في مكان واحد</h2>
                </div>

                <div class="category-grid">
                    <article class="category-card">
                        <div class="category-image-wrap">
                            <img
                                src="../assests/imgs/about/laptops.png"
                                class="category-image"
                                alt="حاسوبات محمولة حديثة"
                            >
                            <span class="category-number">01</span>
                        </div>
                        <div class="category-content">
                            <div class="category-icon" aria-hidden="true">
                                <i class="bi bi-laptop"></i>
                            </div>
                            <div>
                                <h3>حاسوبات محمولة</h3>
                                <p>خيارات متنوعة للعمل والدراسة والترفيه بأداء قوي وتصميمات حديثة.</p>
                            </div>
                            <span class="category-arrow" aria-hidden="true">
                                <i class="bi bi-arrow-left"></i>
                            </span>
                        </div>
                    </article>

                    <article class="category-card">
                        <div class="category-image-wrap">
                            <img
                                src="../assests/imgs/about/phones.png"
                                class="category-image"
                                alt="هواتف ذكية حديثة"
                            >
                            <span class="category-number">02</span>
                        </div>
                        <div class="category-content">
                            <div class="category-icon" aria-hidden="true">
                                <i class="bi bi-phone"></i>
                            </div>
                            <div>
                                <h3>هواتف ذكية</h3>
                                <p>أحدث الهواتف والمواصفات المتطورة مع مجموعة متكاملة من الملحقات.</p>
                            </div>
                            <span class="category-arrow" aria-hidden="true">
                                <i class="bi bi-arrow-left"></i>
                            </span>
                        </div>
                    </article>

                    <article class="category-card">
                        <div class="category-image-wrap">
                            <img
                                src="../assests/imgs/about/home-electronics.png"
                                class="category-image"
                                alt="أجهزة منزلية حديثة"
                            >
                            <span class="category-number">03</span>
                        </div>
                        <div class="category-content">
                            <div class="category-icon" aria-hidden="true">
                                <i class="bi bi-house-gear"></i>
                            </div>
                            <div>
                                <h3>أجهزة منزلية</h3>
                                <p>حلول منزلية موثوقة وعالية الأداء تجمع بين الأناقة والكفاءة.</p>
                            </div>
                            <span class="category-arrow" aria-hidden="true">
                                <i class="bi bi-arrow-left"></i>
                            </span>
                        </div>
                    </article>
                </div>
            </section>

            <section class="experience-section">
                <div class="experience-copy">
                    <span class="section-kicker">تجربة متكاملة</span>
                    <h2 class="section-title">خدمة موثوقة قبل البيع وبعده</h2>
                    <p>
                        نفتخر بامتلاك شبكة واسعة من الفروع، وفريق عمل متخصص يساعد العملاء في اختيار المنتجات
                        المناسبة، ويقدم الاستشارات الفنية والإجابة عن الاستفسارات لضمان تجربة شراء ناجحة.
                    </p>
                    <p>
                        ويتم تحديث منتجاتنا وعروضنا باستمرار لمواكبة أحدث التقنيات، إلى جانب خدمات الضمان
                        والصيانة المعتمدة وخيارات الدفع المرنة.
                    </p>
                </div>

                <div class="experience-list">
                    <div class="feature-item">
                        <span class="feature-icon"><i class="bi bi-shield-check"></i></span>
                        <div>
                            <h3>ضمان موثوق</h3>
                            <p>منتجات أصلية وخدمات ما بعد البيع.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <span class="feature-icon"><i class="bi bi-headset"></i></span>
                        <div>
                            <h3>دعم متخصص</h3>
                            <p>فريق جاهز لمساعدتك في كل خطوة.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <span class="feature-icon"><i class="bi bi-truck"></i></span>
                        <div>
                            <h3>توصيل سريع</h3>
                            <p>خدمة مرنة وآمنة إلى مختلف المناطق.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="stats-panel" aria-label="إحصائيات متجر الأفق">
                <div class="stat-card">
                    <div class="stat-icon" aria-hidden="true">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <strong>+25</strong>
                        <span>فرعًا</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" aria-hidden="true">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <strong>+20,000</strong>
                        <span>منتج</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" aria-hidden="true">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <strong>+100,000</strong>
                        <span>عميل</span>
                    </div>
                </div>
            </section>

            <section class="closing-card">
                <div class="closing-icon" aria-hidden="true">
                    <i class="bi bi-stars"></i>
                </div>
                <div>
                    <h2>ثقتكم تدفعنا دائمًا إلى الأفضل</h2>
                    <p>
                        في متجر الأفق نؤمن بأن الجودة والثقة وخدمة العملاء هي أساس النجاح، ولذلك نواصل تطوير
                        خدماتنا وتوسيع شبكة فروعنا وتوفير أحدث التقنيات لنكون الوجهة الأولى لكل من يبحث عن
                        الأجهزة الإلكترونية والمنزلية بأفضل قيمة وأعلى مستوى من الجودة.
                    </p>
                </div>
            </section>

        </div>
    </main>

    <?php include_once __DIR__ . "/../includes/footer.php"; ?>
</body>
</html>
