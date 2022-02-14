<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once __DIR__ . "/shopify_services/vendor/autoload.php";
function autoloadLib($class) {
    include __DIR__.'/lib/' . $class . '.php';
}
spl_autoload_register('autoloadLib');
$config_key = array(
    'ShopUrl' => "brustadshop.myshopify.com",
    'ApiKey' => "4de73ab1185eddc125c9bf69f40f5b63",
    'SharedSecret' => "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",
);

define("root_path","https://brustad1.placewise-services.com");
PHPShopify\ShopifySDK::config($config_key);
$scopes = 'read_products,write_products,read_script_tags,write_script_tags,read_price_rules,write_price_rules,read_themes,write_themes,read_customers,write_customers,unauthenticated_write_customers,write_orders,read_orders';
$redirectUrl = root_path."/redirect_url.php";
\PHPShopify\AuthHelper::createAuthRequest($scopes, $redirectUrl);

// $accessToken = \PHPShopify\AuthHelper::createAuthRequest($scopes);
// $store = new Store();
// $checkStoreExist = $store->getStoreByShop_url("techsfactorystory.myshopify.com");
// if(!empty($checkStoreExist)){
//     $store->update("techsfactorystory.myshopify.com",$accessToken);
// }else{
//     $store->create("techsfactorystory.myshopify.com",$accessToken);
// }
// header("Location: ".root_path."/theme.php");
// exit;








// echo $accessToken;


// echo "dasdsada";
// "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"
?>


<!-- require_once __DIR__ . "/etc/config.php";
// $shop = !empty($_POST['shop']) ? $_POST['shop'] : "";
$config_api = array(
    'ShopUrl' => "techsfactorystory.myshopify.com",
    'ApiKey' => '000435964f529135ee8a60cd451649a5',
    'SharedSecret' => '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',
);
PHPShopify\ShopifySDK::config($config_api);
$scopes = 'read_products,write_products,read_script_tags,write_script_tags,read_price_rules,write_price_rules,read_themes,write_themes,read_customers,write_customers';
$accessToken = \PHPShopify\AuthHelper::createAuthRequest($scopes);
// if(!empty($_GET['code'])){
//     session_unset();
//     $_SESSION['token'] = $accessToken;
//     $_SESSION['shop'] = $_GET['shop'];
//     $store = new Store();
//     $checkStoreExist = $store->getStoreByShop_url($_GET['shop']);
//     if(!empty($checkStoreExist)){
//         $store->update($_GET['shop'],$accessToken);
//     }else{
//         $store->create($_GET['shop'],$accessToken);
//     }
//     header("Location: ".root_path. "/index.php");
//     exit;
// }
// if(!empty($_SESSION['token'])) {
//     header("Location: ".root_path. "/index.php");
//     exit;
// } -->

<!-- <p>Install this app in a shop to get access to its private admin data.</p>     
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <label for='shop'><strong>The URL of the Shop</strong> 
    <span class="hint">(enter it exactly like this: myshop.myshopify.com)</span> 
    </label> 
    <p>   
    <input type="hidden" name="submitForm" value="1">      
    <input id="shop" name="shop" size="45" type="text" value="" /> 
    <input name="commit" type="submit" value="Install" /> 
    </p> 
</form> -->


