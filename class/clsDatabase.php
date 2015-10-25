<?php
include ("config/constants.php.inc");

class Db {
	protected static $connection;

	//Connection Class
	public function connect() {

		// Try and connect to the database, if a connection has not been established yet
		if (!isset(self::$connection)) {
			// Load configuration
			self::$connection = mysqli_connect(host, user, pass, dbname) or die("no connection");
			mysqli_select_db(self::$connection, 'moviefy');

		}

		// If connection was not successful, handle the error
		if (self::$connection === false) {
			//Handle Error - notify admin
			return mysqli_connect_error($connection);
		}

		return self::$connection;
	}

	public function query($query) {
		// Connect to the database
		$connection = $this -> connect();

		//Query the database
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

		return $result;
	}

	public function insertGetLastID($query) {
		// Connect to the database
		$connection = $this -> connect();
		//Query the database
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

		return mysqli_insert_id($connection);
	}

	public function getaffectedRows($query) {
		// Connect to the database
		$connection = $this -> connect();

		//Query the database
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$resultRows = mysqli_affected_rows($connection);
		return $resultRows;
	}

	public function error() {
		$connection = $this -> connect();
		return $connection -> error();
	}

	public function selectReturnRows($query) {
		$connection = $this -> connect();

		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

		return mysqli_num_rows($result);
	}

	public function select($query) {
		$rows = array();
		$result = $this -> query($query);

		//If query failed, return 'false'
		if ($result === false)
			return false;

		// If query was successful, retrieve all the rows into an array
		while ($row = mysqli_fetch_array($result)) {
			$rows[] = $row;
		}
		return $rows;
	}

	public function quote($value) {
		$connection = $this -> connect();
		return mysqli_real_escape_string($connection, $value);
	}

}
?>