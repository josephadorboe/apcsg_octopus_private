<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_investigationrequest
	$patientsInvestigationRequesttable->getinvestigationinsurancestatus($type,$instcode)
	chargereportfees($form_key,$billingcode,$visitcode,$patientcode,$patientnumber,$patient,$reportfees,$serviceamount,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$billercode,$biller);
	
*/

class OctopusPatientsInvestigationsRequestSql Extends Engine{

	// 30 JULY 2025, JOSEPH ADORBOE 
	public function querygetpatientlabsrequest($currentvisitcode,$instcode) : String {
		$list =	"SELECT MIV_CODE,MIV_REQUESTCODE,MIV_TEST,MIV_REMARK,MIV_TESTCODE,MIV_TESTPARTNERCODE,MIV_DATE from octopus_patients_investigationrequest where MIV_INSTCODE = '$instcode' and MIV_VISITCODE = '$currentvisitcode' AND MIV_CATEGORY ='LABS' and MIV_STATE IN('$this->theone','$this->thetwo','$this->thefive','$this->thesix') and MIV_COMPLETE = '$this->theone'";
	return $list;
	}

	// 28 JUNE 2021 JOSEPH ADORBOE  transactioncode
	public function getinvestigationinsurancestatus($patientcode,$visitcode,$privateinsurancecode,$partnercompaniescode,$nationalinsurancecode,$instcode){
		$nut = 1 ;
		$sqlstmt = ("SELECT MIV_ID FROM octopus_patients_investigationrequest where MIV_PATIENTCODE = ? AND MIV_VISITCODE = ? and MIV_INSTCODE = ? and MIV_COMPLETE = ? and MIV_PAYMENTMETHODCODE IN(?,?,?) ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $nut);
		$st->BindParam(5, $privateinsurancecode);
		$st->BindParam(6, $partnercompaniescode);
		$st->BindParam(7, $nationalinsurancecode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){					
				return $this->thevalid;
			}else{
				return $this->theinvalid;
			}
		}else{
			return $this->theinvalid;
		}			
	}	

	// 29 JULY 2025, JOSEPH ADORBOE 
	public function querygetlabsrequestlist(String $instcode) : String{
		$list = ("SELECT DISTINCT MIV_PATIENTCODE,MIV_DATE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_VISITCODE,MIV_DATE,MIV_GENDER,MIV_AGE , MIV_PAYMENTMETHOD,MIV_PAYMENTMETHODCODE,MIV_SCHEME,MIV_SCHEMECODE,MIV_PAYMENTTYPE,MIV_TYPE,MIV_CONSULTATIONSTATE FROM octopus_patients_investigationrequest WHERE MIV_STATUS IN('$this->theone','$this->thetwo','$this->thefour','$this->thethree') and MIV_INSTCODE = '$instcode' AND MIV_CATEGORY = 'LABS' AND MIV_STATE IN('$this->theone','$this->thetwo','$this->thethree','$this->thefour','$this->thefive','$this->thesix','$this->thenine') AND MIV_COMPLETE = '$this->theone' ORDER BY MIV_DATE DESC ");
		return $list;
	}
	// 30 JULY 2025, JOSEPH ADORBOE 
	public function getpatientlabsrequest( String $instcode, String $idvalue) : String {
		$list = ("SELECT MIV_CODE,MIV_VISITCODE,MIV_DATE,MIV_PATIENTCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_CATEGORY,MIV_BILLINGCODE,MIV_PAYMENTMETHOD,MIV_PAYMENTMETHOD,MIV_SCHEMECODE,MIV_SCHEME,MIV_TYPE,MIV_PAYMENTTYPE,MIV_CONSULTATIONSTATE,MIV_GENDER,MIV_AGE,MIV_STATE,MIV_TESTCODE,MIV_COST,MIV_PAYMENTMETHODCODE,MIV_TEST,MIV_BILLERCODE,MIV_BILLER,MIV_REQUESTCODE,MIV_TESTPARTNERCODE,MIV_DATETIME FROM octopus_patients_investigationrequest WHERE MIV_INSTCODE = '$instcode' AND MIV_VISITCODE = '$idvalue'  AND MIV_STATE != '0' AND MIV_CATEGORY = 'LABS' AND MIV_STATUS IN('1','2','3','4') ");
		return $list;
	}

	// 29 JULY 2025, JOSEPH ADORBOE 
	public function querygetlabsdashboardlist($instcode) : String {
		$list ="SELECT DISTINCT MIV_PATIENTCODE,MIV_VISITCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_DATE,MIV_SCHEME,MIV_VISITCODE,MIV_PAYMENTMETHOD,MIV_GENDER,MIV_AGE,MIV_INSTCODE,MIV_CATEGORY,MIV_COMPLETE  FROM octopus_patients_investigationrequest WHERE MIV_INSTCODE = '$instcode' AND MIV_CATEGORY = 'LABS' AND MIV_COMPLETE = '$this->theone' AND MIV_DATE = '$this->theday' order by MIV_PATIENT ASC LIMIT 50";
		return $list;
	}

	// 29 JULY 2025 JOSEPH ADORBOE
	public function getlaboratorydashboard(String $instcode) : String{
        $one = 1;
		$six = 6;
		$sentout = 8;
        $not = '$this->thezero';
		$category = 'LABS';
		// $rt = 'LABS';
		$pro = "2,3";
		$pending = $awaitingresults = $requestsentout =  $processing =  0;
        $sql = 'SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_STATE = ? and MIV_INSTCODE = ? and MIV_CATEGORY = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $this->theone);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $category);
        $ext = $st->execute();
        if ($ext) {
            $pending = $st->rowcount();       
        }
		$sql = "SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_STATE IN ('$this->thetwo','$this->thethree') AND MIV_INSTCODE = ? and MIV_CATEGORY = ?";
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $instcode);
        $st->BindParam(2, $category);
        $ext = $st->execute();
        if ($ext) {
            $processing = $st->rowcount();       
        }
        $sql = 'SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_STATE = ? and MIV_INSTCODE = ? and MIV_CATEGORY = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $this->thesix);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $category);
        $ext = $st->execute();
        if ($ext) {
            $awaitingresults = $st->rowcount();       
        }

