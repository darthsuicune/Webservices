<?php
class User{
	var $id;
	var $name;
	var $surname;
	var $email;
	var $role;

	public function __construct($name, $surname, $email, $role, $id = 0 ){
		$this->id = $id;
		$this->name = $name;
		$this->surname = $surname;
		$this->email = $email;
		$this->role = $role;
	}

	public static function createFromCursor($entry){
		return new User($entry[UsersContract::COLUMN_NAME],
				$entry[UsersContract::COLUMN_SURNAME],
				$entry[UsersContract::COLUMN_E_MAIL],
				$entry[UsersContract::COLUMN_ROLE],
				$entry[UsersContract::COLUMN_ID]);
	}

	public function to_array(){
		return array(UsersContract::COLUMN_ID=>$this->id,
				UsersContract::COLUMN_ROLE=>$this->role,
				UsersContract::COLUMN_E_MAIL=>$this->email,
				UsersContract::COLUMN_NAME=>$this->name,
				UsersContract::COLUMN_SURNAME=>$this->surname
		);
	}
	
	public function equals(User $user) {
		return (($this->id == $user->id)
				&& ($this->name == $user->name)
				&& ($this->surname == $user->surname)
				&& ($this->email == $user->email)
				&& ($this->role == $user->role));
	}
	
	public function isAllowedTo($action) {
		if($this->role){
			return true;
		}
		$isAllowed = false;
		switch ($action) {
			case Actions::MENU:
				switch ($this->role) {
					case UsersContract::ROLE_MARITIMOS:
					case UsersContract::ROLE_SOCIAL:
					case UsersContract::ROLE_SOCIAL_SOCORROS:
					case UsersContract::ROLE_SOCORROS:
					case UsersContract::ROLE_SOCORROS_MARITIMOS:
					case UsersContract::ROLE_REGISTER:
					default:
						break;
				}
				break;
			case Actions::MENU_MANAGEMENT:
				switch ($this->role) {
					case UsersContract::ROLE_MARITIMOS:
					case UsersContract::ROLE_SOCIAL:
					case UsersContract::ROLE_SOCIAL_SOCORROS:
					case UsersContract::ROLE_SOCORROS:
					case UsersContract::ROLE_SOCORROS_MARITIMOS:
						break;
					case UsersContract::ROLE_REGISTER:
						$isAllowed = true;
						break;
					default:
						break;
				}
				break;
			case Actions::SEE_MAP:
				switch($this->role) {
					case UsersContract::ROLE_MARITIMOS:
					case UsersContract::ROLE_SOCIAL:
					case UsersContract::ROLE_SOCIAL_SOCORROS:
					case UsersContract::ROLE_SOCORROS:
					case UsersContract::ROLE_SOCORROS_MARITIMOS:
						$isAllowed = true;
						break;
					case UsersContract::ROLE_REGISTER:
					default:
						break;
				}
				break;
			default:
				break;
		}

		return $isAllowed;
	}

	public function getAllowedTypes() {
		$types = array();
		switch ($this->role) {
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