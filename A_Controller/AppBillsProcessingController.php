<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 23 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 
	Base : 	octopus_patients_bills
*/

class BillProcessingController Extends Engine{
	// // 7 SEPT 2023 JOSEPH ADORBOE
	// public function selectnoncashbillingitemsprocesseddetails($idvalue,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$instcode){
	// 	$list = ("SELECT * from octopus_patients_billitems where B_INSTCODE = '$instcode' and B_VISITCODE = '$idvalue' and B_STATUS IN('2') and B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode') ");
	// 	return $list;
	// }
	
	// 7 SEPT 2023 JOSEPH ADORBOE
	public function getshiftsearchtransactions($idvalue,$instcode){
		$list = ("SELECT * from octopus_patients_reciept WHERE BP_INSTCODE = '$instcode' AND BP_SHIFTCODE = '$idvalue' AND BP_STATUS = '1' ");		
		return $list;
	}
	// 7 SEPT 2023 JOSEPH ADORBOE
	public function getshifttransactions($currentuserlevel,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$chequescode,$prepaidcode,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$currentshiftcode,$instcode){
		if ($currentuserlevel == '3') {
			$list = ("SELECT * from octopus_patients_reciept WHERE BP_INSTCODE = '$instcode' AND BP_SHIFTCODE = '$currentshiftcode' AND BP_STATUS = '1' AND BP_METHODCODE IN('$cashpaymentmethodcode','$mobilemoneypaymentmethodcode','$chequescode','$prepaidcode') ");
		}else if($currentuserlevel == '9' || $currentuserlevel == '38'){
			$list = ("SELECT * from octopus_patients_reciept where BP_INSTCODE = '$instcode' and BP_SHIFTCODE = '$currentshiftcode' AND BP_STATUS = '1' ");
		}else if($currentuserlevel == '2' ){
			$list = ("SELECT * from octopus_patients_reciept where BP_INSTCODE = '$instcode' and BP_SHIFTCODE = '$currentshiftcode' AND BP_STATUS = '1' AND BP_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode')");
		}else{
			$list = ("SELECT * from octopus_patients_reciept where BP_INSTCODE = '$instcode' and BP_SHIFTCODE = '$currentshiftcode' AND BP_STATUS = '1' ");
		}
		return $list;
	}
	// 7 SEPT 2023 JOSEPH ADORBOE
	public function getprintitems($scode){
		$list = ("SELECT * from octopus_patients_billitems where B_RECIPTNUM = '$scode' and B_STATUS = '2' ");
		return $list;
	}
	// 7 SEPT 2023 JOSEPH ADORBOE
	public function getreciptlistdetails(){
		$list = ("SELECT * from octopus_admin_receiptdetails where RP_INSTCODE = ? ");
		return $list;
	}
	// 7 SEPT 2023 JOSEPH ADORBOE
	public function getreciptprint(){
		$list = ("SELECT * from octopus_patients_reciept where BP_CODE = ? ");
		return $list;
	}
	// 7 SEPT 2023 JOSEPH ADORBOE
	public function getpaymentbillislist($billingcode){
		$list = ("SELECT * from octopus_patients_billingpayments where BPT_BILLINGCODE = '$billingcode' and BPT_STATUS = '1' order by BPT_ID DESC ");
		return $list;
	}
	// 7 SEPT 2023 JOSEPH ADORBOE
	public function getitemspaidlist($visitcode,$idvalue){
		$list = ("SELECT * from octopus_patients_billitems where B_VISITCODE = '$visitcode' and B_STATUS IN('2','4','6','7') and B_RECIPTNUM = '$idvalue' ");
		return $list;
	}
	// 7 SEPT 2023 JOSEPH ADORBOE
	public function getreciptsissuedsearchlist($searchitem,$instcode){
		$list = ("SELECT * from octopus_patients_reciept where BP_INSTCODE = '$instcode' AND ( BP_PATIENTNUMBER like '%$searchitem%' or BP_PATIENT like '%$searchitem%' or BP_RECIEPTNUMBER like '%$searchitem%' ) ");
		return $list;
	}
	// 5 SEPT 2023 JOSEPH ADORBOE
	public function getreciptsissuedlist($instcode){
		$list = ("SELECT * from octopus_patients_reciept where BP_STATUS = '1' and BP_INSTCODE = '$instcode'  order by BP_ID DESC limit 10 ");
		return $list;
	}
	// 5 SEPT 2023 JOSEPH ADORBOE
	public function getinsurancebils($privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$instcode){
		$list = ("SELECT DISTINCT B_VISITCODE,B_DT,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE,B_BILLCODE from octopus_patients_billitems where B_STATUS ='1' and B_INSTCODE = '$instcode' AND B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode') order by B_DT DESC LIMIT 10");
		return $list;
	}
	// 5 SEPT 2023 JOSEPH ADORBOE
	public function getinsurancesummarytills($currentshiftcode,$currentusercode,$instcode){
		$list = ("SELECT * from octopus_cashier_tills where TILL_ACTORCODE = '$currentusercode' and TILL_INSTCODE = '$instcode' and TILL_SHIFTCODE = '$currentshiftcode' AND TILL_TYPE = '2'");
		return $list;
	}
	// 5 SEPT 2023 JOSEPH ADORBOE
	public function getpartnerbills($currentusercode,$instcode){
		$list = ("SELECT * FROM octopus_cashier_partnerbills WHERE PC_PROCESSACTORCODE = '$currentusercode' AND PC_INSTCODE = '$instcode'  order by PC_ID DESC limit 10");
		return $list;
	}
	// 29 AUG 2023 JOSEPH ADORBOE
	public function getpatientbillingpayments($billingcode,$visitcode,$instcode){
		$list = ("SELECT * from octopus_patients_billingpayments where BPT_BILLINGCODE = '$billingcode' and BPT_VISITCODE = '$visitcode' AND BPT_INSTCODE = 
		'$instcode' and BPT_STATUS = '1' order by BPT_ID DESC ");
		return $list;
	}
	// 19 AUG 2023 JOSEPH ADORBOE
	public function selectcancelledbillingitems($instcode){
		$list = ("SELECT * from octopus_patients_billitems where B_STATUS ='0' and  B_INSTCODE = '$instcode' AND (  B_TOTAMT > '0' OR B_TOTAMT = '-1') order by B_DT DESC");
		return $list;
	}
	// 19 AUG 2023 JOSEPH ADORBOE
	public function selectbillingitemsdetails($idvalue,$prepaidcode,$instcode,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode){
		$list = ("SELECT * from octopus_patients_billitems where B_INSTCODE = '$instcode' and B_VISITCODE = '$idvalue' and B_STATUS IN('1','4','7') and B_METHODCODE IN('$mobilemoneypaymentmethodcode','$cashpaymentmethodcode','$prepaidcode') ");
		return $list;
	}
	// 19 AUG 2023 JOSEPH ADORBOE
	public function selectbillingitems($chequescode,$creditcode,$prepaidcode,$instcode,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode){
		$list = ("SELECT DISTINCT B_VISITCODE,B_DT,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE,B_BILLCODE,B_PAYMENTTYPE from octopus_patients_billitems where B_STATUS IN('1','4') and B_METHODCODE IN('$cashpaymentmethodcode','$mobilemoneypaymentmethodcode','$chequescode','$creditcode','$prepaidcode') and B_INSTCODE = '$instcode' AND (  B_TOTAMT > '0' OR B_TOTAMT = '-1')   order by B_DT DESC");
		return $list;
	}

	// 12 MAR 2021  JOSEPH ADORBOE
	public function generatereceiptdefered($form_key,$day,$days,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$insurancetillcode,$insurancesummarycode, $billingcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift,$currenttable,$patientreceipttable,$patientbillitemtable,$patientsbillstable,$patientdiscounttable,$patientbillingtable,$patientbillingpaymenttable,$cashiertillstable,$cashiersummarytable,$patientsMedicalreportstable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable)
	{
		$bal = 0;
		$two = 2;
		$na = 'NA';
		$one = 1;
		$three = 3;		
		$receipt = $patientreceipttable->selectinsertreceiptsinsurance($form_key,$transactiondate,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$transactionshift,$transactionshiftcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,'NA','NA',$insurancetillcode,$days,$billingcode);
		
		if($receipt == '2'){
			$patientbillingpaymenttable->setbillingpaymentsinsurance($form_key,$billingcode,$transactiondate,$patientcode,$patientnumber,$patient,$visitcode,$transactionshift,$transactionshiftcode,$amountpaid,$totalamount,$bal,$currentusercode,$currentuser,$instcode,$paycode,$payname,$paymethcode,$paymeth,$phonenumber,$chequenumber,$insurancetillcode,$receiptnumber,$days,$transactionday,$transactionmonth,$transactionyear);
			$bills = $patientbillitemtable->updatebillitem($form_key,$paycode,$payname,$day,$visitcode,$currentshiftcode,$currentshift,$currentuser,$currentusercode);
			$billsreceipt = $patientsbillstable->updatebillsreceipt($form_key,$currentuser,$currentusercode,$billcode);
			$discount = $patientdiscounttable->updatereceiptdiscount($form_key,$patientcode,$instcode);
			$billing = $patientbillingtable->updatebillingreceipt($receiptnumber,$billingcode,$instcode);
		//	$billingpayment = $patientbillingpaymenttable->updatebillingpaymentreceipt($receiptnumber,$billingcode,$instcode);
			$current = $currenttable->updatereceipt($instcode);
			$cashiertillstable->updatecashierinsurancetill($insurancetillcode,$amountpaid,$currentusercode,$transactionshiftcode,$paycode,$instcode);
			$cashiersummarytable->updatecashierinsurancesummary($insurancesummarycode,$amountpaid,$transactionshiftcode,$instcode);
			$selected = 2;
			$unselected = 1;
			$paid = 4;
			$show = 7;
			$medicalreport = $patientsMedicalreportstable->selectedpaidmedicalreport($selected,$patientcode,$unselected,$instcode);
			$servicerequest = $patientsServiceRequesttable->selectedpaidservicerequest($selected,$show,$patientcode,$visitcode,$unselected,$instcode);
			$investigations = $patientsInvestigationRequesttable->selectedpaidinvestigation($selected,$paid,$patientcode,$visitcode,$unselected,$instcode);
			$prescrption = $Prescriptionstable->selectedpaidprescription($selected,$paid,$patientcode,$visitcode,$unselected,$instcode);
			$devices = $patientsDevicestable->selectedpaiddevices($selected,$paid,$patientcode,$visitcode,$unselected,$instcode);
			$procedures = $patientproceduretable->selectedpaidprocedures($selected,$paid,$patientcode,$visitcode,$unselected,$instcode);
			return "2";
		}else{
			return "0";
		}
	} 
	// 30 OCT 2021  2021  JOSEPH ADORBOE
	public function generatecopaymentreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalgeneratedamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$billingcode,$patientreceipttable,$patientbillitemtable,$patientbillingtable,$patientdiscounttable,$patientsbillstable,$patientbillingpaymenttable,$currenttable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable)
	{		
		$receipt = $patientreceipttable->selectinsertreceipts($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$amountpaid,$totalgeneratedamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$billingcode);
		if($receipt == "2"){
			$bills = $patientbillitemtable->updatebillitem($form_key,$paycode,$payname,$day,$visitcode,$currentshiftcode,$currentshift,$currentuser,$currentusercode);
			$billsreceipt = $patientsbillstable->updatebillsreceipt($form_key,$currentuser,$currentusercode,$billcode);
			$discount = $patientdiscounttable->updatereceiptdiscount($form_key,$patientcode,$instcode);
			$billing = $patientbillingtable->updatebillingreceipt($receiptnumber,$billingcode,$instcode);
			$billingpayment = $patientbillingpaymenttable->updatebillingpaymentreceipt($receiptnumber,$billingcode,$instcode);
			$current = $currenttable->updatereceipt($instcode);
			$selected = 2;
			$unselected = 1;
			$paid = 4;
			$show = 7;

			// pay before service
			if($payingtype == "1") {
				$medicalreport = $patientsMedicalreportstable->selectedpaidmedicalreport($selected,$patientcode,$unselected,$instcode);
				$servicerequest = $patientsServiceRequesttable->selectedpaidservicerequest($selected,$show,$patientcode,$visitcode,$unselected,$instcode);
				$investigations = $patientsInvestigationRequesttable->selectedpaidinvestigation($selected,$paid,$patientcode,$visitcode,$unselected,$instcode);
				$prescrption = $Prescriptionstable->selectedpaidprescription($selected,$paid,$patientcode,$visitcode,$unselected,$instcode);
				$devices = $patientsDevicestable->selectedpaiddevices($selected,$paid,$patientcode,$visitcode,$unselected,$instcode);
				$procedures = $patientproceduretable->selectedpaidprocedures($selected,$paid,$patientcode,$visitcode,$unselected,$instcode);
				return '2';
			} elseif ($payingtype == "7") {
				$medicalreport = $patientsMedicalreportstable->selectedpaidmedicalreport($selected,$patientcode,$unselected,$instcode);
				$servicerequest = $patientsServiceRequesttable->selectedpaidservicerequest($selected,$show,$patientcode,$visitcode,$unselected,$instcode);
				$investigations = $patientsInvestigationRequesttable->selectedshowinvestigation($selected,$patientcode,$visitcode,$unselected,$instcode);
				$prescrption = $Prescriptionstable->selectedshowprescription($selected,$patientcode,$visitcode,$unselected,$instcode);
				$devices = $patientsDevicestable->selectedshowevices($selected,$patientcode,$visitcode,$unselected,$instcode);
				$procedures = $patientproceduretable->selectedshowprocedures($selected,$patientcode,$visitcode,$unselected,$instcode);
				return '2';

			}else{
				$medicalreport = $patientsMedicalreportstable->selectedpaidmedicalreport($selected,$patientcode,$unselected,$instcode);
				$servicerequest = $patientsServiceRequesttable->selectedpaidservicerequest($selected,$show,$patientcode,$visitcode,$unselected,$instcode);
				$investigations = $patientsInvestigationRequesttable->selectedpaidinvestigation($selected,$paid,$patientcode,$visitcode,$unselected,$instcode);
				$prescrption = $Prescriptionstable->selectedpaidprescription($selected,$paid,$patientcode,$visitcode,$unselected,$instcode);
				$devices = $patientsDevicestable->selectedpaiddevices($selected,$paid,$patientcode,$visitcode,$unselected,$instcode);
				$procedures = $patientproceduretable->selectedpaidprocedures($selected,$paid,$patientcode,$visitcode,$unselected,$instcode);
				return '2';
			}

		}else{
			return '0';
		}     
		
	}

