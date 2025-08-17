<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 24 FEB 2025, 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	$patientselfregistrationcontroller->insert_patientselfregistration
*/

class PatientSelfRegistrationClassController Extends Engine{
	

	// 6 JAN 2021,  JOSEPH ADORBOE
    public function insert_patientselfregistration($form_key,$newpatientnumber,$patienttitle,$patientfirstname,$patientlastname,$fullname,$days,$patientbirthdate,$patientgender,$patientreligion,$patientmaritalstatus,$currentusercode,$currentuser,$instcode,$patientoccupation,$theyear,$theserial,$patientnationality,$patienthomeaddress,$patientphone,$patientaltphone,$paymentmenthodname,$paymentmethodcode,$patientemergencyone,$patientemergencytwo,$smsphone,$smsphoned,$fk,$patientemail,$patientpostal,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$paymentschemecode,$paymentschemename,$patientcardnumber,$patientcardexpirydate,$requestservices,$servicescode,$servicesname,$visitcode,$currentshiftcode,$currentshift,$servicerequestcode,$billingcode,$billingitemcode,$patientage,$amount,$newfolderamount,$billamount,$billingnewfolderitemcode,$filenamed,$newfoldercharge,$newfolderservicerequestcode,$nofiticationconsent,$payment,$discount,$discountamount,$serviceamount,$servicecharge,$currentday,$currentmonth,$currentyear,$billingcurrency,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$paymentschemeplan){
	
		$mt = 1;
		$dept = 'SERVICES';
		$sqlstmt = ("SELECT PATIENT_ID FROM octopus_patients where PATIENT_PATIENTNUMBER = ? AND PATIENT_INSTCODE = ? AND PATIENT_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newpatientnumber);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';		
		}else{		
		$sqlstmt = "INSERT INTO octopus_patients(PATIENT_CODE,PATIENT_PATIENTNUMBER,PATIENT_DATE,PATIENT_FIRSTNAME,PATIENT_LASTNAME,PATIENT_NAMES,PATIENT_TITLE,PATIENT_INSTCODE,PATIENT_DOB,PATIENT_GENDER,PATIENT_RELIGION,PATIENT_MARITAL,PATIENT_OCCUPATION,PATIENT_YEAR,PATIENT_SERIAL,PATIENT_NATIONALITY,PATIENT_HOMEADDRESS,PATIENT_PHONENUMBER,PATIENT_ALTPHONENUMBER,PATIENT_PAYMENTMETHOD,PATIENT_PAYMENTMETHODCODE,PATIENT_ACTOR,PATIENT_ACTORCODE,PATIENT_LASTVISIT,PATIENT_CONSENT,PATIENT_DAY,PATIENT_MONTH,PATIENT_YEARS,PATIENT_BILLCURRENCY) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $newpatientnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $patientfirstname);
		$st->BindParam(5, $patientlastname);
		$st->BindParam(6, $fullname);
		$st->BindParam(7, $patienttitle);
		$st->BindParam(8, $instcode);
		$st->BindParam(9, $patientbirthdate);
		$st->BindParam(10, $patientgender);
		$st->BindParam(11, $patientreligion);
		$st->BindParam(12, $patientmaritalstatus);
		$st->BindParam(13, $patientoccupation);
		$st->BindParam(14, $theyear);
		$st->BindParam(15, $theserial);
		$st->BindParam(16, $patientnationality);
		$st->BindParam(17, $patienthomeaddress);
		$st->BindParam(18, $patientphone);
		$st->BindParam(19, $patientaltphone);
		$st->BindParam(20, $paymentmenthodname);
		$st->BindParam(21, $paymentmethodcode);
		$st->BindParam(22, $currentuser);
		$st->BindParam(23, $currentusercode);
		$st->BindParam(24, $days);		
		$st->BindParam(25, $nofiticationconsent);
		$st->BindParam(26, $currentday);
		$st->BindParam(27, $currentmonth);
		$st->BindParam(28, $currentyear);
		$st->BindParam(29, $billingcurrency);		
		$exepatient = $st->execute();

		if($exepatient){

			if(!empty($patientphone)){

				$sqlstmt = ("SELECT PH_ID FROM octopus_phonebook where PH_PHONENUMBER = ? ");
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $patientphone);
				$st->execute();				
				if($st->rowcount() < 1){								
					$sqlstmt = "INSERT INTO octopus_phonebook(PH_CODE,PH_PATIENTCODE,PH_PATIENTNUMBER,PH_PATIENT,PH_PHONENUMBER,PH_SMSPHONE,PH_ACTOR,PH_ACTORCODE,PH_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $fk);
					$st->BindParam(2, $form_key);
					$st->BindParam(3, $newpatientnumber);
					$st->BindParam(4, $fullname);
					$st->BindParam(5, $patientphone);
					$st->BindParam(6, $smsphone);
					$st->BindParam(7, $currentuser);
					$st->BindParam(8, $currentusercode);
					$st->BindParam(9, $instcode);
					$exephonebook = $st->execute();
				}	
			}

			if(!empty($patientaltphone)){
				$sqlstmt = ("SELECT PH_ID FROM octopus_phonebook where PH_PHONENUMBER = ? ");
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $patientaltphone);
				$st->execute();				
				if($st->rowcount() < 1){					
					$fk = $form_key.'@@';								
				$sqlstmt = "INSERT INTO octopus_phonebook(PH_CODE,PH_PATIENTCODE,PH_PATIENTNUMBER,PH_PATIENT,PH_PHONENUMBER,PH_SMSPHONE,PH_ACTOR,PH_ACTORCODE,PH_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $fk);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $newpatientnumber);
				$st->BindParam(4, $fullname);
				$st->BindParam(5, $patientaltphone);
				$st->BindParam(6, $smsphoned);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);
				$exe = $st->execute();
				}	
			}

