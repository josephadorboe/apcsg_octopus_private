<?php
	REQUIRE_ONCE (INTFILE);	
	$patientpromotionmodel = isset($_POST['patientpromotionmodel']) ? $_POST['patientpromotionmodel'] : '';

	switch ($patientpromotionmodel)
	{

		// 28 DEC 2024, JOSEPH ADROBOE
		case 'addpatientpromotion':
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$promotionsubscription = htmlspecialchars(isset($_POST['promotionsubscription']) ? $_POST['promotionsubscription'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);	
			if($preventduplicate == '1'){
				if (empty($patientcode) || empty($patientnumber) || empty($patient) || empty($promotionsubscription) ) {
						$status = 'error';
						$msg = 'Required Field Cannot be empty';                      
					} else { 
						if (!empty($promotionsubscription)) {							
							$pset = explode('@@@', $promotionsubscription);
							$promotioncode = $pset[0];
							$promotiontitle = $pset[1]; 
							$promotionstartdate = $pset[2]; 
							$promotionenddate = $pset[3]; 
							$promotionvalidityday = $pset[4]; 
							$promotionservicecode = $pset[5]; 
							$promotionservice = $pset[6]; 
							$promotionunitprice = $pset[7]; 
							$promotiontotal = $pset[8]; 
							$promotionqty = $pset[9]; 							                     
						} else {
							$promotioncode = $promotiontitle = $promotionstartdate = $promotionenddate = $promotionvalidityday = 			$promotionservicecode = $promotionservice = $promotionunitprice = $promotiontotal = $promotionqty  = '';
						}
						$patientpromotioncode = md5(microtime());
						$sqlresults = $patientpromotiontable->addnewpatientpromotion($patientpromotioncode,$day,$patientcode,$patientnumber,$patient,$promotioncode,$promotiontitle,$promotionstartdate,$promotionenddate,$promotionvalidityday,$promotionservicecode,$promotionservice,$promotionunitprice,$promotiontotal,$promotionqty,$currentusercode,$currentuser,$instcode);                      
						if($sqlresults == '2'){
							$sqlresults = $promotionsetuptable->updateaddpromotionpendingsubscriber($promotioncode,$instcode);
						}                
						$result = $engine->getresults($sqlresults,$item=$promotiontitle .'for '.$patientnumber .' - '. $patient,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9741;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					                     
					}
			}
		break;	
		// 31 DEC 2024 ,  JOSEPH ADORBOE  
		case 'editpatientpromotionstatus': 
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$promotionstatus = htmlspecialchars(isset($_POST['promotionstatus']) ? $_POST['promotionstatus'] : '');
			$reason = htmlspecialchars(isset($_POST['reason']) ? $_POST['reason'] : '');
			$promotionstate = htmlspecialchars(isset($_POST['promotionstate']) ? $_POST['promotionstate'] : '');
			$promotionpaid = htmlspecialchars(isset($_POST['promotionpaid']) ? $_POST['promotionpaid'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);	
			if($preventduplicate == '1'){
				if(empty($ekey) ||  empty($reason) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
					// if($promotionpaid == '1' && $promotionstate == '2'){
					// 	$promotionstatus = 
					// }					
					$sqlresults = $patientpromotiontable->editpatientpromotionsubscription($ekey,$promotionstatus,$day,$reason,$currentusercode,$currentuser,$instcode);
					if($sqlresults == '2'){
						// if($promotionstate == '0'){

						// }
					// 	$cash = 'CASH';
					// 	$pricingtable->setcashprices($itemcode=$servicecode,$item=$servicename,$newprice=$unitprice,$alternateprice=$unitprice,$dollarprice='0.00',$partnerprice=$unitprice,$cashpricecode=md5(microtime()),$category='1',$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);                       
					 }  
					$action = 'Edit Promotion';							
					$result = $engine->getresults($sqlresults,$item='',$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9748;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);   
				}
			}
		break;
	

	} 
?>
