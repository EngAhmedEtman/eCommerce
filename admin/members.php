<?php
session_start();
$pageTitle = 'members';
/*
=================================
=== Manage members
=== edit | delete | Add
=================================
*/
include 'init.php';
auth('index.php');

include 'controller/membersController.php';


$do = $_GET['do'] ?? 'manage';
switch ($do) {

    case 'manage':

        handleMembersIndex();
        break;

    case 'add':
        handleMembersCreate();
        break;

    case 'insert':
        ($_SERVER['REQUEST_METHOD'] == 'POST') ? handleMembersStore() : redirectTo('members.php?do=add');
        break;
    case 'edit':
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        handleMemberEdit($userid);
        break;
    
    
    
    
    case 'update':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userid = $_POST['userid'] ?? 0;
            handleMembersUpdate($userid);
            } else {
                header('location:members.php?do=manage');
            }
            break;

    
    case 'delete':
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        handleMembersDelete($userid);
        break;

    case 'active':
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        handleMembersActive($userid);


    default:
        echo "<div class='alert alert-danger'>Invalid Action</div>";
}



include $tpl . "footer.php";
