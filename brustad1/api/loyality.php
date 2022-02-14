<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once __DIR__ . "/../etc/config.php";
$json = json_decode(file_get_contents('php://input'), true);
if ($json == null) {
    $json = $_REQUEST;
}
$type = $json['type'];
$layolty = new Loyalty();
$customer = new Customer();
$customerRewards = new CustomerRewards();
// $auth = new Auth();
switch ($type) {
    case "checkCustomerLoyaltyFound":
        $id = $json['id'];
        if(!empty($id)){
            $data = $shopify->Customer($id)->get();
            $email = $data['email'];
            // echo $email;
            // exit;
            $layoltyPoints = $layolty->getLoyaltyPoints($email);
            $member_not_active = json_decode($layoltyPoints);
            if(!$member_not_active){
                $shopify_data = array(
                    "phone"=> $data['phone'],
                    "first_name" => $data['first_name'],
                    "last_name" => $data['last_name'],
                );
                $layoltyPoints = json_encode($shopify_data);
            }
        }else{
            $layoltyPoints =  array();
            $layoltyPoints = json_encode($layoltyPoints);
        }
        $data = $layoltyPoints;
        // $layoltyPoints = $data_loyalty;
        break;
    case "checkCanSubmitCreateAccount":
        $phone = $json['phone'];
        $birthday = $json['birthday'];
        $is_loyalty = $json['is_loyalty'];
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
            if($is_loyalty == "yes"){
                $tz  = new DateTimeZone('Europe/Brussels');
                $age = DateTime::createFromFormat('Y-d-m', $birthday, $tz)->diff(new DateTime('now', $tz))->y;
                if($age < 15){
                    $data['error'] = 1;
                    $data['msg'] = "Must be at least 15 years old";
                }
            }
        }
        // echo "<pre>";
        // print_r($json);
        // exit;
        if($data['error'] != 1){
            if($is_loyalty == "yes"){
                $data_email_loyalty = $layolty->getLoyaltyPoints($email);
                $data_loyalty = json_decode($data_email_loyalty);
                if($data_loyalty != false && $data_loyalty != "false"){
                    $data['error'] = 1;
                    $data['msg'] = "This email already exists in loyalty system";
                }
            }
        }
        if($data['error'] != 1){
            if($is_loyalty == "yes"){
                $data_phone_loyalty = $layolty->getLoyaltyPointsByPhone($phone);
                if($data_phone_loyalty != false && $data_phone_loyalty != "false"){
                    $data['error'] = 1;
                    $data['msg'] = "This phone already exists in loyalty system";
                }
            }
        }


        // echo "<pre>";
        // print_r($data);
        // exit;
        // $data = $tags;
        $data = json_encode($data);
        break; 
    case "checkCustomerPhoneLoyaltyFound":
        $phone = $json['phone'];
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
            $data_phone_loyalty = $layolty->getLoyaltyPointsByPhone($phone);
            if($data_phone_loyalty != false && $data_phone_loyalty != "false"){
                $data['error'] = 1;
                $data['msg'] = "This phone already exists in loyalty system";
            }
        }
        $data = json_encode($data);
        break;
    case "editMember":
        $id = $json['customer_id'];
        $shop = $json['shop_url'];
        $fname = $json['fname'];
        $lname = $json['lname'];
        $gender = $json['gender'];
        $birthday = $json['birthday'];
        $sms = $json['sms'];
        $email = $json['email'];
        $offers = $json['offers'];
        $email = $json['email'];
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
        break;
    case "addMember":
        $id = $json['customer_id'];
        $shop = $json['shop_url'];
        $fname = $json['fname'];
        $lname = $json['lname'];
        $gender = $json['gender'];
        $birthday = $json['birthday'];
        $sms = $json['sms'];
        $offers = $json['offers'];
        $email = $json['email'];
        $device = $json['device'];
        $password = $json['password'];
        $cpassword = $json['cpassword'];
        $phone = $json['phone'];
        $customer_info = $shopify->Customer($id)->get();
        $error = "";
        $error_count = 0;
        if(!empty($phone)){
            $phone = preg_replace('~^[0\D]++|\D++~', '', $phone);
        }
        if(!empty($customer_info['phone'])){
            $phone = preg_replace('~^[0\D]++|\D++~', '', $customer_info['phone']);
        }
        if(!empty($customer_info['email'])){
            $email = $customer_info['email'];
        }
        $memberData = array(
            'properties' => array(
                    'email' => $email,
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
        $error_count = 0;
        if(!empty($password) && $password == $cpassword){
            $data = $loyalty->createLoyaltyMember($memberData);
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
        $data = json_encode($data);
        break;    
    case "getRewardsData":    
        $data_all_rewards = $customerRewards->getCustomerRewardsCountByCustomerId($json['customer_id']);
        $data = json_encode($data_all_rewards);        
        break;
    case 'addRewardsDataByCustomer':
        $customer_id = $json['customer_id'];
        if($data_loyalty['data_loyalty']){
            $addRewards = $customerRewards->addRewardsDataByCustomer($json,$data_loyalty);
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
        break;    
    case 'getCustomerRewards':
        $customer_id = $json['customer_id'];
        if($data_loyalty['data_loyalty']){
            $reward_info = $customerRewards->getCustomerRewardsByCustomerId($customer_id);
            $data['found_loyalty'] = 1; 
            $data['data'] = $reward_info; 
        }else{
            $data['found_loyalty'] = 0; 
        }
        $data = json_encode($data); 
        break;
    default:
        $data = 'Nothing found';
        break;
}

if ($json['test'] == 1) {
   //print '<pre>';
   print_r($data);
   exit;
}
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT');
header('Content-Type: application/json');
print $data;    
exit;