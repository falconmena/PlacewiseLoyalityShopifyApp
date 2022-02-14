<?php
session_start();
// session_unset();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . "/../shopify_services/vendor/autoload.php";
define("apiKey", "4de73ab1185eddc125c9bf69f40f5b63");
define("password", "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");
define("shopUrl", "brustadshop.myshopify.com");
define("root_path","https://brustad1.placewise-services.com");
define("pageName",explode( ".", basename($_SERVER['PHP_SELF']))[0] );
function autoloadLib($class) {
    include __DIR__.'/../lib/' . $class . '.php';
}
spl_autoload_register('autoloadLib');
$dbhost   = "falcon-clients.com";
$dbname   = "falconclients_loyality";
$dbuser   = "falconclients_loyality";
$dbpass   = "mohammad1995@"; 
$dbserver = "mysql:host=falcon-clients.com;dbname=falconclients_loyality";
// if(empty($_SESSION['token']) && constant("pageName") != "install") {
//     header("Location: ".root_path. "/install.php");
//     exit;
// }
// echo $_SESSION['token'];
// exit;


// $config = array(
//     'ShopUrl' => shopUrl,
//     'ApiKey' => apiKey,
//     'Password' => password,
// );
$config = array(
    'ShopUrl' => shopUrl,
    'AccessToken' => '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',
);
$shopify = new PHPShopify\ShopifySDK($config);
$customer_id = "";
$customer_data = array();
if (empty($_GET['customer_id']) || strpos($_GET['customer_id'], '-') !== false) {
    $customer_id = "null";
}else{
    $params = array(
        'id' => $customer_id
    );
    $customer_id = $_GET['customer_id'];
    $customer_data = $shopify->Customer($customer_id)->get();
}


// echo "<pre>";
// print_r($_SESSION);