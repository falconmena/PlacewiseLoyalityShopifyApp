<?php

Class Customer extends Connection  {
    public function create($first_name,$last_name,$gender,$age,$phone,$concents,$email){
        $db = $this->openConnection();
        $sql = "insert into `customers`(`first_name`,`last_name`,`gender`,`age`,`phone`,`Concents`,`email`) values ('$first_name','$last_name','$gender','$age','$phone','$concents','$email')";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function update($first_name,$last_name,$gender,$age,$phone,$concents,$email){
        $db = $this->openConnection();
        $sql = "update `customers` set `first_name` = '$first_name' , `last_name`  = '$last_name' , `gender`  = '$gender' , `age`  = '$age' , `phone`  = '$phone', `Concents`  = '$concents' where `email` = '$email' ";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function getCustomerByEmail($email){
        $db = $this->openConnection();
        $stmt = $db->prepare('select * FROM customers where email = :email ');
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();
        $this->closeConnection();
        return $data;
    }
}
?>