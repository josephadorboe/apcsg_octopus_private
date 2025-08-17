<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 17 Oct 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_oxygen
	$oxygensetuptable->
*/

class OctopusSetupOxygenSql Extends Engine{
	// 17 OCT 2023 JOSEPH ADORBOE
	public function getquerylabplan($instcode){		
		$list = ("SELECT * FROM octopus_st_oxygen WHERE LP_INSTCODE = '$instcode' and LP_STATUS = '1' AND LP_CATEGORY = 'LABS'  order by LP_NAME DESC ");
		return $list;
	}

	// 12 SEPT  2021,  JOSEPH ADORBOE
    public function insert_addoxygen($form_key,$newoxygen,$currentusercode,$currentuser){
		$mt = 1;
		$sqlstmt = ("SELECT OX_ID FROM octopus_st_oxygen where OX_NAME = ? AND OX_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newoxygen);
		$st->BindParam(2, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_oxygen(OX_CODE,OX_NAME,OX_DESC,OX_ACTORCODE,OX_ACTOR) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newoxygen);
				$st->BindParam(3, $newoxygen);
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

$oxygensetuptable = new OctopusSetupOxygenSql();
?>