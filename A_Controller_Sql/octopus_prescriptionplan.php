<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 29 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_prescriptionplan
	$prescriptionplansetuptable->
*/

class OctopusPrescriptionPlanSql Extends Engine{
	// 24 SEPT 2023 JOSEPH ADORBOE
	public function getqueryprescriptionplan($plancode,$instcode){		
		$list = ("SELECT * FROM octopus_prescriptionplan_medication WHERE TRM_INSTCODE = '$instcode' and TRM_STATUS = '1' AND TRM_PLANCODE = '$plancode'  order by TRM_MEDICATION DESC");
		return $list;
	}
	// 24 Sept 2023, 23 JAN 2022 JOSEPH ADORBOE 
	public function getprescriptionplandetails($plancode,$instcode){
		$nut = 1;
		$sqlstmt = ("SELECT * FROM octopus_prescriptionplan WHERE TRP_CODE = ? AND TRP_INSTCODE = ? AND TRP_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $plancode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['TRP_CODE'].'@'.$object['TRP_NUMBER'].'@'.$object['TRP_NAME'];
				return $results;
			}else{
				return '1';
			}
		}else{
			return '0';
		}			
	}	
	// 29 Sept 2023, 23 JAN 2022  JOSEPH ADORBOE
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

$prescriptionplansetuptable = new OctopusPrescriptionPlanSql();
?>