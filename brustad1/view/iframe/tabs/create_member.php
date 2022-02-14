<?php
  ob_start(); 
  require_once __DIR__ . "/../header.php";  
  if(!empty($data_loyalty) && $data_loyalty['data_loyalty']){
    header("Location: ".root_path."/view/iframe?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop']);
    exit();
  }
  $loyalty = new Loyalty();
  $userSession = new UserSession();
  $customer_id = $_GET['customer_id'];
  $shopUrl = $_GET['shop'];
  if(!empty($_POST['information_form']) && $_POST['information_form'] == 1){
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
      $error = "";
      $error_count = 0;
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
        $error_count = 0;
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
      if($error_count != 1){
        $updateCustomerInfo = array(
          "first_name" => $first_name,
          "last_name" => $last_name,
          "phone" => $phone
        );  
        $editCustomerShopify = $shopify->Customer($customer_id)->put($updateCustomerInfo);
        // $tokenData = array(
        //   'grant_type' => 'password',
        //   'identifier_type' => "msisdn",
        //   "identifier" => $phone,
        //   "password" => $password
        // );
        // $data = $loyalty->createToken($tokenData);
        // $dataSession = $userSession->getUserSessionByMsisdn($phone);
        // if(!empty($dataSession)){
        //     $userSession->update($phone,$data->access_token);
        // }else{
        //     $userSession->create($phone,$data->access_token);
        // }
        header("Location: ".root_path."/view/iframe?customer_id=".$_POST['customer_id']."&shop=".$_POST['shopUrl']);
        exit();
      }
  }
?>
<div class="login-box-body col-md-8" style="margin:auto;">
    <h3 class="login-box-msg">Create Loyalty Member</h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop']; ?>">
      <input type="hidden" name="customer_id" value="<?php echo $customer_id;?>" >
      <input type="hidden" name="shopUrl" value="<?php echo $shopUrl;?>" >
      <input type="hidden" name="email" value="<?php echo $customer_data['email']; ?>"/>
      <?php if(!empty($customer_data['phone'])){ ?>
      <input type="hidden" name="phone" value="<?php echo $customer_data['phone']; ?>"/>
      <?php } ?>
      <input type="hidden" name="information_form" value="1"/>
      <div class="form-group">
        <label>First Name</label>
        <input type="text" required name="fname" value="<?php echo $data_loyalty['properties']['first_name'];?>" class="form-control" id="staticFname" />
      </div>
      <div class="form-group">
        <label>Last Name</label>
        <input type="text" required name="lname" value="<?php echo $data_loyalty['properties']['last_name'];?>" class="form-control" id="staticLname" />
      </div>
      <div class="form-group">
        <label style="display:block;">Gender</label>
        <div class="radio" style="display: inline-block;margin-left: 20px;">
          <label>
          <input class="form-check-input" type="radio" name="gender" <?php if($data_loyalty['properties']['gender'] == "man"){echo "checked";} ?> value="man">
            Man
          </label>
        </div>
        <div class="radio" style="display: inline-block;margin-left: 24px;">
          <label>
          <input class="form-check-input" type="radio" name="gender" <?php if($data_loyalty['properties']['gender'] == "woman"){echo "checked";} ?>  value="woman">
            Woman
          </label>
        </div>
      </div>
      <?php if(empty($customer_data['phone'])){ ?>  
      <div class="form-group">
        <label>Phone number</label>
        <input type="tel" required name="phone"  class="form-control" id="staticphone" />
      </div>
      <?php } ?>
      <div class="form-group">
        <label>Birthday</label>
        <div class="input-group date" >
        <input class="form-control" type="date" required name="birthday" value="<?php echo $data_loyalty['properties']['birthday'];?>" id="birthday-input">
        </div>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" required name="password"  class="form-control" id="staticpassword" />
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" required name="c_password"  class="form-control" id="staticconfirm_password" />
      </div>

      <div class="form-group">
        <label style="display:block;">Do you want to receive exclusive offers, information and discounts by SMS?</label>
        <div class="radio" style="display: inline-block;margin-left: 20px;">
          <label>
          <input class="form-check-input" type="radio" name="sms_marketing"  value="true">
            Yes
          </label>
        </div>
        <div class="radio" style="display: inline-block;margin-left: 24px;">
          <label>
          <input class="form-check-input" type="radio" name="sms_marketing"   value="false">
            No
          </label>
        </div>
      </div>

      <div class="form-group">
        <label style="display:block;">Do you want to receive exclusive offers, information and discounts by e-mail?</label>
        <div class="radio" style="display: inline-block;margin-left: 20px;">
          <label>
          <input class="form-check-input" type="radio" name="email_marketing"  value="true">
            Yes
          </label>
        </div>
        <div class="radio" style="display: inline-block;margin-left: 24px;">
          <label>
          <input class="form-check-input" type="radio" name="email_marketing"  value="false">
            No
          </label>
        </div>
      </div>
      <div class="form-group">
        <label style="display:block;">Do you want to receive customized offers?</label>
        <div class="radio" style="display: inline-block;margin-left: 20px;">
          <label>
          <input class="form-check-input" type="radio" name="dmp_profiling"  value="true">
            Yes
          </label>
        </div>
        <div class="radio" style="display: inline-block;margin-left: 24px;">
          <label>
          <input class="form-check-input" type="radio" name="dmp_profiling"  value="false">
            No
          </label>
        </div>
      </div>
      <div class="form-group">
        <label style="display:block;">Do you agree that we store cookies on your device?</label>
        <div class="radio" style="display: inline-block;margin-left: 20px;">
          <label>
          <input class="form-check-input" type="radio" name="cookie_tracking"  value="true">
            Yes
          </label>
        </div>
        <div class="radio" style="display: inline-block;margin-left: 24px;">
          <label>
          <input class="form-check-input" type="radio" name="cookie_tracking" value="false">
            No
          </label>
        </div>
      </div>
      <?php if(!empty($error)){ ?>
      <div class="form-group" >
          <div class='row'>
            <div class="col-sm-3" style="margin:auto;">
              <span style="color: #dd4b39;"><?php echo $error;?></span>
            </div>
          </div>
      </div>        
      <?php } ?>
      <div class="form-group" >
          <div class='row'>
            <div class="col-sm-4" style="margin:auto;">
              <button type="submit" style="width: 100%;" class="btn btn-primary">Create Member</button>
            </div>
          </div>
      </div>
    </form>
</div>
