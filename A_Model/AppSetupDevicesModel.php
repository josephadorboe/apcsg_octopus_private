<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$setupdevicemodel = htmlspecialchars(isset($_POST['setupdevicemodel']) ? $_POST['setupdevicemodel'] : '');
	
	// 7 NOV 2023 JOSEPH ADORBOE 
	switch ($setupdevicemodel)
	{
	
		// 25 DEC 2023, JOSEPH ADORBOE  
		case 'approvebulkdevicesreturntosuppliers':
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
					$start = $devicesetuptable->returntosupplierdevicesbulk($addqty,$itemcode,$instcode);
					if($start == '2'){
						$med = $devicesetuptable->calculatedevicestockvalue($itemcode,$instcode);	
						$std = $stockadjustmenttable->approvebulkrestock($ajustcode,$instcode);	
						$bt = $batchestable->returntosupplierbatchnumberqty($batchnumber,$addqty,$instcode);							
						if($std == '2' && $bt == '2' && $med == '2'){
							$sqlresults = '2';
						}else{
							$sqlresults = '0';
						}					
					}							
					$action = "Approve return to supplier Device";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9912;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}

		break;

		// 25 DEC 2023, JOSEPH ADORBOE  
		case 'deletedevicesreturntosupplier':
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
					$action = "Delete Device Return to Supplier ";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9913;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}				
			}
		break;

		// 25 DEC 2023, 12 NOV 2023 JOSEPH ADORBOE  
		case 'editdevicesreturntosupplier':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$supplier = htmlspecialchars(isset($_POST['supplier']) ? $_POST['supplier'] : '');	
			$returnstockvalue = htmlspecialchars(isset($_POST['returnstockvalue']) ? $_POST['returnstockvalue'] : '');	
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');	
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$oldqty = htmlspecialchars(isset($_POST['oldqty']) ? $_POST['oldqty'] : '');	
			$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');				
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty) || empty($batch) || empty($supplier)){
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

						$bt = explode('@@', $batch);
						$batchcode = $bt['0'];
						$batchqty = $bt['1'];
						$batchnumber = $bt['2'];
						if ($suppliedqty > $batchqty) {
							$status = 'error';
							$msg = "Qty insufficent";
							return '0';
						}else{				
					$transferqty = 0;			
					$newqty = $oldqty + $suppliedqty;
			
					// batchnumber
					$sqlresults = $stockadjustmenttable->editreturntosupplier($ekey,$supplier,$returnstockvalue,$description,$suppliedqty,$batchcode,$batchnumber,$currentusercode,$currentuser,$instcode);						
					$action = "Edit Return to Supplier Devices";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9914;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
						}				
				
			}
			}
			}
		break;

		// 25 DEC 2023  JOSEPH ADORBOE  
		case 'bulkreturntosuppliermedicationstocks':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){													
				foreach($_POST["scheckbox"] as $key => $value){
					$suppliedqty = $_POST["suppliedqty"][$key];
					$supplier = $_POST["supplier"][$key];
					$suppliervalue = $_POST["suppliervalue"][$key];
					$description = $_POST["description"][$key];
					$kt = explode('@@@',$value);
					$itemcode = $kt['0'];
					$itemnumber = $kt['1'];
					$item = $kt['2'];
					$storeqty = $kt['3'];
					$totalqty = $kt['4'];
					$costprice = $kt['5'];
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
					$type = 18;	
					$adjustmentnumber = 'AD'.date('His').rand(10,99);
					$newstoreqty = $storeqty - $suppliedqty;
					$newtotalqty = $totalqty - $suppliedqty;
					$stockvalue = $newtotalqty * $cashprice;               
					$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
					$ajustcode = md5(microtime());

					$validatesuppliedqty = $engine->getnumbernonzerovalidation($suppliedqty);
					if ($validatesuppliedqty == '1') {
						$status = 'error';
						$msg = "Qty value is invalid";
						return '0';
					}

					$zero = '0';

					$sqlresults = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newstoreqty,$totalqty,$unit='NA',$costprice=$zero,$newprice=$zero,$batchcode=$zero,$batchnumber=$zero,$insuranceprice=$zero,$dollarprice=$zero,$currentshift,$currentshiftcode,$expire,$type,$state='0',$value=$suppliervalue,$supplier,$description,$currentuser,$currentusercode,$instcode);
					
					$action = "Bulk Return to Supplier Devices";									
					$result = $engine->getresults($sqlresults,$item,$action);									
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9915;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
				}
				}
				}
			}

		break;

		// 24 DEC 2023, 23 JULY 2023  JOSEPH ADORBOE  
		case 'approvebulkdevicesreturntostores':
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
					$costprice=$cashprice='0';
					$batchdescription = 'Automatic batch for return Device to stores';
					$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
					$batchcode = md5(microtime());
					$batchnumber = 'BA'.date('His').rand(10,99);
					$start = $devicesetuptable->returntostoresdevices($addqty,$itemcode,$instcode);
					if($start == '2'){	
						$std = $stockadjustmenttable->approvebulkrestock($ajustcode,$instcode);	
						$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item=$medication,$batchcategory=2,$costprice,$cashprice,$suppliedqty=$addqty,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);
					//	$bt = $batchestable->increasebatchqty($batchcode,$addqty,$instcode);	
						if($std == '2' && $batch == '2'){
							$sqlresults = '2';
						}else{
							$sqlresults = '0';
						}					
					}							
					$action = "Approve return to stores Devices";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9916;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}

		break;

		// 24 DEC 2023, JOSEPH ADORBOE  
		case 'deletedevicesreturntostores':
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
					$eventcode=9917;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}				
			}
		break;
	
		// 24 DEC 2023, 12 NOV 2023 JOSEPH ADORBOE  
		case 'editdevicesreturntostores':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$oldqty = htmlspecialchars(isset($_POST['oldqty']) ? $_POST['oldqty'] : '');	
			$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');	
			$batchcode = htmlspecialchars(isset($_POST['batchcode']) ? $_POST['batchcode'] : '');				
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty) ){
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

						// $bt = explode('@@', $batch);
						// $batchcode = $bt['0'];
						// $batchqty = $bt['1'];
						// $batchnumber = $bt['2'];
						// if ($suppliedqty > $batchqty) {
						// 	$status = 'error';
						// 	$msg = "Qty insufficent";
						// 	return '0';
						// }else{				
					$transferqty = 0;			
					$newqty = $oldqty + $suppliedqty;
			
					// batchnumber
					$sqlresults = $stockadjustmenttable->edittransfer($ekey,$suppliedqty,$batchcode,$batchnumber,$currentusercode,$currentuser,$instcode);					
					$action = "Edit Return to stores Devices";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9918;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
			//	}				
			}
			}
			}
		break;
		// 24 DEC 2023, JOSEPH ADORBOE  
		case 'bulkreturntostoredevicesstocks':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){													
				foreach($_POST["scheckbox"] as $key => $value){
					$suppliedqty = $_POST["suppliedqty"][$key];
					$kt = explode('@@@',$value);
					$itemcode = $kt['0'];
					$itemnumber = $kt['1'];
					$item = $kt['2'];
					$storeqty = $kt['3'];
					$itemqty = $kt['4'];
					$transferqty = $kt['5'];
					$cashprice = $kt['6'];
					$totalqty = $kt['7'];
				if(!empty($suppliedqty) ){					
					if(!is_numeric($suppliedqty)){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($suppliedqty < 0 || $suppliedqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else if($suppliedqty>$itemqty){
						$status = "error";
						$msg = "Quantity in store NOT sufficent for this transfer ";
					}else{	
					$type = 6;	
					$adjustmentnumber = 'AD'.date('His').rand(10,99);
					$newstoreqty = $storeqty + $suppliedqty;
					$newpharmacyqty = $itemqty - $suppliedqty;
					$totalqty = $newstoreqty + $transferqty + $newpharmacyqty; 
					$stockvalue = $totalqty * $cashprice;               
					$expire = date('Y-m-d', strtotime($day. '+ 3 months'));				
					$ajustcode = md5(microtime());
					$validatesuppliedqty = $engine->getnumbernonzerovalidation($suppliedqty);
					if ($validatesuppliedqty == '1') {
						$status = 'error';
						$msg = "Qty value is invalid";
						return '0';
					}
					$description = 'Return to stores Devices';
					$zero = '0';

					$sqlresults = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newpharmacyqty,$newstoreqty,$unit='NA',$costprice=$zero,$newprice=$zero,$batchcode=$zero,$batchnumber=$zero,$insuranceprice=$zero,$dollarprice=$zero,$currentshift,$currentshiftcode,$expire,$type,$state='0',$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);
					
					$action = "Bulk Return to stores Devices";									
					$result = $engine->getresults($sqlresults,$item,$action);									
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9919;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
				}
				}
				}
			}
		break;

		// 24 DEC 2023,   JOSEPH ADORBOE  
		case 'approvebulkdevicestransfer':
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
					$start = $devicesetuptable->transferdevices($addqty,$itemcode,$instcode);
					if($start == '2'){	
						$std = $stockadjustmenttable->approvebulkrestock($ajustcode,$instcode);	
						$bt = $batchestable->transferbulkbatchprocess($itemcode,$qty=$addqty,$instcode);
					//	$bt = $batchestable->reducebatchqty($batchcode,$addqty,$instcode);	
						if($std == '2' && $bt == '2'){
							$sqlresults = '2';
						}else{
							$sqlresults = '0';
						}					
					}							
					$action = "Approve transfer Devices";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9920;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}
		break;
		// 24 DEC 2023 JOSEPH ADORBOE  
		case 'deletedevicestransfer':
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
					$action = "Delete Devices Transfer";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9921;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}				
			}
		break;
		// 24 DEC 2023, JOSEPH ADORBOE  
		case 'editdevicestransfer':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$oldqty = htmlspecialchars(isset($_POST['oldqty']) ? $_POST['oldqty'] : '');	
			$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$batchcode = htmlspecialchars(isset($_POST['batchcode']) ? $_POST['batchcode'] : '');		
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');				
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					if(!is_numeric($suppliedqty) ){
						$status = "error";
						$msg = "Quantity MUST be a Number Only ";
					}else if($suppliedqty < 0 || $suppliedqty == 0){
						$status = "error";
						$msg = "Quantity cannot be zero or less ";
					}else if($suppliedqty>$oldqty){
						$status = "error";
						$msg = "Quantity in store NOT sufficent for this transfer ";
					}else{	
						$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
						if ($validateqty == '1') {
							$status = 'error';
							$msg = "Qty value is invalid";
							return '0';
						}

						// $bt = explode('@@', $batch);
						// $batchcode = $bt['0'];
						// $batchqty = $bt['1'];
						// $batchnumber = $bt['2'];
						// if ($suppliedqty > $batchqty) {
						// 	$status = 'error';
						// 	$msg = "Qty insufficent";
						// 	return '0';
						// }else{	

					$transferqty = 0;			
					$newqty = $oldqty + $suppliedqty;
			
					// batchnumber
					$sqlresults = $stockadjustmenttable->edittransfer($ekey,$suppliedqty,$batchcode,$batchnumber,$currentusercode,$currentuser,$instcode);;						
					$action = "Edit Transfer Devices";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9922;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					}
				}
			}
		break;

		// 24 DEC 2023  JOSEPH ADORBOE  
		case 'bulktransferdevicesstocks':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){																	
				foreach($_POST["scheckbox"] as $key => $value){
					$suppliedqty = $_POST["suppliedqty"][$key];
					$kt = explode('@@@',$value);
					$itemcode = $kt['0'];
					$itemnumber = $kt['1'];
					$item = $kt['2'];
					$storeqty = $kt['3'];
					$itemqty = $kt['4'];
					$transferqty = $kt['5'];
					$cashprice = $kt['6'];
					$totalqty = $kt['7'];

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
					$type = 5;	
					$adjustmentnumber = 'AD'.date('His').rand(10,99);
					$newstoreqty = $storeqty - $suppliedqty;
					$newtransferqty = $transferqty + $suppliedqty;
				//	$totalqty = $newstoreqty + $newtransferqty + $itemqty; 
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

					$description = 'Transfer Devices';
					$zero = '0';
					$batchprocesscode = md5(microtime());
					$batchprocessnumber = rand(100,10000);
					$batchtotalqty = $batchestable->gettotalbatchqty($days,$itemcode,$itemname=$item,$category=2,$qty=$storeqty,$expire,$stockvalue,$cashprice,$cashprice,$currentuser,$currentusercode,$instcode);
					$sqlresults = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newtransferqty,$storeqty,$unit='NA',$costprice=$zero,$newprice=$zero,$batchcode=$batchprocesscode,$batchnumber=$batchprocessnumber,$insurancepric=$zero,$dollarprice=$zero,$currentshift,$currentshiftcode,$expire,$type,$state='0',$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);
					
					$action = "Bulk tansfer Devices";									
					$result = $engine->getresults($sqlresults,$item,$action);									
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9923;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
				}
				}
				}
			}
		break;

		// 24 DEC 2023  JOSEPH ADORBOE  
		case 'approvebulkdevicesrestock':
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
					$start = $devicesetuptable->updatedevicesapprove($itemcode,$addqty,$costprice,$cashprice,$partnerprice,$dollarprice,$insuranceprice,$instcode);
					if($start == '2'){	
						$med = $devicesetuptable->calculatedevicestockvalue($itemcode,$instcode);
						$std = $stockadjustmenttable->approvebulkrestock($ajustcode,$instcode);	
						$bat = $batchestable->approvebatch($batchcode,$instcode);
						$cp = $pricingtable->setcashprices($itemcode,$item=$medication,$cashprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);	
						if($med == '2' && $std == '2' && $cp == '2'){
							$sqlresults = '2';
						}else{
							$sqlresults = '0';
						}					
					}							
					$action = "Approve Restock Device";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9924;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}
		break;

		// 23 DEC 2023, JOSEPH ADORBOE  
		case 'deletedevicesrestocking':
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
					$action = "Delete Restock Devices";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9925;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}				
			}
		break;
		// 23 DEC 2023,  JOSEPH ADORBOE  
		case 'editdevicesrestocking':
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
				if(empty($ekey) || empty($suppliedqty) || empty($costprice) || empty($cashprice) ){
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

				$type = 4;	
				$transferqty = 0;			
                $newqty = $oldqty + $suppliedqty;

				$xp = explode("-",$expiry);
				$fday = $xp[0];
				$fmonth = $xp[1];
				$fyear = $xp[2];
				$expiry = $fyear.'-'.$fmonth.'-'.$fday;
			
                if ($expiry < $day) {
                    $status = "error";
                    $msg = " Stock expiry date cannot be before $day Unsuccessful";
                } else {
					// batchnumber
					$sqlresults  = $stockadjustmenttable->editstockadjustment($ekey,$suppliedqty,$costprice,$cashprice,$insuranceprice,$dollarprice,$expiry,$currentuser,$currentusercode,$instcode);
					// $stockadjustmenttable->editstockadjustmentpending($ekey,$suppliedqty,$costprice,$cashprice,$insuranceprice,$dollarprice,$instcode);
					if($sqlresults == '2'){			
						$bat = $batchestable->editbatchpending($batchcode,$suppliedqty,$expiry,$suppliedqty,$currentusercode,$currentuser,$instcode);
						$exp = $expirytable->editexpiry($batchcode,$suppliedqty,$expiry,$currentuser,$currentusercode,$instcode);					
						if($exp == '2' && $bat == '2'){
							$sqlresults = '2';
						}else{
							$sqlresults = '0';
						}						
					}										
					$action = "Edit Restock Devices";									
					$result = $engine->getresults($sqlresults,$item=$medication.' Batch NO: '.$batchnumber,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9926;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}
			}
			}
		break;

		// 23 DEC 2023, 16 MAY 2023  JOSEPH ADORBOE  
		case 'bulkrestockdevicesstores':										
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
						$costprices = $kt['5'];
						$cashprice = $kt['6'];

						$xp = explode("-",$expire);
						$fday = $xp[0];
						$fmonth = $xp[1];
						$fyear = $xp[2];
						$expire = $fyear.'-'.$fmonth.'-'.$fday;
						
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
								
								$type = 4;	
								$transferqty = 0;
								$adjustmentnumber = 'AD'.date('His').rand(100,100000);
								$newqty = $storeqty + $suppliedqty;
								$totalqty = $newqty + $transferqty + $itemqty; 
								$stockvalue = $totalqty * $newprice;
								$expirycode = md5(microtime());
								$ajustcode = md5(microtime());
								$cashpricecode = md5(microtime());
								$alternateprice = $partnerprice = $newprice;
								$batchcategory = 2;
								
								if ($expire < $day) {
									$status = "error";
									$msg = " Stock expiry date cannot be before $day  Unsuccessful";
								} else {
									$batchnumber = 'BA'.date('His').rand(10,99);
									$batchcode = md5(microtime());	
									$description = 'Restock Devices ';

									$sqlresults = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit='NA',$costprice,$newprice,$batchcode,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$type,$state='0',$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);
									
									if($sqlresults == '2'){
										$batch = $batchestable->newbatchespending($batchcode,$batchnumber,$days,$itemcode,$item,$batchcategory,$costprice,$cashprice,$suppliedqty,$batchdescription = "BULK RESTOCK",$expire,$currentuser,$currentusercode,$instcode);
										
									//	$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item,$batchcategory,$costprice,$cashprice=$newprice,$suppliedqty,$currentuser,$currentusercode,$instcode);
										$exp = $expirytable->newexpiry($expirycode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$expire,$batchcode,$batchnumber,$currentuser,$currentusercode,$instcode);									
									}
									$action = "Bulk Restock Device with batch Number: $batchnumber";									
									$result = $engine->getresults($sqlresults,$item,$action);									
									$re = explode(',', $result);
									$status = $re[0];					
									$msg = $re[1];
									$event= "$action: $form_key $msg";
									$eventcode=9927;
									$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);													
							
								}						
								
							}
						}
					}
				}
			}
		break;

		// 22 DEC 2023,  JOSEPH ADORBOE  
		case 'createbatchdevice':
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
					
					$sqlresults = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$medication,$category,$costprice,$cashprice,$batchqty,$currentuser,$currentusercode,$instcode);						
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

		// 22 DEC 2023 JOSPH ADORBOE 
		case 'modifydevicesquantites':			
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
						
						$sqlresults = $devicesetuptable->modifymedicationqty($ekey, $totalqty, $storeqty, $pharmacyqty, $transferqty, $stockvalue,$currentuser, $currentusercode, $instcode);					
						$action = "Modify Qty  Devices";									
						$result = $engine->getresults($sqlresults,$item=$medication,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9928;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
					
					}		
			}
	
		break;

		// 22 DEC 2023,   JOSEPH ADORBOE  
		case 'returntosuppliersdevices':
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
		//	$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');	
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$supplier = htmlspecialchars(isset($_POST['supplier']) ? $_POST['supplier'] : '');
			$returnstockvalue = htmlspecialchars(isset($_POST['returnstockvalue']) ? $_POST['returnstockvalue'] : '');	
			$batchtotalqty = htmlspecialchars(isset($_POST['batchtotalqty']) ? $_POST['batchtotalqty'] : '');			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($returnqty) || empty($description) || empty($supplier) || empty($returnstockvalue)){
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
					$batchcode = md5(microtime());
					$batchnumber = 'BA'.date("His").rand(10,99);
					// $bt = explode('@@', $batch);
					// $batchcode = $bt['0'];
					// $batchqty = $bt['1'];
					// $batchnumber = $bt['2'];

					if ($expire < $day) {
						$status = "error";
						$msg = " Stock expiry date cannot be before $day  Unsuccessful";
					}else if($returnqty>$batchtotalqty){
						$status = "error";
						$msg = " Insufficent batch qty to return ";
					} else {
						$sqlresults = $devicesetuptable->returntosupplierdevices($returnqty,$newtotalqty,$itemcode,$stockvalue,$instcode);	
						if($sqlresults =='2'){	
							$trans  = $stockadjustmenttable->stockadjustmentsreturn($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty=$returnqty,$newqty,$storeqty,$unit,$batchcode,$batchnumber,$currentshift,$currentshiftcode,	$expire,$type,$state=1,$supplier,$description,$value=$returnstockvalue,$currentuser,$currentusercode,$instcode);
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
									$devicesetuptable->calculatedevicestockvalue($itemcode,$instcode);
									$bal= $rem;	
									if($bal == 0){
										break;	
									}								
								}		 
							//	$batch = $batchestable->returntosupplierbatchnumberqty($batchnumber,$returnqty,$instcode);
						
							
						}					
						$action = "Return to Supplier Devices";									
						$result = $engine->getresults($sqlresults,$item,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9930;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
					}
				}
				}
			}

		break;

		// 22 DEC 2023,   JOSEPH ADORBOE  
		case 'returnfromstoresdevices':
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
				if(empty($ekey) || empty($suppliedqty)){
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
					// $bt = explode('@@', $batch);
					// $batchcode = $bt['0'];
					// $batchqty = $bt['1'];
					// $batchnumber = $bt['2'];
					$batchcode = md5(microtime());
					$batchnumber = 'BA'.date('His').rand(10,99);

					if ($expire < $day) {
						$status = "error";
						$msg = " Stock expiry date cannot be before $day  Unsuccessful";
					} else {
						$sqlresults = $devicesetuptable->returntostoresdevices($suppliedqty,$itemcode,$instcode);	
						if($sqlresults =='2'){
							$description = "Return to stores Devices";	
							$trans  = $stockadjustmenttable->stockadjustmentsreturn($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty=$totalqty,$storeqty=$newstoreqty,$unit,$batchcode,$batchnumber,$currentshift,$currentshiftcode,$expire,$type,$state=1,$supplier='NA',$description,$value='0',$currentuser,$currentusercode,$instcode);							
							$batch = $batchestable->addnewbatches($batchcode,$batchnumber,$days,$itemcode,$itemname=$item,$category=2,$qtysupplied=$suppliedqty,$qtyleft=$suppliedqty,$description,$expire,$currentuser,$currentusercode,$instcode);							
							//	$batch = $batchestable->returntostoresreducebatchnumberqty($batchnumber,$suppliedqty,$instcode);											
						}					
						$action = "Return to stores Devices";									
						$result = $engine->getresults($sqlresults,$item,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9931;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					}
				}
				}
			}

		break;

		// 22 DEC 2023,   JOSEPH ADORBOE  
		case 'singletransferdevice':
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
			$batchtotalqty = htmlspecialchars(isset($_POST['batchtotalqty']) ? $_POST['batchtotalqty'] : '');		
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
				//  $expirycode = md5(microtime());
					$ajustcode = md5(microtime());

					$validatesuppliedqty = $engine->getnumbernonzerovalidation($suppliedqty);
					if ($validatesuppliedqty == '1') {
						$status = 'error';
						$msg = "Qty value is invalid";
						return '0';
					}

					if ($expire < $day) {
						$status = "error";
						$msg = " Stock expiry date cannot be before $day  Unsuccessful";
					} else {

					// $bt = explode('@@', $batch);
					// $batchcode = $bt['0'];
					// $batchqty = $bt['1'];
					// $batchnumber = $bt['2'];

					if($suppliedqty > $batchtotalqty){
						$status = "error";
						$msg = " insufficent Qty";
					}else{
						$description = 'Single Transfer Device';
						$sqlresults = $devicesetuptable->transferdevices($suppliedqty,$itemcode,$instcode);	
						if($sqlresults =='2'){	
							$sqlresults = $stockadjustmenttable->stockadjustmentstransfer($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newtransferqty,$storeqty,$unit,$batchprocesscode,$batchprocessnumber,$currentshift,$currentshiftcode,$expire,$type,$state=1,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);
						//	$batch = $batchestable->reducebatchqty($batchcode,$suppliedqty,$instcode);
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
						}					
						$action = "Transfer Devices from batch number $batchnumber";									
						$result = $engine->getresults($sqlresults,$item,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9932;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					

					}

					}
				}
				}
			}

		break;

		// 20 DEC 2023,   JOSEPH ADORBOE  
		case 'singlerestockstoresdevices':
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
			$batchdescription = htmlspecialchars(isset($_POST['batchdescription']) ? $_POST['batchdescription'] : '');
			$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
			$insuranceprice = htmlspecialchars(isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '');
			$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');
			$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');							
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty) || empty($costprice) || empty($newprice) ){
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

			
				$adjustmentnumber = 'AD'.date('His').rand(10,99);
                $newqty = $storeqty + $suppliedqty;
				$totalqty = $newqty + $transferqty + $itemqty; 
				$stockvalue = $totalqty * $newprice;           

			    $expirycode = md5(microtime());
				$ajustcode = md5(microtime());
				$cashpricecode = md5(microtime());
				$alternateprice = $partnerprice = $newprice;

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
					$description = 'Restock Devices';
					$cash = 'CASH';
					$one = 1;
					$batchcategory =2;					

					$sqlresults = $devicesetuptable->restockdevices($itemcode,$suppliedqty,$totalqty,$costprice,$newprice,$stockvalue,$partnerprice,$alternateprice,$dollarprice,$insuranceprice,$instcode);
					if($sqlresults == '2'){
						$adj = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$costprice,$newprice,$batchcode,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$type,$state=1,$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);

						$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item,$batchcategory,$costprice,$cashprice,$suppliedqty,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);

						$exp = $expirytable->newexpiry($expirycode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$expire,$batchcode,$batchnumber,$currentuser,$currentusercode,$instcode);

						$pri =  $pricingtable->setcashprices($itemcode,$item,$newprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);

						if($adj == '2' && $batch == '2' && $exp == '2' && $pri == '2'){
							$sqlresults = '2';
						}else{
							$sqlresults = '0';
						}
					}

					$action = "Single Restock Device with batch number $batchnumber";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9933;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}
			}
			}
		break;
		// 20 DEC 2023 , JOSEPH ADORBOE 
		case 'addnewdevices':			
			$devices = htmlspecialchars(isset($_POST['devices']) ? $_POST['devices'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$restock = htmlspecialchars(isset($_POST['restock']) ? $_POST['restock'] : '');
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');
			$insuranceprice = htmlspecialchars(isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '');
			$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$expire = htmlspecialchars(isset($_POST['expire']) ? $_POST['expire'] : '');
			$batchdescription = htmlspecialchars(isset($_POST['batchdescription']) ? $_POST['batchdescription'] : '');
			$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
			$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($devices) || empty($storeqty) || empty($costprice) || empty($cashprice) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$devicenumber = rand(100,10000);
					$devices = strtoupper($devices);					
					
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

					// $validatetransferqty = $engine->getnumbernonzerovalidation($transferqty);
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
						$msg = "Dollar Prices value is invalid";
						return '0';
					}

					// $validatepartnerprice = $engine->getnumbervalidation($partnerprice);
					// if ($validatepartnerprice == '1') {
					// 	$status = 'error';
					// 	$msg = "Partner Prices value is invalid";
					// 	return '0';
					// }

					$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
					if ($validateinsuranceprice == '1') {
						$status = 'error';
						$msg = "Insurance Prices value is invalid";
						return '0';
					}
					$transferqty = 0;
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
					$itemcode = md5(microtime());
					$ajustcode = md5(microtime());				
                	$expirycode = md5(microtime());	
					$cashpricecode = md5(microtime());
					$adnumber = rand(10,100);
					$batchnumber = 'BA'.date('His').rand(10,99);
					$batchcode = md5(microtime());	
					$description ='NEW DEVICES';	
					$cash = 'CASH';

					$xp = explode("-",$expire);
					$fday = $xp[0];
					$fmonth = $xp[1];
					$fyear = $xp[2];
					$expire = $fyear.'-'.$fmonth.'-'.$fday;

					$sqlresults = $devicesetuptable->adddevices($itemcode,$devices,$devicenumber,$restock,$days,$description,$cashprice,$costprice,$partnerprice,$insuranceprice,$alternateprice,$dollarprice,$storeqty,$totalqty,$stockvalue,$currentuser,$currentusercode,$instcode);
				
						if($sqlresults =='2'){	
							$pe = $pricingtable->setcashprices($itemcode,$devices,$cashprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);
							$sj = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber=$devicenumber,$item=$devices,$suppliedqty=$storeqty,$newqty=$storeqty,$storeqty,$unit='NA',$costprice,$newprice=$cashprice,$batchcode,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$type=4,$state=1,$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);
							$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item=$devices,$batchcategory=2,$costprice,$cashprice,$suppliedqty=$storeqty,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);								
							$exp = $expirytable->newexpiry($expirycode,$adjustmentnumber,$days,$itemcode,$itemnumber=$devicenumber,$item=$devices,$suppliedqty=$storeqty,$expire,$batchcode,$batchnumber,$currentuser,$currentusercode,$instcode);									
							if($insuranceprice > '0'){						
								if (!empty($_POST["scheckbox"])) {
									foreach ($_POST["scheckbox"] as $schemes) {
										$pricecode = md5(microtime());	
										$req = explode('@@@', $schemes);
										$schemecode = $req['0'];
										$schemename = $req['1'];
										$insurancecode = $req['2'];
										$insurancename = $req['3'];                       
										$ins = $pricingtable->setinsuranceprices($pricecode,$category,$itemcode,$devices,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);;
									}  
								}
							}											
						}	
						$action = "Add Devices";									
						$result = $engine->getresults($sqlresults,$item=$devices,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9996;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
					}
			}
	
		break;


		// 20 DEC 2023, JOSPH ADORBOE
		case 'editdevicessetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$devices = htmlspecialchars(isset($_POST['devices']) ? $_POST['devices'] : '');	
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$devicenumber = htmlspecialchars(isset($_POST['devicenumber']) ? $_POST['devicenumber'] : '');
			$restock = htmlspecialchars(isset($_POST['restock']) ? $_POST['restock'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($devices) || empty($description) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					if(empty($devicenumber)){
						$devicenumber = rand(100,10000);
					}					
					$devices = strtoupper($devices);					
					$sqlresults = $devicesetuptable->editdevice($ekey,$devices,$description,$currentuser,$currentusercode,$instcode);
								
					if($sqlresults =='2'){	
						$pricingtable->updatepricesitems($ekey,$devices,$instcode);													
					}	
					$action = "Edit Devices";									
					$result = $engine->getresults($sqlresults,$item=$devices,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9997;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}	
		break;

		// 20 DEC 2023, JOSPH ADORBOE
		case 'enabledevicessetup':
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
					$sqlresults = $devicesetuptable->enabledevices($ekey,$days,$currentuser,$currentusercode,$instcode);					
					if($sqlresults =='2'){	
						$pricingtable->enableitempriceing($ekey,$currentuser,$currentusercode,$instcode);												
					}	
					$action = "Enable Devices";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9998;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}	
		break;

		// 19 DEC 2023, 25 DEC 2022  JOSPH ADORBOE
		case 'disabledevicesetup':
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
					$sqlresults = $devicesetuptable->disabledevices($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode);					
					if($sqlresults =='2'){	
						$pricingtable->disableitempriceing($ekey,$currentuser,$currentusercode,$instcode);												
					}	
					$action = "Disable Devices";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9999;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}
			}	
		break;

		// 7 NOv 2023, 28 Sept 2023, 20 DEC 2022  JOSEPH ADORBOE 
		case 'addnewdevices':			
			$devices = htmlspecialchars(isset($_POST['devices']) ? $_POST['devices'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$restock = htmlspecialchars(isset($_POST['restock']) ? $_POST['restock'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($devices) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$devicenumber = date('his');
					$devices = strtoupper($devices);					
					$sqlresults =$devicesetuptable->newdevices($form_key,$devices,$devicenumber,$restock,$days,$description,$currentuser,$currentusercode,$instcode);
					$action = "Add Devices";
					$result = $engine->getresults($sqlresults,$item=$devices,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=10000;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}	
		break;		
			
	}
	function devicestoremenu(){ ?>
	<div class="btn-group mt-2 mb-2">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					Bulk Action <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a class="dropdown-item" href="managerestockdevices">Restock</a></li>
					<li><a class="dropdown-item" href="managetransferdevices">Transfer</a></li>
					<li><a class="dropdown-item" href="returntostoresdevices">Return to Stores</a></li>
					<li><a class="dropdown-item" href="returntosupplierdevices">Return to Supplier</a></li>					
				</ul>
			</div>
			<div class="btn-group mt-2 mb-2">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					Reports List<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#" data-toggle="modal" data-target="#largeModalstorerestockreports">Restock List</a></li>
					<li><a href="#" data-toggle="modal" data-target="#largeModaltransferreport">Transfer List</a></li>
					<li><a href="#" data-toggle="modal" data-target="#largeModalreturntostoresdevices">Store Return list</a></li>
					<li><a href="#" data-toggle="modal" data-target="#largeModalreturntosuppliersdevices">Supplier Return list</a></li>
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
	<?php 
	}
?>
