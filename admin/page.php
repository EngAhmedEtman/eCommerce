<?php

$do = isset($_GET['do']) ? $_GET['do'] : 'mange'; 

if($do == 'mange'){
    echo 'welcome to the mange page';
}
elseif($do =='add'){
        echo 'welcome to the add category page';
}
else{
    echo 'error there is no page found';
}