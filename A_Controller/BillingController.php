<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 19 JULY 2021
	PURPOSE: TO OPERATE MYSQL QUERY 
	
*/


class billingController Extends Engine
{

	// 10 MAR 2023 JOSEPH ADORBOE 
	public function billingrejectransactions($bcode,$servicecode,$dpts,$visitcode,$instcode,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode){		
	
		$two = 2;
		$zero  = '0';
		$cash = 'CASH';
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_STATE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $two);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{
								
				$sql = "UPDATE octopus_patients_billitems SET B_STATE = ? , B_STATUS = ? , B_COMPLETE = ? WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $zero);
				$st->BindParam(4, $bcode);
				$st->BindParam(5, $instcode);
				$st->BindParam(6, $visitcode);
				$selectitem = $st->Execute();
				
				
				// $ut = 1;
				// $sql = "UPDATE octopus_patients_billing SET BG_AMOUNT = BG_AMOUNT + ?, BG_AMOUNTBAL = BG_AMOUNTBAL + ? WHERE BG_CODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? AND BG_TYPE = ? ";
				// $st = $this->db->prepare($sql);
				// $st->BindParam(1, $amt);
				// $st->BindParam(2, $amt);
				// $st->BindParam(3, $billgeneratedcode);
				// $st->BindParam(4, $instcode);
				// $st->BindParam(5, $visitcode);
				// $st->BindParam(6, $ut);
				// $st->BindParam(7, $type);
				// $selectitem = $st->Execute(); $cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode
					if($selectitem){
							$selected = 1;
							$unselected = '0';
							if($dpts == 'SERVICES'){				
								
								$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ?, REQU_STATE = ?, REQU_PAYMENTMETHODCODE = ? , REQU_PAYMENTMETHOD = ?  , REQU_PAYSCHEMECODE = ? , REQU_PAYSCHEME = ?  WHERE REQU_CODE = ? and REQU_VISITCODE = ? and REQU_INSTCODE = ? ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $selected);
								$st->BindParam(2, $selected);
								$st->BindParam(3, $cashpaymentmethodcode);
								$st->BindParam(4, $cashpaymentmethod);
								$st->BindParam(5, $cashschemecode);
								$st->BindParam(6, $cash);
								$st->BindParam(7, $servicecode);
								$st->BindParam(8, $visitcode);
								$st->BindParam(9, $instcode);
								$selectitem = $st->Execute();				
									if($selectitem){						
										return '2' ;						
									}else{						
										return '0' ;						
									}

							}else if($dpts == 'LABS'){
								
								$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_STATUS = ?, MIV_PAYMENTMETHODCODE =? , MIV_PAYMENTMETHOD = ?, MIV_SCHEMECODE = ?, MIV_SCHEME = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ?  and MIV_SELECTED = ? AND MIV_INSTCODE = ? ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $selected);
								$st->BindParam(2, $selected);
								$st->BindParam(3, $cashpaymentmethodcode);
								$st->BindParam(4, $cashpaymentmethod);
								$st->BindParam(5, $cashschemecode);
								$st->BindParam(6, $cash);
								$st->BindParam(7, $servicecode);
								$st->BindParam(8, $visitcode);
								$st->BindParam(9, $unselected);
								$st->BindParam(10, $instcode);
								$selectitem = $st->Execute();				
									if($selectitem){						
										return '2' ;						
									}else{						
										return '0' ;						
									}
							}else if($dpts == 'IMAGING'){
								
									$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_STATUS = ?, MIV_PAYMENTMETHODCODE =? , MIV_PAYMENTMETHOD = ?, MIV_SCHEMECODE = ?, MIV_SCHEME = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ?  and MIV_SELECTED = ? AND MIV_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $selected);
									$st->BindParam(3, $cashpaymentmethodcode);
									$st->BindParam(4, $cashpaymentmethod);
									$st->BindParam(5, $cashschemecode);
									$st->BindParam(6, $cash);
									$st->BindParam(7, $servicecode);
									$st->BindParam(8, $visitcode);
									$st->BindParam(9, $unselected);
									$st->BindParam(10, $instcode);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0' ;						
										}
								
							}else if($dpts == 'PHARMACY'){

								$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ?, PRESC_STATUS =?, PRESC_PAYMENTMETHODCODE =? , PRESC_PAYMENTMETHOD = ?, PRESC_PAYSCHEMECODE = ?, PRESC_PAYSCHEME = ?   WHERE PRESC_CODE = ? AND PRESC_VISITCODE = ? and PRESC_SELECTED = ? AND PRESC_INSTCODE = ? ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $selected);
								$st->BindParam(2, $selected);
								$st->BindParam(3, $cashpaymentmethodcode);
								$st->BindParam(4, $cashpaymentmethod);
								$st->BindParam(5, $cashschemecode);
								$st->BindParam(6, $cash);
								$st->BindParam(7, $servicecode);
								$st->BindParam(8, $visitcode);
								$st->BindParam(9, $unselected);
								$st->BindParam(10, $instcode);
								$selectitem = $st->Execute();				
									if($selectitem){						
										return '2' ;						
									}else{						
										return '0' ;						
									}

							}else if($dpts == 'DEVICES'){

									$sql = "UPDATE octopus_patients_devices SET PD_STATUS = ?, PD_STATE = ? , PD_PAYMENTMETHODCODE =? , PD_PAYMENTMETHOD = ?, PD_SCHEMECODE = ?, PD_SCHEME = ? WHERE PD_CODE = ? and PD_VISITCODE = ? and PD_SELECTED = ? and PD_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $selected);
									$st->BindParam(3, $cashpaymentmethodcode);
									$st->BindParam(4, $cashpaymentmethod);
									$st->BindParam(5, $cashschemecode);
									$st->BindParam(6, $cash);
									$st->BindParam(7, $servicecode);
									$st->BindParam(8, $visitcode);
									$st->BindParam(9, $unselected);
									$st->BindParam(10, $instcode);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0' ;						
										}

								}else if($dpts == 'PROCEDURE'){

									$sql = "UPDATE octopus_patients_procedures SET PPD_STATUS = ?, PPD_STATE = ? , PPD_PAYMENTMETHODCODE =? , PPD_PAYMENTMETHOD = ?, PPD_PAYSCHEMECODE = ?, PPD_PAYSCHEME = ?  WHERE PPD_CODE = ? and PPD_VISITCODE = ? and PPD_SELECTED = ? and PPD_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $selected);
									$st->BindParam(3, $cashpaymentmethodcode);
									$st->BindParam(4, $cashpaymentmethod);
									$st->BindParam(5, $cashschemecode);
									$st->BindParam(6, $cash);
									$st->BindParam(7, $servicecode);
									$st->BindParam(8, $visitcode);
									$st->BindParam(9, $unselected);
									$st->BindParam(10, $instcode);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0' ;						
										}

								}else if($dpts == 'MEDREPORTS'){
										$sql = "UPDATE octopus_patients_medicalreports SET MDR_STATUS = ? , MDR_STATE = ? WHERE MDR_CODE = ?  and MDR_INSTCODE = ? ";
										$st = $this->db->prepare($sql);
										$st->BindParam(1, $selected);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $servicecode);
										$st->BindParam(4, $instcode);
										$selectitem = $st->Execute();				
											if($selectitem){						
												return '2' ;						
											}else{						
												return '0' ;						
											}
							}else{
								return '1';
							}					
												
					}else{						
						return '0' ;						
					}
				}			
		}else{			
			return '0' ;			
		}	
	}

	
	// 01 MAR 2023
	public function billingunselectiontransactions($bcode,$billcode,$billingcode,$amt,$servicecode,$dpts,$visitcode,$instcode){
		
		//die($billingcode);
		$but = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? and B_INSTCODE = ? and B_VISITCODE = ? AND  B_STATE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $but);
		$unselect = $st->execute();
		if($unselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{
				$selected = 2;
				$unselected = 1;
				$retvial = 0;
				$sql = "UPDATE octopus_patients_billitems SET B_STATE = ? WHERE B_CODE = ? and B_VISITCODE = ? AND B_INSTCODE = ? AND  B_STATE = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $unselected);
				$st->BindParam(2, $bcode);
				$st->BindParam(3, $visitcode);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $selected);
				$billitems = $st->Execute();	

			// 	$ut = 1;
			// 	$sql = "UPDATE octopus_patients_billing SET BG_AMOUNT = BG_AMOUNT - ?, BG_AMOUNTBAL = BG_AMOUNTBAL - ?  WHERE BG_CODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? ";
			// 	$st = $this->db->prepare($sql);
			// 	$st->BindParam(1, $amt);
			// 	$st->BindParam(2, $amt);
			// 	$st->BindParam(3, $billingcode);
			// 	$st->BindParam(4, $instcode);
			// 	$st->BindParam(5, $visitcode);
			// 	$st->BindParam(6, $ut);
			// //	$st->BindParam(6, $visitcode);
			// 	$selectitem = $st->Execute();
				if($billitems){
					return '2';												
				}else{						
					return '0' ;						
				}
				}			
			}else{			
				return '0' ;			
			}	
	}

	// 01 MAR 2023 JOSEPH ADORBOE 
	public function billingselectiontransactions($bcode,$billgeneratedcode,$amt,$servicecode,$dpts,$visitcode,$instcode){

		$but = 2;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_STATE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $but);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{
				$nt = 2;
				$sql = "UPDATE octopus_patients_billitems SET B_STATE = ? , B_BILLGENERATEDCODE = ? WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nt);
				$st->BindParam(2, $billgeneratedcode);
				$st->BindParam(3, $bcode);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $visitcode);
				$selectitem = $st->Execute();
				
			// 	$ut = 1;
			// 	$sql = "UPDATE octopus_patients_billing SET BG_AMOUNT = BG_AMOUNT + ?, BG_AMOUNTBAL = BG_AMOUNTBAL + ? WHERE BG_CODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? ";
			// 	$st = $this->db->prepare($sql);
			// 	$st->BindParam(1, $amt);
			// 	$st->BindParam(2, $amt);
			// 	$st->BindParam(3, $billgeneratedcode);
			// 	$st->BindParam(4, $instcode);
			// 	$st->BindParam(5, $visitcode);
			// 	$st->BindParam(6, $ut);
			// //	$st->BindParam(6, $visitcode);
			// 	$selectitem = $st->Execute();
					if($selectitem){
							return '2';						
					}else{						
						return '0' ;						
					}
				}			
		}else{			
			return '0' ;			
		}	
	}


	// 01 MAR 2023 JOSEPH ADORBOE 
	public function processclaimsschemes($days,$claimsamount,$claimmethodcode,$claimmethod,$claimschemecode,$claimscheme,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode){

		$two = 2;
		$one = 1;
		$zero = 0;
		$sqlstmt = ("SELECT * FROM octopus_claims_scheme  where CLAM_MONTH = ? AND CLAM_INSTCODE = ? AND CLAM_YEAR = ? AND CLAM_SCHEMECODE = ? AND CLAM_STATUS = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $claimmonth);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $claimyear);
		$st->BindParam(4, $claimschemecode);
		$st->BindParam(5, $one);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){	
				$sql = "UPDATE octopus_claims_scheme SET CLAM_AMOUNT = CLAM_AMOUNT + ? , CLAM_BAL =  CLAM_BAL + ? WHERE CLAM_MONTH = ? AND CLAM_INSTCODE = ? AND CLAM_YEAR = ? AND  CLAM_STATUS = ? AND CLAM_METHODCODE = ?  AND CLAM_SCHEMECODE = ?";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $claimsamount);
				$st->BindParam(2, $claimsamount);
				$st->BindParam(3, $claimmonth);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $claimyear);
				$st->BindParam(6, $one);
				$st->BindParam(7, $claimmethodcode);
				$st->BindParam(8, $claimschemecode);
				$selectitem = $st->Execute();   
				if ($selectitem) {
					return '2' ;
				} else {
					return '0' ;
				}						
					
			}else{   
				$insertinurancetill =  "INSERT INTO octopus_claims_scheme (CLAM_CODE,CLAM_NUMBER,CLAM_METHODCODE,CLAM_METHOD,CLAM_SCHEME,CLAM_SCHEMECODE,CLAM_DATE,CLAM_AMOUNT,CLAM_AMOUNTPAID,CLAM_TAX,CLAM_BAL,CLAM_MONTH,CLAM_YEAR,CLAM_ACTOR,CLAM_ACTORCODE,CLAM_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($insertinurancetill);
				$st->BindParam(1, $clamskeycode);
				$st->BindParam(2, $claimnumber);
				$st->BindParam(3, $claimmethodcode);
				$st->BindParam(4, $claimmethod);
				$st->BindParam(5, $claimscheme);
				$st->BindParam(6, $claimschemecode);
				$st->BindParam(7, $days);
				$st->BindParam(8, $claimsamount);
				$st->BindParam(9, $zero);
				$st->BindParam(10, $zero);
				$st->BindParam(11, $claimsamount);
				$st->BindParam(12, $claimmonth);
				$st->BindParam(13, $claimyear);
				$st->BindParam(14, $currentuser);
				$st->BindParam(15, $currentusercode);
				$st->BindParam(16, $instcode);
				$selectitem = $st->Execute();
				if ($selectitem) {
					return '2' ;
				} else {
					return '0' ;
				}        
    	}
		
	}else{
		return '0' ;
	}	
		
	}

	// 01 MAR 2023 JOSEPH ADORBOE 
	public function processclaimsmonthly($days,$claimsamount,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode){
		$two = 2;
		$one = 1;
		$zero = 0;
		$sqlstmt = ("SELECT * FROM octopus_claims_monthly where CLAM_MONTH = ? AND CLAM_INSTCODE = ? AND CLAM_YEAR = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $claimmonth);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $claimyear);
	//	$st->BindParam(4, $two);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				$sql = "UPDATE octopus_claims_monthly SET CLAM_AMOUNT = CLAM_AMOUNT + ? , CLAM_BAL =  CLAM_BAL + ? WHERE CLAM_MONTH = ? AND CLAM_INSTCODE = ? AND CLAM_YEAR = ? AND  CLAM_STATUS = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $claimsamount);
				$st->BindParam(2, $claimsamount);
				$st->BindParam(3, $claimmonth);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $claimyear);
				$st->BindParam(6, $one);
				$selectitem = $st->Execute();   
				if ($selectitem) {
					return '2' ;
				} else {
					return '0' ;
				}				
			}else{           
       
				$insertinurancetill =  "INSERT INTO octopus_claims_monthly (CLAM_CODE,CLAM_NUMBER,CLAM_DATE,CLAM_AMOUNT,CLAM_BAL,CLAM_MONTH,CLAM_YEAR,CLAM_ACTOR,CLAM_ACTORCODE,CLAM_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($insertinurancetill);
				$st->BindParam(1, $clamskeycode);
				$st->BindParam(2, $claimnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $claimsamount);
				$st->BindParam(5, $claimsamount);
				$st->BindParam(6, $claimmonth);
				$st->BindParam(7, $claimyear);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$selectitem = $st->Execute();
				if ($selectitem) {
					return '2' ;
				} else {
					return '0' ;
				}
        	}
		
		}else{
			return '0' ;
		}	
		
	}
	

	// 21 FEB 2023  JOSEPH ADORBOE
	public function getcurrentbillingtotal($currentshiftcode,$instcode){	
		$nut = 1;
		$two =2;	
		$sql = 'SELECT * FROM octopus_cashier_summary WHERE CS_SHIFTCODE = ? AND CS_INSTCODE = ? AND CS_STATUS = ? AND CS_TYPE = ?';
		$st = $this->db->prepare($sql);
	//	$st->BindParam(1, $currentusercode);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$st->BindParam(4, $two);
		$ext = $st->execute();
		if($ext){		
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				// 							0					
				$currentdetails = $obj['CS_TOTAL'];				
				return $currentdetails;					
			}else{
				return '0';
			}
		}else{
			return '0';
		}	
	}



	// 05 FEB 2023 JOSEPH ADORBOE 
	public function processclaimsperformedtransactionsclose($claimscodes,$visitcode,$instcode){

		$one = 1;
		$two = 2;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CLAIMSCODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_PREFORMED = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $claimscodes);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $one);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{               
                $sql = "UPDATE octopus_patients_claims SET CLAIM_STATUS = ?  WHERE CLAIM_CODE = ? AND CLAIM_INSTCODE = ? AND CLAIM_VISITCODE = ? AND  CLAIM_STATUS = ?";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $two);
				$st->BindParam(2, $claimscodes);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $visitcode);
				$st->BindParam(5, $one);
				$selectitem = $st->Execute();
                if ($selectitem) {
                    return '2' ;
                } else {
                    return '0' ;
                }
            }		
		}
	}
	

	// 05 FEB 2023 JOSEPH ADORBOE 
	public function processclaimsperformedtransactions($bcode,$days,$claimscode,$claimsnumber,$claimsamount,$visitcode,$claimmethodcode,$claimmethod,$claimschemecode,$claimscheme,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode){

		$two = 2;
		$one = 1;
		$zero = 0;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_PREFORMED = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $two);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{
    $sql = "UPDATE octopus_patients_billitems SET B_PREFORMED = ? ,B_CLAIMSDATE =? WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND  B_PREFORMED = ? ";
    $st = $this->db->prepare($sql);
    $st->BindParam(1, $two);
    $st->BindParam(2, $days);
    $st->BindParam(3, $bcode);
    $st->BindParam(4, $instcode);
    $st->BindParam(5, $visitcode);
    $st->BindParam(6, $one);
    $selectitem = $st->Execute();

    $sql = "UPDATE octopus_patients_claims SET CLAIMS_TRANSNUM = CLAIMS_TRANSNUM + ? , CLAIM_TOTAL =  CLAIM_TOTAL + ? WHERE CLAIM_CODE = ? AND CLAIM_INSTCODE = ? AND CLAIM_VISITCODE = ? AND  CLAIM_STATUS = ? AND CLAIM_NUMBER = ?";
    $st = $this->db->prepare($sql);
    $st->BindParam(1, $one);
    $st->BindParam(2, $claimsamount);
    $st->BindParam(3, $claimscode);
    $st->BindParam(4, $instcode);
    $st->BindParam(5, $visitcode);
    $st->BindParam(6, $one);
    $st->BindParam(7, $claimsnumber);
    $selectitem = $st->Execute();

    $sqlstmt = ("SELECT * FROM octopus_claims where CLAM_SCHEMECODE = ? AND CLAM_MONTH = ? AND CLAM_INSTCODE = ? AND CLAM_STATUS = ? ");
    $st = $this->db->prepare($sqlstmt);
    $st->BindParam(1, $claimschemecode);
    $st->BindParam(2, $claimmonth);
    $st->BindParam(3, $instcode);
    $st->BindParam(4, $one);
    $checkselect = $st->execute();
    if ($checkselect) {
        if ($st->rowcount() > 0) {

			$sql = "UPDATE octopus_claims SET CLAM_AMOUNT = CLAM_AMOUNT + ? , CLAM_BAL =  CLAM_BAL + ? WHERE CLAM_SCHEMECODE = ? AND CLAM_MONTH = ? AND CLAM_INSTCODE = ? AND  CLAM_STATUS = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $claimsamount);
			$st->BindParam(2, $claimsamount);
			$st->BindParam(3, $claimschemecode);
			$st->BindParam(4, $claimmonth);
			$st->BindParam(5, $instcode);
			$st->BindParam(6, $one);
			$selectitem = $st->Execute();
			if ($selectitem) {
                return '2' ;
            } else {
                return '0' ;
            }
            
        } else {
            $insertinurancetill =  "INSERT INTO octopus_claims (CLAM_CODE,CLAM_NUMBER,CLAM_METHODCODE,CLAM_METHOD,CLAM_SCHEME,CLAM_SCHEMECODE,CLAM_DATE,CLAM_AMOUNT,CLAM_AMOUNTPAID,CLAM_TAX,CLAM_BAL,CLAM_MONTH,CLAM_YEAR,CLAM_ACTOR,CLAM_ACTORCODE,CLAM_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
            $st = $this->db->prepare($insertinurancetill);
            $st->BindParam(1, $clamskeycode);
            $st->BindParam(2, $claimnumber);
            $st->BindParam(3, $claimmethodcode);
            $st->BindParam(4, $claimmethod);
            $st->BindParam(5, $claimscheme);
            $st->BindParam(6, $claimschemecode);
            $st->BindParam(7, $days);
            $st->BindParam(8, $claimsamount);
            $st->BindParam(9, $zero);
            $st->BindParam(10, $zero);
            $st->BindParam(11, $claimsamount);
            $st->BindParam(12, $claimmonth);
            $st->BindParam(13, $claimyear);
            $st->BindParam(14, $currentuser);
            $st->BindParam(15, $currentusercode);
            $st->BindParam(16, $instcode);
            $selectitem = $st->Execute();
            if ($selectitem) {
                return '2' ;
            } else {
                return '0' ;
            }
        }
    }
	} 
		
	}else{
		return '0' ;
	}	
		
	}
	

	// 05 FEB 20223 JOSEPH ADORBOE 
	public function getclaimsmain($patientcode,$visitcode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_claims where CLAIM_VISITCODE = ? and CLAIM_PATIENTCODE = ? and CLAIM_INSTCODE = ? and CLAIM_STATUS IN('1','2','4')  ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
	//	$st->BindParam(4, $visitcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CLAIM_DATE'].'@'.$object['CLAIM_PAYSCHEME'].'@'.$object['CLAIM_METHOD'].'@'.$object['CLAIMS_TRANSNUM'].'@'.$object['CLAIM_TOTAL'].'@'.$object['CLAIM_CODE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}
	

	// 01 FEB 2023 JOSEPH ADORBOE 
	public function getinsurancesummarycode($day,$tillcode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift){
		
		$but = 1;
		$amt = 0;
		$two =2;
		$sqlstmt = ("SELECT * FROM octopus_cashier_summary where CS_DATE = ? AND CS_INSTCODE = ? AND CS_TYPE = ?  AND CS_STATUS = ? AND  CS_SHIFTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $transactiondate);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $two);
		$st->BindParam(4, $but);
		$st->BindParam(5, $transactionshiftcode);
		
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				return $object['CS_CODE'];				 				
			}else{
				$insertinurancetill =  "INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_TYPE,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($insertinurancetill);
				$st->BindParam(1, $tillcode);
				$st->BindParam(2, $transactiondate);
				$st->BindParam(3, $transactionshift);
				$st->BindParam(4, $transactionshiftcode);
				$st->BindParam(5, $amt);
				$st->BindParam(6, $two);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);				
                $selectitem = $st->Execute();
                if ($selectitem) {
                    return $tillcode ;
                } else {
                    return '0' ;
                }
            }	
		
	}
	}

	// 01 FEB 2023 JOSEPH ADORBOE 
	public function getinsurancetillcode($day,$paycode,$payname,$paymethcode,$paymeth,$tillcode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift){
		

		$but = 1;
		$amt = 0;
		$two =2;
		$sqlstmt = ("SELECT * FROM octopus_cashier_tills where TILL_DATE = ? AND TILL_INSTCODE = ? AND TILL_ACTORCODE = ? AND TILL_PAYMENTMETHODCODE = ? AND TILL_SCHEMECODE = ? AND TILL_STATUS = ? AND  TILL_SHIFTCODE = ? AND TILL_TYPE = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $transactiondate);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $paymethcode);
		$st->BindParam(5, $paycode);
		$st->BindParam(6, $but);
		$st->BindParam(7, $transactionshiftcode);
		$st->BindParam(8, $two);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				return $object['TILL_CODE'];				 				
			}else{
				$insertinurancetill =  "INSERT INTO octopus_cashier_tills (TILL_CODE,TILL_DATE,TILL_SHIFT,TILL_SHIFTCODE,TILL_PAYMENTMETHOD,TILL_PAYMENTMETHODCODE,TILL_SCHEME,TILL_SCHEMECODE,TILL_AMOUNT,TILL_ALTAMOUNT,TILL_TYPE,TILL_INSTCODE,TILL_ACTOR,TILL_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($insertinurancetill);
				$st->BindParam(1, $tillcode);
				$st->BindParam(2, $transactiondate);
				$st->BindParam(3, $transactionshift);
				$st->BindParam(4, $transactionshiftcode);
				$st->BindParam(5, $paymeth);
				$st->BindParam(6, $paymethcode);
				$st->BindParam(7, $payname);
				$st->BindParam(8, $paycode);
				$st->BindParam(9, $amt);
				$st->BindParam(10, $amt);
				$st->BindParam(11, $two);
				$st->BindParam(12, $instcode);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
                $selectitem = $st->Execute();
                if ($selectitem) {
                    return $tillcode ;
                } else {
                    return '0' ;
                }
            }	
		
	}
	}

	// 12 MAR 2021  JOSEPH ADORBOE
	public function generatereceiptdefered($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$insurancetillcode,$insurancesummarycode, $billingcode,$fkey,$currentday,$currentmonth,$currentyear,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift)
	{
		$bal = 0;
		$two = 2;
		$na = 'NA';
		$one = 1;
		$three = 3;
    $sqlstmt = ("SELECT * FROM octopus_patients_reciept where BP_CODE = ? AND BP_INSTCODE = ?");
    $st = $this->db->prepare($sqlstmt);
    $st->BindParam(1, $form_key);
    $st->BindParam(2, $instcode);
    $details =	$st->execute();
    if ($details) {
        if ($st->rowcount() =='0') {
            $sql = ("INSERT INTO octopus_patients_billingpayments (BPT_CODE,BPT_VISITCODE,BPT_BILLINGCODE,BPT_DATE,BPT_DATETIME,BPT_PATIENTCODE,BPT_PATIENTNUMBER,BPT_PATIENT,BPT_PAYSCHEMECODE,BPT_PAYSCHEME,BPT_METHOD,BPT_METHODCODE,BPT_AMOUNTPAID,BPT_TOTALAMOUNT,BPT_TOTALBAL,BPT_INSTCODE,BPT_ACTORCODE,BPT_ACTOR,BPT_SHIFTCODE,BPT_SHIFT,BPT_DAY,BPT_MONTH,BPT_YEAR,BPT_PHONENUMBER,BPT_CHEQUENUMBER,BPT_BANKCODE,BPT_BANK,BPT_CASHIERTILLCODE,BPT_RECEIPTNUMBER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $form_key);
            $st->BindParam(2, $visitcode);
            $st->BindParam(3, $billingcode);
            $st->BindParam(4, $transactiondate);
            $st->BindParam(5, $days);
            $st->BindParam(6, $patientcode);
            $st->BindParam(7, $patientnumber);
            $st->BindParam(8, $patient);
            $st->BindParam(9, $paycode);
            $st->BindParam(10, $payname);
            $st->BindParam(11, $paymeth);
            $st->BindParam(12, $paymethcode);
            $st->BindParam(13, $amountpaid);
            $st->BindParam(14, $totalamount);
            $st->BindParam(15, $bal);
            $st->BindParam(16, $instcode);
            $st->BindParam(17, $currentusercode);
            $st->BindParam(18, $currentuser);
            $st->BindParam(19, $transactionshiftcode);
            $st->BindParam(20, $transactionshift);
            $st->BindParam(21, $transactionday);
            $st->BindParam(22, $transactionmonth);
            $st->BindParam(23, $transactionyear);
            $st->BindParam(24, $phonenumber);
            $st->BindParam(25, $chequenumber);
            $st->BindParam(26, $na);
            $st->BindParam(27, $na);
            $st->BindParam(28, $insurancetillcode);
			$st->BindParam(29, $receiptnumber);			
            $open = $st->execute();
			if($open){
				$sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT + ? ,TILL_ALTAMOUNT = TILL_ALTAMOUNT + ?  where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? AND TILL_CODE = ? AND TILL_TYPE = ?  ";
				$st = $this->db->prepare($sqlstmts);
				$st->BindParam(1, $amountpaid);
				$st->BindParam(2, $amountpaid);
				$st->BindParam(3, $transactionshiftcode);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $paycode);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $insurancetillcode);
            	$st->BindParam(8, $two);
				$tills = $st->execute();
				
				$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? AND CS_CODE = ? AND CS_TYPE = ?";
				$st = $this->db->prepare($sqlstmtst);
				$st->BindParam(1, $amountpaid);
				$st->BindParam(2, $transactionshiftcode);
				$st->BindParam(3, $one);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $insurancesummarycode);
				$st->BindParam(6, $two);
           		$dt = $st->execute();

				   

				   $sql = ("INSERT INTO octopus_patients_reciept (BP_CODE,BP_DATE,BP_PATIENTCODE,BP_PATIENTNUMBER,BP_PATIENT,BP_BILLCODE,BP_DESC,BP_SHIFTCODE,BP_SHIFT,BP_CASHIERTILLSCODE,BP_SCHEME,BP_SCHEMCODE,BP_VISITCODE,BP_TOTAL,BP_AMTPAID,BP_ACTORCODE,BP_ACTOR,BP_INSTCODE,BP_CHANGE,BP_RECIEPTNUMBER,BP_METHOD,BP_METHODCODE,BP_STATE,BP_PHONENUMBER,BP_CHEQUENUMBER,BP_INSURANCEBAL,BP_BANKSCODE,BP_BANKS,BP_DT,BP_BILLINGCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
				   $st = $this->db->prepare($sql);
				   $st->BindParam(1, $fkey);
				   $st->BindParam(2, $transactiondate);
				   $st->BindParam(3, $patientcode);
				   $st->BindParam(4, $patientnumber);
				   $st->BindParam(5, $patient);
				   $st->BindParam(6, $billcode);
				   $st->BindParam(7, $remarks);
				   $st->BindParam(8, $transactionshiftcode);
				   $st->BindParam(9, $transactionshift);
				   $st->BindParam(10, $insurancetillcode);
				   $st->BindParam(11, $payname);
				   $st->BindParam(12, $paycode);
				   $st->BindParam(13, $visitcode);
				   $st->BindParam(14, $totalamount);
				   $st->BindParam(15, $amountpaid);
				   $st->BindParam(16, $currentusercode);
				   $st->BindParam(17, $currentuser);
				   $st->BindParam(18, $instcode);
				   $st->BindParam(19, $chang);
				   $st->BindParam(20, $receiptnumber);
				   $st->BindParam(21, $paymeth);
				   $st->BindParam(22, $paymethcode);
				   $st->BindParam(23, $state);
				   $st->BindParam(24, $phonenumber);
				   $st->BindParam(25, $chequenumber);
				   $st->BindParam(26, $insurancebal);
				   $st->BindParam(27, $bankcode);
				   $st->BindParam(28, $bankname);
				   $st->BindParam(29, $days);
				   $st->BindParam(30, $billingcode);
				   $genreceipt = $st->execute();
				   if($genreceipt){

					$sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PAYDATE = ?, B_RECIPTNUM = ?, B_PAYACTOR = ?, B_PAYACTORCODE = ? , B_PAYSHIFTCODE = ? , B_PAYSHIFT = ?, B_COMPLETE = ?, B_PAYMETHODCODE = ?, B_PAYMETHOD = ? WHERE B_VISITCODE = ? AND B_STATE = ? ");
                    $st = $this->db->prepare($sql);
                    $st->BindParam(1, $two);
                    $st->BindParam(2, $three);
                    $st->BindParam(3, $transactiondate);
                    $st->BindParam(4, $fkey);
                    $st->BindParam(5, $currentuser);
                    $st->BindParam(6, $currentusercode);
                    $st->BindParam(7, $transactionshiftcode);
                    $st->BindParam(8, $transactionshift);
                    $st->BindParam(9, $two);
                    $st->BindParam(10, $paycode);
                    $st->BindParam(11, $payname);
                    $st->BindParam(12, $visitcode);
                    $st->BindParam(13, $two);
                    $updtebilitems = $st->execute();

				 	$sql = ("UPDATE octopus_patients_bills SET BILL_RECEIPTNUMBER = ?, BILL_ACTOR = ?, BILL_ACTORCODE = ?, BILL_STATUS = ? WHERE BILL_CODE = ?");
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $fkey);
					$st->BindParam(2, $currentuser);
					$st->BindParam(3, $currentusercode);
					$st->BindParam(4, $two);
					$st->BindParam(5, $billcode);
					$updatebills = $st->execute();

					$sql = "UPDATE octopus_patients_discounts SET PDS_RECEIPTCODE = ? , PDS_STATUS = ?  WHERE PDS_PATIENTCODE = ? AND  PDS_STATUS = ? AND PDS_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $fkey);
					$st->BindParam(2, $two);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $one);
					$st->BindParam(5, $instcode);
					$recipt = $st->Execute();

					$sql = "UPDATE octopus_patients_billing SET BG_STATUS = ?, BG_RECEIPTNUMBER = ? WHERE BG_CODE = ? AND  BG_STATUS = ? AND BG_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $two);
					$st->BindParam(2, $receiptnumber);
					$st->BindParam(3, $billingcode);
					$st->BindParam(4, $one);
					$st->BindParam(5, $instcode);
					$reciptbill = $st->Execute();

					$sql = "UPDATE octopus_patients_billingpayments SET BPT_RECEIPTNUMBER = ? WHERE BPT_BILLINGCODE = ? AND  BPT_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $receiptnumber);
					$st->BindParam(2, $billingcode);
					$st->BindParam(3, $instcode);
					$receiptpayment = $st->Execute();

					$sql = "UPDATE octopus_current SET CU_RECEIPTNUMBER = CU_RECEIPTNUMBER + ?  WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $one);
					$st->BindParam(2, $instcode);
					$reciptnum = $st->Execute();

					$selected = 2;
					$unselected = 1;
					$paid = 4;
					$show = 7;

					$sqlmed = "UPDATE octopus_patients_medicalreports SET MDR_STATUS = ? , MDR_SELECTED = ?  WHERE MDR_PATIENTCODE = ? and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
					$st = $this->db->prepare($sqlmed);
					$st->BindParam(1, $selected);
					$st->BindParam(2, $selected);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $unselected);
					$st->BindParam(5, $instcode);
					$med = $st->Execute();
				
					$sqlservice = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? , REQU_SHOW = ? , REQU_SELECTED = ?  WHERE REQU_VISITCODE = ? and REQU_SELECTED = ? and REQU_INSTCODE = ? AND  REQU_PATIENTCODE = ?";
					$st = $this->db->prepare($sqlservice);
					$st->BindParam(1, $selected);
					$st->BindParam(2, $show);
					$st->BindParam(3, $selected);
					$st->BindParam(4, $visitcode);
					$st->BindParam(5, $unselected);
					$st->BindParam(6, $instcode);
					$st->BindParam(7, $patientcode);
					$servicerequest = $st->Execute();

					$sqllabs = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_STATUS = ? , MIV_SELECTED = ?  WHERE MIV_VISITCODE = ? and MIV_SELECTED = ? AND MIV_INSTCODE = ? AND MIV_PATIENTCODE =? ";
						$st = $this->db->prepare($sqllabs);
						$st->BindParam(1, $paid);
						$st->BindParam(2, $selected);
						$st->BindParam(3, $selected);
						$st->BindParam(4, $visitcode);
						$st->BindParam(5, $unselected);
						$st->BindParam(6, $instcode);
						$st->BindParam(7, $patientcode);
						$labs = $st->Execute();

						$sqlprescriptions = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_STATUS = ? , PRESC_SELECTED = ? , PRESC_DISPENSE = ?  WHERE PRESC_VISITCODE = ? and PRESC_SELECTED = ? AND PRESC_PATIENTCODE = ?";
						$st = $this->db->prepare($sqlprescriptions);
						$st->BindParam(1, $paid);
						$st->BindParam(2, $selected);
						$st->BindParam(3, $selected);
						$st->BindParam(4, $unselected);
						$st->BindParam(5, $visitcode);
						$st->BindParam(6, $unselected);
						$st->BindParam(7, $patientcode);
						$prescriptions = $st->Execute();

						$sqldevices = "UPDATE octopus_patients_devices SET PD_STATE = ? , PD_STATUS = ? , PD_SELECTED = ?, PD_DISPENSE = ?  WHERE PD_VISITCODE = ? and PD_SELECTED = ? AND PD_PATIENTCODE = ?";
						$st = $this->db->prepare($sqldevices);
						$st->BindParam(1, $paid);
						$st->BindParam(2, $selected);
						$st->BindParam(3, $selected);
						$st->BindParam(4, $unselected);
						$st->BindParam(5, $visitcode);
						$st->BindParam(6, $unselected);
						$st->BindParam(7, $patientcode);
						$devices = $st->Execute();

						$sqlprocedure = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_STATUS = ? , PPD_SELECTED = ? , PPD_DISPENSE = ?  WHERE  PPD_VISITCODE = ? and  PPD_SELECTED = ? AND PPD_PATIENTCODE = ? ";
						$st = $this->db->prepare($sqlprocedure);
						$st->BindParam(1, $paid);
						$st->BindParam(2, $selected);
						$st->BindParam(3, $selected);
						$st->BindParam(4, $unselected);
						$st->BindParam(5, $visitcode);
						$st->BindParam(6, $unselected);
						$st->BindParam(7, $patientcode);
						$procedure = $st->Execute();

					return '2';

				   }else{
					return '0';
				   }


				
				//return '2';
			}else{
				return '0';
			}	
        } else {
            return '0';
        }
    } else {
        return '0';
    }
}		

          		
		// $sql = ("INSERT INTO octopus_patients_reciept (BP_CODE,BP_DATE,BP_PATIENTCODE,BP_PATIENTNUMBER,BP_PATIENT,BP_BILLCODE,BP_DESC,BP_SHIFTCODE,BP_SHIFT,BP_CASHIERTILLSCODE,BP_SCHEME,BP_SCHEMCODE,BP_VISITCODE,BP_TOTAL,BP_AMTPAID,BP_ACTORCODE,BP_ACTOR,BP_INSTCODE,BP_CHANGE,BP_RECIEPTNUMBER,BP_METHOD,BP_METHODCODE,BP_STATE,BP_PHONENUMBER,BP_CHEQUENUMBER,BP_INSURANCEBAL,BP_BANKSCODE,BP_BANKS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
		// $st = $this->db->prepare($sql);   
		// $st->BindParam(1, $form_key);
		// $st->BindParam(2, $day);
		// $st->BindParam(3, $patientcode);
		// $st->BindParam(4, $patientnumber);
		// $st->BindParam(5, $patient);
		// $st->BindParam(6, $billcode);
		// $st->BindParam(7, $remarks);
		// $st->BindParam(8, $currentshiftcode);
		// $st->BindParam(9, $currentshift);
		// $st->BindParam(10, $cashiertilcode);
		// $st->BindParam(11, $payname);
		// $st->BindParam(12, $paycode);
		// $st->BindParam(13, $visitcode);
		// $st->BindParam(14, $totalamount);
		// $st->BindParam(15, $amountpaid);
		// $st->BindParam(16, $currentusercode);
		// $st->BindParam(17, $currentuser);
		// $st->BindParam(18, $instcode);
		// $st->BindParam(19, $chang);	
		// $st->BindParam(20, $receiptnumber);	
		// $st->BindParam(21, $paymeth);	
		// $st->BindParam(22, $paymethcode);	
		// $st->BindParam(23, $state);
		// $st->BindParam(24, $phonenumber);
		// $st->BindParam(25, $chequenumber);
		// $st->BindParam(26, $insurancebal);
		// $st->BindParam(27, $bankscode);
		// $st->BindParam(28, $banks);	
		// $genreceipt = $st->execute();	
		// 	if($genreceipt){
		// 		$a = 6;
		// 		$b = 2;
		// 		$c = 1;
		// 		$sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PAYDATE = ?, B_RECIPTNUM = ?, B_PAYACTOR = ?, B_PAYACTORCODE = ? , B_PAYSHIFTCODE = ? , B_PAYSHIFT = ?, B_COMPLETE = ?, B_PAYMETHODCODE = ?, B_PAYMETHOD = ? WHERE B_VISITCODE = ? AND B_STATE = ? and B_BILLCODE = ? ");
		// 		$st = $this->db->prepare($sql);
		// 		$st->BindParam(1, $a);
		// 		$st->BindParam(2, $a);
		// 		$st->BindParam(3, $day);
		// 		$st->BindParam(4, $form_key);
		// 		$st->BindParam(5, $currentuser);
		// 		$st->BindParam(6, $currentusercode);
		// 		$st->BindParam(7, $currentshiftcode);
		// 		$st->BindParam(8, $currentshift);
		// 		$st->BindParam(9, $c);
		// 		$st->BindParam(10, $paymethcode);
		// 		$st->BindParam(11, $paymeth);
		// 		$st->BindParam(12, $visitcode);
		// 		$st->BindParam(13, $b);
		// 		$st->BindParam(14, $billcode);
		// 		$updtebilitems = $st->execute();
		// 			if($updtebilitems){
		// 				$vt = 6 ;
		// 				$sql = ("UPDATE octopus_patients_bills SET BILL_RECEIPTNUMBER = ?, BILL_ACTOR = ?, BILL_ACTORCODE = ?, BILL_STATUS = ? WHERE BILL_CODE = ?");
		// 				$st = $this->db->prepare($sql);
		// 				$st->BindParam(1, $form_key);
		// 				$st->BindParam(2, $currentuser);
		// 				$st->BindParam(3, $currentusercode);
		// 				$st->BindParam(4, $vt);
		// 				$st->BindParam(5, $billcode);
		// 				$updatebills = $st->execute();						
		// 					if($updatebills){
		// 						$nt = 3;
		// 						$ty = 5;
		// 						$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ?  WHERE REQU_BILLCODE = ? and REQU_STATUS = ?  ";
		// 						$st = $this->db->prepare($sql);
		// 						$st->BindParam(1, $nt);
		// 						$st->BindParam(2, $billcode);
		// 						$st->BindParam(3, $ty);
		// 						$servicerequest = $st->Execute();	
		// 						if($servicerequest){
		// 							$vt = 1;
		// 							$sql = "UPDATE octopus_current SET CU_RECEIPTNUMBER = CU_RECEIPTNUMBER + ?  WHERE CU_INSTCODE = ? ";
		// 							$st = $this->db->prepare($sql);
		// 							$st->BindParam(1, $vt);
		// 							$st->BindParam(2, $instcode);
		// 							$recipt = $st->Execute();	
		// 							if($recipt){
		// 								$selected = 5;
		// 									$paid = 6;
		// 									$pay = 2;
		// 									$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_STATUS = ?  WHERE MIV_STATE = ? and MIV_BILLINGCODE = ?";
		// 									$st = $this->db->prepare($sql);
		// 									$st->BindParam(1, $paid);
		// 									$st->BindParam(2, $pay);
		// 									$st->BindParam(3, $selected);
		// 									$st->BindParam(4, $billcode);
		// 									$labs = $st->Execute();	
		// 									if($labs){
		// 										$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_STATUS = ?  WHERE PRESC_STATE = ? and PRESC_BILLINGCODE = ?";
		// 										$st = $this->db->prepare($sql);
		// 										$st->BindParam(1, $paid);
		// 										$st->BindParam(2, $pay);
		// 										$st->BindParam(3, $selected);
		// 										$st->BindParam(4, $billcode);
		// 										$labs = $st->Execute();	
		// 										if($labs){
		// 												$sede = 1;
		// 												$sql = "UPDATE octopus_cashiertill SET  CA_INSURANCE = CA_INSURANCE + ?  WHERE CA_CODE = ? and CA_STATUS = ? ";
		// 												$st = $this->db->prepare($sql);
		// 												$st->BindParam(1, $totalamount);
		// 											//	$st->BindParam(2, $totalamount);
		// 												$st->BindParam(2, $cashiertill);
		// 												$st->BindParam(3, $sede);
		// 												$tills = $st->Execute();	
		// 												if($tills){
		// 													return '2';
		// 												}else{
		// 													return '0';
		// 												}	
		// 										}else{
		// 											return '0';
		// 										}
		// 									}else{
		// 										return '0';
		// 									}
		// 							}else{
		// 								return '0';
		// 							}				
		// 						}else{
		// 							return '0';
		// 						}				
		// 					}					
		// 			}else{				
		// 				return '0';				
		// 			}
		// 		}else{
		// 			return '0';
		// 		}
		// 	}else{
		// 		return '0';
		// 	}
        // }else{
		// 	return '0';
		// }

	//}
	
	// 19 JULY 2021 JOSEPH ADORBOE 
	public function getpatientinsurancetransactiondetails($idvalue,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$creditcode){
		$sqlstmt = ("SELECT DISTINCT B_VISITCODE,B_DT,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_DPT,B_BILLCODE,B_METHOD,B_METHODCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_PAYMENTTYPE FROM octopus_patients_billitems where B_VISITCODE = ? and B_STATUS IN('1','2','4') and B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode','$creditcode') ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['B_VISITCODE'].'@'.$object['B_DT'].'@'.$object['B_PATIENTCODE'].'@'.$object['B_PATIENTNUMBER'].'@'.$object['B_PATIENT'].'@'.$object['B_DPT'].'@'.$object['B_BILLCODE'].'@'.$object['B_METHOD'].'@'.$object['B_PAYSCHEME'].'@'.$object['B_PAYSCHEMECODE'].'@'.$object['B_PAYMENTTYPE'].'@'.$object['B_METHODCODE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}
	
	// 15 APR  2021 JOSEPH ADORBOE 
	public function billingunselectedtransactions($bcode,$visitcode,$instcode){

		$but = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_STATE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $but);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{
                $nt = 2;
				$one = 1;
                $sql = "UPDATE octopus_patients_billitems SET B_STATE = ?  WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND  B_STATE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $one);
                $st->BindParam(2, $bcode);
                $st->BindParam(3, $instcode);
                $st->BindParam(4, $visitcode);
                $st->BindParam(5, $nt);
                $selectitem = $st->Execute();
                if ($selectitem) {
                    return '2' ;
                } else {
                    return '0' ;
                }
            }	
		
	}
	}
	

	// 15 APR  2021 JOSEPH ADORBOE 
	public function billingselectedtransactions($bcode,$visitcode,$instcode){

		$but = 2;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_STATE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $but);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{
                $nt = 2;
				$one = 1;
                $sql = "UPDATE octopus_patients_billitems SET B_STATE = ?  WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND  B_STATE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $nt);
                $st->BindParam(2, $bcode);
                $st->BindParam(3, $instcode);
                $st->BindParam(4, $visitcode);
                $st->BindParam(5, $one);
                $selectitem = $st->Execute();
                if ($selectitem) {
                    return '2' ;
                } else {
                    return '0' ;
                }
            }	
		
	}
	}
	
	
	
} 
?>