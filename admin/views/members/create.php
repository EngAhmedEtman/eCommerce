<?php showMessage(); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-3">
                <div class="card-body p-4">
                    <h1 class="text-center mb-4"><?php echo $pageTitle; ?></h1>
                    <form action="members.php?do=insert" method="POST">
                        <div class="mb-3">
                            <label class="form-label">اسم المتخدم</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control" name="newPassword" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">البريد الالكتروني</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الاسم كامل</label>
                            <input type="text" class="form-control" name="full" required>
                        </div>
                        <div class="d-grid">
                            <input type="submit" value="اضافة مستخدم" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>