<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 8 MAY 2024
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_year
	$patientsyeartable->getnewpatientnumber($instcode)
*/

class OctopusPatientsYearSql Extends Engine{
	// 8 MAY 2024 6 JAN 2021
	public function getnewpatientnumber($instcode){		
		$theyear = date('Y');				
		$sql = "SELECT PYR_SERIAL FROM octopus_patients_year where PYR_YEAR = ? and PYR_INSTCODE = ? "; 
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $theyear);
		$st->BindParam(2, $instcode);
		$ext = $st->execute();
		if($ext){
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = $obj['PYR_SERIAL'];
				$value = $valu + 1;
				$patientnumber = $value.'/'.$theyear;	
				if($instcode == 'HMS1000'){
					$patientnumber = $value.'/OG/'.$theyear;
				}			
			}else{				
				$value = 1;
				$patientnumber = $value.'/'.$theyear;
				if($instcode == 'HMS1000'){
					$patientnumber = $value.'/OG/'.$theyear;
				}				
			}
			return $patientnumber ;
		}else{
			return '0';
		}		
	}
	// 8 MAY 2024, 8 JAN 2021   JOSEPH ADORBOE
    public function processpatientnumber($form_key,$theserial,$theyear,$instcode,$currentuser,$currentusercode){	
		$rt = 1;
		$sqlstmt = ("SELECT PYR_ID, PYR_SERIAL FROM octopus_patients_year where PYR_YEAR = ? and  PYR_INSTCODE = ? and PYR_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $theyear);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $rt);
		$st->execute();		
		if($st->rowcount() > 0){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$serial = $obj['PYR_SERIAL'];		
			$rt = 0;
			if($serial>$theserial){
				return '2';
			}else{
			$sql = "UPDATE octopus_patients_year SET PYR_SERIAL = ? WHERE PYR_YEAR = ? and PYR_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $theserial);
			$st->BindParam(2, $theyear);
			$st->BindParam(3, $instcode);			
			$exe = $st->execute();			
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}
		}				
		}else{			
		$sqlstmt = "INSERT INTO octopus_patients_year(PYR_CODE,PYR_SERIAL,PYR_YEAR,PYR_INSTCODE,PYR_ACTOR,PYR_ACTORCODE) VALUES (?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $theserial);
		$st->BindParam(3, $theyear);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $currentusercode);
		$exe = $st->execute();			
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}	
	}
	}
	
} 
	$patientsyeartable = new OctopusPatientsYearSql();
?>