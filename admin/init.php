<?php

include 'connect.php';

// routes

$tpl = 'include/temp/'; //template directly
$lang = 'include/languages/';
$func = 'include/functions/';      //function directly
$css = 'layout/css/';   //css directly
$js = 'layout/js/';   //js directly

// include the important files
include $func . 'functions.php';
include $func . 'validation.php';
include $lang . 'english.php';
include $tpl ."header.php";

//include nabvar on all pages expect the one with $noNavbar variable 

if(!isset($noNavbar))
{
include $tpl ."navbar.php";
}




?>