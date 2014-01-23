<?php
class AdminPanel{
	public function getAdminPanel($user){
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
		return $locationService->getLocations($user, 0);

	}

	function getLocationTable($locationList){
		$table = "        <table>" . "\n";
		$table .= $this->getEmptyRow();
		foreach($locationList as $index=>$value){
			$table .= $this->getLocationRow($value);
		}
		$table .= "        </table>" . "\n";
		return $table;
	}
	
	function getEmptyRow(){
		$row = "            <tr>" . "\n";
		$row .= '               <form accept-charset="utf8" method="POST" action="">';
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
		$location .= $this->getTypeCell($row->type);
		$location .= $this->getAddressCell($row->address);
		$location .= $this->getotherCell($row->other);
		$location .= $this->getexpireDateCell($row->expireDate);
		$location .= '                    <td><input name="send" type="submit" value="Modify"></td>' . "\n";
		$location .= '                    <td><input name="send" type="submit" value="Borrar"></td>' . "\n";
		$location .= "                </form>" . "\n";
		$location .= "            </tr>" . "\n";
		return $location;
	}

	function addForm($id){
		$form = '		<form accept-charset="utf8" method="POST" action="index.php"';
		$form .= "";
		return $form . ">\n";
	}

	function getLatitudeCell($coordinate){
		$cell = "                    <td>";
		$cell .= '<input required="required" name="latitude" type="text" value="' . $coordinate . '">';
		$cell .= "</td>" . "\n";
		return $cell;
	}
	function getLongitudeCell($coordinate){
		$cell = "                    <td>";
		$cell .= '<input required="required" name="longitude" type="text" value="' . $coordinate . '">';
		$cell .= "</td>" . "\n";
		return $cell;
	}
	function getNameCell($name){
		$cell = "                    <td>";
		$cell .= '<input required="required" name="name" type="text" value="' . $name . '">';
		$cell .= "</td>" . "\n";
		return $cell;
	}
	function getTypeCell($type){
		$cell = "                    <td>";
		$cell .= '<input required="required" name="type" type="text" value="' . $type . '">';
		$cell .= "</td>" . "\n";
		return $cell;
	}
	function getAddressCell($address){
		$cell = "                    <td>";
		$cell .= '<input required="required" name="address" type="text" value="';
		if($address != null){
			 $cell .= $address;
		} else {
			$cell .= "null";
		}
		$cell .= '"></td>' . "\n";
		return $cell;
	}
	function getOtherCell($other){
		$cell = "                    <td>";
		$cell .= '<input required="required" name="other" type="text" value="';
		if($other != null){
			$cell .= $other;
		} else {
			$cell .= "null";
		}
		$cell .= '"></td>' . "\n";
		return $cell;
	}
	function getExpireDateCell($expireDate){
		$cell = "                    <td>";
		$cell .= '<input required="required" name="expireDate" type="text" value="';
		if($expireDate != null){
			$cell .= $expireDate;
		} else {
			$cell .= "null";
		}
		$cell .= '"></td>' . "\n";
		return $cell;
	}
}