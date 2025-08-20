<?php
session_start();
$pageTitle = 'categories';
/*
=================================
=== categories page
=== edit | delete | Add
=================================
*/
include 'init.php';
auth('index.php');

include 'controller/categoriesController.php';

$do = $_GET['do'] ?? 'manage';
switch ($do) {
    case('manage'):
        handleCategoriesIndex();
        break;
    


    case('add'):
        handleCategoriesCreate();
        break;

    case('insert'):
        ($_SERVER['REQUEST_METHOD'] == 'POST') ? handleCategoriesStore() : redirectTo('categories.php?do=add');
        break;

    case('edit'):
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        handleCategoriesEdit($id);
        break;

    case('update'):
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? 0;
            handleCategoriesUpdate($id);
            } else {
                header('location:members.php?do=manage');
            }
            break;
    
    case('delete'):
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        handleCategoriesDelete($id);        
        break;

    default:
        echo "<div class='alert alert-danger'>Invalid Action</div>";
}




include $tpl . "footer.php";