<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_serial
	$serialtable = new OctopusSerialSql();
*/

class OctopusSerialSql Extends Engine{
		// 4 SEPT 2023,  JOSEPH ADORBOE
		public function updateserials($count,$physiciancode,$instcode){
			$one = 1;			
			$sql = "UPDATE octopus_serial SET SERIAL_NUMBER = ?  WHERE SERIAL_DOCTORCODE = ? AND  SERIAL_INSTCODE = ?";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $count );
			$st->BindParam(2, $physiciancode);
			$st->BindParam(3, $instcode);
			$exe = $st->execute();	
			if($exe){				
				return '2';
			}else{				
				return '0';				
			}	
		}
		// 12 MAY 2021 JOSEPH ADORBOE 
	public function getconsultationserialnumber($form_key,$specscode,$specsname,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode){
		$rt = 1;
		//echo $specscode;
		//die;
		$sqlstmt = ("SELECT * FROM octopus_serial WHERE SERIAL_INSTCODE = ? AND SERIAL_SHIFTCODE = ? AND SERIAL_DOCTORCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $currentshiftcode);
		$st->BindParam(3, $specscode);		
		$expt = $st->execute();
		if($expt){
		//	echo $st->rowcount();
		//	die;
			if($st->rowcount() > '0'){
			//	die('testing');
				$object =  $st->fetch(PDO::FETCH_ASSOC);
				$serialnumber = $object['SERIAL_NUMBER'];
				return $serialnumber;
			}else{
			//	die('test');
				$serial = 0 ;
				$sqlstmt = "INSERT INTO octopus_serial(SERIAL_CODE,SERIAL_DOCTOR,SERIAL_DOCTORCODE,SERIAL_DATE,SERIAL_SHIFT,SERIAL_SHIFTCODE,SERIAL_NUMBER,SERIAL_ACTOR,SERIAL_ACTORCODE,SERIAL_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $specscode);
				$st->BindParam(3, $specsname);
				$st->BindParam(4, $days);
				$st->BindParam(5, $currentshift);
				$st->BindParam(6, $currentshiftcode);
				$st->BindParam(7, $serial);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$exe = $st->execute();
				if($exe){
					return $serial;
				}else{
					return '0';
				}				
			}
		}else{
			return '0';
		}
	}
} 

$serialtable = new OctopusSerialSql();
?>