<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 18 FEB 20201
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class RegistrationController Extends Engine{

	
	// 28 JULY 2023 JOSEPH ADORBOE
	public function addpatientschemeplan($form_key,$paymentschemeplan){			
		$sql = "UPDATE octopus_patients_paymentschemes SET PAY_PLAN = ? WHERE PAY_PATIENTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $paymentschemeplan);
		$st->BindParam(2, $form_key);
		$exe = $st->execute();	
		if($exe){
			return '2';			
		}else{			
			return '0';			
		}
	}


	// 04 NOV 2022 JOSEPH ADORBOE
	public function updatepatienttypes($instcode){
		// $one = 1;
		// $sqlstmt = ("SELECT * FROM octopus_patients where PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND ( PATIENT_TYPE IS NULL OR PATIENT_TYPE ='' )");
		// $st = $this->db->prepare($sqlstmt);   
		// $st->BindParam(1, $instcode);
		// $st->BindParam(2, $one);
		// $st->execute();	
		
		// if($st->rowcount() > 0){
		// 	$row = $st->fetch(PDO::FETCH_ASSOC);
		// 	$patientnum = $row['PATIENT_PATIENTNUMBER'];
		// 	$patientcode = $row['PATIENT_CODE'];

		// 	for($i=0;$i<$st->rowcount();$i++){				
		// 		$pn = explode('/', $patientnum);
		// 		$type = $pn[1];
		// 		$sql = "UPDATE octopus_patients SET PATIENT_TYPE = ? WHERE PATIENT_CODE = ? AND  PATIENT_INSTCODE = ?";
		// 		$st = $this->db->prepare($sql);
		// 		$st->BindParam(1, $type);
		// 		$st->BindParam(2, $patientcode);
		// 		$st->BindParam(3, $instcode);
		// 		$exe = $st->execute();	               
		// 	}
		// //	return 1;	
		// }else{
		// 	return 0;
		// }

	}

	// 8 MAY 2024, 30 june 2021 JOSEPH ADORBOE 
	public function validatepatientnumber($instcode,$newpatientnumber,$instcodenuc,$nextnewpatientnumber){
	//	die($instcode);
		if ($instcode == $instcodenuc){
		//	return '1';
			if(!empty($newpatientnumber)){
				$pnd = explode('/', $newpatientnumber);
				$ser = $pnd[0];
				$tp = $pnd[1];
				$yp = $pnd[2];

				$nt = explode('/',$nextnewpatientnumber);
				$se = $nt[0];
				$yu = $nt[1];
				$theyear = date('Y');
				
				if(empty($ser) || empty($tp) || empty($yp)){
					return '0';
				}else{					
					if(is_numeric($ser)){						
						if($yp == $theyear){							
							if($ser == $se){
								return '2';
							}else if($ser < $se){
								return '2';
							}else{
								return '0';
								// if($tp == 'XP' || $tp == 'OG'){
								// 	if($yp == '1990' || $yp == '1991' ||$yp == '1992' ||$yp == '1993' ||$yp == '1994' ||$yp == '1995' ||$yp == '1996' ||$yp == '1997' ||$yp == '1998' ||$yp == '1999' || $yp == '2000' || $yp == '2001' || $yp == '2002' || $yp == '2003' || $yp == '2004' || $yp == '2005' || $yp == '2006' || $yp == '2007' || $yp == '2008' || $yp == '2009' || $yp == '2010' || $yp == '2011' || $yp == '2012' || $yp == '2013' || $yp == '2014' || $yp == '2015' || $yp == '2016' || $yp == '2017' || $yp == '2018' || $yp == '2019' || $yp == '2020' || $yp == '2021' || $yp == '2022' || $yp == '2023' || $yp == '2024'){
								// 			return '2';
								// 	}else{
								// 		return '0';
								// 	}
		
								// }else{
								// 	return '0';
								// }
							}
						}else if($yp < $theyear){							
							if($tp == 'XP' || $tp == 'OG' ){
								if($yp == '2000' || $yp == '2001' || $yp == '2002' || $yp == '2003' || $yp == '2004' || $yp == '2005' || $yp == '2006' || $yp == '2007' || $yp == '2008' || $yp == '2009' || $yp == '2010' || $yp == '2011' || $yp == '2012' || $yp == '2013' || $yp == '2014' || $yp == '2015' || $yp == '2016' || $yp == '2017' || $yp == '2018' || $yp == '2019' || $yp == '2020' || $yp == '2021' || $yp == '2022' || $yp == '2023'){
									return '2';
								}else{
									return '0';
								}	
							}else{
								return '0';
							}
						}else{
							return '0';
						}
					}else{
						return '0';
					}
				}
			}else{
				return '0';
			}

		}else{
			return '2';
		}

	}	

	// 03 MAY 2022 
	public function setnewphysiopatientreferal($patientcode,$servicerequestcode,$instcode){
		$three = 3;
		$one = 1;
		$sql = "UPDATE octopus_patients SET PATIENT_PHYSIO = ? WHERE PATIENT_CODE = ? AND PATIENT_PHYSIO = ? AND PATIENT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $three);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $one);
		$st->BindParam(4, $instcode);	
		$exe = $st->execute();	
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STAGE = ? WHERE REQU_CODE = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $three);
		$st->BindParam(2, $servicerequestcode);
		$st->BindParam(3, $instcode);
	//	$st->BindParam(4, $instcode);		
		$exe = $st->execute();	
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 03 MAY 2022 
	public function setnewphysiopatient($form_key,$servicerequestcode,$instcode){
		$two = 2;
		$one = 1;
		$sql = "UPDATE octopus_patients SET PATIENT_PHYSIO = ? WHERE PATIENT_CODE = ? AND PATIENT_PHYSIO = ? AND PATIENT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $form_key);
		$st->BindParam(3, $one);
		$st->BindParam(4, $instcode);		
		$exe = $st->execute();	
		
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STAGE = ? WHERE REQU_CODE = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $servicerequestcode);
		$st->BindParam(3, $instcode);
	//	$st->BindParam(4, $instcode);		
		$exe = $st->execute();

		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 21 APR  2021
	public function update_patientregistrationfile($form_key,$registratioform){
		$rt = 1;
		$sql = "UPDATE octopus_patients SET PATIENT_FORMNAME = ?, PATIENT_FORM = ? WHERE PATIENT_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $registratioform);
		$st->BindParam(2, $rt);
		$st->BindParam(3, $form_key);		
		$exe = $st->execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 25 JAN 2021
	public function update_patientfile($form_key,$finame){
		$rt = 1;
		$sql = "UPDATE octopus_patients SET PATIENT_FOLDERNAME = ?, PATIENT_FOLDERATTACHED = ? WHERE PATIENT_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $finame);
		$st->BindParam(2, $rt);
		$st->BindParam(3, $form_key);		
		$exe = $st->execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}
	

	// 6 JAN 2021,  JOSEPH ADORBOE
    public function insert_patientregistration($form_key,$newpatientnumber,$patienttitle,$patientfirstname,$patientlastname,$fullname,$days,$patientbirthdate,$patientgender,$patientreligion,$patientmaritalstatus,$currentusercode,$currentuser,$instcode,$patientoccupation,$theyear,$theserial,$patientnationality,$patienthomeaddress,$patientphone,$patientaltphone,$paymentmenthodname,$paymentmethodcode,$patientemergencyone,$patientemergencytwo,$smsphone,$smsphoned,$fk,$patientemail,$patientpostal,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$paymentschemecode,$paymentschemename,$patientcardnumber,$patientcardexpirydate,$requestservices,$servicescode,$servicesname,$visitcode,$currentshiftcode,$currentshift,$servicerequestcode,$billingcode,$billingitemcode,$patientage,$amount,$newfolderamount,$billamount,$billingnewfolderitemcode,$filenamed,$newfoldercharge,$newfolderservicerequestcode,$nofiticationconsent,$payment,$discount,$discountamount,$serviceamount,$servicecharge,$currentday,$currentmonth,$currentyear,$billingcurrency,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$paymentschemeplan){
	
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

			if($requestservices == 'YES'){

				$sqlstmt = "INSERT INTO octopus_patients_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUMBER,VISIT_PATIENT,VISIT_DATE,VISIT_SERVICECODE,VISIT_SERVICE,VISIT_PAYMENTMETHOD,VISIT_PAYMENTMETHODCODE,VISIT_PAYMENTSCHEME,VISIT_PAYMENTSCHEMECODE,VISIT_ACTOR,VISIT_ACTORCODE,VISIT_INSTCODE,VISIT_SHIFTCODE,VISIT_SHIFT,VISIT_GENDER,VISIT_AGE,VISIT_PAYMENTTYPE,VISIT_DAY,VISIT_MONTH,VISIT_YEAR,VISIT_PLAN) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $visitcode);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $newpatientnumber);
				$st->BindParam(4, $fullname);
				$st->BindParam(5, $days);
				$st->BindParam(6, $servicescode);
				$st->BindParam(7, $servicesname);
				$st->BindParam(8, $paymentmenthodname);
				$st->BindParam(9, $paymentmethodcode);
				$st->BindParam(10, $paymentschemename);
				$st->BindParam(11, $paymentschemecode);
				$st->BindParam(12, $currentuser);
				$st->BindParam(13, $currentusercode);
				$st->BindParam(14, $instcode);
				$st->BindParam(15, $currentshiftcode);
				$st->BindParam(16, $currentshift);
				$st->BindParam(17, $patientgender);
				$st->BindParam(18, $patientage);
				$st->BindParam(19, $payment);
				$st->BindParam(20, $currentday);
				$st->BindParam(21, $currentmonth);
				$st->BindParam(22, $currentyear);
				$st->BindParam(23, $paymentschemeplan);
					
				$exe = $st->execute();
			
				$sqlstmtserv = "INSERT INTO octopus_patients_servicesrequest(REQU_CODE,REQU_VISITCODE,REQU_BILLCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_ACTOR,REQU_ACTORCODE,REQU_INSTCODE,REQU_SHIFTCODE,REQU_SHIFT,REQU_PAYMENTTYPE,REQU_SHOW,REQU_DAY,REQU_MONTH,REQU_YEAR,REQU_PLAN) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmtserv);   
				$st->BindParam(1, $servicerequestcode);
				$st->BindParam(2, $visitcode);
				$st->BindParam(3, $billingcode);
				$st->BindParam(4, $days);
				$st->BindParam(5, $form_key);
				$st->BindParam(6, $newpatientnumber);
				$st->BindParam(7, $fullname);
				$st->BindParam(8, $patientage);
				$st->BindParam(9, $patientgender);
				$st->BindParam(10, $paymentmenthodname);
				$st->BindParam(11, $paymentmethodcode);
				$st->BindParam(12, $paymentschemecode);
				$st->BindParam(13, $paymentschemename);
				$st->BindParam(14, $servicescode);
				$st->BindParam(15, $servicesname);
				$st->BindParam(16, $currentuser);
				$st->BindParam(17, $currentusercode);
				$st->BindParam(18, $instcode);
				$st->BindParam(19, $currentshiftcode);
				$st->BindParam(20, $currentshift);
				$st->BindParam(21, $payment);
				$st->BindParam(22, $payment);
				$st->BindParam(23, $currentday);
				$st->BindParam(24, $currentmonth);
				$st->BindParam(25, $currentyear);
				$st->BindParam(26, $paymentschemeplan);				
				$exed = $st->execute();				
				
				// $sqlstmtbills = "INSERT INTO octopus_patients_bills(BILL_CODE,BILL_PATIENTCODE,BILL_PATIENTNUMBER,BILL_PATIENT,BILL_VISITCODE,BILL_DATE,BILL_AMOUNT,BILL_ACTOR,BILL_ACTORCODE,BILL_INSTCODE) 
				// VALUES (?,?,?,?,?,?,?,?,?,?) ";
				// $st = $this->db->prepare($sqlstmtbills);   
				// $st->BindParam(1, $billingcode);
				// $st->BindParam(2, $form_key);
				// $st->BindParam(3, $newpatientnumber);
				// $st->BindParam(4, $fullname);
				// $st->BindParam(5, $visitcode);
				// $st->BindParam(6, $days);
				// $st->BindParam(7, $billamount);
				// $st->BindParam(8, $currentuser);
				// $st->BindParam(9, $currentusercode);
				// $st->BindParam(10, $instcode);
				// $exedd = $st->execute();

				if($schemepricepercentage < 100){
					$schemeamount = ($amount*$schemepricepercentage)/100;
					$patientamount = $amount - $schemeamount ;
					$rtn = 1;
					$cash = 'CASH'; 
					$formkey = md5(microtime());
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
					$st->BindParam(6, $form_key);
					$st->BindParam(7, $newpatientnumber);
					$st->BindParam(8, $fullname);
					$st->BindParam(9, $servicesname);
					$st->BindParam(10, $servicescode);
					$st->BindParam(11, $paymentschemecode);
					$st->BindParam(12, $paymentschemename);
					$st->BindParam(13, $paymentmenthodname);
					$st->BindParam(14, $paymentmethodcode);
					$st->BindParam(15, $rtn);
					$st->BindParam(16, $schemeamount);
					$st->BindParam(17, $schemeamount);
					$st->BindParam(18, $schemeamount);
					$st->BindParam(19, $currentuser);
					$st->BindParam(20, $currentusercode);
					$st->BindParam(21, $instcode);
					$st->BindParam(22, $currentshiftcode);
					$st->BindParam(23, $currentshift);
					$st->BindParam(24, $servicerequestcode);
					$st->BindParam(25, $dept);
					$st->BindParam(26, $payment);
					$st->BindParam(27, $patientcardnumber);
					$st->BindParam(28, $patientcardexpirydate);
					$st->BindParam(29, $currentday);
					$st->BindParam(30, $currentmonth);
					$st->BindParam(31, $currentyear);
					$st->BindParam(32, $paymentschemeplan);	
					$exedd = $st->execute();
					$formkey = md5(microtime());
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
					$st->BindParam(6, $form_key);
					$st->BindParam(7, $newpatientnumber);
					$st->BindParam(8, $fullname);
					$st->BindParam(9, $servicesname);
					$st->BindParam(10, $servicescode);
					$st->BindParam(11, $cashschemecode);
					$st->BindParam(12, $cash);
					$st->BindParam(13, $cashpaymentmethod);
					$st->BindParam(14, $cashpaymentmethodcode);
					$st->BindParam(15, $rtn);
					$st->BindParam(16, $patientamount);
					$st->BindParam(17, $patientamount);
					$st->BindParam(18, $patientamount);
					$st->BindParam(19, $currentuser);
					$st->BindParam(20, $currentusercode);
					$st->BindParam(21, $instcode);
					$st->BindParam(22, $currentshiftcode);
					$st->BindParam(23, $currentshift);
					$st->BindParam(24, $servicerequestcode);
					$st->BindParam(25, $dept);
					$st->BindParam(26, $payment);
					$st->BindParam(27, $patientcardnumber);
					$st->BindParam(28, $patientcardexpirydate);
					$st->BindParam(29, $currentday);
					$st->BindParam(30, $currentmonth);
					$st->BindParam(31, $currentyear);
					$st->BindParam(32, $paymentschemeplan);	
					$exedd = $st->execute();

					if ($patientage > '64' && $amount > '0') {
						$sqlstmtdiscount = "INSERT INTO octopus_patients_discounts(PDS_CODE,PDS_PATIENTCODE,PDS_PATIENTNUMBER,PDS_PATIENT,PDS_DATE,
									PDS_VISITCODE,PDS_SERVICECODE,PDS_SERVICE,PDS_SERVICEAMOUNT,PDS_DISCOUNTAMOUNT,PDS_DISCOUNT,PDS_ACTOR,PDS_ACTORCODE,PDS_INSTCODE,PDS_DAY,PDS_MONTH,PDS_YEAR) 
									VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
						$st = $this->db->prepare($sqlstmtdiscount);
						$st->BindParam(1, $form_key);
						$st->BindParam(2, $form_key);
						$st->BindParam(3, $newpatientnumber);
						$st->BindParam(4, $fullname);
						$st->BindParam(5, $days);
						$st->BindParam(6, $visitcode);
						$st->BindParam(7, $servicescode);
						$st->BindParam(8, $servicesname);
						$st->BindParam(9, $servicecharge);
						$st->BindParam(10, $discountamount);
						$st->BindParam(11, $discount);
						$st->BindParam(12, $currentuser);
						$st->BindParam(13, $currentusercode);
						$st->BindParam(14, $instcode);
						$st->BindParam(15, $currentday);
						$st->BindParam(16, $currentmonth);
						$st->BindParam(17, $currentyear);
						$exedx = $st->execute();
					}

				}else{
					$rtn = 1;
					$sqlstmtbillsitems = "INSERT INTO octopus_patients_billitems(B_CODE,B_VISITCODE,B_BILLCODE,B_DT,B_DTIME,
								B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE
								,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_ACTOR,B_ACTORCODE,B_INSTCODE,B_SHIFTCODE,B_SHIFT,B_SERVCODE,B_DPT,B_PAYMENTTYPE,B_CARDNUMBER,B_EXPIRYDATE,B_DAY,B_MONTH,B_YEAR,B_PLAN) 
								VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmtbillsitems);
					$st->BindParam(1, $billingitemcode);
					$st->BindParam(2, $visitcode);
					$st->BindParam(3, $billingcode);
					$st->BindParam(4, $days);
					$st->BindParam(5, $days);
					$st->BindParam(6, $form_key);
					$st->BindParam(7, $newpatientnumber);
					$st->BindParam(8, $fullname);
					$st->BindParam(9, $servicesname);
					$st->BindParam(10, $servicescode);
					$st->BindParam(11, $paymentschemecode);
					$st->BindParam(12, $paymentschemename);
					$st->BindParam(13, $paymentmenthodname);
					$st->BindParam(14, $paymentmethodcode);
					$st->BindParam(15, $rtn);
					$st->BindParam(16, $amount);
					$st->BindParam(17, $amount);
					$st->BindParam(18, $amount);
					$st->BindParam(19, $currentuser);
					$st->BindParam(20, $currentusercode);
					$st->BindParam(21, $instcode);
					$st->BindParam(22, $currentshiftcode);
					$st->BindParam(23, $currentshift);
					$st->BindParam(24, $servicerequestcode);
					$st->BindParam(25, $dept);
					$st->BindParam(26, $payment);
					$st->BindParam(27, $patientcardnumber);
					$st->BindParam(28, $patientcardexpirydate);
					$st->BindParam(29, $currentday);
					$st->BindParam(30, $currentmonth);
					$st->BindParam(31, $currentyear);
					$st->BindParam(32, $paymentschemeplan);	
					$exedd = $st->execute();

					if ($patientage > '64' && $amount > '0') {
						$sqlstmtdiscount = "INSERT INTO octopus_patients_discounts(PDS_CODE,PDS_PATIENTCODE,PDS_PATIENTNUMBER,PDS_PATIENT,PDS_DATE,
									PDS_VISITCODE,PDS_SERVICECODE,PDS_SERVICE,PDS_SERVICEAMOUNT,PDS_DISCOUNTAMOUNT,PDS_DISCOUNT,PDS_ACTOR,PDS_ACTORCODE,PDS_INSTCODE,PDS_DAY,PDS_MONTH,PDS_YEAR) 
									VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
						$st = $this->db->prepare($sqlstmtdiscount);
						$st->BindParam(1, $form_key);
						$st->BindParam(2, $form_key);
						$st->BindParam(3, $newpatientnumber);
						$st->BindParam(4, $fullname);
						$st->BindParam(5, $days);
						$st->BindParam(6, $visitcode);
						$st->BindParam(7, $servicescode);
						$st->BindParam(8, $servicesname);
						$st->BindParam(9, $servicecharge);
						$st->BindParam(10, $discountamount);
						$st->BindParam(11, $discount);
						$st->BindParam(12, $currentuser);
						$st->BindParam(13, $currentusercode);
						$st->BindParam(14, $instcode);
						$st->BindParam(15, $currentday);
						$st->BindParam(16, $currentmonth);
						$st->BindParam(17, $currentyear);
						$exedx = $st->execute();
					}
				}

			}			
			
			if($newfoldercharge == 'YES'){

				// $sqlstmtbills = "INSERT INTO octopus_patients_bills(BILL_CODE,BILL_PATIENTCODE,BILL_PATIENTNUMBER,BILL_PATIENT,BILL_VISITCODE,BILL_DATE,BILL_AMOUNT,BILL_ACTOR,BILL_ACTORCODE,BILL_INSTCODE) 
				// VALUES (?,?,?,?,?,?,?,?,?,?) ";
				// $st = $this->db->prepare($sqlstmtbills);   
				// $st->BindParam(1, $billingcode);
				// $st->BindParam(2, $form_key);
				// $st->BindParam(3, $newpatientnumber);
				// $st->BindParam(4, $fullname);
				// $st->BindParam(5, $visitcode);
				// $st->BindParam(6, $days);
				// $st->BindParam(7, $newfolderamount);
				// $st->BindParam(8, $currentuser);
				// $st->BindParam(9, $currentusercode);
				// $st->BindParam(10, $instcode);
				// $exedd = $st->execute();

				if($schemepricepercentage < 100){
					$schemeamount = ($newfolderamount*$schemepricepercentage)/100;
					$patientamount = $newfolderamount - $schemeamount ;
					$rtn = 1;
					$cash = 'CASH';
					$newfoldercode = 'SER0001';
					$newfolder  = 'REGISTRATION';
					$formkey = md5(microtime());
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
					$st->BindParam(16, $schemeamount);
					$st->BindParam(17, $schemeamount);
					$st->BindParam(18, $schemeamount);
					$st->BindParam(19, $currentuser);
					$st->BindParam(20, $currentusercode);
					$st->BindParam(21, $instcode);
					$st->BindParam(22, $currentshiftcode);
					$st->BindParam(23, $currentshift);
					$st->BindParam(24, $newfolderservicerequestcode);
					$st->BindParam(25, $dept);
					$st->BindParam(26, $payment);
					$st->BindParam(27, $patientcardnumber);
					$st->BindParam(28, $patientcardexpirydate);
					$st->BindParam(29, $currentday);
					$st->BindParam(30, $currentmonth);
					$st->BindParam(31, $currentyear);
					$st->BindParam(32, $paymentschemeplan);	
					$exedd = $st->execute();
					$formkey = md5(microtime());
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
					$st->BindParam(6, $form_key);
					$st->BindParam(7, $newpatientnumber);
					$st->BindParam(8, $fullname);
					$st->BindParam(9, $newfolder);
					$st->BindParam(10, $newfoldercode);
					$st->BindParam(11, $cashschemecode);
					$st->BindParam(12, $cash);
					$st->BindParam(13, $cashpaymentmethod);
					$st->BindParam(14, $cashpaymentmethodcode);
					$st->BindParam(15, $rtn);
					$st->BindParam(16, $patientamount);
					$st->BindParam(17, $patientamount);
					$st->BindParam(18, $patientamount);
					$st->BindParam(19, $currentuser);
					$st->BindParam(20, $currentusercode);
					$st->BindParam(21, $instcode);
					$st->BindParam(22, $currentshiftcode);
					$st->BindParam(23, $currentshift);
					$st->BindParam(24, $newfolderservicerequestcode);
					$st->BindParam(25, $dept);
					$st->BindParam(26, $payment);
					$st->BindParam(27, $patientcardnumber);
					$st->BindParam(28, $patientcardexpirydate);
					$st->BindParam(29, $currentday);
					$st->BindParam(30, $currentmonth);
					$st->BindParam(31, $currentyear);
					$st->BindParam(32, $paymentschemeplan);	
					$exedd = $st->execute();

				}else{
					$rtn = 1;
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
					$st->BindParam(26, $payment);
					$st->BindParam(27, $currentday);
					$st->BindParam(28, $currentmonth);
					$st->BindParam(29, $currentyear);
					$st->BindParam(30, $paymentschemeplan);	
					$exedd = $st->execute();
				}

				$sqlstmtserv = "INSERT INTO octopus_patients_servicesrequest(REQU_CODE,REQU_VISITCODE,REQU_BILLCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_ACTOR,REQU_ACTORCODE,REQU_INSTCODE,REQU_SHIFTCODE,REQU_SHIFT,REQU_STATUS,REQU_DAY,REQU_MONTH,REQU_YEAR,REQU_PLAN) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmtserv);   
				$st->BindParam(1, $newfolderservicerequestcode);
				$st->BindParam(2, $visitcode);
				$st->BindParam(3, $billingcode);
				$st->BindParam(4, $days);
				$st->BindParam(5, $form_key);
				$st->BindParam(6, $newpatientnumber);
				$st->BindParam(7, $fullname);
				$st->BindParam(8, $patientage);
				$st->BindParam(9, $patientgender);
				$st->BindParam(10, $paymentmenthodname);
				$st->BindParam(11, $paymentmethodcode);
				$st->BindParam(12, $paymentschemecode);
				$st->BindParam(13, $paymentschemename);
				$st->BindParam(14, $newfoldercode);
				$st->BindParam(15, $newfolder);
				$st->BindParam(16, $currentuser);
				$st->BindParam(17, $currentusercode);
				$st->BindParam(18, $instcode);
				$st->BindParam(19, $currentshiftcode);
				$st->BindParam(20, $currentshift);
				$st->BindParam(21, $payment);
				$st->BindParam(22, $currentday);
				$st->BindParam(23, $currentmonth);
				$st->BindParam(24, $currentyear);
				$st->BindParam(25, $paymentschemeplan);	
				$exed = $st->execute();	

			}
				return '2';			
			}else{			
				return '0';			
			}
		}	
	}

	

} 
?>