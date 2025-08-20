<?php showMessage(); ?>


  <div class="container py-5 bg-light">

    <!-- عنوان الصفحة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold">
        <i class="fa-solid fa-list me-2 text-primary"></i> إدارة الأقسام
      </h2>
      <a href="categories.php?do=add" class="btn btn-success btn-lg">
        <i class="fa-solid fa-plus me-2"></i> إضافة قسم جديد
      </a>
    </div>

    <!-- شريط البحث + عدد الأقسام -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      
      <!-- البحث -->
      <form class="d-flex w-50">
        <input type="text" class="form-control me-2" placeholder="ابحث عن قسم...">
        <button class="btn btn-outline-primary">
          <i class="fa-solid fa-search"></i>
        </button>
      </form>

      <!-- البادج + الأزرار -->
      <div class="d-flex align-items-center gap-2">
        <span class="badge bg-primary p-2 fs-6">
          عدد الأقسام : <?php echo countWhere('categories') ?>
        </span>

        <a href="?sort=ASC" 
           class="btn btn-outline-primary btn-sm <?php echo ($sort == 'ASC') ? 'active' : ''; ?>">
          <i class="bi bi-arrow-up"></i> تصاعدي
        </a>

        <a href="?sort=DESC" 
           class="btn btn-outline-primary btn-sm <?php echo ($sort == 'DESC') ? 'active' : ''; ?>">
          <i class="bi bi-arrow-down"></i> تنازلي
        </a>
      </div>
    </div>

    <!-- جدول عرض الأقسام -->
    <div class="card shadow-sm">
      <div class="card-body">
        <table class="table table-striped align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>اسم القسم</th>
              <th>الوصف</th>
              <th>الحالة</th>
              <th>السماح بالإعلانات</th>
              <th>السماح بالتعليقات</th>
              <th class="text-center">الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categories as $categorie): ?>
              <tr>
                <td><?php echo $categorie['id'] ?></td>
                <td><?php echo $categorie['name'] ?></td>
                <td><?php echo $categorie['dscription'] ?></td>

                <!-- حالة التفعيل -->
                <td>
                  <span class="badge <?php echo ($categorie['visibility'] == 1) ? 'bg-success' : 'bg-danger'; ?>">
                    <?php echo ($categorie['visibility'] == 1) ? 'مفعل' : 'غير مفعل'; ?>
                  </span>
                </td>

                <!-- السماح بالإعلانات -->
                <td>
                  <span class="badge <?php echo ($categorie['allowAds'] == 1) ? 'bg-success' : 'bg-danger'; ?>">
                    <?php echo ($categorie['allowAds'] == 1) ? 'مسموح' : 'غير مسموح'; ?>
                  </span>
                </td>

                <!-- السماح بالتعليقات -->
                <td>
                  <span class="badge <?php echo ($categorie['allowComment'] == 1) ? 'bg-success' : 'bg-danger'; ?>">
                    <?php echo ($categorie['allowComment'] == 1) ? 'مسموح' : 'غير مسموح'; ?>
                  </span>
                </td>

                <!-- الإجراءات -->
                <td class="text-center">
                  <a href="categories.php?do=edit&id=<?php echo $categorie['id']; ?>"
                    class="btn btn-sm btn-warning me-1">
                    <i class="fa-solid fa-pen-to-square"></i> تعديل
                  </a>

                  <a href="categories.php?do=delete&id=<?php echo $categorie['id']; ?>"
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
