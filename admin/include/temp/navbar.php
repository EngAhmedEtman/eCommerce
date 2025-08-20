<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <!-- اللوجو -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
            <i class="fa-solid fa-cubes me-2 text-primary"></i> لوحة التحكم
        </a>

        <!-- زر الموبايل -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="تبديل القائمة">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- روابط النافبار -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo $pageTitle == 'categories' ? 'active' : '' ?>" href="categories.php">
                        <i class="fa-solid fa-list me-1"></i> الأقسام
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $pageTitle == 'members' ? 'active' : '' ?>" href="members.php">
                        <i class="fa-solid fa-users me-1"></i> الأعضاء
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $pageTitle == 'products' ? 'active' : '' ?>" href="products.php">
                        <i class="fa-solid fa-box-open me-1"></i> المنتجات
                    </a>
                </li>
            </ul>

            <!-- جزء المستخدم -->
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- صورة المستخدم -->
                            <img src="uploads/avatars/<?php echo $_SESSION['user_image'] ?? 'default.png'; ?>"
                                class="rounded-circle me-2" alt="User Avatar" width="32" height="32">
                            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        </a>



                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fa-solid fa-user me-2"></i> الملف الشخصي
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="members.php?do=edit&userid=<?php echo $_SESSION['id']; ?>">
                                    <i class="fa-solid fa-user-pen me-2"></i> تعديل الملف الشخصي
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="settings.php">
                                    <i class="fa-solid fa-gear me-2"></i> الإعدادات
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="index.php?do=logout">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> تسجيل الخروج
                                </a>

                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-2" href="login.php">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> تسجيل الدخول
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>