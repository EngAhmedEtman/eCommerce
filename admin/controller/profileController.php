<?php

function handleProfile($id)
{

    $user = findBy('users',$id);

    //تخزين البيانات لارساله لصفحة ال view
    $data = [
        'user' => $user,
        'pageTitle' => 'الملف الشخصي'
    ];

    // عرض الداتا
    loadView('profile', $data);
}