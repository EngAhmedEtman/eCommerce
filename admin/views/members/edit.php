<?php showMessage(); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-3">
                <div class="card-body p-4">
                    <h1 class="text-center mb-4"><?php echo $pageTitle; ?></h1>
                    <form action="members.php?do=update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="userid" value="<?php echo $user['id']; ?>">

                        <div class="mb-3">
                            <label class="form-label">اسم المستخدم</label>
                            <input type="text" class="form-control"
                                name="username"
                                value="<?php echo htmlspecialchars($user['Username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">كلمة المرور</label>
                            <input type="hidden" name="oldPassword" value="<?php echo $user['password']; ?>">
                            <input type="password" class="form-control" name="newPassword">
                            <small class="text-muted">اتركه فارغا اذا لم تريد تغيير كلمة السر</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">البريد الالكتروني</label>
                            <input type="email" class="form-control"
                                name="email"
                                value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الاسم كامل</label>
                            <input type="text" class="form-control"
                                name="full"
                                value="<?php echo htmlspecialchars($user['FullName']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control"
                                name="phone"
                                value="<?= htmlspecialchars($user['phone']); ?>" required>
                        </div>

                        <!-- الصورة -->
                        <div class="mb-3">
                            <label for="userImage" class="form-label">الصورة</label>
                            <input type="file" id="userImage" name="image" class="form-control">
                            <div class="mt-3">
                                <p class="mb-1 fw-bold">الصورة الحالية:</p>
                                <img src="uploads/<?= htmlspecialchars($user['image'] ?: 'default.png'); ?>" alt="صورة المنتج" class="img-thumbnail" width="200">
                            </div>
                        </div>


                        <div class="d-grid">
                            <input type="submit" value="تعديل بيانات المستخدم" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>