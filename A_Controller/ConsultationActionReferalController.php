<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 26 FEB 2022 
	PURPOSE: TO OPERATE MYSQL QUERY 	insert_newdevice($form_key,$newdevices,$description,$currentusercode,$currentuser,$instcode)
*/

class ConsultationActionReferalController Extends Engine{	

	// 26 FEB 2022  JOSEPH ADORBOE 
	public function update_patientaction_referal($form_key, $patientcode, $patientnumber, $patient, $visitcode, $day, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $reviewnumber,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$consultationpaymenttype,$physiciancode,$physicians,$referaltype,$consultationnumber,$referalserviceamount,$physiofirstvisit,$physiofollowup,$currentshiftcode,$currentshift,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$servicerequestedcode,$servicerequested,$outcomenumber){
	
		$not = 5;
		$servicerequestcode = md5(microtime());
		$billingcode = md5(microtime());
		$ten = 10;
		$two = 2;
		$one = 1;
		$seven = 7;
		$servicebillcode = md5(microtime());
		$newconsultationcode = md5(microtime());
		$visitdate =  date( "Y-m-d", strtotime( "$day +7 day" ) );
		$dpt = 'SERVICES';
	//	$sqlstmt = ("SELECT OUT_ID FROM octopus_patients_consultations_outcome WHERE OUT_VISITCODE = ? AND  OUT_PATIENTCODE = ? AND  OUT_INSTCODE = ? AND OUT_STATUS = ? AND OUT_CONSULTATIONCODE  = ? AND OUT_ACTIONCODE = ? ");
	//	$st = $this->db->prepare($sqlstmt);   
	//	$st->BindParam(1, $visitcode);
	//	$st->BindParam(2, $patientcode);
	//	$st->BindParam(3, $instcode);
	//	$st->BindParam(4, $one);
	//	$st->BindParam(5, $consultationcode);
	//	$st->BindParam(6, $patientaction);
	//	$check = $st->execute();
	//	if($check){
	//		if($st->rowcount() > 0){			
	//			return '1';	
	//		}else{

				$outcomecode = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_patients_consultations_outcome(OUT_CODE,OUT_CONSULTATIONCODE,OUT_CONSULTATIONNUMBER,OUT_VISITCODE,OUT_DATE,OUT_PATIENTCODE,OUT_PATIENTNUMBER,OUT_PATIENT,OUT_DOCTOR,OUT_DOCTORCODE,OUT_SERVICECODE,OUT_SERVICE,OUT_ACTIONDATE,OUT_ACTIONCODE,OUT_ACTION,OUT_INSTCODE,OUT_SHIFTCODE,OUT_SHIFT,OUT_DAY,OUT_MONTH,OUT_YEAR,OUT_ACTOR,OUT_ACTORCODE,OUT_NUMBER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $outcomecode);
				$st->BindParam(2, $consultationcode);
				$st->BindParam(3, $consultationnumber);
				$st->BindParam(4, $visitcode);
				$st->BindParam(5, $days);
				$st->BindParam(6, $patientcode);
				$st->BindParam(7, $patientnumber);
				$st->BindParam(8, $patient);
				$st->BindParam(9, $currentuser);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $servicerequestedcode);
				$st->BindParam(12, $servicerequested);
				$st->BindParam(13, $days);
				$st->BindParam(14, $patientaction);
				$st->BindParam(15, $action);
				$st->BindParam(16, $instcode);
				$st->BindParam(17, $currentshiftcode);
				$st->BindParam(18, $currentshift);
				$st->BindParam(19, $currentday);
				$st->BindParam(20, $currentmonth);
				$st->BindParam(21, $currentyear);
				$st->BindParam(22, $currentuser);
				$st->BindParam(23, $currentusercode);
				$st->BindParam(24, $outcomenumber);				
				$exeoutcome = $st->execute();			
				if($exeoutcome){
		
				if($referaltype == 'TODAY'){
					// create a new service request $paymentmethod,$paymentmethodcode,$schemecode,$scheme
					
					
					// create a new consultation
					if($servicecode !== $physiofirstvisit && $servicecode !== $physiofollowup){

						$sqlstmtserv = "INSERT INTO octopus_patients_servicesrequest(REQU_CODE,REQU_VISITCODE,REQU_BILLCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_ACTOR,REQU_ACTORCODE,REQU_INSTCODE,REQU_SHIFTCODE,REQU_SHIFT,REQU_VISITTYPE,REQU_PAYMENTTYPE,REQU_SHOW,REQU_DAY,REQU_MONTH,REQU_YEAR,REQU_DOCTOR,REQU_DOCTORCODE,REQU_STAGE,REQU_VITALSTATUS) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmtserv);   
			$st->BindParam(1, $servicerequestcode);
			$st->BindParam(2, $visitcode);
			$st->BindParam(3, $billingcode);
			$st->BindParam(4, $days);
			$st->BindParam(5, $patientcode);
			$st->BindParam(6, $patientnumber);
			$st->BindParam(7, $patient);
			$st->BindParam(8, $age);
			$st->BindParam(9, $gender);
			$st->BindParam(10, $paymentmethod);
			$st->BindParam(11, $paymentmethodcode);
			$st->BindParam(12, $schemecode);
			$st->BindParam(13, $scheme);
			$st->BindParam(14, $servicecode);
			$st->BindParam(15, $servicesed);
			$st->BindParam(16, $currentuser);
			$st->BindParam(17, $currentusercode);
			$st->BindParam(18, $instcode);
			$st->BindParam(19, $currentshiftcode);
			$st->BindParam(20, $currentshift);
			$st->BindParam(21, $one);
			$st->BindParam(22, $consultationpaymenttype);
			$st->BindParam(23, $consultationpaymenttype);
			$st->BindParam(24, $currentday);
			$st->BindParam(25, $currentmonth);
			$st->BindParam(26, $currentyear);
			$st->BindParam(27, $physicians);
			$st->BindParam(28, $physiciancode);
			$st->BindParam(29, $two);
			$st->BindParam(30, $one);
			$servicerequest = $st->execute();


						$sqlstmt = "INSERT INTO octopus_patients_consultations(CON_CODE,CON_VISITCODE,CON_DATE,CON_PATIENTCODE,CON_PATIENTNUMBER,CON_PATIENT,CON_AGE,CON_GENDER,CON_SERIAL,CON_DOCTOR,CON_DOCTORCODE,CON_PAYMENTMETHOD,CON_PAYMENTMETHODCODE,CON_PAYSCHEMECODE,CON_PAYSCHEME,CON_SERVICECODE,CON_SERVICE,CON_ACTOR,CON_ACTORCODE,CON_INSTCODE,CON_SHIFTCODE,CON_SHIFT,CON_REQUESTCODE,CON_PAYMENTTYPE,CON_CONSULTATIONNUMBER,CON_DAY,CON_MONTH,CON_YEAR,CON_REMARKS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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

					$sql = "UPDATE octopus_patients_servicesrequest SET REQU_COMPLETE = ?, REQU_STATE = ?  WHERE REQU_CODE = ? AND REQU_INSTCODE  = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $two);
					$st->BindParam(2, $ten);
					$st->BindParam(3, $requestcode);
					$st->BindParam(4, $instcode);
					$exeservice = $st->execute();
					$sql = "UPDATE octopus_current SET CU_CONSULTATIONCODE = ? WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $consultationnumber);
					$st->BindParam(2, $instcode);
					$exe = $st->execute();

					$sql = "UPDATE octopus_serial SET SERIAL_NUMBER = ?  WHERE SERIAL_DOCTORCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $one);
					$st->BindParam(2, $physiciancode);
					$exe = $st->execute();	

					// send price to billing 
					$sqlstmtbillsitems = "INSERT INTO octopus_patients_billitems(B_CODE,B_VISITCODE,B_BILLCODE,B_DT,B_DTIME,
					B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE
					,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_ACTOR,B_ACTORCODE,B_INSTCODE,B_SHIFTCODE,B_SHIFT,B_SERVCODE,B_DPT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmtbillsitems);
					$st->BindParam(1, $servicebillcode);
					$st->BindParam(2, $visitcode);
					$st->BindParam(3, $billingcode);
					$st->BindParam(4, $days);
					$st->BindParam(5, $days);
					$st->BindParam(6, $patientcode);
					$st->BindParam(7, $patientnumber);
					$st->BindParam(8, $patient);
					$st->BindParam(9, $servicesed);
					$st->BindParam(10, $servicecode);
					$st->BindParam(11, $schemecode);
					$st->BindParam(12, $scheme);
					$st->BindParam(13, $paymentmethod);
					$st->BindParam(14, $paymentmethodcode);
					$st->BindParam(15, $one);
					$st->BindParam(16, $referalserviceamount);
					$st->BindParam(17, $referalserviceamount);
					$st->BindParam(18, $referalserviceamount);
					$st->BindParam(19, $currentuser);
					$st->BindParam(20, $currentusercode);
					$st->BindParam(21, $instcode);
					$st->BindParam(22, $currentshiftcode);
					$st->BindParam(23, $currentshift);
					$st->BindParam(24, $servicerequestcode);
					$st->BindParam(25, $dpt);
					$st->BindParam(26, $consultationpaymenttype);
					$st->BindParam(27, $currentday);
					$st->BindParam(28, $currentmonth);
					$st->BindParam(29, $currentyear);
					$exebills= $st->execute();					

					if($servicerequest && $exebills  ){
						return '2';
					}else{
						return '0';
					}

					}else{

						$sqlstmt = "INSERT INTO octopus_patients_review(REV_CODE,REV_DATE,REV_PATIENTCODE,REV_PATIENTNUM,REV_PATIENT,REV_VISITCODE,REV_NOTES,REV_ACTOR,REV_ACTORCODE,REV_INSTCODE,REV_REQUESTCODE,REV_SERVICE,REV_SERVICECODE,REV_DAY,REV_MONTH,REV_YEAR) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $form_key);
					$st->BindParam(2, $day);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $patientnumber);
					$st->BindParam(5, $patient);
					$st->BindParam(6, $visitcode);
					$st->BindParam(7, $remarks);
					$st->BindParam(8, $currentuser);
					$st->BindParam(9, $currentusercode);
					$st->BindParam(10, $instcode);
					$st->BindParam(11, $reviewnumber);
					$st->BindParam(12, $servicesed);
					$st->BindParam(13, $servicecode);	
					$st->BindParam(14, $currentday);
					$st->BindParam(15, $currentmonth);
					$st->BindParam(16, $currentyear);			
					$exe = $st->execute();
					$sql = "UPDATE octopus_current SET CU_REVIEWCODE = ? WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $reviewnumber);
					$st->BindParam(2, $instcode);
					$exe = $st->execute();

					$sql = "UPDATE octopus_patients SET PATIENT_REVIEWDATE = ? , PATIENT_SERVICES = ? WHERE PATIENT_CODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $day);
					$st->BindParam(2, $servicesed);
					$st->BindParam(3, $patientcode);
					$exed = $st->execute();

					if($exe){
						return '2';
					}else{
						return '0';
					}

					}			

					
				}else if($referaltype == 'NEXTVISIT'){

					$sqlstmt = "INSERT INTO octopus_patients_review(REV_CODE,REV_DATE,REV_PATIENTCODE,REV_PATIENTNUM,REV_PATIENT,REV_VISITCODE,REV_NOTES,REV_ACTOR,REV_ACTORCODE,REV_INSTCODE,REV_REQUESTCODE,REV_SERVICE,REV_SERVICECODE,REV_DAY,REV_MONTH,REV_YEAR) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $form_key);
					$st->BindParam(2, $visitdate);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $patientnumber);
					$st->BindParam(5, $patient);
					$st->BindParam(6, $visitcode);
					$st->BindParam(7, $remarks);
					$st->BindParam(8, $currentuser);
					$st->BindParam(9, $currentusercode);
					$st->BindParam(10, $instcode);
					$st->BindParam(11, $reviewnumber);
					$st->BindParam(12, $servicesed);
					$st->BindParam(13, $servicecode);	
					$st->BindParam(14, $currentday);
					$st->BindParam(15, $currentmonth);
					$st->BindParam(16, $currentyear);			
					$exe = $st->execute();
					$sql = "UPDATE octopus_current SET CU_REVIEWCODE = ? WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $reviewnumber);
					$st->BindParam(2, $instcode);
					$exe = $st->execute();

					$sql = "UPDATE octopus_patients SET PATIENT_REVIEWDATE = ? , PATIENT_SERVICES = ? WHERE PATIENT_CODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $visitdate);
					$st->BindParam(2, $servicesed);
					$st->BindParam(3, $patientcode);
					$exed = $st->execute();

					if($exe){
						return '2';
					}else{
						return '0';
					}
				}	
			
				}
		//	}
		//	}
		}
	
	
} 
?>
