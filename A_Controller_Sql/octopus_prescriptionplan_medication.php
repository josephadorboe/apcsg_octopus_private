<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 28 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_prescriptionplan_medication
	$planmedicationtable->updatemediactiuonname($ekey,$medication,$instcode);	
*/

class OctopusPrescriptionMedicationSql Extends Engine{
	// 24 SEPT 2023 JOSEPH ADORBOE
	public function getquerylabplan($instcode){		
		$list = ("SELECT * FROM octopus_prescriptionplan_medication WHERE LP_INSTCODE = '$instcode' and LP_STATUS = '1' AND LP_CATEGORY = 'LABS'  order by LP_NAME DESC ");
		return $list;
	}
	// 9 oct 2023 JOSEPH ADORBOE
	public function getquerymedicationplan($treatmentplancode,$instcode){		
		$list = ("SELECT * from octopus_prescriptionplan_medication where TRM_PLANCODE = '$treatmentplancode' and TRM_INSTCODE = '$instcode' and TRM_STATUS = '1' order by TRM_ID DESC ");
		return $list;
	}

	// 2 DEC 2023,  JOSEPH ADORBOE
	public function updatemediactiuonname($ekey,$medication,$instcode){		
		$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_MEDICATION = ?  WHERE TRM_MEDICATIONCODE = ? AND TRM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $medication);
		$st->BindParam(2, $ekey);	
		$st->BindParam(3, $instcode);					
		$exe = $st->execute();		
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 9 OCT 2023,  27 MAY 2021 JOSEPH ADORBOE 
	public function update_planmedication($ekey,$medicationcode,$medicationname,$doseagecode,$doseagename,$notes,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_MEDICATIONCODE = ?, TRM_MEDICATION = ?,  TRM_DOSAGEFORMCODE = ?, TRM_DOSAGEFORM =? , TRM_FREQCODE =?, TRM_FREQ =?, TRM_DAYSCODE =?, TRM_DAYS =?, TRM_ROUTECODE =?, TRM_ROUTE =? , TRM_QTY =?, TRM_STRENGHT =?, TRM_DESC =?, TRM_ACTOR =?, TRM_ACTORCODE =? WHERE TRM_CODE = ? AND TRM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $medicationcode);
		$st->BindParam(2, $medicationname);
		$st->BindParam(3, $doseagecode);
		$st->BindParam(4, $doseagename);
		$st->BindParam(5, $frequencycode);
		$st->BindParam(6, $frequencyname);
		$st->BindParam(7, $dayscode);
		$st->BindParam(8, $daysname);
		$st->BindParam(9, $routecode);
		$st->BindParam(10, $routename);
		$st->BindParam(11, $qty);
		$st->BindParam(12, $strenght);
		$st->BindParam(13, $notes);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $ekey);
		$st->BindParam(17, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 23 JAN 2022 ,  JOSEPH ADORBOE
    public function newprescriptionplanmedication($form_key,$treatmentplancode,$treatmentplanname,$medicationcode,$medicationname,$day,$doseagecode,$doseagename,$notes,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode){
	
		$one = 1;
		$sqlstmt = ("SELECT TRM_ID FROM octopus_prescriptionplan_medication where TRM_MEDICATIONCODE = ? and  TRM_INSTCODE = ? and  TRM_PLANCODE = ? AND TRM_STATUS = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $medicationcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $treatmentplancode);
		$st->BindParam(4, $one);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$qty =1;
				$sqlstmt = "INSERT INTO octopus_prescriptionplan_medication(TRM_CODE,TRM_PLANCODE,TRM_PLAN,TRM_MEDICATIONCODE,TRM_MEDICATION,TRM_DOSAGEFORMCODE,TRM_DOSAGEFORM,TRM_FREQCODE,TRM_FREQ,TRM_DAYSCODE,TRM_DAYS,TRM_ROUTECODE,TRM_ROUTE,TRM_QTY,TRM_STRENGHT,TRM_DESC,TRM_DATE,TRM_ACTOR,TRM_ACTORCODE,TRM_INSTCODE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $treatmentplancode);
				$st->BindParam(3, $treatmentplanname);
				$st->BindParam(4, $medicationcode);
				$st->BindParam(5, $medicationname);
				$st->BindParam(6, $doseagecode);
				$st->BindParam(7, $doseagename);
				$st->BindParam(8, $frequencycode);
				$st->BindParam(9, $frequencyname);
				$st->BindParam(10, $dayscode);
				$st->BindParam(11, $daysname);
				$st->BindParam(12, $routecode);
				$st->BindParam(13, $routename);
				$st->BindParam(14, $qty);
				$st->BindParam(15, $strenght);
				$st->BindParam(16, $notes);
				$st->BindParam(17, $day);
				$st->BindParam(18, $currentuser);
				$st->BindParam(19, $currentusercode);
				$st->BindParam(20, $instcode);
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
	// 9 OCT 2023, 27 MAY 2021 
	public function update_removemedicationfromtreatmentplan($ekey,$removereason,$days,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_STATUS = ? , TRM_REASON = ?, TRM_REASONACTOR = ?, TRM_REASONACTORCODE = ?, TRM_REASONDAYS = ? WHERE TRM_CODE = ?  AND TRM_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $removereason);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $days);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 23 JAN 2022 JOSEPH ADORBOE 
	public function update_removemedicationfromplans($ekey,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_STATUS = ? WHERE TRM_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $tty);
		$st->BindParam(2, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 9 OCT 2023,  27 MAY 2021 JOSEPH ADORBOE 
	public function update_treatmentplanmedication($ekey,$medcode,$medname,$dosecode,$dose,$notes,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_MEDICATIONCODE = ?, TRM_MEDICATION = ?,  TRM_DOSAGEFORMCODE = ?, TRM_DOSAGEFORM =? , TRM_FREQCODE =?, TRM_FREQ =?, TRM_DAYSCODE =?, TRM_DAYS =?, TRM_ROUTECODE =?, TRM_ROUTE =? , TRM_QTY =?, TRM_STRENGHT =?, TRM_DESC =?, TRM_ACTOR =?, TRM_ACTORCODE =? WHERE TRM_CODE = ? AND TRM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $medcode);
		$st->BindParam(2, $medname);
		$st->BindParam(3, $dosecode);
		$st->BindParam(4, $dose);
		$st->BindParam(5, $freqcode);
		$st->BindParam(6, $freqname);
		$st->BindParam(7, $dayscode);
		$st->BindParam(8, $daysname);
		$st->BindParam(9, $routecode);
		$st->BindParam(10, $routename);
		$st->BindParam(11, $qty);
		$st->BindParam(12, $strenght);
		$st->BindParam(13, $notes);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $ekey);
		$st->BindParam(17, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 29 Sept 2023, 23 JAN 2022 JOSEPH ADORBOE 
	public function editprescriptionplanmedication($ekey, $medcode, $medname, $dosecode, $dose, $freqcode, $freqname, $dayscode, $daysname, $routecode, $routename, $qty, $strenght, $currentusercode, $currentuser, $instcode){
		$tty = '0';
		$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_MEDICATIONCODE = ?, TRM_MEDICATION = ? , TRM_DOSAGEFORMCODE = ? , TRM_DOSAGEFORM = ? ,TRM_FREQCODE =? , TRM_FREQ = ? ,  TRM_DAYSCODE = ? , TRM_DAYS = ? , TRM_ROUTECODE = ? , TRM_ROUTE = ? ,  TRM_QTY = ? , TRM_STRENGHT =  ? , TRM_ACTOR = ? , TRM_ACTORCODE = ? WHERE TRM_CODE = ? AND TRM_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $medcode);
		$st->BindParam(2, $medname);
		$st->BindParam(3, $dosecode);
		$st->BindParam(4, $dose);
		$st->BindParam(5, $freqcode);
		$st->BindParam(6, $freqname);
		$st->BindParam(7, $dayscode);
		$st->BindParam(8, $daysname);
		$st->BindParam(9, $routecode);
		$st->BindParam(10, $routename);
		$st->BindParam(11, $qty);
		$st->BindParam(12, $strenght);
		$st->BindParam(13, $currentuser);
		$st->BindParam(14, $currentusercode);
		$st->BindParam(15, $ekey);
		$st->BindParam(16, $instcode);		
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	
	// 23 JAN 2022 ,  JOSEPH ADORBOE
    public function insert_prescriptionplanlist($form_key,$prescriptionplancode,$prescriptionplan,$medicationcode,$medicationnum,$medicationname,$days,$dosagecode,$dosage,$currentusercode,$currentuser,$instcode){
	
		$one = 1;
		$sqlstmt = ("SELECT TRM_ID FROM octopus_prescriptionplan_medication where TRM_MEDICATIONCODE = ? and  TRM_INSTCODE = ? and  TRM_PLANCODE = ? AND TRM_STATUS = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $medicationcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $prescriptionplancode);
		$st->BindParam(4, $one);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$qty =1;
				$sqlstmt = "INSERT INTO octopus_prescriptionplan_medication(TRM_CODE,TRM_PLANCODE,TRM_PLAN,TRM_MEDICATIONCODE,TRM_MEDICATIONNUM,TRM_MEDICATION,TRM_DATE,TRM_ACTOR,TRM_ACTORCODE,TRM_INSTCODE,TRM_QTY,TRM_DOSAGEFORMCODE,TRM_DOSAGEFORM) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $prescriptionplancode);
				$st->BindParam(3, $prescriptionplan);
				$st->BindParam(4, $medicationcode);
				$st->BindParam(5, $medicationnum);
				$st->BindParam(6, $medicationname);
				$st->BindParam(7, $days);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $qty);
				$st->BindParam(12, $dosagecode);
				$st->BindParam(13, $dosage);
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
	// 23 Sept 2023, 29 JULY 2022  JOSEPH ADORBOE
	public function enablemedicationonplan($ekey,$currentuser,$currentusercode,$instcode){		
		$zero = 0;
		$vt = '-1';
		$one = 1;		
		$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_STATUS = ?, TRM_ACTOR = ?, TRM_ACTORCODE = ? WHERE TRM_MEDICATIONCODE = ? AND TRM_STATUS = ? AND TRM_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $vt);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();		
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 23 Sept 2023, 29 JULY 2022  JOSEPH ADORBOE
	public function disablemedicationonplan($ekey,$currentuser,$currentusercode,$instcode){		
		$zero = 0;
		$vt = '-1';
		$one = 1;		
		$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_STATUS = ?, TRM_ACTOR =?, TRM_ACTORCODE = ? WHERE TRM_MEDICATIONCODE = ? AND TRM_STATUS = ? AND TRM_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $vt);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $one);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();		
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	
} 
	$planmedicationtable = new OctopusPrescriptionMedicationSql();
?>