	// 29 AUG 2023 ,  30 OCT 2021 JOSEPH ADORBOE 
	public function makecopayment($form_key,$billingcode,$day,$patientcode,$patientnumber,$patient,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalgeneratedamount,$totalgeneratedamountbal,$bal,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$currentday,$currentmonth,$currentyear,$amountdeducted,$foreigncurrency,$receiptnumber,$patientbillingpaymenttable,$patientbillingtable,$cashiertillstable,$cashiersummarytable ){

		$billpayment =  $patientbillingpaymenttable->setbillingpayments($form_key,$billingcode,$day,$patientcode,$patientnumber,$patient,$visitcode,$currentshift,$currentshiftcode,$amountpaid,$totalgeneratedamountbal,$bal,$currentusercode,$currentuser,$instcode,$paycode,$payname,$paymethcode,$paymeth,$phonenumber,$chequenumber,$bankname,$bankcode,$cashiertillcode,$receiptnumber,$days,$currentday,$currentmonth,$currentyear);
		//setbillingpayments($form_key,$billingcode,$day,$patientcode,$patientnumber,$patient,$visitcode,$currentshift,$currentshiftcode,$amountpaid,$totalgeneratedamountbal,$bal,$currentusercode,$currentuser,$instcode,$paycode,$payname,$paymethcode,$paymeth,$phonenumber,$chequenumber,$bankname,$bankcode,$cashiertillcode,$days,$currentday,$currentmonth,$currentyear);				
		if($billpayment == 2){
			$billing = $patientbillingtable->updatepaymentbilling($amountdeducted,$billingcode,$type=1,$visitcode,$instcode);	
			$till = $cashiertillstable->selectinsertupdatetills($form_key,$day,$currentshift,$currentshiftcode,$currentusercode,$currentuser,$instcode,$paycode,$payname,$paymethcode,$paymeth,$amountdeducted,$foreigncurrency);
			$summary = $cashiersummarytable->selectinsertupdatecashiersummary($form_key,$day,$currentshift,$currentshiftcode,$currentusercode,$currentuser,$instcode,$amountdeducted);
			if ($billing == '2' && $till == '2' && $summary == '2') {
				return '2';
			} else {
				return '0';
			}
		}else{
			return '0';
		}			
	}
	// 19 JUNE 2022  JOSEPH ADORBOE 
	public function makeprepaidcopayment($form_key,$billingcode,$day,$patientcode,$patientnumber,$patient,$visitcode,$currentshift,$currentshiftcode,$amountpaid,$totalgeneratedamount,$totalgeneratedamountbal,$bal,$currentusercode,$currentuser,$instcode,$paycode,$payname,$paymethcode,$paymeth,$phonenumber,$chequenumber,$bankname,$bankcode,$cashiertillcode,$days,$currentday,$currentmonth,$currentyear,$amountdeducted,$prepaidcode,$prepaidchemecode,$receiptnumber,$patientbillingpaymenttable,$patientbillingtable,$patientschemetable,$cashiersummarytable){
		$one = 1;
		$billpayment =  $patientbillingpaymenttable->setbillingpayments($form_key,$billingcode,$day,$patientcode,$patientnumber,$patient,$visitcode,$currentshift,$currentshiftcode,$amountpaid,$totalgeneratedamountbal,$bal,$currentusercode,$currentuser,$instcode,$paycode,$payname,$paymethcode,$paymeth,$phonenumber,$chequenumber,$bankname,$bankcode,$cashiertillcode,$receiptnumber,$days,$currentday,$currentmonth,$currentyear);
		if($billpayment == '2'){
			$billing = $patientbillingtable->updatepaymentbilling($amountdeducted,$billingcode,$type=1,$visitcode,$instcode);
			$scheme = $patientschemetable->updatepatientscheme($patientcode,$amountpaid,$instcode,$prepaidchemecode);
			$summary = $cashiersummarytable->selectinsertupdatecashiersummarytypes($form_key,$day,$currentshift,$currentshiftcode,$type=5,$currentusercode,$currentuser,$instcode,$amountpaid);
			$summary = $cashiersummarytable->deductfromsummary($currentshiftcode,$amountpaid,$type = 4,$instcode);
			if ($billing == '2' && $scheme == '2' && $summary == '2' ) {
				return '2';
			} else {
				return '0';
			}

		}else{
			return '0';
		}

	}	
	

