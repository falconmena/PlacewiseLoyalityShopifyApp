<?php 
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
include_once(dirname(__FILE__) . '/inc/Lib.php'); 


// $_REQUEST['query'] = '4792672319';
if(isset($_REQUEST['query']) && !empty($_REQUEST['query']))
	$Caller = $_REQUEST['query'];
else 
	{echo 'Not Valid Email'; exit;}

///4741238538
///4792672319

// $Customer = MembersByEmail($Caller);
$Customer1 = MembersInfoByEmail($Caller);

print json_encode($Customer1);
?>

