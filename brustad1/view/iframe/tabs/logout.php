<?php
ob_start(); 
require_once __DIR__ . "/../header.php";
$loyalty = new Loyalty();
$userSession = new UserSession();
$phone = $data_loyalty['properties']['msisdn'];
$phone = preg_replace('~^[0\D]++|\D++~', '', $phone);
$data_session = $userSession->getUserSessionByMsisdn($phone);
$token_data = array(
    "token" => $data_session['token']
);
$loyalty->revokeToken($token_data);
header("Location: ".root_path."/view/iframe?customer_id=".$_GET['customer_id']."&shop=".$_GET['shop']);
exit;