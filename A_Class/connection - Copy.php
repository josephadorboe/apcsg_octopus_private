<?php
 class MysqlConnection{ 
	// private static $host = "127.0.0.1";
	// private $dbname = "apcsg_octopus";   
	// private $dbusername = "root";
	// private $dbpassword ="space123";
	// private $port=3307;
	// public $handler = null;
	private static $connectioninstance = null;

	private function __construct() {
        // Constructor logic, if any
    }

	public static function getconnectioninstance(){
		if (self::$connectioninstance === null) {
			static $host = "127.0.0.1";	
			static $dbname = "apcsg_octopus";   
			static $dbusername = "root";
			static $dbpassword ="space123";
		try {
			$connectioninstance = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbusername, $dbpassword , array(PDO::ATTR_PERSISTENT=> true));
			$connectioninstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$connectioninstance = new self();
			return self::$connectioninstance;
			//return 1 ;
			// $value = 1;
			}
			catch(PDOException $e){
				// echo 'Refreshing database connection';
				// return $this->handler;
				echo $e->getMessage();
				// $this->handler=null;				
				die('CONNECTION DOWN ');
			}	           
        }        
	}
	// public function dbconnect() {
	// 	// if($this->handler !== null){
	// 	// 	return $this->handler;
	// 	// }
	// 	try {
	// 		$this->handler = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname, $this->dbusername, $this->dbpassword , array(PDO::ATTR_PERSISTENT=> true));
	// 		$this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);				
	// 		return $this->handler;
	// 	}
	// 	catch(PDOException $e){
	// 			// echo 'Refreshing database connection';
	// 			// return $this->handler;
	// 			echo $e->getMessage();
	// 			$this->handler=null;				
	// 		die('CONNECTION DOWN ');
	// 	}		 	    
	// }    
 }
 // $connection = new MysqlConnection();

	echo $mysqldbconnect = MysqlConnection::getconnectioninstance();
	die;