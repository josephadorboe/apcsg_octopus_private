<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_servicesrequestqueryphysiopatientqueue
	$patientsServiceRequesttable->physiopatientaddtomybasket($ekey,$currentuser,$currentusercode,$instcode);
*/

class OctopusPatientsServiceRequestSql Extends Engine{
	// 15 SEPT 2023 
	public function getrecordscounts($instcode,$currentshiftcode)
	{
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_SHIFTCODE = '$currentshiftcode' AND REQU_STATUS = '8' AND REQU_STATE = '7'"; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$sendbackservicecount  = $st->rowCount();
		
		// $sql = "SELECT DISTINCT B_VISITCODE,B_DT FROM octopus_patients_billitems WHERE B_INSTCODE = '$instcode' AND B_DT = '$day' AND B_STATUS = 1 and B_METHODCODE IN('$cashpaymentmethodcode','$mobilemoneypaymentmethodcode','$chequescode','$creditcode','$prepaidcode')"; 
        // $st = $this->db->prepare($sql);   
        // $st->execute();   
		// $noninsurancecount  = $st->rowCount();	
		// 	
		$noninsurancecount = 1;
		return $sendbackservicecount.'@'.$noninsurancecount;      
	}
	// 18 MAY 2025
	public function querysearchmyphysiocompletedservicebasket($instcode,$currentusercode,$physioservices,$searchparam,$searchitem) : String{
		$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENTCODE,REQU_PATIENT,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->thetwo' AND REQU_STAGE = '$this->thesix' AND REQU_DOCTORCODE = '$currentusercode' AND REQU_STATUS = '$this->thetwo' AND $searchparam LIKE '%$searchitem%' ORDER BY REQU_ID DESC LIMIT 200");
		return $list;								
	}
	// 18 MAY 2025
	public function querysearchmydatephysiocompletedservicebasket($instcode,$currentusercode,$physioservices,$fromdate,$todate ) : String{
		$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENTCODE,REQU_PATIENT,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->thetwo' AND REQU_STAGE = '$this->thesix' AND REQU_DOCTORCODE = '$currentusercode' AND REQU_STATUS = '$this->thetwo' AND DATE(REQU_DATE) BETWEEN '$fromdate' AND '$todate' ORDER BY REQU_ID DESC LIMIT 200");
			return $list;								
	}
	// 18 MAY 2025
	public function querysearchmyphysioservicebasket($instcode,$currentusercode,$physioservices,$searchparam,$searchitem) : String{
		$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENTCODE,REQU_PATIENT,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->theone' AND REQU_STAGE = '$this->thefive' AND REQU_STATUS = '$this->thetwo' AND REQU_DOCTORCODE = '$currentusercode' AND $searchparam LIKE '%$searchitem%'  ORDER BY REQU_ID DESC ");
			return $list;								
	}
	// 18 MAY 2025
	public function querysearchdatemyphysioservicebasket($instcode,$currentusercode,$physioservices,$fromdate,$todate) : String{
		$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENTCODE,REQU_PATIENT,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->theone' AND REQU_STAGE = '$this->thefive' AND REQU_STATUS = '$this->thetwo' AND REQU_DOCTORCODE = '$currentusercode' AND DATE(REQU_DATE) BETWEEN '$fromdate' AND '$todate' ORDER BY REQU_ID DESC ");
			return $list;								
	}
	// 18 MAY 2025
	public function querysearchdatephysiopatientqueueachive(String $instcode,String $physioservices, String $searchparam,$fromdate,$todate) : String{		
			$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENT,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->theone' AND REQU_STAGE ='$this->theseven' AND REQU_STATUS = '$this->thetwo' AND DATE(REQU_DATE) BETWEEN '$fromdate' AND '$todate'  ORDER BY REQU_ID DESC ");
		
			return $list;								
	}
	// 18 MAY 2025
	public function querysearchphysiopatientqueuearchive(String $instcode,String $physioservices, String $searchitem, String $searchparam) : String{
		$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENT,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->theone' AND REQU_STAGE ='$this->theseven' AND REQU_STATUS = '$this->thetwo' AND $searchparam LIKE '%$searchitem%' ORDER BY REQU_ID DESC ");	
		return $list;								
	}
	// 18 MAY 2025, JOSEPH ADORBOE 
	public function queryphysiopatientqueuearchive(String $instcode,String $physioservices) : String{
		$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENT,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->theone' AND REQU_STAGE ='$this->theseven' AND REQU_STATUS = '$this->thetwo' ORDER BY REQU_ID DESC ");
			return $list;								
	}

