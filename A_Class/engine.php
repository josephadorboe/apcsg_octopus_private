<?php
class engine{
	public $db;		
	public $theday ;
	public $thedays ;
	public int $thezero = 0;
	public int $theone = 1;
	public int $thetwo = 2;
	public int $thethree = 3;
	public int $thefour = 4;
	public int $thefive = 5;
	public int $thesix = 6;
	public int $theseven = 7;
	public int $theeight = 8;
	public int $thenine = 9;
	public int $theten = 10;
	public int $thefailed = 0;
	public int $thepassed = 2;
	public int $theexisted = 1;	
	public String $theactive = 'ACTIVE';
	public String $theinactive = 'INACTIVE';
	public String $thevalid = 'VALID';
	public String $theinvalid = 'INVALID';
	// public $mysqldbconnect;
		
  	public function __construct() {
		$this->db = new MysqlConnection();				
		$this->db = $this->db->dbconnect();  		
		$this->theday = date('Y-m-d');	
		$this->thedays = date('Y-m-d H:i:s ');	
			  
	}

	// 14 JUNE 2025, JOSEPH ADORBOE 
	public function validatedateentry($entrydate) : mixed {
		$bdate = explode('-', $entrydate);
		$mmd = $bdate[1];
		$ddd = $bdate[2];
		$yyy = $bdate[0];
		$maxyear = date('Y') + 10;
		if($mmd < 1 || $mmd > 12){
			return 'Month is INVALID';
		}else if($ddd < 1 || $ddd > 31){
			return 'Day is INVALID';
		}else if($mmd == '02' && $ddd > 29){
			return 'Febuary Has 29 Days';
		}else if(($mmd == '04' || $mmd == '06' || $mmd == '09' || $mmd == '11') && $ddd > 30){
			return 'Month Has 30 Days';
		}else if($yyy < 1900 || $ddd > $maxyear){
			return 'Year is INVALID';
		}else{
			return 1;
		}
	}
	
