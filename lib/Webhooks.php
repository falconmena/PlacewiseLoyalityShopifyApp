<?php 
    class Webhooks{
        
        public function create_customer(){
            
            $store = new Store();
            $loyalty = new Loyalty();
            $webhook_content = '';
            $webhook = fopen('php://input' , 'rb');
            while(!feof($webhook)){
            	$webhook_content .= fread($webhook, 4096);
            }
            fclose($webhook);
            $data = json_decode($webhook_content, true);
            $file_name = "file_for_testing" . time() . ".txt";
            echo file_put_contents($file_name,serialize($data));
            $shop = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];
            // $shop = "mo-final-testing.myshopify.com";
            // $data = unserialize('a:25:{s:2:"id";i:5420914638985;s:5:"email";s:31:"awwbusubwqhiammmmm111@gmail.com";s:17:"accepts_marketing";b:0;s:10:"created_at";s:25:"2022-02-13T19:44:46+03:00";s:10:"updated_at";s:25:"2022-02-13T19:44:46+03:00";s:10:"first_name";s:8:"mohammad";s:9:"last_name";s:9:"abusubhia";s:12:"orders_count";i:0;s:5:"state";s:7:"enabled";s:11:"total_spent";s:4:"0.00";s:13:"last_order_id";N;s:4:"note";N;s:14:"verified_email";b:0;s:20:"multipass_identifier";N;s:10:"tax_exempt";b:0;s:5:"phone";N;s:4:"tags";s:142:"phone=41239599&gender=man&birthday=2000-02-14&password=mohammad1995@&sms_status=true&email_status=true&offers_status=false&device_status=true&";s:15:"last_order_name";N;s:8:"currency";s:3:"NOK";s:9:"addresses";a:0:{}s:28:"accepts_marketing_updated_at";s:25:"2022-02-13T19:44:46+03:00";s:22:"marketing_opt_in_level";N;s:14:"tax_exemptions";a:0:{}s:21:"sms_marketing_consent";N;s:20:"admin_graphql_api_id";s:36:"gid://shopify/Customer/5420914638985";}');
            
            $data_store = $store->getStoreByShop_url($shop);
            $accessToken = $data_store['token'];
            $config = array(
                'ShopUrl' => $shop,
                'AccessToken' => $accessToken,
            );
            $shopify = new PHPShopify\ShopifySDK($config);
            
            
            $array_tags = $data['tags'];
            $id = $data['id'];
            // $id = "5420814696585";
            $array_tags = str_replace("+","@@RTRTEh@@",$array_tags);
            parse_str($array_tags,$tags);
            
            $phone = str_replace("@@RTRTEh@@","+",$tags['phone']);
            $phone = str_replace("@@RTRTEh@@","+",$phone);
            $params = array(
                "phone" => $phone,
                "tags"  => ""
            );
            // echo $phone;
            // echo "sadsada";
            // exit;
            $edit = $shopify->Customer($id)->put($params);
            $phone = $edit['phone'];
            if (!(strpos($phone, '+47') !== false) and !(strpos($phone, '0047') !== false)) {
                $phone = "0047" . $phone;
            }
            
            $memberData = array(
                'properties' => array(
                        'email' => $edit['email'],
                        'msisdn' => $phone,
                        // 'msisdn' => "004741231531",
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
            $new_member = $loyalty->createLoyaltyMember($memberData,$shop); 
            
            // echo "<pre>";
            // print_r($new_member);
            // exit;
        }
        
        
        public function create_order(){
            
            $webhook_content = '';
            $webhook = fopen('php://input' , 'rb');
            while(!feof($webhook)){
            	$webhook_content .= fread($webhook, 4096);
            }
            fclose($webhook);
            $data = json_decode($webhook_content, true);
            
            $file_name = "file_for_testing_create_order" . time() . ".txt";
            echo file_put_contents($file_name,serialize($data));
            
            $shop = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];
            // $shop = "placewisesdev.myshopify.com";
            // echo "<pre>";
            // print_r($data);
            // exit;
            $store = new Store();
            $customerRewards = new CustomerRewards();
            $data_store = $store->getStoreByShop_url($shop);
            $store_id = $data_store['id'];
            $accessToken = $data_store['token'];
            $config = array(
                'ShopUrl' => $shop,
                'AccessToken' => $accessToken,
            );
            
            $shopify = new PHPShopify\ShopifySDK($config);
            $discount_applications = $data['discount_applications'];
            $customer_id = $data['customer']['id'];
            foreach ($discount_applications as $key => $value) {
                $customerRewards->updateUsedByCode($store_id,$value['code'],$customer_id);
            }
        }
        
    }

?>