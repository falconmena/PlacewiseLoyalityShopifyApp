<?php
ob_start(); 
require_once __DIR__ . "/../header.php";
$discount = new Discount();
$customerRewards = new CustomerRewards();
$data_discount = $discount->getAllDiscount();
$point_used = $customerRewards->getCustomerRewardsSumByCustomerId($customer_data['id']);
$point_used = !empty($point_used) ? $point_used : 0;
if(!empty($_GET['rewards_id'])){
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
        header("Location: ".root_path."/view/iframe/tabs/rewards_member.php?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop']);
        exit;
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
<div class="content-wrapper" style="margin-top:0;">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Store</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Store</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
        <div class="row card-group-row mb-40pt" style="margin: 10px 40px 40px 40px;">
            <?php foreach ($data_discount as $key => $value) { ?>
            <div class="col-lg-4 col-sm-4 card-group-row__col mb-2">
                <div class="card card-group-row__card text-center o-hidden card--raised navbar-shadow" style="height: 100%;margin-bottom: 0;">
                    <div class="card-body d-flex flex-column">
                        <div class="flex-grow-1 mb-16pt" style="height: 100%;">
                            <h4 class="mb-8pt"><?php echo $value['points'] ." Points";  ?></h4>
                            <p class="text-black-70"><?php echo $value['title'];?></p>
                        </div>          
                    </div>
                    <div class="card-footer">
                        <?php if($data_loyalty['properties']['bonus_points'] >= ($value['points'] + $point_used)){
                        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"."&rewards_id=".$value['id'];     
                        ?>
                        <a href="<?php echo $actual_link;?>" class="btn btn-success">Earning point</a>
                        <?php }else{ ?>
                        <a class="btn btn-outline-secondary disabled">More points needed</a>
                        <?php } ?>
                    </div>
                </div>
            </div>    
            <?php } ?>   
            <?php if(empty($data_discount)){ ?>
                <h3 style="margin: auto;">There is no rewards to display</h3>
            <?php } ?>          
        </div>
    </section>
</div>
<?php
require_once __DIR__ . "/../footer.php";
?>

