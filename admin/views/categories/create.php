<?php showMessage(); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">إضافة قسم جديد</h4>
                </div>

                <div class="card-body p-4">
                    <form action="categories.php?do=insert" method="POST">
                        <!-- Category Name -->
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">اسم القسم</label>
                            <input type="text"
                                    name = "name"
                                class="form-control"
                                id="categoryName"
                                placeholder="اكتب اسم القسم"
                                required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="categoryDesc" class="form-label">الوصف</label>
                            <textarea class="form-control"
                                id="categoryDesc"
                                name = "dscription"
                                rows="3"
                                placeholder="اكتب وصف مختصر للقسم"></textarea>
                        </div>

                        <!-- Visibility -->
                        <div class="mb-3">
                            <label class="form-label d-block">إظهار القسم</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="visibility"
                                    id="visibleYes"
                                    value="1" checked>
                                <label class="form-check-label" for="visibleYes">نعم</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="visibility"
                                    id="visibleNo"
                                    value="0">
                                <label class="form-check-label" for="visibleNo">لا</label>
                            </div>
                        </div>

                        <!-- Allow Comments -->
                        <div class="mb-3">
                            <label class="form-label d-block">السماح بالتعليقات</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="allowComment"
                                    id="commentYes"
                                    value="1" checked>
                                <label class="form-check-label" for="commentYes">مسموح</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="allowComment"
                                    id="commentNo"
                                    value="0">
                                <label class="form-check-label" for="commentNo">غير مسموح</label>
                            </div>
                        </div>

                        <!-- Allow Comments -->
                        <div class="mb-3">
                            <label class="form-label d-block">السماح بالتعليقات</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="allowAds"
                                    id="AdsYes"
                                    value="1" checked>
                                <label class="form-check-label" for="AdsYes">مسموح</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="allowAds"
                                    id="AdsNo"
                                    value="0">
                                <label class="form-check-label" for="AdsNo">غير مسموح</label>
                            </div>
                        </div>


                        <!-- Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-plus-circle me-2"></i> إضافة القسم
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>