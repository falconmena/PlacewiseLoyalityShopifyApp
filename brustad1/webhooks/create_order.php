<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// header('Content-Type: application/json');
require_once __DIR__ . "/../shopify_services/vendor/autoload.php";
function autoloadLib($class) {
    include __DIR__.'/../lib/' . $class . '.php';
}
spl_autoload_register('autoloadLib');
$webhook_content = '';
$webhook = fopen('php://input' , 'rb');
while(!feof($webhook)){
	$webhook_content .= fread($webhook, 4096);
}
fclose($webhook);
$data = json_decode($webhook_content, true);
$shop = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];
// $shop = "techsfactorystory.myshopify.com";
$store = new Store();
$customerRewards = new CustomerRewards();
$discount = new Discount();
$data_store = $store->getStoreByShop_url($shop);
$accessToken = $data_store['token'];
$config = array(
    'ShopUrl' => $shop,
    'AccessToken' => $accessToken,
);
$shopify = new PHPShopify\ShopifySDK($config);

// $data_ser = serialize($data);
// echo file_put_contents("create_orderorder2321231.txt",$data_ser);
// exit;
// $data = array (
//     'id' => 3126281961636,
//     'discount_applications' => array(0 => 
//       array (
//         'type' => 'discount_code',
//         'value' => '20.0',
//         'value_type' => 'percentage',
//         'allocation_method' => 'across',
//         'target_selection' => 'all',
//         'target_type' => 'line_item',
//         'code' => '31D8F967B4C9',
//       ),
//     ),
//     'customer' => 
//     array (
//       'id' => 4546048196772,
//     ),
// );
$discount_applications = $data['discount_applications'];
$customer_id = $data['customer']['id'];
// $data_price_role = $shopify->PriceRule()->get();
// $priceRoleColumn = array_column($data_price_role, 'title');
foreach ($discount_applications as $key => $value) {
    $customerRewards->updateUsedByCode($value['code'],$customer_id);
    // $discount_data = $discount->getDiscountByCode($value['code']);
    // $discount_id = $discount_data['id']; 
    // $data_customer_rewareds = $customerRewards->getCustomerRewardsByRewardsIdAndCustomerId($discount_id,$customer_id);
    // foreach ($data_customer_rewareds as $k => $v) {
    //     if($k == 0){
    //         $customerRewards->updateUsed($v['id']);
    //     }
    // }
    // if(count($data_customer_rewareds) < 2){
    //     $data_price_role_key = array_search($value['code'],$priceRoleColumn,true);
    //     if($priceRoleColumn[$data_price_role_key] == $value['code']){
    //         $priceRoleId = $data_price_role[$data_price_role_key]['id'];
    //         $customerIds = $data_price_role[$data_price_role_key]['prerequisite_customer_ids']; 
    //         if(in_array($customer_id, $customerIds)){
    //             if (($key = array_search($customer_id, $customerIds)) !== false) {
    //                 unset($customerIds[$key]);
    //                 $customerIds = array_values($customerIds);
    //             }
    //             if(!empty($customerIds)){
    //                 $priceRoleParams = array(
    //                     "prerequisite_customer_ids" => $customerIds
    //                 );
    //                 $shopify->PriceRule($priceRoleId)->put($priceRoleParams);
    //             }else{
    //                 //delete discount code
    //                 $data_discount_code = $shopify->PriceRule($priceRoleId)->DiscountCode()->get();
    //                 foreach ($data_discount_code as $key => $value) {
    //                     $shopify->PriceRule($priceRoleId)->DiscountCode($value['id'])->delete();
    //                 }
    //                 $shopify->PriceRule($priceRoleId)->delete();
    //             }            
    //         }
    //     }
    // }
}
// $data_ser = serialize($data);
// echo file_put_contents("create_orderorder232123.txt",$data_ser);
?>