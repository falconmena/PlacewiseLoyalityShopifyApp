<?php

Class UserSession extends Connection  {

    public function create($msisdn,$token){
        $db = $this->openConnection();
        $sql = "insert into `user_session`(`msisdn`,`token`) values ('$msisdn','$token')";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function update($msisdn,$token){
        // echo $code . " ".$points." ".$id;
        // exit;
        $db = $this->openConnection();
        $sql = "update `user_session` set `token`  = '$token'  where `msisdn` = '$msisdn' ";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function getUserSessionByMsisdn($msisdn){
        $db = $this->openConnection();
        $stmt = $db->prepare('select * FROM user_session where msisdn = :msisdn ');
        $stmt->execute(['msisdn' => $msisdn]);
        $data = $stmt->fetch();
        $this->closeConnection();
        return $data;
    }
}
?>