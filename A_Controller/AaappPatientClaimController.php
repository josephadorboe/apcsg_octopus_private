<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 5 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 
	Base : 	octopus_patients_claims
	$patientclaimscontroller->
*/

class PatientsClaimsController Extends Engine{
	// 9 SEPT 2023 JOSEPH ADORBOE
	public function getclaimsreports($patientnumber,$day,$general,$second,$privateinsurancecode,$schemecode,$first,$instcode){
		if($general == '4'){	
			$querysearchlist = ("SELECT DISTINCT B_DT,B_PATIENTNUMBER,B_PATIENT,B_PAYSCHEME,B_VISITCODE  FROM octopus_patients_billitems  WHERE B_STATUS !=$this->thefailed AND B_INSTCODE = '$instcode' AND Date(B_DT) >= '$first' AND Date(B_DT) <= '$second' AND B_METHODCODE = '$privateinsurancecode' AND B_PAYSCHEMECODE = '$schemecode' order by B_ID DESC ");						
		}else if($general == '20'){											
			$querysearchlist = ("SELECT * FROM octopus_patients_claims  WHERE CLAIM_STATUS !=$this->thefailed AND CLAIM_INSTCODE = '$instcode' AND Date(CLAIM_DATE) >= '$first' AND Date(CLAIM_DATE) <= '$second' order by CLAIM_ID DESC ");						
		}else if($general == '3'){											
			$querysearchlist = ("SELECT DISTINCT B_DT,B_PATIENTNUMBER,B_PATIENT,B_PAYSCHEME,B_VISITCODE FROM octopus_patients_billitems  WHERE B_STATUS !=$this->thefailed AND B_INSTCODE = '$instcode' AND Date(B_DT) >= '$first' AND Date(B_DT) <= '$second' AND B_METHODCODE = '$privateinsurancecode' order by B_ID DESC ");						
		}else if($general == '5'){											
			$querysearchlist = ("SELECT DISTINCT B_DT,B_PATIENTNUMBER,B_PATIENT,B_PAYSCHEME,B_VISITCODE FROM octopus_patients_billitems  WHERE B_STATUS !=$this->thefailed AND B_INSTCODE = '$instcode' AND Date(B_DT) >= '$first' AND Date(B_DT) <= '$second' AND B_METHODCODE = '$privateinsurancecode' AND B_PATIENTNUMBER = '$patientnumber' order by B_ID DESC ");						
		}else{											
			$querysearchlist = ("SELECT * FROM octopus_patients_claims  WHERE CLAIM_STATUS !=$this->thefailed AND CLAIM_INSTCODE = '$instcode' AND Date(CLAIM_DATE)  = '$day' order by CLAIM_ID DESC ");										 
		}
	
		return $querysearchlist;
	}

	// 9 SEPT 2023 JOSEPH ADORBOE
	public function getpatientclaims($instcode){
		$list = ("SELECT * FROM octopus_patients_claims WHERE CLAIM_STATUS IN('1','3') AND CLAIM_INSTCODE = '$instcode'  order by CLAIM_ID DESC LIMIT 400");
		return $list;
	}

	// 18 Sept 2023, 14 JULY 2022 JOSEPH ADORBOE 
	public function performinsurancebilling($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$days,$visitcode,$paymentmethodcode,$paymentmethod,$patientschemecode,$patientscheme,$patientservicecode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$patientclaimstable,$patientbillitemtable){		
				
		if( $paymentmethodcode == $privateinsurancecode || $paymentmethodcode == $nationalinsurancecode || $paymentmethodcode == $partnercompaniescode ){
			$check = $patientclaimstable->getclaimsnumber($patientcode,$visitcode,$patientschemecode,$instcode);
			if($check !== $this->thefailed){
				$sp = explode('@', $check);
				$claincode = $sp[$this->thefailed];
				$clainnumber = $sp['1'];	
				$bills = $patientbillitemtable->updatepatientclaims($claincode,$clainnumber,$patientcode,$visitcode,$patientservicecode,$patientschemecode,$instcode);
				if($bills == $this->thepassed){
					return $this->thepassed;
				}else{
					return $this->thefailed;
				}				
			}else{
				$claims = $patientclaimstable->insert_patientclaims($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$visitcode,$patientschemecode,$patientscheme,$paymentmethod,$paymentmethodcode,$days,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);
				$bills = $patientbillitemtable->updatepatientclaims($form_key,$claimsnumber,$patientcode,$visitcode,$patientservicecode,$patientschemecode,$instcode);
				if($bills == $this->thepassed && $claims == $this->thepassed){
					return $this->thepassed;
				}else{
					return $this->thefailed;
				}
			}
		}else{
			$bills = $patientbillitemtable->updatepatientclaims($form_key,$claimsnumber,$patientcode,$visitcode,$patientservicecode,$patientschemecode,$instcode);
			if($bills == $this->thepassed){
				return $this->thepassed;
			}else{
				return $this->thefailed;
			}
		}
	}

} 
	$patientclaimscontroller = new PatientsClaimsController();

?>