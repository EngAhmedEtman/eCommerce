<?php

function handleMembersIndex()
{
    $query = '';
    if (isset($_GET['page']) && $_GET['page'] == 'pending') {
        $query = 'AND RegStatus = 0';
    }

    $members = showData('users', "WHERE GroupID != 1 $query ORDER BY id ASC");

    //تخزين البيانات لارساله لصفحة ال view
    $data = [
        'members' => $members,
        'pageTitle' => 'ادارة الاعضاء'
    ];

    // عرض الداتا
    loadView('members/index', $data);
}

function handleMembersCreate() {
    $data = [
        'pageTitle' => 'اضافة مستخدم جديد'
    ];
    
    loadView('members/create', $data);
}

function handleMembersStore()
{
   // تجهيز الداتا
       $uploadedImage = handleUserImage();

        $data = [
        'Username' => $_POST['username'] ?? '',
        'Email'    => $_POST['email'] ?? '',
        'FullName' => $_POST['full'] ?? '',
        'image' => $uploadedImage ?? '',
        'phone' => $_POST['phone'] ?? '',
        'password' => sha1($_POST['newPassword']) ?? '',
    ];
    $labels = [
        'Username' => 'اسم المتتخدم',
        'Email'    => 'البريد الالكتروني',
        'FullName' => 'الاسم الكامل',
        'image' => 'الصورة',
        'phone' => 'رقم الهاتف',
        'password' => 'كلمة المرور',
    ];
    $rules = [
        'Username' => ['require', 'min:3', 'max:20'],
        'Email'    => ['require', 'email', 'max:100'],
        'FullName' => ['require', 'min:6', 'max:50'],
        'phone' => ['require', 'phone'],
        'image' => [],
        'password' => ['require', 'password'],
    ];
    $errors = validation($data, $rules, $labels);
    
    if (!empty($errors)) {
        checkErrors($errors, 'members.php?do=add');
        return;
    }
    //التأكد من ان المستخدم غير موجود من قبل
    $existing_user = findBy('users', $_POST['username'], 'Username');
    if ($existing_user && $_POST['username'] == $existing_user['Username']) {
        setMessage('error', 'هذا المستخدم موجود بالفعل');
        redirectTo('members.php?do=manage');
        return;
    }

    //اضافة المستخدم
    if (insertUser($data)) {
        setMessage('success', 'تم انشاء المستخدم بنجاح');
        redirectTo('members.php?do=manage');
    } else {
        setMessage('error', 'خطأ اثناء الاضافة');
        redirectTo('members.php?do=add');
    }

}


function handleMemberEdit($userid)
{
    if (!$userid || !is_numeric($userid) || $userid <= 0) {
        setMessage('error', 'معرف المستخدم غير صالح');
        redirectTo('members.php?do=manage');
        return;
    }
    
    $user = findBy('users', $userid);
    
    if (!$user) {
        setMessage('error', 'هذا المستخدم غير موجود');
        redirectTo('members.php?do=manage'); // ✅ ارجع للصفحة الرئيسية
        return;
    }
    
    $data = [
        'user' => $user,
        'pageTitle' => 'تعديل المستخدم'
    ];
    
    loadView('members/edit', $data);
     
}


function handleMembersUpdate($userid)
{

    $user = findBy('users', $userid);
    if (!$user) {
        setMessage('error', 'هذا المستخدم غير موجود');
        redirectTo('members.php?do=manage');
        return;
    }
    // روﺮﻤﻟا ﺔﻤﻠﻛ ﺔﺠﻟﺎﻌﻣ
    $old_password = $_POST['oldPassword'];
    $new_password = $_POST['newPassword'];
    $password = checkNewPasswordFound($old_password, $new_password);

        $uploadedImage = handleUserImage();

    $data = [
        'Username' => $_POST['username'] ?? '',
        'Email'    => $_POST['email'] ?? '',
        'FullName' => $_POST['full'] ?? '',
        'image' => $uploadedImage ?: $user['image'],
        'phone' => $_POST['phone'] ?? '',
        'password' => $password ?? '',
    ];
    $labels = [
        'Username' => 'اسم المستخدم',
        'Email'    => 'البريد الالكتروني',
        'FullName' => 'الاسم كامل',
        'image' => 'صورة المستخدم',
        'phone' => 'رقم الهاتف',
        'password' => 'كلمة السر',
    ];
    $rules = [
        'Username' => ['require', 'min:3', 'max:20'],
        'Email'    => ['require', 'email', 'max:100'],
        'FullName' => ['require', 'min:3', 'max:50'],
        'phone' => ['require', 'phone'],
        'image' => [],
        'password' => ['password'],
    ];

    $errors = validation($data, $rules, $labels);
    if (!empty($errors)) {
        checkErrors($errors, "members.php?do=edit&userid=" . $userid);
        return;
    }

    $existing_user = findBy('users', $_POST['username'], 'Username');
    if ($existing_user && $_POST['username'] != $user['Username']) {
        setMessage('error', 'هذا المستخدم موجود بالعفل ');
        redirectTo('members.php?do=manage');
        return;
    }

    if (update($data, $userid, 'users') > 0) {
        $_SESSION['userImage'] = $data['image'];
        setMessage('success', 'تم التعديل بنجاح');
        header("Location: members.php?do=manage");
        exit();
    } else {
        setMessage('error', 'خطأ اثناء التعديل، لم يتم التعديل');
        redirectTo("members.php?do=edit&userid=" . $userid);
        exit();
    }
}


function handleMembersDelete($userid)
{

    $user =  findBy('users', $userid);

    if (!$user) {
        setMessage('error', 'هذا المستخدم غير موجود');
        redirectTo('members.php?do=manage');
        return;
    }

    if (delete('users', $userid)) {
        setMessage('success', 'تم الحذف بنجاح');
    } else {
        setMessage('error', 'لم يتم الحذف');
    }
    redirectTo('members.php?do=manage');
}


function handleMembersActive($userid)
{

    if (updateSingleColumn('users', 'RegStatus', 1, $userid) > 0) {
        setMessage('success', 'تم تحديث الحالة بنجاح');
    } else {
        setMessage('error', 'خطأ اثناء التحديث');
    }
    redirectTo('members.php?do=manage');
}


function handleUserImage()
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