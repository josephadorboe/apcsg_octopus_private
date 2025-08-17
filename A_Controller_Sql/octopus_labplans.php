<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 24 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_labplans
	$labplantable = new OctopusLabPlansSql();
*/

class OctopusLabPlansSql Extends Engine{
	// 24 SEPT 2023 JOSEPH ADORBOE
	public function getquerylabplan($instcode){		
		$list = ("SELECT * FROM octopus_labplans WHERE LP_INSTCODE = '$instcode' and LP_STATUS = '1' AND LP_CATEGORY = 'LABS'  order by LP_NAME DESC ");
		return $list;
	}

	// 24 Sept 2023, 23 JAN 2022 JOSEPH ADORBOE 
	public function getlabplandetails($plancode,$instcode){
		$nut = 1;
		$sqlstmt = ("SELECT * FROM octopus_labplans WHERE LP_CODE = ? AND LP_INSTCODE = ? AND LP_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $plancode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['LP_CODE'].'@'.$object['LP_CODENUM'].'@'.$object['LP_NAME'].'@'.$object['LP_CATEGORY'];
				return $results;
			}else{
				return '1';
			}
		}else{
			return '0';
		}			
	}	

	// 26 Sept 2023, 22 NOV 2021,  JOSEPH ADORBOE
    public function newlabplans($lapplancode,$labsplans,$labplannumber,$description,$days,$category,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT LP_ID FROM octopus_labplans where LP_NAME = ? and  LP_INSTCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $labsplans);
		$st->BindParam(2, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_labplans(LP_CODE,LP_CODENUM,LP_NAME,LP_DESC,LP_DATES,LP_CATEGORY,LP_ACTOR,LP_ACTORCODE,LP_INSTCODE) 
				VALUES (?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $lapplancode);
				$st->BindParam(2, $labplannumber);
				$st->BindParam(3, $labsplans);
				$st->BindParam(4, $description);
				$st->BindParam(5, $days);
				$st->BindParam(6, $category);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);
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
$labplantable = new OctopusLabPlansSql();
?>