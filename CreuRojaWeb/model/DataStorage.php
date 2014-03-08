<?php

interface DataStorage{
	
	/**
	 * Abstraction layer for the query to the database.
	 *
	 * @param array $columns
	 * @param array $tables Needs to contain at least one value
	 * @param String $where
	 * @param array $whereArgs
	 * @return associative array with the result set.
	 */
	public function query(array $columns, array $tables, $where, array $whereArgs);
	
	/**
	 * Abstraction layer for the insert of rows into a database
	 *
	 * @param string $table
	 * @param array $values
	 * @return true if successful, false if an error happened
	 */
	public function insert($table, array $values);
	
	/**
	 * Abstraction layer for bulk inserting values into the database
	 *
	 * @param string $table
	 * @param array $values -> Must contain only arrays. The first sub-array
	 * must provide through keys the parameters to use as columns. The second and further
	 * can then omit the keys or include them (they will be ignored anyway)
	 *
	 * Example: $values = array(array("key1"=>"value1", "key2"=>"value2"),
	 * array("value3", "value4"));
	 * @return true if successful, false if an error happened
	 */
	public function bulkInsert($table, array $values);
	
	/**
	 * Abstraction layer for the update of rows from a database
	 * @param array $values
	 * @param string $table
	 * @param string $where
	 * @param array $whereArgs
	 * @return true if successful, false if an error happened
	 */
	public function update($table, array $values, $where, array $whereArgs);
	
	/**
	 * Abstraction layer for the deletion of rows from a database
	 *
	 * @param string $table
	 * @param string $where
	 * @param array $whereArgs
	 * @return true if successful, false if an error happened
	 */
	public function delete($table, $where, array $whereArgs);
}