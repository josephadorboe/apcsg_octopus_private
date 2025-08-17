 <?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$pharmamodel = htmlspecialchars(isset($_POST['pharmamodel']) ? $_POST['pharmamodel'] : '');

	// 20 NOV 2023
	switch ($pharmamodel)
	{
				

		// 21 NOV 2023, 18 OCT 2022   JOSEPH ADORBOE  
		case 'rejecttransfers':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$requestedqty = htmlspecialchars(isset($_POST['requestedqty']) ? $_POST['requestedqty'] : '');
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');
			$itemqty = htmlspecialchars(isset($_POST['itemqty']) ? $_POST['itemqty'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');
			$rejectreason = htmlspecialchars(isset($_POST['rejectreason']) ? $_POST['rejectreason'] : '');
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($rejectreason) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{

					$sqlresults =  $stockadjustmenttable->rejecttransfers($ekey,$days,$rejectreason,$currentusercode,$currentuser,$instcode);
					if($sqlresults =='2'){	
						if ($type == '2') {
							$medicationtable->rejecttransfermedications($itemqty,$itemcode,$instcode);
							$batchestable->returntostoresreducebatchnumberqty($batchnumber,$itemqty,$instcode);
						}
						if ($type == '5') {
							$devicesetuptable->rejecttransferdevices($itemqty,$itemcode,$instcode);
							$batchestable->returntostoresreducebatchnumberqty($batchnumber,$itemqty,$instcode);
						}
						if ($type == '11') {
							$consumablesetuptable->rejecttransferconsumable($itemqty,$itemcode,$instcode);
							$batchestable->returntostoresreducebatchnumberqty($batchnumber,$itemqty,$instcode);
						}
						if ($type == '8') {
							$generalitemstable->rejecttransfergeneralitems($itemqty,$itemcode,$instcode);
							$batchestable->returntostoresreducebatchnumberqty($batchnumber,$itemqty,$instcode);
						}
					}	
					
				$action = "Reject Transfers";									
				$result = $engine->getresults($sqlresults,$item=$item .' '.$itemqty ,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=363;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);		
					
				}
			}

		break;
		
		// 20 NOV 2023, 18 OCT 2022   JOSEPH ADORBOE  
		case 'accepttransfers':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$requestedqty = htmlspecialchars(isset($_POST['requestedqty']) ? $_POST['requestedqty'] : '');
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');
			$itemqty = htmlspecialchars(isset($_POST['itemqty']) ? $_POST['itemqty'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
					if(!is_numeric($suppliedqty)){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($suppliedqty < 0 || $suppliedqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else if($suppliedqty != $itemqty){
						$status = "error";
						$msg = "Quantity in Pharmacy NOT same ";
					}else{	
					$sqlresults =  $stockadjustmenttable->accepttransfers($ekey,$days,$currentusercode,$currentuser,$instcode);
					if($sqlresults =='2'){	
						if ($type == '2') {
							$medicationtable->accepttransfermedications($itemqty,$itemcode,$instcode);
						}
						if ($type == '5') {
							$devicesetuptable->accepttransferdevices($itemqty,$itemcode,$instcode);
						}
						if ($type == '11') {
							$consumablesetuptable->accepttransferconsumable($itemqty,$itemcode,$instcode);
						}
						if ($type == '8') {
							$generalitemstable->accepttransfergeneralitems($itemqty,$itemcode,$instcode);
						}
					}	
						
					$action = "Accept Transfers";									
					$result = $engine->getresults($sqlresults,$item=$item.' '.$suppliedqty,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=364;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);		
										
				}
				}
			}

		break;
	
	}	
		
?>

