<?php

class Member{
	

	public $properties;
	public $person_id;
	
	
	public function setProperties($first_name, $last_name, $msisdn, $email, $birthday, $language = 'no'){
		$properties = new stdClass();
		$properties->first_name = $first_name;
		$properties->last_name = $last_name;
		$properties->msisdn = $msisdn;
		$properties->email = $email;
		$properties->language = $language;
		$this->properties = $properties;
	}
	
	
	public function setPersonID($person_id){
		$this->person_id = $person_id;
	}
	
}

?>