<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_billitems
	$patientbillitemtable->querygetcashprinttransactionlist($scode,$instcode);
*/

class OctopusPatientBillitemClass Extends Engine{

	// 22 JUNE 2025, JOSEPH ADORBOE
	public function querygetcashprinttransactionlist($scode,$instcode){
		$list = "SELECT B_ITEM, B_TOTAMT FROM octopus_patients_billitems WHERE B_RECIPTNUM = '$scode' AND B_STATUS = '2' AND B_INSTCODE = '$instcode' ";
		return $list;
	}


	// 19 JUNE 2025, JOSEPH ADORBOE 
	public function querygetcashtransactionsendbacklist($idvalue,$instcode,$mobilemoneypaymentmethodcode,$cashpaymentmethodcode,$prepaidcode){
		$list = "SELECT B_CODE,B_BILLCODE,B_STATE,B_COST,B_SERVCODE,B_DTIME,B_ITEM,B_TOTAMT,B_DPT,B_BILLGENERATEDCODE from octopus_patients_billitems where B_INSTCODE = '$instcode' and B_VISITCODE = '$idvalue' AND B_STATE = '1' and B_STATUS IN('1','4') and B_METHODCODE IN('$mobilemoneypaymentmethodcode','$cashpaymentmethodcode','$prepaidcode')  ";
		return $list;
	}

	// 18 JUNE 2025, JOSEPH ADORBOE 
	public function querygetcashtransactionlist($idvalue,$instcode,$mobilemoneypaymentmethodcode,$cashpaymentmethodcode,$prepaidcode){
		$list = "SELECT B_CODE,B_BILLCODE,B_STATE,B_COST,B_SERVCODE,B_DTIME,B_ITEM,B_TOTAMT,B_DPT,B_BILLGENERATEDCODE from octopus_patients_billitems where B_INSTCODE = '$instcode' and B_VISITCODE = '$idvalue' and B_STATUS IN('1','4') and B_METHODCODE IN('$mobilemoneypaymentmethodcode','$cashpaymentmethodcode','$prepaidcode')  ";
		return $list;
	}

