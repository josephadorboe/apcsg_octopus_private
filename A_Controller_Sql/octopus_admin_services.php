<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 28 NOV 2023
	PURPOSE: TO OPERATE MYSQL QUERY	
	Based on octopus_admin_services
	$adminservicetable->changeserviceprice($itemcode,$cashprice,$alternateprice,$dollarprice,$insuranceprice,$instcode);
	$adminservicetable = new OctopusAdminServiceSql();
*/

class OctopusAdminServiceSql Extends Engine{

	// 28 NOV JOSEPH ADORBOE
	public function getadminservicelist($instcode){		
		$list = ("SELECT * from octopus_admin_services WHERE SEV_INSTCODE = '$instcode'  order by SEV_SERVICES ");
		return $list;
	}
	// 11 NOV 2023, JOSEPH ADORBOE
	public function changeserviceprice($itemcode,$cashprice,$alternateprice,$dollarprice,$insuranceprice,$instcode){
		$zero = '0';
		$one = 1;
		$sql = "UPDATE octopus_admin_services SET SEV_CASHPRICE =?, SEV_ALTPRICE =? , SEV_INSURANCE =?, SEV_DOLLAR =? WHERE SEV_SERVICECODE = ? AND SEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $cashprice);
		$st->BindParam(2, $alternateprice);
		$st->BindParam(3, $insuranceprice);
		$st->BindParam(4, $dollarprice);
		$st->BindParam(5, $itemcode);
		$st->BindParam(6, $instcode);
		// $st->BindParam(7, $dollarprice);
		// $st->BindParam(8, $itemcode);
		// $st->BindParam(9, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 28 NOV 2023 JOSEPH ADORBOE 
	public function servicedetails($idvalue,$instcode){	
		$one = 1;
		$sql = "SELECT * FROM octopus_admin_services WHERE SEV_SERVICECODE = ? AND SEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$exe = $st->Execute();
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['SEV_CODE'].'@@'.$obj['SEV_SERVICECODE'].'@@'.$obj['SEV_SERVICES'].'@@'.$obj['SEV_CASHPRICE'].'@@'.$obj['SEV_ALTPRICE'].'@@'.$obj['SEV_INSURANCE'].'@@'.$obj['SEV_DOLLAR'] ;				
		}else{			
			$ordernum = '0';			
		}
		return 	$ordernum; 	
		
	}
	// 28 NOV 2023 JOSEPH ADORBOE
	public function enableservicesetup($ekey,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$one = 1;		
		$sql = "UPDATE octopus_admin_services SET SEV_STATUS = ?, SEV_ACTOR =?, SEV_ACTORCODE = ? WHERE SEV_SERVICECODE = ?  AND SEV_STATUS = ? AND SEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $zero);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){		
			return '2';							
		}else{								
			return '0';								
		}	
	}
	// 28 NOV 2023 JOSEPH ADORBOE
	public function disableservicesetup($ekey,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$one = 1;		
		$sql = "UPDATE octopus_admin_services SET SEV_STATUS = ?, SEV_ACTOR =?, SEV_ACTORCODE = ? WHERE SEV_SERVICECODE = ?  AND SEV_STATUS = ? AND SEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $one);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){		
			return '2';							
		}else{								
			return '0';								
		}	
	}

	// 11 AUG 2023,6 MAR 2021 JOSEPH ADORBOE
	public function getpaymentschemestate($patientschemecode,$instcode)
	{
		$sql = 'SELECT * FROM octopus_admin_services WHERE PSC_CODE = ? and PSC_INSTCODE = ? ';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientschemecode);
		$st->BindParam(2, $instcode);
		$state = $st->execute();
		if($state){
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$results = $obj['PSC_STATE'];			
				return $results;					
			}else{
				return '0';
			}
		}else{
			return '0';
		}	
	}
		
} 
$adminservicetable = new OctopusAdminServiceSql();
?>