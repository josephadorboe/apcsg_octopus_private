<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 31 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients
	$patienttable->updatepatientresetphysiotherpy($patientcode,$currentusercode,$currentuser,$instcode);
*/

class OctopusPatientsSql Extends Engine{

	// 12 JUNE 2025, JOSEPH ADORBOE
	public function patientsearchforattachment($instcode,$searchitem,$searchparam) : String {
		$list = ("SELECT PATIENT_CODE,PATIENT_PATIENTNUMBER,PATIENT_NAMES,PATIENT_GENDER,PATIENT_DOB,PATIENT_PHONENUMBER,PATIENT_PAYMENTMETHOD,PATIENT_STATUS,PATIENT_BILLCURRENCY,PATIENT_ALTPHONENUMBER,PATIENT_PHYSIO,PATIENT_DOD,PATIENT_RELIGION,PATIENT_MARITAL,PATIENT_NATIONALITY,PATIENT_OCCUPATION,PATIENT_HOMEADDRESS,PATIENT_LASTVISIT,PATIENT_NUMVISITS,PATIENT_REVIEWDATE,PATIENT_SERVICES FROM octopus_patients WHERE PATIENT_INSTCODE = '$instcode' AND $searchparam like '%$searchitem%' ");																	
		return $list;
	}
	// 11 MAR 2025, JOSEPH ADORBOE
	public function patientrecordpatientssearch($instcode,$searchitem,$searchparam) : String {
		$list = ("SELECT PATIENT_CODE,PATIENT_PATIENTNUMBER,PATIENT_TITLE,PATIENT_FIRSTNAME,PATIENT_LASTNAME,PATIENT_NAMES,PATIENT_GENDER,PATIENT_DOB,PATIENT_PHONENUMBER,PATIENT_PAYMENTMETHOD,PATIENT_STATUS,PATIENT_BILLCURRENCY,PATIENT_ALTPHONENUMBER,PATIENT_PHYSIO,PATIENT_DOD,PATIENT_RELIGION,PATIENT_MARITAL,PATIENT_NATIONALITY,PATIENT_OCCUPATION,PATIENT_HOMEADDRESS,PATIENT_LASTVISIT,PATIENT_NUMVISITS,PATIENT_REVIEWDATE,PATIENT_SERVICES,PATIENT_GROUP,PATIENT_GROUPCODE,PATIENT_PAYMENTSCHEME,PATIENT_PAYMENTSCHEMECODE FROM octopus_patients WHERE PATIENT_INSTCODE = '$instcode' AND $searchparam like '%$searchitem%' ");																	
		return $list;
	}

	// 16 MAY 2025, JOSEPH ADORBOE
	public function updatepatientresetphysiotherpy($patientcode,$currentusercode,$currentuser,$instcode){		
		$one = '1';	
		$zero = '0';						
		$sql = "UPDATE octopus_patients SET PATIENT_PHYSIO = ? , PATIENT_ACTORCODE = ?, PATIENT_ACTOR = ? WHERE PATIENT_CODE = ? AND PATIENT_STATUS = ? AND PATIENT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $patientcode);
		$st->BindParam(5, $one);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();												
		if($exe){								
			return $this->thepassed;								
		}else{								
			return $this->thefailed;								
		}				
	}
	// 17 MAR 2021 JOSEPH ADORBOE 
	public function getphysiopatientdetails($patientcode){
		$sqlstmt = ("SELECT PATIENT_CODE,PATIENT_PATIENTNUMBER,PATIENT_DOB,PATIENT_NAMES,PATIENT_GENDER,PATIENT_RELIGION,PATIENT_MARITAL,PATIENT_OCCUPATION,PATIENT_NATIONALITY,PATIENT_HOMEADDRESS,PATIENT_PHONENUMBER,PATIENT_BLOODGROUP,PATIENT_LASTVISIT,PATIENT_NUMVISITS,PATIENT_REVIEWDATE,PATIENT_PHYSIO FROM octopus_patients where PATIENT_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PATIENT_CODE'].'@'.$object['PATIENT_PATIENTNUMBER'].'@'.$object['PATIENT_DOB'].'@'.$object['PATIENT_NAMES'].'@'.$object['PATIENT_GENDER'].'@'.$object['PATIENT_RELIGION'].'@'.$object['PATIENT_MARITAL'].'@'.$object['PATIENT_OCCUPATION'].'@'.$object['PATIENT_NATIONALITY'].'@'.$object['PATIENT_HOMEADDRESS'].'@'.$object['PATIENT_PHONENUMBER'].'@'.$object['PATIENT_BLOODGROUP'].'@'.$object['PATIENT_LASTVISIT'].'@'.$object['PATIENT_NUMVISITS'].'@'.$object['PATIENT_REVIEWDATE'].'@'.$object['PATIENT_PHYSIO'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return $this->thefailed;
		}			
	}	
	
