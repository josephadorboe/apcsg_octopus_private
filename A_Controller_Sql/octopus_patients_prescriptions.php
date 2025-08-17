<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_prescriptions
	$Prescriptionstable->getprescriptionrequesteddetails($requestcode,$instcode);
	$patientprecriptionrequest = ("SELECT * FROM octopus_patients_prescriptions WHERE PRESC_INSTCODE = '$instcode' AND PRESC_DISPENSE != '0' AND  date(PRESC_DATETIME) = '$day' order by PRESC_DISPENSE DESC");
										   
											
*/

class OctopusPatientsPrescriptionsSql Extends Engine{
	// 16 AUG 2024, JOSEPH ADORBOE 
	public function getprescriptionrequesteddetails($requestcode,$instcode){
		$zero = '0';
		$one  = '1';
		$sqlstmt = ("SELECT * FROM octopus_patients_prescriptions WHERE PRESC_CODE = ? AND PRESC_INSTCODE = ? AND PRESC_STATUS != ? ORDER BY PRESC_ID  DESC LIMIT 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $requestcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $zero);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PRESC_MEDICATIONCODE'].'@'.$object['PRESC_MEDICATION'].'@'.$object['PRESC_INSTRUCTION'].'@'.$object['PRESC_DOSAGEFORMCODE'].'@'.$object['PRESC_DOSAGEFORM'].'@'.$object['PRESC_FREQUENCYCODE'].'@'.$object['PRESC_FREQUENCY'].'@'.$object['PRESC_DAYSCODE'].'@'.$object['PRESC_DAYS'].'@'.$object['PRESC_ROUTECODE'].'@'.$object['PRESC_ROUTE'].'@'.$object['PRESC_QUANTITY'].'@'.$object['PRESC_STRENGHT'].'@'.$object['PRESC_CODE'].'@'.$object['PRESC_CONSULTATIONCODE'].'@'.$object['PRESC_VISITCODE'].'@'.$object['PRESC_DATE'].'@'.$object['PRESC_GENDER'].'@'.$object['PRESC_AGE'].'@'.$object['PRESC_PATIENTCODE'].'@'.$object['PRESC_PATIENTNUMBER'].'@'.$object['PRESC_PATIENT'].'@'.$object['PRESC_STATE'] ;				
			}else{
				$results = '1';
			}
		}else{
			$results = '1';
		}			
		return $results;
	}
	// 4 JAN 2024 JOSEPH ADORBOE
	public function getqueryprescriptionmonitorpending($day,$instcode){		
		$list = ("SELECT * FROM octopus_patients_prescriptions WHERE PRESC_INSTCODE = '$instcode' AND PRESC_DISPENSE = '1' AND PRESC_COMPLETE != '1' AND  date(PRESC_DATETIME) < '$day' order by PRESC_DISPENSE DESC");
		return $list;
	}
	// 4 JAN 2024 JOSEPH ADORBOE
	public function getqueryprescriptionmonitor($day,$instcode){		
		$list = ("SELECT * FROM octopus_patients_prescriptions WHERE PRESC_INSTCODE = '$instcode' AND PRESC_DISPENSE != '0' AND  date(PRESC_DATETIME) = '$day' order by PRESC_DISPENSE DESC ");
		return $list;
	}
	// 2 DEC 2023 JOSEPH ADORBOE
	public function getqueryprescription($idvalue,$instcode){		
		$list = ("SELECT * FROM octopus_patients_prescriptions WHERE PRESC_INSTCODE = '$instcode' AND PRESC_STATUS != '0' AND PRESC_MEDICATIONCODE = '$idvalue' order by PRESC_DATE DESC ");
		return $list;
	}
	// 3 oct 2023 JOSEPH ADORBOE
	public function getquerylegacyprescriptions($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_prescriptions where PRESC_PATIENTCODE = '$patientcode'  and PRESC_INSTCODE = '$instcode' and PRESC_STATUS != '0' order by  PRESC_STATUS DESC, PRESC_ID DESC ");
		return $list;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryprescriptionshistory($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * FROM octopus_patients_prescriptions WHERE PRESC_PATIENTCODE = '$patientcode' AND PRESC_VISITCODE != '$visitcode' AND PRESC_INSTCODE = '$instcode' order by  PRESC_STATUS DESC, PRESC_ID DESC  ");
		return $list;
	}

	// 8 oct 2023 JOSEPH ADORBOE
	public function getqueryservicebasketprescriptions($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_prescriptions where PRESC_PATIENTCODE = '$patientcode' and PRESC_VISITCODE = '$visitcode' and PRESC_INSTCODE = '$instcode'  order by PRESC_STATUS ASC, PRESC_ID DESC  ");
		return $list;
	}
	// 9 SEPT 2023 JOSEPH ADORBOE
	public function getpatientprescriptionsclaims($visitcode,$patientcode,$instcode){
		$list = ("SELECT * from octopus_patients_prescriptions where PRESC_PATIENTCODE = '$patientcode' and PRESC_VISITCODE = '$visitcode' and PRESC_INSTCODE = '$instcode' and PRESC_STATUS != '0' AND PRESC_RETURN ='0' order by PRESC_ID DESC ");
		return $list;
	}
	// 4 JAN 2023, JOSEPH ADORBOE 
	public function getmedicationtotals($cashpaymentmethodcode,$day,$instcode){
		$zero = '0';
		$two = 2;
		$sqlstmt = ("SELECT SUM(PRESC_TOT) AS TOTCASH from octopus_patients_prescriptions where PRESC_PAYMENTMETHODCODE = ? and PRESC_DISPENSE = ? AND PRESC_INSTCODE = ? AND  date(PRESC_DISPENSEDATE) = ? ");
		$st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $cashpaymentmethodcode);
        $st->BindParam(2, $two);
        $st->BindParam(3, $instcode);
		$st->BindParam(4, $day);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$res = $obj['TOTCASH'];
		}else{
			$res = '0';
		}

		$sqlstmt = ("SELECT SUM(PRESC_TOT) AS TOTCASH from octopus_patients_prescriptions where PRESC_PAYMENTMETHODCODE != ? and PRESC_DISPENSE = ? AND PRESC_INSTCODE = ? AND  date(PRESC_DISPENSEDATE) = ? ");
		$st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $cashpaymentmethodcode);
        $st->BindParam(2, $two);
        $st->BindParam(3, $instcode);
		$st->BindParam(4, $day);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ress = $obj['TOTCASH'];
		}else{
			$ress = '0';
		}
		$tot = $res +$ress;

		return $res.'@'.$ress.'@'.$tot;

	}
	// 23 OCT 2023, 
	public function cancellprescription($visitcode,$days,$cancelreason,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATUS = ?, PRESC_RETURNREASON = ?, PRESC_RETURNACTORCODE = ?, PRESC_RETURNACTOR = ?, PRESC_RETURNTIME = ?  WHERE PRESC_VISITCODE = ? AND PRESC_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $cancelreason);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $days);
		$st->BindParam(6, $visitcode);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();				
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 8 OCT 2023, 
	public function update_removepatientprescription($ekey,$cancelreason,$days,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATUS = ?,  PRESC_RETURNREASON = ?, PRESC_RETURNTIME = ?, PRESC_RETURNACTORCODE = ?,  PRESC_RETURNACTOR = ? , PRESC_STATE = ? , PRESC_COMPLETE = ? WHERE PRESC_CODE = ? AND PRESC_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $cancelreason);
		$st->BindParam(3, $days);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $zero);
		$st->BindParam(7, $zero);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 8 OCT 2023, 
	public function update_patientprescription($ekey,$days,$day,$medicationcode,$medicationname,$doseagecode,$doseagename,$notes,$type,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_DATE = ?, PRESC_DATETIME = ?,  PRESC_MEDICATIONCODE = ?, PRESC_MEDICATION =? , PRESC_DOSAGEFORMCODE =?, PRESC_DOSAGEFORM =?, PRESC_FREQUENCYCODE =?, PRESC_FREQUENCY =?, PRESC_DAYSCODE =?, PRESC_DAYS =? , PRESC_ROUTECODE =?, PRESC_ROUTE =?, PRESC_QUANTITY =?, PRESC_STRENGHT =?, PRESC_INSTRUCTION =?, PRESC_ACTORCODE =?, PRESC_ACTOR =?  WHERE PRESC_CODE = ?  AND PRESC_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $day);
		$st->BindParam(2, $days);
		$st->BindParam(3, $medicationcode);
		$st->BindParam(4, $medicationname);
		$st->BindParam(5, $doseagecode);
		$st->BindParam(6, $doseagename);
		$st->BindParam(7, $frequencycode);
		$st->BindParam(8, $frequencyname);
		$st->BindParam(9, $dayscode);
		$st->BindParam(10, $daysname);
		$st->BindParam(11, $routecode);
		$st->BindParam(12, $routename);
		$st->BindParam(13, $qty);
		$st->BindParam(14, $strenght);
		$st->BindParam(15, $notes);
		$st->BindParam(16, $currentusercode);
		$st->BindParam(17, $currentuser);
		$st->BindParam(18, $ekey);
		$st->BindParam(19, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 8 oct 2023, JOSEPH ADORBOE
    public function insert_patientprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medicationcode,$medicationname,$doseagecode,$doseagename,$notes,$type,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentusercode,$currentuser,$instcode){
		
		$one = 1;
		$sqlstmt = ("SELECT PRESC_ID FROM octopus_patients_prescriptions where PRESC_PATIENTCODE = ? AND PRESC_VISITCODE = ? AND PRESC_MEDICATIONCODE = ? and PRESC_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $medicationcode);
		$st->BindParam(4, $one);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_prescriptions(PRESC_CODE,PRESC_DATE,PRESC_DATETIME,PRESC_PATIENTCODE,PRESC_PATIENTNUMBER,PRESC_PATIENT,PRESC_CONSULTATIONCODE,PRESC_AGE,PRESC_GENDER,PRESC_VISITCODE,PRESC_MEDICATIONCODE,PRESC_MEDICATION,PRESC_DOSAGEFORMCODE,PRESC_DOSAGEFORM,PRESC_FREQUENCYCODE,PRESC_FREQUENCY,PRESC_DAYSCODE,PRESC_DAYS,PRESC_ROUTECODE,PRESC_ROUTE,PRESC_QUANTITY,PRESC_STRENGHT,PRESC_INSTRUCTION,PRESC_TYPE,PRESC_ACTORCODE,PRESC_ACTOR,PRESC_INSTCODE,PRESC_PAYMENTMETHOD,PRESC_PAYMENTMETHODCODE,PRESC_PAYSCHEMECODE,PRESC_PAYSCHEME,PRESC_CODENUM,PRESC_PAYMENTTYPE,PRESC_BILLERCODE,PRESC_BILLER,PRESC_PLAN) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $day);
				$st->BindParam(3, $days);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $patient);
				$st->BindParam(7, $consultationcode);
				$st->BindParam(8, $age);
				$st->BindParam(9, $gender);
				$st->BindParam(10, $visitcode);
				$st->BindParam(11, $medicationcode);
				$st->BindParam(12, $medicationname);
				$st->BindParam(13, $doseagecode);
				$st->BindParam(14, $doseagename);
				$st->BindParam(15, $frequencycode);
				$st->BindParam(16, $frequencyname);
				$st->BindParam(17, $dayscode);
				$st->BindParam(18, $daysname);
				$st->BindParam(19, $routecode);
				$st->BindParam(20, $routename);
				$st->BindParam(21, $qty);
				$st->BindParam(22, $strenght);
				$st->BindParam(23, $notes);
				$st->BindParam(24, $type);
				$st->BindParam(25, $currentusercode);
				$st->BindParam(26, $currentuser);
				$st->BindParam(27, $instcode);
				$st->BindParam(28, $paymentmethod);
				$st->BindParam(29, $paymentmethodcode);
				$st->BindParam(30, $schemecode);
				$st->BindParam(31, $scheme);
				$st->BindParam(32, $prescriptionrequestcode);
				$st->BindParam(33, $consultationpaymenttype);
				$st->BindParam(34, $currentusercode);
				$st->BindParam(35, $currentuser);
				$st->BindParam(36, $plan);
				$exe = $st->execute();				
				if($exe){								
					return '2';								
				}else{								
					return '0';								
				}		
			}
		}else{
			return '0';
		}	
	}
	// 20 Sept 2023, 28 JUNE 2021 JOSEPH ADORBOE  transactioncode
	public function getinsurancestatus($patientcode,$visitcode,$privateinsurancecode,$partnercompaniescode,$nationalinsurancecode,$instcode){
		$nut = 1 ;
		$sqlstmt = ("SELECT * FROM octopus_patients_prescriptions where PRESC_PATIENTCODE = ? AND PRESC_VISITCODE = ? and PRESC_INSTCODE = ? and PRESC_COMPLETE = ? and PRESC_PAYMENTMETHODCODE IN(?,?,?) ");
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
				return '2';
			}else{
				return '1';
			}

		}else{
			return '-1';
		}
			
	}	
	// 3 SEPT  2023
	public function dischargeprescription($patientcode,$visitcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_CONSULTATIONSTATE = ? WHERE PRESC_VISITCODE = ? and PRESC_INSTCODE = ? AND PRESC_PATIENTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $patientcode);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 29 AUG 2023
	public function selectedshowprescription($selected,$patientcode,$visitcode,$unselected,$instcode){
		$sqlprescriptions = "UPDATE octopus_patients_prescriptions SET  PRESC_STATUS = ? , PRESC_SELECTED = ? WHERE PRESC_VISITCODE = ? and PRESC_SELECTED = ? and PRESC_INSTCODE = ? AND PRESC_PATIENTCODE = ?";
		$st = $this->db->prepare($sqlprescriptions);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $selected);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $unselected);
		$st->BindParam(5, $instcode);
		$st->BindParam(6, $patientcode);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 29 AUG 2023
	public function selectedpaidprescription($selected,$paid,$patientcode,$visitcode,$unselected,$instcode){
		$sqlprescriptions = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_STATUS = ? , PRESC_SELECTED = ? , PRESC_DISPENSE = ?  WHERE PRESC_VISITCODE = ? and PRESC_SELECTED = ? AND PRESC_PATIENTCODE = ?";
		$st = $this->db->prepare($sqlprescriptions);
		$st->BindParam(1, $paid);
		$st->BindParam(2, $selected);
		$st->BindParam(3, $selected);
		$st->BindParam(4, $unselected);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $unselected);
		$st->BindParam(7, $patientcode);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 26 AUG 2023
	public function reversecancelprescription($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? ,  PRESC_STATUS = ? ,  PRESC_COMPLETE = ? WHERE PRESC_CODE = ? and PRESC_VISITCODE = ? AND PRESC_INSTCODE = ? and PRESC_SELECTED = ?  ";
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
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 26 AUG 2023
	public function cancelprescription($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? ,  PRESC_STATUS = ? ,  PRESC_COMPLETE = ? WHERE PRESC_CODE = ? and PRESC_VISITCODE = ? AND PRESC_INSTCODE = ? and PRESC_SELECTED = ?  ";
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
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 26 AUG 2023
	public function sendbackprescription($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? WHERE PRESC_CODE = ? and PRESC_VISITCODE = ? AND PRESC_INSTCODE = ? and PRESC_SELECTED = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $unselected);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 19 SEPT 2021 JOSEPH ADORBOE  transactioncode
	public function getpendingmedication($patientcode,$visitcode,$instcode){        
        $rant = '0' ;
        $sqlstmt = ("SELECT PRESC_ID FROM octopus_patients_prescriptions WHERE PRESC_PATIENTCODE = ? AND PRESC_INSTCODE = ? AND PRESC_VISITCODE = ? AND PRESC_STATE IN('1','2') ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $patientcode);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $visitcode);
	//	$st->BindParam(4, $rant);
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
	public function unselectprescription($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_SELECTED = ? WHERE PRESC_CODE = ? and PRESC_VISITCODE = ? AND PRESC_INSTCODE = ? and PRESC_SELECTED = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $unselected);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $selected);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 25 AUG 2023
	public function selectprescription($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_SELECTED = ? WHERE PRESC_CODE = ? AND PRESC_VISITCODE = ? and PRESC_SELECTED = ? AND PRESC_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $unselected);
		$st->BindParam(5, $instcode);
		$selectitem = $st->Execute();				
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	
} 
$Prescriptionstable = new OctopusPatientsPrescriptionsSql();
?>