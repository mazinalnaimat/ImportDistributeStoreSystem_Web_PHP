<?php
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../includes/Presentation_Utils.php";



if (empty($_SESSION['PrePage']) || $_SESSION['PrePage'] != $_SERVER['PHP_SELF']) 
{
    unset($_SESSION['PageVars']);
    $_SESSION['PrePage'] = $_SERVER['PHP_SELF'];
}

$ActionFilePath = "../../actions/search_action.php";

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البحث</title>
    <link rel="icon" type="image/png" href="../../assests/imgs/ALOFOQ logo without text.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../../assests/css/share_style.css">
    <link rel="stylesheet" href="../../assests/css/search_screen_style.css">
</head>

<body>
    <?php include_once __DIR__ . "/../../includes/header.php"; ?>

    <main class="container min-vh-100 d-flex flex-column">
        
        <!-- Title  -->
        <div class="d-flex align-items-center justify-content-center mb-4 mt-4">
            <i class="bi bi-search display-4 text-danger"></i>
            <h2 class="page-title mb-0 mx-3 fw-bold">شاشة البحث</h2>
        </div>
        
        <!-- Back Button & Change Search Mode -->
        <div class="row g-3 mb-4 align-items-center">
            <!--Back Button   -->
            <div class="col-auto">
                <?php if (!empty($_SESSION['page_stack']) && count($_SESSION['page_stack']) > 1): ?>
                    <form method="POST" action="<?= $ActionFilePath ?>">
                        <button type="submit" name="go_back" class="btn btn-outline-light rounded-pill px-4 btn-sm">
                            <i class="bi bi-arrow-right me-2"></i> رجوع
                        </button>
                    </form>
                <?php endif; ?>
            </div> 
            <!-- Change Search Mode  -->
            <?php if (isset($_SESSION['PageVars']['SearchMode'])): ?>
                <div class="col-auto d-flex gap-2">
                    <form method="POST" action="<?= $ActionFilePath ?>" class="d-flex gap-2">
                        <button type="submit" name="set_search_mode" value="branches" 
                                class="btn btn-sm <?= $_SESSION['PageVars']['SearchMode'] == 'branches' ? 'btn-danger' : 'btn-dark border-danger' ?> px-3">
                            <i class="bi bi-house-gear me-1"></i> الفروع
                        </button>
                        <button type="submit" name="set_search_mode" value="distributions" 
                                class="btn btn-sm <?= $_SESSION['PageVars']['SearchMode'] == 'distributions' ? 'btn-danger' : 'btn-dark border-danger' ?> px-3">
                            <i class="bi bi-truck me-1"></i> التوزيعات
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div> 


        <!-- Choose the search mode when entering the page for the first time -->
        <?php if (!isset($_SESSION['PageVars']['SearchMode'])): ?>
            <div class="row mt-5  g-4 justify-content-center align-items-center">
                
                <div class="col-11 col-sm-10 col-md-6 col-lg-4">
                    <form method="POST" action="<?= $ActionFilePath ?>">
                        <button type="submit" name="set_search_mode" value="branches" 
                                class="btn btn-dark border-danger w-100 shadow-lg big-card-responsive p-3">
                            
                            <div class="icon-circle mb-4 bg-danger bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-house-gear text-danger"></i>
                            </div>
                            
                            <h2 class="display-4 fw-bold text-light">الفروع</h2>
                            <span class="fs-5 text-secondary mt-2 d-block">البحث في بيانات ومواقع الفروع</span>
                        </button>
                    </form>
                </div>

                <div class="col-11 col-sm-10 col-md-6 col-lg-4">
                    <form method="POST" action="<?= $ActionFilePath ?>">
                        <button type="submit" name="set_search_mode" value="distributions" 
                                class="btn btn-dark border-danger w-100 shadow-lg big-card-responsive p-3">
                            
                            <div class="icon-circle mb-4 bg-danger bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-truck text-danger"></i>
                            </div>

                            <h2 class="display-4 fw-bold text-light">التوزيعات</h2>
                            <span class="fs-5 text-secondary mt-2 d-block">البحث في فواتير وحركات التوزيع</span>
                        </button>
                    </form>
                </div>

            </div>
        <?php endif; ?>

        <!-- Branches & Distributions Search Screens  -->
        <?php if (isset($_SESSION['PageVars']['SearchMode'])): ?>

            <?php 
                
                $NumberOfItemsPerPage= $_SESSION['PageVars']['NumberOfItemsPerPage'] ?? 5;
                $PageNumber = $_SESSION['PageVars']['SearchPageNumber'] ??1;
                $TotalPages = ceil((float) ($_SESSION['PageVars']['TotalSearchResultNumber'] / $NumberOfItemsPerPage));

           ?>

            <!-- Search Bar -->
            <div class="card bg-dark text-light border-secondary p-3 mb-4 shadow-sm">
                <form method="POST" action="<?= $ActionFilePath ?>" class="row g-2 align-items-end">
                    
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">نص البحث</label>
                        <input type="text" name="search_text" class="form-control bg-dark text-light border-secondary" 
                               value="<?= $_SESSION['PageVars']['SearchCriteria']['Search'] ?? '' ?>" placeholder="أدخل كلمة للبحث...">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small text-secondary">البحث في عمود</label>
                        <select name="search_column" class="form-select bg-dark text-light border-secondary">
                            <?php 
                            // Determine which columns to show
                            if ($_SESSION['PageVars']['SearchMode'] == 'branches') 
                            {
                                $cols = 
                                [
                                    'BranchId' => 'معرف الفرع', 
                                    'Name' => 'اسم الفرع', 
                                    'Phone' => 'الهاتف', 
                                    'Address' => 'العنوان',  
                                    'Email' => 'البريد الإلكتروني', 
                                    'UserName' => 'منشئ الفرع'
                                ];
                            } 
                            else 
                            {
                                $cols = 
                                [
                                    'BranchName' => 'اسم الفرع المستلم', 
                                    'DistributionId' => 'معرف التوزيع',
                                    'CreatedBy' => 'بواسطة (المستخدم)',
                                    'CreateDateTime' => 'تاريخ الإنشاء',
                                    'DistributionDateTime' => 'تاريخ التوزيع'
                                ];
                            }
                            
                            foreach($cols as $val => $label): ?>
                                <option value="<?= $val ?>" <?= ($_SESSION['PageVars']['SearchCriteria']['ColName'] ?? '') == $val ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small text-secondary">الترتيب</label>
                        <select name="sort_order" class="form-select bg-dark text-light border-secondary">
                            <option value="ASC" <?= ($_SESSION['PageVars']['SearchCriteria']['Order'] ?? '') == 'ASC' ? 'selected' : '' ?>>تصاعدي </option>
                            <option value="DESC" <?= ($_SESSION['PageVars']['SearchCriteria']['Order'] ?? '') == 'DESC' ? 'selected' : '' ?>>تنازلي</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small text-secondary">عرض</label>
                        <input type="hidden" name="search_page_number" value="1">
                        <select name="number_items_per_page" class="form-select bg-dark text-light border-secondary" onchange="this.form.submit()">
                            <?php foreach ([5, 10, 20, 50] as $n): ?>
                                <option value="<?= $n ?>" <?= $NumberOfItemsPerPage == $n ? 'selected' : '' ?>><?= $n ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" name="execute_search" class="btn btn-danger w-100">
                            <i class="bi bi-search"></i> بحث
                        </button>
                    </div>
                </form>
            </div>

            <!-- Result Table -->
            <div class="table-responsive shadow rounded-3 mb-5">
                <table class="table table-dark table-hover border-secondary align-middle mb-0">
                    <thead class="table-danger">
                        <tr>
                            <?php if($_SESSION['PageVars']['SearchMode'] == 'branches'): ?>
                                <th>#</th>
                                <th>اسم الفرع</th>
                                <th>معرف الفرع</th>
                                <th>الهاتف</th>
                                <th>البريد الإلكتروني</th>
                                <th>العنوان</th>
                                <th>بواسطة</th>
                            <?php else: ?>
                                <th>#</th>
                                <th>الفرع المستلم</th>
                                <th>معرف التوزيع</th>
                                <th>بواسطة</th>
                                <th>تاريخ الإنشاء</th>
                                <th>تاريخ التوزيع</th>
                                <th class="">شراء</th>
                                <th class="t">بيع</th>
                                <th class="text-success">ربح</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $Results = $_SESSION['PageVars']['SearchResults'] ?? [];
                        if (empty($Results)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-secondary">لا توجد نتائج لعرضها</td>
                            </tr>
                        <?php else: ?>
                            <?php for ($i=0; $i<count($Results); $i++): ?>
                                <tr>
                                    <td class="fw-bold text-light"><?=  ($PageNumber -1 ) * $NumberOfItemsPerPage + $i +1?></td>
                                    <?php if($_SESSION['PageVars']['SearchMode'] == 'branches'): ?>
                                        <td class="fw-bold text-light"><?= $Results[$i]['Name'] ?></td>
                                        <td><?= $Results[$i]['BranchId'] ?></td>
                                        <td><?= $Results[$i]['Phone'] ?></td>
                                        <td><?= $Results[$i]['Email'] ?></td>
                                        <td><?= $Results[$i]['Address'] ?></td>
                                        <td><span class="badge bg-secondary"><?= $Results[$i]['UserName'] ?></span></td>
                                    
                                    <?php else: ?>
                                        <td><?= $Results[$i]['BranchName'] ?></td>
                                        <td><?= $Results[$i]['DistributionId'] ?></td>
                                        <td><span class="badge bg-secondary"><?= $Results[$i]['CreatedBy'] ?></span></td>
                                        <td dir="ltr" class="text-end"><?= date('Y-m-d H:i:s', strtotime($Results[$i]['CreateDateTime'])) ?></td>
                                        <td dir="ltr" class="text-end"><?= date('Y-m-d H:i:s', strtotime($Results[$i]['DistributionDateTime'])) ?></td>
                                        
                                        <td class="fw-bold">
                                            <?= number_format($Results[$i]['TotalDistPurchasePrice'], 2) ?>
                                        </td>
                                        <td class="fw-bold">
                                            <?= number_format($Results[$i]['TotalDistSellingPrice'], 2) ?>
                                        </td>
                                        <td class="text-success fw-bold">
                                            <?= number_format($Results[$i]['TotalDistProfit'], 2) ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <?php if ($TotalPages > 1): ?>
                <nav class="mt-3">
                    <ul class="pagination justify-content-center gap-1">
                        
                        <li class="page-item <?= ($PageNumber<= 1) ? 'disabled' : '' ?>">
                            <form method="POST" action="<?=$ActionFilePath?>" class="d-inline m-0 p-0">
                                <input type="hidden" name="search_page_number" value="<?= max(1, $PageNumber- 1) ?>">
                                <button type="submit" class="page-link btn shadow-none <?= ($PageNumber<= 1) ? 'bg-secondary border-secondary text-white' : 'bg-danger border-danger text-white' ?>" <?= ($PageNumber<= 1) ? 'disabled' : '' ?>>
                                    السابق
                                </button>
                            </form>
                        </li>

                        <?php for ($p = 1; $p <= $TotalPages; $p++): ?>
                            <li class="page-item <?= ($p == $PageNumber) ? 'active' : '' ?>">
                                <form method="POST" action="<?=$ActionFilePath?>" class="d-inline m-0 p-0">
                                    <input type="hidden" name="search_page_number" value="<?= $p ?>">
                                    <button type="submit" class="page-link btn shadow-none <?= ($p == $PageNumber) ? 'bg-light text-danger fw-bold border-danger' : 'bg-danger text-white border-danger' ?>">
                                        <?= $p ?>
                                    </button>
                                </form>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?= ($PageNumber>= $TotalPages) ? 'disabled' : '' ?>">
                            <form method="POST" action="<?=$ActionFilePath?>" class="d-inline m-0 p-0">
                                <input type="hidden" name="search_page_number" value="<?= min($TotalPages, $PageNumber+ 1) ?>">
                                <button type="submit" class="page-link btn shadow-none <?= ($PageNumber>= $TotalPages) ? 'bg-secondary border-secondary text-white' : 'bg-danger border-danger text-white' ?>" <?= ($PageNumber>= $TotalPages) ? 'disabled' : '' ?>>
                                    التالي
                                </button>
                            </form>
                        </li>

                    </ul>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    
    </main>

    <?php include_once __DIR__ . "/../../includes/footer.php"; ?>
</body>
</html>