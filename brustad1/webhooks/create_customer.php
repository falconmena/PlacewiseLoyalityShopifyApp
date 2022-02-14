<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// header('Content-Type: application/json');
require_once __DIR__ . "/../shopify_services/vendor/autoload.php";
// $shop = "techsfactorystory.myshopify.com";
function autoloadLib($class) {
    include __DIR__.'/../lib/' . $class . '.php';
}
spl_autoload_register('autoloadLib');
$store = new Store();
$loyalty = new Loyalty();


$webhook_content = '';
$webhook = fopen('php://input' , 'rb');
while(!feof($webhook)){
	$webhook_content .= fread($webhook, 4096);
}
fclose($webhook);
$data = json_decode($webhook_content, true);
echo file_put_contents("1_2_2022_v2.txt",serialize($data));
// $shop = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];
$shop = "brustadshop.myshopify.com";
$data_store = $store->getStoreByShop_url($shop);
// echo "<pre>";
// print_r($data_store);
$accessToken = $data_store['token'];
$config = array(
    'ShopUrl' => $shop,
    'AccessToken' => $accessToken,
);
$shopify = new PHPShopify\ShopifySDK($config);
// echo file_put_contents("newall.txt",$hmac_header);
// $data = array(
//     "id" => "6053687984342",
//     "tags" => "phone=00962785845813&gender=man&birthday=1995-02-01&password=mohammad1995@&sms_status=true&email_status=true&offers_status=false&device_status=true&is_loyalty=yes&"
// );
// $data = "phone=962792981817&gender=man&birthday=1995-04-28&password=mohammad1995@&sms_status=false&email_status=true&offers_status=false&device_status=false&is_loyalty=yes&";
$array_tags = $data['tags'];
// echo "<pre>";
$id = $data['id'];
$array_tags = str_replace("+","@@RTRTEh@@",$array_tags);
parse_str($array_tags,$tags);
$phone = str_replace("@@RTRTEh@@","+",$tags['phone']);
$phone = str_replace("@@RTRTEh@@","+",$phone);
$params = array(
    "phone" => $phone,
    "tags"  => ""
);

// echo "<pre>";
// print_r($params);
// print_r($id);
// print_r($tags);

$edit = $shopify->Customer($id)->put($params);
// exit;
//create loyalty data
if($tags['is_loyalty'] == "yes"){
    $memberData = array(
        'properties' => array(
                'email' => $edit['email'],
                'msisdn' => $edit['phone'],
                'first_name' => $edit['first_name'],
                'last_name' => $edit['last_name'],
                'gender' => str_replace("@@RTRTEh@@","+",$tags['gender']),
                'birthday' => str_replace("@@RTRTEh@@","+",$tags['birthday'])
        ),
        'consents' => array(
        'sms_marketing' => array('status'=>$tags['sms_status']),
        'email_marketing' => array('status'=>$tags['email_status']),
        'dmp_profiling' => array('status'=>$tags['offers_status']),
        'cookie_tracking' => array('status'=>$tags['device_status'])
        ),
        'send_sms_welcome_message' => 'true',
        'password' => str_replace("@@RTRTEh@@","+",$tags['password'])
    );

    $loyalty->createLoyaltyMember($memberData); 

}
// $test['1'] = $edit;
// $test['2'] = $data;
// $test['3'] = $memberData;
?>