	// 26 AUG 2023, 29 JULY 2021 JOSEPH ADORBOE 
	public function reversecashiercanceltransactions($ekey,$servicecode,$department,$visitcode,$amount,$days,$patientcode,$currentuser,$currentusercode,$instcode,$patientbillitemtable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable){	
		
		$bills = $patientbillitemtable->reversecancelbillingitems($ekey,$days,$currentuser,$currentusercode,$visitcode,$instcode);
		if($bills == 2){
			$selected = 1;
			$unselected = '0';
			
			if($department == 'SERVICES'){
				$result = $patientsServiceRequesttable->reversecancelservices($visitcode,$servicecode,$patientcode,$currentusercode,$currentuser,$instcode);								
				return $result;
			}else if($department == 'LABS' || $department == 'IMAGING'){
				$result =$patientsInvestigationRequesttable->reveresecancelinvestigation($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($department == 'PHARMACY'){	
				$result =$Prescriptionstable->reversecancelprescription($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($department == 'DEVICES'){
				$result =$patientsDevicestable->reversecanceldevices($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($department == 'PROCEDURE'){
				$result =$patientproceduretable->reversecancelprocedures($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($department == 'MEDREPORTS'){
				$result =$patientsMedicalreportstable->reversecancelmedicalreport($selected,$servicecode,$unselected,$instcode);
				return $result;				
			}else{
				return '0';
			}														
			}else{						
				return '0' ;						
			}
	
	}
	// 26 AUG 2023 JOSEPH ADORBOE 
	public function cashiercanceltransactions($bcode,$servicecode,$dpts,$visitcode,$days,$currentuser,$currentusercode,$instcode,$patientbillitemtable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable){
		$bills = $patientbillitemtable->cancelbillingitems($bcode,$days,$currentuser,$currentusercode,$visitcode,$instcode);
		if($bills == 2){
			$selected = 1;
			$unselected = '0';
			$sted = 2;
			$utied = 3 ;
			if($dpts == 'SERVICES'){
				$result = $patientsServiceRequesttable->billscancelservices($selected,$servicecode,$visitcode,$unselected,$instcode);								
				return $result;
			}else if($dpts == 'LABS' || $dpts == 'IMAGING'){
				$result =$patientsInvestigationRequesttable->cancelinvestigation($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($dpts == 'PHARMACY'){	
				$result =$Prescriptionstable->cancelprescription($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($dpts == 'DEVICES'){
				$result =$patientsDevicestable->canceldevices($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($dpts == 'PROCEDURE'){
				$result =$patientproceduretable->cancelprocedures($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($dpts == 'MEDREPORTS'){
				$result =$patientsMedicalreportstable->cancelmedicalreport($selected,$servicecode,$unselected,$instcode);
				return $result;				
			}else{
				return '0';
			}						
		}else{			
			return '0' ;			
		}	
	}
	// 26 AUG 2023, 31 JAN 2021 
	public function cashiersendbacktransactions($bcode,$servicecode,$dpts,$sendbackreason,$visitcode,$days,$currentuser,$currentusercode,$instcode,$patientbillitemtable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable){
		$bills = $patientbillitemtable->sendbackbillingitems($bcode,$visitcode,$instcode);
		if($bills == 2){
			$selected = 1;
			$unselected = '0';
			if($dpts == 'SERVICES'){
				$result = $patientsServiceRequesttable->billssendbackservices($selected,$servicecode,$visitcode,$sendbackreason,$currentuser,$currentusercode,$instcode);								
				return $result;
			}else if($dpts == 'LABS' || $dpts == 'IMAGING'){
				$result =$patientsInvestigationRequesttable->sendbackinvestigation($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($dpts == 'PHARMACY'){	
				$result =$Prescriptionstable->sendbackprescription($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($dpts == 'DEVICES'){
				$result =$patientsDevicestable->sendbackdevices($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($dpts == 'PROCEDURE'){
				$result =$patientproceduretable->sendbackprocedures($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($dpts == 'MEDREPORTS'){
				$result =$patientsMedicalreportstable->sendbackmedicalreport($selected,$servicecode,$unselected,$instcode);
				return $result;				
			}else{
				return '0';
			}			
		}else{
			return '0';
		}		
	}
	// 23 AUG 2023, 31 JAN 2021 JOSEPH ADORBOE 
	public function cashierselectedtransactions($bcode,$billgeneratedcode,$amt,$servicecode,$dpts,$visitcode,$instcode,$type,$patientbillitemtable,$patientbillingtable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable){		
	
			$bills = $patientbillitemtable->selectbillingitems($bcode,$visitcode,$billgeneratedcode,$instcode);
			if($bills == '2'){
				$selected = 1;
				$unselected = '0';
				$patientbillingtable->updatebilling($amt,$billgeneratedcode,$type,$visitcode,$instcode);
				if($dpts == 'SERVICES'){
					$result = $patientsServiceRequesttable->billsselectservices($selected,$servicecode,$visitcode,$unselected,$instcode);								
					return $result;
				}else if($dpts == 'LABS' || $dpts == 'IMAGING'){
					$result =$patientsInvestigationRequesttable->selectinvestigation($selected,$servicecode,$visitcode,$unselected,$instcode);
					return $result;
				}else if($dpts == 'PHARMACY'){
					$result =$Prescriptionstable->selectprescription($selected,$servicecode,$visitcode,$unselected,$instcode);
					return $result;
				}else if($dpts == 'DEVICES'){
					$result =$patientsDevicestable->selectdevices($selected,$servicecode,$visitcode,$unselected,$instcode);
					return $result;
				}else if($dpts == 'PROCEDURE'){
					$result =$patientproceduretable->selectprocedures($selected,$servicecode,$visitcode,$unselected,$instcode);
					return $result;
				}else if($dpts == 'MEDREPORTS'){
					$result =$patientsMedicalreportstable->selectmedicalreport($selected,$servicecode,$unselected,$instcode);
					return $result;				
				}else{
					return '0';
				}
			}else{
				return '0';
			}
	}
	// 25 AUG 2023, 31 JAN 2021 
	public function cashierunselectedtransactions($bcode,$billcode,$billingcode,$amt,$servicecode,$dpts,$visitcode,$instcode,$type,$patientbillitemtable,$patientbillingtable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable){
		$bills = $patientbillitemtable->unselectbillingitems($bcode,$visitcode,$instcode);
		if($bills == 2){
			$selected = 1;
			$unselected = '0';
			$patientbillingtable->unselectupdatebilling($amt,$billingcode,$type,$visitcode,$instcode);
			if($dpts == 'SERVICES'){
				$result = $patientsServiceRequesttable->billsunselectservices($selected,$servicecode,$visitcode,$unselected,$instcode);								
				return $result;
			}else if($dpts == 'LABS' || $dpts == 'IMAGING'){
				$result =$patientsInvestigationRequesttable->unselectinvestigation($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($dpts == 'PHARMACY'){	
				$result =$Prescriptionstable->unselectprescription($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($dpts == 'DEVICES'){
				$result =$patientsDevicestable->unselectdevices($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($dpts == 'PROCEDURE'){
				$result =$patientproceduretable->unselectprocedures($selected,$servicecode,$visitcode,$unselected,$instcode);
				return $result;
			}else if($dpts == 'MEDREPORTS'){
				$result =$patientsMedicalreportstable->unselectmedicalreport($selected,$servicecode,$unselected,$instcode);
				return $result;				
			}else{
				return '0';
			}			
		}else{
			return '0';
		}		
	}			

} 

$billprocessingcontroller = new BillProcessingController();
?>