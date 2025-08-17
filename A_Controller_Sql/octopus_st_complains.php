<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 3 oct 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_complains
	$complainstable->insert_newcomplains($form_key,$newcomplain,$currentusercode,$currentuser,$instcode);
*/

class OctopussetupcomplainssSql Extends Engine{
	// 3 Oct 2023 JOSEPH ADORBOE
	public function getquerylabplan($instcode){		
		$list = ("SELECT * FROM octopus_st_complains WHERE LP_INSTCODE = '$instcode' and LP_STATUS = '1' AND LP_CATEGORY = 'LABS'  order by LP_NAME DESC ");
		return $list;
	}
	// 3 oct 2023, 12 SEPT 2021,  JOSEPH ADORBOE
    public function insert_newcomplains($form_key,$newcomplain,$currentusercode,$currentuser,$instcode){
		
		$mt = 1;
		$sqlstmt = ("SELECT COMPL_ID FROM octopus_st_complains where COMPL_COMPLAINS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newcomplain);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';	
			}else{
				$sqlstmt = "INSERT INTO octopus_st_complains(COMPL_CODE,COMPL_COMPLAINS,COMPL_DESC,COMPL_USERCODE,COMPL_USER,COMPL_INSTCODE) 
				VALUES (?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newcomplain);
				$st->BindParam(3, $newcomplain);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $instcode);				
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
$complainstable = new OctopussetupcomplainssSql;
?>