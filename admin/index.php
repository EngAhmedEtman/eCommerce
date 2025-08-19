<?php
session_start();

$noNavbar = '';
$pageTitle = 'Login';

include 'init.php';

auth(null , 'dashboard.php') ;

//chech if user coming from http post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedPass = sha1($password);

    //chech if the user in the database
    $row = checkUserFound($username, $hashedPass);
    if ($row) {
        $_SESSION['GroupID'] = $row['GroupID'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['Username'];
        header('location:dashboard.php');
        exit;
    }
}

?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="off">
    <input class="btn btn-primary d-grid w-100" type="submit" value="login">
</form>

<?php include $tpl . "footer.php"; ?>