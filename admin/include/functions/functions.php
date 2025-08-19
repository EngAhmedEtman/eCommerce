<?php

function auth($redirect_if_not_logged = null, $redirect_if_logged = null, $guard = 'username'){
    if (!isset($_SESSION[$guard])) {
        if ($redirect_if_not_logged !== null) {
            header('location: ' . $redirect_if_not_logged);
            exit();
        }
    } else {
        if ($redirect_if_logged !== null) {
            header('location: ' . $redirect_if_logged);
            exit();
        }
    }
}




function pageTitle(){
    global $pageTitle;

    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo 'Default';
    }
}



function find($table, $id) {
    global $con;
    $stmt = $con->prepare("SELECT * FROM $table WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetch();
}


function update(array $data, $id, $table = 'users'){
    global $con;

    if (empty($data)) {
        return false; // مفيش حاجة تتحدث
    }

    $columns = array_keys($data);
    $placeholders = array_map(fn($col) => "$col = :$col", $columns);

    // أضف الـ id للبيانات قبل التنفيذ
    $data['id'] = $id;

    // هنا لازم تكتب العمود الاساسي ثابت (id) مش المتغير $id
    $stmt = $con->prepare("UPDATE $table SET " . implode(", ", $placeholders) . " WHERE id = :id");

    $stmt->execute($data);

    return $stmt->rowCount();
}




function setMessage($type, $message){
    $_SESSION[$type] = $message;
}



function showMessage(){
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['info'])) {
        echo '<div class="alert alert-warning">' . $_SESSION['info'] . '</div>';
        unset($_SESSION['info']);
    }
}



function checkUserFound($username, $hashedPass){
    global $con;
    $stmt = $con->prepare("SELECT 
                            *
                        FROM 
                            users 
                        WHERE 
                            Username = ? 
                        AND 
                            password = ? 
                        AND 
                            GroupID = 1
                        Limit 1
                            ");
    $stmt->execute(array($username, $hashedPass));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        return $row; // رجع بيانات المستخدم
    }
    return false;
}


function checkNewPasswordFound($oldPassword, $newPassword){
    return  empty($newPassword) ?  $oldPassword :  sha1($newPassword);
}


function checkErrors($errors, $url){
    if (!empty($errors)) {
        foreach ($errors as $field => $msgs) {
            foreach ($msgs as $msg) {
                setMessage('error', $msg);
            }
        }
        header("Location: $url");
        exit();
    }
}


function showData($table , $condition = ""){
    global $con;
    $stmt = $con->prepare("SELECT * FROM $table $condition ");
    $stmt->execute();
    return $stmt->fetchAll();
}


function insert($table , $data){
    global $con;

    if (empty($data)) {
        return false; 
    }

    $columns = array_keys($data);
    $placeholders = array_map(fn($col) => ":$col", $columns);
    try{
    $stmt = $con->prepare("INSERT INTO $table (" . implode(', ', $columns) . ") 
        VALUES (" . implode(', ', $placeholders) . ")");

        $stmt->execute($data);

        return true;
    } catch (PDOException $e) {
        return false; 
    }
}

function delete($table ,$row){
    global $con;

    try {
        $stmt = $con->prepare("DELETE FROM $table WHERE id = ? ");
        $stmt->execute([$row['id']]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}


