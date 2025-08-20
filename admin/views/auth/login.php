<?php showMessage(); ?>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2 class="text-center mb-4">تسجيل الدخول</h2>
            <p class="text-center text-muted">مرحباً بك في لوحة التحكم</p>
        </div>
        
        <form class="login-form" action="index.php?do=login" method="POST">
            <div class="form-group mb-3">
                <label class="form-label">اسم المستخدم</label>
                <input class="form-control" 
                       type="text" 
                       name="user" 
                       placeholder="أدخل اسم المستخدم" 
                       autocomplete="off"
                       required>
            </div>
            
            <div class="form-group mb-4">
                <label class="form-label">كلمة المرور</label>
                <input class="form-control" 
                       type="password" 
                       name="pass" 
                       placeholder="أدخل كلمة المرور" 
                       autocomplete="off"
                       required>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    دخول
                </button>
            </div>
        </form>
        
        <div class="login-footer mt-4 text-center">
            <small class="text-muted">
                © <?php echo date('Y'); ?> - جميع الحقوق محفوظة
            </small>
        </div>
    </div>
</div>

<style>
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.login-card {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
}

.login-header h2 {
    color: #333;
    font-weight: 600;
}

.form-control {
    padding: 0.75rem;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 8px;
    padding: 0.75rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}
</style>