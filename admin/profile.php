<?php
session_start();

$pageTitle = 'products';

include 'init.php';
include 'controller/profileController.php';

auth();

$id= $_SESSION['id'];
handleProfile($id);



include $tpl . "footer.php"; 
