<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 13 MAR 2022
	PURPOSE: TO OPERATE MYSQL QUERY 
	
*/


class PrescriptionPlanController Extends Engine
{
	// 23 JAN 2022 JOSEPH ADORBOE 
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


	// 23 JAN 2022  JOSEPH ADORBOE
    public function newprescriptionplans($prescriptionplancode,$prescriptionplan,$prescriptionplannumber,$description,$days,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT TRP_ID FROM octopus_prescriptionplan where TRP_NAME = ? and  TRP_INSTCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $prescriptionplan);
		$st->BindParam(2, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_prescriptionplan(TRP_CODE,TRP_NUMBER,TRP_NAME,TRP_DESC,TRP_DATES,TRP_ACTOR,TRP_ACTORCODE,TRP_INSTCODE) 
				VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $prescriptionplancode);
				$st->BindParam(2, $prescriptionplannumber);
				$st->BindParam(3, $prescriptionplan);
				$st->BindParam(4, $description);
				$st->BindParam(5, $days);				
				$st->BindParam(6, $currentuser);
				$st->BindParam(7, $currentusercode);
				$st->BindParam(8, $instcode);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_PRESCRIPTIONPLAN = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $prescriptionplannumber);
					$st->BindParam(2, $instcode);						
					$exetg = $st->execute();
					if($exetg){
						return '2';
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
	}

	// 23 JAN 2022 ,  JOSEPH ADORBOE
    public function insert_prescriptionplanlist($form_key,$prescriptionplancode,$prescriptionplan,$medicationcode,$medicationnum,$medicationname,$days,$dosagecode,$dosage,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT TRM_ID FROM octopus_prescriptionplan_medication where TRM_MEDICATIONCODE = ? and  TRM_INSTCODE = ? and  TRM_PLANCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $medicationcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $prescriptionplancode);
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

} 
?>