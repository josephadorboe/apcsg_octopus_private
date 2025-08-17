<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_consultations_archive
	$patientconsultationsarchivetable->querygetshiftconsultation($instcode,$first);
	getqueryconsultationreport($fromdate,$todate,$instcode)
	// = new OctopusPatientsConsultationsArchiveSql();	
*/

class OctopusPatientsConsultationsArchiveSql Extends Engine{
	// 13 JUNE 2025, JOSEPH ADORBOE 
	public function querygetsearchshiftconsultationbyshift($instcode,$currentshiftcode) : String {
		$list = ("SELECT CON_CODE,CON_CONSULTATIONNUMBER,CON_DATE,CON_PATIENTNUMBER,CON_PATIENT,CON_COMPLETE,CON_DOCTOR,CON_SERVICE,CON_PAYSCHEME,CON_AGE,CON_GENDER FROM octopus_patients_consultations_archive  WHERE CON_STATUS !='0' AND CON_INSTCODE = '$instcode' AND CON_SHIFTCODE  = '$currentshiftcode' order by CON_ID DESC ");
		return $list;

	}

	// 13 JUNE 2025, JOSEPH ADORBOE 
	public function querygetsearchshiftconsultationbydate($instcode,$first,$second) : String {
		$list = ("SELECT CON_CODE,CON_CONSULTATIONNUMBER,CON_DATE,CON_PATIENTNUMBER,CON_PATIENT,CON_COMPLETE,CON_DOCTOR,CON_SERVICE,CON_PAYSCHEME,CON_AGE,CON_GENDER FROM octopus_patients_consultations_archive  WHERE CON_STATUS !='0' AND CON_INSTCODE = '$instcode' AND DATE(CON_DATE) >= '$first' AND DATE(CON_DATE) <= '$second' order by CON_ID DESC ");
		return $list;

	}

	// 13 JUNE 2025, JOSEPH ADORBOE 
	public function querygetsearchshiftconsultationbyname($instcode,$first) : String {
		$list = ("SELECT CON_CODE,CON_CONSULTATIONNUMBER,CON_DATE,CON_PATIENTNUMBER,CON_PATIENT,CON_COMPLETE,CON_DOCTOR,CON_SERVICE,CON_PAYSCHEME,CON_AGE,CON_GENDER FROM octopus_patients_consultations_archive  WHERE CON_STATUS !='0' AND CON_INSTCODE = '$instcode' AND ( CON_PATIENTNUMBER LIKE '%$first%' OR (CON_PATIENT LIKE '%$first%' ) OR (CON_CONSULTATIONNUMBER LIKE '%$first%') ) ORDER BY CON_ID DESC LIMIT 100");
		return $list;

	}

	// 21 FEB 2025,  JOSEPH ADORBOE 
	public function getquerydoctorconsultationreport($fromdate,$todate,$doctorcode,$doctorname,$instcode){	
		if($doctorcode == '1'){
			$list = ("SELECT CON_DATE,CON_CONSULTATIONNUMBER,CON_PATIENTCODE,CON_PATIENTNUMBER,CON_PATIENT,CON_AGE,CON_GENDER,CON_DOCTOR,CON_DOCTORCODE,CON_PAYSCHEME,CON_SERVICE,CON_STATE from octopus_patients_consultations_archive  where DATE(CON_DATE)  between '$fromdate' AND '$todate'  AND CON_INSTCODE = '$instcode' order by CON_ID DESC ");
		}else{
			$list = ("SELECT CON_DATE,CON_CONSULTATIONNUMBER,CON_PATIENTCODE,CON_PATIENTNUMBER,CON_PATIENT,CON_AGE,CON_GENDER,CON_DOCTOR,CON_DOCTORCODE,CON_PAYSCHEME,CON_SERVICE,CON_STATE from octopus_patients_consultations_archive  where DATE(CON_DATE)  between '$fromdate' AND '$todate'  AND CON_INSTCODE = '$instcode' AND CON_DOCTORCODE = '$doctorcode' order by CON_ID DESC ");
		}	
		
		return $list;
	}
		

