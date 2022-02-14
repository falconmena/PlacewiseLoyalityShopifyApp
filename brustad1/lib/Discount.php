<?php

Class Discount extends Connection  {

    public function create($title,$type,$value,$points){
        $db = $this->openConnection();
        $sql = "insert into `discount`(`title`,`type`,`value`,`points`) values ('$title','$type','$value','$points')";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function update($title,$type,$value,$points,$id){
        // echo $code . " ".$points." ".$id;
        // exit;
        $db = $this->openConnection();
        $sql = "update `discount` set `title`  = '$title' ,`type`  = '$type',`value`  = '$value' , `points`  = '$points' where `id` = $id ";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function delete($id){
        $db = $this->openConnection();
        $sql = "delete from `discount` where `id` = $id ";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function getAllDiscount(){
        $db = $this->openConnection();
        $stmt = $db->prepare('SELECT * FROM discount');
        $stmt->execute();
        $data = $stmt->fetchAll();
        $this->closeConnection();
        return $data;
    }
    public function getDiscountById($id){
        $db = $this->openConnection();
        $stmt = $db->prepare('SELECT * FROM discount where id = :id ');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();
        $this->closeConnection();
        return $data;
    }
    public function getDiscountByCode($code){
        $db = $this->openConnection();
        $stmt = $db->prepare('SELECT * FROM discount where code = :code ');
        $stmt->execute(['code' => $code]);
        $data = $stmt->fetch();
        $this->closeConnection();
        return $data;
    }
}
?>