	// 11 MAR 2025, JOSEPH ADORBOE
	public function requestserviceselectpatientssearch($instcode,$searchitem,$searchparam) : String {
		$list = ("SELECT PATIENT_CODE,PATIENT_PATIENTNUMBER,PATIENT_NAMES,PATIENT_GENDER,PATIENT_DOB,PATIENT_PHONENUMBER,PATIENT_PAYMENTMETHOD,PATIENT_STATUS,PATIENT_BILLCURRENCY,PATIENT_ALTPHONENUMBER,PATIENT_PHYSIO,PATIENT_DOD,PATIENT_RELIGION,PATIENT_MARITAL,PATIENT_NATIONALITY,PATIENT_OCCUPATION,PATIENT_HOMEADDRESS,PATIENT_LASTVISIT,PATIENT_NUMVISITS,PATIENT_REVIEWDATE,PATIENT_SERVICES FROM octopus_patients WHERE PATIENT_INSTCODE = '$instcode' AND $searchparam like '%$searchitem%' ");																	
		return $list;
	}
	// 11 MAR 2025, JOSEPH ADORBOE
	public function patientfolderpatientsearch($instcode,$searchitem,$searchparam) : String {
		$list = ("SELECT PATIENT_CODE,PATIENT_PATIENTNUMBER,PATIENT_NAMES,PATIENT_GENDER,PATIENT_DOB,PATIENT_PHONENUMBER,PATIENT_PAYMENTMETHOD,PATIENT_STATUS,PATIENT_BILLCURRENCY,PATIENT_ALTPHONENUMBER,PATIENT_PHYSIO,PATIENT_DOD,PATIENT_RELIGION,PATIENT_MARITAL,PATIENT_NATIONALITY,PATIENT_OCCUPATION,PATIENT_HOMEADDRESS,PATIENT_LASTVISIT,PATIENT_NUMVISITS,PATIENT_REVIEWDATE,PATIENT_SERVICES FROM octopus_patients WHERE PATIENT_INSTCODE = '$instcode' AND $searchparam like '%$searchitem%' ");																	
		return $list;
	}
	
