<?php

interface DataStorage{
	public function query(array $columns, array $tables, $where, array $whereArgs);
	public function insert($table, array $values);
	public function bulkInsert($table, array $values);
	public function update($table, array $values, $where, array $whereArgs);
	public function delete($table, $where, array $whereArgs);
}