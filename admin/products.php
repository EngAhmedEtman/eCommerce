<?php
session_start();
$pageTitle = 'products';
/*
=================================
=== categories page
=== edit | delete | Add
=================================
*/
include 'init.php';
auth('index.php');


echo "اهلا بيك يا رايق في صفحة المنتجات الرايقه زيك" ;





include $tpl . "footer.php";