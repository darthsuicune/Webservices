<?php
class User{
	var $id;
	var $email;
	var $role;
	var $allowedTypes;

	public function __construct($email, $role, $id = 0 ){
		$this->id = $id;
		$this->email = $email;
		$this->role = $role;
		$this->allowedTypes = self::getAllowedTypes($role);
	}
	
	public function to_array(){
		return array(UsersContract::COLUMN_ID=>$this->id,
				UsersContract::COLUMN_ROLE=>$this->role,
				UsersContract::COLUMN_E_MAIL=>$this->email);
	} 

	private function getAllowedTypes($role) {
		$types = array();
		switch ($role) {
			case UsersContract::ROLE_ADMIN:
				$types[] = LocationsContract::TYPE_ADAPTADAS;
				$types[] = LocationsContract::TYPE_ASAMBLEA;
				$types[] = LocationsContract::TYPE_BRAVO;
				$types[] = LocationsContract::TYPE_CUAP;
				$types[] = LocationsContract::TYPE_HOSPITAL;
				$types[] = LocationsContract::TYPE_MARITIMO;
				$types[] = LocationsContract::TYPE_NOSTRUM;
				$types[] = LocationsContract::TYPE_SOCIAL;
				$types[] = LocationsContract::TYPE_TERRESTRE;
				break;
			case UsersContract::ROLE_SOCIAL:
				$types[] = LocationsContract::TYPE_ASAMBLEA;
				$types[] = LocationsContract::TYPE_SOCIAL;
				break;
			case UsersContract::ROLE_SOCORROS:
				$types[] = LocationsContract::TYPE_ADAPTADAS;
				$types[] = LocationsContract::TYPE_ASAMBLEA;
				$types[] = LocationsContract::TYPE_BRAVO;
				$types[] = LocationsContract::TYPE_CUAP;
				$types[] = LocationsContract::TYPE_HOSPITAL;
				$types[] = LocationsContract::TYPE_NOSTRUM;
				$types[] = LocationsContract::TYPE_TERRESTRE;
				break;
			case UsersContract::ROLE_MARITIMOS:
				$types[] = LocationsContract::TYPE_ASAMBLEA;
				$types[] = LocationsContract::TYPE_MARITIMO;
				break;
			case UsersContract::ROLE_SOCIAL_SOCORROS:
				$types[] = LocationsContract::TYPE_ADAPTADAS;
				$types[] = LocationsContract::TYPE_ASAMBLEA;
				$types[] = LocationsContract::TYPE_BRAVO;
				$types[] = LocationsContract::TYPE_CUAP;
				$types[] = LocationsContract::TYPE_HOSPITAL;
				$types[] = LocationsContract::TYPE_NOSTRUM;
				$types[] = LocationsContract::TYPE_SOCIAL;
				$types[] = LocationsContract::TYPE_TERRESTRE;
				break;
			case UsersContract::ROLE_SOCORROS_MARITIMOS:
				$types[] = LocationsContract::TYPE_ADAPTADAS;
				$types[] = LocationsContract::TYPE_ASAMBLEA;
				$types[] = LocationsContract::TYPE_BRAVO;
				$types[] = LocationsContract::TYPE_CUAP;
				$types[] = LocationsContract::TYPE_HOSPITAL;
				$types[] = LocationsContract::TYPE_MARITIMO;
				$types[] = LocationsContract::TYPE_NOSTRUM;
				$types[] = LocationsContract::TYPE_TERRESTRE;
								break;
			case UsersContract::ROLE_REGISTER:
				break;
			default:
				break;
		}
		return $types;
	}
}