			$sqlstmt = "INSERT INTO octopus_patients_contacts(PC_CODE,PC_PATIENTCODE,PC_PATIENTNUMBER,PC_PATIENT,PC_DATE,PC_PHONE,PC_PHONEALT,PC_HOMEADDRESS,PC_EMAIL,PC_POSTAL,PC_EMERGENCYONE,PC_EMERGENCYTWO,PC_ACTOR,PC_ACTORCODE,PC_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $form_key);
			$st->BindParam(3, $newpatientnumber);
			$st->BindParam(4, $fullname);
			$st->BindParam(5, $days);
			$st->BindParam(6, $patientphone);
			$st->BindParam(7, $patientaltphone);
			$st->BindParam(8, $patienthomeaddress);
			$st->BindParam(9, $patientemail);
			$st->BindParam(10, $patientpostal);
			$st->BindParam(11, $patientemergencyone);
			$st->BindParam(12, $patientemergencytwo);
			$st->BindParam(13, $currentuser);
			$st->BindParam(14, $currentusercode);
			$st->BindParam(15, $instcode);			
			$exe = $st->execute();

			$sqlstmtbills = "INSERT INTO octopus_patients_bills(BILL_CODE,BILL_PATIENTCODE,BILL_PATIENTNUMBER,BILL_PATIENT,BILL_VISITCODE,BILL_DATE,BILL_AMOUNT,BILL_ACTOR,BILL_ACTORCODE,BILL_INSTCODE) 
				VALUES (?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmtbills);   
				$st->BindParam(1, $billingcode);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $newpatientnumber);
				$st->BindParam(4, $fullname);
				$st->BindParam(5, $visitcode);
				$st->BindParam(6, $days);
				$st->BindParam(7, $billamount);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$exedd = $st->execute();

			
			if($paymentmethodcode == $privateinsurancecode  || $paymentmethodcode == $nationalinsurancecode || $paymentmethodcode == $partnercompaniescode){
				$sqlstmt = "INSERT INTO octopus_patients_paymentschemes(PAY_CODE,PAY_PATIENTCODE,PAY_PATIENTNUMBER,PAY_PATIENT,PAY_DATE,PAY_PAYMENTMETHODCODE,PAY_PAYMENTMETHOD,PAY_SCHEMECODE,PAY_SCHEMENAME,PAY_ENDDT,PAY_CARDNUM,PAY_ACTOR,PAY_ACTORCODE,PAY_INSTCODE,PAY_PLAN) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $newpatientnumber);
				$st->BindParam(4, $fullname);
				$st->BindParam(5, $days);
				$st->BindParam(6, $paymentmethodcode);
				$st->BindParam(7, $paymentmenthodname);
				$st->BindParam(8, $paymentschemecode);
				$st->BindParam(9, $paymentschemename);
				$st->BindParam(10, $patientcardexpirydate);
				$st->BindParam(11, $patientcardnumber);
				$st->BindParam(12, $currentuser);
				$st->BindParam(13, $currentusercode);
				$st->BindParam(14, $instcode);
				$st->BindParam(15, $paymentschemeplan);				
				$exe = $st->execute();			
			}

				
					$rtn = $one = 1;
					$newfoldercode = 'SER0001';
					$newfolder  = 'REGISTRATION';
					$formkey = md5(microtime());
					$sqlstmtbillsitems = "INSERT INTO octopus_patients_billitems(B_CODE,B_VISITCODE,B_BILLCODE,B_DT,B_DTIME,
								B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE
								,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_ACTOR,B_ACTORCODE,B_INSTCODE,B_SHIFTCODE,B_SHIFT,B_SERVCODE,B_DPT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_PLAN) 
								VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmtbillsitems);
					$st->BindParam(1, $formkey);
					$st->BindParam(2, $visitcode);
					$st->BindParam(3, $billingcode);
					$st->BindParam(4, $days);
					$st->BindParam(5, $days);
					$st->BindParam(6, $form_key);
					$st->BindParam(7, $newpatientnumber);
					$st->BindParam(8, $fullname);
					$st->BindParam(9, $newfolder);
					$st->BindParam(10, $newfoldercode);
					$st->BindParam(11, $paymentschemecode);
					$st->BindParam(12, $paymentschemename);
					$st->BindParam(13, $paymentmenthodname);
					$st->BindParam(14, $paymentmethodcode);
					$st->BindParam(15, $rtn);
					$st->BindParam(16, $newfolderamount);
					$st->BindParam(17, $newfolderamount);
					$st->BindParam(18, $newfolderamount);
					$st->BindParam(19, $currentuser);
					$st->BindParam(20, $currentusercode);
					$st->BindParam(21, $instcode);
					$st->BindParam(22, $currentshiftcode);
					$st->BindParam(23, $currentshift);
					$st->BindParam(24, $newfolderservicerequestcode);
					$st->BindParam(25, $dept);
					$st->BindParam(26, $one);
					$st->BindParam(27, $currentday);
					$st->BindParam(28, $currentmonth);
					$st->BindParam(29, $currentyear);
					$st->BindParam(30, $paymentschemeplan);	
					$exedd = $st->execute();
					if($exedd){
					return '2';			
				}else{			
					return '0';			
				}

					
			}else{			
				return '0';			
			}
		}	
	}

	

} 
$patientselfregistrationcontroller = new PatientSelfRegistrationClassController()
?>