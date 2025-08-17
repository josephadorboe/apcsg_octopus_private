<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 29 DEC 2024, 
	PURPOSE: TO OPERATE MYSQL QUERY 
	$walletoperationcontroller->generatewalletoperationreceipt	
*/

class OctopusWalletOperationController Extends Engine
{
	// 29 DEC 2024, JOSEPH ADORBOE
	public function generatewalletoperationreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$descriptions,$currentshift,$currentshiftcode,$amountpaid,$currentusercode,$currentuser,$instcode,$chang,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$phonenumber,$state,$cashiertillcode,$days,$prepaidchemecode,$prepaidscheme,$prepaidcode,$prepaid,$billingpaymentcode,$currentday,$currentmonth,$currentyear,$depositcode,$depositscheme,$patientreceipttable,$patientschemetable,$currenttable,$patientbillingpaymenttable,$cashiertillstable,$cashiersummarytable)
	{       
		$new = $patientreceipttable->walletdepositreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$descriptions,$currentshift,$currentshiftcode,$amountpaid,$currentusercode,$currentuser,$instcode,$chang,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$phonenumber,$state,$cashiertillcode,$days,$billingpaymentcode);
		if($new == '2'){
			// $curr = $currenttable->updatereceipt($instcode);
			$pb = $patientbillingpaymenttable->walletdepositbillspayments($form_key,$day,$visitcode='NA',$patientcode,$patientnumber,$patient,$currentshift,$currentshiftcode,$amountpaid,$currentusercode,$currentuser,$instcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$phonenumber,$cashiertillcode,$days,$billingpaymentcode,$currentday,$currentmonth,$currentyear);
					
			$pd = $patientschemetable->walletdepositpatientscheme($form_key,$day,$patientcode,$patientnumber,$patient,$amountpaid,$currentusercode,$currentuser,$instcode,$prepaidchemecode,$prepaidscheme,$prepaidcode,$prepaid);
			if( $pb == '2' && $pd =='2'){
				$til = $cashiertillstable->deposittillsoperations($form_key,$day, $currentshift,$currentusercode,$paymethcode,$paymeth,$amountpaid,$depositcode,$depositscheme,$currentuser,$currentshiftcode,$instcode);
				$summ = $cashiersummarytable->depositsummaryoperations($form_key,$day, $currentshift,$currentusercode,$amountpaid,$currentuser,$currentshiftcode,$instcode);
				if($til == '2' && $summ == '2'){
					return '2';
				}else{
					return '0';
				}
			}else{
				return '0';
			}

		}else{
			return '0';
		}
	}	
                                
} 
 	$walletoperationcontroller =  new OctopusWalletOperationController ();
?>