<?php 

function handleLoginShow()
{
    auth(null ,'dashboard.php');
        $data = [
        'pageTitle' => 'Login'
    ];
    loadView('auth/login', $data);
}

function handleLoginProcess()
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    redirectTo('index.php');
    return;
    }

        $data = [
            'username' => $_POST['user'] ?? '',
            'password' => $_POST['pass'] ?? '',
        ];

        $labels = [
        'username' => 'اسم المستخدم',
        'password' => 'كلمة المرور'
    ];

        $rules = [
        'username' => ['require'],
        'password' => ['require']
    ];

    $errors = validation($data, $rules, $labels);
    if (!empty($errors)) {
        checkErrors($errors, 'index.php');
        return;
    }

        // التحقق من المستخدم
    $hashedPass = sha1($data['password']);
    $user = checkUserFound($data['username'],$hashedPass);

    if($user)
    {   //تسجيل الدخول

        $row = findBy('users','username','Username' );
        $_SESSION['GroupID'] = $row['GroupID'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $data['username'];
        redirectTo('dashboard.php');
    }else {
        setMessage('error', 'اسم المستخدم أو كلمة المرور غير صحيح');
        redirectTo('index.php');
    }
}


function handleLogout()
{
    session_start();
session_unset();
session_destroy();
redirectTo('index.php');
exit();
}