<?php

    class PlacewiseApi{
        
        public function membersInfoByEmail($shop_url = "",$email = ""){
            $placewiseLib = new PlacewiseLib($shop_url);
            $data = $placewiseLib->MembersInfoByEmail($email);
            print json_encode($data);
            exit;
        }
        public function loyalty_points_by_phone($shop_url = "",$msisdn = ""){
            $placewiseLib = new PlacewiseLib($shop_url);
            $data = $placewiseLib->MembersByMSISDN($msisdn);
            print json_encode($data);
            exit;
        }
        public function create_member($shop_url = ""){
            // $shop_url = $_POST['shop_url'];
            $params = json_encode($_POST);
            $placewiseLib = new PlacewiseLib($shop_url);
            $data = $placewiseLib->CreatMember($params);
            print $data;
            exit;
        }
        public function edit_member(){
            $member_id =  $_POST['member_id'];
            $shop_url = $_POST['shop_url'];
            unset($_POST['member_id']);
            unset($_POST['shop_url']);
            $placewiseLib = new PlacewiseLib($shop_url);
            // $member = array(
            //     "properties" => array(
            //         "last_name" => ""
            //     )
            // );	
            $data = $placewiseLib->editMember(json_encode($_POST),$member_id);
            print $data;
            exit;
        }
        public function create_token(){
            $shop_url = $_POST['shop_url'];
            $placewiseLib = new PlacewiseLib($shop_url);
            $data = $placewiseLib->CreateToken(json_encode($_POST));
            print $data;
            exit;
        }
        public function revoke_token(){
            $shop_url = $_POST['shop_url'];
            $placewiseLib = new PlacewiseLib($shop_url);
            $data = $placewiseLib->revokeToken(json_encode($_POST));
            print $data;
            exit;
        }
        public function token_info($shop_url = "",$token = ""){
            $placewiseLib = new PlacewiseLib($shop_url);
            $data = $placewiseLib->tokenInfo($token);
            print json_encode($token_info);
            exit;
        }
        
    }
?>