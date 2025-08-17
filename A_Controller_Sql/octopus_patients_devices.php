<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_devices
	$patientsDevicestable->getdevicerequestdetails($requestcode,$patientcode,$instcode)
*/

class OctopusPatientsDevicesSql Extends Engine{
	// 11 AUG 2024, JOSEPH ADORBOE 
	public function getdevicerequestdetails($requestcode,$instcode){
		$stmt = "SELECT *  FROM octopus_patients_devices WHERE PD_CODE = ? AND PD_INSTCODE = ? ";
		$st = $this->db->prepare($stmt);
		$st->BindParam(1, $requestcode);
        // $st->BindParam(2, $patientcode);
        $st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$res = $obj['PD_DEVICECODE'].'@@'.$obj['PD_DEVICE'].'@@'.$obj['PD_HISTORY'].'@@'.$obj['PD_QTY'].'@@'.$obj['PD_STATE'].'@@'.$obj['PD_RETURNREASON'];
		}else{
			$res = '0';
		}
		return $res;
	}
	//  5 JAN 2025 JOSEPH ADORBOE
	public function getquerypatientdevicesmonitorpending($day,$instcode){		
		$list = ("SELECT * FROM octopus_patients_devices WHERE PD_INSTCODE = '$instcode' AND PD_DISPENSE = '1' AND  date(PD_DATE) < '$day' order by PD_DISPENSE DESC");
		return $list;
	}
	// 5 JAN 2025 JOSEPH ADORBOE
	public function getquerypatientdevicesmonitor($day,$instcode){		
		$list = ("SELECT * FROM octopus_patients_devices WHERE PD_INSTCODE = '$instcode' AND PD_DISPENSE != '0' AND  date(PD_DATE) = '$day' order by PD_DISPENSE DESC ");
		return $list;
	}
	// 20 DEC 2023 JOSEPH ADORBOE
	public function getquerypatientdevices($idvalue,$instcode){		
		$list = ("SELECT * FROM octopus_patients_devices WHERE PD_INSTCODE = '$instcode' AND PD_STATUS != '0' AND PD_DEVICECODE = '$idvalue' order by PD_DATE DESC ");
		return $list;
	}
	// 7 NOV 2023 JOSEPH ADORBOE
	public function getquerypatientdeviceslist($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_devices where PD_PATIENTCODE = '$patientcode' and  PD_INSTCODE = '$instcode'  order by PD_ID DESC");
		return $list;
	}
	// 3 Oct 2023 JOSEPH ADORBOE
	public function getquerylegacydevices($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_devices where PD_PATIENTCODE = '$patientcode' and  PD_INSTCODE = '$instcode' order by PD_STATUS DESC, PD_ID DESC");
		return $list;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryhistorydevices($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_devices where PD_PATIENTCODE = '$patientcode' AND PD_VISITCODE != '$visitcode' and PD_INSTCODE = '$instcode'  order by PD_STATUS DESC, PD_ID DESC ");
		return $list;		
	}

	
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicebasketdevices($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_devices where PD_PATIENTCODE = '$patientcode' and PD_VISITCODE = '$visitcode' and PD_INSTCODE = '$instcode'  order by PD_STATUS DESC, PD_ID DESC  ");
		return $list;		
	}

	// 27 NOV 2022
	public function getdevicetotals($cashpaymentmethodcode,$day,$instcode){
		$zero = '0';
		$two = 2;
		$sqlstmt = ("SELECT SUM(PD_TOT) AS TOTCASH from octopus_patients_devices where PD_PAYMENTMETHODCODE = ? and PD_DISPENSE = ? AND PD_INSTCODE = ? AND  date(PD_DISPENSEDATE) = ? ");
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

		$sqlstmt = ("SELECT SUM(PD_TOT) AS TOTCASH from octopus_patients_devices where PD_PAYMENTMETHODCODE != ? and PD_DISPENSE = ? AND PD_INSTCODE = ? AND  date(PD_DISPENSEDATE) = ? ");
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

	// 25 AUG 2023
	public function cancelconsultationdevices($cancelreason,$days,$visitcode,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_devices SET PD_STATE = ?, PD_STATUS = ?, PD_COMPLETE = ?, PD_RETURNREASON = ?, PD_RETURNACTOR = ? , PD_RETURNACTORCODE = ?, PD_RETURNTIME = ? WHERE PD_VISITCODE = ? AND PD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $cancelreason);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $days);
		$st->BindParam(8, $visitcode);
		$st->BindParam(9, $instcode);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 20 Sept 2023, 27 JUNE 2021 JOSEPH ADORBOE  transactioncode
	public function getpendingmedicaldevices($patientcode,$instcode){
		$rant = 1 ; 
		$sqlstmt = ("SELECT * FROM octopus_patients_devices where PD_PATIENTCODE = ? AND PD_INSTCODE = ? AND PD_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $rant);
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
	// 10 oct 2023, 
	public function update_patientdevices($ekey,$days,$devicescode,$devicesname,$storyline,$quantity,$currentusercode,$currentuser,$instcode){
		$one  = 1;
		$sql = "UPDATE octopus_patients_devices SET PD_DATE = ?, PD_DEVICECODE = ?,  PD_DEVICE = ?, PD_HISTORY = ? , PD_QTY = ? , PD_ACTORCODE = ?, PD_ACTOR =?   WHERE PD_CODE = ? and PD_STATUS = ? and PD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $devicescode);
		$st->BindParam(3, $devicesname);
		$st->BindParam(4, $storyline);
		$st->BindParam(5, $quantity);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $one);
		$st->BindParam(10, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 29 MAY 2021 JOSEPH  ADORBOE 
	public function update_removepatientdevices($ekey,$days,$cancelreason,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$three = 3;
		$sql = "UPDATE octopus_patients_devices SET PD_STATUS = ? , PD_RETURNREASON = ? , PD_RETURNACTORCODE = ?, PD_RETURNACTOR = ? ,PD_RETURNTIME = ? ,PD_RETURN = ? WHERE PD_CODE = ? and PD_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $cancelreason);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $days);
		$st->BindParam(6, $three);
		$st->BindParam(7, $ekey);
		$st->BindParam(8, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 10 oct 2023, 29 MAY  2021,  JOSEPH ADORBOE
    public function insert_patientdevices($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$devicescode,$devicesname,$storyline,$patientdevicecode,$type,$paymentmethodcode,$paymentmethod,$quantity,$scheme,$schemecode,$consultationpaymenttype,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT PD_ID FROM octopus_patients_devices where PD_PATIENTCODE = ? AND PD_VISITCODE = ? AND PD_DEVICECODE = ? and PD_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $devicescode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_devices(PD_CODE,PD_DATE,PD_PATIENTCODE,PD_PATIENTNUMBER,PD_PATIENT,PD_CONSULTATIONCODE,PD_AGE,PD_GENDER,PD_VISITCODE,PD_DEVICECODE,PD_DEVICE,PD_HISTORY,PD_ACTOR,PD_ACTORCODE,PD_INSTCODE,PD_REQUESTCODE,PD_TYPE,PD_PAYMENTMETHODCODE,PD_PAYMENTMETHOD,PD_SCHEMECODE,PD_SCHEME,PD_PAYMENTTYPE,PD_QTY, PD_BILLERCODE, PD_BILLER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $days);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumber);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $consultationcode);
				$st->BindParam(7, $age);
				$st->BindParam(8, $gender);
				$st->BindParam(9, $visitcode);
				$st->BindParam(10, $devicescode);
				$st->BindParam(11, $devicesname);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$st->BindParam(16, $patientdevicecode);
				$st->BindParam(17, $type);
				$st->BindParam(18, $paymentmethodcode);
				$st->BindParam(19, $paymentmethod);
				$st->BindParam(20, $schemecode);
				$st->BindParam(21, $scheme);
				$st->BindParam(22, $consultationpaymenttype);
				$st->BindParam(23, $quantity);
				$st->BindParam(24, $currentusercode);
				$st->BindParam(25, $currentuser);
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
	// 3 SEPT 2023
	public function dischagerdevices($patientcode,$visitcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_patients_devices SET PD_CONSULTATIONSTATE = ? WHERE PD_VISITCODE = ? and PD_INSTCODE = ? AND PD_PATIENTCODE = ? ";
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
	public function selectedshowevices($selected,$patientcode,$visitcode,$unselected,$instcode){
		$sqldevices = "UPDATE octopus_patients_devices SET PD_STATUS = ? , PD_SELECTED = ? WHERE PD_VISITCODE = ? and PD_SELECTED = ? and PD_INSTCODE = ? AND PD_PATIENTCODE = ?";
		$st = $this->db->prepare($sqldevices);
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
	public function selectedpaiddevices($selected,$paid,$patientcode,$visitcode,$unselected,$instcode){
		$sqldevices = "UPDATE octopus_patients_devices SET PD_STATE = ? , PD_STATUS = ? , PD_SELECTED = ?, PD_DISPENSE = ?  WHERE PD_VISITCODE = ? and PD_SELECTED = ? AND PD_PATIENTCODE = ?";
		$st = $this->db->prepare($sqldevices);
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
	// 26 AUG 2023
	public function reversecanceldevices($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_devices SET PD_STATE = ?, PD_STATUS = ?, PD_COMPLETE = ? WHERE PD_CODE = ? AND PD_VISITCODE = ? AND PD_INSTCODE = ? and PD_SELECTED = ?  ";
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
	// 25 AUG 2023
	public function canceldevices($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_devices SET PD_STATE = ?, PD_STATUS = ?, PD_COMPLETE = ? WHERE PD_CODE = ? AND PD_VISITCODE = ? AND PD_INSTCODE = ? and PD_SELECTED = ?  ";
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
	// 25 AUG 2023
	public function sendbackdevices($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_devices SET PD_STATE = ? WHERE PD_CODE = ? AND PD_VISITCODE = ? AND PD_INSTCODE = ? and PD_SELECTED = ?  ";
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
	// 25 AUG 2023, 19 SEPT 2021 JOSEPH ADORBOE  transactioncode
	public function getpendingdevice($patientcode,$visitcode,$instcode){        
        $rant = '0' ;
        $sqlstmt = ("SELECT PD_ID FROM octopus_patients_devices WHERE PD_PATIENTCODE = ? AND PD_INSTCODE = ? AND PD_VISITCODE = ? AND PD_STATE IN('1','2') ");
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
	public function unselectdevices($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_devices SET PD_SELECTED = ? WHERE PD_CODE = ? AND PD_VISITCODE = ? AND PD_INSTCODE = ? and PD_SELECTED = ?  ";
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
	public function selectdevices($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_devices SET PD_SELECTED = ? WHERE PD_CODE = ? and PD_VISITCODE = ? and PD_SELECTED = ? and PD_INSTCODE = ? ";
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

$patientsDevicestable = new OctopusPatientsDevicesSql();
?>