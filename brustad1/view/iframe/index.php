<?php
// session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once __DIR__ . "/header.php";
// $auth = new Auth();
// $customer_data = array(
//     "id" => "12312321321321321",
//     "email" => "abusubhiam@gmail.com",
// );
// $data = $auth->CreateJwtToken($customer_data);
// print_r($data['token']);
// print_r("0-------");
// print_r($auth->DecodeJwtToken($data['token']));
// $_SESSION["color"] = "green";
// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';

$customerRewards = new CustomerRewards();
// $loyalty = new Loyalty();
$point_used = $customerRewards->getCustomerRewardsSumByCustomerId($customer_data['id']);
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
            <h1 class="m-0">Information</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Information</li>
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
              <div class="box box-primary">
                    <div class="box-body">
                      <strong><i class="fa fa-gift margin-r-5"></i> Points</strong>
                      <p class="text-muted">
                      <?php echo (!empty($data_loyalty['properties']['bonus_points']) ?  $data_loyalty['properties']['bonus_points'] : 0);?>
                      </p>
                      <hr>
                      <strong><i class="fa fa-fw fa-hourglass-half  margin-r-5"></i> Points used</strong>
                      <p class="text-muted"><?php echo (!empty($point_used) ? $point_used : 0);?></p>
                      <hr>
                      <strong><i class="fa fa-fw fa-info-circle  margin-r-5"></i> Username</strong>
                      <p class="text-muted">
                        <?php echo $data_loyalty['properties']['first_name']." ".$data_loyalty['properties']['last_name'];?>
                      </p>
                      <hr>
                      <strong><i class="fa fa-envelope  margin-r-5"></i> Email</strong>
                      <p class="text-muted">
                      <?php echo $data_loyalty['properties']['email'];?>
                      </p>
                      <hr>
                      <strong><i class="fa fa-fw fa-phone  margin-r-5"></i> Phone</strong>
                      <p class="text-muted">
                      <?php echo $data_loyalty['properties']['msisdn'];?>
                      </p>
                      <hr>
                      <strong><i class="fa fa-fw fa-male  margin-r-5"></i> Gender</strong>
                      <p class="text-muted">
                      <?php echo $data_loyalty['properties']['gender'];?>
                      </p>
                      <hr>
                      <strong><i class="fa fa-calendar  margin-r-5"></i> Birthday</strong>
                      <p class="text-muted">
                      <?php echo $data_loyalty['properties']['birthday'];?>
                      </p>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>            
    </section>
  </div>
<?php
require_once __DIR__ . "/footer.php";
?>

