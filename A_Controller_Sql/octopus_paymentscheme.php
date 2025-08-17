<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023
	PURPOSE: TO OPERATE MYSQL QUERY	
	Based on octopus_paymentscheme
	$paymentschemetable->getpaymentschemeLov($selected,$instcode);
*/

class OctopusPaymentSchemeClass Extends Engine{
	// 15 AUG 2025, JOSEPH ADORBOE , 14 JUNE 2022
	public function getprepaidchemecode($prepaidcode,$instcode)
	{
		$mnm = 1;
		$sql = " SELECT PSC_CODE FROM octopus_paymentscheme WHERE PSC_INSTCODE = ?  AND PSC_PAYMENTMETHODCODE = ? AND PSC_STATUS = ? "; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);	
		$st->BindParam(2, $prepaidcode);	
		$st->BindParam(3, $mnm);				
		$ext = $st->execute();	
		if($ext){
			if($st->rowcount()){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$value = $obj['PSC_CODE'];				
				return $value;
			}else{
				return '0';
			}
		}else{
			return '0';
		}			
	}
	// 24 JUNE 2021
	public function getcashschemecode($cashpaymentmethodcode,$instcode)
	{
		$mnm = 1;
		$sql = " SELECT PSC_CODE FROM octopus_paymentscheme where PSC_INSTCODE = ?  and PSC_PAYMENTMETHODCODE = ? and PSC_STATUS = ? "; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);	
		$st->BindParam(2, $cashpaymentmethodcode);	
		$st->BindParam(3, $mnm);				
		$ext = $st->execute();	
		if($ext){
			if($st->rowcount()){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$value = $obj['PSC_CODE'];				
				return $value;
			}else{
				return '0';
			}
		}else{
			return '0';
		}			
	}

	// 6 MAR 2021
	public function suspendpaymentscheme($currentusercode,$currentuser,$ekey){		
		$sql = "UPDATE octopus_paymentscheme SET PSC_STATE = ?, PSC_ACTOR = ?, PSC_ACTORCODE = ?  WHERE PSC_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thezero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);		
		$suspendscheme = $st->execute();		
		if($suspendscheme){			
			return $this->thepassed;			
		}else{			
			return $this->thefailed;			
		}
	}

	// 6 MAR 2021, JOSEPH ADORBOE 
	public function activatepaymentscheme($currentusercode,$currentuser,$ekey){		
		$sql = "UPDATE octopus_paymentscheme SET PSC_STATE = ?, PSC_ACTOR = ?, PSC_ACTORCODE = ?  WHERE PSC_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->theone);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);		
		$activatescheme = $st->execute();		
		if($activatescheme){			
			return $this->thepassed;			
		}else{			
			return $this->thefailed;			
		}
	}

	// 08 JUNE 2021
	public function getpaymentschemeeditLov($selected,$instcode)
	{
		$sql = "SELECT PSC_CODE,PSC_SCHEMENAME,PSC_PAYMENTMETHOD,PSC_PAYMENTMETHODCODE FROM octopus_paymentscheme WHERE PSC_STATUS = '$this->theone' AND PSC_INSTCODE = '$instcode' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo "<option value=''>-- Select --</option>";
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'@@@'.$obj['PSC_PAYMENTMETHODCODE'].'@@@'.$obj['PSC_PAYMENTMETHOD'].'" >'.$obj['PSC_SCHEMENAME'].' </option>';
		}
	} 

	// 15 NOV 2022 JOSEPH ADORBOE 
	public function getschemepercentage($paymentschemecode,$instcode){
		$one = 1;
		$sql = 'SELECT PSC_SCHEMEPERCENTAGE FROM octopus_paymentscheme WHERE PSC_CODE = ? AND PSC_INSTCODE = ? AND PSC_STATUS = ?';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $this->theone);	
		$exrt = $st->execute();
        if($exrt){
			if($st->rowcount() > 0){			
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PSC_SCHEMEPERCENTAGE'];			
				return $price ; 			
			}else{
				return $this->thefailed;
            }

        }else{
			return $this->thefailed;
		}

	}

	// 5 NOV JOSEPH ADORBOE
	public function getpaymentschemlist($privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$instcode){		
		$list = ("SELECT * FROM octopus_paymentscheme WHERE PSC_INSTCODE = '$instcode' AND PSC_PAYMENTMETHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode') AND PSC_STATUS = '1'");
		return $list;
	}
	// 11 AUG 2023,6 MAR 2021 JOSEPH ADORBOE
	public function getpaymentschemestate($patientschemecode,$instcode) : mixed
	{
		$sql = "SELECT PSC_STATE FROM octopus_paymentscheme WHERE PSC_CODE = ? and PSC_INSTCODE = ? ";
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
				return $this->thefailed;
			}
		}else{
			return $this->thefailed;
		}	
	}

		
} 
$paymentschemetable = new OctopusPaymentSchemeClass();
?>