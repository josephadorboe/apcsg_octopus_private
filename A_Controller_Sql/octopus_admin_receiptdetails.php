<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 22 JUNE 2025
	PURPOSE: TO OPERATE MYSQL QUERY	
	Based on octopus_admin_services
	$adminreceipttable->getfacilityreceiptdetail($instcode);
	$adminreceipttable = new OctopusAdminServiceSql();
*/

class OctopusAdminReceiptClass Extends Engine{

	
	// 22 JUNE 2025 JOSEPH ADORBOE 
	public function getfacilityreceiptdetail($instcode){	
		$one = 1;
		$sql = "SELECT RP_INSTNAME , RP_PHONENUM, RP_EMAIL , RP_LOGO , RP_PIN, RP_CAPTION FROM octopus_admin_receiptdetails WHERE  RP_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);		
		$exe = $st->Execute();
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['RP_INSTNAME'].'@@'.$obj['RP_PHONENUM'].'@@'.$obj['RP_EMAIL'].'@@'.$obj['RP_LOGO'].'@@'.$obj['RP_PIN'].'@@'.$obj['RP_CAPTION'] ;				
		}else{			
			$ordernum = '0';			
		}
		return 	$ordernum; 	
		
	}
	 
       
		
} 
$adminreceipttable = new OctopusAdminReceiptClass();
?>