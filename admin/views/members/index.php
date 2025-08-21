<div class="container py-5">

  <!-- العنوان + زر الإضافة -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">
      <i class="fa-solid fa-users text-primary me-2"></i> إدارة الأعضاء
    </h2>
    <a href="members.php?do=add" class="btn btn-success btn-lg">
      <i class="fa-solid fa-user-plus me-2"></i> إضافة عضو جديد
    </a>
  </div>

  <?php showMessage(); ?>

  <!-- شريط البحث + عدد الأعضاء -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <!-- البحث -->
    <form class="d-flex w-50">
      <input type="text" class="form-control me-2" placeholder="ابحث عن عضو...">
      <button class="btn btn-outline-primary">
        <i class="fa-solid fa-search"></i>
      </button>
    </form>

    <!-- عدد الأعضاء -->
    <span class="badge bg-primary p-2 fs-6">
      عدد الأعضاء : <?php echo countWhere('users'); ?>
    </span>
  </div>

  <!-- جدول عرض الأعضاء -->
  <div class="card shadow-sm">
    <div class="card-body">
      <table class="table table-striped align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>الصورة</th>
            <th>اسم المستخدم</th>
            <th>البريد الإلكتروني</th>
            <th>الاسم الكامل</th>
            <th>تاريخ التسجيل</th>
            <th class="text-center">الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          foreach ($members as $member): ?>
            <tr>
              <td><?= $i++; ?></td>
              <td>
                <img src="uploads/<?= htmlspecialchars($member['image']) ?: 'default.png'; ?>" width="60" height="60" class="rounded">
              </td>
              <td><?php echo htmlspecialchars($member['Username']); ?></td>
              <td><?php echo htmlspecialchars($member['Email']); ?></td>
              <td><?php echo htmlspecialchars($member['FullName']); ?></td>
              <td><?php echo htmlspecialchars($member['date']); ?></td>
              <td class="text-center">
                <a href="members.php?do=edit&userid=<?php echo $member['id']; ?>"
                  class="btn btn-sm btn-warning me-1">
                  <i class="fa-solid fa-pen-to-square"></i> تعديل
                </a>

                <a href="members.php?do=delete&userid=<?php echo $member['id']; ?>"
                  class="btn btn-sm btn-danger me-1"
                  onclick="return confirm('هل أنت متأكد من حذف هذا العضو؟');">
                  <i class="fa-solid fa-trash"></i> حذف
                </a>

                <?php if ($member['RegStatus'] == 0): ?>
                  <a href="members.php?do=active&userid=<?php echo $member['id']; ?>"
                    class="btn btn-sm btn-success"
                    onclick="return confirm('هل أنت متأكد من تفعيل هذا العضو؟');">
                    <i class="fa-solid fa-check"></i> تفعيل
                  </a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>