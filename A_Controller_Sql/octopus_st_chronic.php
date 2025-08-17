<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 2 oct  2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_chronic
*/

class OctopuschronicSql Extends Engine{
	// 2 oct  2023 JOSEPH ADORBOE
	public function getquerylabplan($instcode){		
		$list = ("SELECT * FROM octopus_st_chronic WHERE LP_INSTCODE = '$instcode' and LP_STATUS = '1' AND LP_CATEGORY = 'LABS'  order by LP_NAME DESC ");
		return $list;
	}
	// 13 AUG 2021,  JOSEPH ADORBOE
    public function insert_newchronic($form_key,$newchronic,$description,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT CH_ID FROM octopus_st_chronic where CH_CHRONIC = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newchronic);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_chronic(CH_CODE,CH_CHRONIC,CH_DESC,CH_USERCODE,CH_USER) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newchronic);
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

$chronictable = new OctopuschronicSql();
?>