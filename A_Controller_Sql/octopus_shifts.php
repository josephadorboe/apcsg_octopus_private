<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 9 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_shifts
*/

class OctopusShiftsSql Extends Engine{
	
	// 10 SEPT 2023,  JOSEPH ADORBOE
    public function updateshiftendofday($shiftcode,$instcode){
		$one = 1;
		$zero = '0';
		$sqlstmts = "UPDATE octopus_shifts set SHIFT_ENDOFDAY = ? where SHIFT_CODE = ? and SHIFT_INSTCODE = ? AND SHIFT_ENDOFDAY = ?";
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $one);
		$st->BindParam(2, $shiftcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $zero);
		$exe = $st->execute();				
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}		
	}	
	
} 

$shifttable = new OctopusShiftsSql();
?>