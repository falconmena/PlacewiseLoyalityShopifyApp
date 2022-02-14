<?php
  $point_used = $customerRewards->getCustomerRewardsSumByCustomerId($customer_data['id']);
?>
<div class="container">
    <div class="main-body">
        <div class="row gutters-sm">
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                      <h6 class="mb-0">Points</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                      <?php echo (!empty($data_loyalty['properties']['bonus_points']) ?  $data_loyalty['properties']['bonus_points'] : 0);?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      <h6 class="mb-0">Points used</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                      <?php echo (!empty($point_used) ? $point_used : 0);?>
                    </div>
                  </div>
                  <hr>
                    <div class="row">
                    <div class="col-sm-4">
                      <h6 class="mb-0">First name</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                      <?php echo $data_loyalty['properties']['first_name'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      <h6 class="mb-0">Last name</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                        <?php echo $data_loyalty['properties']['last_name'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                        <?php echo $data_loyalty['properties']['email'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                        <?php echo $data_loyalty['properties']['msisdn'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      <h6 class="mb-0">Gender</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                        <?php echo $data_loyalty['properties']['gender'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Birthday</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            <?php echo $data_loyalty['properties']['birthday'];?>
                        </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>    
