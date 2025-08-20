<?php
session_start();

$noNavbar = '';
$pageTitle = 'Login';

include 'init.php';
include 'controller/authController.php';


$do = $_GET['do'] ?? 'show';

switch ($do) {
    case 'show':
        handleLoginShow();
        break;
        
    case 'login':
        handleLoginProcess();
        break;
        
    case 'logout':
        handleLogout();
        break;
        
    default:
        handleLoginShow();
        break;
    }





//chech if user coming from http post request


?>

<!-- <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="off">
    <input class="btn btn-primary d-grid w-100" type="submit" value="login">
</form> -->

<?php include $tpl . "footer.php"; ?>