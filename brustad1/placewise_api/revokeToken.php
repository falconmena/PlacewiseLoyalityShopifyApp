<?php
header('Content-Type: application/json');
include_once(dirname(__FILE__) . '/inc/Lib.php');
if(!empty($_POST)){
  $data = revokeToken(json_encode($_POST));
  print $data;
  exit;
}else {
  echo 'Not Valid Request';
  exit;
}
?>

