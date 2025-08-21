<?php showMessage(); ?>

<div class="container my-4">

    <!-- عنوان الصفحة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="fa-solid fa-box-open text-primary me-2"></i> <?php echo $pageTitle ?>
        </h2>
        <a href="products.php?do=add" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> إضافة منتج جديد
        </a>
    </div>

    <div class="row">
        <!-- جزء الفلترة -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <i class="fa-solid fa-filter me-2"></i> الفلترة
                </div>
                <div class="card-body">
                    <!-- بداية الفورم -->
                    <form method="GET" action="products.php">

                        <!-- البحث -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">بحث</label>
                            <input type="text" name="search" class="form-control"
                                value="<?= $_GET['search'] ?? '' ?>"
                                placeholder="ابحث عن منتج...">
                        </div>

                        <!-- الفلترة حسب القسم -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">القسم</label>
                            <select name="categorie" class="form-select">
                                <option value="">الكل</option>
                                <?php foreach ($categories as $categorie): ?>
                                    <option value="<?= $categorie['id'] ?>"
                                        <?= (($_GET['category'] ?? '') == $categorie['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($categorie['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- حالة المنتج -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">الحالة</label>
                            <select name="status" class="form-select">
                                <option value="">الكل</option>
                                <option value="1" <?= (($_GET['status'] ?? '') == '1') ? 'selected' : '' ?>>مفعل</option>
                                <option value="0" <?= (($_GET['status'] ?? '') == '0') ? 'selected' : '' ?>>غير مفعل</option>
                            </select>
                        </div>

                        <!-- زر التطبيق -->
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> تطبيق
                        </button>

                    </form>
                    <!-- نهاية الفورم -->
                </div>
            </div>
        </div>


        <!-- جزء عرض المنتجات -->
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <i class="fa-solid fa-table me-2"></i> قائمة المنتجات
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>الصورة</th>
                                <th>الاسم</th>
                                <th>القسم</th>
                                <th>السعر</th>
                                <th>الحالة</th>
                                <th>التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- مثال منتج -->
                            <?php foreach ($products as $product):
                            ?>
                                <tr>
                                    <td>
                                        <img src="uploads/<?= htmlspecialchars($product['image']); ?>" width="60" height="60" class="rounded">
                                    </td>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php

                                        foreach ($categories as $categorie) {
                                            if ($product['categorieId'] == $categorie['id']) {
                                                echo htmlspecialchars($categorie['name']);
                                                break;
                                            }
                                        }
                                        ?></td>
                                    <td><?php echo $product['price']; ?> ج.م</td>
                                    <?php if ($product['status'] == 1): ?>
                                        <td>
                                            <span class="badge bg-success">مفعل</span>
                                        </td>
                                    <?php elseif ($product['status'] == 0) : ?>
                                        <td>
                                            <span class="badge bg-danger">غير مفعل</span>
                                        </td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <a href="products.php?do=edit&id=<?php echo $product['id']; ?>"
                                            class="btn btn-sm btn-warning me-1">
                                            <i class="fa-solid fa-pen-to-square"></i> تعديل
                                        </a>

                                        <a href="products.php?do=delete&id=<?php echo $product['id']; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('هل أنت متأكد من الحذف؟');">
                                            <i class="fa-solid fa-trash"></i> حذف
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>