	// 21 FEB 2025,  JOSEPH ADORBOE getquerydoctorconsultationreport($fromdate,$todate,$doctorcode,$doctorname,$instcode)
	public function getqueryconsultationreport($fromdate,$todate,$instcode){		
		$list = ("SELECT CON_DATE,CON_CONSULTATIONNUMBER,CON_PATIENTCODE,CON_PATIENTNUMBER,CON_PATIENT,CON_AGE,CON_GENDER,CON_DOCTOR,CON_DOCTORCODE,CON_PAYSCHEME,CON_SERVICE,CON_STATE from octopus_patients_consultations_archive  where DATE(CON_DATE)  between '$fromdate' AND '$todate'  AND CON_INSTCODE = '$instcode' order by CON_ID DESC 
		");
		return $list;
	}

	// 19 FEB 2025,  JOSEPH ADORBOE
	public function getquerypatientfoldercompletedconsultations($patientcodecode,$instcode){		
		$list = ("SELECT * from octopus_patients_consultations_archive  where CON_STATUS !='0' and CON_PATIENTCODE = '$patientcodecode' and CON_INSTCODE = '$instcode' order by CON_ID DESC 
		");
		return $list;
	}

	// 2 oct 2023 JOSEPH ADORBOE
	public function getquerycompletedconsultations($currentusercode,$instcode){		
		$list = ("SELECT * from octopus_patients_consultations_archive  WHERE CON_STATUS IN('5') AND CON_DOCTORCODE = '$currentusercode' AND CON_INSTCODE = '$instcode' AND CON_COMPLETE = '2' order by CON_ACTIONDATE DESC
		");
		return $list;
	}

	// 17 MAR 2021 JOSEPH ADORBOE 
	public function getpatientconsultationservicebasketdetails($idvalue){
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations_archive where CON_VISITCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_COMPLAINT'].'@'.$object['CON_PHYSIALEXAMS'].'@'.$object['CON_INVESTIGATION'].'@'.$object['CON_DIAGNSIS'].'@'.$object['CON_PRESCRIPTION'].'@'.$object['CON_DOCNOTES'].'@'.$object['CON_PROCEDURE'].'@'.$object['CON_OXYGEN'].'@'.$object['CON_MANAGEMENT'].'@'.$object['CON_DEVICES'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}
	// 26 oct 2023 JOSEPH ADORBOE
	public function getqueryfolderconsultations($patientcodecode,$instcode){		
		$day = date("Y-m-d");
		$list = ("SELECT * from octopus_patients_consultations_archive  where CON_STATUS !='0' and CON_PATIENTCODE = '$patientcodecode' and CON_INSTCODE = '$instcode' order by CON_ID DESC
		");
		return $list;
	}
	// 24 SEPT 2023 JOSEPH ADORBOE
	public function getquerypastedconsultation($currentusercode,$instcode){		
		$list = ("SELECT * from octopus_patients_consultations_archive  where CON_STATUS ='5' and CON_DOCTORCODE = '$currentusercode' and CON_INSTCODE = '$instcode' order by CON_CONSULTATIONNUMBER DESC ");
		return $list;
	}
	// 25 Oct 2023,  JOSEPH ADORBOE   WHERE 
    public function endconsultationarchive($days,$patientaction,$action,$visitcode,$instcode){
		$ten = 10;
		$five = 5;
		$two = 2;
		$one = 1; 
		$sql = "UPDATE octopus_patients_consultations_archive SET  CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ? , CON_ACTIONDATE = ?, CON_ACTIONCODE = ? , CON_ACTION = ? WHERE CON_VISITCODE = ? AND CON_INSTCODE =? ";
		$st = $this->db->prepare($sql);		
		$st->BindParam(1, $ten);
		$st->BindParam(2, $five);
		$st->BindParam(3, $two);
		$st->BindParam(4, $days);
		$st->BindParam(5, $patientaction);
		$st->BindParam(6, $action);
		$st->BindParam(7, $visitcode);
		$st->BindParam(8, $instcode);			
		$exe = $st->execute();		
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	// 18 SEPT 2023,  JOSEPH ADORBOE
    public function cancelarchiveconsultationrequestcode($ekey,$cancelreason,$instcode){
		$zero = '0';
		$action = 'Cancelled';
		$days = date("Y-m-d H:i:s");
		$sql = "UPDATE octopus_patients_consultations_archive SET  CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ?, CON_ACTIONDATE = ? , CON_ACTIONCODE = ? , CON_ACTION = ?, CON_REMARKS = ?   WHERE CON_REQUESTCODE = ? AND CON_INSTCODE = ? ";
		$st = $this->db->prepare($sql);		
		$st->BindParam(1, $zero);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $days);
		$st->BindParam(5, $zero);
		$st->BindParam(6, $action);
		$st->BindParam(7, $cancelreason);
		$st->BindParam(8, $ekey);	
		$st->BindParam(9, $instcode);			
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}

	// 18 SEPT 2023,  JOSEPH ADORBOE
    public function cancelarchiveconsultation($consultationcode,$cancelreason,$instcode){
		$zero = '0';
		$action = 'Cancelled';
		$days = date("Y-m-d H:i:s");
		$sql = "UPDATE octopus_patients_consultations_archive SET  CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ?, CON_ACTIONDATE = ? , CON_ACTIONCODE = ? , CON_ACTION = ?, CON_REMARKS = ?   WHERE CON_CODE = ? AND CON_INSTCODE = ? ";
		$st = $this->db->prepare($sql);		
		$st->BindParam(1, $zero);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $days);
		$st->BindParam(5, $zero);
		$st->BindParam(6, $action);
		$st->BindParam(7, $cancelreason);
		$st->BindParam(8, $consultationcode);	
		$st->BindParam(9, $instcode);			
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	// 5 NOV 2023, 12 FEB 2022 JOSEPH ADORBOE 
	public function getpatientfolderconsultationdetails($idvalue){
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations_archive where CON_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_PAYMENTTYPE'].'@'.$object['CON_ACTION'].'@'.$object['CON_ACTIONCODE'].'@'.$object['CON_ACTIONDATE'].'@'.$object['CON_DOCTOR'].'@'.$object['CON_DOCTORCODE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	
	// 4 MAY 2025,  JOSEPH ADORBOE 
	public function getpatientphysioconsultationarchivedetails(String $idvalue, String $instcode){
		$sqlstmt = ("SELECT CON_CODE,CON_REQUESTCODE,CON_VISITCODE,CON_DATE,CON_PATIENTCODE,CON_PATIENTNUMBER,CON_PATIENT,CON_AGE,CON_GENDER,CON_SERIAL,CON_PAYMENTMETHOD,CON_PAYMENTMETHODCODE,CON_PAYSCHEMECODE,CON_PAYSCHEME,CON_SERVICECODE,CON_SERVICE,CON_STATUS,CON_STAGE,CON_PAYMENTTYPE  FROM octopus_patients_consultations_archive WHERE CON_REQUESTCODE = ? AND CON_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_PAYMENTTYPE'];
				return $results;
			}else{
				return 1 ;
			}

		}else{
			return $this->thefailed;
		}			
	}

	// 17 MAR 2021 JOSEPH ADORBOE 
	public function getpatientconsultationarchivedetails($idvalue){
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations_archive where CON_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_PAYMENTTYPE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}			
	}	
	// 18 SEPT 2023,  JOSEPH ADORBOE
    public function updateconsulationsdoctor($ekey,$specsname,$specscode,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "UPDATE octopus_patients_consultations_archive SET CON_DOCTOR = ?, CON_DOCTORCODE = ?, CON_ACTORCODE = ? , CON_ACTOR = ?  where CON_REQUESTCODE = ? AND CON_INSTCODE = ?";
			$st = $this->db->Prepare($sqlstmt);
			$st->BindParam(1, $specsname);
			$st->BindParam(2, $specscode);
			$st->BindParam(3, $currentusercode);
			$st->Bindparam(4, $currentuser);
			$st->BindParam(5, $ekey);
			$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	public function insertconsultationsarchive($ekey,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$specscode,$specsname,$days,$serialnumber,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$patientservicecode,$patientservice,$paymenttype,$consultationnumber,$currentday,$currentmonth,$currentyear,$plan){
		$one = 1;
		$consultationcode = md5(microtime());	
			$sqlstmt = "INSERT INTO octopus_patients_consultations_archive(CON_CODE,CON_VISITCODE,CON_DATE,CON_PATIENTCODE,CON_PATIENTNUMBER,CON_PATIENT,CON_AGE,CON_GENDER,CON_SERIAL,CON_DOCTOR,CON_DOCTORCODE,CON_PAYMENTMETHOD,CON_PAYMENTMETHODCODE,CON_PAYSCHEMECODE,CON_PAYSCHEME,CON_SERVICECODE,CON_SERVICE,CON_ACTOR,CON_ACTORCODE,CON_INSTCODE,CON_SHIFTCODE,CON_SHIFT,CON_REQUESTCODE,CON_PAYMENTTYPE,CON_CONSULTATIONNUMBER,CON_DAY,CON_MONTH,CON_YEAR,CON_PLAN) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $consultationcode);
					$st->BindParam(2, $visitcode);
					$st->BindParam(3, $days);
					$st->BindParam(4, $patientcode);
					$st->BindParam(5, $patientnumber);
					$st->BindParam(6, $patient);
					$st->BindParam(7, $age);
					$st->BindParam(8, $gender);
					$st->BindParam(9, $serialnumber);
					$st->BindParam(10, $specsname);
					$st->BindParam(11, $specscode);
					$st->BindParam(12, $paymentmethod);
					$st->BindParam(13, $paymentmethodcode);
					$st->BindParam(14, $patientschemecode);
					$st->BindParam(15, $patientscheme);
					$st->BindParam(16, $patientservicecode);
					$st->BindParam(17, $patientservice);
					$st->BindParam(18, $currentuser);
					$st->BindParam(19, $currentusercode);
					$st->BindParam(20, $instcode);
					$st->BindParam(21, $currentshiftcode);
					$st->BindParam(22, $currentshift);
					$st->BindParam(23, $ekey);
					$st->BindParam(24, $paymenttype);
					$st->BindParam(25, $consultationnumber);
					$st->BindParam(26, $currentday);
					$st->BindParam(27, $currentmonth);
					$st->BindParam(28, $currentyear);
					$st->BindParam(29, $plan);
					$exe = $st->execute();
					if($exe){								
						return '2';								
					}else{								
						return '0';								
					}					
	}
	// 4 SEPT 2023
	public function newconsultationsarchive($newconsultationcode,$servicerequestcode,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$servicecode,$servicesed,$schemecode,$scheme,$paymentmethodcode,$paymentmethod,$consultationnumber,$consultationpaymenttype,$remarks,$physicians,$physiciancode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear){
		$one = 1;
			$sqlstmt = "INSERT INTO octopus_patients_consultations_archive(CON_CODE,CON_VISITCODE,CON_DATE,CON_PATIENTCODE,CON_PATIENTNUMBER,CON_PATIENT,CON_AGE,CON_GENDER,CON_SERIAL,CON_DOCTOR,CON_DOCTORCODE,CON_PAYMENTMETHOD,CON_PAYMENTMETHODCODE,CON_PAYSCHEMECODE,CON_PAYSCHEME,CON_SERVICECODE,CON_SERVICE,CON_ACTOR,CON_ACTORCODE,CON_INSTCODE,CON_SHIFTCODE,CON_SHIFT,CON_REQUESTCODE,CON_PAYMENTTYPE,CON_CONSULTATIONNUMBER,CON_DAY,CON_MONTH,CON_YEAR,CON_REMARKS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
						$st = $this->db->prepare($sqlstmt);   
						$st->BindParam(1, $newconsultationcode);
						$st->BindParam(2, $visitcode);
						$st->BindParam(3, $days);
						$st->BindParam(4, $patientcode);
						$st->BindParam(5, $patientnumber);
						$st->BindParam(6, $patient);
						$st->BindParam(7, $age);
						$st->BindParam(8, $gender);
						$st->BindParam(9, $one);
						$st->BindParam(10, $physicians);
						$st->BindParam(11, $physiciancode);
						$st->BindParam(12, $paymentmethod);
						$st->BindParam(13, $paymentmethodcode);
						$st->BindParam(14, $schemecode);
						$st->BindParam(15, $scheme);
						$st->BindParam(16, $servicecode);
						$st->BindParam(17, $servicesed);
						$st->BindParam(18, $currentuser);
						$st->BindParam(19, $currentusercode);
						$st->BindParam(20, $instcode);
						$st->BindParam(21, $currentshiftcode);
						$st->BindParam(22, $currentshift);
						$st->BindParam(23, $servicerequestcode);
						$st->BindParam(24, $consultationpaymenttype);
						$st->BindParam(25, $consultationnumber);
						$st->BindParam(26, $currentday);
						$st->BindParam(27, $currentmonth);
						$st->BindParam(28, $currentyear);
						$st->BindParam(29, $remarks);
						$exe = $st->execute();
						if($exe){								
							return '2';								
						}else{								
							return '0';								
						}
			}
	// 3 SEPT 2023,  JOSEPH ADORBOE
    public function dischargeconsultationarchive($days,$patientaction,$action,$remarks,$consultationcode,$currentuser,$currentusercode,$instcode){
		$ten = 10;
		$five = 5;
		$two = 2;
		$sql = "UPDATE octopus_patients_consultations_archive SET CON_ACTIONDATE = ?, CON_ACTIONCODE = ?,  CON_ACTION = ?,  CON_REMARKS = ?, CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ?, CON_ACTOR = ?, CON_ACTORCODE = ?  WHERE CON_CODE = ? AND CON_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $patientaction);
		$st->BindParam(3, $action);
		$st->BindParam(4, $remarks);
		$st->BindParam(5, $ten);
		$st->BindParam(6, $five);
		$st->BindParam(7, $two);
		$st->BindParam(8, $currentuser);
		$st->BindParam(9, $currentusercode);
		$st->BindParam(10, $consultationcode);
		$st->BindParam(11, $instcode);			
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	// 3 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientnumberconsulationsarchive($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "UPDATE octopus_patients_consultations_archive SET CON_PATIENTNUMBER = ?, CON_ACTOR = ?, CON_ACTORCODE =?  where CON_PATIENTCODE = ? and CON_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $replacepatientnumber);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	// 2 AUG 2024 JOSEPH ADORBOE 
	public function completedtodayconsultation($currentusercode,$instcode){
		$day = date("Y-m-d");
		$five = 5;
		$two = 2;
		$list = ("SELECT * from octopus_patients_consultations_archive  WHERE CON_STATUS = '$five' AND CON_DOCTORCODE = '$currentusercode' AND CON_INSTCODE = '$instcode' AND CON_COMPLETE = '$two' order By CON_ACTIONDATE DESC LIMIT 10 ");
		return $list;
	}
	// 13 JAN 2022 JOSEPH ADORBOE  
	public function  getlastvisitarchivedetails($lastvisitcode,$patientcode){			
		$sp = 1 ;		
		$sql = "SELECT * FROM octopus_patients_consultations_archive where CON_PATIENTCODE = ? AND CON_VISITCODE = ? "; 
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $lastvisitcode);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['CON_DOCTOR'].'@'.$obj['CON_DATE'].'@'.$obj['CON_COMPLAINT'].'@'.$obj['CON_PHYSIALEXAMS'].'@'.$obj['CON_INVESTIGATION'].'@'.$obj['CON_DIAGNSIS'].'@'.$obj['CON_PRESCRIPTION'].'@'.$obj['CON_DOCNOTES'].'@'.$obj['CON_PROCEDURE'].'@'.$obj['CON_OXYGEN'].'@'.$obj['CON_MANAGEMENT'].'@'.$obj['CON_DEVICES'];			
		}else{			
			$valu = 0;			
		}		
		return $valu ;		
	}
	// 18 JULY 2021 JOSEPH ADORBOE  
	public function  getlastvisitdetails($lastvisitcode,$patientcode){			
		$sp = 1 ;		
		$sql = "SELECT * FROM octopus_patients_consultations_archive where CON_PATIENTCODE = ? AND CON_VISITCODE = ? "; 
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $lastvisitcode);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['CON_DOCTOR'].'@'.$obj['CON_DATE'].'@'.$obj['CON_COMPLAINT'].'@'.$obj['CON_PHYSIALEXAMS'].'@'.$obj['CON_INVESTIGATION'].'@'.$obj['CON_DIAGNSIS'].'@'.$obj['CON_PRESCRIPTION'].'@'.$obj['CON_DOCNOTES'].'@'.$obj['CON_PROCEDURE'].'@'.$obj['CON_OXYGEN'].'@'.$obj['CON_MANAGEMENT'].'@'.$obj['CON_DEVICES'];			
		}else{			
			$valu = 0;			
		}		
		return $valu ;		
	}
	
} 
$patientconsultationsarchivetable = new OctopusPatientsConsultationsArchiveSql();

// 2 AUG 2024 JOSEPH ADORBOE 
function widgetcompletedconsultation($currentusercode,$instcode,$dbconn,$patientconsultationsarchivetable,$patienttable){ ?>
	<div class="card">
			<div class="card-header ">
				<h3 class="card-title ">Completed Consultation</h3>
				<div class="card-options">
					<a href="pastconsultation" class="btn btn-secondary btn-sm">More </a>							
				</div>
			</div>
			<div class="card-body" style="min-height: 350px; max-height: 350px; font-size: 14px; overflow: scroll;">
			<div class="table-responsive">
				
				<table class="table card-table table-striped table-vcenter table-outline table-bordered text-nowrap ">
					<thead>
						<tr>
							<th scope="col" class="border-top-0">No.</th>							
							<th>Patient Details</th>
							<!-- <th>Patient No.</th>
							<th>Service</th>	 -->
						</tr>
					</thead>
					<tbody>
						<?php 								
							$nu = 0;
							$mypatientgpconsultationlist = $patientconsultationsarchivetable->completedtodayconsultation($currentusercode,$instcode);
							$getmypatientgpconsultationlist = $dbconn->query($mypatientgpconsultationlist);
							while ($row = $getmypatientgpconsultationlist->fetch(PDO::FETCH_ASSOC)){
								$patientcode = $row['CON_PATIENTCODE'];
								$patientdetails = $patienttable->getpatientdetails($patientcode);
							if($patientdetails !== '1'){
								$pdetails = explode('@',$patientdetails);								
								$patientlastvisit = $pdetails[12];
								$patientnumvisit = $pdetails[13];
								$patientnextreviewdate = $pdetails[14];	
								$patientnextreviewservices = $pdetails[18];					
							}
							      
						?>		<tr > 
									<td><?php echo ++$nu; ?></td>											
									<td><a href="#" onClick="MyWindow=window.open('pastconsultationdetails?<?php echo $row['CON_CODE'] ; ?>','MyWindow<?php echo $row['CON_CODE'] ; ?>','left=50px,top=30px,width=1300px,height=800px'); return false;">
										<?php echo $row['CON_CONSULTATIONNUMBER'] ; ?> - <?php echo $row['CON_PATIENTNUMBER'] ; ?> - <?php echo $row['CON_PATIENT']?><br /> 
									<?php echo $row['CON_PAYSCHEME'] ; ?> - <?php echo $row['CON_SERVICE'] ; ?> <br />
									By : <?php echo $row['CON_ACTOR'] ; ?> - Action on : <?php echo date('d M Y', strtotime($row['CON_ACTIONDATE'])) ; ?><br />
									
									Next Visit : <?php echo date('d M Y', strtotime($patientnextreviewdate)) ; ?> @ <?php echo $patientnextreviewservices ; ?>
								</td>
								</tr>
					<?php  }  ?>
				</tbody>
				</table>
				
				</div>
			</div>
		</div>

	<?php  }
?>