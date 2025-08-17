<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$partnerpaymentmodel = htmlspecialchars(isset($_POST['partnerpaymentmodel']) ? $_POST['partnerpaymentmodel'] : '');
	
	// 06 MAR 2022 JOSEPH ADORBOE  
switch ($partnerpaymentmodel)
{

	// 5 JAN 2024, 11 SEPT 2023, 06 MAR 2022 JOSEPH ADORBOE 
	case 'addpartnerpayment':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$amountrequested = htmlspecialchars(isset($_POST['amountrequested']) ? $_POST['amountrequested'] : '');
		$receiptnum = htmlspecialchars(isset($_POST['receiptnum']) ? $_POST['receiptnum'] : '');
		$desc = htmlspecialchars(isset($_POST['desc']) ? $_POST['desc'] : '');
		$totalamount = htmlspecialchars(isset($_POST['totalamount']) ? $_POST['totalamount'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){	
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($amountrequested) || empty($receiptnum) ){	
					$status = "error";
					$msg = "Required Fields cannot be empty ";	
				}else{

                    if ($amountrequested !== $totalamount) {
                        $status = "error";
                        $msg = "$amountrequested is NOT equal to the total Amount $totalamount";
                    } else {
                        if (!is_numeric($amountrequested)) {
                            $status = "error";
                            $msg = "$amountrequested is not number ";
                        } else {
                            $rep = $partnerbilltable->getpartnerreceiptnum($receiptnum, $instcode);
                            if ($rep !== '2') {
								$status = "error";
								$msg = "$receiptnum already exisit";
                            } else {
							
                                $sqlresults = $partnerbilltable->updatepartnerpayments($ekey,$amountrequested,$receiptnum,$desc,$days,$currentusercode,$currentuser,$instcode);
								if($sqlresults =='2'){
									$sqlresults  = $patientsInvestigationRequesttable->updatepartnerpaymentsinvestigations($ekey,$instcode);
								}
								$action = 'Payment Successfully';
                                $result = $engine->getresults($sqlresults,$item=$receiptnum,$action);
                                $re = explode(',', $result);
                                $status = $re[0];					
                                $msg = $re[1];
                                $event= "$action: $form_key $msg";
                                $eventcode=9868;
                                $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 					
                        
                            }
                        }
                    }
                }				
			}							
		}

	break;

	

}
	
	
?>
