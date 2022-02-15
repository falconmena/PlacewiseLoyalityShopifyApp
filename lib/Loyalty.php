<?php
// header('Content-Type: application/json');

class Loyalty {
    
    public function getLoyaltyPoints($shop_url,$email) {	
        // $url = root_path . "/placewise_api/?query=$email";
        $url = root_path . "/?r=PlacewiseApi/membersInfoByEmail/" . $shop_url . "/" . $email;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
	}
	public function getLoyaltyPointsByPhone($shop_url,$phone) {	
        $url = root_path . "/?r=PlacewiseApi/loyalty_points_by_phone/" . $shop_url . "/" . $phone;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function createLoyaltyMember($member,$shop_url) {	
	    $curl = curl_init();
	    curl_setopt_array($curl, array(
	        CURLOPT_URL => root_path . "/?r=PlacewiseApi/create_member/" . $shop_url,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => http_build_query($member),
	    ));
	    $response = curl_exec($curl);
	    curl_close($curl);
	    return json_decode($response);
	}
	public function getTokenInfo($token) {	
        $url = root_path . "/placewise_api/token_info.php?query=$token";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
	}
	public function createToken($member) {	
	    $curl = curl_init();
	    curl_setopt_array($curl, array(
	        CURLOPT_URL => root_path . "/placewise_api/create_token.php",
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => http_build_query($member),
	    ));
	    $response = curl_exec($curl);
	    curl_close($curl);
	    return json_decode($response);
	}
	public function revokeToken($data) {	
	    $curl = curl_init();
	    curl_setopt_array($curl, array(
	        CURLOPT_URL => root_path . "/placewise_api/revokeToken.php",
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => http_build_query($data),
	    ));
	    $response = curl_exec($curl);
	    curl_close($curl);
	    return json_decode($response);
	}
	public function editLoyaltyMember($member) {	
	    $curl = curl_init();
	    curl_setopt_array($curl, array(
	        CURLOPT_URL => root_path . "/placewise_api/edit_member.php",
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => http_build_query($member),
	    ));
	    $response = curl_exec($curl);
	    curl_close($curl);
	    return json_decode($response);
	}
	
}
?>