<?php

Class Store extends Connection  {

    public function create($shop_url,$token){
        $db = $this->openConnection();
        $sql = "insert into `store`(`shop_url`,`token`) values ('$shop_url','$token')";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function update($shop_url,$token){
        // echo $code . " ".$points." ".$id;
        // exit;
        $db = $this->openConnection();
        $sql = "update `store` set `token`  = '$token'  where `shop_url` = '$shop_url' ";
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