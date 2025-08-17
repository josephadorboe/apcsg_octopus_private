<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$partnerpaymentmodel = isset($_POST['partnerpaymentmodel']) ? $_POST['partnerpaymentmodel'] : '';
	
	// 06 MAR 2022 JOSEPH ADORBOE  
switch ($partnerpaymentmodel)
{

	// 06 MAR 2022 JOSEPH ADORBOE 
	case 'addpartnerpayment':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$amountrequested = isset($_POST['amountrequested']) ? $_POST['amountrequested'] : '';
		$receiptnum = isset($_POST['receiptnum']) ? $_POST['receiptnum'] : '';
		$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
		$totalamount = isset($_POST['totalamount']) ? $_POST['totalamount'] : '';
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
                            $rep = $partnerpaymentsql->getpartnerreceiptnum($receiptnum, $instcode);
                            if ($rep !== '2') {
								$status = "error";
								$msg = "$receiptnum already exisit";
                            } else {
                                $answer = $partnerpaymentsql->cashierpartnerpaymentadd($ekey,$amountrequested,$receiptnum,$desc,$days,$currentusercode,$currentuser,$instcode);
                                if ($answer == '1') {
                                    $status = "error";
                                    $msg = "Already Selected";
                                } elseif ($answer == '2') {
                                    $event= "partner Payment $ekey for has been saved successfully ";
                                    $eventcode= 102;
                                    $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                    if ($audittrail == '2') {
                                        $status = "success";
                                        $msg = "Payment Successfully";
                                    //  $view = 'cashiertransactions';
                                    } else {
                                        $status = "error";
                                        $msg = "Audit Trail Failed!";
                                    }
                                } elseif ($answer == '0') {
                                    $status = "error";
                                    $msg = "Unsuccessful";
                                } else {
                                    $status = "error";
                                    $msg = "Unknown Source";
                                }
                            }
                        }
                    }
                }				
			}							
		}

	break;

	

}
	
	
?>
