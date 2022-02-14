<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/../shopify_services/vendor/autoload.php";
// require_once __DIR__. "/../vendor/autoload.php";
define("apiKey","4de73ab1185eddc125c9bf69f40f5b63");
define("sharedSecret","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");
define("root_path","https://brustad1.placewise-services.com");
define("pageName",explode( ".", basename($_SERVER['PHP_SELF']))[0]);
function autoloadLib($class) {
    include __DIR__.'/../lib/' . $class . '.php';
}
spl_autoload_register('autoloadLib');
$store = new Store();
$loyalty = new Loyalty();
$userSession = new UserSession();
if(!empty($_GET['hmac']) && !empty($_GET['shop'])){
    $validHmac = Helper::validateHmac($_GET, sharedSecret);
    $validShop = Helper::validateShopDomain($_GET['shop']);
    $hmac = $_GET['hmac'];
    $shop = $_GET['shop'];
    $locale = $_GET['locale'];
    $new_design_language = $_GET['new_design_language'];
    $session = $_GET['session'];
    $timestamp = $_GET['timestamp'];
}
if(!(strpos(strtok($_SERVER["REQUEST_URI"], '?'), "/view/iframe/") !== false) && !(strpos(strtok($_SERVER["REQUEST_URI"], '?'), "/api/") !== false) && !(strpos(strtok($_SERVER["REQUEST_URI"], '?'), "/webhooks/") !== false)  && !(strpos(strtok($_SERVER["REQUEST_URI"], '?'), "/install.php") !== false) &&  !($validHmac && $validShop)) {
    header("Location: ".root_path."/view/404.php");
    exit;
}else{
    $data_store = $store->getStoreByShop_url($_GET['shop']);
}
define("accessToken",$data_store['token']);
define("shopUrl", $_GET['shop']);
$dbhost   = "falcon-clients.com";
$dbname   = "falconclients_loyality";
$dbuser   = "falconclients_loyality";
$dbpass   = "mohammad1995@"; 
$dbserver = "mysql:host=falcon-clients.com;dbname=falconclients_loyality";
$config = array(
    'ShopUrl' => shopUrl,
    'AccessToken' => accessToken,
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
if(!empty($customer_data)){
    $data_loyalty = $loyalty->getLoyaltyPoints($customer_data['email']);
    $data_loyalty = json_decode($data_loyalty,true);
    if(!empty($data_loyalty)){
        $data_loyalty['data_loyalty'] = true;
        $data_loyalty['customer_exist'] = true;
        $data_loyalty['properties']['bonus_points'] = 2000;
    }elseif(!$data_loyalty){
        $data_loyalty['data_loyalty'] = false;
        $data_loyalty['properties']['first_name'] = $customer_data['first_name'];
        $data_loyalty['properties']['last_name'] = $customer_data['last_name'];
        $data_loyalty['properties']['msisdn'] = $customer_data['phone'];
    }
}
