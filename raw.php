<?php
ob_start("ob_gzhandler");
ini_set('open_basedir',getcwd());

//load the config array
require_once('config/site.config.php');

//load the generic functions
require_once('functions/include_functions.php');
require_once('functions/numbers.php');
require_once('functions/generic.php');
require_once('includes.php');

//page stuff
$page = $_REQUEST['page'];
if($database->connected){
    if ($page != ''){
        if (file_exists('raw/'.$page.'.php')){
            //yay the page exists!
        }elseif (file_exists('raw/'.$page.'/index.php')){
            //points to a folder rather than i file so we need to tell it to look for the index of that folder
            $page = $page.'/index';
        }else{
            unset($_GET['page']);
            $page = '404';
        }
    }else{
        unset($_GET['page']);
        $page = 'index';
    }
}
//Main site includes.
if($page=='404'){
    require_once('header.php');
    require_once('err/404.php');
    require_once('footer.php');
}elseif(!$database->connected){
    require_once('err/noDatabase.php');
}else{
    require_once('raw/'.$page.'.php');
}
?>
