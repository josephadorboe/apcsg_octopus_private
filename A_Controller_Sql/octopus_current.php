<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 3 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_current
	$currenttable = new OctopusCurrentSql();	
*/

class OctopusCurrentSql Extends Engine{
	// 17 APR 2021
	public function getcurrentdetails(String $instcode) : mixed{		
		$sql = 'SELECT CU_SHIFTCODE,CU_SHIFT,CU_SHFTTYPE,CU_DATE,CU_STAFFPERSHIFT,CU_PRECRIPECODE,CU_CONSULTATIONDURATION,CU_STARTCONSULTATION,CU_ENDCONSULTATION,CU_DAYSAHEAD,CU_APPOINTMENTNUMBER,CU_STARTSHIFT,CU_ENDSHIFT,CU_LASTCHECK,CU_DAY,CU_WEEK,CU_MONTH,CU_YEAR FROM octopus_current WHERE CU_INSTCODE = ? ';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->execute();
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				// 							0							1					2						3						4					
				$currentdetails = $obj['CU_SHIFTCODE'].'@@@'.$obj['CU_SHIFT'].'@@@'.$obj['CU_SHFTTYPE'].'@@@'.$obj['CU_DATE'].'@@@'.$obj['CU_STAFFPERSHIFT'].'@@@'.$obj
				//        5								6										7								8								9				
				['CU_PRECRIPECODE'].'@@@'.$obj['CU_CONSULTATIONDURATION'].'@@@'.$obj['CU_STARTCONSULTATION'].'@@@'.$obj['CU_ENDCONSULTATION'].'@@@'.$obj['CU_DAYSAHEAD'].'@@@'.
				// 			10								11							12							13						14	
				$obj['CU_APPOINTMENTNUMBER'].'@@@'.$obj['CU_STARTSHIFT'].'@@@'.$obj['CU_ENDSHIFT'].'@@@'.$obj['CU_LASTCHECK'].'@@@'.$obj['CU_DAY'].'@@@'.$obj
			//		15						16					17
				['CU_WEEK'].'@@@'.$obj['CU_MONTH'].'@@@'.$obj['CU_YEAR'] ;
				//.
				//					7							8							9							10								11
			//	.'@@@'.$obj['CU_CREDITSTATUS'];			
				
				return $currentdetails;					
			}else{
				return $this->thefailed;
			}	
	}	
	

	// 09 JULY 2021
	public function getreviewrequestcode(String $instcode) : Int
	{
		$sql = " SELECT CU_REVIEWCODE FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_REVIEWCODE'];
		$value = $data + 1;			
		return $value;		
	}


	// 28 Sept 2023,  14 MAY 2021 JOSEPH ADORBOE 
	public function getlastdevicecodenumber(String $instcode) : Int{
		$sqlstmt = ("SELECT CU_DEVICECODE FROM octopus_current where CU_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['CU_DEVICECODE'];
				$results = $value + 1;
				return $results;
			}else{
				return -1 ;
			}
		}else{
			return  -1 ;
		}			
	}

	// 28 Sept 2023, 13 MAY 2021 JOSEPH ADORBOE 
	public function getlastmedicationcodenumber(String $instcode) : Int{
		$sqlstmt = ("SELECT CU_MEDICATIONCODE FROM octopus_current where CU_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['CU_MEDICATIONCODE'];
				$results = $value + 1;
				return $results;
			}else{
				return -1 ;
			}
		}else{
			return  -1 ;
		}			
	}

	// 24 Sept 2023, 14 MAY 2021 JOSEPH ADORBOE 
	public function getlastlabcodenumber(String $instcode) : Int{
		$sqlstmt = ("SELECT CU_LABCODE FROM octopus_current where CU_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['CU_LABCODE'];
				$results = $value + 1;
				return $results;
			}else{
				return -1 ;
			}

		}else{
			return  -1 ;
		}
			
	}
	
	// 6 MAR 2021 JOSEPH ADORBOE 
	public function getlastestreceiptnumber(String $instcode) : Int{
		$sqlstmt = ("SELECT CU_RECEIPTNUMBER  FROM octopus_current where CU_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['CU_RECEIPTNUMBER'];
				$results = $value + 1;
				return $results;
			}else{
				return -1;
			}
		}else{
			return -1;
		}			
	}	
	// 1 SEPT  2023
	public function updateincidencenumber( String $instcode, String $incidencecode) : Int {
		$sql = "UPDATE octopus_current SET CU_INCIDENCENUMBER = ?  WHERE CU_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $incidencecode);
		$st->BindParam(2, $instcode);						
		$exe = $st->execute();
		if($exe){			
			return $this->thepassed;			
		}else{			
			return  $this->thefailed;		
		}
	}
	// 9 AUG 2023
	public function updatereceipt(String $instcode) : Int {
		$one = 1;
		$sql = "UPDATE octopus_current SET CU_RECEIPTNUMBER = CU_RECEIPTNUMBER + ?  WHERE CU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $instcode);
		$reciptnum = $st->Execute();
		if($reciptnum){			
			return $this->thepassed;			
		}else{			
			return $this->thefailed;		
		}
	}
	// 7 MAR 2021
	public function activatefacilitycreditstatus( String $currentusercode, String $currentuser, String $instcode) : Int{		
		$sql = "UPDATE octopus_current SET CU_CREDITSTATUS = ?  WHERE CU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->theone);
		$st->BindParam(2, $instcode);
		$activatescheme = $st->execute();		
		if($activatescheme){			
			return $this->thepassed;			
		}else{			
			return $this->thefailed;		
		}
	}	
	// 7 MAR 2021 JOSEPH ADORBOE
	public function getfacilitycreditstatus(String $instcode) : int
	{
		$sql = 'SELECT CU_CREDITSTATUS FROM octopus_current WHERE CU_INSTCODE = ?  ';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);		
		$state = $st->execute();
		if($state){
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$results = $obj['CU_CREDITSTATUS'];			
				return $results;					
			}else{
				return -1;
			}
		}else{
			return -1;
		}	
	}
	// 7 MAR 2021
	public function deactivatefacilitycreditstatus( String $currentusercode, String $currentuser, String $instcode) : Int {		
		$sql = "UPDATE octopus_current SET CU_CREDITSTATUS = ?  WHERE CU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thezero);
		$st->BindParam(2, $instcode);
		$activatescheme = $st->execute();		
		if($activatescheme){			
			return $this->thepassed;		
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

	// 3 JULY 2019
	public function gettotalpopulation(String $instcode) : mixed{
		
		$sql = 'SELECT CU_PATIENTS FROM octopus_current WHERE CU_INSTCODE = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->execute();
		if($st->rowcount() > 0){
		
		$obj = $st->fetch(PDO::FETCH_ASSOC);
		$cashierbootcode = $obj['CU_PATIENTS'];			
			return $cashierbootcode;					
		}else{
			return $this->thefailed;
		}	
	}

	// 9 AUG 2023, 3 JULY 2019
	public function getunpaid(String $instcode) : mixed{
		$sql = 'SELECT CU_UNPAID FROM octopus_current WHERE CU_INSTCODE = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->execute();
		if($st->rowcount() > 0){
		
		$obj = $st->fetch(PDO::FETCH_ASSOC);
		$cashierbootcode = $obj['CU_UNPAID'];			
			return $cashierbootcode;					
		}else{
			return $this->thefailed;
		}	
	}
	
	// 03 AUG 2023  09 JULY 2021   JOSEPH ADORBOE
	public function updatecurrenttable(String $columnname,$coulmnvalue,$instcode) : Int {								
		$sql = "UPDATE octopus_current SET $columnname = ? WHERE CU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $coulmnvalue);
		$st->BindParam(2, $instcode);
		$exe = $st->execute();												
		if($exe){								
			return $this->thepassed;								
		}else{								
			return $this->thefailed;						
		}				
	}	
	
} 
$currenttable = new OctopusCurrentSql();	
?>