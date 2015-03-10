<?php
	//Centralized class for connecting to DB
	class DBUtil {
		protected $servername = "localhost";
		protected $username = "bikash";
		protected $password = "biswas";
		protected $dbname = "compliance";

		function DBUtil() {
		}

		public function getConnection() {
			$conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			return $conn;
		}
	}

?>