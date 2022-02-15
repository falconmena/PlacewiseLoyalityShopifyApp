<?php

class CustomerRewards extends Database{
        
    public function create($customer_id,$rewards_id,$points,$code,$store_id){
        $db = $this->openConnection();
        $sql = "insert into `customer_rewards`(`customer_id`,`discount_id`,`points`,`code`,`store_id`) values ('$customer_id','$rewards_id','$points','$code','$store_id')";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function getCustomerRewardsByCustomerId($store_id,$id){
        $db = $this->openConnection();
        $stmt = $db->prepare('SELECT * FROM customer_rewards where customer_id = :id and store_id = :store_id order by id desc  ');
        $stmt->execute(['id' => $id,'store_id' => $store_id]);
        $data = $stmt->fetchAll();
        $this->closeConnection();
        return $data;
    }
    public function getCustomerRewardsByRewardsId($id){
        $db = $this->openConnection();
        $stmt = $db->prepare('SELECT * FROM customer_rewards where discount_id = :id ');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();
        $this->closeConnection();
        return $data;
    }
    public function getCustomerRewardsByRewardsIdAndCustomerId($discount_id,$customer_id){
        $db = $this->openConnection();
        $stmt = $db->prepare('SELECT * FROM customer_rewards where discount_id = :discount_id and customer_id = :customerId and used = 0 ');
        $stmt->execute(['discount_id' => $discount_id,'customerId' => $customer_id]);
        $data = $stmt->fetchAll();
        $this->closeConnection();
        return $data;
    }
    public function getCustomerRewardsSumByCustomerId($id,$store_id){
        $db = $this->openConnection();
        $stmt = $db->prepare('SELECT sum(points) as actual_point FROM customer_rewards where customer_id = :id and store_id = :store_id ');
        $stmt->execute(['id' => $id,'store_id' => $store_id]);
        $data = $stmt->fetch();
        $this->closeConnection();
        return $data['actual_point'];
    }
    public function getCustomerRewardsCountByCustomerId($id){
        $db = $this->openConnection();
        $stmt = $db->prepare('select count(*) counter,a.customer_id,a.discount_id,a.code,b.points,b.type,b.value,b.title from customer_rewards a , discount b
                                where customer_id = :id and a.discount_id = b.id and used = 0
                                group by discount_id,customer_id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetchAll();
        $this->closeConnection();
        return $data;
    }
    public function updateUsed($id){
        $db = $this->openConnection();
        $sql = "update `customer_rewards` set `used`  = '1'  where `id` = $id ";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function updateUsedByCode($store_id,$code,$customer_id){
        $db = $this->openConnection();
        $sql = "update `customer_rewards` set `used`  = '1'  where `code` = '$code' and `customer_id` = $customer_id  and `store_id` = $store_id ";
        $db->exec($sql);
        $this->closeConnection();
    }
    public function addRewardsDataByCustomer($data_shop,$layoltyPoints,$store_id){
        $get_points = $data_shop['points'];
        $get_points = !empty($get_points) ? $get_points : 0;
        $bonus_points = $layoltyPoints['properties']['bonus_points'];
        $bonus_points = !empty($bonus_points) ? $bonus_points : 0;
        $actual_point = $this->getCustomerRewardsSumByCustomerId($data_shop['customer_id'],$store_id);
        $actual_point = !empty($actual_point) ? $actual_point : 0;
        $actual_point += $get_points;
        $final_actual_point = floatval($bonus_points) - floatval($actual_point);
        $final_actual_point = number_format($final_actual_point, 2);
        
        if($bonus_points >= $actual_point){
            $code = Helper::generateCode(12);
            $this->create($data_shop['customer_id'],0,$get_points,$code,$store_id);
            $value_type = "fixed_amount"; 
            $value = "-".floatval($get_points);
            $customers_ids = array();
            array_push($customers_ids,$data_shop['customer_id']);
            $priceRoleParams = array(
                "value_type" => $value_type,
                "value" => $value,
                "customer_selection" => "prerequisite",
                "target_type" => "line_item",
                "starts_at" => date("Y-m-d H:i:s"),
                "target_selection" => "all",
                "allocation_method" => "across",
                "prerequisite_customer_ids" => $customers_ids,
                "title" => $code,
                "usage_limit" => 1,
                "once_per_customer" => true,
            ); 
            $data['code'] = $code;
            $data['add_reward'] = 1;
            $data['actual_point'] = $final_actual_point;
            $data['priceRoleParams'] = $priceRoleParams;
        }else{
            $data['add_reward'] = 0;
            $data['error'] = 1; // You don't have enough points
        }
        return $data;   
    }
        
}
?>