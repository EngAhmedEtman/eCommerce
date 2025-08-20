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
include $tpl . "footer.php"; 