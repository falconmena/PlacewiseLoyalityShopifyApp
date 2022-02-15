<?php

class Store extends Database{
        
    public function create($shop_url,$token,$api_key,$shared_secret,$pw_production,$pw_product_name,$pw_slug,$pw_client_authorization){
        $db = $this->openConnection();
        $sql = "insert into `store`(`shop_url`,`token`,`api_key`,`shared_secret`,`pw_production`,`pw_product_name`,`pw_slug`,`pw_client_authorization`) values ('$shop_url','$token','$api_key','$shared_secret','$pw_production','$pw_product_name','$pw_slug','$pw_client_authorization')";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function update($shop_url,$token,$api_key,$shared_secret,$pw_production,$pw_product_name,$pw_slug,$pw_client_authorization){
        $db = $this->openConnection();
        $sql = "update `store` set `token`  = '$token',`api_key`  = '$api_key',`shared_secret`  = '$shared_secret',`pw_production`  = '$pw_production',`pw_product_name`  = '$pw_product_name',`pw_slug`  = '$pw_slug',`pw_client_authorization`  = '$pw_client_authorization'  where `shop_url` = '$shop_url' ";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function delete($shop_url){
        $db = $this->openConnection();
        $sql = "delete from `store` where `shop_url` = '$shop_url' ";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function getStoreByShop_url($shop_url){
        $db = $this->openConnection();
        $stmt = $db->prepare('select * FROM store where shop_url = :shop_url ');
        $stmt->execute(['shop_url' => $shop_url]);
        $data = $stmt->fetch();
        $this->closeConnection();
        return $data;
    }
        
}
?>