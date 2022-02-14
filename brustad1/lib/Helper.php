<?php
class Helper{
    public static function validateHmac($params, $secret) {
        $hmac = $params['hmac'];
        unset($params['hmac']);
        ksort($params);
        $computedHmac = hash_hmac('sha256', http_build_query($params), $secret);
        return hash_equals($hmac, $computedHmac);
    }    
    public static function validateShopDomain($shop) {
        $substring = explode('.', $shop);
        if (count($substring) != 3) {
          return FALSE;
        }
        $substring[0] = str_replace('-', '', $substring[0]);
        return (ctype_alnum($substring[0]) && $substring[1] . '.' . $substring[2] == 'myshopify.com');
    } 
    public static function generateCode($length){
      return strtoupper(substr(md5(time()), 0, $length));
    }
    
}