	// 15 JAN 2024 , JOSEPH ADORBOE 
	public function validateemailaddress($email){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return $this->thefailed;
		}else{
			return $this->thepassed;
		}
	}
	// 15 JAN 2025, JOSEPH ADORBOE 
	public function validatephonenumberonly($phonenumber){
		if(!(is_numeric($phonenumber))){
			return $this->thefailed;
		}else if($phonenumber < $this->thezero){
			return $this->thefailed;
		}else if($phonenumber == $this->thezero){
			return $this->thefailed;
		}else if(strlen($phonenumber) !== $this->theten){
			return $this->thefailed;
		}else if($phonenumber == '0000000000'){
			return $this->thefailed;
		}else if(substr($phonenumber,0,1)){
			return $this->thefailed;		
		}else{
			return $this->thepassed;
		}
	}

	// 15 JAN 2025, JOSEPH ADORBOE 
	public function validatephonenumber($phonenumber){
		if(!(is_numeric($phonenumber))){
			return $this->thefailed;
		}else if($phonenumber < $this->thezero){
			return $this->thefailed;
		}else if($phonenumber == $this->thezero){
			return $this->thefailed;
		}else if(strlen($phonenumber) !== 13){
			return $this->thefailed;
		}else{
			return $this->thepassed;
		}
	}
	// 3 AUG 2023 
	public function getresults($results,$item,$action){	
		if($results == '0'){					
			$status = "error";					
			$msg = "$action $item  Unsuccessful"; 
		}else if($results == '1'){					
			$status = "error";					
			$msg = "$item already Exist"; 				
		}else if($results == '2'){					
			$status = "success";
			$msg = "$action $item Successfully";						
		}else{					
			$status = "error";					
			$msg = "$action $item Unsuccessful "; 								
		}
		$value = $status.','.$msg;
		return $value;
	}


	// public function getdiagnosis(){
		
	// $x = 95000;
	
	// do {
	// 	$sqlstmt = "INSERT INTO octopus_st_diagnosis(DN_ID) 
	// 			VALUES (?) ";
	// 			$st = $this->db->prepare($sqlstmt);   
	// 			$st->BindParam(1, $x);
	// 			$exe = $st->execute();
	//   //echo "The number is: $x <br>";
	//   $x++;
	// } while ($x <= 97000);
	
	// }

	// 30 DEC 2022 JOSEPH ADORBOE 
	public function getnumbernonzerovalidation($numbervalue) : String{

		if(!(is_numeric($numbervalue))){
			return '1';
		}else if($numbervalue < '0'){
			return '1';
		}else if($numbervalue == '0'){
			return '1';
		}else{
			return '0';
		}

	}

	// 30 DEC 2022 JOSEPH ADORBOE 
	public function getnumbervalidation($numbervalue) : String{

		if(!(is_numeric($numbervalue))){
			return '1';
		}else if($numbervalue < '0'){
			return '1';
		
		}else{
			return '0';
		}

	}

	// 04 APR 2021
	public function getdoctorappointmenttime($starttime,$endconsultation,String $appdoctorcode, String $instcode) : mixed
	{
		$mnm = '1';
		$sql = " SELECT T_TIMESLOT FROM octopus_appointmentloop where T_DOCTORCODE = ? AND T_INSTCODE = ? "; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $appdoctorcode);	
		$st->BindParam(2, $instcode);			
		$rt = $st->execute();	
		if($rt){
			if($st->rowcount()>0){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$data = $obj['T_TIMESLOT'];
				return $data;

			}else{
				$sqlstmt = "INSERT INTO octopus_appointmentloop(T_DOCTORCODE,T_TIMESLOT,T_INSTCODE) 
				VALUES (?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $appdoctorcode);
				$st->BindParam(2, $starttime);
				$st->BindParam(3, $instcode);
				$exe = $st->execute();
				if($exe){
					return $starttime;
				}else{
					return $this->thefailed;
				}				
			}
		}else{
			return $this->thefailed;
		}		
	}	

	

	// 12 APR 2021 
	public function getcurrentversion() : mixed {
		$nut = 1;
		$sql = 'SELECT VER_STATE,VER_VERSION,VER_DATE FROM octopus_version where VER_ID = ?';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $nut);
		$st->Execute();
		$obj = $st->fetch(PDO::FETCH_ASSOC);			
			return $obj['VER_STATE'].'@@'.$obj['VER_VERSION'].'@@'.$obj['VER_DATE'];
		}
		
	// 26 SEPT 2019 
	public function completepatient(String $patientcode) : void{			
		$sql = 'UPDATE octopus_patients set PATIENT_COMPLETE = ? where PATIENT_CODE = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thetwo);
		$st->BindParam(2, $patientcode);
		$st->execute();		
	}

	// // 3 JULY 2019
	// public function getunpaid(String $instcode) :  Int{
	// 	$sql = 'SELECT CU_UNPAID FROM octopus_current WHERE CU_INSTCODE = ?';
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $instcode);
	// 	$st->execute();
	// 	if($st->rowcount() > 0){		
	// 	$obj = $st->fetch(PDO::FETCH_ASSOC);
	// 	$cashierbootcode = $obj['CU_UNPAID'];			
	// 		return $cashierbootcode;					
	// 	}else{
	// 		return $this->thefailed;
	// 	}	
	// }

	// 3 JULY 2019
	public function getservicetoday(String $currentshiftcode,String $instcode) : Int{
		$sql = 'SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_SHIFTCODE = ? and REQU_INSTCODE = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $instcode);
		$st->execute();			
		if($st->rowcount() > 0){		
			return $st->rowcount();				
		}else{
			return $this->thefailed;
		}
	}

	// // 3 JULY 2019
	// public function gettotalpopulation(String $instcode) : Int{
	// 	$statu = '1';
	// 	$sql = 'SELECT CU_PATIENTS FROM octopus_current WHERE CU_INSTCODE = ?';
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $instcode);
	// 	$st->execute();
	// 	if($st->rowcount() > 0){
		
	// 	$obj = $st->fetch(PDO::FETCH_ASSOC);
	// 	$cashierbootcode = $obj['CU_PATIENTS'];			
	// 		return $cashierbootcode;					
	// 	}else{
	// 		return $this->thefailed;
	// 	}
	
	// }

	// 3 JULY 2019
	public function getregistrationtoday(String $currentshiftcode, String $instcode) : Int{
		$statu = '1';
		$sql = 'SELECT PATIENT_ID FROM octopus_patients WHERE PATIENT_SHIFTCODE = ? and PATIENT_INSTCODE = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $instcode);
		$st->execute();
		if($st->rowcount() > 0){		
			return $st->rowcount();				
		}else{
			return $this->thefailed;
		}

	}
	
	// 3 JULY 2019
	public function gettotalunpaid( String $currentusercode, String $currentshiftcode) : mixed{
		$statu = '1';
		$sql = 'SELECT CA_TOTALAMT FROM octopus_cashierboots WHERE CA_CASHIERCODE = ? and CA_SHIFTCODE = ? and CA_STATUS = ? ';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $currentshiftcode);
		$st->BindParam(3, $statu);
		$st->execute();
			if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$cashierbootcode = $obj['CA_TOTALAMT'];			
			return $cashierbootcode;					
			}else{
				return $this->thefailed;
			}	
	}
		
	// 3 JULY 2019
	public function getcashiertilcodeed( String $currentusercode, String $currentshiftcode) : mixed{
		$sql = 'SELECT CA_TOTALAMT FROM octopus_cashierboots WHERE CA_CASHIERCODE = ? and CA_SHIFTCODE = ? and CA_STATUS = ? ';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $currentshiftcode);
		$st->BindParam(3, $this->theone);
		$st->execute();
			if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
				$cashierbootcode = $obj['CA_TOTALAMT'];			
				return $cashierbootcode;					
			}else{
				return $this->thefailed;
			}
	
	}

	// 12 SEPT 2020
    public function getcurrentshiftdetails(String $instcode) : mixed{		
		$sql = 'SELECT * FROM octopus_current WHERE CU_INSTCODE = ? ';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->execute();
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$shiftcode = $obj['CU_SHIFTCODE'].'@@@'.$obj['CU_SHIFT'].'@@@'.$obj['CU_SHFTTYPE'].'@@@'.$obj['CU_DATE'];			
				return $shiftcode;					
			}else{
				return $this->thefailed;
			}	
    }
	
	
	// 30 JUNE 2021 JOSEPH ADORBOE
	public function getactionkey(String $form_number, String $form_key) :  Int{	
		$sql = 'SELECT FORM_ID FROM octopus_userformlogs WHERE FORM_KEY = ? AND FORM_NUMBER = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $form_number);
		$action = $st->execute();
		if($action){
			if($st->rowcount() > 0){		
				return $this->thefailed;					
			}else{
				return $this->theexisted;
			}
		}else{
			return -1;
		}		
	
    }
	
	
	  
    public function redirect($url)
	{
	
    if (!headers_sent())
    {
        header('Location: '.$url);
        exit;
    }
    else
    { 	
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; 
		exit;
   	}
	}	
    
}

$engine =  new engine();
