<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$endofdaymodel = htmlspecialchars(isset($_POST['endofdaymodel']) ? $_POST['endofdaymodel'] : '');
	
	// 9 SEPT 2023 JOSEPH ADORBOE  
	switch ($endofdaymodel)
	{
		
		// 10 SEPT 2023, 12 APR 2023, JOSEPH ADORBOE 
		case 'approveendofday':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$approveremarks = htmlspecialchars(isset($_POST['approveremarks']) ? $_POST['approveremarks'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){			
				if(empty($approveremarks)){
					$status = 'error';
					$msg = 'Required Field cannot be null';
				}else{							
					$sqlresults = $endofdaytable->approveendofday($ekey,$approveremarks,$day,$currentusercode,$currentuser,$instcode);
					$action = "End of Day";							
					$result = $engine->getresults($sqlresults,$item='',$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9869;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}				
			}
		break;
		
		// 5 JAN 2023, 10 SEPT 2023,  11 APR 2023 JOSEPH ADORBOE 
		case 'editendofday':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$bankcashtotalamount = htmlspecialchars(isset($_POST['bankcashtotalamount']) ? $_POST['bankcashtotalamount'] : '');
			$bankaccountdetails = htmlspecialchars(isset($_POST['bankaccountdetails']) ? $_POST['bankaccountdetails'] : '');
			$bankdepositslip = htmlspecialchars(isset($_POST['bankdepositslip']) ? $_POST['bankdepositslip'] : '');
			$ecashopeningbalance = htmlspecialchars(isset($_POST['ecashopeningbalance']) ? $_POST['ecashopeningbalance'] : '');
			$ecashtotalamount = htmlspecialchars(isset($_POST['ecashtotalamount']) ? $_POST['ecashtotalamount'] : '');	
			$ecashclosebal = htmlspecialchars(isset($_POST['ecashclosebal']) ? $_POST['ecashclosebal'] : '');
			$cashathand = htmlspecialchars(isset($_POST['cashathand']) ? $_POST['cashathand'] : '');		
			$totalamount = htmlspecialchars(isset($_POST['totalamount']) ? $_POST['totalamount'] : '');
			$shift = htmlspecialchars(isset($_POST['shift']) ? $_POST['shift'] : '');
			$remarks = htmlspecialchars(isset($_POST['remarks']) ? $_POST['remarks'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){			
				if(empty($bankcashtotalamount) || empty($shift) || empty($totalamount)){
					$status = 'error';
					$msg = 'Required Field cannot be null';
				}else{				
					$sshift = explode('@@@',$shift);
					$shiftcode = $sshift['0'];
					$shiftname = $sshift['1'];
					$shiftdate = $sshift['2'];
					$eodnumber = date('His');
									
					$sqlresults = $endofdaytable->updateendofday($ekey,$shiftcode,$shiftname,$shiftdate,$bankcashtotalamount,$bankaccountdetails,$bankdepositslip,$ecashopeningbalance,$ecashtotalamount,$ecashclosebal,$cashathand,$totalamount,$remarks,$currentusercode,$currentuser,$instcode);
					if($sqlresults =='2'){
						$sqlresults = $shifttable->updateshiftendofday($shiftcode,$instcode);
					}
					
					$action = "End of Day";							
					$result = $engine->getresults($sqlresults,$item=$shiftname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9870;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);											
				}				
			}
		break;

		// 5 JAN 2023, 10 SEPT 2023, 11 APR 2023 JOSEPH ADORBOE 
		case 'addendofday':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$bankcashtotalamount = htmlspecialchars(isset($_POST['bankcashtotalamount']) ? $_POST['bankcashtotalamount'] : '');
			$bankaccountdetails = htmlspecialchars(isset($_POST['bankaccountdetails']) ? $_POST['bankaccountdetails'] : '');
			$bankdepositslip = htmlspecialchars(isset($_POST['bankdepositslip']) ? $_POST['bankdepositslip'] : '');
			$ecashopeningbalance = htmlspecialchars(isset($_POST['ecashopeningbalance']) ? $_POST['ecashopeningbalance'] : '');
			$ecashtotalamount = htmlspecialchars(isset($_POST['ecashtotalamount']) ? $_POST['ecashtotalamount'] : '');	
			$ecashclosebal = htmlspecialchars(isset($_POST['ecashclosebal']) ? $_POST['ecashclosebal'] : '');
			$cashathand = htmlspecialchars(isset($_POST['cashathand']) ? $_POST['cashathand'] : '');		
			$totalamount = htmlspecialchars(isset($_POST['totalamount']) ? $_POST['totalamount'] : '');
			$shift = htmlspecialchars(isset($_POST['shift']) ? $_POST['shift'] : '');
			$remarks = htmlspecialchars(isset($_POST['remarks']) ? $_POST['remarks'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){			
				if(empty($bankcashtotalamount) || empty($shift) || empty($ecashopeningbalance) || empty($ecashclosebal)){
					$status = 'error';
					$msg = 'Required Field cannot be null';
				}else{				
					$sshift = explode('@@@',$shift);
					$shiftcode = $sshift['0'];
					$shiftname = $sshift['1'];
					$shiftdate = $sshift['2'];
					$eodnumber = date('His');

					$ecashtotalamount = $ecashclosebal-$ecashopeningbalance;
					$totalamount = $bankcashtotalamount+$ecashtotalamount+$cashathand;					
					
					$sqlresults = $endofdaytable->newendofday($form_key,$eodnumber,$shiftcode,$shiftname,$shiftdate,$bankcashtotalamount,$bankaccountdetails,$bankdepositslip,$ecashopeningbalance,$ecashtotalamount,$ecashclosebal,$cashathand,$totalamount,$remarks,$currentusercode,$currentuser,$instcode);
					if($sqlresults =='2'){
						$sqlresults = $shifttable->updateshiftendofday($shiftcode,$instcode);
					}
					
					$action = "End of Day";							
					$result = $engine->getresults($sqlresults,$item=$shiftname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9871;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 					
														
					}				
				}
		break;

	}

?>
