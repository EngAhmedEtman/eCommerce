<?php

function handleProductsIndex()
{

    $condition = handleProductFilter();

    $products = showData('products', $condition ?? '');
    $categories = showData('categories');

    //تخزين البيانات لارساله لصفحة ال view
    $data = [
        'products' => $products,
        'categories' => $categories,
        'pageTitle' => 'إدارة المنتجات'
    ];

    // عرض الداتا
    loadView('products/index', $data);
}

function handleProductsCreate()
{

    $categories = showData('categories');

    $data = [
        'categories' => $categories,
        'pageTitle' => 'إضافة منتج جديد'
    ];

    loadView('products/create', $data);
}

function handleProductsStore()
{
    // تجهيز الداتا
    $uploadedImage = handleProductImage();

    $data = [
        'name'          => $_POST['name'] ?? '',
        'description'    => $_POST['description'] ?? '',
        'price'    => $_POST['price'] ?? '',
        'image'  => $uploadedImage ?? '',
        'status'  => $_POST['status'] ?? '',
        'categorieId'  => $_POST['categorieId'] ?? '',
    ];
    $labels = [
        'name'          => 'اسم المنتج',
        'description'    => 'وصف المنتج',
        'price'    => 'سعر المنتج',
        'image'  => 'صورة المنتج',
        'status'  => 'حالة المنتج',
        'categorieId'  => 'القسم',
    ];
    $rules = [
        'name' => ['require', 'min:3', 'max:20'],
        'description'    => ['require', 'max:100'],
        'price' => ['require'],
        'image' => ['require'],
        'status' => ['require'],
        'categorieId' => ['require'],
    ];
    $errors = validation($data, $rules, $labels);

    if (!empty($errors)) {
        checkErrors($errors, 'products.php?do=add');
        return;
    }

    //اضافة المنتج
    if (insert('products', $data)) {
        setMessage('success', 'تم انشاء القسم بنجاح');
        redirectTo('products.php?do=manage');
    } else {
        setMessage('error', 'خطأ اثناء الانشاء');
        redirectTo('products.php?do=add');
    }
}


function handleProductEdit($id)
{
    if (!$id || !is_numeric($id) || $id <= 0) {
        setMessage('error', 'معرف المنتج غير صالح');
        redirectTo('products.php?do=manage');
        return;
    }

    $product = findBy('products', $id);

    if (!$product) {
        setMessage('error', 'معرف المنتج غير موجود');
        redirectTo('products.php?do=manage');
        return;
    }

    $categories = showData('categories');

    $data = [
        'product' => $product,
        'categories' => $categories,
        'pageTitle' => 'تعديل المنتج',
    ];

    loadView('products/edit', $data);
}


function handleProductsUpdate($id)
{
    $product = findBy('products', $id);
    if (!$product) {
        setMessage('error', 'هذا المنتج غير موجود');
        redirectTo('products.php?do=manage');
        return;
    }

    $uploadedImage = handleProductImage();


    $data = [
        'name'          => $_POST['name'] ?? '',
        'description'    => $_POST['description'] ?? '',
        'price'    => $_POST['price'] ?? '',
        'image'  => $uploadedImage ?: $product['image'],
        'status'  => $_POST['status'] ?? '',
        'categorieId'  => $_POST['categorieId'] ?? '',
    ];
    $labels = [
        'name'          => 'اسم المنتج',
        'description'    => 'وصف المنتج',
        'price'    => 'سعر المنتج',
        'image'  => 'صورة المنتج',
        'status'  => 'حالة المنتج',
        'categorieId'  => 'القسم',
    ];
    $rules = [
        'name' => ['require', 'min:3', 'max:20'],
        'description'    => ['require', 'max:100'],
        'price' => ['require'],
        'image' => [''],
        'status' => ['require'],
        'categorieId' => ['require'],
    ];
    $errors = validation($data, $rules, $labels);
    if (!empty($errors)) {
        checkErrors($errors, "products.php?do=edit&id=" . $id);
        return;
    }


    if (update($data, $id, 'products') > 0) {
        setMessage('success', 'تم التعديل بنجاح');
        redirectTo('products.php?do=manage');
        exit();
    } else {
        setMessage('error', 'خطأ اثناء التعديل، لم يتم التعديل');
        redirectTo("products.php?do=edit&id=" . $id);
        exit();
    }
}



function handleProductsDelete($id)
{
    $product =  findBy('products', $id);

    if (!$product) {
        setMessage('error', 'هذا المنتج غير موجود');
        redirectTo('products.php?do=manage');
        return;
    }

    if (delete('products', $id)) {
        setMessage('success', 'تم الحذف بنجاح');
    } else {
        setMessage('error', 'لم يتم الحذف');
    }
    redirectTo('products.php?do=manage');
}


function handleProductFilter()
{

    $condition = '';

    if (isset($_GET['search']) && $_GET['search'] != null) {
        $name = $_GET['search'];
        $condition .= "WHERE name LIKE '%{$name}%' ";
    }

    if (isset($_GET['status']) && $_GET['status'] != null) {
        if ($condition != '') {
            $condition .= 'AND ';
        }
        $status = $_GET['status'];
        $condition .= "WHERE status LIKE '%{$status}%' ";
    }

    if (isset($_GET['categorie']) && $_GET['categorie'] != null) {
        if ($condition != '') {
            $condition .= 'AND ';
        }
        $categorie = $_GET['categorie'];
        $condition .= "WHERE categorieId LIKE '%{$categorie}%' ";
    }
    return $condition;
}


function handleProductImage()
{

    // لو فيه صورة
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        // بيانات عن الصورة
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $tmpName   = $_FILES['image']['tmp_name'];

        // الامتدادات المسموحة
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (in_array($ext, $allowedExt)) {
            // اسم جديد للصورة (عشان ميحصلش تعارض)
            $newName = uniqid() . "." . $ext;

            // المجلد اللي هتتخزن فيه
            $uploadDir = "uploads/";

            // لو المجلد مش موجود اعمله
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // انقل الصورة للمكان الجديد
            if (move_uploaded_file($tmpName, $uploadDir . $newName)) {
                return $newName; // رجع اسم الصورة
            } else {
                return false; // فشل الرفع
            }
        } else {
            return false; // امتداد غير مسموح
        }
    } else {
        return false; // مفيش صورة
    }
}
