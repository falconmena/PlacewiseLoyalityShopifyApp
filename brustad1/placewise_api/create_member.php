<?php
//header('Content-Type: application/json');
//ini_set('display_errors', 1); 
//ini_set('display_startup_errors', 1); 
//error_reporting(E_ALL);
include_once(dirname(__FILE__) . '/inc/Lib.php');
if(!empty($_POST)){
//   $_POST = array(
//     "email"=>"rami@boost.no",
//     "msisdn"=>"4741238538",
//     "first_name"=>"rami",
//     "last_name"=>"makhamreh",
//     "gender"=>"man",
//     "birthday"=>"1995-03-09",
//     "password"=>"ramirami",
//     "send_sms_welcome_message"=>"true"    
//   );
//   echo '<h1>request</h1>';
//   echo "<h3>Route : POST</h3>";
//   echo "<h3>Link : https://bpc-api.boostcom.no/v3/day-oslo/members</h3>";
//   echo "<h3>headers</h3>";
//   echo 'content-type: application/json'.'<br>';
//   echo 'x-product-name:tech-factory'.'<br>';
//   //echo 'X-Client-Authorization:t8TUL14JeENJEenmzyzBKc4s'.'<br>';
//   echo 'X-User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0'.'<br>';  
//   echo '{'.'<br>';
//   echo "'email':'rami@boost.no',<br>
//     'msisdn':'4741238538',<br>
//     'first_name':'rami',<br>
//     'last_name':'makhamreh',<br>
//     'gender':'man',<br>
//     'birthday':'1995-03-09',<br>
//     'password':'ramirami',<br>
//     'send_sms_welcome_message':'true'<br>"; 
//   echo '}'.'<br>';
  $customer = CreatMember(json_encode($_POST));
  $data = $customer;
//   echo "<h3>Response</h3>";
  //$data = json_encode(array("1"));
  print $data;
  exit;
}else {
  echo 'Not Valid Request';
  exit;
}
?>
