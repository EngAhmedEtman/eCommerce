<?php
session_start();


if(isset($_SESSION['username']))
    {
    $pageTitle = 'Dashboard';
    include 'init.php';

    echo 'welcome';

    include $tpl."footer.php"; 
}
else{
header('location: index.php');
exit;
}



?>