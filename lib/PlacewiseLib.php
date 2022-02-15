<?php

class PlacewiseLib{
    
    private $Production;
    private $Slug;
    private $Product_name;
    private $Client_Authorization;
    private $Header;

    public function __construct($shop_url) {
        $store = new Store();
        $data_store = $store->getStoreByShop_url($shop_url);
        $this->Production = $data_store['pw_production']; 
        $this->Slug = $data_store['pw_slug']; 
        $this->Header = array(
        	'content-type: application/json',
        	'x-product-name:' . $data_store['pw_product_name'],
        	'X-Client-Authorization:' . $data_store['pw_client_authorization'],
        	'X-User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0',
        );
    }
    
    public function MembersByEmail($email){
	
    	$cURLConnection = curl_init();
    	curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $this->Header);
    	curl_setopt($cURLConnection, CURLOPT_URL, $this->Production . '/v3/' . $this->Slug . '/transactions/points/by_email/' . $email . '');
    	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    
    	$Results= curl_exec($cURLConnection);
    	curl_close($cURLConnection);
    	if(isset(json_decode($Results)->default_wallet))
    		return json_decode($Results);
    	else
    		return false;
	
    }
    
    
    public function OffersByMSISDN($MSISDN){
	
    	$USER_ID = $this->MembersIDByMSISDN($MSISDN);
    	$cURLConnection = curl_init();
    	
    	curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $this->Header);
    
    	curl_setopt($cURLConnection, CURLOPT_URL, $this->Production . '/v3/' . $this->Slug . '/members/' . $USER_ID . '/offers');
    	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    
    	$Results= curl_exec($cURLConnection);
    	curl_close($cURLConnection);
    	return json_decode($Results);
	
    }

    public function OffersByGuest(){
	
    	$cURLConnection = curl_init();
    	curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $this->Header);
    	curl_setopt($cURLConnection, CURLOPT_URL, $this->Production . '/v3/' . $this->Slug . '/members/guest/offers');
    	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    	$Results= curl_exec($cURLConnection);
    	curl_close($cURLConnection);
    	return json_decode($Results);
    	
    }


    public function MembersByMSISDN($MSISDN){
	
    	$cURLConnection = curl_init();
    	curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $this->Header);
    	curl_setopt($cURLConnection, CURLOPT_URL, $this->Production . '/v3/' . $this->Slug . '/members/by_msisdn/' . $MSISDN . '');
    	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    	$Results= curl_exec($cURLConnection);
    	curl_close($cURLConnection);
    	if(isset(json_decode($Results)->id))
    		return json_decode($Results);
    	else
    		return false;
    	
    }


    public function MembersInfoByEmail($Email){
	
    	$cURLConnection = curl_init();
    	curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $this->Header);
    	curl_setopt($cURLConnection, CURLOPT_URL, $this->Production . '/v3/' . $this->Slug . '/members/by_email/' . $Email . '');
    	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

	    $Results= curl_exec($cURLConnection);
    	curl_close($cURLConnection);
    	if(isset(json_decode($Results)->id))
    		return json_decode($Results);
    	else
    		return false;
	
    }


    public function tokenInfo($token){
        $header_token = "authorization:Bearer ".$token;
        array_push($Header,$header_token);
        $cURLConnection = curl_init();
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $this->Header);
        curl_setopt($cURLConnection, CURLOPT_URL, $this->Production . '/v3/' . $this->Production . '/members/oauth/token/info');
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $Results= curl_exec($cURLConnection);
        curl_close($cURLConnection);
        return json_decode($Results);
    }


    public function MembersIDByMSISDN($MSISDN){
	
    	$cURLConnection = curl_init();
    	curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $this->Header);
    	curl_setopt($cURLConnection, CURLOPT_URL, $this->Production . '/v3/' . $this->Slug . '/members/by_msisdn/' . $MSISDN . '');
    	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    	$Results= curl_exec($cURLConnection);
    	curl_close($cURLConnection);
    	if(isset(json_decode($Results)->id))
    		return json_decode($Results)->id;
    	else
    		return false;
    	
    }

    
    public function CreatMember($Member){
	
    	$curl = curl_init();
    	curl_setopt_array($curl, array(
    		CURLOPT_URL => $this->Production . '/v3/' . $this->Slug . '/members',
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_ENCODING => '',
    		CURLOPT_MAXREDIRS => 10,
    		CURLOPT_TIMEOUT => 0,
    		CURLOPT_FOLLOWLOCATION => true,
    		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    		CURLOPT_CUSTOMREQUEST => 'POST',
    		CURLOPT_POSTFIELDS => $Member,
    		// CURLOPT_POST => true,
    		CURLOPT_HTTPHEADER => $this->Header,
    	));
    	$response = curl_exec($curl);
    	curl_close($curl);
    	return $response;
    	
    }
    
    
    public function editMember($member,$member_id){
    	$curl = curl_init();
    	curl_setopt_array($curl, array(
      		CURLOPT_URL => $this->Production . '/v3/' . $this->Slug . '/members/'.$member_id,
      		CURLOPT_RETURNTRANSFER => true,
      		CURLOPT_ENCODING => '',
      		CURLOPT_MAXREDIRS => 10,
      		CURLOPT_TIMEOUT => 0,
      		CURLOPT_FOLLOWLOCATION => true,
      		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      		CURLOPT_CUSTOMREQUEST => 'PUT',
      		CURLOPT_POSTFIELDS =>$member,
      		CURLOPT_HTTPHEADER => $this->Header,
    	));
    	$response = curl_exec($curl);
    	curl_close($curl);
    	return $response;
    }

    public function CreateToken($Member){
        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => $this->Production . '/v3/' . $this->Slug . '/members/oauth/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $Member,
                // CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => $this->Header,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    
    public function revokeToken($token){

        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => $this->Production . '/v3/' . $this->Slug . '/members/oauth/revoke',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $token,
                // CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => $this->Header,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    
    
    
}
?>