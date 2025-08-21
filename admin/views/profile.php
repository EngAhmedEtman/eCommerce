<!-- <?php showMessage(); ?> -->

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h3>الملف الشخصي</h3>
                </div>
                <div class="card-body">
                    <!-- صورة المستخدم -->
                    <div class="text-center mb-4">
                        <img src="uploads/<?= htmlspecialchars($user['image'] ?? 'default.png') ?>" 
                             alt="صورة المستخدم" 
                             class="rounded-circle" width="120" height="120">
                    </div>

                    <!-- بيانات المستخدم -->
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">الاسم الكامل:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext"><?= htmlspecialchars($user['Username']) ?></p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">البريد الإلكتروني:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext"><?= htmlspecialchars($user['Email']) ?></p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">رقم الهاتف:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext"><?= htmlspecialchars($user['phone'] ?? '-') ?></p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">تاريخ الانضمام:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext"><?= date("d-m-Y", strtotime($user['date'])) ?></p>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="members.php?do=edit&userid=<?php echo $_SESSION['id']; ?>" class="btn btn-primary">تعديل الملف الشخصي</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


