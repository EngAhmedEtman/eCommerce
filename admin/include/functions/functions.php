<?php



function pageTitle()
{
    global $pageTitle;

    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo 'Default';
    }
}

function getMemberById($id)
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetch();
}


function updateMember(array $data)
{
    global $con;
    $stmt = $con->prepare("UPDATE users 
                            SET Username = ?, Email = ?, FullName = ?, password = ?
                            WHERE UserID = ?");
    $stmt->execute(array($data['username'], $data['email'], $data['full'], $data['password'], $data['id']));
    return  $stmt->rowCount();
}


function setMessage($type, $message)
{
    $_SESSION[$type] = $message;
}



function showMessage()
{
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



function checkUserFound($username, $hashedPass)
{
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


function checkNewPasswordFound($oldPassword, $newPassword)
{
    return  empty($newPassword) ?  $oldPassword :  sha1($newPassword);
}


function validation($values, $rules, $labels = [])
{
    $errors = [];

    foreach ($rules as $fieldName => $fieldRules) {
        // تنظيف أولي
        $raw   = $values[$fieldName] ?? null;
        $value = is_string($raw) ? trim($raw) : $raw;

        // اسم العرض (تعريب)
        $label = $labels[$fieldName] ?? $fieldName;

        foreach ($fieldRules as $rule) {
            if ($rule === 'require') {
                if ($value === null || $value === '') {
                    $errors[$fieldName][] = "$label مطلوب.";
                }
            } elseif (strpos($rule, 'max:') === 0) {
                $max = (int) explode(':', $rule)[1];
                if (mb_strlen((string)$value, 'UTF-8') > $max) {
                    $errors[$fieldName][] = "$label يجب ألا يزيد عن $max حروف.";
                }
            } elseif (strpos($rule, 'min:') === 0) {
                $min = (int) explode(':', $rule)[1];
                if (mb_strlen((string)$value, 'UTF-8') < $min) {
                    $errors[$fieldName][] = "$label يجب ألا يقل عن $min حروف.";
                }
            } elseif ($rule === 'phone') {
                if (!preg_match('/^01[0-9]{9}$/', (string)$value)) {
                    $errors[$fieldName][] = "$label يجب أن يكون رقم موبايل مصري صحيح.";
                }
            } elseif ($rule === 'email') {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$fieldName][] = "$label يجب أن يكون بريدًا إلكترونيًا صحيحًا.";
                }
            } elseif ($rule === 'password') {
                if (mb_strlen((string)$value, 'UTF-8') < 6) {
                    $errors[$fieldName][] = "$label خطأ في كلمة المرور";
                }
            } elseif ($rule === 'int') {
                if (!filter_var($value, FILTER_VALIDATE_INT) && $value !== 0 && $value !== '0') {
                    $errors[$fieldName][] = "$label يجب أن يكون رقمًا صحيحًا.";
                }
            }
        }
    }

    return $errors;
}



function checkErrors($errors, $url)
{
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



function showData()
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1 ORDER BY UserID ASC");
    $stmt->execute();
    return $stmt->fetchAll();
}

function insertDataInDatabase()
{
    global $con;
    try {
        $stmt = $con->prepare("INSERT INTO users (Username,Password,Email,FullName)
                                VALUES(:user, :pass, :email, :name)");

        $stmt->execute(array(
            'user' => $_POST['username'],
            'pass' => sha1($_POST['newPassword']),
            'email' => $_POST['email'],
            'name' => $_POST['full'],
        ));

        return true; // نجاح الإدخال
    } catch (PDOException $e) {
        return false; // فشل الإدخال
    }
}



function deleteUser($row)
{
    global $con;

        try {
        $stmt = $con->prepare("DELETE FROM users WHERE UserID = ? ");
        $stmt->execute([$row['UserID']]);
        return true ;
        }catch (PDOException $e) {
        return false;
    }
}



