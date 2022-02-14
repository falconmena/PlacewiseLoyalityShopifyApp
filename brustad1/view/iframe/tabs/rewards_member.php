<?php
ob_start(); 
require_once __DIR__ . "/../header.php";
$customerRewards = new CustomerRewards();
$data_all_rewards = $customerRewards->getCustomerRewardsCountByCustomerId($customer_data['id']);
?>
<div class="content-wrapper" style="margin-top:0;">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Rewards</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Rewards</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
        <div class="row card-group-row mb-40pt" style="margin: 10px 40px 40px 40px;">
            <?php foreach ($data_all_rewards as $key => $value) { ?>
            <div class="col-lg-4 col-sm-4 card-group-row__col mb-2">
                <div class="card card-group-row__card text-center o-hidden card--raised navbar-shadow" style="height: 100%;margin-bottom: 0;">
                    <div class="card-body d-flex flex-column">
                        <div class="flex-grow-1 mb-16pt" style="height: 100%;">
                            <h4 class="mb-8pt"><?php echo $value['code']; ?></h4>
                            <p class="text-black-70"><?php echo $value['title'];?></p>
                        </div>          
                    </div>
                    <div class="card-footer">
                        Current Balance : <?php echo $value['counter'];?>
                    </div>
                </div>
            </div>    
            <?php } ?>  
            <?php if(empty($data_all_rewards)){ ?>
                <h3 style="margin: auto;">There is no rewards to display</h3>
            <?php } ?>   
        </div>
    </section>
</div>
<?php
require_once __DIR__ . "/../footer.php";
?>