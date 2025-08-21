<?php showMessage() ; ?>

<div class="container mt-5">
    <!-- كارت إضافة المنتج -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6"> <!-- نفس حجم صفحة التعديل -->
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0"><i class="fa-solid fa-circle-plus me-2"></i> إضافة منتج جديد</h4>
                </div>
                <div class="card-body p-4">

            <form action="products.php?do=insert" method="POST" enctype="multipart/form-data">

                <!-- اسم المنتج -->
                <div class="mb-3">
                    <label for="productName" class="form-label">اسم المنتج</label>
                    <input type="text" id="productName" name="name" class="form-control" placeholder="ادخل اسم المنتج">
                </div>

                <!-- الوصف -->
                <div class="mb-3">
                    <label for="productDesc" class="form-label">الوصف</label>
                    <textarea id="productDesc" name="description" rows="4" class="form-control" placeholder="ادخل وصف المنتج"></textarea>
                </div>

                <!-- السعر -->
                <div class="mb-3">
                    <label for="productPrice" class="form-label">السعر</label>
                    <input type="number" id="productPrice" name="price" class="form-control" placeholder="ادخل سعر المنتج">
                </div>

                <!-- الصورة -->
                <div class="mb-3">
                    <label for="productImage" class="form-label">الصورة</label>
                    <input type="file" id="productImage" name="image" class="form-control">
                </div>

                <!-- الحالة -->
                <div class="mb-3">
                    <label for="productStatus" class="form-label">الحالة</label>
                    <select id="productStatus" name="status" class="form-select">
                        <option value="1">مفعل</option>
                        <option value="0">غير مفعل</option>
                    </select>
                </div>
                
                <!-- القسم -->
                <div class="mb-3">
                    <label for="productStatus" class="form-label">القسم</label>
                    <select id="productStatus" name="categorieId" class="form-select">
                        <option value="" disabled selected>اختار القسم</option>
                    <?php  
                    foreach($categories as $categorie){
                        echo "<option value ='" . $categorie['id'] . "'> ". $categorie['name'] ." </option>";
                    };

                    ?>

                    </select>
                </div>

                <!-- الأزرار -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fa-solid fa-check me-2"></i> إضافة المنتج
                    </button>
                    <a href="products.php" class="btn btn-secondary px-4">
                        <i class="fa-solid fa-arrow-left me-2"></i> رجوع
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