	// 8 AUG 2023 
	public function selectpatientssearch($instcode,$searchitem){
		$list = ("SELECT PATIENT_CODE,PATIENT_PATIENTNUMBER,PATIENT_NAMES,PATIENT_GENDER,PATIENT_DOB,PATIENT_PHONENUMBER,PATIENT_PAYMENTMETHOD FROM octopus_patients WHERE PATIENT_INSTCODE = '$instcode' AND ( PATIENT_PATIENTNUMBER like '%$searchitem%' or PATIENT_FIRSTNAME like '%$searchitem%' or PATIENT_LASTNAME like '%$searchitem%' )");																	
		return $list;
	}
	// 1 JUNE 2024  JOSEPH ADORBOE
	public function updatepatientbio($patientcode,$patientfirstname,$patientlastname,$name,$patientgender,$patientbirthdate,$currentusercode,$currentuser,$instcode){		
		$one = 1;	
		$zero = '0';						
		$sql = "UPDATE octopus_patients SET PATIENT_NAMES = ?, PATIENT_FIRSTNAME = ?, PATIENT_LASTNAME = ?, PATIENT_DOB = ? , PATIENT_GENDER = ? , PATIENT_ACTORCODE = ?, PATIENT_ACTOR =? WHERE PATIENT_CODE = ? AND PATIENT_STATUS = ? AND PATIENT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $name);
		$st->BindParam(2, $patientfirstname);
		$st->BindParam(3, $patientlastname);
		$st->BindParam(4, $patientbirthdate);
		$st->BindParam(5, $patientgender);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $patientcode);
		$st->BindParam(9, $one);
		$st->BindParam(10, $instcode);
		$exe = $st->execute();												
		if($exe){								
			return $this->thepassed;								
		}else{								
			return $this->thefailed;								
		}				
	}
	// 23 SEPT 2023 JOSEPH ADORBOE
	public function getquerypatientdeathlist($instcode){		
		$list = ("SELECT * from octopus_patients where PATIENT_INSTCODE = '$instcode' and PATIENT_STATUS = '0'");
		return $list;
	}
	// 2 NOV 2023   JOSEPH ADORBOE 
	public function checkpatientalive($patientcode,$instcode){
        $zero = '0';
        $sqlstmt = ("SELECT PATIENT_DOD FROM octopus_patients WHERE PATIENT_CODE = ? AND PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $patientcode);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $zero);
    //    $st->BindParam(4, $one);
        $details =	$st->execute();
        if ($details) {
            if ($st->rowcount() > 0) {
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$data = $obj['PATIENT_DOD'];
					return $data;
                return $this->thepassed;
            } else {
                return $this->thefailed;
            }
        } else {
            return $this->thefailed;
        }
    }
	// 30 apr 2022  JOSEPH ADORBOE 
	public function checkpatientphysico($patientcode,$instcode){
        $one = 1;
        $sqlstmt = ("SELECT PATIENT_PHYSIO FROM octopus_patients WHERE PATIENT_CODE = ? AND PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $patientcode);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $one);
    //    $st->BindParam(4, $one);
        $details =	$st->execute();
        if ($details) {
            if ($st->rowcount() > 0) {
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$data = $obj['PATIENT_PHYSIO'];
					return $data;
                return $this->thepassed;
            } else {
                return $this->thefailed;
            }
        } else {
            return $this->thefailed;
        }
    }
	// 3 Oct 2023, 12 JULY 2021 JOSEPH ADORBOE 
	public function checkattachedpatientfolder($patientcode,$instcode){
		$sqlstmt = ("SELECT PATIENT_FOLDERATTACHED FROM octopus_patients where PATIENT_CODE = ? and PATIENT_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PATIENT_FOLDERATTACHED'];
				return $results;
			}else{
				return'-1';
			}

		}else{
			return '-1';
		}			
	}	
	// 4 SEPT 2023 25 JAN 2021
	public function update_patientfileed($ekey,$finame){		
		$rt = 1;
		$sql = "UPDATE octopus_patients SET PATIENT_FOLDERNAME = ?, PATIENT_FOLDERATTACHED = ? WHERE PATIENT_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $finame);
		$st->BindParam(2, $rt);
		$st->BindParam(3, $ekey);		
		$exe = $st->execute();		
		if($exe){			
			return $this->thepassed;			
		}else{			
			return $this->thefailed;			
		}
	}
	//  3 SEPT 2023, 17 jan 2021,  JOSEPH ADORBOE
    public function updatepatientnumberrecords($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode) {
		$but = 1;
		$sqlstmt = ("SELECT PATIENT_ID FROM octopus_patients where PATIENT_PATIENTNUMBER = ? and PATIENT_INSTCODE = ? and PATIENT_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $replacepatientnumber);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $but);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return $this->theexisted;				
			}else{	
				$sqlstmt = "UPDATE octopus_patients SET PATIENT_PATIENTNUMBER = ? ,PATIENT_ACTOR = ? , PATIENT_ACTORCODE = ? where PATIENT_CODE = ? and PATIENT_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $replacepatientnumber);
				$st->BindParam(2, $currentuser);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $ekey);
				$st->BindParam(5, $instcode);
				$exe = $st->execute();
				if($exe){				
					return $this->thepassed;
				}else{				
					return $this->thefailed;				
				}	
			}
		}
	}
	//  3 SEPT 2023, 17 jan 2021,  JOSEPH ADORBOE
    public function updatepatientrecords($ekey,$patientfirstname,$patientlastname,$fullname,$patientaltphone,$patientnationality,$patientreligion,$patientmaritalstatus,$patienthomeaddress,$patientbirthdate,$patientoccupation,$patientgender,$patientphone,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "UPDATE octopus_patients SET PATIENT_FIRSTNAME = ? ,PATIENT_LASTNAME = ? , PATIENT_NAMES = ? , PATIENT_GENDER = ? , PATIENT_RELIGION = ?  , PATIENT_MARITAL =  ? , PATIENT_OCCUPATION = ? , PATIENT_NATIONALITY = ?, PATIENT_HOMEADDRESS = ?, PATIENT_PHONENUMBER = ? , PATIENT_ALTPHONENUMBER = ? , PATIENT_DOB= ?  , PATIENT_ACTOR = ? , PATIENT_ACTORCODE = ?   where PATIENT_CODE = ? and PATIENT_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientfirstname);
		$st->BindParam(2, $patientlastname);
		$st->BindParam(3, $fullname);
		$st->BindParam(4, $patientgender);
		$st->BindParam(5, $patientreligion);
		$st->BindParam(6, $patientmaritalstatus);
		$st->BindParam(7, $patientoccupation);
		$st->BindParam(8, $patientnationality);
		$st->BindParam(9, $patienthomeaddress);
		$st->BindParam(10, $patientphone);
		$st->BindParam(11, $patientaltphone);
		$st->BindParam(12, $patientbirthdate);
		$st->BindParam(13, $currentuser);
		$st->BindParam(14, $currentusercode);
		$st->BindParam(15, $ekey);
		$st->BindParam(16, $instcode);
		$exe = $st->execute();				
		if($exe){				
			return $this->thepassed;
		}else{				
			return $this->thefailed;				
		}		
	}	
	// 9 AUG 2023, 30 APR 2022  JOSEPH ADORBOE 
	public function chechphysiostate($servicescode,$patientcode,$physiofirstvisit,$physiofollowup,$instcode){
        $one = 1;
        if ($servicescode == $physiofirstvisit || $servicescode == $physiofollowup) {
            $sqlstmt = "SELECT PATIENT_ID FROM octopus_patients WHERE PATIENT_CODE = ? AND PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_PHYSIO = ? ";
            $st = $this->db->prepare($sqlstmt);
            $st->BindParam(1, $patientcode);
            $st->BindParam(2, $instcode);
            $st->BindParam(3, $one);
            $st->BindParam(4, $one);
            $ert = $st->execute();
            if ($ert) {
                if ($st->rowcount()>0) {
					return $this->theexisted;
                } else {
					return $this->thepassed;
                }
            } else {
                return $this->theexisted;
            }
        }
    }	
	// 09 AUG 2023  09 JULY 2021   JOSEPH ADORBOE
	public function updatepatientreviewperformedservices($day,$patientcode,$instcode){		
		$one = 1;							
		$sql = "UPDATE octopus_patients SET PATIENT_REVIEWDATE = ? WHERE PATIENT_CODE = ? AND PATIENT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $day);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$exe = $st->execute();												
		if($exe){								
			return $this->thepassed;								
		}else{								
			return $this->thefailed;								
		}				
	}
	// 03 AUG 2023  09 JULY 2021   JOSEPH ADORBOE
	public function updatepatientvisitservices($days,$patientcode,$instcode){		
		$one = 1;							
		$sql = "UPDATE octopus_patients SET PATIENT_LASTVISIT = ?, PATIENT_NUMVISITS =  PATIENT_NUMVISITS + ?  WHERE PATIENT_CODE = ? AND PATIENT_STATUS = ? AND PATIENT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $one);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();												
		if($exe){								
			return $this->thepassed;								
		}else{								
			return $this->thefailed;								
		}	
	}
	// 09 AUG 2023  09 JULY 2021   JOSEPH ADORBOE updatepatientsetphysio($patientcode,$servicerequestcode,$state,$instcode,$servicerequestsql)
	public function updatepatientsetphysio($patientcode,$state,$instcode){				
		$one = 1;							
		$sql = "UPDATE octopus_patients SET PATIENT_PHYSIO = ? WHERE PATIENT_CODE = ? AND PATIENT_PHYSIO = ? AND PATIENT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $state);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $one);
		$st->BindParam(4, $instcode);	
		$exe = $st->execute();												
		if($exe){	
			return $this->thepassed;								
		}else{								
			return $this->thefailed;								
		}
	}
	// 23 JUNE 2021 JOSEPH ADORBOE
	public function getpatientdetailstwo($patientcodecode,$instcode){	
		$nut = 1;	
		$sql = 'SELECT PATIENT_DOB,PATIENT_PATIENTNUMBER,PATIENT_NAMES,PATIENT_GENDER,PATIENT_DOB,PATIENT_PHONENUMBER,PATIENT_ALTPHONENUMBER,PATIENT_HOMEADDRESS FROM octopus_patients WHERE PATIENT_CODE = ? and PATIENT_INSTCODE = ? and PATIENT_STATUS = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcodecode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$ext = $st->execute();
		if($ext){		
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$day = date('Y-m-d');		
				$age = 0;
				$yearOnly1 = date('Y', strtotime($obj['PATIENT_DOB']));
				$yearOnly2 = date('Y', strtotime($day));		
				$monthOnly1 = date('m', strtotime($obj['PATIENT_DOB']));
				$monthOnly2 = date('m', strtotime($day));
				$dayOnly1 = date('d', strtotime($obj['PATIENT_DOB']));
				$dayOnly2 = date('d', strtotime($day));
				$yearOnly = $yearOnly2 - $yearOnly1;
				$monthOnly = $monthOnly2 - $monthOnly1;
				$dayOnly = $dayOnly2 - $dayOnly1;
				if($yearOnly>'0'){
					if($monthOnly<1){
						$m = 1;
						$age = $yearOnly - 1;
					}elseif($monthOnly>'0'){
						$age = $yearOnly ;
					}else if($monthOnly=='0'){
						$age = $yearOnly ;
					}
				}else{
					$age = 0;
				}
				//						0								1						2										
				$currentdetails = $obj['PATIENT_PATIENTNUMBER'].'@'.$obj['PATIENT_NAMES'].'@'.$obj['PATIENT_GENDER'].'@'.$obj['PATIENT_DOB'].'@'.$age.'@'.$obj['PATIENT_PHONENUMBER'].'@'.$obj['PATIENT_ALTPHONENUMBER'].'@'.$obj['PATIENT_HOMEADDRESS'];				
				return $currentdetails;					
			}else{
				return $this->thefailed;
			}
		}else{
			return $this->thefailed;
		}	
	}
	// 8 AUG 2023 , 06 NOV 2022 JOSEPH ADORBOE
	public function updatepatientbillingcurrency(String $patientcode, String $billingcurrency, String $instcode): int{
		$sqlstmt = 'UPDATE octopus_patients set PATIENT_BILLCURRENCY = ? where PATIENT_CODE = ? and PATIENT_INSTCODE = ? ';
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $billingcurrency);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$ert = $st->execute();
			if($ert){
				return $this->thepassed;
			}else{
				return $this->thefailed;
			}
	}
	// 8 AUG 2023, 17 JULY 2021 JOSEPH ADORBOE
	public function updatepatientbirtdate($patientcode,$patientbirthdate,$instcode){
		$sqlstmt = 'UPDATE octopus_patients set PATIENT_DOB = ? where PATIENT_CODE = ? and PATIENT_INSTCODE = ? ';
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientbirthdate);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$ert = $st->execute();
		if($ert){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}
	}
	// 23 JUNE 2021 JOSEPH ADORBOE
	public function getpatientalivedetails($patientnumber,$instcode) : mixed{	
		$nut = 1;	
		$sql = 'SELECT PATIENT_STATUS,PATIENT_CODE,PATIENT_NAMES,PATIENT_GENDER,PATIENT_DOB FROM octopus_patients WHERE PATIENT_PATIENTNUMBER = ? and PATIENT_INSTCODE = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientnumber);
		$st->BindParam(2, $instcode);
		$ext = $st->execute();
		if($ext){		
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				if($obj['PATIENT_STATUS'] == 1){
					// 								0								1										
					$currentdetails = $obj['PATIENT_CODE'].'@'.$obj['PATIENT_NAMES'].'@'.$obj['PATIENT_GENDER'].'@'.$obj['PATIENT_DOB'];				
					return $currentdetails;	
				}else{
					return -1;
				}
								
			}else{
				return $this->thefailed;
			}
		}else{
			return $this->thefailed;
		}	
	}
	// 03 AUG 2023  09 JULY 2021   JOSEPH ADORBOE
	public function updatepatientdeath($patientcode,$dod,$instcode) : Int {		
		$one = 1;	
		$zero = '0';						
		$sql = "UPDATE octopus_patients SET PATIENT_DOD = ?, PATIENT_STATUS = ?  WHERE PATIENT_CODE = ? AND PATIENT_STATUS = ? AND PATIENT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $dod);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();												
		if($exe){								
			return $this->thepassed;								
		}else{								
			return $this->thefailed;								
		}				
	}
	
	// 03 AUG 2023  09 JULY 2021   JOSEPH ADORBOE
	public function updatepatientreviewservices($reviewdate,$servicename,$patientcode,$instcode) : Int {		
		$one = 1;							
		$sql = "UPDATE octopus_patients SET PATIENT_REVIEWDATE = ?, PATIENT_SERVICES = ?  WHERE PATIENT_CODE = ? AND PATIENT_STATUS = ? AND PATIENT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $reviewdate);
		$st->BindParam(2, $servicename);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();												
		if($exe){								
			return $this->thepassed;								
		}else{								
			return $this->thefailed;								
		}				
	}
	// 17 MAR 2021 JOSEPH ADORBOE 
	public function getpatientdetails($patientcode) : String{
		$sqlstmt = ("SELECT PATIENT_CODE,PATIENT_PATIENTNUMBER,PATIENT_DOB,PATIENT_NAMES,PATIENT_GENDER,PATIENT_RELIGION,PATIENT_MARITAL,PATIENT_OCCUPATION,PATIENT_NATIONALITY,PATIENT_HOMEADDRESS,PATIENT_PHONENUMBER,PATIENT_BLOODGROUP,PATIENT_LASTVISIT,PATIENT_NUMVISITS,PATIENT_REVIEWDATE,PATIENT_PHYSIO,PATIENT_FIRSTNAME,PATIENT_LASTNAME,PATIENT_SERVICES FROM octopus_patients where PATIENT_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PATIENT_CODE'].'@'.$object['PATIENT_PATIENTNUMBER'].'@'.$object['PATIENT_DOB'].'@'.$object['PATIENT_NAMES'].'@'.$object['PATIENT_GENDER'].'@'.$object['PATIENT_RELIGION'].'@'.$object['PATIENT_MARITAL'].'@'.$object['PATIENT_OCCUPATION'].'@'.$object['PATIENT_NATIONALITY'].'@'.$object['PATIENT_HOMEADDRESS'].'@'.$object['PATIENT_PHONENUMBER'].'@'.$object['PATIENT_BLOODGROUP'].'@'.$object['PATIENT_LASTVISIT'].'@'.$object['PATIENT_NUMVISITS'].'@'.$object['PATIENT_REVIEWDATE'].'@'.$object['PATIENT_PHYSIO'].'@'.$object['PATIENT_FIRSTNAME'].'@'.$object['PATIENT_LASTNAME'].'@'.$object['PATIENT_SERVICES'];
				return $results;
			}else{
				return $this->theexisted;
			}
		}else{
			return $this->thefailed;
		}			
	}
	
	
} 
	$patienttable = new OctopusPatientsSql();
?>