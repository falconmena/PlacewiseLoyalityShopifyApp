<?php
// header('Content-Type: application/json');

class Loyalty {
    
    public function getLoyaltyPoints($email) {	
        $url = "https://brustad1.placewise-services.com/placewise_api/?query=$email";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
	}
	public function getTokenInfo($token) {	
        $url = "https://brustad1.placewise-services.com/placewise_api/token_info.php?query=$token";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
	}
	public function getLoyaltyPointsByPhone($phone) {	
        $url = "https://brustad1.placewise-services.com/placewise_api/LoyaltyPointsByPhone.php?query=$phone";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function createLoyaltyMember($member) {	
	    $curl = curl_init();
	    curl_setopt_array($curl, array(
	        CURLOPT_URL => "https://brustad1.placewise-services.com/placewise_api/create_member.php",
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => http_build_query($member),
	    ));
	    $response = curl_exec($curl);
	    curl_close($curl);
	    return json_decode($response);
	}
	public function createToken($member) {	
	    $curl = curl_init();
	    curl_setopt_array($curl, array(
	        CURLOPT_URL => "https://brustad1.placewise-services.com/placewise_api/create_token.php",
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
	        CURLOPT_URL => "https://brustad1.placewise-services.com/placewise_api/revokeToken.php",
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
	        CURLOPT_URL => "https://brustad1.placewise-services.com/placewise_api/edit_member.php",
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

