<?php
class User{
	var $id;
	var $name;
	var $surname;
	var $email;
	var $role;
	var $language;

	public function __construct($name, $surname, $email, $role, $id = 0,
			$language = Strings::LANG_CATALAN){
		$this->id = $id;
		$this->name = $name;
		$this->surname = $surname;
		$this->email = $email;
		$this->role = $role;
		$this->language = $language;
	}

	public static function createFromCursor($entry){
		return new User($entry[UsersContract::COLUMN_NAME],
				$entry[UsersContract::COLUMN_SURNAME],
				$entry[UsersContract::COLUMN_E_MAIL],
				$entry[UsersContract::COLUMN_ROLE],
				$entry[UsersContract::COLUMN_ID],
				$entry[UsersContract::COLUMN_LANGUAGE]);
	}

	public function to_array(){
		return array(UsersContract::COLUMN_ID=>$this->id,
				UsersContract::COLUMN_ROLE=>$this->role,
				UsersContract::COLUMN_E_MAIL=>$this->email,
				UsersContract::COLUMN_NAME=>$this->name,
				UsersContract::COLUMN_SURNAME=>$this->surname,
				UsersContract::COLUMN_LANGUAGE=>$this->language
		);
	}

	public function equals(User $user) {
		return (($this->id == $user->id)
				&& ($this->name == $user->name)
				&& ($this->surname == $user->surname)
				&& ($this->email == $user->email)
				&& ($this->role == $user->role));
	}

	public function getDefaultView() {
		$content = false;
		switch($this->role) {
			case UsersContract::ROLE_ADMIN:
				$content = new Map();
				break;
			case UsersContract::ROLE_REGISTER:
				$content = new UserManager();
				break;
			default:
				$content = new Map();
				break;
		}
		return $content;
	}

	public function isAllowedTo($action) {
		//Admins can do anything
		if($this->role == UsersContract::ROLE_ADMIN){
			return true;
		}
		$isAllowed = false;
		switch ($action) {
			//This actions are all allowed by default
			case Actions::ABOUT:
			case Actions::CONTACT:
			case Actions::LOGIN:
			case Actions::LOGOUT:
			case Actions::CHANGE_PASSWORD:
			case Actions::RECOVER_PASSWORD:
				$isAllowed = true;
				break;
				//Currently this actions can only be performed by admins
			case Actions::UPDATE_LOCATION:
			case Actions::ADD_LOCATION:
			case Actions::DELETE_LOCATION:
			case Actions::MANAGE_LOCATIONS:
				break;
				//This actions can be performed also by register users
			case Actions::MANAGE_USERS:
			case Actions::REGISTER:
				switch($this->role) {
					case UsersContract::ROLE_REGISTER:
						$isAllowed = true;
						break;
					default:
						break;
				}
				break;
				//Register users can't see the map
			case Actions::MAP:
				switch($this->role) {
					case UsersContract::ROLE_MARITIMOS:
					case UsersContract::ROLE_SOCIAL:
					case UsersContract::ROLE_SOCIAL_SOCORROS:
					case UsersContract::ROLE_SOCORROS:
					case UsersContract::ROLE_SOCORROS_MARITIMOS:
						$isAllowed = true;
						break;
					default:
						break;
				}
				break;
			default:
				break;
		}

		return $isAllowed;
	}

	public function getManagedRoles() {
		$result = array();
		switch($this->role){
			case UsersContract::ROLE_ADMIN:
				$result[] = UsersContract::ROLE_ADMIN;
			case UsersContract::ROLE_REGISTER:
				$result[] = UsersContract::ROLE_REGISTER;
				$result[] = UsersContract::ROLE_MARITIMOS;
				$result[] = UsersContract::ROLE_SOCIAL;
				$result[] = UsersContract::ROLE_SOCIAL_SOCORROS;
				$result[] = UsersContract::ROLE_SOCORROS;
				$result[] = UsersContract::ROLE_SOCORROS_MARITIMOS;
				break;
			default:
				break;
		}
		return $result;
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