		$sql = 'SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_STATE = ? and MIV_INSTCODE = ? and MIV_CATEGORY = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $this->theeight);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $category);
        $ext = $st->execute();
        if ($ext) {
            $requestsentout = $st->rowcount();        
        }
		//					0				1						2					3				
		$radiologydashboarddetails = $pending.'@@@'.$processing.'@@@'.$awaitingresults.'@@@'.$requestsentout;        
        return $radiologydashboarddetails;
    }

	// 24 MAY 2025, JOSEPH ADORBOE 
	public function getpatientradiologyresults( String $instcode, String $idvalue) : String {
		$list = ("SELECT MIV_CODE,MIV_VISITCODE,MIV_DATE,MIV_PATIENTCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_CATEGORY,MIV_BILLINGCODE,MIV_PAYMENTMETHOD,MIV_PAYMENTMETHOD,MIV_SCHEMECODE,MIV_SCHEME,MIV_TYPE,MIV_PAYMENTTYPE,MIV_CONSULTATIONSTATE,MIV_GENDER,MIV_AGE,MIV_STATE,MIV_TESTCODE,MIV_COST,MIV_PAYMENTMETHODCODE,MIV_TEST,MIV_BILLERCODE,MIV_BILLER,MIV_REQUESTCODE,MIV_TESTPARTNERCODE,MIV_DATETIME FROM octopus_patients_investigationrequest WHERE MIV_INSTCODE = '$instcode' AND MIV_VISITCODE = '$idvalue'  AND MIV_STATE = 7 AND MIV_CATEGORY = 'IMAGING' AND MIV_STATUS IN('2') ");
		return $list;
	}

	// 9 JULY 2025,  JOSEPH ADORBOE
	public function countradiologyrequest($type,$instcode){
		$sqlstmt = "SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE  MIV_CATEGORY = ?  AND MIV_DATE = ? AND MIV_COMPLETE = ? AND MIV_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $type);
		$st->BindParam(2, $this->theday);
		$st->BindParam(3, $this->theone);
		$st->BindParam(4, $instcode);
		$selectit = $st->execute();
		if($selectit){			
			return $st->rowcount();
		}else{
			return $this->theone;
		}				
	}	

	// 24 MAY 2025, JOSEPH ADORBOE 
	public function querygetradiologyresultlist(String $instcode) : String{
		$list = ("SELECT DISTINCT MIV_PATIENTCODE,MIV_DATE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_VISITCODE,MIV_DATE,MIV_GENDER,MIV_AGE , MIV_PAYMENTMETHOD,MIV_PAYMENTMETHODCODE,MIV_SCHEME,MIV_SCHEMECODE,MIV_PAYMENTTYPE,MIV_TYPE,MIV_CONSULTATIONSTATE from octopus_patients_investigationrequest where MIV_STATUS IN('$this->thetwo','$this->thefour') and MIV_INSTCODE = '$instcode' AND MIV_CATEGORY = 'IMAGING' AND MIV_STATE IN('$this->theseven') and MIV_COMPLETE = '$this->thetwo' order by MIV_DATE DESC ");
		return $list;
	}

	// 04 APR  2021 JOSEPH ADORBOE	  
	public function chargereportfees($form_key,$billingcode,$visitcode,$patientcode,$patientnumber,$patient,$reportfees,$serviceamount,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$billercode,$biller)
	{
		$nut = 2;
		$one =1;
		$zero = 0;
		$serviceitem = 'REPORT FEES';
		$cashscheme = 'CASH';
		$depts = 'IMAGING';
		
		
		$qty = 1 ;
		$sql = ("INSERT INTO octopus_patients_billitems (B_CODE,B_VISITCODE,B_SERVCODE,B_BILLCODE,B_DT,B_DTIME,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_METHODCODE,B_METHOD,B_PAYSCHEMECODE,B_PAYSCHEME,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_INSTCODE,B_DPT,B_ACTORCODE,B_ACTOR,B_SHIFTCODE,B_SHIFT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_BILLERCODE,B_BILLER) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $billingcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $form_key);
		$st->BindParam(4, $form_key);
		$st->BindParam(5, $this->theday);
		$st->BindParam(6, $this->thedays);
		$st->BindParam(7, $patientcode);
		$st->BindParam(8, $patientnumber);
		$st->BindParam(9, $patient);
		$st->BindParam(10, $serviceitem);
		$st->BindParam(11, $reportfees);
		$st->BindParam(12, $cashpaymentmethodcode);
		$st->BindParam(13, $cashpaymentmethod);
		$st->BindParam(14, $cashschemecode);
		$st->BindParam(15, $cashscheme);
		$st->BindParam(16, $qty);
		$st->BindParam(17, $serviceamount);
		$st->BindParam(18, $serviceamount);
		$st->BindParam(19, $serviceamount);
		$st->BindParam(20, $instcode);
		$st->BindParam(21, $depts);
		$st->BindParam(22, $currentusercode);
		$st->BindParam(23, $currentuser);
		$st->BindParam(24, $currentshiftcode);
		$st->BindParam(25, $currentshift);	
		$st->BindParam(26, $this->theone);
		$st->BindParam(27, $currentday);
		$st->BindParam(28, $currentmonth);
		$st->BindParam(29, $currentyear);
		$st->BindParam(30, $billercode);
		$st->BindParam(31, $biller);	
		$setbills = $st->execute();				
		if($setbills){				
			return $this->thepassed ;	
		}else{
			return $this->thefailed ;	
		}
	}

	// 31 MAY 2025 , 03 APR 2021 , JOSEPH ADORBOE
	public function processunselectinvestigation($bcode,$currentusercode,$currentuser){
		$sqlstmt = "SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE  MIV_CODE = ? AND MIV_STATE != ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $this->thetwo);
		$selectit = $st->execute();
		if($selectit){
			if($st->rowcount() > $this->thefailed){
				return $this->theexisted;
			}else{				
				$sqlstmt = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_PROCESSACTOR = ?, MIV_PROCESSACTORCODE = ? , MIV_COST = ?,  MIV_PARTNERCOST = ?  WHERE MIV_CODE = ? and MIV_STATE = ?  ";
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $this->theone);
				$st->BindParam(2, $currentuser);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $this->thezero);
				$st->BindParam(5, $this->thezero);
				$st->BindParam(6, $bcode);
				$st->BindParam(7, $this->thetwo);
				$selectitem = $st->Execute();				
					if($selectitem){
						return $this->thepassed ;	
					}else{
						return $this->thefailed ;	
					}
            	}
			}else{
				return $this->thefailed;
			}							
	}	

	// 03 APR 2021 
	public function processselectinvestigation($bcode,$serviceamount,$partneramount,$currentusercode,$currentuser) : int {		
		$sqlstmt = "SELECT MIV_ID FROM octopus_patients_investigationrequest where  MIV_CODE = ? and MIV_STATE != ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $this->theone);
		$selectit = $st->execute();
		if($selectit){
			if($st->rowcount() >'0'){
				return $this->theexisted;
			}else{
				if($serviceamount == '-1'){
					$sqlstmtupdate = "UPDATE octopus_patients_investigationrequest SET MIV_COST = ? , MIV_PROCESSACTOR = ? , MIV_PROCESSACTORCODE = ?, MIV_PARTNERCOST = ?   WHERE MIV_CODE = ? and MIV_STATE = ?  ";
					$st = $this->db->prepare($sqlstmtupdate);
					$st->BindParam(1, $serviceamount);
					$st->BindParam(2, $currentuser);
					$st->BindParam(3, $currentusercode);
					$st->BindParam(4, $partneramount);
					$st->BindParam(5, $bcode);
					$st->BindParam(6, $this->theone);
					$selectitem = $st->Execute();				
					if($selectitem){
						return $this->thepassed ;	
					}else{
						return $this->thefailed ;	
					}

				}else{					
					$sqlstmtupdatep = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_COST = ? , MIV_PROCESSACTOR = ? , MIV_PROCESSACTORCODE = ? , MIV_PARTNERCOST = ?  WHERE MIV_CODE = ? and MIV_STATE = ?  ";
					$st = $this->db->prepare($sqlstmtupdatep);
					$st->BindParam(1, $this->thetwo);
					$st->BindParam(2, $serviceamount);
					$st->BindParam(3, $currentuser);
					$st->BindParam(4, $currentusercode);
					$st->BindParam(5, $partneramount);
					$st->BindParam(6, $bcode);
					$st->BindParam(7, $this->theone);
					$selectitem = $st->Execute();				
					if($selectitem){
							return $this->thepassed ;	
					}else{
						return $this->thefailed ;	
					}

				}
						
			}
		}else{
			return $this->thefailed ;
		}	
	}	


	// 31 MAY 2025, JOSEPH ADORBOE 
	public function querygetreturninvestigationrequest(String $category,String $instcode,String $visitcode) : String {
		$list = "SELECT MIV_CODE,MIV_TESTCODE,MIV_TYPE,MIV_COST,MIV_PAYMENTMETHODCODE,MIV_STATE,MIV_RETURN,MIV_CATEGORY,MIV_REQUESTCODE,MIV_TEST,MIV_STATE,MIV_RETURN from octopus_patients_investigationrequest where MIV_INSTCODE = '$instcode' and MIV_VISITCODE = '$visitcode' AND MIV_CATEGORY = '$category' and MIV_STATUS IN('2','3','6') and MIV_STATE IN('4','6') and MIV_RETURN IN ('0','1','2')" ;
		return $list;
	}

	// 24 MAY 2025, JOSEPH ADORBOE 
	public function getpatientradiologyrequest( String $instcode, String $idvalue) : String {
		$list = ("SELECT MIV_CODE,MIV_VISITCODE,MIV_DATE,MIV_PATIENTCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_CATEGORY,MIV_BILLINGCODE,MIV_PAYMENTMETHOD,MIV_PAYMENTMETHOD,MIV_SCHEMECODE,MIV_SCHEME,MIV_TYPE,MIV_PAYMENTTYPE,MIV_CONSULTATIONSTATE,MIV_GENDER,MIV_AGE,MIV_STATE,MIV_TESTCODE,MIV_COST,MIV_PAYMENTMETHODCODE,MIV_TEST,MIV_BILLERCODE,MIV_BILLER,MIV_REQUESTCODE,MIV_TESTPARTNERCODE,MIV_DATETIME FROM octopus_patients_investigationrequest WHERE MIV_INSTCODE = '$instcode' AND MIV_VISITCODE = '$idvalue'  AND MIV_STATE != '0' AND MIV_CATEGORY = 'IMAGING' AND MIV_STATUS IN('1','2','3','4') ");
		return $list;
	}
	// 24 MAY 2025,  04 APR 2021 , JOSEPH ADORBOE
	public function getpatientlabstotal(String $visitcode) : mixed {
		$sql = ("SELECT SUM(MIV_COST) FROM octopus_patients_investigationrequest where MIV_VISITCODE = ? AND MIV_STATUS != ? AND MIV_STATE IN('2','3')  ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $this->thezero);
		// $st->BindParam(3, $this->thethree);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){				
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUM(MIV_COST)']??$this->thezero;				
				return $results;
			}else{
				return $this->thefailed;
			}
		}else{
			return -1;
		}		
	}

	// 29 JULY 2025, 04 APR 2021 JOSEPH ADORBOE  transactioncode MIV_ATTACHEDFILE
	public function getlabtestrequestdetails($transactioncode){
		$sqlstmt = ("SELECT MIV_CODE,MIV_PATIENTCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_GENDER,MIV_AGE,MIV_VISITCODE,MIV_DATE,MIV_DATETIME,MIV_REQUESTCODE,MIV_TESTCODE,MIV_TEST,MIV_CATEGORY,MIV_COST,MIV_REMARK,MIV_PAYMENTMETHOD,MIV_PAYMENTMETHODCODE,MIV_SCHEME,MIV_SCHEMECODE,MIV_STATE,MIV_STATUS,MIV_SAMPLE,MIV_SAMPLELABEL,MIV_SAMPLEDATE,MIV_SAMPLEACTOR,MIV_ATTACHEDFILE,MIV_RESULTDATE,MIV_PARTNERCOST FROM octopus_patients_investigationrequest WHERE MIV_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $transactioncode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
			//	 						0							1								2							3							4						5						6							7
				$results = $object['MIV_CODE'].'@'.$object['MIV_PATIENTCODE'].'@'.$object['MIV_PATIENTNUMBER'].'@'.$object['MIV_PATIENT'].'@'.$object['MIV_GENDER'].'@'.$object['MIV_AGE'].'@'.$object['MIV_VISITCODE'].'@'.$object['MIV_DATE'].'@'.$object
			//			8							9							10							11							12						13						14							15									16
				['MIV_DATETIME'].'@'.$object['MIV_REQUESTCODE'].'@'.$object['MIV_TESTCODE'].'@'.$object['MIV_TEST'].'@'.$object['MIV_CATEGORY'].'@'.$object['MIV_COST'].'@'.$object['MIV_REMARK'].'@'.$object['MIV_PAYMENTMETHOD'].'@'.$object['MIV_PAYMENTMETHODCODE']
			//						17							18						19							20							21							22							23								24	
				.'@'.$object['MIV_SCHEME'].'@'.$object['MIV_SCHEMECODE'].'@'.$object['MIV_STATE'].'@'.$object['MIV_STATUS'].'@'.$object['MIV_SAMPLE'].'@'.$object['MIV_SAMPLELABEL'].'@'.$object['MIV_SAMPLEDATE'].'@'.$object['MIV_SAMPLEACTOR'].'@'.$object
			// 			25	
				['MIV_ATTACHEDFILE'].'@'.$object['MIV_RESULTDATE'].'@'.$object['MIV_PARTNERCOST'];

				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}

	// 04 APR 2021 JOSEPH ADORBOE 
	public function getpatienttransactiondetails(String $idvalue) : mixed {
		$sqlstmt = ("SELECT DISTINCT MIV_VISITCODE,MIV_DATE,MIV_PATIENTCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_CATEGORY,MIV_BILLINGCODE,MIV_PAYMENTMETHOD,MIV_PAYMENTMETHOD,MIV_SCHEMECODE,MIV_SCHEME,MIV_TYPE,MIV_PAYMENTTYPE,MIV_CONSULTATIONSTATE,MIV_GENDER,MIV_AGE FROM octopus_patients_investigationrequest WHERE MIV_VISITCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['MIV_VISITCODE'].'@'.$object['MIV_DATE'].'@'.$object['MIV_PATIENTCODE'].'@'.$object['MIV_PATIENTNUMBER'].'@'.$object['MIV_PATIENT'].'@'.$object['MIV_CATEGORY'].'@'.$object['MIV_BILLINGCODE'].'@'.$object['MIV_PAYMENTMETHOD'].'@'.$object['MIV_SCHEME'].'@'.$object['MIV_SCHEMECODE'].'@'.$object['MIV_TYPE'].'@'.$object['MIV_PAYMENTTYPE'].'@'.$object['MIV_CONSULTATIONSTATE'].'@'.$object['MIV_GENDER'].'@'.$object['MIV_AGE'];
				return $results;
			}else{
				return $this->theexisted;
			}

		}else{
			return $this->thefailed;
		}
			
	}
	// 24 MAY 2025, JOSEPH ADORBOE 
	public function querygetradiologyrequestlist(String $instcode) : String{
		$list = ("SELECT DISTINCT MIV_PATIENTCODE,MIV_DATE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_VISITCODE,MIV_DATE,MIV_GENDER,MIV_AGE , MIV_PAYMENTMETHOD,MIV_PAYMENTMETHODCODE,MIV_SCHEME,MIV_SCHEMECODE,MIV_PAYMENTTYPE,MIV_TYPE,MIV_CONSULTATIONSTATE from octopus_patients_investigationrequest where MIV_STATUS IN('$this->theone','$this->thetwo','$this->thefour','$this->thethree') and MIV_INSTCODE = '$instcode' AND MIV_CATEGORY = 'IMAGING' AND MIV_STATE IN('$this->theone','$this->thetwo','$this->thethree','$this->thefour','$this->thefive','$this->thesix','$this->thenine') and MIV_COMPLETE = '$this->theone' order by MIV_DATE DESC ");
		return $list;
	}
	// 12 MAR 2022,  JOSEPH ADORBOE
    public function insert_walkininvestigation($form_key,$labrequestcode,$currentvisitcode,$patientcode,$patient,$patientnumber,$gender,$age,$labscode,$labsname,$labpartnercode,$notes,$type,$category,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$currentusercode,$currentuser,$instcode) : Int {
		
		$one = 1;
		$scheme = 'CASH';
		$sqlstmt = ("SELECT MIV_ID FROM octopus_patients_investigationrequest where MIV_PATIENTCODE = ? AND MIV_VISITCODE = ? AND MIV_TESTCODE = ? and MIV_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $currentvisitcode);
		$st->BindParam(3, $labscode);
		$st->BindParam(4, $this->theone);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return $this->theexisted;			
			}else{

				$sqlstmt = "INSERT INTO octopus_patients_investigationrequest(MIV_CODE,MIV_DATE,MIV_DATETIME,MIV_PATIENTCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_CONSULTATIONCODE,MIV_AGE,MIV_GENDER,MIV_VISITCODE,MIV_TESTCODE,MIV_TEST,MIV_TYPE,MIV_CATEGORY,MIV_REMARK,MIV_ACTOR,MIV_ACTORCODE,MIV_INSTCODE,MIV_PAYMENTMETHOD,MIV_PAYMENTMETHODCODE,MIV_SCHEMECODE,MIV_SCHEME,MIV_REQUESTCODE,MIV_PAYMENTTYPE,MIV_TESTPARTNERCODE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $this->theday);
				$st->BindParam(3, $this->thedays);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $patient);
				$st->BindParam(7, $form_key);
				$st->BindParam(8, $age);
				$st->BindParam(9, $gender);
				$st->BindParam(10, $currentvisitcode);
				$st->BindParam(11, $labscode);
				$st->BindParam(12, $labsname);
				$st->BindParam(13, $type);
				$st->BindParam(14, $category);
				$st->BindParam(15, $notes);
				$st->BindParam(16, $currentuser);
				$st->BindParam(17, $currentusercode);
				$st->BindParam(18, $instcode);
				$st->BindParam(19, $cashpaymentmethod);
				$st->BindParam(20, $cashpaymentmethodcode);
				$st->BindParam(21, $cashschemecode);
				$st->BindParam(22, $scheme);
				$st->BindParam(23, $labrequestcode);
				$st->BindParam(24, $this->theone);
				$st->BindParam(25, $labpartnercode);
				$exe = $st->execute();
				if($exe){										
					return $this->thepassed;								
				}else{								
					return $this->thefailed;						
				}									
						
			}
		}else{
			return $this->thefailed;
		}	
	}

	// 19 MAY 2025, JOSEPH ADORBOE 
	public function querygetpatientradiologyrequest($currentvisitcode,$instcode) : String {
		$list =	"SELECT MIV_CODE,MIV_REQUESTCODE,MIV_TEST,MIV_REMARK,MIV_TESTCODE,MIV_TESTPARTNERCODE,MIV_DATE from octopus_patients_investigationrequest where MIV_INSTCODE = '$instcode' and MIV_VISITCODE = '$currentvisitcode' AND MIV_CATEGORY ='IMAGING' and MIV_STATE IN('$this->theone','$this->thetwo','$this->thefive','$this->thesix') and MIV_COMPLETE = '$this->theone'";
	return $list;
	}

	// 19 MAY 2025, JOSEPH ADORBOE 
	public function querygetradiologydashboardlist($instcode) : String {
		$list ="SELECT DISTINCT MIV_PATIENTCODE,MIV_VISITCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_DATE,MIV_SCHEME,MIV_VISITCODE,MIV_PAYMENTMETHOD,MIV_GENDER,MIV_AGE,MIV_INSTCODE,MIV_CATEGORY,MIV_COMPLETE  FROM octopus_patients_investigationrequest WHERE MIV_INSTCODE = '$instcode' AND MIV_CATEGORY = 'IMAGING' AND MIV_COMPLETE = '$this->theone' AND MIV_DATE = '$this->theday' order by MIV_PATIENT ASC LIMIT 50";
		return $list;
	}
	// 19 MAY 2025, 31 MAY 2021 JOSEPH ADORBOE
	public function getradiologydashboard(String $instcode) : String{
        $one = 1;
		$six = 6;
		$sentout = 8;
        $not = '$this->thezero';
		$category = 'IMAGING';
		$rt = 'LABS';
		$pro = "2,3";
		$pending = $awaitingresults = $requestsentout =  $processing =  0;
        $sql = 'SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_STATE = ? and MIV_INSTCODE = ? and MIV_CATEGORY = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $this->theone);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $category);
        $ext = $st->execute();
        if ($ext) {
            $pending = $st->rowcount();       
        }
		$sql = "SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_STATE IN ('$this->thetwo','$this->thethree') AND MIV_INSTCODE = ? and MIV_CATEGORY = ?";
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $instcode);
        $st->BindParam(2, $category);
        $ext = $st->execute();
        if ($ext) {
            $processing = $st->rowcount();       
        }
        $sql = 'SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_STATE = ? and MIV_INSTCODE = ? and MIV_CATEGORY = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $this->thesix);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $category);
        $ext = $st->execute();
        if ($ext) {
            $awaitingresults = $st->rowcount();       
        }

		$sql = 'SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_STATE = ? and MIV_INSTCODE = ? and MIV_CATEGORY = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $this->theeight);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $category);
        $ext = $st->execute();
        if ($ext) {
            $requestsentout = $st->rowcount();        
        }
		//					0				1						2					3				
		$radiologydashboarddetails = $pending.'@@@'.$processing.'@@@'.$awaitingresults.'@@@'.$requestsentout;        
        return $radiologydashboarddetails;
    }

	// 16 AUG 2024, JOSEPH ADORBOE
	public function pendingpaymentinvestigationslist(String $patientcode,String $visitcode,String $instcode) : String {
		$list = ("SELECT * FROM octopus_patients_investigationrequest WHERE MIV_ATTACHED = '$this->theone' AND MIV_INSTCODE = '$instcode' AND MIV_PATIENTCODE ='$patientcode' AND MIV_STATUS = '$this->theone' AND MIV_VISITCODE = '$visitcode' AND MIV_STATE = '$this->theone'");										
		return $list;
	}

	// 16 AUG 2024, JOSEPH ADORBOE 
	public function getinvestigationsrequesteddetails(String $requestcode,String $instcode) : mixed {
		
		$sqlstmt = ("SELECT MIV_TESTCODE,MIV_TEST,MIV_TYPE,MIV_CATEGORY',MIV_CODE,MIV_REMARK,MIV_STATUS,MIV_ATTACHEDFILE  FROM octopus_patients_investigationrequest WHERE MIV_CODE = ? AND MIV_INSTCODE = ? AND MIV_STATUS != ? ORDER BY MIV_ID  DESC LIMIT 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $requestcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $this->thezero);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['MIV_TESTCODE'].'@'.$object['MIV_TEST'].'@'.$object['MIV_TYPE'].'@'.$object['MIV_CATEGORY'].'@'.$object['MIV_CODE'].'@'.$object['MIV_REMARK'].'@'.$object['MIV_STATUS'].'@'.$object['MIV_ATTACHEDFILE'] ;				
			}else{
				$results = $this->theexisted;
			}
		}else{
			$results = $this->theexisted;
		}			
		return $results;
	}

	// 31 JULY 2024 JOSEPH ADORBOE
	public function getwalkininvestigationsimaging(String $currentvisitcode,String $instcode) : String {
		$list = "SELECT * from octopus_patients_investigationrequest where MIV_INSTCODE = '$instcode' and MIV_VISITCODE = '$currentvisitcode' AND  MIV_CATEGORY ='IMAGING' and MIV_STATE IN('$this->theone','$this->thetwo','$this->thefive','$this->thesix') and MIV_COMPLETE = '$this->theone'";
		return $list;
	}
	// 31 JULY 2024,  JOSEPH ADORBOE
    public function insert_labswalkin($form_key,$labrequestcode,$currentvisitcode,$patientcode,$patient,$patientnumber,$gender,$age,$labscode,$labsname,$labpartnercode,$notes,$type,$category,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$currentusercode,$currentuser,$instcode) : String{		
		$one = 1;
		$scheme = 'CASH';
		$sqlstmt = ("SELECT MIV_ID FROM octopus_patients_investigationrequest where MIV_PATIENTCODE = ? AND MIV_VISITCODE = ? AND MIV_TESTCODE = ? and MIV_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $currentvisitcode);
		$st->BindParam(3, $labscode);
		$st->BindParam(4, $this->theone);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return $this->theexisted;			
			}else{

				$sqlstmt = "INSERT INTO octopus_patients_investigationrequest(MIV_CODE,MIV_DATE,MIV_DATETIME,MIV_PATIENTCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_CONSULTATIONCODE,MIV_AGE,MIV_GENDER,MIV_VISITCODE,MIV_TESTCODE,MIV_TEST,MIV_TYPE,MIV_CATEGORY,MIV_REMARK,MIV_ACTOR,MIV_ACTORCODE,MIV_INSTCODE,MIV_PAYMENTMETHOD,MIV_PAYMENTMETHODCODE,MIV_SCHEMECODE,MIV_SCHEME,MIV_REQUESTCODE,MIV_PAYMENTTYPE,MIV_TESTPARTNERCODE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $this->theday);
				$st->BindParam(3, $this->thedays);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $patient);
				$st->BindParam(7, $form_key);
				$st->BindParam(8, $age);
				$st->BindParam(9, $gender);
				$st->BindParam(10, $currentvisitcode);
				$st->BindParam(11, $labscode);
				$st->BindParam(12, $labsname);
				$st->BindParam(13, $type);
				$st->BindParam(14, $category);
				$st->BindParam(15, $notes);
				$st->BindParam(16, $currentuser);
				$st->BindParam(17, $currentusercode);
				$st->BindParam(18, $instcode);
				$st->BindParam(19, $cashpaymentmethod);
				$st->BindParam(20, $cashpaymentmethodcode);
				$st->BindParam(21, $cashschemecode);
				$st->BindParam(22, $scheme);
				$st->BindParam(23, $labrequestcode);
				$st->BindParam(24, $this->theone);
				$st->BindParam(25, $labpartnercode);
				$exe = $st->execute();
				if($exe){
					return $this->thepassed ;						
				}else{						
					return $this->thefailed;						
				}	
			}
		}else{
			return $this->thefailed;
		}	
	}
	// 31 JULY 2024 JOSEPH ADORBOE
	public function getwalkininvestigationslabs( String $currentvisitcode, String $instcode) : String {
		$list = "SELECT * from octopus_patients_investigationrequest where MIV_INSTCODE = '$instcode' and MIV_VISITCODE = '$currentvisitcode' AND  MIV_CATEGORY ='LABS' and MIV_STATE IN('$this->theone','$this->thetwo','$this->thefive','$this->thesix') and MIV_COMPLETE = '$this->theone'";
		return $list;
	}
	// 26 JUNE 2024
	public function updateinvestigationsattachedremoved($ekey,$currentuser,$currentusercode,$instcode){
		$na = '';
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_ATTACHED = ? , MIV_RESULTDATE = ?, MIV_RESULTACTOR = ?, MIV_RESULTACTORCODE = ?, MIV_STATE = ?, MIV_ATTACHEDFILE = ?, MIV_COMPLETE = ? WHERE MIV_CODE = ? AND MIV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->theone);
		$st->BindParam(2, $this->thedays);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $this->thesix);
		$st->BindParam(6, $na);
		$st->BindParam(7, $this->theone);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $instcode);
		$ups = $st->Execute();	
		if($ups){			
			return $this->thepassed ;						
		}else{						
			return $this->thefailed;						
		}
	}
	// 15 JUNE 2024, JOSEPH ADORBOE
	public function getqueryinvestigationsattached( String $instcode) : String{
		$list = ("SELECT * from octopus_patients_investigationrequest WHERE MIV_INSTCODE = '$instcode' AND  MIV_STATUS != '$this->thezero' AND MIV_ATTACHED = '$this->thetwo' group by MIV_VISITCODE order by DATE(MIV_RESULTDATE) DESC LIMIT 50");
		return $list;
	}
	// 18 JUNE 2024,, JOSEPH ADORBOE
	public function investigationslist( String $visitcode, String $instcode) : String{
		$list = ("SELECT * FROM octopus_patients_investigationrequest WHERE MIV_INSTCODE = '$instcode' AND MIV_VISITCODE ='$visitcode' AND MIV_STATUS != '$this->thezero' ORDER BY MIV_ATTACHED DESC ");										
		return $list;
	}
	// 18 JUNE 2024,  JOSEPH ADORBOE
	public function getinvestigation( String $code, String $instcode) : String{
		$sqlstmt = ("SELECT MIV_PATIENTNUMBER,MIV_PATIENT,MIV_AGE,MIV_GENDER,MIV_PATIENTCODE,MIV_REQUESTCODE FROM octopus_patients_investigationrequest where MIV_INSTCODE = ? AND  MIV_CODE = ? LIMIT 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $code);	
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['MIV_PATIENTNUMBER'].'@'.$object['MIV_PATIENT'].'@'.$object['MIV_AGE'].'@'.$object['MIV_GENDER'].'@'.$object['MIV_PATIENTCODE'].'@'.$object['MIV_REQUESTCODE'];
				return $results;
			}else{
				return  $this->theone;
			}
		}else{
			return $this->thezero;
		}		
	}

	// 18 JUNE 2024,  JOSEPH ADORBOE
	public function getvisitcodeinvestigation(String $visitcode,String $instcode) : String {
		$sqlstmt = ("SELECT MIV_PATIENTNUMBER,MIV_PATIENT,MIV_AGE,MIV_GENDER,MIV_PATIENTCODE FROM octopus_patients_investigationrequest where MIV_INSTCODE = ? AND  MIV_VISITCODE = ? LIMIT 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $visitcode);
	//	$st->BindParam(3, $visitcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['MIV_PATIENTNUMBER'].'@'.$object['MIV_PATIENT'].'@'.$object['MIV_AGE'].'@'.$object['MIV_GENDER'].'@'.$object['MIV_PATIENTCODE'];
				return $results;
			}else{
				return  $this->theone;
			}
		}else{
			return  $this->thezero;
		}		
	}
	// 2 SEPT  2023, JOSEPH ADORBOE
	public function selectinvestigationsattachedlist( String $patientcode, String $visitcode, String $instcode) : String {
		$list = ("SELECT * FROM octopus_patients_investigationrequest WHERE MIV_ATTACHED = '$this->theone' AND MIV_INSTCODE = '$instcode' AND MIV_PATIENTCODE ='$patientcode' AND MIV_STATUS = '$this->thetwo' AND MIV_VISITCODE = '$visitcode' ");										
		return $list;
	}
	// 15 JUNE 2024, JOSEPH ADORBOE
	public function getqueryinvestigations( String $instcode) : String {
		$list = ("SELECT * from octopus_patients_investigationrequest WHERE MIV_INSTCODE = '$instcode' AND  MIV_STATUS != '$this->thezero' AND MIV_ATTACHED = '$this->theone' group by MIV_VISITCODE order by MIV_DATE DESC LIMIT 1000");
		return $list;
	}
	// 15 JUNE 2024, JOSEPH ADORBOE
	public function getquerytodayinvestigations( String $instcode) : String {
		
		$list = ("SELECT * from octopus_patients_investigationrequest where DATE(MIV_DATE) = '$this->theday'  AND MIV_INSTCODE = '$instcode' and MIV_STATUS != '$this->thezero' AND MIV_ATTACHED = '$this->theone'  GROUP BY MIV_VISITCODE DESC");
		return $list;
	}
	// 7 oct 2023 JOSEPH ADORBOE
	public function getquerypendingimaginginvestigations(String $patientcode,String $visitcode,String $instcode) : String{
		$list = ("SELECT * from octopus_patients_investigationrequest where MIV_PATIENTCODE = '$patientcode' and MIV_VISITCODE = '$visitcode' and MIV_INSTCODE = '$instcode'  AND MIV_CATEGORY = 'IMAGING'  order by MIV_STATUS DESC , MIV_ID DESC");
		return $list;
	}
	// 7 oct 2023 JOSEPH ADORBOE
	public function getqueryinvestigationsimaginghistory(String $patientcode, String $visitcode, String $instcode) : String {
		$list = ("SELECT * from octopus_patients_investigationrequest where MIV_PATIENTCODE = '$patientcode' and MIV_INSTCODE = '$instcode' AND MIV_VISITCODE != '$visitcode' AND MIV_CATEGORY = 'IMAGING' order by MIV_STATUS DESC , MIV_ID DESC limit 10");
		return $list;
	}
	// 5 oct 2023 JOSEPH ADORBOE
	public function getquerypendinginvestigations( String $patientcode, String $visitcode, String $instcode) : String{
		$list = ("SELECT * from octopus_patients_investigationrequest where MIV_PATIENTCODE = '$patientcode' and MIV_VISITCODE = '$visitcode' and MIV_INSTCODE = '$instcode' AND MIV_CATEGORY = 'LABS'  order by MIV_STATUS DESC , MIV_ID DESC");
		return $list;
	}
	// 5 oct 2023 JOSEPH ADORBOE
	public function getqueryinvestigationshistory( String $patientcode, String $visitcode, String $instcode) : String {
		$list = ("SELECT * from octopus_patients_investigationrequest where MIV_PATIENTCODE = '$patientcode' and MIV_INSTCODE = '$instcode'  AND MIV_VISITCODE != '$visitcode' AND MIV_CATEGORY = 'LABS' order by MIV_STATUS DESC , MIV_ID DESC limit 10");
		return $list;
	}
	// 3 Oct 2023 JOSEPH ADORBOE
	public function getquerylegacyinvestigation( String $patientcode, String $instcode) : String {
		$list = ("SELECT * from octopus_patients_investigationrequest where MIV_PATIENTCODE = '$patientcode'  and MIV_INSTCODE = '$instcode' and MIV_STATUS != '$this->thezero' order by MIV_ID DESC ");
		return $list;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicebasketinvestigations( String $patientcode, String $visitcode, String $instcode) : String {
		$list = ("SELECT * from octopus_patients_investigationrequest where MIV_PATIENTCODE = '$patientcode' and MIV_VISITCODE = '$visitcode' and MIV_INSTCODE = '$instcode' and MIV_STATUS != '$this->thezero' order by MIV_ID DESC");
		return $list;
	}
	// 2 Oct 2023 JOSEPH ADORBOE
	public function getquerydetailinvestigations( String $patientcode, String $instcode) : String {
		$list = ("SELECT * from octopus_patients_investigationrequest where MIV_ATTACHED = '$this->theone' and MIV_INSTCODE = '$instcode' and MIV_PATIENTCODE = '$patientcode' and MIV_STATE = '$this->theone'");
		return $list;
	}
	// 01 NOV 2022 JOSEPH ADORBOE
	public function cancellconsutlationinvestigations( String $visitcode, String $cancelreason, String $currentusercode, String $currentuser, String $instcode) : String {
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATUS = ?, MIV_RETURNACTORCODE = ?, MIV_RETURNACTOR = ?, MIV_RETURNTIME = ?, MIV_RETURNREASON = ? , MIV_STATE = ?,  MIV_COMPLETE = ? WHERE MIV_VISITCODE = ?  AND MIV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thezero);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $this->thedays);
		$st->BindParam(5, $cancelreason);
		$st->BindParam(6, $this->thezero);
		$st->BindParam(7, $this->thezero);
		$st->BindParam(8, $visitcode);
		$st->BindParam(9, $instcode);
	//	$st->BindParam(10, $instcode);			
		$exe = $st->execute();							
		if($exe){								
			return $this->thetwo;								
		}else{								
			return $this->thezero;								
		}	
	}
	// 01 NOV 2022 JOSEPH ADORBOE
	public function update_removepatientlabs( String $ekey, String $cancelreason, String $currentusercode, String $currentuser, String $instcode)  : String {
		$zero = '$this->thezero';
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATUS = ?, MIV_RETURNACTORCODE = ?, MIV_RETURNACTOR = ?, MIV_RETURNTIME = ?, MIV_RETURNREASON = ?  WHERE MIV_CODE = ?  AND MIV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thezero);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $this->thedays);
		$st->BindParam(5, $cancelreason);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);			
		$exe = $st->execute();							
		if($exe){								
			return $this->thetwo;								
		}else{								
			return $this->thezero;								
		}	
	}
	// 6 OCT 2023
	public function update_patientlabs($ekey,$labscode,$labsname,$notes,$currentusercode,$currentuser,$instcode) : String {
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_DATE = ?, MIV_DATETIME = ?,  MIV_TESTCODE = ?, MIV_TEST =? , MIV_REMARK =?, MIV_ACTORCODE =?, MIV_ACTOR =?  WHERE MIV_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->theday);
		$st->BindParam(2, $this->thedays);
		$st->BindParam(3, $labscode);
		$st->BindParam(4, $labsname);
		$st->BindParam(5, $notes);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $ekey);
		$exe = $st->execute();							
		if($exe){								
			return $this->thetwo;								
		}else{								
			return $this->thezero;								
		}	
	}	
	// 6 oct 2023,   JOSEPH ADORBOE
    public function insert_patientlabs($form_key,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labscode,$labsname,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$labpartnercode,$plan) : String{
		
		$mt = 1;
		$sqlstmt = ("SELECT MIV_ID FROM octopus_patients_investigationrequest where MIV_PATIENTCODE = ? AND MIV_VISITCODE = ? AND MIV_TESTCODE = ? and MIV_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $labscode);
		$st->BindParam(4, $this->theone);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return $this->theexisted;			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_investigationrequest(MIV_CODE,MIV_DATE,MIV_DATETIME,MIV_PATIENTCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_CONSULTATIONCODE,MIV_AGE,MIV_GENDER,MIV_VISITCODE,MIV_TESTCODE,MIV_TEST,MIV_TYPE,MIV_CATEGORY,MIV_REMARK,MIV_ACTOR,MIV_ACTORCODE,MIV_INSTCODE,MIV_PAYMENTMETHOD,MIV_PAYMENTMETHODCODE,MIV_SCHEMECODE,MIV_SCHEME,MIV_REQUESTCODE,MIV_PAYMENTTYPE,MIV_TESTPARTNERCODE,MIV_BILLERCODE,MIV_BILLER,MIV_PLAN) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $this->theday);
				$st->BindParam(3, $this->thedays);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $patient);
				$st->BindParam(7, $consultationcode);
				$st->BindParam(8, $age);
				$st->BindParam(9, $gender);
				$st->BindParam(10, $visitcode);
				$st->BindParam(11, $labscode);
				$st->BindParam(12, $labsname);
				$st->BindParam(13, $type);
				$st->BindParam(14, $cate);
				$st->BindParam(15, $notes);
				$st->BindParam(16, $currentuser);
				$st->BindParam(17, $currentusercode);
				$st->BindParam(18, $instcode);
				$st->BindParam(19, $paymentmethod);
				$st->BindParam(20, $paymentmethodcode);
				$st->BindParam(21, $schemecode);
				$st->BindParam(22, $scheme);
				$st->BindParam(23, $labrequestcode);
				$st->BindParam(24, $consultationpaymenttype);
				$st->BindParam(25, $labpartnercode);
				$st->BindParam(26, $currentusercode);
				$st->BindParam(27, $currentuser);
				$st->BindParam(28, $plan);
				$exe = $st->execute();										
						if($exe){								
							return $this->thetwo;								
						}else{								
							return $this->thezero;								
						}
					}									
					
				}else{
					return  $this->thezero ;
				}	
	}
	
	
	// 11 SEPT 2021 JOSEPH ADORBOE 
	public function getpatientinvestigationrequest($patientcode,$instcode) : String {
		$nut = 1;
		$sqlstmt = ("SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_PATIENTCODE = ? AND MIV_INSTCODE = ? AND MIV_COMPLETE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $this->theone);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				return  $this->thetwo ;
			}else{
				return $this->theone ;
			}
		}else{
			return  $this->thezero ;
		}
			
	}	
	// 11 SEPT 2023 , 06 MAR 2022 JOSEPH ADORBOE
	public function updatepartnerpaymentsinvestigations($ekey,$instcode) : String {
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_PARTNERSET = ? WHERE MIV_BATCHCODE = ? and MIV_PARTNERSET = ? and  MIV_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thetwo);
		$st->BindParam(2, $ekey);
		$st->BindParam(3, $this->theone);
		$st->BindParam(4, $instcode);
		$exe = $st->execute();		
		if($exe){		
			return $this->thepassed ;						
		}else{						
			return $this->thefailed;						
		}
	}
	// 3 SEPT  2023
	public function dischagerinvestigations($patientcode,$visitcode,$instcode) : Int {
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_CONSULTATIONSTATE = ? WHERE MIV_VISITCODE = ? and MIV_PATIENTCODE = ? AND MIV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->theone);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $instcode);
		$ups = $st->Execute();	
		if($ups){			
			return $this->thepassed ;						
		}else{						
			return $this->thefailed;						
		}
	}
	// 2 SEPT  2023
	public function updateinvestigationsattached($requestcode,$filenames,$currentuser,$currentusercode,$instcode) : Int {
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_ATTACHED = ? , MIV_RESULTDATE = ?, MIV_RESULTACTOR = ?, MIV_RESULTACTORCODE = ?, MIV_STATE = ?, MIV_ATTACHEDFILE = ?, MIV_COMPLETE = ? WHERE MIV_REQUESTCODE = ? AND MIV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thetwo);
		$st->BindParam(2, $this->thedays);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $this->theseven);
		$st->BindParam(6, $filenames);
		$st->BindParam(7, $this->thetwo);
		$st->BindParam(8, $requestcode);
		$st->BindParam(9, $instcode);
		$ups = $st->Execute();	
		if($ups){			
			return $this->thepassed ;						
		}else{						
			return $this->thefailed;						
		}
	}
	// 29 AUG 2023
	public function selectedshowinvestigation($selected,$patientcode,$visitcode,$unselected,$instcode): Int {
		$sqllabs = "UPDATE octopus_patients_investigationrequest SET MIV_STATUS = ? , MIV_SELECTED = ? WHERE MIV_VISITCODE = ? and MIV_SELECTED = ? AND MIV_INSTCODE = ? AND MIV_PATIENTCODE =?";
		$st = $this->db->prepare($sqllabs);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $selected);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $unselected);
		$st->BindParam(5, $instcode);
		$st->BindParam(6, $patientcode);                                     
		$selectitem = $st->Execute();								
		if($selectitem){						
			return $this->thepassed ;						
		}else{						
			return $this->thefailed;						
		}
	}
	// 29 AUG 2023
	public function selectedpaidinvestigation($selected,$paid,$patientcode,$visitcode,$unselected,$instcode) : Int {
		$sqllabs = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_STATUS = ? , MIV_SELECTED = ?  WHERE MIV_VISITCODE = ? and MIV_SELECTED = ? AND MIV_INSTCODE = ? AND MIV_PATIENTCODE =? ";
		$st = $this->db->prepare($sqllabs);
		$st->BindParam(1, $paid);
		$st->BindParam(2, $selected);
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
	// 26 AUG 2023
	public function reveresecancelinvestigation($selected,$servicecode,$visitcode,$unselected,$instcode) : Int {
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_STATUS = ?, MIV_COMPLETE = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ? AND MIV_INSTCODE = ? and MIV_SELECTED = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $selected);
		$st->BindParam(3, $selected);
		$st->BindParam(4, $servicecode);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $instcode);
		$st->BindParam(7, $unselected);
		$selectitem = $st->Execute();								
		if($selectitem){						
			return $this->thepassed ;						
		}else{						
			return $this->thefailed;						
		}
	}
	// 26 AUG 2023
	public function cancelinvestigation($selected,$servicecode,$visitcode,$unselected,$instcode) : Int {
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_STATUS = ?, MIV_COMPLETE = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ? AND MIV_INSTCODE = ? and MIV_SELECTED = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $unselected);
		$st->BindParam(2, $unselected);
		$st->BindParam(3, $unselected);
		$st->BindParam(4, $servicecode);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $instcode);
		$st->BindParam(7, $unselected);
		$selectitem = $st->Execute();								
		if($selectitem){						
			return $this->thetwo ;						
		}else{						
			return $this->thezero ;						
		}
	}
	// 25 AUG 2023
	public function sendbackinvestigation($selected,$servicecode,$visitcode,$unselected,$instcode): Int {
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ? AND MIV_INSTCODE = ? and MIV_SELECTED = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $unselected);
		$selectitem = $st->Execute();								
		if($selectitem){						
			return $this->thepassed ;						
		}else{						
			return $this->thefailed;						
		}
	}
	// 19 SEPT 2021 JOSEPH ADORBOE  transactioncode
	public function getpendinglabs($patientcode,$visitcode,$instcode): Int {        
        $rant = '$this->thezero' ;
        $sqlstmt = ("SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_PATIENTCODE = ? AND MIV_INSTCODE = ? AND MIV_VISITCODE = ? AND MIV_STATE IN('$this->theone','$this->thetwo') ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $patientcode);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $visitcode);
	    $details =	$st->execute();
        if ($details) {
            if ($st->rowcount() > 0) {				
                return $this->thepassed;
            } else {
                return $this->theexisted;
            }
        } else {
            return $this->thefailed;
        }    			
	}
	// 25 AUG 2023
	public function unselectinvestigation($selected,$servicecode,$visitcode,$unselected,$instcode) : Int {
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_SELECTED = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ? AND MIV_INSTCODE = ? and MIV_SELECTED = ?  ";
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
			return $this->thefailed;						
		}
	}
	// 25 AUG 2023
	public function selectinvestigation($selected,$servicecode,$visitcode,$unselected,$instcode): Int {
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_SELECTED = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ?  and MIV_SELECTED = ? AND MIV_INSTCODE = ? ";
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
			return $this->thefailed;						
		}
	}

	// 22 MAY 2025, JOSEPH ADORBOE 
	public function editinvestigation($ekey,$labcode,$lab,$labpartnercode,$note,$currentuser,$currentusercode,$instcode): Int {
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_TESTCODE = ? , MIV_TEST =? , MIV_REMARK = ? , MIV_ACTOR = ?, MIV_ACTORCODE = ?, MIV_TESTPARTNERCODE = ? WHERE MIV_CODE = ? AND MIV_STATE = ?  AND MIV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $labcode);
		$st->BindParam(2, $lab);
		$st->BindParam(3, $note);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $labpartnercode);
		$st->BindParam(7, $ekey);
		$st->BindParam(8, $this->theone);
		$st->BindParam(9, $instcode);
		$selectitem = $st->Execute();				
		if($selectitem){						
			return $this->thepassed ;						
		}else{						
			return $this->thefailed;						
		}
	}
	
} 

$patientsInvestigationRequesttable = new OctopusPatientsInvestigationsRequestSql();
?>