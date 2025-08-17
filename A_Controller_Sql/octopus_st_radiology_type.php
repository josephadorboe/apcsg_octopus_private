<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 29 MAY 2025
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_radiology_type
	$setupradiologytypetable->getradiologytypelov()
*/

class OctopusSetupRadiologyTypeClass Extends Engine{
	// 29 MAY 2025,  JOSEPH ADORBOE
	public function getradiologytypelov()
	{
		
		$sql = " SELECT RADTYPE_CODE,RADTYPE_NAME FROM octopus_st_radiology_type where RADTYPE_STATUS = '$this->theone'  ORDER BY RADTYPE_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		// echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['RADTYPE_CODE'].'@@@'.$obj['RADTYPE_NAME'].'">'.$obj['RADTYPE_NAME'].' </option>';
		}
	}
	
} 
	$setupradiologytypetable = new OctopusSetupRadiologyTypeClass();
?>