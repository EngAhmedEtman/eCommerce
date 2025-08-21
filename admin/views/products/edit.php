<?php showMessage(); ?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center">
          <h4 class="mb-0"><i class="fa-solid fa-box-open me-2"></i> <?php echo htmlspecialchars($pageTitle); ?></h4>
        </div>
        <div class="card-body p-4">

          <form action="products.php?do=update&id=<?php $product['id'] ;?>" method="POST" enctype="multipart/form-data">

            <!-- اسم المنتج -->
            <div class="mb-3">
              <label for="productName" class="form-label">اسم المنتج</label>
              <input type="text" id="productName" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>">
              <input type="hidden" name="id" class="form-control" value="<?php echo htmlspecialchars($product['id']); ?>">
            </div>

            <!-- الوصف -->
            <div class="mb-3">
              <label for="productDesc" class="form-label">الوصف</label>
              <textarea id="productDesc" name="description" rows="4" class="form-control"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <!-- السعر -->
            <div class="mb-3">
              <label for="productPrice" class="form-label">السعر</label>
              <input type="number" id="productPrice" name="price" class="form-control" value="<?php echo htmlspecialchars($product['price']); ?>">
            </div>

            <!-- الصورة -->
            <div class="mb-3">
              <label for="productImage" class="form-label">الصورة</label>
              <input type="file" id="productImage" name="image" class="form-control">
              <div class="mt-3">
                <p class="mb-1 fw-bold">الصورة الحالية:</p>
                <img src="uploads/<?= htmlspecialchars($product['image']) ?? $product['image'] ?>" alt="صورة المنتج" class="img-thumbnail" width="200">
              </div>
            </div>

            <!-- الحالة -->
            <div class="mb-3">
              <label for="productStatus" class="form-label">الحالة</label>
              <select id="productStatus" name="status" class="form-select">
                <option value="1" <?= $product['status'] == 1 ? 'selected' : '' ?>>مفعل</option>
                <option value="0" <?= $product['status'] == 0 ? 'selected' : '' ?>>غير مفعل</option>
              </select>
            </div>


            <!-- القسم -->

            <div class="mb-3">
              <label for="productCategory" class="form-label">القسم</label>
              <select id="productCategory" name="categorieId" class="form-select">
                <?php foreach ($categories as $categorie): ?>
                  <option value="<?= $categorie['id'] ?>"
                    <?= ($product['categorieId'] == $categorie['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categorie['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>



            <!-- الأزرار -->
            <div class="text-center mt-4">
              <button type="submit" class="btn btn-success px-4">
                <i class="fa-solid fa-check me-2"></i> حفظ التعديلات
              </button>
              <a href="products.php" class="btn btn-secondary px-4">
                <i class="fa-solid fa-arrow-left me-2"></i> رجوع
              </a>
            </div>
          </form>

        </div>
      </div>
    </div>