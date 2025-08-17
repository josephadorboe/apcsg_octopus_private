<?php
 class MysqlConnection{ 
	private $host = "localhost";
	private $dbname = "apcsg_octopus";   
	private $dbusername = "root";
	private $dbpassword ="space123";
	private $port=3307;
	public $handler = null;
	private static $connectioninstance = null;

	// 15 AUG 2025, JOSEPH ADORBOE 
	public function dbconnect() {
		if($this->handler !== null){
			return $this->handler;
		}
		try {
			$this->handler = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname, $this->dbusername, $this->dbpassword , array(PDO::ATTR_PERSISTENT=> true));
			$this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);				
			return $this->handler;
		}
		catch(PDOException $e){
				// echo 'Refreshing database connection';
				// return $this->handler;
				echo $e->getMessage();
				$this->handler=null;				
			die('CONNECTION DOWN ');
		}		 	    
	}    
 }
 $connection = new MysqlConnection();

	