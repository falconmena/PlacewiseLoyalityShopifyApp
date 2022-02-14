<?php
header('Content-Type: application/json');
include_once(dirname(__FILE__) . '/inc/Lib.php');	
 if(!empty($_POST)){
    //print gettype($_POST);	
    $member_id =  $_POST['member_id'];
    unset($_POST['member_id']);
    $member = array(
        "properties" => array(
            "last_name" => "abusubhiaaaaaa"
        )
    );	
    $data = editMember(json_encode($_POST),$member_id);
    print $data;
    exit;
 }else {
   print 'Not Valid Request';
   exit;
 }
?>
