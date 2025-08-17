<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 21 FEB 2024
	PURPOSE: TO OPERATE MYSQL QUERY
	Base : 	octopus_passvalues
	$passvaluestable->gettotalbatchqty($instcode)
*/

class OctopusPassvaluesSql Extends Engine{
		// 25 Jan 2024,  16 MAR 2023 , JOSEPH ADORBOE  
		public function passingvalues($pkey,$value){		
			$sql = ("INSERT INTO octopus_passvalues (PASS_KEY,PASS_VALUE) VALUES (?,?) ");
			$st = $this->db->prepare($sql);   
			$st->BindParam(1, $pkey);
			$st->BindParam(2, $value);
			$st->execute();						
		}
	
		//  25 Jan 2024, 16 MAR 2023
		public function getpassvalue($id){	
			$sql = ("SELECT PASS_VALUE from octopus_passvalues where PASS_KEY = ?");
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $id);
			$st->execute();			
			if($st->rowCount() == 1){		
				$row = $st->fetch(PDO::FETCH_ASSOC);    
				$evalue = $row['PASS_VALUE'];
				return $evalue;					
			}else{
				return '1';
			}	
		}
}
$passvaluestable =  new OctopusPassvaluesSql();
?>
