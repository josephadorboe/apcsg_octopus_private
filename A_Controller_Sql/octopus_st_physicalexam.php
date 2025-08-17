<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 5 oct 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_physicalexam
	$physicalexamssetuptable->
*/

class OctopussetupexamsSql Extends Engine{
	// 5 Oct 2023 JOSEPH ADORBOE
	public function getquerylabplan($instcode){		
		$list = ("SELECT * FROM octopus_st_physicalexam WHERE LP_INSTCODE = '$instcode' and LP_STATUS = '1' AND LP_CATEGORY = 'LABS'  order by LP_NAME DESC ");
		return $list;
	}

	// 5 Oct 2023, 12 SEPT 2021,  JOSEPH ADORBOE
    public function insert_physicalexams($physicalexamcode,$newphysicalexams,$currentusercode,$currentuser){	

		$mt = 1;
		$sqlstmt = ("SELECT PE_ID FROM octopus_st_physicalexam where PE_NAME = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newphysicalexams);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_physicalexam(PE_CODE,PE_NAME,PE_DESC,PE_ACTORCODE,PE_ACTOR) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $physicalexamcode);
				$st->BindParam(2, $newphysicalexams);
				$st->BindParam(3, $newphysicalexams);
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

$physicalexamssetuptable = new OctopussetupexamsSql();
?>