<?php
session_start();

$pageTitle = 'products';

include 'init.php';
include 'controller/productsController.php';


$do = $_GET['do'] ?? 'manage';

switch ($do) {

    case 'manage':
        handleProductsIndex();
        break;

    case 'add':
        handleProductsCreate();
        break;

    case 'insert':
        ($_SERVER['REQUEST_METHOD'] == 'POST') ? handleProductsStore() : redirectTo('products.php?do=add');
        break;
    case 'edit':
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        handleProductEdit($id);
        break;
    
    
    
    
    case 'update':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? 0;
            handleProductsUpdate($id);
            } else {
                header('location:products.php?do=manage');
            }
            break;

    
    case 'delete':
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        handleProductsDelete($id);
        break;


    default:
        echo "<div class='alert alert-danger'>Invalid Action</div>";
}



include $tpl . "footer.php"; 



