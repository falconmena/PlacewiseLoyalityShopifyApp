<?php

    class ShopifyApi{
        
        
        public function checkCustomerLoyaltyFound($shop_url = "",$customer_id = ""){
            $customerRewards = new CustomerRewards();
            $store = new Store();
            $data_store = $store->getStoreByShop_url($shop_url);
            $store_id = $data_store['id'];
            $accessToken = $data_store['token'];
            $customer_id = strval($customer_id);
            $config = array(
                'ShopUrl' => $shop_url,
                'AccessToken' => $accessToken,
            );
            $shopify = new PHPShopify\ShopifySDK($config);
            $json = json_decode(file_get_contents('php://input'), true);
            if ($json == null) {
                $json = $_REQUEST;
            }
            if(!empty($customer_id)){
                try{
                    $data = $shopify->Customer($customer_id)->get(); 
                }catch(Exception $e) {
                    $data = array();
                }
                $email = $data['email'];
                $layolty = new Loyalty();
                $shopify_data = $layolty->getLoyaltyPoints($shop_url,$email);
                $shopify_data = json_decode($shopify_data,true);

                // $shopify_data['properties']['bonus_points'] = 100;
                
                // get actual points
                
                $actual_point = $customerRewards->getCustomerRewardsSumByCustomerId($customer_id,$store_id);
                $actual_point = !empty($actual_point) ? $actual_point : 0;
                
                $bonus_points = $shopify_data['properties']['bonus_points'];
                $bonus_points = !empty($bonus_points) ? $bonus_points : 0;
                
                $shopify_data['properties']['actual_point'] = $bonus_points - $actual_point;
                
                
                
                
                if(!$shopify_data){
                    $shopify_data = array(
                        "phone"=> $data['phone'],
                        "first_name" => $data['first_name'],
                        "last_name" => $data['last_name'],
                    );
                }
                $data = json_encode($shopify_data);
            }else{
                $data =  array();
                $data = json_encode($data);
            }
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT');
            header('Content-Type: application/json');
            print $data;    
            exit;
        }
        
        public function checkCanSubmitCreateAccount(){
            
            $json = json_decode(file_get_contents('php://input'), true);
            if ($json == null) {
                $json = $_REQUEST;
            }
            $shop_url = $json['shop'];
            $customer_id = $json['id'];
            $store = new Store();
            $data_store = $store->getStoreByShop_url($shop_url);
            $accessToken = $data_store['token'];
            $customer_id = strval($customer_id);
            $config = array(
                'ShopUrl' => $shop_url,
                'AccessToken' => $accessToken,
            );
            $shopify = new PHPShopify\ShopifySDK($config);
            $phone = intval($json['phone']);
            $birthday = $json['birthday'];
            $email = $json['email'];
            $data['error'] = 0;
            $params = array(
                'phone' => $phone,
            );
            $data_phone = $shopify->Customer()->get($params);
            
            if(!empty($data_phone)){
                $data['error'] = 1;
                $data['msg'] = "This phone already exists";
            }
            if($data['error'] != 1){
                $tz  = new DateTimeZone('Europe/Brussels');
                $age = DateTime::createFromFormat('Y-d-m', $birthday, $tz)->diff(new DateTime('now', $tz))->y;
                if($age < 15){
                    $data['error'] = 1;
                    $data['msg'] = "Must be at least 15 years old";
                }
            }
            $layolty = new Loyalty();
            if($data['error'] != 1){
                $data_email_loyalty = $layolty->getLoyaltyPoints($shop_url,$email);
                $data_loyalty = json_decode($data_email_loyalty);
                if($data_loyalty != false && $data_loyalty != "false"){
                    $data['error'] = 1;
                    $data['msg'] = "This email already exists in loyalty system";
                }
            }
            if($data['error'] != 1){
                $data_phone_loyalty = $layolty->getLoyaltyPointsByPhone($shop_url,$phone);
                if($data_phone_loyalty != false && $data_phone_loyalty != "false"){
                    $data['error'] = 1;
                    $data['msg'] = "This phone already exists in loyalty system";
                }
            }
            $data = json_encode($data);
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT');
            header('Content-Type: application/json');
            print $data;    
            exit;
        }
        
        public function checkCustomerPhoneLoyaltyFound($shop_url = "",$phone = ""){
            
            $store = new Store();
            $layolty = new Loyalty();
            $data_store = $store->getStoreByShop_url($shop_url);
            $accessToken = $data_store['token'];
            $config = array(
                'ShopUrl' => $shop_url,
                'AccessToken' => $accessToken,
            );
            $shopify = new PHPShopify\ShopifySDK($config);
            $json = json_decode(file_get_contents('php://input'), true);
            if ($json == null) {
                $json = $_REQUEST;
            }
            $data['error'] = 0;
            $params = array(
                'phone' => $phone,
            );
            $data_phone = $shopify->Customer()->get($params);
            if(!empty($data_phone)){
                $data['error'] = 1;
                $data['msg'] = "This phone already exists";
            }
            if($data['error'] != 1){
                if (!(strpos($phone, '+47') !== false) and !(strpos($phone, '0047') !== false)) {
                    $phone = "0047" . $phone;
                }
                $data_phone_loyalty = $layolty->getLoyaltyPointsByPhone($shop_url,$phone);
                if($data_phone_loyalty != false && $data_phone_loyalty != "false"){
                    $data['error'] = 1;
                    $data['msg'] = "This phone already exists in loyalty system";
                }
            }
            $data = json_encode($data);
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT');
            header('Content-Type: application/json');
            print $data;    
            exit;
            
            
        }
        
        public function editMember(){
            
            $json = json_decode(file_get_contents('php://input'), true);
            if ($json == null) {
                $json = $_REQUEST;
            }
            $store = new Store();
            $loyalty = new Loyalty();
            $shop = $json['shop'];
            $id = $json['customer_id'];
            $data_store = $store->getStoreByShop_url($shop);
            $accessToken = $data_store['token'];
            $config = array(
                'ShopUrl' => $shop,
                'AccessToken' => $accessToken,
            );
            $shopify = new PHPShopify\ShopifySDK($config);
            $shopify_data = $shopify->Customer($id)->get(); 
            $customer_email = $shopify_data['email'];
            $data_loyalty = $loyalty->getLoyaltyPoints($shop,$customer_email);
            $data_loyalty = json_decode($data_loyalty,true);
            $fname = $json['fname'];
            $lname = $json['lname'];
            $gender = $json['gender'];
            $birthday = $json['birthday'];
            $sms = $json['sms'];
            $email = $json['email'];
            $offers = $json['offers'];
            $device = $json['device'];
            $memberData = array(
                'properties' => array(
                    'first_name' => $fname,
                    'last_name' => $lname,
                    'gender' => $gender,
                    'birthday' => $birthday,
                ),
                'consents' => array(
                  'sms_marketing' => array('status'=>$sms),
                  'email_marketing' => array('status'=>$email),
                  'dmp_profiling' => array('status'=>$offers),
                  'cookie_tracking' => array('status'=>$device)
                ),
                'member_id' => $data_loyalty['id']
            );
            $data = $loyalty->editLoyaltyMember($memberData);
            foreach ($data->errors->properties as $key => $value) {
                foreach ($value->error as $kError => $vError) {
                    foreach ($vError as $kField => $vField) {
                        if($vField->error == "minimum_years_since"){
                            $data->msg = "The minimum age is $vField->limit years";
                            $data->error = 1;
                            break;
                        }elseif ($vField->error == "value_not_match" && $vField->property == "gender") {
                            $data->msg = "Please Select Gender";
                            $data->error = 1;
                            break;
                        }
                    } 
                } 
            }
            if($data->error == 1){
                unset($data->errors);
            }
            $data = json_encode($data);
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT');
            header('Content-Type: application/json');
            print $data;    
            exit;
        
        }
        
        public function addMember(){
            
            $json = json_decode(file_get_contents('php://input'), true);
            if ($json == null) {
                $json = $_REQUEST;
            }
            $store = new Store();
            $loyalty = new Loyalty();
            $shop = $json['shop'];
            $id = $json['customer_id'];
            $birthday = $json['birthday'];
            $phone = intval($json['phone']);
            
            $fname = $json['fname'];
            $lname = $json['lname'];
            $gender = $json['gender'];
            $sms = $json['sms'];
            $email = $json['email'];
            $offers = $json['offers'];
            $device = $json['device'];
            
            $password = $json['password'];
            $cpassword = $json['cpassword'];
            $data_store = $store->getStoreByShop_url($shop);
            $accessToken = $data_store['token'];
            $config = array(
                'ShopUrl' => $shop,
                'AccessToken' => $accessToken,
            );
            $shopify = new PHPShopify\ShopifySDK($config);
            
            $customer_info = $shopify->Customer($id)->get();
            $customer_email = $customer_info['email'];
            $customer_phone = $customer_info['phone'];
            
            $data = array();
            if($password != $cpassword){
                $data['error'] = 1;
                $data['msg'] = "Passord og ompassordet må være det samme";
            }else{
                if(empty($customer_phone)){
                    $params = array(
                        'phone' => $phone,
                    );
                    $data_phone = $shopify->Customer()->get($params);
                    if(!empty($data_phone)){
                        $data['error'] = 1;
                        $data['msg'] = "This phone already exists";
                    }   
                }
                if($data['error'] != 1){
                    $tz  = new DateTimeZone('Europe/Brussels');
                    $age = DateTime::createFromFormat('Y-d-m', $birthday, $tz)->diff(new DateTime('now', $tz))->y;
                    if($age < 15){
                        $data['error'] = 1;
                        $data['msg'] = "Must be at least 15 years old";
                    }
                }
                $layolty = new Loyalty();
                if($data['error'] != 1){
                    $data_email_loyalty = $layolty->getLoyaltyPoints($shop,$customer_email);
                    $data_loyalty = json_decode($data_email_loyalty);
                    if($data_loyalty != false && $data_loyalty != "false"){
                        $data['error'] = 1;
                        $data['msg'] = "This email already exists in loyalty system";
                    }
                }
                if($data['error'] != 1){
                    $data_phone_loyalty = $layolty->getLoyaltyPointsByPhone($shop_url,$phone);
                    if($data_phone_loyalty != false && $data_phone_loyalty != "false"){
                        $data['error'] = 1;
                        $data['msg'] = "This phone already exists in loyalty system";
                    }
                }
                
                #Create Customer
                if($data['error'] != 1){
                    
                    if(!empty($phone)){
                        $phone = preg_replace('~^[0\D]++|\D++~', '', $phone);
                    }
                    
                    $memberData = array(
                        'properties' => array(
                                'email' => $customer_email,
                                'msisdn' => $phone,
                                'first_name' => $fname,
                                'last_name' => $lname,
                                'gender' => $gender,
                                'birthday' => $birthday,
                        ),
                        'consents' => array(
                          'sms_marketing' => array('status'=>$sms),
                          'email_marketing' => array('status'=>$email),
                          'dmp_profiling' => array('status'=>$offers),
                          'cookie_tracking' => array('status'=>$device)
                        ),
                        'send_sms_welcome_message' => 'true',
                        'password' => $password
                    );
                    $data = $memberData;
                    $error_count = 0;
                    if(!empty($password) && $password == $cpassword){
                        $data = $loyalty->createLoyaltyMember($memberData,$shop);
                        foreach ($data->errors->properties as $key => $value) {
                            foreach ($value->error as $kError => $vError) {
                              $error_count = 1;
                              foreach ($vError as $kField => $vField) {
                                if($vField->error == "minimum_years_since"){
                                  $error .= "The minimum age is $vField->limit years<br>";
                                }elseif ($vField->error == "value_not_match" && $vField->property == "gender") {
                                  $error .= "Please Select Gender<br>";
                                }
                              } 
                            } 
                        }
                        if(!empty($data->errors->msisdn)){
                            $error_count = 1;
                            $error .= "Phone is not valid";
                        }
                    }else{
                        $error_count = 1;
                        $error = "password and confirmation do not match";
                    }
                    $data = array();
                    if($error_count == 1){
                        $data['error_count'] = $error_count;
                        $data['error'] = $error;
                    }else{
                        $data['error_count'] = 0;
                    }
                }
            }
            
            $data = json_encode($data);
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT');
            header('Content-Type: application/json');
            print $data;    
            exit;
            
            
        }    
        
        public function addRewardsDataByCustomer(){
            
            $json = json_decode(file_get_contents('php://input'), true);
            if ($json == null) {
                $json = $_REQUEST;
            }
            $store = new Store();
            $loyalty = new Loyalty();
            $customerRewards = new CustomerRewards();
            
            $shop = $json['shop'];
            $customer_id = $json['customer_id'];
            $points = $json['points'];
            $data_store = $store->getStoreByShop_url($shop);
            $accessToken = $data_store['token'];
            $config = array(
                'ShopUrl' => $shop,
                'AccessToken' => $accessToken,
            );
            $shopify = new PHPShopify\ShopifySDK($config);
            $customer_info = $shopify->Customer($customer_id)->get();
            $customer_email = $customer_info['email'];
            
            $layolty = new Loyalty();
            $data_loyalty = $layolty->getLoyaltyPoints($shop,$customer_email);
            $data_loyalty = json_decode($data_loyalty,true);
            
            // $data_loyalty['properties']['bonus_points'] = 100;
            
            if(!empty($data_loyalty)){
                $addRewards = $customerRewards->addRewardsDataByCustomer($json,$data_loyalty,$data_store['id']);
                $addRewards['found_loyalty'] = 1;
                if($addRewards['add_reward']){
                    $priceRoleParams = $addRewards['priceRoleParams'];
                    $code = $addRewards['code'];
                    unset($addRewards['priceRoleParams']);
                    $price_role = $shopify->PriceRule()->post($priceRoleParams);
                    $shopify->PriceRule($price_role['id'])->DiscountCode()->post(array("code"=>$code));
                }
            }else{
              $addRewards['found_loyalty'] = 0; 
            }
            $data = json_encode($addRewards);
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT');
            header('Content-Type: application/json');
            print $data;    
            exit;
        }
        
        public function getCustomerRewards($shop_url = "",$customer_id = ""){
            $store = new Store();
            $customerRewards = new CustomerRewards();
            $layolty = new Loyalty();
            $data_store = $store->getStoreByShop_url($shop_url);
            $store_id = $data_store['id'];
            $accessToken = $data_store['token'];
            $customer_id = strval($customer_id);
            $config = array(
                'ShopUrl' => $shop_url,
                'AccessToken' => $accessToken,
            );
            $shopify = new PHPShopify\ShopifySDK($config);
            $json = json_decode(file_get_contents('php://input'), true);
            if ($json == null) {
                $json = $_REQUEST;
            }
            
            $customer_info = $shopify->Customer($customer_id)->get();
            $customer_email = $customer_info['email'];
            $data_loyalty = $layolty->getLoyaltyPoints($shop_url,$customer_email);
            $data_loyalty = json_decode($data_loyalty,true);
            
            if(!empty($data_loyalty)){
                $reward_info = $customerRewards->getCustomerRewardsByCustomerId($store_id,$customer_id);
                $data['found_loyalty'] = 1; 
                $data['data'] = $reward_info; 
            }else{
                $data['found_loyalty'] = 0; 
            }
            $data = json_encode($data); 
            
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT');
            header('Content-Type: application/json');
            print $data;    
            exit;
            
            
        }
        
        
        
        
    }
?>