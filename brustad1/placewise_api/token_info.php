<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once(dirname(__FILE__) . '/inc/Lib.php');

if(isset($_REQUEST['query']) && !empty($_REQUEST['query'])){
    $token = $_REQUEST['query'];
}else{
    echo 'Not Valid Token'; 
    exit;
}
$token_info = tokenInfo($token);
print json_encode($token_info);
exit;
?>
