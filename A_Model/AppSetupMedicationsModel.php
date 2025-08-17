<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model/model.php';	
	$setupmedicationmodel = htmlspecialchars(isset($_POST['setupmedicationmodel']) ? $_POST['setupmedicationmodel'] : '');
	$dept = 'OPD';
	Global $instcode;

	
	// 28 NOV 2023 JOSEPH ADORBOE  
	switch ($setupmedicationmodel)
	{

		// 12 DEC 2023, 12 NOV 2023 JOSEPH ADORBOE  
		case 'createbatchmedication':
			$batchqty = htmlspecialchars(isset($_POST['batchqty']) ? $_POST['batchqty'] : '');
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');	
			$totalqty = htmlspecialchars(isset($_POST['totalqty']) ? $_POST['totalqty'] : '');	
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');	
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');	
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');	
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($batchqty) || empty($itemcode) || empty($totalqty)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					if(!is_numeric($batchqty) ){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($batchqty > $storeqty ){
						$status = "error";
						$msg = "insufficent store Quantity ";
					}else if($batchqty < 0 || $batchqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else{	
						$validateqty = $engine->getnumbernonzerovalidation($batchqty);
						if ($validateqty == '1') {
							$status = 'error';
							$msg = "Qty value is invalid";
							return '0';
						}
						$adnumber = rand(1,100);
						$batchnumber = 'BA'.date('His').rand(10,99);
						$batchcode = md5(microtime());	
						$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
						$batchdescription = 'Standalone Batch';
					//	$stockvalue = $suppliedqty*$totalqty;
					// 	batchnumber
					$sqlresults = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$medication,$category,$costprice,$cashprice,$batchqty,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);						
					$action = "New Batch added";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9971;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
					}
				}
			}
		break;

		// 12 DEC 2023, 23 JULY 2023  JOSEPH ADORBOE  
		case 'approvebulkmedicationreturntosuppliers':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				foreach($_POST["scheckbox"] as $key){
					$kt = explode('@@@',$key);
					$ajustcode = $kt['0'];
					$itemcode = $kt['1'];
					$medication = $kt['2'];
					$addqty = $kt['3'];
					$batchcode = $kt['4'];
					$batchnumber = $kt['5'];					
					$start = $medicationtable->returntosuppliermedicationsbulk($addqty,$itemcode,$instcode);
					if($start == '2'){
						$med = $medicationtable->calculatemedicationstockvalue($itemcode,$instcode);	
						$std = $stockadjustmenttable->approvebulkrestock($ajustcode,$instcode);	
						$bt = $batchestable->returntosupplierbatchnumberqty($batchnumber,$addqty,$instcode);	
						
						if($std == '2' && $bt == '2' && $med == '2'){
							$sqlresults = '2';
						}else{
							$sqlresults = '0';
						}					
					}							
					$action = "Approve return to supplier Medication";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9972;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}

		break;

		// 11 DEC 2023, 12 NOV 2023 JOSEPH ADORBOE  
		case 'editmedicationreturntosupplier':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$supplier = htmlspecialchars(isset($_POST['supplier']) ? $_POST['supplier'] : '');	
			$returnstockvalue = htmlspecialchars(isset($_POST['returnstockvalue']) ? $_POST['returnstockvalue'] : '');	
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');	
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$oldqty = htmlspecialchars(isset($_POST['oldqty']) ? $_POST['oldqty'] : '');	
			$batchprocessorcode = htmlspecialchars(isset($_POST['batchprocessorcode']) ? $_POST['batchprocessorcode'] : '');
			$batchprocessnumber = htmlspecialchars(isset($_POST['batchprocessnumber']) ? $_POST['batchprocessnumber'] : '');
			$batchprocessnumber = htmlspecialchars(isset($_POST['batchprocessnumber']) ? $_POST['batchprocessnumber'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');	
			$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');				
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty) || empty($supplier) || empty($batch)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					if(!is_numeric($suppliedqty) ){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($suppliedqty < 0 || $suppliedqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else{	
						$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
						if ($validateqty == '1') {
							$status = 'error';
							$msg = "Qty value is invalid";
							return '0';
						}
						if($batchprocessorcode == '0'){
							$batchprocessnumber = date('his');
							$batchprocessorcode = md5(microtime());		
						}
						
						$bt = explode('@@@', $batch);
						$batchcode = $bt['0'];
						$batchnumber = $bt['1'];
						$batchqty = $bt['2'];
						$batchexpiry = $bt['3'];
						if ($suppliedqty > $batchqty) {
							$status = 'error';
							$msg = "Qty insufficent";
							return '0';
						}else{

					$transferqty = 0;			
					$newqty = $oldqty + $suppliedqty;
						
						$sqlresults = $stockadjustmenttable->editreturntosupplier($ekey,$supplier,$returnstockvalue,$description,$suppliedqty,$batchcode,$batchnumber,$currentusercode,$currentuser,$instcode);	
						$action = "Edit Return to Suppliers Medication";									
						$result = $engine->getresults($sqlresults,$item=$medication,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9974;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	

						}				
				
					}
				}
			}
		break;


		// 12 DEC 2023, JOSEPH ADORBOE  
		case 'deletemedicationreturntosupplier':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');	
			$batchcode = htmlspecialchars(isset($_POST['batchcode']) ? $_POST['batchcode'] : '');	
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					$sqlresults = $stockadjustmenttable->deletependingstockajustment($ekey,$currentusercode,$currentuser,$instcode);						
					$action = "Delete Medication Return to Supplier ";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9973;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}				
			}
		break;

		// 11 DEC 2023, 18 MAY 2023  JOSEPH ADORBOE  
		case 'bulkreturntosuppliermedicationstocks':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){													
				foreach($_POST["scheckbox"] as $key => $value){
					(int)$suppliedqty = $_POST["suppliedqty"][$key];
					$supplier = $_POST["supplier"][$key];
					$suppliervalue = $_POST["suppliervalue"][$key];
					$description = $_POST["description"][$key];
					$kt = explode('@@@',$value);
					$itemcode = $kt['0'];
					$itemnumber = $kt['1'];
					$item = $kt['2'];
					(int)$storeqty = $kt['3'];
					(int)$totalqty = $kt['4'];
					$unit = $kt['5'];
					$cashprice = $kt['6'];

				if(!empty($suppliedqty) && !empty($supplier) && !empty($suppliervalue) && !empty($description) ){					
					
					if(!is_numeric($suppliedqty)){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($suppliedqty < 0 || $suppliedqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else if($suppliedqty>$storeqty){
						$status = "error";
						$msg = "Quantity in store NOT sufficent for this transfer ";
					}else{	
					$type = 15;	
					$adjustmentnumber = 'AD'.date('His').rand(10,99);
					(int)$newstoreqty = (int)$storeqty - (int)$suppliedqty;
				//	$newpharmacyqty = $itemqty - $suppliedqty;
					// $totalqty = $newstoreqty + $transferqty + $itemqty; 
					$stockvalue = $totalqty * $cashprice;               
					$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
				//  $expirycode = md5(microtime());
					$ajustcode = md5(microtime());

					$validatesuppliedqty = $engine->getnumbernonzerovalidation($suppliedqty);
					if ($validatesuppliedqty == '1') {
						$status = 'error';
						$msg = "Qty value is invalid";
						return '0';
					}

				//	$description = 'Return to Supplier Medication';
					$zero = '0';

					$sqlresults = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newstoreqty,$totalqty,$unit,$costprice=$zero,$newprice=$zero,$batchcode=$zero,$batchnumber=$zero,$insuranceprice=$zero,$dollarprice=$zero,$currentshift,$currentshiftcode,$expire,$type,$state='0',$value=$suppliervalue,$supplier,$description,$currentuser,$currentusercode,$instcode);
					$action = "Bulk Return to Supplier Medications";									
					$result = $engine->getresults($sqlresults,$item,$action);									
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9975;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
				}
				}
				}
			}

		break;

		// 11 DEC 2023, 23 JULY 2023  JOSEPH ADORBOE  
		case 'approvebulkmedicationreturntostores':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				foreach($_POST["scheckbox"] as $key){
					$kt = explode('@@@',$key);
					$ajustcode = $kt['0'];
					$itemcode = $kt['1'];
					$medication = $kt['2'];
					$addqty = $kt['3'];
					// $batchcode = $kt['4'];
					// $batchnumber = $kt['5'];
					$batchnumber = 'BA'.date('His').rand(10,99);
					$batchcode = md5(microtime());
					$costprice=$cashprice='0';
					$batchdescription = 'Automatic batch for return to stores';
					$expire = date('Y-m-d', strtotime($day. '+ 3 months'));

					$start = $medicationtable->returntostoresmedications($addqty,$itemcode,$instcode);
					if($start == '2'){	
						$std = $stockadjustmenttable->approvebulkrestock($ajustcode,$instcode);	
						$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item=$medication,$batchcategory=3,$costprice,$cashprice,$suppliedqty=$addqty,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);
					//	$bt = $batchestable->increasebatchqty($batchcode,$addqty,$instcode);	
						if($std == '2' && $batch == '2'){
							$sqlresults = '2';
						}else{
							$sqlresults = '0';
						}					
					}							
					$action = "Approve return to stores Medication";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9976;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}

		break;

		// 11 DEC 2023, 12 NOV 2023 JOSEPH ADORBOE  
		case 'editmedicationreturntostores':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$oldqty = htmlspecialchars(isset($_POST['oldqty']) ? $_POST['oldqty'] : '');	
		//	$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');				
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					if(!is_numeric($suppliedqty) ){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($suppliedqty < 0 || $suppliedqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else{	
						$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
						if ($validateqty == '1') {
							$status = 'error';
							$msg = "Qty value is invalid";
							return '0';
						}
		
					$transferqty = 0;			
					$newqty = $oldqty + $suppliedqty;
					$batchcode=$batchnumber='0';
					$sqlresults = $stockadjustmenttable->edittransfer($ekey,$suppliedqty,$batchcode,$batchnumber,$currentusercode,$currentuser,$instcode);;						
					$action = "Edit Return to stores Medication";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9978;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					}
				}
			}
		break;
		// 11 DEC 2023, JOSEPH ADORBOE  
		case 'deletemedicationreturntostores':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');	
			$batchcode = htmlspecialchars(isset($_POST['batchcode']) ? $_POST['batchcode'] : '');	
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					$sqlresults = $stockadjustmenttable->deletependingstockajustment($ekey,$currentusercode,$currentuser,$instcode);						
					$action = "Delete Medication Return to stores ";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9977;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}				
			}
		break;

		// 11 DEC 2023, 18 MAY 2023  JOSEPH ADORBOE  
		case 'bulkreturntostoresmedicationstocks':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){													
				foreach($_POST["scheckbox"] as $key => $value){
					(int)$suppliedqty = $_POST["suppliedqty"][$key];
					(int)$storeqty = $_POST["storeqty"][$key];
					(int)$transferqty = $_POST["transferqty"][$key];
					$kt = explode('@@@',$value);
					$itemcode = $kt['0'];
					$itemnumber = $kt['1'];
					$item = $kt['2'];
					(int)$storeqty = $kt['3'];
					(int)$itemqty = $kt['4'];
					$unit = $kt['5'];
					$cashprice = $kt['6'];

				if(!empty($suppliedqty) ){					
					
					if(!is_numeric($suppliedqty)){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($suppliedqty < 0 || $suppliedqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else if($suppliedqty>$itemqty){
						$status = "error";
						$msg = "Quantity in Shelf NOT sufficent for this transfer ";
					}else{	
					$type = 3;	
					$adjustmentnumber = 'AD'.date('His').rand(10,99);
					$newstoreqty = $storeqty + $suppliedqty;
					$newpharmacyqty = $itemqty - $suppliedqty;
					$totalqty = $newstoreqty + $transferqty + $newpharmacyqty; 
					$stockvalue = $totalqty * $cashprice;               
					$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
				//    $expirycode = md5(microtime());
					$ajustcode = md5(microtime());

					$validatesuppliedqty = $engine->getnumbernonzerovalidation($suppliedqty);
					if ($validatesuppliedqty == '1') {
						$status = 'error';
						$msg = "Qty value is invalid";
						return '0';
					}

					$description = 'Return to stores Medication';
					$zero = '0';

					$sqlresults = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newpharmacyqty,$newstoreqty,$unit,$costprice=$zero,
					$newprice=$zero,$batchcode=$zero,$batchnumber=$zero,$insuranceprice=$zero,$dollarprice=$zero,$currentshift,$currentshiftcode,$expire,$type,$state='0',$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);
					
					$action = "Bulk Return to stores Medications";									
					$result = $engine->getresults($sqlresults,$item,$action);									
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9979;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
					}
				}
				}
			}
		break;


		// 10 DEC 2023, 23 JULY 2023  JOSEPH ADORBOE  
		case 'approvebulkmedicationtransfer':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				foreach($_POST["scheckbox"] as $key){
					$kt = explode('@@@',$key);
					$ajustcode = $kt['0'];
					$itemcode = $kt['1'];
					$medication = $kt['2'];
					$addqty = $kt['3'];
					$batchcode = $kt['4'];
					$batchnumber = $kt['5'];					
					$sqlresults = $medicationtable->transfermedications($addqty,$itemcode,$instcode);
					if($sqlresults == '2'){	
						$std = $stockadjustmenttable->approvebulkrestock($ajustcode,$instcode);	
					//	$bt = $batchestable->reducebatchqty($batchcode,$addqty,$instcode);	
						$sqlresults = $batchestable->transferbulkbatchprocess($itemcode,$qty=$addqty,$instcode);	
						// if($std == '2' && $bt == '2'){
						// 	$sqlresults = '2';
						// }else{
						// 	$sqlresults = '0';
						// }					
					}		
										
					$action = "Approve transfer Medication";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=307;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				
				}
			}

		break;
		// 10 DEC 2023, JOSEPH ADORBOE  
		case 'deletemedicationtransfer':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');	
			$batchcode = htmlspecialchars(isset($_POST['batchcode']) ? $_POST['batchcode'] : '');	
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					$sqlresults = $stockadjustmenttable->deletependingstockajustment($ekey,$currentusercode,$currentuser,$instcode);						
					$action = "Delete Medication Transfer";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9980;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}				
			}
		break;

		// 28 MAR 2024, 10 DEC 2023, 12 NOV 2023, JOSEPH ADORBOE  
		case 'editmedicationtransfer':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$oldqty = htmlspecialchars(isset($_POST['oldqty']) ? $_POST['oldqty'] : '');	
			$batchcode = htmlspecialchars(isset($_POST['batchcode']) ? $_POST['batchcode'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');		
			$totalbatchqty = htmlspecialchars(isset($_POST['totalbatchqty']) ? $_POST['totalbatchqty'] : '');				
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					if(!is_numeric($suppliedqty) ){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($suppliedqty < 0 || $suppliedqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else{	
						$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
						if ($validateqty == '1') {
							$status = 'error';
							$msg = "Qty value is invalid";
							return '0';
						}
						
						if ((int)$suppliedqty > (int)$totalbatchqty) {
							$status = 'error';
							$msg = "Qty insufficent";
							return '0';
						}else{	

					$transferqty = 0;			
					$newqty = (int)$oldqty + (int)$suppliedqty;
			
					// batchnumber
					$sqlresults = $stockadjustmenttable->edittransfer($ekey,$suppliedqty,$batchcode,$batchnumber,$currentusercode,$currentuser,$instcode);					
					$action = "Edit Transfer Medication";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9981;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					
						}				
					}
				}
			}
		break;

		// 10 DEC 2023, 18 MAY 2023  JOSEPH ADORBOE  
		case 'bulktransfermedicationstocks':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){													
				foreach($_POST["scheckbox"] as $key => $value){
					$suppliedqty = $_POST["suppliedqty"][$key];
					$storeqty = $_POST["storeqty"][$key];
					$transferqty = $_POST["transferqty"][$key];
					$kt = explode('@@@',$value);
					$itemcode = $kt['0'];
					$itemnumber = $kt['1'];
					$item = $kt['2'];
					$storeqty = $kt['3'];
					$itemqty = $kt['4'];
					$unit = $kt['5'];
					$cashprice = $kt['6'];
				if(!empty($suppliedqty) ){						
					if(!is_numeric($suppliedqty)){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($suppliedqty < 0 || $suppliedqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else if($suppliedqty>$storeqty){
						$status = "error";
						$msg = "Quantity in store NOT sufficent for this transfer ";
					}else{	
					$type = 2;	
					$adjustmentnumber = 'AD'.date('His').rand(10,99);
					$newstoreqty = $storeqty - $suppliedqty;
					$newtransferqty = $transferqty + $suppliedqty;
					$totalqty = $newstoreqty + $newtransferqty + $itemqty; 
					$stockvalue = $totalqty * $cashprice;               
					$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
					$ajustcode = md5(microtime());
					$batchtotalqty = $batchestable->gettotalbatchqty($days,$itemcode,$itemname=$item,$category=3,$qty=$storeqty,$expire,$stockvalue,$cashprice,$cashprice,$currentuser,$currentusercode,$instcode);

					$validatesuppliedqty = $engine->getnumbernonzerovalidation($suppliedqty);
					if ($validatesuppliedqty == '1') {
						$status = 'error';
						$msg = "Qty value is invalid";
						return '0';
					}

					$description = 'Transfer Medication';
					$zero = '0';
					$batchprocesscode = md5(microtime());
					$batchprocessnumber = rand(100,10000);
					$sqlresults = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newtransferqty,$storeqty,$unit,$costprice=$zero,$newprice=$zero,$batchcode=$batchprocesscode,$batchnumber=$batchprocessnumber,$insurancepric=$zero,$dollarprice=$zero,$currentshift,$currentshiftcode,$expire,$type,$state='0',$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);
					
					$action = "Bulk tansfer Medications";									
					$result = $engine->getresults($sqlresults,$item,$action);									
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9982;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
						}
					}
				}
			}
		break;

		// 9 DEC 2023  JOSEPH ADORBOE  
		case 'approvebulkmedicationrestock':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				foreach($_POST["scheckbox"] as $key){
					
					$kt = explode('@@@',$key);
					$ajustcode = $kt['0'];
					$itemcode = $kt['1'];
					$medication = $kt['2'];
					$addqty = $kt['3'];
					$cashprice = $kt['4'];
					$costprice = $kt['5'];
					$dollarprice = $kt['6'];
					$insuranceprice = $kt['7'];
					$batchcode = $kt['8'];
					$alternateprice='0';
					$partnerprice = '0';
					$cashpricecode = md5(microtime());
					$category ='2';
					$cash = 'CASH';
					$start = $medicationtable->updatemedicationapprove($itemcode,$addqty,$costprice,$cashprice,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode);
					if($start == '2'){	
						$med = $medicationtable->calculatemedicationstockvalue($itemcode,$instcode);
						$std = $stockadjustmenttable->approvebulkrestock($ajustcode,$instcode);	
						$bat = $batchestable->approvebatch($batchcode,$instcode);
						$cp = $pricingtable->setcashprices($itemcode,$item=$medication,$cashprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);	
						if($med == '2' && $std == '2' && $cp == '2'){
							$sqlresults = '2';
						}else{
							$sqlresults = '0';
						}					
					}							
					$action = "Approve Restock Medication";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9983;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);		
			
				}
			}

		break;

		// 8 DEC 2023, JOSEPH ADORBOE  
		case 'deletemedicationrestocking':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');	
			$batchcode = htmlspecialchars(isset($_POST['batchcode']) ? $_POST['batchcode'] : '');	
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					$sqlresults = $stockadjustmenttable->deletependingstockajustment($ekey,$currentusercode,$currentuser,$instcode);
					if($sqlresults == '2'){			
						$bat = $batchestable->deletebatch($batchcode,$instcode);	
						$exp = $expirytable->disableexpiry($batchcode,$instcode);
						if($exp == '2' && $bat == '2'){
							$sqlresults = '2';
						}else{
							$sqlresults = '0';
						}
					}							
					$action = "Delete Restock Medication";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9984;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}				
			}
		break;
		// 8 DEC 2023,  JOSEPH ADORBOE  
		case 'editmedicationrestocking':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$oldqty = htmlspecialchars(isset($_POST['oldqty']) ? $_POST['oldqty'] : '');	
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');	
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');	
			$insuranceprice = htmlspecialchars(isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '');	
			$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');	
			$expiry = htmlspecialchars(isset($_POST['expiry']) ? $_POST['expiry'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');		
			$batchcode = htmlspecialchars(isset($_POST['batchcode']) ? $_POST['batchcode'] : '');				
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty) ||  empty($costprice) || empty($cashprice) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					if(!is_numeric($suppliedqty) || !is_numeric($costprice) || !is_numeric($cashprice)){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($suppliedqty < 0 || $suppliedqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else{	
						$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
						if ($validateqty == '1') {
							$status = 'error';
							$msg = "Qty value is invalid";
							return '0';
						}
						$validatecostprice = $engine->getnumbernonzerovalidation($costprice);
						if ($validatecostprice == '1') {
							$status = 'error';
							$msg = "Cost Price value is invalid";
							return '0';
						}
						$validatenewprice = $engine->getnumbernonzerovalidation($cashprice);
						if ($validatenewprice == '1') {
							$status = 'error';
							$msg = "New Price value is invalid";
							return '0';
						}
						$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
						if ($validateinsuranceprice == '1') {
							$status = 'error';
							$msg = "Insurance Price value is invalid";
							return '0';
						}						
						$validatedollarprice = $engine->getnumbervalidation($dollarprice);
						if ($validatedollarprice == '1') {
							$status = 'error';
							$msg = "Dollar Price value is invalid";
							return '0';
						}						

						$type = 1;	
						$transferqty = 0;			
						$newqty = (int)$oldqty + (int)$suppliedqty;
						$xp = explode("-",$expiry);
						$fday = $xp[0];
						$fmonth = $xp[1];
						$fyear = $xp[2];
						$expire = $fyear.'-'.$fmonth.'-'.$fday;
			
                if ($expire < $day) {
                    $status = "error";
                    $msg = "Stock expiry date cannot be before $day Unsuccessful";
                } else {
					// batchnumber
					$sqlresults  = $stockadjustmenttable->editstockadjustment($ekey,$suppliedqty,$costprice,$cashprice,$insuranceprice,$dollarprice,$expire,$currentuser,$currentusercode,$instcode);
					
					if($sqlresults == '2'){			
						$bat = $batchestable->editbatchpending($batchcode,$suppliedqty,$expire,$suppliedqty,$currentusercode,$currentuser,$instcode);
						$exp = $expirytable->editexpiry($batchcode,$suppliedqty,$expire,$currentuser,$currentusercode,$instcode);					
						if($exp == '2' && $bat == '2'){
							$sqlresults = '2';
						}else{
							$sqlresults = '0';
						}
					}										
					$action = "Edit Restock Medications";									
					$result = $engine->getresults($sqlresults,$item=$medication.' Batch NO: '.$batchnumber,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9985;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}
			}
			}
		break;

		// 7 DEC 2023, 16 MAY 2023  JOSEPH ADORBOE  
		case 'bulkrestockmedicationstores':										
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($_POST["scheckbox"]) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	

					foreach($_POST["scheckbox"] as $key => $value){
						$suppliedqty = $_POST["suppliedqty"][$key];
						$costprice = $_POST["costprice"][$key];
						$newprice = $_POST["newprice"][$key];
						$dollarprice = $_POST["dollarprice"][$key];
						$insuranceprice = $_POST["insuranceprice"][$key];
						$expire = $_POST["expire"][$key];						
						$kt = explode('@@@',$value);
						$itemcode = $kt['0'];
						$itemnumber = $kt['1'];
						$item = $kt['2'];
						$storeqty = $kt['3'];
						$itemqty = $kt['4'];
						$unit = $kt['5'];
						$cashprice = $kt['6'];
						
						if(!empty($suppliedqty) && !empty($itemcode)){

							if(!is_numeric($suppliedqty) || !is_numeric($costprice) || !is_numeric($newprice)){
								$status = "error";
								$msg = "Quantity MUST be a Number Only ";
							}else if($suppliedqty < 0 || $suppliedqty == 0){
								$status = "error";
								$msg = "Quantity cannot be zero or less ";
							}else{	
								$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
								if ($validateqty == '1') {
									$status = 'error';
									$msg = "Qty value is invalid";
									return '0';
								}
												
								$validatecostprice = $engine->getnumbernonzerovalidation($costprice);
								if ($validatecostprice == '1') {
									$status = 'error';
									$msg = "Cost Price value is invalid";
									return '0';
								}

								$validatenewprice = $engine->getnumbernonzerovalidation($newprice);
								if ($validatenewprice == '1') {
									$status = 'error';
									$msg = "New Price value is invalid";
									return '0';
								}
								
								$validatedollarprice = $engine->getnumbervalidation($dollarprice);
								if ($validatedollarprice == '1') {
									$status = 'error';
									$msg = "Dollar Price value is invalid";
									return '0';
								}

								$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
								if ($validateinsuranceprice == '1') {
									$status = 'error';
									$msg = "Insurance Price value is invalid";
									return '0';
								}
								
								$type = 1;	
								$transferqty = 0;
								$adjustmentnumber = 'AD'.date('His').rand(10,99);
								$newqty = $storeqty + $suppliedqty;
								$totalqty = $newqty + $transferqty + $itemqty; 
								$stockvalue = $totalqty * $newprice;
								$expirycode = md5(microtime());
								$ajustcode = md5(microtime());
								$cashpricecode = md5(microtime());
								$alternateprice = $partnerprice = $newprice;
								$batchcategory = 3;
								$xp = explode("-",$expire);
								$fday = $xp[0];
								$fmonth = $xp[1];
								$fyear = $xp[2];
								$expire = $fyear.'-'.$fmonth.'-'.$fday;
								
								if ($expire < $day) {
									$status = "error";
									$msg = " Stock expiry date cannot be before $day  Unsuccessful";
								} else {
									$batchnumber = 'BA'.date('His').rand(10,99);
									$batchcode = md5(microtime());	
									$description = 'Restock Medication';

									$sqlresults = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$costprice,
									$newprice,$batchcode,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$type,$state='0',$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);
									
									if($sqlresults == '2'){
										$batch = $batchestable->newbatchespending($batchcode,$batchnumber,$days,$itemcode,$item,$batchcategory,$costprice,$cashprice,$suppliedqty,$batchdescription = "BULK RESTOCK",$expire,$currentuser,$currentusercode,$instcode);
										$exp = $expirytable->newexpiry($expirycode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$expire,$batchcode,$batchnumber,$currentuser,$currentusercode,$instcode);									
									}
									$action = "Bulk Restock Medications with batch Number: $batchnumber";									
									$result = $engine->getresults($sqlresults,$item,$action);									
									$re = explode(',', $result);
									$status = $re[0];					
									$msg = $re[1];
									$event= "$action: $form_key $msg";
									$eventcode=9986;
									$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);													
							
								}						
								
							}
						}
					}
				}
			}
		break;

		// 5 DEC 2023,   JOSEPH ADORBOE  
		case 'returntosuppliers':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$returnqty = htmlspecialchars(isset($_POST['returnqty']) ? $_POST['returnqty'] : '');
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$itemnumber = htmlspecialchars(isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '');	
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');	
			$itemqty = htmlspecialchars(isset($_POST['itemqty']) ? $_POST['itemqty'] : '');	
			$unit = htmlspecialchars(isset($_POST['unit']) ? $_POST['unit'] : '');	
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');			
			$newprice = htmlspecialchars(isset($_POST['newprice']) ? $_POST['newprice'] : '');	
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');	
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');	
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');	
			$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');	
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$supplier = htmlspecialchars(isset($_POST['supplier']) ? $_POST['supplier'] : '');
			$returnstockvalue = htmlspecialchars(isset($_POST['returnstockvalue']) ? $_POST['returnstockvalue'] : '');	
			$batchtotalqty = htmlspecialchars(isset($_POST['batchtotalqty']) ? $_POST['batchtotalqty'] : '');						
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($returnqty) ||  empty($description) || empty($supplier) || empty($returnstockvalue)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					if(!is_numeric($returnqty)){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($returnqty < 0 || $returnqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else if($returnqty>$storeqty){
						$status = "error";
						$msg = "Quantity in Pharmacy NOT sufficent for this return ";
					}else{	
					$adjustmentnumber = 'AD'.date('His').rand(10,99);
					$newqty = $storeqty - $returnqty;
					$oldqty = $storeqty + $itemqty + $transferqty;				
					$newtotalqty = $oldqty - $returnqty; 
					$stockvalue = $newtotalqty * $cashprice;
					
					$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
					$expirycode = md5(microtime());
					$ajustcode = md5(microtime());
					$processbatchcode = md5(microtime());
					$processbatchnumber = rand(100,100000);
					

					if($returnqty>$batchtotalqty){
						$status = "error";
						$msg = " Insufficent batch qty to return ";						
					} else {
						$sqlresults = $medicationtable->returntosuppliermedications($returnqty,$newtotalqty,$itemcode,$stockvalue,$instcode);	
						if($sqlresults =='2'){	
							$trans  = $stockadjustmenttable->stockadjustmentsreturn($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty=$returnqty,$newqty,$storeqty,$unit,$processbatchcode,$processbatchnumber,$currentshift,$currentshiftcode,
							$expire,$type,$state=1,$supplier,$description,$value=$returnstockvalue,$currentuser,$currentusercode,$instcode);
								
							if($trans == '2'){	

								$bal =  $returnqty;
								$rem = 0;
								foreach($_POST["scheckbox"] as $key){
									$kt = explode('@@@',$key);
									$batchcode = $kt['0'];
									$batchnumber = $kt['1'];
									$batchqty = $kt['2'];
									$batchexpiry = $kt['3'];
									if($batchqty > $bal){
										$qty = $bal;
										$rem = 0;
										$state = 1;
									}else if($batchqty == $bal){
										$qty = $bal;
										$rem = 0;
										$state = 2;
									}
									else{
										$qty = $batchqty;
										$rem = $bal - $batchqty;
										$state = 2;
									}
									$sqlresults = $batchestable->returntosupplierbatchprocess($batchcode,$qty,$state,$instcode);	
									$bal= $rem;	
									if($bal == 0){
										break;	
									}								
								}
							}else{
								$medicationtable->reverse_returntosuppliermedications($returnqty,$itemcode,$instcode);
								$stockadjustmenttable->revrse_stockadjustments($ajustcode,$instcode);
							}		 
																	
						}else{
							$medicationtable->reverse_returntosuppliermedications($returnqty,$itemcode,$instcode);
							$stockadjustmenttable->revrse_stockadjustments($ajustcode,$instcode);
						}				
						$action = "Return to Supplier Medications";									
						$result = $engine->getresults($sqlresults,$item,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9987;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
						}
					}
				}
			}
		break;

		// 3 DEC 2023,   JOSEPH ADORBOE  
		case 'returnfromstores':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$itemnumber = htmlspecialchars(isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '');	
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');	
			$itemqty = htmlspecialchars(isset($_POST['itemqty']) ? $_POST['itemqty'] : '');	
			$unit = htmlspecialchars(isset($_POST['unit']) ? $_POST['unit'] : '');	
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');			
			$newprice = htmlspecialchars(isset($_POST['newprice']) ? $_POST['newprice'] : '');	
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');	
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');	
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');	
			$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');				
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
					}else if($suppliedqty>$itemqty){
						$status = "error";
						$msg = "Quantity in Pharmacy NOT sufficent for this return ";
					}else{	
				//	$type = 3;	
					$adjustmentnumber = 'AD'.date('His').rand(10,99);
					$newstoreqty = $storeqty + $suppliedqty;
					$newtransferqty = $transferqty + $suppliedqty;
					$totalqty = $newstoreqty + $transferqty + $itemqty; 
					$stockvalue = $totalqty * $cashprice;					
					$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
					$expirycode = md5(microtime());
					$ajustcode = md5(microtime());
					$batchcode = md5(microtime());
					$batchnumber = 'BA'.date('his').rand(10,99);
					
					$sqlresults = $medicationtable->returntostoresmedications($suppliedqty,$itemcode,$instcode);	
					if($sqlresults =='2'){
						$description = 'Return to stores Medication ';	
						$trans  = $stockadjustmenttable->stockadjustmentsreturn($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty=$totalqty,$storeqty=$newstoreqty,$unit,$batchcode,$batchnumber,$currentshift,$currentshiftcode,$expire,$type,$state=1,$supplier='NA',$description,$value='0',$currentuser,$currentusercode,$instcode);
						$batch = $batchestable->addnewbatches($batchcode,$batchnumber,$days,$itemcode,$itemname=$item,$category=3,$qtysupplied=$suppliedqty,$qtyleft=$suppliedqty,$description,$expire,$currentuser,$currentusercode,$instcode);
						if($trans == '2' && $batch == '2'){
							$sqlresults ='2';
						}else{
							$sqlresults ='0';
							$medicationtable->reverse_returntostoresmedications($itemqty,$itemcode,$instcode);
							$stockadjustmenttable->revrse_stockadjustments($ajustcode,$instcode);
							$batchestable->reverse_newbatches($batchcode,$instcode);
						}										
					}else{
						$medicationtable->reverse_returntostoresmedications($itemqty,$itemcode,$instcode);
						$stockadjustmenttable->revrse_stockadjustments($ajustcode,$instcode);
						$batchestable->reverse_newbatches($batchcode,$instcode);
					}					
					$action = "Return to stores Medications";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9988;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}
			}
		break;
		
		// 2 DEC 2023,   JOSEPH ADORBOE  
		case 'singletransfermedicationstocks':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$itemnumber = htmlspecialchars(isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '');	
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');	
			$itemqty = htmlspecialchars(isset($_POST['itemqty']) ? $_POST['itemqty'] : '');	
			$unit = htmlspecialchars(isset($_POST['unit']) ? $_POST['unit'] : '');	
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');			
			$newprice = htmlspecialchars(isset($_POST['newprice']) ? $_POST['newprice'] : '');	
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');	
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');	
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');		
			$batchtotalqty = htmlspecialchars(isset($_POST['batchtotalqty']) ? $_POST['batchtotalqty'] : '');		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty) || empty($batchtotalqty) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{					
					if(!is_numeric($suppliedqty)){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($suppliedqty < 0 || $suppliedqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else if($suppliedqty>$storeqty){
						$status = "error";
						$msg = "Quantity in store NOT sufficent for this transfer ";
					}else{	
				//	$type = 2;	
					$adjustmentnumber = 'AD'.date('His').rand(10,99);
					$newstoreqty = $storeqty - $suppliedqty;
					$newtransferqty = $transferqty + $suppliedqty;
					$totalqty = $newstoreqty + $newtransferqty + $itemqty; 
					$stockvalue = $totalqty * $cashprice;               
					$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
				    $batchprocesscode = md5(microtime());
					$batchprocessnumber = rand(100,10000);
					$ajustcode = md5(microtime());

					$validatesuppliedqty = $engine->getnumbernonzerovalidation($suppliedqty);
					if ($validatesuppliedqty == '1') {
						$status = 'error';
						$msg = "Qty value is invalid";
						return '0';
					}else if($suppliedqty>$batchtotalqty){
						$status = 'error';
						$msg = "Batch Qty insufficent for transfer qty ";
					}else{

					// if ($expire < $day) {
					// 	$status = "error";
					// 	$msg = " Stock expiry date cannot be before $day  Unsuccessful";
					// } else {					
					// if($suppliedqty > $batchqty){
					// 	$status = "error";
					// 	$msg = " insufficent Qty";
					// }else{
						$description = 'Single Transfer Medication';
						$sqlresults = $medicationtable->transfermedications($suppliedqty,$itemcode,$instcode);	
						if($sqlresults =='2'){	
							$sqlresults  = $stockadjustmenttable->stockadjustmentstransfer($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newtransferqty,$storeqty,$unit,$batchprocesscode,$batchprocessnumber,$currentshift,$currentshiftcode,$expire,$type,$state=1,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);
							if($sqlresults =='2'){
								$bal =  $suppliedqty;
								$rem = 0;
								foreach($_POST["scheckbox"] as $key){
									$kt = explode('@@@',$key);
									$batchcode = $kt['0'];
									$batchnumber = $kt['1'];
									$batchqty = $kt['2'];
									$batchexpiry = $kt['3'];
								//	echo "<br />batch qty : {$batchqty}, batch balance:{$bal} , batch code:{$batchcode}  <br />";
									if($batchqty > $bal){
										$qty = $bal;
										$rem = 0;
										$state = 1;
									}else if($batchqty == $bal){
										$qty = $bal;
										$rem = 0;
										$state = 2;
									}
									else{
										$qty = $batchqty;
										$rem = $bal - $batchqty;
										$state = 2;
									}
								//	echo "<br />qty : {$qty}, rem : {$rem} <br />";	
									$sqlresults = $batchestable->transferbatchprocess($batchcode,$qty,$state,$instcode);	
									$bal= $rem;	
									if($bal == 0){
										break;	
									}								
								}															
						}					
						$action = "Transfer Medications from batch number $batchprocessnumber";									
						$result = $engine->getresults($sqlresults,$item,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9989;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
					}

					}
				}
				}
			}

		break;

		// 12 JAN 2021  JOSPH ADORBOE 
		case 'modifymedicationquantites':			
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');
			$pharmacyqty = htmlspecialchars(isset($_POST['pharmacyqty']) ? $_POST['pharmacyqty'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($cashprice) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					
					if(empty($storeqty))
					{
						$storeqty = 0;
					}
					if(empty($pharmacyqty))
					{
						$pharmacyqty = 0;
					}
					if(empty($transferqty))
					{
						$transferqty = 0;
					}

					$validatestoreqty = $engine->getnumbervalidation($storeqty);
					if ($validatestoreqty == '1') {
						$status = 'error';
						$msg = "Store quantity value is invalid";
						return '0';
					}

					$validatepharmacyqty = $engine->getnumbervalidation($pharmacyqty);
					if ($validatepharmacyqty  == '1') {
						$status = 'error';
						$msg = "Pharmacy quantity value is invalid";
						return '0';
					}

					$validatetransferqty = $engine->getnumbervalidation($transferqty);
					if ($validatetransferqty == '1') {
						$status = 'error';
						$msg = "Transfer quantity value is invalid";
						return '0';
					}

					$validatecashprice = $engine->getnumbernonzerovalidation($cashprice);
					if ($validatecashprice == '1') {
						$status = 'error';
						$msg = "Cash Price value is invalid";
						return '0';
					}
	
					$totalqty = $storeqty + $transferqty + $pharmacyqty;
					if($totalqty < '0'){
						$status = 'error';
						$msg = "Total store qty cannot be less than zero ";
						return '0';
					}
					$stockvalue = $totalqty*$cashprice;
					if($stockvalue < '0'){
						$status = 'error';
						$msg = "Stock value cannot be zero or less";
						return '0';
					}
					
					$sqlresults = $medicationtable->modifymedicationqty($ekey,$totalqty,$storeqty,$pharmacyqty,$transferqty,$stockvalue,$currentuser,$currentusercode, $instcode);					
					$action = "Modify Qty  Medications";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9990;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}			
			}	
		break;

		// 2 DEC 2023,   JOSEPH ADORBOE  
		case 'singlerestockmedicationstores':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$itemnumber = htmlspecialchars(isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '');	
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');	
			$itemqty = htmlspecialchars(isset($_POST['itemqty']) ? $_POST['itemqty'] : '');	
			$unit = htmlspecialchars(isset($_POST['unit']) ? $_POST['unit'] : '');			
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');			
			$newprice = htmlspecialchars(isset($_POST['newprice']) ? $_POST['newprice'] : '');
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');	
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');	
			$expire = htmlspecialchars(isset($_POST['expire']) ? $_POST['expire'] : '');
			$expiryday = htmlspecialchars(isset($_POST['expiryday']) ? $_POST['expiryday'] : '');
			$expirymonth = htmlspecialchars(isset($_POST['expirymonth']) ? $_POST['expirymonth'] : '');
			$expiryyear = htmlspecialchars(isset($_POST['expiryyear']) ? $_POST['expiryyear'] : '');
			$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
			$insuranceprice = htmlspecialchars(isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '');
			$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');
			$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');	
			$batchdescription = htmlspecialchars(isset($_POST['batchdescription']) ? $_POST['batchdescription'] : '');							
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty) || empty($costprice) || empty($newprice) || empty($expiryday) || empty($expirymonth) || empty($expiryyear) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					if(!is_numeric($suppliedqty) || !is_numeric($costprice) || !is_numeric($newprice)){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($suppliedqty < 0 || $suppliedqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else{	
						$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
						if ($validateqty == '1') {
							$status = 'error';
							$msg = "Qty value is invalid";
							return '0';
						}
						$validatecostprice = $engine->getnumbernonzerovalidation($costprice);
						if ($validatecostprice == '1') {
							$status = 'error';
							$msg = "Cost Price value is invalid";
							return '0';
						}
						$validatenewprice = $engine->getnumbernonzerovalidation($newprice);
						if ($validatenewprice == '1') {
							$status = 'error';
							$msg = "New Price value is invalid";
							return '0';
						}
						$validatedollarprice = $engine->getnumbervalidation($dollarprice);
						if ($validatedollarprice == '1') {
							$status = 'error';
							$msg = "Dollar Price value is invalid";
							return '0';
						}
						$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
						if ($validateinsuranceprice == '1') {
							$status = 'error';
							$msg = "Insurance Price value is invalid";
							return '0';
						}

				$type = 1;	
				$transferqty = 0;
				$adjustmentnumber = 'AD'.date('His').rand(10,99);
                $newqty = $storeqty + $suppliedqty;
				$totalqty = $newqty + $transferqty + $itemqty; 
				$stockvalue = $totalqty * $newprice;           

                $expirycode = md5(microtime());
				$ajustcode = md5(microtime());
				$cashpricecode = md5(microtime());
				$alternateprice = $partnerprice = $newprice;
				$expire = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
				
                if ($expire < $day) {
                    $status = "error";
                    $msg = " Stock expiry date cannot be before $day  Unsuccessful";
                } else {
					$batchnumber = 'BA'.date('His').rand(10,99);
					$batchcode = md5(microtime());	
					$description = 'Restock Medication';
					$cash = 'CASH';
					$one = '1';
					$batchcategory = '3';
					
					$sqlresults = $medicationtable->restockmedication($itemcode,$suppliedqty,$totalqty,$costprice,$newprice,$stockvalue,$partnerprice,$alternateprice,$dollarprice,$insuranceprice,$instcode);
					if($sqlresults == '2'){
						$adj = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$costprice,$newprice,$batchcode,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$type,$state=1,$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);
						$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item,$batchcategory,$costprice,$cashprice,$suppliedqty,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);
						$exp = $expirytable->newexpiry($expirycode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$expire,$batchcode,$batchnumber,$currentuser,$currentusercode,$instcode);
						$pri =  $pricingtable->setcashprices($itemcode,$item,$newprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);
						if($adj == '2' && $batch == '2' && $exp == '2' && $pri == '2'){
							$sqlresults = '2';
						}else{
							$sqlresults = '0';
							$medicationtable->reverse_restockmedication($itemcode,$suppliedqty,$newprice,$instcode);
							$stockadjustmenttable->revrse_stockadjustments($ajustcode,$instcode);
							$batchestable->reverse_newbatches($batchcode,$instcode);
							$expirytable->reverse_newexpiry($expirycode,$instcode);
							$pricingtable->revrse_setprice($itemcode,$instcode);
						}
					}
					$action = "Single Restock Medications with batch number $batchnumber";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9991;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}
			}
			}
		break;
		// 2 DEC 2023,.  JOSPH ADORBOE
		case 'enablemedicationssetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$sqlresults = $medicationtable->enablemedication($ekey,$days,$currentuser,$currentusercode,$instcode);;					
					if($sqlresults =='2'){	
						$pricingtable->enableitempriceing($ekey,$currentuser,$currentusercode,$instcode);												
					}	
					$action = "Enable Medications";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9992;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}	
		break;

		// 2 DEC 2023 JOSPH ADORBOE
		case 'disablemedicationsetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$disablereason = htmlspecialchars(isset($_POST['disablereason']) ? $_POST['disablereason'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($disablereason)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$sqlresults = $medicationtable->disablemedication($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode);					
					if($sqlresults =='2'){	
						$pricingtable->disableitempriceing($ekey,$currentuser,$currentusercode,$instcode);												
					}	
					$action = "Disable Medications";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9993;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	

				}
			}	
		break;

		// 2 DEC 2023, 13 MAY 2021 JOSPH ADORBOE
		case 'editmedication':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$dosageform = htmlspecialchars(isset($_POST['dosageform']) ? $_POST['dosageform'] : '');
			$unit = htmlspecialchars(isset($_POST['unit']) ? $_POST['unit'] : '');
			$restock = htmlspecialchars(isset($_POST['restock']) ? $_POST['restock'] : '');
			$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
			$medicationbrand = htmlspecialchars(isset($_POST['medicationbrand']) ? $_POST['medicationbrand'] : '');
			$medicationdose = htmlspecialchars(isset($_POST['medicationdose']) ? $_POST['medicationdose'] : '');
			$medicationnumber = htmlspecialchars(isset($_POST['medicationnumber']) ? $_POST['medicationnumber'] : '');
			$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($medication) || empty($dosageform) || empty($unit) || empty($restock)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{		
					$dose = explode('@@@', $dosageform);
					$dosageformcode = $dose[0];
					$dosageformname = $dose[1];						
					$unt = explode('@@@', $unit);
					$untcode = $unt[0];
					$untname = $unt[1];
					if(empty($medicationnumber)){
						$medicationnumber = rand(100,10000);
					}					
					$medication = strtoupper($medication);
					$medicationbrand = strtoupper($medicationbrand);
					$med = explode('-', $medication);
					$md = $med[0];					
					$medication = $md.' - '.$dosageformname.' - '.$medicationdose.' - '.$medicationbrand ; 
					$sqlresults = $medicationtable->editnewmedication($ekey,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$mnum,$medicationbrand,$medicationdose,$currentuser,$currentusercode,$instcode);
								
					if($sqlresults =='2'){	
						$sqlresults = $pricingtable->updatepricesitems($ekey,$medication,$instcode);
						$sqlresults = $planmedicationtable->updatemediactiuonname($ekey,$medication,$instcode);								
					}	
					$action = "Edit Medications";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9994;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}	

			}
	
		break;

		// 2 DEC 2023, 14 DEC 2022  JOSPH ADORBOE 
		case 'addnewmedications':			
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$dosageform = htmlspecialchars(isset($_POST['dosageform']) ? $_POST['dosageform'] : '');
			$unit = htmlspecialchars(isset($_POST['unit']) ? $_POST['unit'] : '');
			$restock = htmlspecialchars(isset($_POST['restock']) ? $_POST['restock'] : '');
			$brandname = htmlspecialchars(isset($_POST['brandname']) ? $_POST['brandname'] : '');
			$medicationdose = htmlspecialchars(isset($_POST['medicationdose']) ? $_POST['medicationdose'] : '');
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');
			$insuranceprice = htmlspecialchars(isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '');
			$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');
			$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
			$expire = htmlspecialchars(isset($_POST['expire']) ? $_POST['expire'] : '');
			$expiryday = htmlspecialchars(isset($_POST['expiryday']) ? $_POST['expiryday'] : '');
			$expirymonth = htmlspecialchars(isset($_POST['expirymonth']) ? $_POST['expirymonth'] : '');
			$expiryyear = htmlspecialchars(isset($_POST['expiryyear']) ? $_POST['expiryyear'] : '');
			$batchdescription = htmlspecialchars(isset($_POST['batchdescription']) ? $_POST['batchdescription'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($medication) || empty($dosageform) || empty($restock) || empty($brandname) || empty($medicationdose) || empty($storeqty) || empty($costprice) || empty($cashprice) || empty($expiryday) || empty($expirymonth) || empty($expiryyear) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{

					// if (empty($transferqty)) {
					// 	$transferqty = 0;
					// }
					if (empty($insuranceprice)) {
						$insuranceprice = 0;
					}
					if (empty($dollarprice)) {
						$dollarprice = 0;
					}
					// if (empty($alternateprice)) {
					// 	$alternateprice = 0;
					// }

					$validatestoreqty = $engine->getnumbernonzerovalidation($storeqty);
					if ($validatestoreqty == '1') {
						$status = 'error';
						$msg = "Store quantity value is invalid";
						return '0';
					}

					$validaterestock = $engine->getnumbernonzerovalidation($restock);
					if ($validaterestock == '1') {
						$status = 'error';
						$msg = "Restock quantity value is invalid";
						return '0';
					}

					// $validatetransferqty = $engine->getnumbervalidation($transferqty);
					// if ($validatetransferqty == '1') {
					// 	$status = 'error';
					// 	$msg = "Restock quantity value is invalid";
					// 	return '0';
					// }

					$validatecostprice = $engine->getnumbernonzerovalidation($costprice);
					if ($validatecostprice == '1') {
						$status = 'error';
						$msg = "Cost price value is invalid";
						return '0';
					}

					$validatecashprice = $engine->getnumbernonzerovalidation($cashprice);
					if ($validatecashprice == '1') {
						$status = 'error';
						$msg = "Cash Price value is invalid";
						return '0';
					}

					// $validatealtenate = $engine->getnumbervalidation($alternateprice);
					// if ($validatealtenate == '1') {
					// 	$status = 'error';
					// 	$msg = "Alternate Price Value is invalid";
					// 	return '0';
					// }

					$validatedollarprice = $engine->getnumbervalidation($dollarprice);
					if ($validatedollarprice == '1') {
						$status = 'error';
						$msg = "Doallar Prices value is invalid";
						return '0';
					}

					$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
					if ($validateinsuranceprice == '1') {
						$status = 'error';
						$msg = "Insurance Prices value is invalid";
						return '0';
					}

					// $validatepartnerprice = $engine->getnumbervalidation($partnerprice);
					// if ($validatepartnerprice == '1') {
					// 	$status = 'error';
					// 	$msg = "Partner Prices value is invalid";
					// 	return '0';
					// }

						$dose = explode('@@@', $dosageform);
						$dosageformcode = $dose[0];
						$dosageformname = $dose[1];

						$unt = explode('@@@', $unit);
						$untcode = $unt[0];
						$untname = $unt[1];
						$medicationnumber = rand(100,100000);
						$medication = strtoupper($medication);
						$brandname = strtoupper($brandname);
						$itemname = $medication = $medication.' - '.$dosageformname.' - '.$medicationdose.' - '.$brandname ;
						
						$cashpricecode = md5(microtime());	
						$category = 2;
						$cash = 'CASH';
					//	$storeqty = $storeqty - $transferqty;			
						$transferqty = $qty = 0;
						$partnerprice = $alternateprice = $cashprice;
						$totalqty = $storeqty + $transferqty;
						if($totalqty < '0' || $totalqty == '0'){
							$status = 'error';
							$msg = "Total store qty cannot be less than zero ";
							return '0';
						}
						$stockvalue = $totalqty*$cashprice;
						if($stockvalue < '0' || $stockvalue == '0'){
							$status = 'error';
							$msg = "Stock value cannot be zero or less";
							return '0';
						}
						$adjustmentnumber = 'AD'.date('His').rand(10,99);
						$ajustcode = md5(microtime());
						$expirycode = md5(microtime());
						$cashpricecode = md5(microtime());
						$batchnumber = 'BA'.date('His').rand(10,99);
						$batchcode = md5(microtime());	
						$description ='NEW MEDICATION';
						$itemcode=$form_key;
						$itemnumber=$medicationnumber;
						$item=$medication;
						$expire = $expiryyear.'-'.$expirymonth.'-'.$expiryday;

						$sqlresults = $medicationtable->addmedication($form_key,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$brandname,$medicationdose,$cashprice,$costprice,$partnerprice,$insuranceprice,$alternateprice,$dollarprice,$storeqty,$totalqty,$stockvalue,$currentuser,$currentusercode,$instcode);
									
						if($sqlresults =='2'){
							$ajustments = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item=$medication,$suppliedqty=$storeqty,$newqty=$storeqty,$storeqty,$untname,$costprice,$newprice=$cashprice,$batchcode,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$type=1,$state=1,$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);

							$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item=$medication,$batchcategory=3,$costprice,$cashprice,$suppliedqty=$storeqty,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);

							$exp = $expirytable->newexpiry($expirycode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item=$medication,$suppliedqty=$storeqty,$expire,$batchcode,$batchnumber,$currentuser,$currentusercode,$instcode);		

							if($ajustments == '2' && $batch == '2' && $exp == '2' ){
								$sqlresults ='2';
								$setcash = $pricingtable->setcashprices($itemcode,$medication,$cashprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);
								if($setcash == '2'){
									$sqlresults ='2';
									if($insuranceprice > '0'){						
										if (!empty($_POST["scheckbox"])) {
											foreach ($_POST["scheckbox"] as $schemes) {
												$pricecode = md5(microtime());	
												$req = explode('@@@', $schemes);
												$schemecode = $req['0'];
												$schemename = $req['1'];
												$insurancecode = $req['2'];
												$insurancename = $req['3'];                       
												$ins = $pricingtable->setinsuranceprices($pricecode,$category,$itemcode,$medication,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);;
											}  
										}
									}	
								}else{
									$sqlresults ='0';
									$medicationtable->reverse_addmedication($form_key,$instcode);
									$stockadjustmenttable->revrse_stockadjustments($ajustcode,$instcode);
									$batchestable->reverse_newbatches($batchcode,$instcode);
									$expirytable->reverse_newexpiry($expirycode,$instcode);
									$pricingtable->revrse_setprice($itemcode,$instcode);
								}											

							}else{
								$sqlresults ='0';
								$medicationtable->reverse_addmedication($form_key,$instcode);
								$stockadjustmenttable->revrse_stockadjustments($ajustcode,$instcode);
								$batchestable->reverse_newbatches($batchcode,$instcode);
								$expirytable->reverse_newexpiry($expirycode,$instcode);
								$pricingtable->revrse_setprice($itemcode,$instcode);
							}								
														
						}	
						$action = "Add medications";									
						$result = $engine->getresults($sqlresults,$item=$medication,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9995;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
			
			}
	
		break;	
		
	}

	function medicationstoremenu(){ ?>						
			<div class="btn-group mt-2 mb-2">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					Bulk Action <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a class="dropdown-item" href="managerestockmedications">Restock</a></li>
					<li><a class="dropdown-item" href="managetransfermedications">Transfer</a></li>
					<li><a class="dropdown-item" href="returntostoresmedication">Return to Stores</a></li>
					<li><a class="dropdown-item" href="returntosuppliermedication">Return to Supplier</a></li>					
				</ul>
			</div>
			<div class="btn-group mt-2 mb-2">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					Reports List<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#" data-toggle="modal" data-target="#largeModalstorerestockreports">Restock List</a></li>
					<li><a href="#" data-toggle="modal" data-target="#largeModaltransferreport">Transfer List</a></li>
					<li><a href="#" data-toggle="modal" data-target="#largeModalreturntostoresreport">Store Return list</a></li>
					<li><a href="#" data-toggle="modal" data-target="#largeModalreturntosuppliersreport">Supplier Return list</a></li>
				</ul>
			</div>
			<div class="btn-group mt-2 mb-2">
				<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
					Sub Menu <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="managegeneralstores">Medication Store</a></li>
					<li><a href="managestockdevices">Device Store</a></li>
					<li><a href="manageprocedureconsumableslist">Procedure Consumables Store</a></li>
					<li><a href="managernonmedicalstoreslist">General Items Store</a></li>					
				</ul>
			</div>	
	<?php }

?>