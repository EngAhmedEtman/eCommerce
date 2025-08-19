<?php

$do = $_GET['do'] ?? 'manage';
switch ($do) {

    case 'manage':

        $query = '';
        if(isset($_GET['page']) && $_GET['page'] =='pending' )
        {
        $query =  'AND RegStatus = 0';
        $rows = showData('users', "WHERE GroupID !=1 $query ORDER BY id ASC ");
        renderMembersTable($rows);
        break;
        }else {
        $rows = showData('users', 'WHERE GroupID !=1 ORDER BY id ASC');
        renderMembersTable($rows);
        break;
        }

    case 'add':
        showEditForm('add');
        break;

    case 'insert':

        // validation
        // لازم ال keys 
        //تكون مكتوبه زي الداتا بيز بالضبط 

        $data = [
            // 'id'       => $_POST['userid'] ?? '',
            'Username' => $_POST['username'] ?? '',
            'Email'    => $_POST['email'] ?? '',
            'FullName'     => $_POST['full'] ?? '',
            'password' => $_POST['newPassword'] ?? '',
        ];

        $labels = [
            'Username' => 'اسم المستخدم',
            'Email'    => 'البريد الإلكتروني',
            'FullName'     => 'الاسم الكامل',
            'password' => 'كلمة المرور',
        ];

        $rules = [
            'Username' => ['require', 'min:3', 'max:20'],
            'Email'    => ['require', 'email', 'max:100'],
            'FullName'     => ['require', 'min:6', 'max:50'],
            'password' => ['require', 'password'],
        ];

        $errors = validation($data, $rules, $labels);
        $url = "members.php?manage";
        checkErrors($errors, $url);

        $repeted = findBy('users', $_POST['username'], 'Username');
        if ($_POST['username'] != $repeted['Username']) {
            if ((insertUser($data))) {
                setMessage('success', 'تم انشاء المستخدم بنجاح');
                header('location:members.php?do=manage');
                exit();
            } else {
                setMessage('error', 'خطأ اثناء الاضافة');
                header('location:members.php?do=add');
                exit();
            }
            break;
        } else {
            setMessage('error', 'هذا المتسخدم موجود بالفعل');
            header('location:members.php?do=manage');
            exit();
        }


    case 'edit':
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $row = findBy('users', $userid);

        if ($row) {
            showEditForm('edit', $row);
        } else {
            setMessage('error','هذا المستخدم غير موجود');
            header('location:members.php?do=manage');

        }
        break;


    case 'update':
        echo "<h1 class='text-center'>Update Member</h1>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $pass = checkNewPasswordFound($oldPassword, $newPassword);

            $userid = $_POST['userid'] ?? 0;

            // validation
            $data = [
                // 'id'       => $_POST['userid'] ?? '',
                'Username' => $_POST['username'] ?? '',
                'Email'    => $_POST['email'] ?? '',
                'FullName'     => $_POST['full'] ?? '',
                'password' => $pass ?? '',
            ];

            $labels = [
                'Username' => 'اسم المستخدم',
                'Email'    => 'البريد الإلكتروني',
                'FullName'     => 'الاسم الكامل',
                'password' => 'كلمة المرور',
            ];

            $rules = [
                'Username' => ['require', 'min:3', 'max:20'],
                'Email'    => ['require', 'email', 'max:100'],
                'FullName'     => ['require', 'min:3', 'max:50'],
                'password' => ['password'],
            ];

            $errors = validation($data, $rules, $labels);
            $url = "members.php?do=edit&userid=" . $userid;
            checkErrors($errors, $url);

            // التأكد من ان اسم التسخدم غير موجود من قبل
            $repeted = findBy('users', $_POST['username'], 'Username');
            if ($_POST['username'] != $repeted['Username']) {
                if (update($data, $userid, 'users') > 0) {
                    setMessage('success', 'تم التعديل بنجاح');
                    header("Location: members.php?do=manage");
                    exit();
                } else {
                    setMessage('error', 'خطأ اثناء التعديل، ءلم يتم التعديل');
                    header("Location: members.php?do=edit&userid=" . $userid);
                    exit();
                }
                break;
            } else {
                setMessage('error', 'هذا المتسخدم موجود بالفعل');
                header('location:members.php?do=manage');
                exit();
            }
        }


    case 'delete':
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $row = findBy('users', $userid);
        if (delete('users', $row)) {
            setMessage('success', 'تم الحذف بنجاح');
            header('location:members.php?do=manage');
            break;
        } else {
            setMessage('error', 'لم يتم الحذف');
            header('location:members.php?do=manage');
            break;
        }

    case 'active':
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        if(updateSingleColumn('users','RegStatus',1,$userid) > 0){
            setMessage('success', 'تم تحديث الحالة بنجاح');
            header('location:members.php?do=manage');
            break;
        }
        else{
            setMessage('error', 'خطأ اثناء التحديث');
            header('location:members.php?do=manage');
            break;
        }


    default:
        echo "<div class='alert alert-danger'>Invalid Action</div>";
}
