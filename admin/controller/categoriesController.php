<?php

function handleCategoriesIndex()
{
    $sort = sorting();
    $categories = showData('categories', "ORDER BY id " .$sort);
    $data = [
        'categories' => $categories,
        'pageTitle' => 'Categorie Page'
    ];

    loadView('categories/index', $data);
}


function handleCategoriesStore()
{
    // تجهيز الداتا
    $data = [
        'name'          => $_POST['name'] ?? '',
        'description'    => $_POST['description'] ?? '',
        'visibility'    => $_POST['visibility'] ?? '',
        'allowComment'  => $_POST['allowComment'] ?? '',
        'allowAds'  => $_POST['allowAds'] ?? '',
    ];
    $labels = [
        'name'          => 'اسم القسم',
        'description'    => 'وصف القسم',
        'visibility'    => 'إظهار القسم',
        'allowComment'  => 'إظهار التعليقات',
        'allowAds'  => 'إظهار الاعلانات',
    ];
    $rules = [
        'name' => ['require', 'min:3', 'max:20'],
        'description'    => ['require', 'max:100'],
        'visibility' => ['require'],
        'allowComment' => ['require'],
        'allowAds' => ['require'],
    ];
    $errors = validation($data, $rules, $labels);

    if (!empty($errors)) {
        checkErrors($errors, 'categories.php?do=add');
        return;
    }
    //التأكد من ان المستخدم غير موجود من قبل
    $existingCategorie = findBy('categories', $_POST['name'], 'name');
    if ($existingCategorie && $_POST['name'] == $existingCategorie['name']) {
        setMessage('error', 'هذا القسم موجود بالفعل');
        redirectTo('categories.php?do=manage');
        return;
    }

    //اضافة المستخدم
    if (insert('categories', $data)) {
        setMessage('success', 'تم انشاء القسم بنجاح');
        redirectTo('categories.php?do=manage');
    } else {
        setMessage('error', 'خطأ اثناء الانشاء');
        redirectTo('categories.php?do=add');
    }
}

function handleCategoriesEdit($id)
{
    if (!$id || !is_numeric($id) || $id <= 0) {
        setMessage('error', 'معرف القسم غير صالح');
        redirectTo('categories.php?do=manage');
        return;
    }

    $categorie = findBy('categories', $id);

    if (!$categorie) {
        setMessage('error', 'هذا القسم غير موجود');
        redirectTo('categories.php?do=manage'); // ✅ ارجع للصفحة الرئيسية
        return;
    }

    $data = [
        'categorie' => $categorie,
        'pageTitle' => 'Edit categorie'
    ];

    loadView('categories/edit', $data);
}


function handleCategoriesUpdate($id)
{

    $categorie = findBy('categories', $id);
    if (!$categorie) {
        setMessage('error', 'هذا القسم غير موجود');
        redirectTo('categories.php?do=manage');
        return;
    }

    $data = [
        'name'          => $_POST['name'] ?? '',
        'description'    => $_POST['description'] ?? '',
        'visibility'    => $_POST['visibility'] ?? '',
        'allowComment'  => $_POST['allowComment'] ?? '',
        'allowAds'  => $_POST['allowAds'] ?? '',
    ];
    $labels = [
        'name'          => 'اسم القسم',
        'description'    => 'وصف القسم',
        'visibility'    => 'إظهار القسم',
        'allowComment'  => 'إظهار التعليقات',
        'allowAds'  => 'إظهار الاعلانات',
    ];
    $rules = [
        'name' => ['require', 'min:3', 'max:20'],
        'description'    => ['require', 'max:100'],
        'visibility' => ['require'],
        'allowComment' => ['require'],
        'allowAds' => ['require'],
    ];
    $errors = validation($data, $rules, $labels);
    if (!empty($errors)) {
        checkErrors($errors, "categories.php?do=edit&userid=" . $id);
        return;
    }

    $existing_categorie = findBy('categorie', $_POST['name'], 'name');
    if ($existing_categorie && $_POST['name'] != $categorie['name']) {
        setMessage('error', 'هذا المستخدم موجود بالعفل ');
        redirectTo('categories.php?do=manage');
        return;
    }

    if (update($data, $id, 'categories') > 0) {
        setMessage('success', 'تم التعديل بنجاح');
        header("Location: categories.php?do=manage");
        exit();
    } else {
        setMessage('error', 'خطأ اثناء التعديل، لم يتم التعديل');
        redirectTo("categories.php?do=edit&userid=" . $id);
        exit();
    }
}


function handleCategoriesCreate()
{
    $data = [
        'pageTitle' => 'Add New Categorie'
    ];

    loadView('categories/create', $data);
}



function handleCategoriesDelete($id)
{

    $categorie =  findBy('categories', $id);

    if (!$categorie) {
        setMessage('error', 'هذا القسم غير موجود');
        redirectTo('categories.php?do=manage');
        return;
    }

    if (delete('categories', $id)) {
        setMessage('success', 'تم الحذف بنجاح');
    } else {
        setMessage('error', 'لم يتم الحذف');
    }
    redirectTo('categories.php?do=manage');
}

function sorting()
{
    $sortArray = ['ASC', 'DESC'];

    if (isset($_GET['sort'])) {
        $sort = strtoupper($_GET['sort']);
        if (in_array($sort, $sortArray)) {
            return $sort;
        }
    }
    return 'ASC';
}