	// 27 FEB 2021 JOSEPH ADORBOE
	public function getpatienttotal($visitcode,$mobilemoneypaymentmethodcode,$cashpaymentmethodcode,$prepaidcode){
		$rty = 2;
		$sql = ("SELECT SUM(B_TOTAMT) FROM octopus_patients_billitems where B_VISITCODE = ? and B_STATE = ? AND B_METHODCODE IN('$mobilemoneypaymentmethodcode','$cashpaymentmethodcode','$prepaidcode')");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $this->thetwo);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUM(B_TOTAMT)'];
				return $results;
			}else{
				return $this->thefailed;
			}
		}else{
			return '-1';
		}
		
	}

	// 23 APR 2025, JOSEPH ADORBOE 
	public function processpatientagegendercontact($instcode){
		$one = 1;
		$two = 2;
		$results = intval(0);
		$patientlist = array();
		// Select the list of the patient with null age
		$day = '2025-04-22';
		$sqlstmt = ("SELECT B_PATIENTCODE, B_DT FROM octopus_patients_billitems where B_AGE IS NULL AND B_INSTCODE = '$instcode' AND B_DT > '$day' LIMIT 10");
		$getcashiertransaction = $this->db->query($sqlstmt);
		while ($row = $getcashiertransaction->fetch(PDO::FETCH_ASSOC)){	
			$patientlist[] = $row;
		}
		foreach($patientlist as $patienttrans){
			$patientcode = $patienttrans['B_PATIENTCODE'];
			$transactiondate = $patienttrans['B_DT'];
			// Select patient details with null age
			$sqlstmts = ("SELECT PATIENT_DOB,PATIENT_GENDER,PATIENT_PHONENUMBER,PATIENT_ALTPHONENUMBER FROM octopus_patients where PATIENT_CODE = ? and PATIENT_INSTCODE = ? ");
			$st = $this->db->prepare($sqlstmts);
			$st->BindParam(1, $patientcode);
			$st->BindParam(2, $instcode);
			$details =	$st->execute();
			if($details){
				if($st->rowcount() > 0){
					$object = $st->fetch(PDO::FETCH_ASSOC);
					$results = $object['PATIENT_DOB'].'@'.$object['PATIENT_GENDER'].'@'.$object['PATIENT_PHONENUMBER'].'@'.$object['PATIENT_ALTPHONENUMBER'];				
				}
			}
			if($results !== intval(0)){
				$re = explode('@', $results);
				$dob = $re[0];
				$gender = $re[1];
				$phone =$re[2];
				$altphone = $re[3];
				$contact = $phone .' '.$altphone;
				$age = 0;
				$yearOnly1 = date('Y', strtotime($dob));
				$yearOnly2 = date('Y', strtotime($transactiondate));		
				$monthOnly1 = date('m', strtotime($dob));
				$monthOnly2 = date('m', strtotime($transactiondate));
				$dayOnly1 = date('d', strtotime($dob));
				$dayOnly2 = date('d', strtotime($transactiondate));
				$yearOnly = $yearOnly2 - $yearOnly1;
				$monthOnly = $monthOnly2 - $monthOnly1;
				$dayOnly = $dayOnly2 - $dayOnly1;
				$yeartype = 'Years';
				$monthtype = 'Months';
				if($yearOnly >intval(0)){
					if($monthOnly < 1){
						$theage = $yearOnly - 1;
						$age = $theage.' '.$yeartype;
					}elseif($monthOnly> 0 ){
						$age = $yearOnly.' '.$yeartype ;
					}else if($monthOnly == '0'){
						$age = $yearOnly.' '.$yeartype ;
					}
				}else{
					$age = $monthOnly.' '.$monthtype;
				}
				$sql = "UPDATE octopus_patients_billitems SET B_AGE = ? ,B_GENDER =? , B_CONTACT = ? WHERE B_PATIENTCODE = ? AND  B_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $age);
				$st->BindParam(2, $gender);
				$st->BindParam(3, $contact);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $instcode);
				$selectitem = $st->Execute();
			}
			
		}
		
	}
	// 21 APR 2025, JOSEPH ADORBOE 
	public function queryreceiptitems($visitcode,$idvalue,$instcode){
		$list =  ("SELECT B_ITEM,B_TOTAMT from octopus_patients_billitems where B_VISITCODE = '$visitcode' and B_STATUS IN('2','4','6') and B_RECIPTNUM = '$idvalue' and B_INSTCODE = '$instcode' ");
		return $list;
	}
	// 21 APR 2025, JOSEPH ADORBOE 
	public function querycashtransactionlist($cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$chequescode,$creditcode,$prepaidcode,$instcode){
		$list =  ("SELECT DISTINCT B_VISITCODE,B_DT,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE,B_BILLCODE,B_PAYMENTTYPE, B_AGE, B_GENDER , B_CONTACT from octopus_patients_billitems where B_STATUS IN('1','4') and B_METHODCODE IN('$cashpaymentmethodcode','$mobilemoneypaymentmethodcode','$chequescode','$creditcode','$prepaidcode') and B_INSTCODE = '$instcode' AND (  B_TOTAMT > '0' OR B_TOTAMT = '-1')   order by B_DT DESC ");
		return $list;
	}
	// 21 APR 2025, JOSEPH ADORBOE 
	public function dashboardtransaction($cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$instcode){
		$list = ("SELECT DISTINCT B_VISITCODE,B_DT,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE,B_BILLCODE from octopus_patients_billitems where B_STATUS ='1' and B_INSTCODE = '$instcode' AND B_METHODCODE IN('$cashpaymentmethodcode','$mobilemoneypaymentmethodcode') order by B_DT DESC LIMIT 10");
		return $list;
	}

	// 27 AUG 2023 JOSEPH ADORBOE
	public function unselectbillingitemsdetails($idvalue,$instcode){
		$list = ("SELECT * from octopus_patients_billitems where B_INSTCODE = '$instcode' and B_VISITCODE = '$idvalue' and B_STATUS IN('1','4','7') and B_STATE IN('1','7')  ");
		return $list;
	}
	// 29 NOV 2024, 7 SEPT 2023 JOSEPH ADORBOE
	public function selectnoncashbillingitemsprocessed($privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$instcode){
		$list = ("SELECT DISTINCT B_VISITCODE,B_DT,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE,B_BILLCODE,B_PAYMENTTYPE,B_PLAN,B_AGE,B_GENDER,B_CONTACT FROM octopus_patients_billitems WHERE B_STATUS IN('2') AND B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode') AND B_PREFORMED IN('0','1') AND B_INSTCODE = '$instcode' ORDER BY B_DT DESC LIMIT 50");
		return $list;
	}
	// 29 NOV 2024, JOSEPH ADORBOE 
	public function updatepatientbillingcontact($patientcode,$patientage,$patientgender,$patientcontact,$patientemail,$visitcode,$instcode){	
		$sql = "UPDATE octopus_patients_billitems SET B_AGE = ? ,B_GENDER =? , B_CONTACT = ?, B_EMAIL = ? WHERE B_PATIENTCODE = ? AND  B_INSTCODE = ? AND B_VISITCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientage);
		$st->BindParam(2, $patientgender);
		$st->BindParam(3, $patientcontact);
		$st->BindParam(4, $patientemail);
		$st->BindParam(5, $patientcode);
		$st->BindParam(6, $instcode);
		$st->BindParam(7, $visitcode);
		$selectitem = $st->Execute();	
		if($selectitem){
			return '2';
		}else{
			return '0';
		}		
	}	

	// 5 JAN 2024, 05 FEB 2023 JOSEPH ADORBOE 
	public function getcloseclaims($claimscodes,$visitcode,$instcode){
		$one = 1;
		$two = 2;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CLAIMSCODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_PREFORMED = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $claimscodes);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $one);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{               
                return '2' ;                
            }		
		}
	}
	// 22 AUG 2023 JOSEPH ADORBOE
	public function selectnoncashbillingitemsdetails($idvalue,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$instcode){
		$list = ("SELECT * from octopus_patients_billitems where B_INSTCODE = '$instcode' and B_VISITCODE = '$idvalue' and B_STATUS IN('1','4','7') and B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode') ");
		return $list;
	}
	// 22 AUG 2023 JOSEPH ADORBOE
	public function selectnoncashbillingitems($privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$instcode){
		$list = ("SELECT DISTINCT B_VISITCODE,B_DT,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE,B_BILLCODE,B_PAYMENTTYPE,B_PLAN,B_AGE,B_GENDER,B_CONTACT from octopus_patients_billitems where B_STATUS IN('1','4') and B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode') and B_INSTCODE = '$instcode' AND (B_TOTAMT > '0' OR B_TOTAMT = '-1')   order by B_DT DESC  LIMIT 50");
		return $list;
	}

	// 5 JAN 2024, JOSEPH ADORBOE 
	public function updateperformedbillingitems($bcode,$days,$visitcode,$instcode){	
		$two = 2;		
		$one = 1;
		$sql = "UPDATE octopus_patients_billitems SET B_PREFORMED = ? ,B_CLAIMSDATE =? WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND  B_PREFORMED = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $days);
		$st->BindParam(3, $bcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $one);
		$selectitem = $st->Execute();	
		if($selectitem){
			return '2';
		}else{
			return '0';
		}		
	}	

	// 5 JAN 2024, JOSEPH ADORBOE 
	public function queryperformedbilling($bcode,$instcode,$visitcode){
		$two = 2;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_PREFORMED = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $two);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{
				return '2';
			}
		}else{
			return '1';
		}
	}
	// 7 SEPT 2023 JOSEPH ADORBOE
	public function selectnoncashbillingitemsprocesseddetails($idvalue,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$instcode){
		$list = ("SELECT * from octopus_patients_billitems where B_INSTCODE = '$instcode' and B_VISITCODE = '$idvalue' and B_STATUS IN('2') and B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode') ");
		return $list;
	}

	// 25 oct 2023 JOSEPH ADORBOE 
	public function updatebilleritems($servicerequestedcode,$currentuser,$currentusercode,$visitcode,$instcode){			
		$sql = "UPDATE octopus_patients_billitems SET B_BILLER = ? , B_BILLERCODE = ?  WHERE B_VISITCODE = ? AND B_ITEMCODE = ? AND B_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $currentuser);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $servicerequestedcode);
		$st->BindParam(5, $instcode);
		$selectitem = $st->Execute();
		if($selectitem){
			return '2';
		}else{
			return '0';
		}		
	}	

	// 23 NOV 2023, 16 JULY 2021 JOSEPH ADORBOE	  
	public function sendprocedureforpayment($billingcode,$visitcode,$bcode,$billcode,$day,$days,$patientcode,$patientnumber,$patient,$servicescode,$serviceitem,$paymentmethodcode,$paymentmethod,$paymentschemecode,$paymentscheme,$cost,$depts,$patientpaymenttype,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode,$currentday,$currentmonth,$currentyear,$billercode,$biller)
	{
		$one = 1 ;
		$sql = ("INSERT INTO octopus_patients_billitems (B_CODE,B_VISITCODE,B_SERVCODE,B_BILLCODE,B_DT,B_DTIME,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_METHODCODE,B_METHOD,B_PAYSCHEMECODE,B_PAYSCHEME,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_INSTCODE,B_DPT,B_ACTORCODE,B_ACTOR,B_SHIFTCODE,B_SHIFT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_BILLERCODE,B_BILLER) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $billingcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $bcode);
		$st->BindParam(4, $billcode);
		$st->BindParam(5, $day);
		$st->BindParam(6, $days);
		$st->BindParam(7, $patientcode);
		$st->BindParam(8, $patientnumber);
		$st->BindParam(9, $patient);
		$st->BindParam(10, $serviceitem);
		$st->BindParam(11, $servicescode);
		$st->BindParam(12, $paymentmethodcode);
		$st->BindParam(13, $paymentmethod);
		$st->BindParam(14, $paymentschemecode);
		$st->BindParam(15, $paymentscheme);
		$st->BindParam(16, $one);
		$st->BindParam(17, $cost);
		$st->BindParam(18, $cost);
		$st->BindParam(19, $cost);
		$st->BindParam(20, $instcode);
		$st->BindParam(21, $depts);
		$st->BindParam(22, $currentusercode);
		$st->BindParam(23, $currentuser);
		$st->BindParam(24, $currentshiftcode);
		$st->BindParam(25, $currentshift);
		$st->BindParam(26, $patientpaymenttype);	
		$st->BindParam(27, $currentday);
		$st->BindParam(28, $currentmonth);
		$st->BindParam(29, $currentyear);
		$st->BindParam(30, $billercode);	
		$st->BindParam(31, $biller);	
		$exedd = $st->execute();
		if($exedd){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}	

	// 9 AUG 2023
	public function newbillingmedicalreport($form_key,$days,$visitcode,$patientcode,$patientnumber,$patient,$servicereqcode,$servicereqname,$serviceamount,$servicebillcode,$cashpaymentmethodcode,$cashschemecode,$currentshiftcode,$currentshift,$currentusercode,$currentday,$currentmonth,$currentyear,$currentuser,$instcode){
		$one = 1;
		$dpt = 'MEDREPORTS';
		$cash = 'CASH';
		$sqlstmtbillsitems = "INSERT INTO octopus_patients_billitems(B_CODE,B_VISITCODE,B_BILLCODE,B_DT,B_DTIME,
	B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE
	,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_ACTOR,B_ACTORCODE,B_INSTCODE,B_SHIFTCODE,B_SHIFT,B_SERVCODE,B_DPT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_STATUS,B_BILLERCODE,B_BILLER) 
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmtbillsitems);
		$st->BindParam(1, $servicebillcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $servicebillcode);
		$st->BindParam(4, $days);
		$st->BindParam(5, $days);
		$st->BindParam(6, $patientcode);
		$st->BindParam(7, $patientnumber);
		$st->BindParam(8, $patient);
		$st->BindParam(9, $servicereqname);
		$st->BindParam(10, $servicereqcode);
		$st->BindParam(11, $cashschemecode);
		$st->BindParam(12, $cash);
		$st->BindParam(13, $cash);
		$st->BindParam(14, $cashpaymentmethodcode);
		$st->BindParam(15, $one);
		$st->BindParam(16, $serviceamount);
		$st->BindParam(17, $serviceamount);
		$st->BindParam(18, $serviceamount);
		$st->BindParam(19, $currentuser);
		$st->BindParam(20, $currentusercode);
		$st->BindParam(21, $instcode);
		$st->BindParam(22, $currentshiftcode);
		$st->BindParam(23, $currentshift);
		$st->BindParam(24, $form_key);
		$st->BindParam(25, $dpt);
		$st->BindParam(26, $one);
		$st->BindParam(27, $currentday);
		$st->BindParam(28, $currentmonth);
		$st->BindParam(29, $currentyear);
		$st->BindParam(30, $one);
		$st->BindParam(31, $currentusercode);
		$st->BindParam(32, $currentuser);
		$exedd = $st->execute();
		if($exedd){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}

	// 17 oct 2023, 29 MAR 2022 ,JOSEPH ADORBOE
    public function insertpatientwounddressingbilling($form_key,$days,$visitcode,$patientcode,$patientnumber,$patient,$woundservicecode,$woundservicename,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$serviceamount,$currentusercode,$currentuser,$instcode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear){
				
			$rtn = 1;
			$billingitemcode = md5(microtime());
			$dpt = 'SERVICES';
			$seven = 7;
			$cardnumber = 'NA';
			$day = date('Y-m-d');
			$sqlstmtbillsitems = "INSERT INTO octopus_patients_billitems(B_CODE,B_VISITCODE,B_BILLCODE,B_DT,B_DTIME,
			B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE
			,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_ACTOR,B_ACTORCODE,B_INSTCODE,B_SHIFTCODE,B_SHIFT,B_SERVCODE,B_DPT,B_PAYMENTTYPE,B_CARDNUMBER,B_EXPIRYDATE,B_DAY,B_MONTH,B_YEAR) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmtbillsitems);   
			$st->BindParam(1, $billingitemcode);
			$st->BindParam(2, $visitcode);
			$st->BindParam(3, $form_key);
			$st->BindParam(4, $days);
			$st->BindParam(5, $days);
			$st->BindParam(6, $patientcode);
			$st->BindParam(7, $patientnumber);
			$st->BindParam(8, $patient);
			$st->BindParam(9, $woundservicename);
			$st->BindParam(10, $woundservicecode);
			$st->BindParam(11, $schemecode);
			$st->BindParam(12, $scheme);
			$st->BindParam(13, $paymentmethod);
			$st->BindParam(14, $paymentmethodcode);
			$st->BindParam(15, $rtn);
			$st->BindParam(16, $serviceamount);
			$st->BindParam(17, $serviceamount);
			$st->BindParam(18, $serviceamount);
			$st->BindParam(19, $currentuser);
			$st->BindParam(20, $currentusercode);
			$st->BindParam(21, $instcode);
			$st->BindParam(22, $currentshiftcode);
			$st->BindParam(23, $currentshift);
			$st->BindParam(24, $form_key);
			$st->BindParam(25, $dpt);
			$st->BindParam(26, $seven);
			$st->BindParam(27, $cardnumber);
			$st->BindParam(28, $day);
			$st->BindParam(29, $currentday);
			$st->BindParam(30, $currentmonth);
			$st->BindParam(31, $currentyear);
			$exedd = $st->execute();
			if($exedd){								
				return '2';								
			}else{								
				return '0';								
			}		
	}

	// 18 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientclaims($claincode,$clainnumber,$patientcode,$visitcode,$patientservicecode,$patientschemecode,$instcode){
		$one  = 1;
		$zero  = '0';
		$sql = "UPDATE octopus_patients_billitems SET B_PREFORMED = ?, B_CLAIMSCODE = ? ,B_CLAIMSNUMBER = ?  WHERE B_PATIENTCODE  = ? AND B_VISITCODE = ?  AND  B_ITEMCODE = ? AND B_PAYSCHEMECODE = ? AND B_PREFORMED = ? AND B_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $claincode);
		$st->BindParam(3, $clainnumber);
		$st->BindParam(4, $patientcode);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $patientservicecode);
		$st->BindParam(7, $patientschemecode);
		$st->BindParam(8, $zero);
		$st->BindParam(9, $instcode);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	// 7 SEPT 2023 JOSEPH ADORBOE
	public function querypaymentitemstransactions($visitcode,$idvalue,$instcode){
		$list = ("SELECT * from octopus_patients_billitems where B_VISITCODE = '$visitcode' and B_STATUS IN('2','4','6') and B_RECIPTNUM = '$idvalue' AND B_INSTCODE = '$instcode' ");
		return $list;
	}

	// 18 SEPT 2023, 18 AUG 2023 JOSEPH ADORBOE
	public function servicebilling($patientcode,$patientnumber,$patient,$visitcode,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$paymenttype,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$billingcode,$currentday,$currentmonth,$currentyear,$plan){
		
		$one = 1;
		$dpt = 'SERVICES';
		$sqlstmtbillsitems = "INSERT INTO octopus_patients_billitems(B_CODE,B_VISITCODE,B_BILLCODE,B_DT,B_DTIME,
		B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE
		,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_ACTOR,B_ACTORCODE,B_INSTCODE,B_SHIFTCODE,B_SHIFT,B_SERVCODE,B_DPT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_PLAN) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmtbillsitems);
		$st->BindParam(1, $servicebillcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $billingcode);
		$st->BindParam(4, $days);
		$st->BindParam(5, $days);
		$st->BindParam(6, $patientcode);
		$st->BindParam(7, $patientnumber);
		$st->BindParam(8, $patient);
		$st->BindParam(9, $servicerbs);
		$st->BindParam(10, $servicerbscode);
		$st->BindParam(11, $patientschemecode);
		$st->BindParam(12, $patientscheme);
		$st->BindParam(13, $paymentmethod);
		$st->BindParam(14, $paymentmethodcode);
		$st->BindParam(15, $one);
		$st->BindParam(16, $rbsserviceamount);
		$st->BindParam(17, $rbsserviceamount);
		$st->BindParam(18, $rbsserviceamount);
		$st->BindParam(19, $currentuser);
		$st->BindParam(20, $currentusercode);
		$st->BindParam(21, $instcode);
		$st->BindParam(22, $currentshiftcode);
		$st->BindParam(23, $currentshift);
		$st->BindParam(24, $servicerequestcode);
		$st->BindParam(25, $dpt);
		$st->BindParam(26, $paymenttype);
		$st->BindParam(27, $currentday);
		$st->BindParam(28, $currentmonth);
		$st->BindParam(29, $currentyear);
		$st->BindParam(30, $plan);
		$exedx = $st->execute();		
		if($exedx){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 13 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientbillitemssendback($ekey,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$paymentplan,$serviceamount,$currentusercode,$currentuser,$instcode){
		$one  = 1;
		$seven  = 7;
		$sqlstmt = "UPDATE octopus_patients_billitems SET B_ITEMCODE = ?, B_ITEM =?, B_PAYSCHEMECODE = ?, B_PAYSCHEME = ?, B_PLAN = ?, B_METHOD = ?, B_METHODCODE = ?, B_COST =?, B_TOTAMT = ?, B_CASHAMT =? ,  B_ACTOR = ?, B_ACTORCODE = ? , B_STATUS = ? , B_STATE = ? WHERE B_SERVCODE = ? AND B_INSTCODE = ? AND B_STATUS = ?";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $servicescode);
		$st->BindParam(2, $servicesname);
		$st->BindParam(3, $paymentschemecode);
		$st->BindParam(4, $paymentscheme);
		$st->BindParam(5, $paymentplan);
		$st->BindParam(6, $paymethname);
		$st->BindParam(7, $paymentmethodcode);
		$st->BindParam(8, $serviceamount);
		$st->BindParam(9, $serviceamount);
		$st->BindParam(10, $serviceamount);
		$st->BindParam(11, $currentuser);
		$st->BindParam(12, $currentusercode);
		$st->BindParam(13, $one);
		$st->BindParam(14, $one);
		$st->BindParam(15, $ekey);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $seven);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	// 7 SEPT 2023, 27 FEB 2021 JOSEPH ADORBOE
	public function getpatientprocessedinsurancetotal($visitcode,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode){
		$three = 3;
		$sql = ("SELECT SUM(B_TOTAMT) FROM octopus_patients_billitems where B_VISITCODE = ? and B_STATE = ? AND B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode')");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $three);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUM(B_TOTAMT)'];
				return $results;
			}else{
				return '0';
			}
		}else{
			return '-1';
		}		
	}
	// 7 SEPT 2023,  JOSEPH ADORBOE 
	public function getpatientnoncashtransactionprocesseddetails($idvalue,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode){
		$sqlstmt = ("SELECT DISTINCT B_VISITCODE,B_DT,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_DPT,B_BILLCODE,B_METHOD,B_METHODCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_SHIFTCODE,B_SHIFT FROM octopus_patients_billitems where B_VISITCODE = ? and B_STATUS IN('2') and B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode') ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['B_VISITCODE'].'@'.$object['B_DT'].'@'.$object['B_PATIENTCODE'].'@'.$object['B_PATIENTNUMBER'].'@'.$object['B_PATIENT'].'@'.$object['B_DPT'].'@'.$object['B_BILLCODE'].'@'.$object['B_METHOD'].'@'.$object['B_PAYSCHEME'].'@'.$object['B_PAYSCHEMECODE'].'@'.$object['B_PAYMENTTYPE'].'@'.$object['B_DAY'].'@'.$object['B_MONTH'].'@'.$object['B_YEAR'].'@'.$object['B_SHIFTCODE'].'@'.$object['B_SHIFT'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}

	// 19 JULY 2021 JOSEPH ADORBOE 
	public function getpatientinsurancetransactiondetails($idvalue,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$creditcode){
		$sqlstmt = ("SELECT DISTINCT B_VISITCODE,B_DT,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_DPT,B_BILLCODE,B_METHOD,B_METHODCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_PAYMENTTYPE FROM octopus_patients_billitems where B_VISITCODE = ? and B_STATUS IN('1','2','4') and B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode','$creditcode') ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['B_VISITCODE'].'@'.$object['B_DT'].'@'.$object['B_PATIENTCODE'].'@'.$object['B_PATIENTNUMBER'].'@'.$object['B_PATIENT'].'@'.$object['B_DPT'].'@'.$object['B_BILLCODE'].'@'.$object['B_METHOD'].'@'.$object['B_PAYSCHEME'].'@'.$object['B_PAYSCHEMECODE'].'@'.$object['B_PAYMENTTYPE'].'@'.$object['B_METHODCODE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}			
	}	
	
	// 3 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientnumberbillitems($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "UPDATE octopus_patients_billitems SET B_PATIENTNUMBER = ?, B_ACTOR = ?, B_ACTORCODE =?  where B_PATIENTCODE = ? and B_INSTCODE = ? ";
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
	// 9 AUG 2023
	public function newbilling($form_key,$patientcode,$patientnumbers,$patient,$visitcode,$days,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$servicerequestcode,$billingcode,$schemeamount,$payment,$dpt,$paymentplan,$cardnumber,$cardexpirydate,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear){
		$formkey = md5(microtime());
		$one= 1;
		$sqlstmtbillsitems = "INSERT INTO octopus_patients_billitems(B_CODE,B_VISITCODE,B_BILLCODE,B_DT,B_DTIME,
							B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE
							,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_ACTOR,B_ACTORCODE,B_INSTCODE,B_SHIFTCODE,B_SHIFT,B_SERVCODE,B_DPT,B_PAYMENTTYPE,B_CARDNUMBER,B_EXPIRYDATE,B_DAY,B_MONTH,B_YEAR,B_PLAN) 
							VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmtbillsitems);
		$st->BindParam(1, $formkey);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $billingcode);
		$st->BindParam(4, $days);
		$st->BindParam(5, $days);
		$st->BindParam(6, $patientcode);
		$st->BindParam(7, $patientnumbers);
		$st->BindParam(8, $patient);
		$st->BindParam(9, $servicesname);
		$st->BindParam(10, $servicescode);
		$st->BindParam(11, $paymentschemecode);
		$st->BindParam(12, $paymentscheme);
		$st->BindParam(13, $paymethname);
		$st->BindParam(14, $paymentmethodcode);
		$st->BindParam(15, $one);
		$st->BindParam(16, $schemeamount);
		$st->BindParam(17, $schemeamount);
		$st->BindParam(18, $schemeamount);
		$st->BindParam(19, $currentuser);
		$st->BindParam(20, $currentusercode);
		$st->BindParam(21, $instcode);
		$st->BindParam(22, $currentshiftcode);
		$st->BindParam(23, $currentshift);
		$st->BindParam(24, $servicerequestcode);
		$st->BindParam(25, $dpt);
		$st->BindParam(26, $payment);
		$st->BindParam(27, $cardnumber);
		$st->BindParam(28, $cardexpirydate);
		$st->BindParam(29, $currentday);
		$st->BindParam(30, $currentmonth);
		$st->BindParam(31, $currentyear);
		$st->BindParam(32, $paymentplan);
		$exedd = $st->execute();
		if($exedd){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 29 AUG 2023 
	public function updatebillitem($form_key,$paycode,$payname,$day,$visitcode,$currentshiftcode,$currentshift,$currentuser,$currentusercode){
		$two = 2;
		$three = 3;	
		$sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PAYDATE = ?, B_RECIPTNUM = ?, B_PAYACTOR = ?, B_PAYACTORCODE = ? , B_PAYSHIFTCODE = ? , B_PAYSHIFT = ?, B_COMPLETE = ?, B_PAYMETHODCODE = ?, B_PAYMETHOD = ? WHERE B_VISITCODE = ? AND B_STATE = ? ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $three);
		$st->BindParam(3, $day);
		$st->BindParam(4, $form_key);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $currentshiftcode);
		$st->BindParam(8, $currentshift);
		$st->BindParam(9, $two);
		$st->BindParam(10, $paycode);
		$st->BindParam(11, $payname);
		$st->BindParam(12, $visitcode);
		$st->BindParam(13, $two);
		$selectitem = $st->execute();
		if($selectitem){
			return '2';
		}else{
			return '0';
		}	
	}
	// 27 AUG 2023 JOSEPH ADORBOE 
	public function updatepaymentschemetransactions($bcode,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$paymentplan,$getprice,$total,$days,$visitcode,$currentuser,$currentusercode,$instcode){	
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_patients_billitems SET B_PAYSCHEMECODE = ? , B_PAYSCHEME = ?, B_PLAN = ?, B_DTIME = ?,  B_METHOD = ?, B_METHODCODE = ?, B_COST = ?, B_TOTAMT =? , B_CASHAMT = ? , B_ACTORCODE = ?, B_ACTOR = ?  WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_COMPLETE =?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $paymentscheme);
		$st->BindParam(3, $paymentplan);
		$st->BindParam(4, $days);
		$st->BindParam(5, $paymethname);
		$st->BindParam(6, $paymentmethodcode);
		$st->BindParam(7, $getprice);
		$st->BindParam(8, $total);
		$st->BindParam(9, $total);
		$st->BindParam(10, $currentusercode);
		$st->BindParam(11, $currentuser);
		$st->BindParam(12, $bcode);
		$st->BindParam(13, $instcode);
		$st->BindParam(14, $visitcode);
		$st->BindParam(15, $one);		
		$selectitem = $st->Execute();
		if($selectitem){
			return '2';
		}else{
			return '0';
		}	
	}
	// 27 AUG 2023, 27 FEB 2021 JOSEPH ADORBOE
	public function getpatientinsurancetotal($visitcode,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode){
		$two = 2;
		$sql = ("SELECT SUM(B_TOTAMT) FROM octopus_patients_billitems where B_VISITCODE = ? and B_STATE = ? AND B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode')");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $two);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUM(B_TOTAMT)'];
				return $results;
			}else{
				return '0';
			}
		}else{
			return '-1';
		}		
	}
	// 27 AUG 2023,  JOSEPH ADORBOE 
	public function getpatientnoncashtransactiondetails($idvalue,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode){
		$sqlstmt = ("SELECT DISTINCT B_VISITCODE,B_DT,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_DPT,B_BILLCODE,B_METHOD,B_METHODCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_SHIFTCODE,B_SHIFT, B_AGE,B_GENDER,B_CONTACT,B_EMAIL  FROM octopus_patients_billitems where B_VISITCODE = ? and B_STATUS IN('1','4','7') and B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode') ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['B_VISITCODE'].'@'.$object['B_DT'].'@'.$object['B_PATIENTCODE'].'@'.$object['B_PATIENTNUMBER'].'@'.$object['B_PATIENT'].'@'.$object['B_DPT'].'@'.$object['B_BILLCODE'].'@'.$object['B_METHOD'].'@'.$object['B_PAYSCHEME'].'@'.$object['B_PAYSCHEMECODE'].'@'.$object['B_PAYMENTTYPE'].'@'.$object['B_DAY'].'@'.$object['B_MONTH'].'@'.$object['B_YEAR'].'@'.$object['B_SHIFTCODE'].'@'.$object['B_SHIFT'].'@'.$object['B_AGE'].'@'.$object['B_GENDER'].'@'.$object['B_CONTACT'].'@'.$object['B_EMAIL'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}
	// 26 AUG 2023 JOSEPH ADORBOE 
	public function reversecancelbillingitems($bcode,$days,$currentuser,$currentusercode,$visitcode,$instcode){	
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_patients_billitems SET B_STATE = ? , B_STATUS = ?, B_COMPLETE = ?, B_REVERSEDATE = ?, B_REVERSEACTOR = ?, B_REVERSEACTORCODE = ?  WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_COMPLETE =?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $one);
		$st->BindParam(3, $one);
		$st->BindParam(4, $days);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $bcode);
		$st->BindParam(8, $instcode);
		$st->BindParam(9, $visitcode);
		$st->BindParam(10, $zero);
		$selectitem = $st->Execute();
		if($selectitem){
			return '2';
		}else{
			return '0';
		}	
	}
	// 26 AUG 2023 JOSEPH ADORBOE 
	public function cancelbillingitems($bcode,$days,$currentuser,$currentusercode,$visitcode,$instcode){
		$two = 2;
		$zero = '0';		
		
		$sql = "UPDATE octopus_patients_billitems SET B_STATE = ? , B_STATUS = ?, B_COMPLETE = ?, B_REVERSEDATE = ?, B_REVERSEACTOR = ?, B_REVERSEACTORCODE = ?  WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $days);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $bcode);
		$st->BindParam(8, $instcode);
		$st->BindParam(9, $visitcode);
		$selectitem = $st->Execute();
		if($selectitem){
			return '2';
		}else{
			return '0';
		}		
	}		
	// 26 AUG 2023 JOSEPH ADORBOE 
	public function sendbackbillingitems($bcode,$visitcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_STATE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $one);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){
				$seven = 7;				
				$sql = "UPDATE octopus_patients_billitems SET B_STATE = ?, B_STATUS = ?  WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $seven);
				$st->BindParam(2, $seven);
				$st->BindParam(3, $bcode);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $visitcode);
				$selectitem = $st->Execute();
				if($selectitem){
					return '2';
				}else{
					return '0';
				}				
							
			}else{
				return '1';	
			}
		}
	}	
	// 15 AUG 2023 JOSEPH ADORBOE 
	public function unselectbillingitems($bcode,$visitcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_STATE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $one);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{
				$nt = 2;				
				$sql = "UPDATE octopus_patients_billitems SET B_STATE = ?  WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $one);
				$st->BindParam(2, $bcode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $visitcode);
				$selectitem = $st->Execute();
				if($selectitem){
					return '2';
				}else{
					return '0';
				}	
			}
		}
	}	
	
	// 27 FEB 2021 JOSEPH ADORBOE 
	public function getpatienttransactiondetails($idvalue,$mobilemoneypaymentmethodcode,$cashpaymentmethodcode,$prepaidcode){
		$sqlstmt = ("SELECT DISTINCT B_VISITCODE,B_DT,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_DPT,B_BILLCODE,B_METHOD,B_METHODCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_SHIFTCODE,B_SHIFT FROM octopus_patients_billitems where B_VISITCODE = ? and B_STATUS IN('1','4','7') and B_METHODCODE IN('$mobilemoneypaymentmethodcode','$cashpaymentmethodcode','$prepaidcode') ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['B_VISITCODE'].'@'.$object['B_DT'].'@'.$object['B_PATIENTCODE'].'@'.$object['B_PATIENTNUMBER'].'@'.$object['B_PATIENT'].'@'.$object['B_DPT'].'@'.$object['B_BILLCODE'].'@'.$object['B_METHOD'].'@'.$object['B_PAYSCHEME'].'@'.$object['B_PAYSCHEMECODE'].'@'.$object['B_PAYMENTTYPE'].'@'.$object['B_DAY'].'@'.$object['B_MONTH'].'@'.$object['B_YEAR'].'@'.$object['B_SHIFTCODE'].'@'.$object['B_SHIFT'];
				return $results;
			}else{
				return $this->theexisted;
			}
		}else{
			return $this->thefailed;
		}			
	}	
	// 15 AUG 2023 JOSEPH ADORBOE 
	public function selectbillingitems($bcode,$visitcode,$billgeneratedcode,$instcode){
		$two = 2;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_STATE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $two);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{
				$nt = 2;				
				$sql = "UPDATE octopus_patients_billitems SET B_STATE = ? , B_BILLGENERATEDCODE = ? WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $two);
				$st->BindParam(2, $billgeneratedcode);
				$st->BindParam(3, $bcode);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $visitcode);
				$selectitem = $st->Execute();
				if($selectitem){
					return '2';
				}else{
					return '0';
				}	
			}
		}
	}			
	
} 

$patientbillitemtable = new OctopusPatientBillitemClass();
?>