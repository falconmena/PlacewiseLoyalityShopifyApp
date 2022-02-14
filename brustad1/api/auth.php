<?php

require_once __DIR__ . "/../etc/config.php";
$json = json_decode(file_get_contents('php://input'), true);
if ($json == null) {
    $json = $_REQUEST;
}
$type = $json['type'];
$auth = new Auth();
switch ($type) {
    case "CreateJwtToken":
        $id = $json['id'];
        if(!empty($id)){
            $data = $shopify->Customer($id)->get();
            $data = json_encode($auth->CreateJwtToken($data));
        }else{
            $data = array();
            $data = json_encode($data);
        }
        break;
    default:
        $data = 'Nothing found';
        break;
}

if ($json['test'] == 1) {
   //print '<pre>';
   print_r($data);
   exit;
}
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT');
header('Content-Type: application/json');
print $data;    
exit;