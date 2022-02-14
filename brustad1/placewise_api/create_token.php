<?php
header('Content-Type: application/json');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include_once(dirname(__FILE__) . '/inc/Lib.php');
if(!empty($_POST)){
  /*$test = array(
      "grant_type" => "password",
      "identifier_type" => "id",
      "identifier" => "53056739",
      "password" => "test"
  );*/
  $data = CreateToken(json_encode($_POST));
  print $data;
  exit;
}else {
  echo 'Not Valid Request';
  exit;
}
?>

