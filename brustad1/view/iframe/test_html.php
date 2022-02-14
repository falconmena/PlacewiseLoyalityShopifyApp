<?php
require_once __DIR__ . "/header.php";
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$loyalty = new Loyalty();
$customer = new Customer();
$discount = new Discount();
$customerRewards = new CustomerRewards();
if(!empty($_POST['information_form']) && $_POST['information_form'] == 1){
    $check_email = array();
    $check_email = $customer->getCustomerByEmail($_POST['email']);
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $phone = preg_replace('~^[0\D]++|\D++~', '', $_POST['phone']);
    $sms_marketing = $_POST['sms_marketing'];
    $email_marketing = $_POST['email_marketing'];
    $dmp_profiling = $_POST['dmp_profiling'];
    $cookie_tracking = $_POST['cookie_tracking'];
  //   $concents = $_POST['concents'];
    $error = "";
    $memberData = array(
      'properties' => array(
              'email' => $_POST['email'],
              'msisdn' => $phone,
              'first_name' => $first_name,
              'last_name' => $last_name,
              'gender' => $gender,
              'birthday' => $birthday 
      ),
      'consents' => array(
        'sms_marketing' => array('status'=>$sms_marketing),
        'email_marketing' => array('status'=>$email_marketing),
        'dmp_profiling' => array('status'=>$dmp_profiling),
        'cookie_tracking' => array('status'=>$cookie_tracking)
      ),
      'send_sms_welcome_message' => 'true',
      'password' => $password
    );
    if(!empty($password) && $password == $c_password){
      $data = $loyalty->createLoyaltyMember($memberData);
      foreach ($data->errors->properties as $key => $value) {
          foreach ($value->error as $kError => $vError) {
            $error .=  "Field : ".$kError."<br>";
            foreach ($vError as $kField => $vField) {
              if($vField->error == "minimum_years_since"){
                $error .= "<p>The minimum age is $vField->limit years</p><br>";
              }
            } 
          } 
      }
      if(!empty($data->errors->msisdn)){
        $error .=  "Field : Phone<br>";
        $error .= "<p>is not valid</p><br>";
      }
    }else{
      $error = "password and confirmation do not match";
    }
    // echo "<pre>";
    // print_r($data);
}elseif (!empty($_POST['edit_information_form']) && $_POST['edit_information_form'] == 1) {
  $first_name = $_POST['fname'];
  $last_name = $_POST['lname'];
  $gender = $_POST['gender'];
  $birthday = $_POST['birthday'];
  $sms_marketing = $_POST['sms_marketing'];
  $email_marketing = $_POST['email_marketing'];
  $dmp_profiling = $_POST['dmp_profiling'];
  $cookie_tracking = $_POST['cookie_tracking'];
  // $phone = preg_replace('~^[0\D]++|\D++~', '', $_POST['phone']);
  $memberData = array(
    'properties' => array(
        'first_name' => $first_name,
        'last_name' => $last_name,
        'gender' => $gender,
        'birthday' => $birthday,
        // 'msisdn' => $phone
    ),
    'consents' => array(
      'sms_marketing' => array('status'=>$sms_marketing),
      'email_marketing' => array('status'=>$email_marketing),
      'dmp_profiling' => array('status'=>$dmp_profiling),
      'cookie_tracking' => array('status'=>$cookie_tracking)
    ),
    // "Do you want to receive exclusive offers, information and discounts by SMS?"
    // "Do you want to receive exclusive offers, information and discounts by e-mail?"
    'member_id' => $_POST['member_id']
  );
  // echo "<pre>";
  // print_r($_POST);
  // exit;
  $data = $loyalty->editLoyaltyMember($memberData);
  if(!empty($data->id)){
    $updateCustomerInfo = array(
      "first_name" => $first_name,
      "last_name" => $last_name,
      "birthday" => $birthday,
    );  
    $editCustomerShopify = $shopify->Customer($customer_id)->put($updateCustomerInfo);
    $address = array(
      // "phone" => $phone,
      "first_name" => $first_name,
      "last_name" => $last_name,
    );  
    if(!empty($customer_data['addresses'])){
      $default_address = $customer_data['default_address']['id'];
      $shopify->Customer($customer_id)->Address($default_address)->put($address);
    }else{
      $shopify->Customer($customer_id)->Address->post($address);
    }
  }
  $error = "";
  foreach ($data->errors->properties as $key => $value) {
      foreach ($value->error as $kError => $vError) {
        $error .=  "Field : ".$kError."<br>";
        foreach ($vError as $kField => $vField) {
          if($vField->error == "minimum_years_since"){
            $error .= "<p>The minimum age is $vField->limit years</p><br>";
          }
        } 
      } 
  }
  if(!empty($data->errors->msisdn)){
    $error .=  "Field : Phone<br>";
    $error .= "<p>is not valid</p><br>";
  }
  // echo "<pre>";
  // print_r($data);
}
if(!empty($customer_data)){
  // $data_loyalty = $customer->getCustomerByEmail($customer_data['email']);
  $data_loyalty = $loyalty->getLoyaltyPoints($customer_data['email']);
  $data_loyalty = json_decode($data_loyalty,true);
  if(!empty($data_loyalty)){
    // echo "<pre>";
    // print_r($data_loyalty);
    $data_loyalty['data_loyalty'] = true;
    $data_loyalty['customer_exist'] = true;
    $data_loyalty['properties']['bonus_points'] = 2000;
    // $actual_point = $customerRewards->getCustomerRewardsSumByCustomerId($customer_data['id']);
    // $actual_point = !empty($actual_point) ? $actual_point : 0;
    // $data_loyalty['properties']['bonus_points'] = $data_loyalty['properties']['bonus_points'] - $actual_point;
  }elseif(!$data_loyalty){
    $data_loyalty['data_loyalty'] = false;
    $data_loyalty['properties']['first_name'] = $customer_data['first_name'];
    $data_loyalty['properties']['first_name'] = $customer_data['first_name'];
    $data_loyalty['properties']['last_name'] = $customer_data['last_name'];
    $data_loyalty['properties']['msisdn'] = $customer_data['phone'];
  }
}
if(!empty($_GET['rewards_id'])){
  // echo "<pre>";
  // $test = $shopify->DiscountCode()->lookup(array("code"=>"6BS08HX2BGHE"))->get();
  // print_r($test);
  // exit;
  $bonus_points = $data_loyalty['properties']['bonus_points'];
  $bonus_points = !empty($bonus_points) ? $bonus_points : 0;
  $rewards_id = $_GET['rewards_id'];
  $actual_point = $customerRewards->getCustomerRewardsSumByCustomerId($customer_data['id']);
  $actual_point = !empty($actual_point) ? $actual_point : 0;
  $data_rewards = $discount->getDiscountById($rewards_id);
  $actual_point += $data_rewards['points'];
  if($bonus_points >= $actual_point){
    $code = Helper::generateCode(12);
    $customerRewards->create($customer_data['id'],$rewards_id,$data_rewards['points'],$code);
    $value_type = $data_rewards['type'] == 1 ? "percentage" : "fixed_amount"; 
    $value = "-".floatval($data_rewards['value']);
    $customers_ids = array();
    array_push($customers_ids,$customer_data['id']);
    $priceRoleParams = array(
      "value_type" => $value_type,
      "value" => $value,
      "customer_selection" => "prerequisite",
      "target_type" => "line_item",
      "starts_at" => date("Y-m-d H:i:s"),
      "target_selection" => "all",
      "allocation_method" => "across",
      "prerequisite_customer_ids" => $customers_ids,
      "title" => $code,
      "usage_limit" => 1,
      "once_per_customer" => true,
    ); 
    $price_role = $shopify->PriceRule()->post($priceRoleParams);
    $shopify->PriceRule($price_role['id'])->DiscountCode()->post(array("code"=>$code));     
    // $code = Helper::generateCode(12);
    // $customerRewards->create($customer_data['id'],$rewards_id,$data_rewards['points'],$code);
    // $data_price_role = $shopify->PriceRule()->get();
    // $priceRoleColumn = array_column($data_price_role, 'title');
    // $data_price_role_key = array_search($data_rewards['code'],$priceRoleColumn,true);
    // if($priceRoleColumn[$data_price_role_key] == $data_rewards['code']){
    //   $priceRoleId = $data_price_role[$data_price_role_key]['id'];
    //   $customerIds = $data_price_role[$data_price_role_key]['prerequisite_customer_ids'];
    //   if(!in_array($customer_data['id'], $customerIds)){
    //     array_push($customerIds,$customer_data['id']);
    //     $priceRoleParams = array(
    //       "prerequisite_customer_ids" => $customerIds
    //     );
    //     $shopify->PriceRule($priceRoleId)->put($priceRoleParams);
    //   }
    // }else{
    //   $value_type = $data_rewards['type'] == 1 ? "percentage" : "fixed_amount";
    //   $value = "-".floatval($data_rewards['value']);
    //   $customers_ids = array();
    //   array_push($customers_ids,$customer_data['id']);
    //   $priceRoleParams = array(
    //     "value_type" => $value_type,
    //     "value" => $value,
    //     "customer_selection" => "prerequisite",
    //     "target_type" => "line_item",
    //     "starts_at" => date("Y-m-d H:i:s"),
    //     "target_selection" => "all",
    //     "allocation_method" => "across",
    //     "prerequisite_customer_ids" => $customers_ids,
    //     "title" => $data_rewards['code']
    //   ); 
    //   $price_role = $shopify->PriceRule()->post($priceRoleParams);
    //   $shopify->PriceRule($price_role['id'])->DiscountCode()->post(array("code"=>$data_rewards['code']));
    // }
  }
}
?>
<div>
<ul class="nav nav-tabs" role="tablist" style="margin-bottom: 30px;">
  <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php if($data_loyalty['data_loyalty']){echo "Information";}else{echo "Create Member";}?></a></li>
  <?php if($data_loyalty['data_loyalty']){ ?>
  <li role="presentation"><a href="#edit_member" aria-controls="edit_member" role="tab" data-toggle="tab">Edit member</a></li>  
  <li role="presentation"><a href="#rewards" aria-controls="rewards" role="tab" data-toggle="tab">Rewards</a></li>
  <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Store</a></li>
  <!--<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li> -->
  <?php } ?>  
</ul>
<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="home">
    <?php 
      if($data_loyalty['data_loyalty']){
        require_once __DIR__ . "/tabs/member_information.php";
      }else{
        require_once __DIR__ . "/tabs/create_member.php";
      }
    ?>
  </div>
  <div role="tabpanel" class="tab-pane" id="edit_member">
    <?php if($data_loyalty['data_loyalty']){require_once __DIR__ . "/tabs/edit_member.php";} ?>
  </div>
  <?php if($data_loyalty['data_loyalty']){ ?>
    <div role="tabpanel" class="tab-pane" id="rewards">
      <?php require_once __DIR__ . "/tabs/rewards_member.php";?>
    </div>
  <?php } ?>
  <?php if($data_loyalty['data_loyalty']){ ?>
    <div role="tabpanel" class="tab-pane" id="messages">
      <?php require_once __DIR__ . "/tabs/store_member.php";?>
    </div>
  <?php } ?>
  <div role="tabpanel" class="tab-pane" id="settings">...</div>
</div>
</div>
<?php
require_once __DIR__ . "/footer.php";
?>
