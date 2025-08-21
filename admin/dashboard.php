<?php
session_start();
$pageTitle = 'Dashboard';
include 'init.php';
auth('index.php');
$noNavbar = '';
showMessage();
?>

<body class="bg-light">

    <div class="container-fluid py-5">

        <!-- Page Title -->
        <div class="text-center mb-5">
            <h1 class="fw-bold text-gradient" style="font-size: 2.5rem; line-height: 1.2; background: linear-gradient(90deg, #4e54c8, #8f94fb); -webkit-background-clip: text; color: transparent;">
                لوحة التحكم
            </h1>
            <p class="lead text-muted" style="font-size: 1.1rem;">
                مرحبًا بك في لوحة الإدارة الخاصة بك، تابع الإحصائيات والطلبات بسهولة
            </p>
        </div>


        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <!-- Users -->
            <div class="col-md-3">
                <div class="card shadow-lg border-0 h-100" style="background: linear-gradient(135deg, #6a11cb, #2575fc); color: white;">
                    <div class="card-body text-center">
                        <h6 class="card-title text-uppercase">المستخدمين</h6>
                        <h2 class="fw-bold"><?= countWhere('users') ?? 0 ?></h2>
                        <a href="members.php?do=manage" class="text-white small text-decoration-none">عرض الكل</a>
                    </div>
                </div>
            </div>

            <!-- Active Users -->
            <div class="col-md-3">
                <div class="card shadow-lg border-0 h-100" style="background: linear-gradient(135deg, #11998e, #38ef7d); color: white;">
                    <div class="card-body text-center">
                        <h6 class="card-title text-uppercase">نشط</h6>
                        <h2 class="fw-bold"><?= countWhere('users', 'RegStatus', 1) ?? 0 ?></h2>
                    </div>
                </div>
            </div>

            <!-- Pending Users -->
            <div class="col-md-3">
                <div class="card shadow-lg border-0 h-100" style="background: linear-gradient(135deg, #ff8008, #ffc837); color: white;">
                    <div class="card-body text-center">
                        <h6 class="card-title text-uppercase">معلق</h6>
                        <h2 class="fw-bold"><?= countWhere('users', 'RegStatus', 0) ?? 0 ?></h2>
                        <a href="members.php?page=pending" class="text-white small text-decoration-none">عرض الكل</a>

                    </div>
                </div>
            </div>

            <!-- Banned Users -->
            <div class="col-md-3">
                <div class="card shadow-lg border-0 h-100" style="background: linear-gradient(135deg, #fc5c7d, #6a82fb); color: white;">
                    <div class="card-body text-center">
                        <h6 class="card-title text-uppercase">عدد المنتجات </h6>
                        <h2 class="fw-bold"><?= countWhere('products')   ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Cards -->
        <div class="row g-4 mb-5">
            <!-- Total Orders -->
            <div class="col-md-3">
                <div class="card shadow-lg border-0 h-100" style="background: linear-gradient(135deg, #36d1dc, #5b86e5); color: white;">
                    <div class="card-body text-center">
                        <h6 class="card-title text-uppercase">اجمالي الطلبات</h6>
                        <h2 class="fw-bold">0</h2>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="col-md-3">
                <div class="card shadow-lg border-0 h-100" style="background: linear-gradient(135deg, #ff416c, #ff4b2b); color: white;">
                    <div class="card-body text-center">
                        <h6 class="card-title text-uppercase">طلبات معلقة</h6>
                        <h2 class="fw-bold">0</h2>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="col-md-3">
                <div class="card shadow-lg border-0 h-100" style="background: linear-gradient(135deg, #11998e, #38ef7d); color: white;">
                    <div class="card-body text-center">
                        <h6 class="card-title text-uppercase">طلبات مكتملة</h6>
                        <h2 class="fw-bold">0</h2>
                    </div>
                </div>
            </div>

            <!-- Canceled Orders -->
            <div class="col-md-3">
                <div class="card shadow-lg border-0 h-100" style="background: linear-gradient(135deg, #ff512f, #dd2476); color: white;">
                    <div class="card-body text-center">
                        <h6 class="card-title text-uppercase">طلبات ملغاة</h6>
                        <h2 class="fw-bold">0</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Columns: Recent Members & Latest Items -->
        <div class="row g-4">
            <!-- Recent Members -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-dark text-white text-end">أحدث المستخدمين</div>
                    <div class="card-body p-0">
                        <table class="table table-hover text-center align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>اسم المستخدم</th>
                                    <th>البريد</th>
                                    <th>الاسم الكامل</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rows = showData('users', 'ORDER BY id DESC LIMIT 15');
                                $i = 1;
                                foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['Username'] ?></td>
                                        <td><?= $row['Email'] ?></td>
                                        <td><?= $row['FullName'] ?></td>
                                        <td>
                                            <?php if ($row['RegStatus'] == '1'): ?>
                                                <span class="badge bg-success">نشط</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">معلق</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Latest Items -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-dark text-white text-end">أحدث المنتجات</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- المنتج الأول -->
                            <?php $products = showData('products', 'ORDER BY id DESC LIMIT 4'); ?>
                            <?php foreach ($products as $product): ?>
                                <div class="col-6">
                                    <div class="card shadow-sm h-100">
                                        <img src="uploads/<?= htmlspecialchars($product['image']); ?>?>"
                                            class="card-img-top"
                                            style="width: 100%; height: 150px; object-fit: cover;">
                                        <div class="card-body text-center">
                                            <h6 class="card-title"><?php echo $product['name']; ?></h6>
                                            <p class="card-text"><?php echo $product['description']; ?></p>
                                            <a href="products.php?do=edit&id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm">عرض</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>


                            <!-- أي منتجات إضافية ستظهر أسفل الاثنين -->
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <?php include $tpl . "footer.php"; ?>