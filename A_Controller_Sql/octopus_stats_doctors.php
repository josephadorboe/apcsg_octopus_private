<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 24 OCT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_stats_doctors
*/

class OctopusstatsdoctormonthlySql Extends Engine{
	// 24 OCT 2023 JOSEPH ADORBOE
	public function getquerylabplan($instcode){		
		$list = ("SELECT * FROM octopus_stats_doctors WHERE LP_INSTCODE = '$instcode' and LP_STATUS = '1' AND LP_CATEGORY = 'LABS'  order by LP_NAME DESC ");
		return $list;
	}

	// 24 oct 2023, 28 APR 2022 JOSEPH ADORBOE 
	public function countdoctorstatsmonthly($currentmonth,$currentusercode,$instcode){		
		$one = 1;	
		$three = 3;	
		$four = 4;
		$sql = "UPDATE octopus_stats_doctors SET DS_CONSULTATION = DS_CONSULTATION + ? WHERE DS_DOCTORCODE = ? AND DS_INSTCODE = ? AND DS_MONTH = ? AND DS_TYPE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $currentmonth);	
		$st->BindParam(5, $three);
		$exe = $st->execute();		
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}

	// 24 oct 2023, 28 APR 2022 JOSEPH ADORBOE 
	public function countdoctorstatsday($currentday,$currentmonth,$currentusercode,$instcode){		
		$one = 1;	
		$three = 3;	
		$four = 4;
		$sql = "UPDATE octopus_stats_doctors SET DS_CONSULTATION = DS_CONSULTATION + ? WHERE DS_DOCTORCODE = ? AND DS_INSTCODE = ? AND DS_DAY = ? AND DS_TYPE = ? AND DS_MONTH = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $currentday);	
		$st->BindParam(5, $four);
		$st->BindParam(6, $currentmonth);	
		$exe = $st->execute();	
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}

	// 24 oct 2023, 28 APR 2022 JOSEPH ADORBOE 
	public function countdoctorstatsyear($currentyear,$currentday,$currentmonth,$currentusercode,$instcode){		
		$one = 1;	
		$three = 3;	
		$four = 4;
		$sql = "UPDATE octopus_stats_doctors SET DS_CONSULTATION = DS_CONSULTATION + ? WHERE DS_DOCTORCODE = ? AND DS_INSTCODE = ? AND DS_DAY = ? AND DS_TYPE = ? AND DS_MONTH = ? AND DS_YEAR = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $currentday);	
		$st->BindParam(5, $four);
		$st->BindParam(6, $currentmonth);	
		$st->BindParam(7, $currentyear);	
		$exe = $st->execute();	
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}

	
} 
$doctorstatsmonthlytable = new OctopusstatsdoctormonthlySql();
?>