<?php
// header('Content-Type: application/json');
require_once __DIR__. "/../jwt/autoload.php";
use \Firebase\JWT\JWT;
class Auth {
    public $key = "hh_uy253kPRv#eaAH@#MX!mcfxPUAS";
    public function CreateJwtToken($customer_data){
        $iat = time();
        $exp = $iat + 60 * 60;
        $payload = array(
            "customer_id" => $customer_data['id'],
            "email" => $customer_data['email'],
            "iat" => $iat,
            "exp" => $exp
        );
        $token = JWT::encode($payload, $this->key , "HS512");
        $data['status'] = "ok";
        $data['token'] = $token;
        return $data;
    }
    public function DecodeJwtToken($token){
        $data = JWT::decode($token, $this->key, array('HS512'));
        return $data;
    }

}
