<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 17 JULY 2025
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_investigation_plan_list
	$setupinvestigationplanlisttable->getinvestigationplanlist($plancode,$instcode);
	
*/

class OctopusSetupInvestigationPlanListClass Extends Engine{

	// 17 JULY 2025, JOSEPH ADORBOE 
	public function querygetinvestigationplanitem($idvalue,$status,$instcode){		
		$list = ("SELECT IP_CODE,IP_PLANCODE,IP_ITEMCODE,IP_ITEMNAME,IP_TYPE,IP_INSTCODE,IP_CASHPRICE,IP_STATUS,IP_ACTORCODE,IP_ACTOR  from octopus_st_investigation_plan_list WHERE IP_INSTCODE = '$instcode' AND IP_PLANCODE = '$idvalue' AND IP_STATUS = '$status'  order by IP_ITEMNAME ASC ");
		return $list;
	}
	
	// 17 JULY 2025, JOSEPH ADORBOE 
    public function addnewinvestigationplanitems($form_key,$type,$plancode,$itemcode,$itemname,$itemprice,$currentuser,$currentusercode,$instcode){	
		$one = 1;
		$sqlstmt = ("SELECT IP_ID FROM octopus_st_investigation_plan_list WHERE IP_ITEMCODE = ? AND  IP_INSTCODE = ?  AND IP_STATUS = ?  AND IP_PLANCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $this->theactive);
		$st->BindParam(4, $form_key);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > $this->thefailed){			
				return $this->theexisted;			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_investigation_plan_list(IP_CODE,IP_PLANCODE,IP_ITEMCODE,IP_ITEMNAME,IP_TYPE,IP_INSTCODE,IP_CASHPRICE,IP_STATUS,IP_ACTORCODE,IP_ACTOR) 
				VALUES (?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $plancode);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $itemcode);
				$st->BindParam(4, $itemname);
				$st->BindParam(5, $type);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $itemprice);
				$st->BindParam(8, $this->theactive);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $currentuser);				
				$exe = $st->execute();
				if($exe){			
					return $this->thepassed;								
				}else{								
					return $this->thefailed;								
				}				
			}
		}else{
			return $this->thefailed;
		}	
	}
	
	// 19 JULY 2025, , JOSEPH ADORBOE
	public function removeinvestigationplanitem($itemekey,$radiologyitemstatus,$currentuser,$currentusercode,$instcode){	
		$sql = "UPDATE octopus_st_investigation_plan_list SET IP_STATUS = ?, IP_ACTORCODE = ?, IP_ACTOR =? WHERE IP_CODE = ? AND IP_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $radiologyitemstatus);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $itemekey);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();						
		if($exe){	
			return $this->thepassed;								
		}else{								
			return $this->thefailed;								
		}			
	}
	
	// 19 JULY 2025 , JOSEPH ADORBOE 
	public function getinvestigationplanlist($plancode,$instcode)
	{
		$sql = " SELECT IP_ITEMCODE,IP_ITEMNAME FROM octopus_st_investigation_plan_list WHERE IP_STATUS = '$this->theactive' and IP_INSTCODE = '$instcode' AND  IP_PLANCODE = '$plancode' order by IP_ITEMNAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		$nu = 0;
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			
			echo  '<br />';
			echo ' <input type="checkbox" class="largerCheckbox" checked value="'.$obj['IP_ITEMCODE'].'@@@'.$obj['IP_ITEMNAME'].' " name="scheckbox[]" id="selcheck" /> '.++$nu.' - <b> '.$obj['IP_ITEMNAME'].' </b>  <br />';
			// echo  '< br />';
			// echo '<option value="'.$obj['IP_ITEMCODE'].'">'.$obj['IP_ITEMNAME'].' </option>';
		}
	}


	// //21 APR 2023 
	// public function getImagingsearchlov($instcode)
	// {
	// 	$sql = " SELECT SC_CODE,SC_NAME FROM octopus_st_investigation_plan_list where SC_STATUS = '$this->theone' and SC_INSTCODE = '$instcode' order by SC_NAME "; 
	// 	$st = $this->db->prepare($sql); 
	// 	$st->execute();
	// 	echo '<option value= "">-- Select --</option>';
	// 	echo '<option value="ALL">All</option>';
	// 	while($obj = $st->fetch(PDO::FETCH_ASSOC)){
	// 	echo '<option value="'.$obj['SC_CODE'].'">'.$obj['SC_NAME'].' </option>';
	// 	}
	// }

	
	// // 30 MAY 2025, JOSEPH ADORBOE
	// public function editradiology($ekey,$radiology,$radiologytypecode,$radiologytypename,$description,$radiologystatus,$currentuser,$currentusercode,$instcode){	
	// 	$sql = "UPDATE octopus_st_investigation_plan_list SET SC_NAME = ?, SC_DESC = ?, SC_ACTOR =? , SC_ACTORCODE = ? , SC_TYPE = ?,  SC_TYPECODE = ?, SC_STATUS = ? WHERE SC_CODE = ? AND SC_INSTCODE = ?  ";
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $radiology);
	// 	$st->BindParam(2, $description);
	// 	$st->BindParam(3, $currentuser);
	// 	$st->BindParam(4, $currentusercode);
	// 	$st->BindParam(5, $radiologytypename);
	// 	$st->BindParam(6, $radiologytypecode);
	// 	$st->BindParam(7, $radiologystatus);
	// 	$st->BindParam(8, $ekey);
	// 	$st->BindParam(9, $instcode);		
	// 	$exe = $st->execute();						
	// 	if($exe){	
	// 		return $this->thepassed;								
	// 	}else{								
	// 		return $this->thefailed;								
	// 	}			
	// }	
	
	// //15 SEPT 2021
	// public function getradiologylov($instcode)
	// {
	// 	$mnm = '1';
	// 	$sql = " SELECT SC_CODE,SC_NAME,SC_PARTNERCODE FROM octopus_st_investigation_plan_list where SC_STATUS = '$mnm' AND SC_INSTCODE = '$instcode' ORDER BY SC_NAME "; 
	// 	$st = $this->db->prepare($sql); 
	// 	$st->execute();
	// 	// echo '<option value= "">-- Select --</option>';
	// 	while($obj = $st->fetch(PDO::FETCH_ASSOC)){
	// 	echo '<option value="'.$obj['SC_CODE'].'@@@'.$obj['SC_NAME'].'@@@'.$obj['SC_PARTNERCODE'].'">'.$obj['SC_NAME'].' </option>';
	// 	}
	// }
	// // 29 SEPT 2023 JOSEPH ADORBOE
	// public function getqueryimaging($instcode){		
	// 	$list = ("SELECT * from octopus_st_investigation_plan_list WHERE SC_INSTCODE = '$instcode' order by SC_NAME DESC ");
	// 	return $list;
	// }
	// // 28 Dec 2022 JOSEPH ADORBOE 
	// public function imagingedetails($idvalue,$instcode){	
	// 	$one = 1;
	// 	$sql = "SELECT * FROM octopus_st_investigation_plan_list WHERE SC_CODE = ? AND SC_INSTCODE = ? ";
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $idvalue);
	// 	$st->BindParam(2, $instcode);
	// 	$exe = $st->Execute();
	// 	if($st->rowcount() > 0){			
	// 		$obj = $st->fetch(PDO::FETCH_ASSOC);
	// 		$ordernum = $obj['SC_CODE'].'@@'.$obj['SC_CODENUM'].'@@'.$obj['SC_NAME'].'@@'.$obj['SC_DESC'].'@@'.$obj['SC_CASHPRICE'].'@@'.$obj['SC_ALTERNATEPRICE'].'@@'.$obj['SC_INSURANCEPRICE'].'@@'.$obj['SC_DOLLARPRICE'].'@@'.$obj['SC_PARTNERPRICE'] ;				
	// 	}else{			
	// 		$ordernum = $this->thefailed;			
	// 	}
	// 	return 	$ordernum; 	
		
	// }
	// // 29 Sept 2023, 29 MAY 2022 JOSEPH ADORBOE
	// public function updateimagingprices($ekey,$cashprice,$alternateprice,$dollarprice,$partnerprice,$insuranceprice,$currentuser,$currentusercode,$instcode){	
	// 	$one = 1;
	// 	$sql = "UPDATE octopus_st_investigation_plan_list SET SC_CASHPRICE = ? ,SC_ALTERNATEPRICE = ? ,SC_INSURANCEPRICE = ? ,SC_DOLLARPRICE = ? ,SC_PARTNERPRICE = ? , SC_ACTOR =? , SC_ACTORCODE = ?  WHERE SC_CODE = ? AND SC_INSTCODE = ? ";
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $cashprice);
	// 	$st->BindParam(2, $alternateprice);
	// 	$st->BindParam(3, $insuranceprice);
	// 	$st->BindParam(4, $dollarprice);
	// 	$st->BindParam(5, $partnerprice);
	// 	$st->BindParam(6, $currentuser);
	// 	$st->BindParam(7, $currentusercode);
	// 	$st->BindParam(8, $ekey);
	// 	$st->BindParam(9, $instcode);
	// 	$exe = $st->execute();						
	// 	if($exe){	
	// 		return $this->thepassed;								
	// 	}else{								
	// 		return $this->thefailed;								
	// 	}			
	// }	


	
	// // 29 NOV 2023  JOSEPH ADORBOE
    // public function addnew($form_key,$imaging,$imagingnumber,$description,$partnercode,$cashprice,$alternateprice,$dollarprice,$partnerprice,$insuranceprice, $currentuser,$currentusercode,$instcode){	
	// 	$one = 1;
	// 	$sqlstmt = ("SELECT SC_ID FROM octopus_st_investigation_plan_list Where SC_NAME = ? and  SC_INSTCODE = ?  and SC_STATUS = ? ");
	// 	$st = $this->db->prepare($sqlstmt);   
	// 	$st->BindParam(1, $imaging);
	// 	$st->BindParam(2, $instcode);
	// 	$st->BindParam(3, $one);
	// 	$check = $st->execute();
	// 	if($check){
	// 		if($st->rowcount() > 0){			
	// 			return '1';			
	// 		}else{
	// 			$sqlstmt = "INSERT INTO octopus_st_investigation_plan_list(SC_CODE,SC_CODENUM,SC_NAME,SC_DESC,SC_ACTOR,SC_ACTORCODE,SC_INSTCODE,SC_PARTNERCODE,SC_CASHPRICE,SC_ALTERNATEPRICE,SC_INSURANCEPRICE,SC_DOLLARPRICE,SC_PARTNERPRICE) 
	// 			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
	// 			$st = $this->db->prepare($sqlstmt);   
	// 			$st->BindParam(1, $form_key);
	// 			$st->BindParam(2, $imagingnumber);
	// 			$st->BindParam(3, $imaging);
	// 			$st->BindParam(4, $description);
	// 			$st->BindParam(5, $currentuser);
	// 			$st->BindParam(6, $currentusercode);
	// 			$st->BindParam(7, $instcode);
	// 			$st->BindParam(8, $partnercode);
	// 			$st->BindParam(9, $cashprice);
	// 			$st->BindParam(10, $alternateprice);
	// 			$st->BindParam(11, $insuranceprice);
	// 			$st->BindParam(12, $dollarprice);
	// 			$st->BindParam(13, $partnerprice);
	// 			$exe = $st->execute();
	// 			if($exe){			
	// 				return $this->thepassed;								
	// 			}else{								
	// 				return $this->thefailed;								
	// 			}				
	// 		}
	// 	}else{
	// 		return $this->thefailed;
	// 	}	
	// }
	// // 29 Sept 2023, 13 MAY 2021 JOSEPH ADORBOE
	// public function enableimaging($ekey,$days,$currentuser,$currentusercode,$instcode){
	// 	$zero = $this->thefailed;
	// 	$one = 1;
	// 	$reason = '';
	// 	$sql = "UPDATE octopus_st_investigation_plan_list SET SC_REASON = ?,  SC_REASONDATE = ?, SC_REASONACTOR =?, SC_REASONACTORCODE =? , SC_STATUS =? WHERE SC_CODE = ? AND SC_INSTCODE = ? ";
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $reason);
	// 	$st->BindParam(2, $days);
	// 	$st->BindParam(3, $currentuser);
	// 	$st->BindParam(4, $currentusercode);
	// 	$st->BindParam(5, $one);
	// 	$st->BindParam(6, $ekey);
	// 	$st->BindParam(7, $instcode);
	// 	$exe = $st->execute();							
	// 	if($exe){			
	// 		return $this->thepassed;								
	// 	}else{								
	// 		return $this->thefailed;								
	// 	}	
	// }
	// // 29 Sept 2023, 13 MAY 2021 JOSEPH ADORBOE
	// public function disableimagaing($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode){
	// 	$zero = $this->thefailed;
	// 	$sql = "UPDATE octopus_st_investigation_plan_list SET SC_REASON = ?,  SC_REASONDATE = ?, SC_REASONACTOR =?, SC_REASONACTORCODE =? , SC_STATUS =? WHERE SC_CODE = ? AND SC_INSTCODE = ? ";
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $disablereason);
	// 	$st->BindParam(2, $days);
	// 	$st->BindParam(3, $currentuser);
	// 	$st->BindParam(4, $currentusercode);
	// 	$st->BindParam(5, $zero);
	// 	$st->BindParam(6, $ekey);
	// 	$st->BindParam(7, $instcode);
	// 	$exe = $st->execute();							
	// 	if($exe){			
	// 		return $this->thepassed;								
	// 	}else{								
	// 		return $this->thefailed;								
	// 	}	
	// }
	// // 29 Sept 2023, 29 MAY 2022 JOSEPH ADORBOE
	// public function editimagingonly($ekey,$imaging,$imagingnumber,$description,$partnercode,$currentuser,$currentusercode,$instcode){	
	// 	$one = 1;
	// 	$sql = "UPDATE octopus_st_investigation_plan_list SET SC_CODENUM = ?, SC_NAME = ?,  SC_DESC = ?, SC_ACTOR =? , SC_ACTORCODE = ? , SC_PARTNERCODE = ? WHERE SC_CODE = ? AND SC_INSTCODE = ?  AND SC_STATUS = ?  ";
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $imagingnumber);
	// 	$st->BindParam(2, $imaging);
	// 	$st->BindParam(3, $description);
	// 	$st->BindParam(4, $currentuser);
	// 	$st->BindParam(5, $currentusercode);
	// 	$st->BindParam(6, $partnercode);
	// 	$st->BindParam(7, $ekey);
	// 	$st->BindParam(8, $instcode);
	// 	$st->BindParam(9, $one);
	// 	$exe = $st->execute();						
	// 	if($exe){	
	// 		return $this->thepassed;								
	// 	}else{								
	// 		return $this->thefailed;								
	// 	}			
	// }	


	// // 29 Sept 2023, 20 MAY 2022   JOSEPH ADORBOE
    // public function addnewimaging($form_key,$imaging,$imagingnumber,$description,$partnercode,$currentuser,$currentusercode,$instcode){	
	// 	$mt = 1;
	// 	$sqlstmt = ("SELECT SC_ID FROM octopus_st_investigation_plan_list Where (SC_NAME = ? OR SC_PARTNERCODE = ?) and  SC_INSTCODE = ?  and SC_STATUS = ? ");
	// 	$st = $this->db->prepare($sqlstmt);   
	// 	$st->BindParam(1, $imaging);
	// 	$st->BindParam(2, $partnercode);
	// 	$st->BindParam(3, $instcode);
	// 	$st->BindParam(4, $mt);
	// 	$check = $st->execute();
	// 	if($check){
	// 		if($st->rowcount() > $this->thefailed){			
	// 			return $this->theexisted;			
	// 		}else{
	// 			$sqlstmt = "INSERT INTO octopus_st_investigation_plan_list(SC_CODE,SC_CODENUM,SC_NAME,SC_DESC,SC_ACTOR,SC_ACTORCODE,SC_INSTCODE,SC_PARTNERCODE) 
	// 			VALUES (?,?,?,?,?,?,?,?) ";
	// 			$st = $this->db->prepare($sqlstmt);   
	// 			$st->BindParam(1, $form_key);
	// 			$st->BindParam(2, $imagingnumber);
	// 			$st->BindParam(3, $imaging);
	// 			$st->BindParam(4, $description);
	// 			$st->BindParam(5, $currentuser);
	// 			$st->BindParam(6, $currentusercode);
	// 			$st->BindParam(7, $instcode);
	// 			$st->BindParam(8, $partnercode);
	// 			$exe = $st->execute();
	// 			if($exe){			
	// 				return $this->thepassed;								
	// 			}else{								
	// 				return $this->thefailed;								
	// 			}				
	// 		}
	// 	}else{
	// 		return $this->thefailed;
	// 	}	
	// }	
} 
	$setupinvestigationplanlisttable = new OctopusSetupInvestigationPlanListClass();
?>