<?php 
    ob_start(); 
    require_once __DIR__ . "/../header.php";  
    $userSession = new UserSession();
    $loyalty = new Loyalty();
    $customer_id = $_GET['customer_id'];
    $shopUrl = $_GET['shop'];
    if(!empty($_POST) && $_POST['login_loyalty'] == 1){
        $msisdn = $_POST['msisdn'];
        $password = $_POST['password'];
        $msisdn = preg_replace('~^[0\D]++|\D++~', '', $msisdn);
        $tokenData = array(
            'grant_type' => 'password',
            'identifier_type' => "msisdn",
            "identifier" => $msisdn,
            "password" => $password
        );
        $data = $loyalty->createToken($tokenData);
        if(!empty($data->error)){
          $error = "Invalid Password";
        }elseif(!empty($data)){
            $dataSession = $userSession->getUserSessionByMsisdn($msisdn);
            if(!empty($dataSession)){
                $userSession->update($msisdn,$data->access_token);
            }else{
                $userSession->create($msisdn,$data->access_token);
            }
            header("Location: ".root_path."/view/iframe?customer_id=".$_POST['customer_id']."&shop=".$_POST['shopUrl']);
            exit;
        }
    }
?>
<div class="login-box-body col-md-8" style="margin:auto;">
    <h3 class="login-box-msg">Login Loyalty System</h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop']; ?>">
      <input type="hidden" name="login_loyalty" value="1">
      <div class="form-group has-feedback">
        <input type="hidden" name="customer_id" value="<?php echo $customer_id;?>" >
        <input type="hidden" name="shopUrl" value="<?php echo $shopUrl;?>" >
        <input type="hidden" name="msisdn" value="<?php echo $data_loyalty['properties']['msisdn'];?>" >
        <input type="text" name="msisdn-show" required="1" value="<?php echo $data_loyalty['properties']['msisdn'];?>" disabled class="form-control" placeholder="Phone">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
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
              <button type="submit" style="width: 100%;" class="btn btn-primary">Sign In</button>
            </div>
          </div>
      </div>
    </form>
  </div>
