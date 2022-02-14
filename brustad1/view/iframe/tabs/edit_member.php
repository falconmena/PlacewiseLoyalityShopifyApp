<?php
ob_start(); 
require_once __DIR__ . "/../header.php";
$loyalty = new Loyalty();
if (!empty($_POST['edit_information_form']) && $_POST['edit_information_form'] == 1) {
  $first_name = $_POST['fname'];
  $last_name = $_POST['lname'];
  $gender = $_POST['gender'];
  $birthday = $_POST['birthday'];
  $sms_marketing = $_POST['sms_marketing'];
  $email_marketing = $_POST['email_marketing'];
  $dmp_profiling = $_POST['dmp_profiling'];
  $cookie_tracking = $_POST['cookie_tracking'];
  $phone = preg_replace('~^[0\D]++|\D++~', '', $_POST['phone']);
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
    'member_id' => $_POST['member_id']
  );
  $data = $loyalty->editLoyaltyMember($memberData);
  if(!empty($data->id)){
    $updateCustomerInfo = array(
      "first_name" => $first_name,
      "last_name" => $last_name,
      "birthday" => $birthday,
    );  
    $editCustomerShopify = $shopify->Customer($customer_id)->put($updateCustomerInfo);
    $address = array(
      "first_name" => $first_name,
      "last_name" => $last_name,
    );  
    if(!empty($customer_data['addresses'])){
      $default_address = $customer_data['default_address']['id'];
      $shopify->Customer($customer_id)->Address($default_address)->put($address);
    }else{
      $shopify->Customer($customer_id)->Address->post($address);
    }
    header("Location: ".root_path."/view/iframe?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop']);
    exit;
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
}
// if(!empty($customer_data)){
//   $data_loyalty = $loyalty->getLoyaltyPoints($customer_data['email']);
//   $data_loyalty = json_decode($data_loyalty,true);
//   if(!empty($data_loyalty)){
//     $data_loyalty['data_loyalty'] = true;
//     $data_loyalty['customer_exist'] = true;
//     $data_loyalty['properties']['bonus_points'] = 2000;
//   }elseif(!$data_loyalty){
//     $data_loyalty['data_loyalty'] = false;
//     $data_loyalty['properties']['first_name'] = $customer_data['first_name'];
//     $data_loyalty['properties']['first_name'] = $customer_data['first_name'];
//     $data_loyalty['properties']['last_name'] = $customer_data['last_name'];
//     $data_loyalty['properties']['msisdn'] = $customer_data['phone'];
//   }
// }

?>
<div class="content-wrapper" style="margin-top:0;">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Member</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Member</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="row">
        <div class="col-md-9" style="margin: auto;">
          <div class="box box-warning">
            <div class="box-body">
              <form method="POST" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop']; ?>">  
                <input type="hidden" name="email" value="<?php echo $customer_data['email']; ?>"/>
                <input type="hidden" name="member_id" value="<?php echo $data_loyalty['id']; ?>"/>    
                <input type="hidden" name="edit_information_form" value="1"/>
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
                <!-- <input type="text" required name="phone"  class="form-control" id="staticLname" /> -->
                <div class="form-group">
                  <label>Birthday</label>
                  <div class="input-group date" >
                      <input type="date" name="birthday" required value="<?php echo $data_loyalty['properties']['birthday'];?>" class="form-control pull-right" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                  </div>
                </div>


                <div class="form-group">
                  <label style="display:block;">Do you want to receive exclusive offers, information and discounts by SMS?</label>
                  <div class="radio" style="display: inline-block;margin-left: 20px;">
                    <label>
                    <input class="form-check-input" type="radio" name="sms_marketing" <?php if($data_loyalty['consents']['sms_marketing']['status']){echo "checked";} ?> value="true">
                      Yes
                    </label>
                  </div>
                  <div class="radio" style="display: inline-block;margin-left: 24px;">
                    <label>
                    <input class="form-check-input" type="radio" name="sms_marketing" <?php if(!$data_loyalty['consents']['sms_marketing']['status']){echo "checked";} ?>  value="false">
                      No
                    </label>
                  </div>
                </div>

                <div class="form-group">
                  <label style="display:block;">Do you want to receive exclusive offers, information and discounts by e-mail?</label>
                  <div class="radio" style="display: inline-block;margin-left: 20px;">
                    <label>
                    <input class="form-check-input" type="radio" name="email_marketing" <?php if($data_loyalty['consents']['email_marketing']['status']){echo "checked";} ?> value="true">
                      Yes
                    </label>
                  </div>
                  <div class="radio" style="display: inline-block;margin-left: 24px;">
                    <label>
                    <input class="form-check-input" type="radio" name="email_marketing" <?php if(!$data_loyalty['consents']['email_marketing']['status']){echo "checked";} ?> value="false">
                      No
                    </label>
                  </div>
                </div>

                <div class="form-group">
                  <label style="display:block;">Do you want to receive customized offers?</label>
                  <div class="radio" style="display: inline-block;margin-left: 20px;">
                    <label>
                    <input class="form-check-input" type="radio" name="dmp_profiling" <?php if($data_loyalty['consents']['dmp_profiling']['status']){echo "checked";} ?> value="true">
                      Yes
                    </label>
                  </div>
                  <div class="radio" style="display: inline-block;margin-left: 24px;">
                    <label>
                    <input class="form-check-input" type="radio" name="dmp_profiling" <?php if(!$data_loyalty['consents']['dmp_profiling']['status']){echo "checked";} ?> value="false">
                      No
                    </label>
                  </div>
                </div>

                <div class="form-group">
                  <label style="display:block;">Do you agree that we store cookies on your device?</label>
                  <div class="radio" style="display: inline-block;margin-left: 20px;">
                    <label>
                    <input class="form-check-input" type="radio" name="cookie_tracking" <?php if($data_loyalty['consents']['cookie_tracking']['status']){echo "checked";} ?> value="true">
                      Yes
                    </label>
                  </div>
                  <div class="radio" style="display: inline-block;margin-left: 24px;">
                    <label>
                    <input class="form-check-input" type="radio" name="cookie_tracking" <?php if(!$data_loyalty['consents']['cookie_tracking']['status']){echo "checked";} ?> value="false">
                      No
                    </label>
                  </div>
                </div>
                <div class="form-group" >
                    <label for="staticsubmit" class="col-sm-4"></label>
                    <div class="col-sm-8" >
                      <button type="submit" style="width: 100%;" class="btn btn-primary">Edit Member</button>
                    </div>
                </div>
                <!-- <div class="form-group" style="width: 70%;margin: auto;">
                    <label class="col-sm-4"></label>
                    <div class="col-sm-8" style="margin-top: 25px;">
                      <?php if(!empty($error)) {echo $error;} ?>
                    </div>
                </div> -->
              </form>
            </div>
          </div>  
        </div>
      </div>
    </section>
</div>
<?php
require_once __DIR__ . "/../footer.php";
?>



