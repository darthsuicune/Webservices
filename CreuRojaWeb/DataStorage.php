<?php
require_once('DbLayer.php');

class DataStorage implements LoginProvider, LocationsProvider {
	
	var $mDataStorage;
	
	public function __construct(DataStorageAdapter $dataStorage){
		$this->mDataStorage = $dataStorage;
	}
}

interface DataStorageAdapter {
	public function query();
	public function insert();
	public function bulkInsert();
	public function update();
	public function delete();
}