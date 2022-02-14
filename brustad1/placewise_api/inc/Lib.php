<?php
include_once(dirname(__FILE__) . '/Config.php');




function OffersByMSISDN($MSISDN){
	
	
	global $Production, $Production_APAC_region, $Staging, $Slug, $Header;
	$USER_ID = MembersIDByMSISDN($MSISDN);
	$cURLConnection = curl_init();
	
	curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $Header);

	curl_setopt($cURLConnection, CURLOPT_URL, $Production . '/v3/' . $Slug . '/members/' . $USER_ID . '/offers');
	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

	
	$Results= curl_exec($cURLConnection);
	curl_close($cURLConnection);
	return json_decode($Results);
	
}

function OffersByGuest(){
	
	
	global $Production, $Production_APAC_region, $Staging, $Slug, $Header;
	$cURLConnection = curl_init();
	
	curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $Header);

	curl_setopt($cURLConnection, CURLOPT_URL, $Production . '/v3/' . $Slug . '/members/guest/offers');
	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

	
	$Results= curl_exec($cURLConnection);
	curl_close($cURLConnection);
	return json_decode($Results);
	
}


function MembersByMSISDN($MSISDN){
	
	
	global $Production, $Production_APAC_region, $Staging, $Slug, $Header;
	$cURLConnection = curl_init();
	
	curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $Header);

	curl_setopt($cURLConnection, CURLOPT_URL, $Production . '/v3/' . $Slug . '/members/by_msisdn/' . $MSISDN . '');
	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

	
	$Results= curl_exec($cURLConnection);
	curl_close($cURLConnection);
	if(isset(json_decode($Results)->id))
		return json_decode($Results);
	else
		return false;
	
}

function MembersByEmail($Email){
	
	
	global $Production, $Production_APAC_region, $Staging, $Slug, $Header;
	$cURLConnection = curl_init();
	
	curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $Header);

	curl_setopt($cURLConnection, CURLOPT_URL, $Production . '/v3/' . $Slug . '/transactions/points/by_email/' . $Email . '');
	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

	
	$Results= curl_exec($cURLConnection);
	//print_r($Production . '/v3/' . $Slug . '/transactions/points/by_email/' . $Email . '');
	//echo '<br />';
	//print_r($Header);
	//echo '<br />';
	//print_r($Results);
	curl_close($cURLConnection);
	if(isset(json_decode($Results)->default_wallet))
		return json_decode($Results);
	else
		return false;
	
}

function MembersInfoByEmail($Email){
	
	
	global $Production, $Production_APAC_region, $Staging, $Slug, $Header;
	$cURLConnection = curl_init();
	
	curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $Header);

	curl_setopt($cURLConnection, CURLOPT_URL, $Production . '/v3/' . $Slug . '/members/by_email/' . $Email . '');
	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

	
	$Results= curl_exec($cURLConnection);
// 	print_r($Production . '/v3/' . $Slug . '/transactions/points/by_email/' . $Email . '');
// 	echo '<br />';
// 	print_r($Header);
// 	echo '<br />';
// 	print_r($Results);
	curl_close($cURLConnection);
	if(isset(json_decode($Results)->id))
		return json_decode($Results);
	else
		return false;
	
}
function tokenInfo($token){
    global $Production, $Production_APAC_region, $Staging, $Slug, $Header;
    $header_token = "authorization:Bearer ".$token;
    array_push($Header,$header_token);
    $cURLConnection = curl_init();
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $Header);
    curl_setopt($cURLConnection, CURLOPT_URL, $Production . '/v3/' . $Slug . '/members/oauth/token/info');
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    $Results= curl_exec($cURLConnection);
    curl_close($cURLConnection);
    return json_decode($Results);
}

function MembersIDByMSISDN($MSISDN){
	
	
	global $Production, $Production_APAC_region, $Staging, $Slug, $Header;
	$cURLConnection = curl_init();
	
	curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $Header);

	curl_setopt($cURLConnection, CURLOPT_URL, $Production . '/v3/' . $Slug . '/members/by_msisdn/' . $MSISDN . '');
	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

	
	$Results= curl_exec($cURLConnection);
	curl_close($cURLConnection);
	if(isset(json_decode($Results)->id))
		return json_decode($Results)->id;
	else
		return false;
	
}

function CreatMember($Member){
	
	global $Production, $Production_APAC_region, $Staging, $Slug, $Header;
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $Production . '/v3/' . $Slug . '/members',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => $Member,
		// CURLOPT_POST => true,
		CURLOPT_HTTPHEADER => $Header,
	));
	$response = curl_exec($curl);
	curl_close($curl);
	// return json_decode($response);
	return $response;
	// $cURLConnection = curl_init();
	// curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $Header);
	// curl_setopt($cURLConnection, CURLOPT_URL, $Production . '/v3/' . $Slug . '/members');
	// curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
	// curl_setopt($cURLConnection, CURLOPT_POST, 1);
	// curl_setopt($cURLConnection, CURLOPT_POSTFIELDS,$Member);
	// $results= curl_exec($cURLConnection);
	// curl_close($cURLConnection);
	// return json_decode($results,true);

	
}
function editMember($member,$member_id){
	global $Production, $Production_APAC_region, $Staging, $Slug, $Header;
	$curl = curl_init();
	curl_setopt_array($curl, array(
  		CURLOPT_URL => $Production . '/v3/' . $Slug . '/members/'.$member_id,
  		CURLOPT_RETURNTRANSFER => true,
  		CURLOPT_ENCODING => '',
  		CURLOPT_MAXREDIRS => 10,
  		CURLOPT_TIMEOUT => 0,
  		CURLOPT_FOLLOWLOCATION => true,
  		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  		CURLOPT_CUSTOMREQUEST => 'PUT',
  		CURLOPT_POSTFIELDS =>$member,
  		CURLOPT_HTTPHEADER => $Header,
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}

function CreateToken($Member){
    global $Production, $Production_APAC_region, $Staging, $Slug, $Header;
    $curl = curl_init();
    curl_setopt_array($curl, array(
            CURLOPT_URL => $Production . '/v3/' . $Slug . '/members/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $Member,
            // CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $Header,
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function revokeToken($token){
	global $Production, $Production_APAC_region, $Staging, $Slug, $Header;
	
    $curl = curl_init();
    curl_setopt_array($curl, array(
            CURLOPT_URL => $Production . '/v3/' . $Slug . '/members/oauth/revoke',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $token,
            // CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $Header,
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}


    
?>
