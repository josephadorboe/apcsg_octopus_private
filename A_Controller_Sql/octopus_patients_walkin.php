<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 27 DEC 2024
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_walkin
	$patientswalkintable->querygetserachpatient($instcode,$searchitem,$searchparam)
*/

class OctopusPatientsWalkInSql Extends Engine{

	// 24 MAY 2025,  JOSEPH ADORBOE
	public function getwalkinpatientdetail(String $patientcode,String $instcode) : mixed{	
		$nut = 1;	
		$sql = 'SELECT PAT_CODE,PAT_NUMBER,PAT_PATIENT,PAT_GENDER,PAT_BIRTHDATE,PAT_PHONENUMBER,PAT_ADDRESS FROM octopus_patients_walkin WHERE PAT_CODE = ? and PAT_INSTCODE = ? and PAT_STATUS = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$ext = $st->execute();
		if($ext){		
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$day = date('Y-m-d');		
				$age = 0;
				$yearOnly1 = date('Y', strtotime($obj['PAT_BIRTHDATE']));
				$yearOnly2 = date('Y', strtotime($day));		
				$monthOnly1 = date('m', strtotime($obj['PAT_BIRTHDATE']));
				$monthOnly2 = date('m', strtotime($day));
				$dayOnly1 = date('d', strtotime($obj['PAT_BIRTHDATE']));
				$dayOnly2 = date('d', strtotime($day));
				$yearOnly = $yearOnly2 - $yearOnly1;
				$monthOnly = $monthOnly2 - $monthOnly1;
				$dayOnly = $dayOnly2 - $dayOnly1;
				if($yearOnly>0){
					if($monthOnly<1){
						$m = 1;
						$yr = $yearOnly - 1;
						$age = $yr .' Years';
					}elseif($monthOnly>'0'){
						$age = $yearOnly .' Years';
					}else if($monthOnly=='0'){
						$age = $yearOnly .' Years';;
					}
				}else{
					$age = $monthOnly .'Months';
				}
				
				//						0								1						2										
				$currentdetails = $obj['PAT_NUMBER'].'@'.$obj['PAT_PATIENT'].'@'.$obj['PAT_GENDER'].'@'.$obj['PAT_BIRTHDATE'].'@'.$age.'@'.$obj['PAT_PHONENUMBER'].'@'.$obj['PAT_ADDRESS'];				
				return $currentdetails;					
			}else{
				return $this->thefailed;
			}
		}else{
			return $this->thefailed;
		}	
	}

	// 24 MAY 2025 
	public function querygetserachpatient($instcode,$searchitem,$searchparam) : String{
		$list = ("SELECT PAT_CODE,PAT_NUMBER,PAT_PATIENT,PAT_GENDER,PAT_BIRTHDATE,PAT_DATE,PAT_PHONENUMBER,PAT_ADDRESS,PAT_ACTOR,PAT_ACTORCODE,PAT_INSTCODE FROM octopus_patients_walkin WHERE PAT_INSTCODE = '$instcode' AND $searchparam like '%$searchitem%' ");																	
		return $list;
	}

	// 31 JULY 2021   JOSEPH ADORBOE
	public function insert_addnewwalkinpatient($patientcode,$patientname,$gender,$birthdate,$phonenumber,$address,$currentusercode,$currentuser,$instcode) : Int{		
		$nt = 1; 
		$sqlstmt = ("SELECT PAT_ID FROM octopus_patients_walkin WHERE PAT_PHONENUMBER = ? AND PAT_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $phonenumber);
		$st->BindParam(2, $instcode);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){
				$row = $st->fetch(PDO::FETCH_ASSOC);				
				return $this->theexisted;			
			}else{	

				$sqlstmt = "INSERT INTO octopus_patients_walkin(PAT_CODE,PAT_NUMBER,PAT_PATIENT,PAT_GENDER,PAT_BIRTHDATE,PAT_DATE,PAT_PHONENUMBER,PAT_ACTOR,PAT_ACTORCODE,PAT_INSTCODE,PAT_ADDRESS) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $patientcode);
				$st->BindParam(2, $phonenumber);
				$st->BindParam(3, $patientname);
				$st->BindParam(4, $gender);
				$st->BindParam(5, $birthdate);
				$st->BindParam(6, $this->thedays);
				$st->BindParam(7, $phonenumber);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $address);				
				$exe = $st->execute();						
				if($exe){							
						return $this->thepassed;
					}else{
						return $this->thefailed;
					}							
				}
		}else{
			return '0';
		}

	}
	
	// 31 JULY 2021 JOSEPH ADORBOE
	public function getnonpatientdetails($patientcodecode,$instcode) : mixed{	
		$nut = 1;	
		$sql = 'SELECT PAT_NUMBER,PAT_PATIENT,PAT_GENDER,PAT_AGE FROM octopus_patients_walkin WHERE PAT_CODE = ? and PAT_INSTCODE = ? and PAT_STATUS = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcodecode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$ext = $st->execute();
		if($ext){		
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				// 								0								1										
				$currentdetails = $obj['PAT_NUMBER'].'@'.$obj['PAT_PATIENT'].'@'.$obj['PAT_GENDER'].'@'.$obj['PAT_AGE'];				
				return $currentdetails;					
			}else{
				return $this->thefailed;
			}
		}else{
			return $this->thefailed;
		}	
	}

} 
	$patientswalkintable = new OctopusPatientsWalkInSql();
?>