	// 18 MAy 2025, JOSEPH ADORBOE
	public function physiobackpatientqueue(String $ekey, String $currentuser , String $currentusercode, String $instcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_SERVICEDATE = ?, REQU_STAGE = ?, REQU_DOCTOR = ?, REQU_DOCTORCODE = ?  WHERE REQU_CODE = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thedays);
		$st->BindParam(2, $this->thethree);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();	
		if($exe){			
			return $this->thepassed;;			
		}else{			
			return $this->thefailed;			
		}
	}

	// 18 MAy 2025, JOSEPH ADORBOE
	public function physiopatientaddarchive(String $ekey, String $currentuser , String $currentusercode, String $instcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_SERVICEDATE = ?, REQU_STAGE = ?, REQU_DOCTOR = ?, REQU_DOCTORCODE = ?  WHERE REQU_CODE = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thedays);
		$st->BindParam(2, $this->theseven);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();	
		if($exe){			
			return $this->thepassed;;			
		}else{			
			return $this->thefailed;			
		}
	}	

	// 13 MAY 2025
	public function querymyphysiocompletedservicebasket($instcode,$currentusercode,$physioservices) : String{
		$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENTCODE,REQU_PATIENT,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->thetwo' AND REQU_STAGE = '$this->thesix' AND REQU_DOCTORCODE = '$currentusercode' AND REQU_STATUS = '$this->thetwo' ORDER BY REQU_ID DESC LIMIT 200");
			return $list;								
	}
	// 8 MAY 2025, JOSEPH ADORBOE
	public function physiopatientendconsultation(String $ekey, String $instcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STATE = ?, REQU_STAGE = ?, REQU_COMPLETE = ? WHERE REQU_CODE = ? AND REQU_INSTCODE = ? AND REQU_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->theten);
		$st->BindParam(2, $this->thesix);
		$st->BindParam(3, $this->thetwo);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$st->BindParam(6, $this->thetwo);
		$exe = $st->execute();	
		if($exe){			
			return $this->thepassed;;			
		}else{			
			return $this->thefailed;			
		}
	}	

	// 27 APR 2025
	public function querymyphysioservicebasket($instcode,$currentusercode,$physioservices) : String{
		$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENTCODE,REQU_PATIENT,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->theone' AND REQU_STAGE = '$this->thefive' AND REQU_STATUS = '$this->thetwo' AND REQU_DOCTORCODE = '$currentusercode' ORDER BY REQU_ID DESC ");
			return $list;								
	}
	/// 27 APR 2025 / 02 MAY 2022 
	public function getphysiocounts($physioservices,$usercode,$instcode) : String
	{
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_SHOW = '$this->theseven'  AND REQU_COMPLETE = '$this->theone' AND REQU_SERVICECODE IN('$physioservices') AND REQU_STAGE  IN('$this->theone','$this->thetwo','$this->thethree')  AND REQU_STATUS = '$this->thetwo' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$patientqueuecount = $st->rowCount();	

		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_SHOW = '$this->theseven'  AND REQU_COMPLETE = '$this->theone' AND REQU_SERVICECODE IN('$physioservices') AND REQU_STAGE = '$this->thefive' AND REQU_STATUS = '$this->thetwo' AND REQU_DOCTORCODE = '$usercode'  "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$mypatientqueuecount = $st->rowCount();	

		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_SHOW = '$this->theseven'  AND REQU_COMPLETE = '$this->thetwo' AND REQU_SERVICECODE IN('$physioservices') AND REQU_STAGE = '$this->thesix' AND REQU_STATUS = '$this->thetwo' AND REQU_DOCTORCODE = '$usercode'  "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$mycompletedpatientqueuecount = $st->rowCount();	

		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_SHOW = '$this->theseven'  AND REQU_COMPLETE = '$this->theone' AND REQU_SERVICECODE IN('$physioservices') AND REQU_STAGE = '$this->theseven' AND REQU_STATUS = '$this->thetwo'  "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$archivequeuecount = $st->rowCount();		

		return $patientqueuecount.'@@'.$mypatientqueuecount.'@@'.$archivequeuecount.'@@'.$mycompletedpatientqueuecount; 	
	}
	// 27 APR 2025
	public function queryphysiopatientqueuedashboard(String $instcode,String $physioservices) : String{
		$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENT,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->theone' AND REQU_STAGE  IN('$this->theone','$this->thetwo','$this->thethree') AND REQU_STATUS = '$this->thetwo' ORDER BY REQU_ID DESC  LIMIT 100");
			return $list;								
	}
	// 18 MAY 2025
	public function querysearchdatephysiopatientqueue(String $instcode,String $physioservices, String $searchparam,$fromdate,$todate) : String{
		
			$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENT,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->theone' AND REQU_STAGE IN('$this->theone','$this->thetwo','$this->thethree') AND REQU_STATUS = '$this->thetwo' AND DATE(REQU_DATE) BETWEEN '$fromdate' AND '$todate'  ORDER BY REQU_ID DESC ");
		
			return $list;								
	}
	// 18 MAY 2025
	public function querysearchphysiopatientqueue(String $instcode,String $physioservices, String $searchitem, String $searchparam) : String{
		$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENT,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->theone' AND REQU_STAGE IN('$this->theone','$this->thetwo','$this->thethree') AND REQU_STATUS = '$this->thetwo' AND $searchparam LIKE '%$searchitem%' ORDER BY REQU_ID DESC ");	
		return $list;								
	}
	// 27 APR 2025
	public function queryphysiopatientqueue(String $instcode,String $physioservices) : String{
		$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENT,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE,REQU_SERVICECODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_COMPLETE = '$this->theone' AND REQU_STAGE IN('$this->theone','$this->thetwo','$this->thethree') AND REQU_STATUS = '$this->thetwo' ORDER BY REQU_ID DESC ");
			return $list;								
	}
	// 9 AUG 2023, 03 MAY 2022 
	public function physiopatientaddtomybasket(String $ekey, String $currentuser , String $currentusercode, String $instcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_SERVICEDATE = ?, REQU_STAGE = ?, REQU_DOCTOR = ?, REQU_DOCTORCODE = ?  WHERE REQU_CODE = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thedays);
		$st->BindParam(2, $this->thefive);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();	
		if($exe){			
			return $this->thepassed;;			
		}else{			
			return $this->thefailed;			
		}
	}	

	// 01 MAY 2022  JOSEPH ADORBOE 
	public function getpatientphysioservicedetails($idvalue,$instcode) : mixed{
		$sqlstmt = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_DATE FROM octopus_patients_servicesrequest WHERE REQU_CODE = ? AND REQU_INSTCODE = ? AND REQU_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $this->thetwo);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['REQU_CODE'].'@'.$object['REQU_VISITCODE'].'@'.$object['REQU_DATE'].'@'.$object['REQU_PATIENTCODE'].'@'.$object['REQU_PATIENTNUMBER'].'@'.$object['REQU_PATIENT'].'@'.$object['REQU_AGE'].'@'.$object['REQU_GENDER'].'@'.$object['REQU_PAYMENTMETHOD'].'@'.$object['REQU_PAYMENTMETHODCODE'].'@'.$object['REQU_PAYSCHEMECODE'].'@'.$object['REQU_PAYSCHEME'].'@'.$object['REQU_SERVICECODE'].'@'.$object['REQU_SERVICE'].'@'.$object['REQU_PAYMENTTYPE'].'@'.$object['REQU_DATE'];
				return $results;
			}else{
				return $this->theexisted;
			}

		}else{
			return $this->thefailed;
		}
			
	}
	// 9 AUG 2023, 03 MAY 2022 
	public function setpatientphysioservice($state,$servicerequestcode,$instcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STAGE = ? WHERE REQU_CODE = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $state);
		$st->BindParam(2, $servicerequestcode);
		$st->BindParam(3, $instcode);		
		$exe = $st->execute();	
		if($exe){			
			return $this->thepassed;;			
		}else{			
			return $this->thefailed;		
		}
	}	
	// 6 APR 20-25
	public function queryphysioservicebasket($instcode,$physioservices) : String{
		$list = ("SELECT REQU_VISITCODE,REQU_DATE,REQU_CODE,REQU_PATIENT,REQU_PATIENTNUMBER,REQU_GENDER,REQU_AGE,REQU_SERVICE,REQU_PAYSCHEME,REQU_PAYMENTTYPE from octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physioservices') AND REQU_STAGE IN('$this->theone','$this->thetwo','$this->thethree') AND REQU_COMPLETE = '$this->theone' AND REQU_STATUS = '$this->thetwo' ORDER BY REQU_ID DESC ");
			return $list;								
	}

	// 8 JUNE 2024 JOSEPH ADORBOE
	public function getquerypatientqueueservicerequestdashboard($patientqueueexcept,$day,$instcode) : String {		
		$list = ("SELECT * from octopus_patients_servicesrequest  where REQU_SHOW = '$this->theseven' and REQU_VITALSTATUS = '$this->thezero' AND REQU_INSTCODE = '$instcode' AND REQU_RETURN ='$this->thezero' AND DATE(REQU_DATE) = '$day' AND REQU_STATUS = '$this->thetwo' AND REQU_SERVICECODE NOT IN ('$patientqueueexcept') order by REQU_VISITTYPE  LIMIT  3 ");
		return $list;
	}
	// 8 JUNE 2024, JOSEPH ADORBOE
	public function getquerypatientservicerequestvitalsdashboard($patientqueueexcept,$day,$instcode) : String {		
		$list = ("SELECT * FROM octopus_patients_servicesrequest  WHERE REQU_SHOW = '$this->theseven' AND  DATE(REQU_DATE) = '$day' AND REQU_VITALSTATUS = '$this->theone' AND REQU_STAGE = '$this->thetwo' AND REQU_RETURN ='$this->thezero' AND REQU_STATUS = '$this->thetwo' AND REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE NOT IN ('$patientqueueexcept')   LIMIT 3 ");
		return $list;
	}
	// 8 JUNE 2024, JOSEPH ADORBOE
	public function getquerypatientpastedservicerequestdashboard($patientqueueexcept,$day,$instcode) : String {		
		$list = ("SELECT * from octopus_patients_servicesrequest  where REQU_SHOW = '$this->theseven' and REQU_VITALSTATUS = '$this->thezero' AND REQU_INSTCODE = '$instcode' AND REQU_RETURN ='$this->thezero' AND DATE(REQU_DATE) < '$day' AND REQU_SERVICECODE NOT IN ('$patientqueueexcept') AND REQU_STATUS = '$this->thetwo'  LIMIT 3 ");
		return $list;
	}	

	// 1 JUNE 2024 JOSEPH ADORBOE
	public function update_servicerequestbio($ekey,$name,$age,$gender,$instcode) : Int {
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_PATIENT = ?, REQU_AGE = ?, REQU_GENDER = ?  WHERE REQU_CODE = ? and REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $name);
		$st->BindParam(2, $age);
		$st->BindParam(3, $gender);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return $this->thepassed;;								
		}else{								
			return $this->thefailed;								
		}	
	}

	// 25 MAY 2024 JOSEPH ADORBOE
	public function update_nurseingservicereports($ekey,$servicereport,$instcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STATE = ?, REQU_REMARKS = ?  WHERE REQU_CODE = ? and REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->theten);
		$st->BindParam(2, $servicereport);
		$st->BindParam(3, $ekey);
		$st->BindParam(4, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return $this->thepassed;;								
		}else{								
			return $this->thefailed;								
		}	
	}

	// 27 MAY 2024  JOSEPH ADORBOE
	public function getquerynurseingservices($nursingservices,$instcode) : String{		
		$list = ("SELECT * FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND !(REQU_STATUS = '$this->thezero') AND REQU_STATE ='$this->theone' AND REQU_SERVICECODE IN('$nursingservices') AND REQU_STATUS = '$this->thetwo' order by REQU_ID DESC  ");
		return $list;
	}

	// 25 MAY 2024 JOSEPH ADORBOE
	public function reversercancelconsultationservicerequest($visitcode,$instcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ?  WHERE REQU_VISITCODE = ? and REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thezero);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return $this->thepassed;;								
		}else{								
			return $this->thefailed;								
		}	
	}
	// 25 MAY 2024 JOSEPH ADORBOE
	public function returnservicerequestreversal($ekey,$reversalreason,$currentusercode,$currentuser,$instcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_RETURN = ?, REQU_RETURNTIME = ? , REQU_RETURNACTOR = ?, REQU_RETURNACTORCODE = ? , REQU_RETURNREASON = ? , REQU_DATE = ? , REQU_STAGE = ? , REQU_VITALSTATUS = ?  WHERE REQU_CODE = ? and  REQU_RETURN = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thezero);
		$st->BindParam(2, $this->thedays);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $reversalreason);
		$st->BindParam(6, $this->thedays);
		$st->BindParam(7, $this->theone);
		$st->BindParam(8, $this->thezero);
		$st->BindParam(9, $ekey);
		$st->BindParam(10, $this->theone);
		$st->BindParam(11, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return $this->thepassed;;	
			}else{
				return $this->thefailed ;	
			}	
	}
	// 25 MAY 2024  JOSEPH ADORBOE
	public function getquerypatientcancelledconsultation( String $instcode) : String{		
		$list = ("SELECT * from octopus_patients_servicesrequest  where  REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_RETURN ='$this->thezero' AND !(DATE(REQU_DATE) > '$this->theday') AND REQU_STATUS = '$this->thetwo' order by REQU_VISITTYPE ASC limit 50");
		return $list;
	}	
	// 25 MAY 2024  JOSEPH ADORBOE
	public function getquerypatientcancelledservices( String $instcode) : String{		
		$list = ("SELECT * from octopus_patients_servicesrequest  where REQU_SHOW = '$this->theseven' AND REQU_INSTCODE = '$instcode' AND REQU_RETURN ='$this->theone' AND !(DATE(REQU_DATE) > '$this->theday') AND REQU_STATUS = '$this->thetwo' order by REQU_VISITTYPE ASC limit 50");
		return $list;
	}
	// 15 MAY 2024, JOSEPH ADORBOE 
	public function getpatientservicerequestdetails( String $requestcode) : String {
		$sqlstmt = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_SERIAL,REQU_DOCTOR,REQU_DOCTORCODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_BILLCODE,REQU_PLAN,REQU_VITALSTATUS FROM octopus_patients_servicesrequest WHERE REQU_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $requestcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['REQU_CODE'].'@'.
				$object['REQU_VISITCODE'].'@'.
				$object['REQU_DATE'].'@'.
				$object['REQU_PATIENTCODE'].'@'.
				$object['REQU_PATIENTNUMBER'].'@'.
				$object['REQU_PATIENT'].'@'.
				$object['REQU_AGE'].'@'.
				$object['REQU_GENDER'].'@'.
				$object['REQU_SERIAL'].'@'.
				$object['REQU_DOCTOR'].'@'.
				$object['REQU_DOCTORCODE'].'@'.
				$object['REQU_PAYMENTMETHOD'].'@'.
				$object['REQU_PAYMENTMETHODCODE'].'@'.
				$object['REQU_PAYSCHEMECODE'].'@'.
				$object['REQU_PAYSCHEME'].'@'.
				$object['REQU_SERVICECODE'].'@'.
				$object['REQU_SERVICE'].'@'.
				$object['REQU_PAYMENTTYPE'].'@'.
				$object['REQU_BILLCODE'].'@'.
				$object['REQU_PLAN'].'@'.
				$object['REQU_VITALSTATUS'];
				return $results;
			}else{
				return $this->theexisted;
			}
		}else{
			return $this->thefailed;
		}			
	}	
	// 29 MAY 2024 JOSEPH ADORBOE
	public function getquerypatientqueueservicerequest($patientqueueexcept,String $instcode) : String {		
		$list = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_SERIAL,REQU_DOCTOR,REQU_DOCTORCODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_BILLCODE,REQU_PLAN,REQU_VITALSTATUS from octopus_patients_servicesrequest  where REQU_SHOW = '$this->theseven' and REQU_VITALSTATUS = '$this->thezero' AND REQU_INSTCODE = '$instcode' AND REQU_RETURN ='$this->thezero' AND DATE(REQU_DATE) = '$this->theday' AND REQU_STATUS = '$this->thetwo' AND REQU_SERVICECODE NOT IN ('$patientqueueexcept') order by REQU_VISITTYPE ASC");
		return $list;
	}
	// 30 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicenbasketpatientqueue(String $instcode,$consultationserviceslist) : String {		
		$list = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_SERIAL,REQU_DOCTOR,REQU_DOCTORCODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_BILLCODE,REQU_PLAN,REQU_VITALSTATUS from octopus_patients_servicesrequest  where REQU_SHOW = '$this->theseven' and REQU_VITALSTATUS = '$this->thezero' and REQU_SERVICECODE IN('$consultationserviceslist') AND REQU_INSTCODE = '$instcode' AND REQU_STATUS = '$this->thetwo' order by REQU_VISITTYPE ASC ");
		return $list;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicenbasketarchive(String $instcode) : String{		
		$list = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_SERIAL,REQU_DOCTOR,REQU_DOCTORCODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_BILLCODE,REQU_PLAN,REQU_VITALSTATUS from octopus_patients_servicesrequest  where REQU_SHOW = '$this->theseven' and REQU_VITALSTATUS = '$this->theone' and REQU_STAGE = '$this->thethree'  AND REQU_INSTCODE = '$instcode' AND REQU_RETURN ='$this->thezero' AND REQU_STATUS = '$this->thetwo' order by REQU_DATE DESC limit 500 ");
		return $list;
	}									
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicenbasketwounddressing(String $patientcode,String $visitcode,$wounddressingsservices,String $instcode) : String{		
		$list = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_SERIAL,REQU_DOCTOR,REQU_DOCTORCODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_BILLCODE,REQU_PLAN,REQU_VITALSTATUS from octopus_patients_servicesrequest where REQU_PATIENTCODE = '$patientcode' and REQU_VISITCODE = '$visitcode' and REQU_INSTCODE = '$instcode' and REQU_STATUS = '$this->theone' AND REQU_SERVICECODE IN('$wounddressingsservices') order by REQU_ID DESC  ");
		return $list;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicenbasket(String $instcode) : String{		
		$list = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_SERIAL,REQU_DOCTOR,REQU_DOCTORCODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_BILLCODE,REQU_PLAN,REQU_VITALSTATUS from octopus_patients_servicesrequest  where REQU_SHOW = '$this->theseven' and REQU_VITALSTATUS IN('$this->theone','$this->thezero') and REQU_STAGE IN('$this->thetwo','$this->thethree') and DATE(REQU_DATE) = '$this->theday'  AND REQU_INSTCODE = '$instcode' AND REQU_RETURN ='$this->thezero' AND REQU_STATUS = '$this->thetwo' order by REQU_VISITTYPE ASC ");
		return $list;
	}
	// 18 SEPT 2023 JOSEPH ADORBOE
	public function getquerypatientservicerequestvitals($patientqueueexcept,String $instcode) : String {		
		$list = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_SERIAL,REQU_DOCTOR,REQU_DOCTORCODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_BILLCODE,REQU_PLAN,REQU_VITALSTATUS from octopus_patients_servicesrequest  where REQU_SHOW = '$this->theseven' and DATE(REQU_DATE) = '$this->theday' and REQU_VITALSTATUS = '$this->theone' and REQU_STAGE = '$this->thetwo' AND REQU_INSTCODE = '$instcode' AND REQU_RETURN ='$this->thezero' AND REQU_SERVICECODE NOT IN ('$patientqueueexcept') AND REQU_STATUS = '$this->thetwo' ");
		return $list;
	}
	// 18 SEPT 2023 JOSEPH ADORBOE
	public function getquerypatientservicerequest(String $newfolder,String $restingbloodsugar,String $instcode) : String{		
		$list = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_SERIAL,REQU_DOCTOR,REQU_DOCTORCODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_BILLCODE,REQU_PLAN,REQU_VITALSTATUS from octopus_patients_servicesrequest  where REQU_SHOW = '$this->theseven' and REQU_VITALSTATUS = '$this->thezero' AND REQU_INSTCODE = '$instcode' AND REQU_RETURN ='$this->thezero' AND DATE(REQU_DATE) = '$this->theday' AND REQU_SERVICECODE NOT IN ('$newfolder','$restingbloodsugar') order by REQU_VISITTYPE ASC");
		return $list;
	}
	// 20 SEPT 2023 JOSEPH ADORBOE
	public function getquerypatientpastedservicerequest($patientqueueexcept, String $instcode) : String{		
		$list = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_SERIAL,REQU_DOCTOR,REQU_DOCTORCODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_BILLCODE,REQU_PLAN,REQU_VITALSTATUS from octopus_patients_servicesrequest  where REQU_SHOW = '$this->theseven' and REQU_VITALSTATUS = '$this->thezero' AND REQU_INSTCODE = '$instcode' AND REQU_RETURN ='$this->thezero' AND DATE(REQU_DATE) < '$this->theday' AND REQU_SERVICECODE NOT IN ('$patientqueueexcept') AND REQU_STATUS = '$this->thetwo' order by REQU_ID DESC limit 100 ");
		return $list;
	}	
	// 18 SEPT 2023 JOSEPH ADORBOE
	public function vitalsservicerequest($conlist, String $instcode) : String{		
		$list = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_SERIAL,REQU_DOCTOR,REQU_DOCTORCODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_BILLCODE,REQU_PLAN,REQU_VITALSTATUS from octopus_patients_servicesrequest  where REQU_SHOW = '$this->theseven' and REQU_VITALSTATUS = '$this->thezero' and DATE(REQU_DATE) = '$this->theday' and REQU_SERVICECODE IN('$conlist') AND REQU_INSTCODE = '$instcode' AND REQU_STATUS = '$this->thetwo' order by REQU_VISITTYPE ASC");
		return $list;
	}
	// 13 SEPT 2023 JOSEPH ADORBOE
	public function selectsendbackservicerequest(String $currentshiftcode, String $instcode) : String{		
		$list = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_SERIAL,REQU_DOCTOR,REQU_DOCTORCODE,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_BILLCODE,REQU_PLAN,REQU_VITALSTATUS from octopus_patients_servicesrequest where REQU_INSTCODE = '$instcode' and REQU_SHIFTCODE = '$currentshiftcode' AND REQU_RETURN = '$this->theone' AND REQU_STATUS = '8' AND REQU_STATE = '$this->theseven'");
		return $list;
	}
	// 25 MAY 2024, JOSEPH ADORBOE 
	public function cancelconsultationservicerequest( String $returnreason, String $visitcode, String $currentuser, String $currentusercode, String $instcode) : Int {		
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_RETURN = ?, REQU_RETURNTIME = ? , REQU_RETURNACTOR = ?, REQU_RETURNACTORCODE = ? , REQU_RETURNREASON = ?  WHERE REQU_VISITCODE = ? and  REQU_RETURN = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->theone);
		$st->BindParam(2, $this->thedays);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $visitcode);
		$st->BindParam(7, $this->thezero);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return $this->thepassed ;	
			}else{
				return $this->thefailed;	
			}	
	}
	// 17 oct 2023, 29 MAR 2022 ,JOSEPH ADORBOE
    public function insertpatientwounddressingservicerequest($form_key,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$woundservicecode,$woundservicename,$storyline,$paymentmethod,$paymentmethodcode,$consultationpaymenttype,$schemecode,$scheme,$currentusercode,$currentuser,$instcode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear) : Int {
	
		$mt = 1;
		$sqlstmt = ("SELECT REQU_ID FROM octopus_patients_servicesrequest where REQU_PATIENTCODE = ? AND REQU_VISITCODE = ? AND REQU_SERVICECODE = ? AND REQU_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $woundservicecode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return $this->theexisted;			
			}else{
				$sqlstmtserv = "INSERT INTO octopus_patients_servicesrequest(REQU_CODE,REQU_VISITCODE,REQU_BILLCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_ACTOR,REQU_ACTORCODE,REQU_INSTCODE,REQU_SHIFTCODE,REQU_SHIFT,REQU_VISITTYPE,REQU_PAYMENTTYPE,REQU_SHOW,REQU_DAY,REQU_MONTH,REQU_YEAR,REQU_REMARKS) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmtserv);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $visitcode);
			$st->BindParam(3, $form_key);
			$st->BindParam(4, $this->thedays);
			$st->BindParam(5, $patientcode);
			$st->BindParam(6, $patientnumber);
			$st->BindParam(7, $patient);
			$st->BindParam(8, $age);
			$st->BindParam(9, $gender);
			$st->BindParam(10, $paymentmethod);
			$st->BindParam(11, $paymentmethodcode);
			$st->BindParam(12, $schemecode);
			$st->BindParam(13, $scheme);
			$st->BindParam(14, $woundservicecode);
			$st->BindParam(15, $woundservicename);
			$st->BindParam(16, $currentuser);
			$st->BindParam(17, $currentusercode);
			$st->BindParam(18, $instcode);
			$st->BindParam(19, $currentshiftcode);
			$st->BindParam(20, $currentshift);
			$st->BindParam(21, $mt);
			$st->BindParam(22, $consultationpaymenttype);
			$st->BindParam(23, $consultationpaymenttype);
			$st->BindParam(24, $currentday);
			$st->BindParam(25, $currentmonth);
			$st->BindParam(26, $currentyear);
			$st->BindParam(27, $storyline);
			$exed = $st->execute();				
			if($exed){								
				return $this->thepassed;;								
			}else{								
				return $this->thefailed;								
			}	
				
			}
		}else{
			return $this->thefailed;
		}	
	}	
	// 13 MAY 2021 JOSEPH ADORBOE 
	public function updateservicerequeststage(String $requestcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STAGE = ? WHERE REQU_CODE = ? and REQU_STAGE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thethree);
		$st->BindParam(2, $requestcode);
		$st->BindParam(3, $this->thetwo);
		$exe = $st->execute();							
		if($exe){								
			return $this->thepassed;;								
		}else{								
			return $this->thefailed;								
		}
	}
	// 20 Sept 2023, 20 NOV 2022 JOSEPH ADORBOE
	public function addtoqueuetodayservicerequest(String $ekey,String $addreason,String $currentusercode,String $currentuser,String $instcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_RETURN = ?, REQU_RETURNTIME = ? , REQU_RETURNACTOR = ?, REQU_RETURNACTORCODE = ? , REQU_RETURNREASON = ? ,REQU_DATE = ? WHERE REQU_CODE = ? and  REQU_RETURN = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thezero);
		$st->BindParam(2, $this->thedays);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $addreason);
		$st->BindParam(6, $this->thedays);
		$st->BindParam(7, $ekey);
		$st->BindParam(8, $this->thezero);
		$st->BindParam(9, $instcode);
		$selectitem = $st->Execute();				
		if($selectitem){
			return $this->thepassed;;	
		}else{
			return $this->thefailed ;	
		}	
	}
	// 19 Sept 2023, 20 NOV 2022 JOSEPH ADORBOE
	public function returnservicerequest(String $ekey,String $returnreason,String $currentusercode,String $currentuser,String $instcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_RETURN = ?, REQU_RETURNTIME = ? , REQU_RETURNACTOR = ?, REQU_RETURNACTORCODE = ? , REQU_RETURNREASON = ?  WHERE REQU_CODE = ? and  REQU_RETURN = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->theone);
		$st->BindParam(2, $this->thedays);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $this->thezero);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return $this->thepassed ;	
			}else{
				return $this->thefailed;	
			}	
	}
	// 9 AUG 2023
	public function vitalsforrbsservicerequest($patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$paymenttype,$servicerbscode,$servicerbs,$servicerequestcode,$billingcode,$visittype,$currentday,$currentmonth,$currentyear,$plan) : Int {
		$sqlstmtserv = "INSERT INTO octopus_patients_servicesrequest(REQU_CODE,REQU_VISITCODE,REQU_BILLCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_ACTOR,REQU_ACTORCODE,REQU_INSTCODE,REQU_SHIFTCODE,REQU_SHIFT,REQU_VISITTYPE,REQU_PAYMENTTYPE,REQU_SHOW,REQU_DAY,REQU_MONTH,REQU_YEAR,REQU_PLAN) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmtserv);   
		$st->BindParam(1, $servicerequestcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $billingcode);
		$st->BindParam(4, $this->thedays);
		$st->BindParam(5, $patientcode);
		$st->BindParam(6, $patientnumber);
		$st->BindParam(7, $patient);
		$st->BindParam(8, $age);
		$st->BindParam(9, $gender);
		$st->BindParam(10, $paymentmethod);
		$st->BindParam(11, $paymentmethodcode);
		$st->BindParam(12, $patientschemecode);
		$st->BindParam(13, $patientscheme);
		$st->BindParam(14, $servicerbscode);
		$st->BindParam(15, $servicerbs);
		$st->BindParam(16, $currentuser);
		$st->BindParam(17, $currentusercode);
		$st->BindParam(18, $instcode);
		$st->BindParam(19, $currentshiftcode);
		$st->BindParam(20, $currentshift);
		$st->BindParam(21, $visittype);
		$st->BindParam(22, $paymenttype);
		$st->BindParam(23, $paymenttype);
		$st->BindParam(24, $currentday);
		$st->BindParam(25, $currentmonth);
		$st->BindParam(26, $currentyear);
		$st->BindParam(27, $plan);
		$exed = $st->execute();
		if($exed){								
			return $this->thepassed;;								
		}else{								
			return $this->thefailed;								
		}
	}
	// 18 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientservicerequestdoctors($ekey,$specscode,$specsname,$serialnumber,$currentusercode,$currentuser,$instcode) : Int {
		
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_DOCTORCODE = ?, REQU_DOCTOR = ? , REQU_VITALSTATUS = ?, REQU_SERIAL = ? ,REQU_STAGE = ? ,REQU_NURSE = ? , REQU_NURSECODE = ? WHERE REQU_CODE = ? AND REQU_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $specscode);
		$st->BindParam(2, $specsname);
		$st->BindParam(3, $this->theone);
		$st->BindParam(4, $serialnumber);
		$st->BindParam(5, $this->thetwo);
		$st->BindParam(6, $currentuser);
		$st->BindParam(7, $currentusercode);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $instcode);
		$exe = $st->execute();
		if($exe){				
			return $this->thepassed;;
		}else{				
			return $this->thefailed;				
		}	
	}
	// 13 SEPT 2023,  JOSEPH ADORBOE
    public function updatesendbackservicerequested($ekey,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$paymentplan,$currentusercode,$currentuser,$instcode) : Int {
		
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_PAYMENTMETHOD = ?, REQU_PAYMENTMETHODCODE = ?, REQU_PAYSCHEMECODE = ?, REQU_PAYSCHEME = ?, REQU_PLAN = ?, REQU_SERVICECODE = ?, REQU_SERVICE =?, REQU_RETURN = ?, REQU_ACTOR = ?, REQU_ACTORCODE =? , REQU_STATUS =? , REQU_STATE =?  WHERE REQU_CODE = ? AND REQU_INSTCODE  = ? AND REQU_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $paymethname);
		$st->BindParam(2, $paymentmethodcode);
		$st->BindParam(3, $paymentschemecode);
		$st->BindParam(4, $paymentscheme);
		$st->BindParam(5, $paymentplan);
		$st->BindParam(6, $servicescode);
		$st->BindParam(7, $servicesname);
		$st->BindParam(8, $this->thezero);
		$st->BindParam(9, $currentuser);
		$st->BindParam(10, $currentusercode);
		$st->BindParam(11, $this->theone);
		$st->BindParam(12, $this->theone);
		$st->BindParam(13, $ekey);
		$st->BindParam(14, $instcode);
		$st->BindParam(15, $this->theeight);
		$exe = $st->execute();
		if($exe){				
			return $this->thepassed;;
		}else{				
			return $this->thefailed;				
		}	
	}
	// 4 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientservicerequestoutcome($requestcode,$currentusercode,$currentuser,$instcode) : int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_COMPLETE = ?, REQU_STATE = ?, REQU_ACTOR = ?, REQU_ACTORCODE =?  WHERE REQU_CODE = ? AND REQU_INSTCODE  = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thetwo);
		$st->BindParam(2, $this->theten);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $requestcode);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){				
			return $this->thepassed;;
		}else{				
			return $this->thefailed;				
		}	
	}
	// 3 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientnumberservicerequest($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode) : int {
		$sqlstmt = "UPDATE octopus_patients_servicesrequest SET REQU_PATIENTNUMBER = ?, REQU_ACTOR = ?, REQU_ACTORCODE =?  where REQU_PATIENTCODE = ? and REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $replacepatientnumber);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();
		if($exe){				
			return $this->thepassed;;
		}else{				
			return $this->thefailed;				
		}	
	}
	// 9 AUG 2023
	public function updateservicerequest(String $servicerequestcode) : int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_SHOW = ? , REQU_STATUS = ? WHERE REQU_CODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->theseven);
		$st->BindParam(2, $this->thetwo);
		$st->BindParam(3, $servicerequestcode);
		$exegh = $st->execute();
		if($exegh){								
			return $this->thepassed;;								
		}else{								
			return $this->thefailed;								
		}	
	}		
	// 29 AUG 2023
	public function selectedpaidservicerequest($selected,$show,$patientcode,$visitcode,$unselected,$instcode) : int{
		$sqlservice = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? , REQU_SHOW = ? , REQU_SELECTED = ?  WHERE REQU_VISITCODE = ? and REQU_SELECTED = ? and REQU_INSTCODE = ? AND  REQU_PATIENTCODE = ?";
		$st = $this->db->prepare($sqlservice);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $show);
		$st->BindParam(3, $selected);
		$st->BindParam(4, $visitcode);
		$st->BindParam(5, $unselected);
		$st->BindParam(6, $instcode);
		$st->BindParam(7, $patientcode);
		$selectitem = $st->Execute();			
		if($selectitem){						
			return $this->thepassed ;						
		}else{						
			return $this->thefailed;						
		}
	}	
	// 22 AUG 2023 
	public function reversecancelservices($visitcode,$servicecode,$patientcode,$currentusercode,$currentuser,$instcode) : int {
		$sqlstmt = "UPDATE octopus_patients_servicesrequest SET REQU_COMPLETE = ?, REQU_STATUS = ? ,REQU_STATE = ?, REQU_ACTOR = ? , REQU_ACTORCODE = ? where REQU_VISITCODE = ? and REQU_SERVICECODE = ? and  REQU_INSTCODE = ? and REQU_COMPLETE = ? AND REQU_PATIENTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $this->theone);
		$st->BindParam(2, $this->theone);
		$st->BindParam(3, $this->theone);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $visitcode);
		$st->BindParam(7, $servicecode);
		$st->BindParam(8, $instcode);
		$st->BindParam(9, $this->thezero);
		$st->BindParam(10, $patientcode);
		$exe = $st->execute();
		if($exe){			
			return $this->thepassed;;			
		}else{			
			return $this->thefailed;			
		}
	}
	// 27 AUG 2023
	public function billscancelservices($selected,$servicecode,$visitcode,$unselected,$instcode) : int {
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? , REQU_STATE = ? , REQU_COMPLETE = ? WHERE REQU_CODE = ? and REQU_VISITCODE = ? and REQU_SELECTED = ?  and REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $unselected);
		$st->BindParam(2, $unselected);
		$st->BindParam(3, $unselected);
		$st->BindParam(4, $servicecode);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $unselected);
		$st->BindParam(7, $instcode);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return $this->thepassed ;						
		}else{						
			return $this->thefailed ;						
		}
	}
	// 23 AUG 2023
	public function billssendbackservices($selected,$servicecode,$visitcode,$sendbackreason,$currentuser,$currentusercode,$instcode) : int {
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_RETURN = ?, REQU_RETURNTIME = ?, REQU_RETURNREASON = ?, REQU_RETURNACTOR = ?, REQU_RETURNACTORCODE = ? , REQU_STATUS =?, REQU_STATE = ? WHERE REQU_CODE = ? and REQU_VISITCODE = ? AND REQU_INSTCODE = ? and REQU_STATUS = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $this->thedays);
		$st->BindParam(3, $sendbackreason);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $this->theeight);
		$st->BindParam(7, $this->theseven);
		$st->BindParam(8, $servicecode);
		$st->BindParam(9, $visitcode);
		$st->BindParam(10, $instcode);
		$st->BindParam(11, $selected);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return $this->thepassed ;						
		}else{						
			return $this->thefailed ;						
		}
	}
	// 23 AUG 2023
	public function billsunselectservices($selected,$servicecode,$visitcode,$unselected,$instcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_SELECTED = ? WHERE REQU_CODE = ? and REQU_VISITCODE = ? AND REQU_INSTCODE = ? and REQU_SELECTED = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $unselected);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $selected);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return $this->thepassed ;						
		}else{						
			return $this->thefailed ;						
		}
	}
	// 23 AUG 2023
	public function billsselectservices($selected,$servicecode,$visitcode,$unselected,$instcode) : Int{
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_SELECTED = ? WHERE REQU_CODE = ? and REQU_VISITCODE = ? and REQU_SELECTED = ?  and REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $unselected);
		$st->BindParam(5, $instcode);
		$selectitem = $st->Execute();				
		if($selectitem){						
			return $this->thepassed ;						
		}else{						
			return $this->thefailed ;						
		}
	}
	// 9 AUG 2023
	public function newservicerequest($patientcode,$patientnumbers,$patient,$gender,$age,$visitcode,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$servicerequestcode,$billingcode,$visittype,$payment,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear,$paymentplan) : Int {
		$sqlstmtserv = "INSERT INTO octopus_patients_servicesrequest(REQU_CODE,REQU_VISITCODE,REQU_BILLCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_ACTOR,REQU_ACTORCODE,REQU_INSTCODE,REQU_SHIFTCODE,REQU_SHIFT,REQU_VISITTYPE,REQU_PAYMENTTYPE,REQU_SHOW,REQU_DAY,REQU_MONTH,REQU_YEAR,REQU_PLAN) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmtserv);   
			$st->BindParam(1, $servicerequestcode);
			$st->BindParam(2, $visitcode);
			$st->BindParam(3, $billingcode);
			$st->BindParam(4, $this->thedays);
			$st->BindParam(5, $patientcode);
			$st->BindParam(6, $patientnumbers);
			$st->BindParam(7, $patient);
			$st->BindParam(8, $age);
			$st->BindParam(9, $gender);
			$st->BindParam(10, $paymethname);
			$st->BindParam(11, $paymentmethodcode);
			$st->BindParam(12, $paymentschemecode);
			$st->BindParam(13, $paymentscheme);
			$st->BindParam(14, $servicescode);
			$st->BindParam(15, $servicesname);
			$st->BindParam(16, $currentuser);
			$st->BindParam(17, $currentusercode);
			$st->BindParam(18, $instcode);
			$st->BindParam(19, $currentshiftcode);
			$st->BindParam(20, $currentshift);
			$st->BindParam(21, $visittype);
			$st->BindParam(22, $payment);
			$st->BindParam(23, $payment);
			$st->BindParam(24, $currentday);
			$st->BindParam(25, $currentmonth);
			$st->BindParam(26, $currentyear);
			$st->BindParam(27, $paymentplan);
			$exed = $st->execute();
			if($exed){								
				return $this->thepassed;;								
			}else{								
				return $this->thefailed;								
			}	

	}
	
} 
$patientsServiceRequesttable = new OctopusPatientsServiceRequestSql();
?>