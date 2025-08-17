<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 2 oct 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_allergy
	$setupallergytable->getnewallergyLov();
*/

class OctopusallergySql Extends Engine{
	// 23 APR 2024 JOSEPH ADORBOE
	public function getallergy($patientcode,$instcode){		
		$list = ("SELECT * FROM octopus_patients_allergy WHERE ALG_PATIENTCODE = '$patientcode' AND ALG_INSTCODE = '$instcode' AND ALG_STATUS = '1' ORDER BY ALG_ID DESC ");
		return $list;
	}
	// 2 oct 2023 JOSEPH ADORBOE
	public function getqueryallergy($instcode){		
		$list = ("SELECT * FROM octopus_labplans WHERE LP_INSTCODE = '$instcode' and LP_STATUS = '1' AND LP_CATEGORY = 'LABS'  order by LP_NAME DESC ");
		return $list;
	}
	// 23 APR 2024,  JOSEPH ADORBOE 
	public function getnewallergyLov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_allergy where ALG_STATUS = '$mnm' order by ALG_ALLEGY "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['ALG_CODE'].'@@@'.$obj['ALG_ALLEGY'].'">'.$obj['ALG_ALLEGY'].' </option>';
		}
	}
	// 2 oct 2023,  13 AUG 2021,  JOSEPH ADORBOE
    public function insert_newallergy($form_key,$newallergy,$description,$currentusercode,$currentuser,$instcode){	
		$mt = 1;
		$sqlstmt = ("SELECT ALG_ID FROM octopus_st_allergy where ALG_ALLEGY = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newallergy);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_allergy(ALG_CODE,ALG_ALLEGY,ALG_DESC,ALG_USERCODE,ALG_USER) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newallergy);
				$st->BindParam(3, $description);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);				
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

	$setupallergytable = new OctopusallergySql();
?>