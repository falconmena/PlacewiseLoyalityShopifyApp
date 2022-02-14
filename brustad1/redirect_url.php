<?php

require_once __DIR__ . "/shopify_services/vendor/autoload.php";
function autoloadLib($class) {
    include __DIR__.'/lib/' . $class . '.php';
}
spl_autoload_register('autoloadLib');
// $config_key = array(
//     'ShopUrl' => "placewiseas.myshopify.com",
//     'ApiKey' => "000435964f529135ee8a60cd451649a5",
//     'SharedSecret' => "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",
// );
// $config_key = array(
//     'ShopUrl' => "techsfactorystory.myshopify.com",
//     'ApiKey' => "e88b5463b381f55952f885aeed9e690b",
//     'SharedSecret' => "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",
// );
define("root_path","https://brustad1.placewise-services.com");
$config_key = array(
    'ShopUrl' => $_GET['shop'],
    'ApiKey' => '4de73ab1185eddc125c9bf69f40f5b63',
    'SharedSecret' => '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',
);
PHPShopify\ShopifySDK::config($config_key);
$accessToken = \PHPShopify\AuthHelper::getAccessToken();
$store = new Store();
$checkStoreExist = $store->getStoreByShop_url($_GET['shop']);
if(!empty($checkStoreExist)){
    $store->update($_GET['shop'],$accessToken);
}else{
    $store->create($_GET['shop'],$accessToken);
}
header("Location: ".root_path."/theme.php?".$_SERVER['QUERY_STRING']);
exit();
?>
