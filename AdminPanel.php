<?php
class AdminPanel{
	public function getAdminPanel($user){
		include_once('Location.php');
		$response = "<html>" . "\n";
		$response .= $this->printHeader();
		$response .= $this->printBody($user);
		$response .= "</html>" . "\n";
		return $response;
	}

	function printHeader(){
		$header = "    <head>" . "\n";
		$header .= '        <meta content="text/html; charset=UTF-8" http-equiv="content-type">' . "\n";
		$header .= '        <title>' . $this->getTitle() . '</title>' . "\n";
		$header .= "    </head>" . "\n";
		return $header;
	}

	function getTitle(){
		return "Admin panel";
	}

	function printBody($user){
		$body = "    <body>" . "\n";
		$locationList = $this->getLocationList($user);
		$body .= $this->getLocationTable($locationList);
		$body .= "    </body>" . "\n";
		return $body;
	}

	function getLocationList($user){
		include_once('LocationsService.php');
		$locationService = new LocationsService();
		return $locationService->getWebLocations($user);
	}

	function getLocationTable($locationList){
		$table = "        <table>" . "\n";
		$table .= $this->getTableHeader();
		$table .= $this->getEmptyRow();
		foreach($locationList as $value){
			$table .= $this->getLocationRow($value);
		}
		$table .= "        </table>" . "\n";
		return $table;
	}
	
	function getTableHeader(){
		$header = "            <tr>" . "\n";
		$header .= '                <th>Latitud</th>' . "\n";
		$header .= '                <th>Longitud</th>' . "\n";
		$header .= '                <th>Nom</th>' . "\n";
		$header .= '                <th>Tipus</th>' . "\n";
		$header .= '                <th>Direcció</th>' . "\n";
		$header .= '                <th>Telèfon/Horari</th>' . "\n";
		$header .= '                <th>Data de expiració</th>' . "\n";
		$header .= "            </tr>" . "\n";
		return $header;
	}
	
	function getEmptyRow(){
		$row = "            <tr>" . "\n";
		$row .= '               <form accept-charset="utf8" method="POST" action="?q=' . Index::ADD_REQUEST 
				 . '">' . "\n";
		$row .= $this->getLatitudeCell("");
		$row .= $this->getLongitudeCell("");
		$row .= $this->getNameCell("");
		$row .= $this->getTypeCell("");
		$row .= $this->getAddressCell("");
		$row .= $this->getotherCell("");
		$row .= $this->getexpireDateCell("");
		$row .= '                    <td><input name="send" type="submit" value="Add new"></td>' . "\n";
		$row .= "                </form>" . "\n";
		$row .= "            </tr>" . "\n";
		return $row;
	}

	function getLocationRow($row){
		$location = "            <tr>" . "\n";
		$location .= $this->addForm($row->id);
		$location .= $this->getLatitudeCell($row->latitude);
		$location .= $this->getLongitudeCell($row->longitude);
		$location .= $this->getNameCell($row->name);
		$location .= $this->getTypeCell($row->location_type);
		$location .= $this->getAddressCell($row->address);
		$location .= $this->getotherCell($row->other);
		$location .= $this->getexpireDateCell($row->expireDate);
		$location .= '                    <td><input name="modify" type="submit" value="Modify"></td>' . "\n";
		$location .= "                </form>" . "\n";
		$location .= '                <td><a href="?q=' . Index::DELETE_REQUEST . '/' . $row->id 
				. '"><input type="submit" value="Borrar"></a></td>' . "\n";
		$location .= "            </tr>" . "\n";
		return $location;
	}

	function addForm($id){
		$form = '		<form accept-charset="utf8" method="POST" action="?q=' . Index::UPDATE_REQUEST 
				. '/' . $id . '"';
		$form .= "";
		return $form . ">\n";
	}

	function getLatitudeCell($coordinate){
		$cell = "                    <td>";
		$cell .= '<input required="required" name="' . LocationsContract::LOCATIONS_COLUMN_LATITUDE 
				. '" type="text" value="' . $coordinate . '">';
		$cell .= "</td>" . "\n";
		return $cell;
	}
	function getLongitudeCell($coordinate){
		$cell = "                    <td>";
		$cell .= '<input required="required" name="' . LocationsContract::LOCATIONS_COLUMN_LONGITUDE 
				. '" type="text" value="' . $coordinate . '">';
		$cell .= "</td>" . "\n";
		return $cell;
	}
	function getNameCell($name){
		$cell = "                    <td>";
		$cell .= '<input required="required" name="' . LocationsContract::LOCATIONS_COLUMN_NAME 
				. '" type="text" value="' . $name . '">';
		$cell .= "</td>" . "\n";
		return $cell;
	}
	function getTypeCell($type){
		$cell = "                    <td>";
		$cell .= '<select required="required" name="' . LocationsContract::LOCATIONS_COLUMN_TYPE
				. '"">' . "\n";
		$cell .= $this->getOptions($type);
		$cell .= '                    </select>';
		$cell .= "</td>" . "\n";
		return $cell;
	}
	function getOptions($type){
		$availableOptions = LocationsContract::getLocationTypes();
		$options = "";
		foreach($availableOptions as $option){
			$options .= "                            <option";
			if($type == $option) {
				$options .= ' selected="selected"';
			}
			$options .= ">" . $option . "</option>\n";
		}
		return $options;
		
	}
	function getAddressCell($address){
		$cell = "                    <td>";
		$cell .= '<input name="' . LocationsContract::LOCATIONS_COLUMN_ADDRESS 
				. '" type="text" value="';
		if($address){
			 $cell .= $address;
		} else {
			$cell .= "";
		}
		$cell .= '"></td>' . "\n";
		return $cell;
	}
	function getOtherCell($other){
		$cell = "                    <td>";
		$cell .= '<input name="' . LocationsContract::LOCATIONS_COLUMN_OTHER 
				. '" type="text" value="';
		if($other){
			$cell .= $other;
		} else {
			$cell .= "";
		}
		$cell .= '"></td>' . "\n";
		return $cell;
	}
	function getExpireDateCell($expireDate){
		$cell = "                    <td>";
		$cell .= '<input name="' . LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE
				. '" type="date" value="';
		if($expireDate){
			date_default_timezone_set("Europe/Madrid");
			$cell .= substr(date(DateTime::RFC3339, $expireDate/1000), 0, 10);
		} else {
			$cell .= "";
		}
		$cell .= '"></td>' . "\n";
		return $cell;
	}
}