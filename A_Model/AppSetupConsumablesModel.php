<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$consumablesmodel = htmlspecialchars(isset($_POST['consumablesmodel']) ? $_POST['consumablesmodel'] : '');
	$dept = 'OPD';
	Global $instcode;
	
	// 6 AUG 2023 JOSEPH ADORBOE  returnconsumablestosupplier deleteconsumabletransfer
	switch ($consumablesmodel)
	{


		// 22 NOV 2023, 31 OCT 2022 JOSEPH ADORBOE 
		case 'removeprocedureconsumables':		
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
			$consumablename = isset($_POST['consumablename']) ? $_POST['consumablename'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($ekey)){   
						$status = "error";
						$msg = "Required Fields cannot be empty";	 
					}else{					
						$sqlresults = $procedureconsumabletable->removeprocedureconsumable($ekey,$days,$currentusercode,$currentuser,$instcode);							
						$action = "Remove Procedure consumable";									
						$result = $engine->getresults($sqlresults,$item=$consumablename,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9880;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);															
												
						}			
					}
			
				}
		break;
		
		// 22 NOV 2023 JOSEPH ADORBOE 
		case 'editprocedureconsumables':		
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
			$consumablename = isset($_POST['consumablename']) ? $_POST['consumablename'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($ekey) || empty($qty)){   
						$status = "error";
						$msg = "Required Fields cannot be empty";	 
					}else{							
						$sqlresults = $procedureconsumabletable->editprocedureconsumable($ekey,$qty,$days,$currentusercode,$currentuser,$instcode);							
						$action = "Edit Procedure consumable";									
						$result = $engine->getresults($sqlresults,$item=$consumablename,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9881;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);							
														
						}			
					}			
				}
		break;
		
		// 22 NOV 2023  JOSEPH ADORBOE 
		case 'addprocedureconsumables':		
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$procedurecode = isset($_POST['procedurecode']) ? $_POST['procedurecode'] : '';
			$procedurename = isset($_POST['procedurename']) ? $_POST['procedurename'] : '';
			$consumable = isset($_POST['consumable']) ? $_POST['consumable'] : '';
			$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($consumable) || empty($qty)){   
						$status = "error";
						$msg = "Required Fields cannot be empty";	 
					}else{	
						
						foreach ($consumable as $key) {						
							$med = explode('@@@', $key);
							$consumablecode = $med[0];
							$consumablename = $med[1];
							$formkey = md5(microtime());														
							$sqlresults = $procedureconsumabletable->newprocedureconsumabletouse($formkey,$procedurecode,$procedurename,$consumablecode,$consumablename,$qty,$days,$currentusercode,$currentuser,$instcode);							
							$action = "Add Procedure consumable";									
							$result = $engine->getresults($sqlresults,$item=$procedurename,$action);
							$re = explode(',', $result);
							$status = $re[0];					
							$msg = $re[1];
							$event= "$action: $form_key $msg";
							$eventcode=9882;
							$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
																			
							}			
						}			
					}
			
				}
		break;
		// 19 NOV 2023,   JOSEPH ADORBOE  
		case 'approvebulkconsumablereturntosupplier':
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
					$batchnumber = $kt['4'];

					$sqlresults = $consumablesetuptable->returnconsumabletosup($addqty,$itemcode,$instcode); 					
					if($sqlresults =='2'){		
						$stockadjustmenttable->approvebulkrestock($ajustcode,$instcode);
						$batchestable->returntostoresreducebatchnumberqty($batchnumber,$addqty,$instcode);
						$consumablesetuptable->calculatestockvalue($itemcode,$instcode);
					}
					$action = "Approve Transfer consumable";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9883;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);			
				}
			}

		break;
		// 12 NOV 2023  JOSEPH ADORBOE  
		case 'deleteconsumablereturntosuppliers':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					$sqlresults = $stockadjustmenttable->deletependingstockajustment($ekey,$currentusercode,$currentuser,$instcode);						
					$action = "Delete Return to suppier consumable";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9884;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}				
			}
		break;

		// 12 NOV 2023 JOSEPH ADORBOE  
		case 'editconsumablereturntosupplier':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$oldqty = htmlspecialchars(isset($_POST['oldqty']) ? $_POST['oldqty'] : '');	
			$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');				
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty) || empty($batch)){
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
					$sqlresults = $stockadjustmenttable->edittransfer($ekey,$suppliedqty,$batchcode,$batchnumber,$currentusercode,$currentuser,$instcode);;						
					$action = "Edit Return to supplier consumable";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9885;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
						}				
				
			}
			}
			}
		break;

		// 18 NOV 2023  JOSEPH ADORBOE  
		case 'bulkconsumablereturntosupplier':										
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
						$unit = $kt['5'];
						$cashprice = $kt['6'];
					//	$cashprice = $kt['6'];
						
					if(!empty($suppliedqty) && !empty($supplier) && !empty($suppliervalue) && !empty($description) ){	

							if(!is_numeric($suppliedqty)){
								$status = "error";
								$msg = "Quantity MUST be a Number Only ";
							}else if($suppliedqty < 0 || $suppliedqty == 0){
								$status = "error";
								$msg = "Quantity cannot be zero or less ";
							}else if($suppliedqty>$storeqty){
								$status = "error";
								$msg = "Quantity in Shelf NOT sufficent for this transfer ";
							}else{	
								$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
								if ($validateqty == '1') {
									$status = 'error';
									$msg = "Qty value is invalid";
									return '0';
								}

								if($suppliedqty>$storeqty){
									$status = 'error';
									$msg = "Qty Insufficent";
									return '0';
								}
								
								$type = 13;	
								$adjustmentnumber = 'AD'.date('His').rand(10,99);
								$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
								$expirycode = md5(microtime());
								$ajustcode = md5(microtime());
								$cashpricecode = md5(microtime());
							
								$category = 2;
								$newstoreqty = $storeqty - $suppliedqty;
							//	$newstoreqty = $storeqty - $suppliedqty;
							//	$newitemqty = $itemqty - $suppliedqty;
							//	$totalqty = $newstoreqty + $transferqty + $itemqty; 
								$stockvalue = $totalqty * $cashprice;               
								$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
								$unit = 'Pack';							
								$batchnumber = '0';	
								$zero = '0';
								$sqlresults = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newstoreqty,$totalqty,$unit,$costprice=$zero,$newprice=$zero,$batchcode=$zero,$batchnumber=$zero,$insuranceprice=$zero,$dollarprice=$zero,$currentshift,$currentshiftcode,$expire,$type,$state='0',$value=$suppliervalue,$supplier,$description,$currentuser,$currentusercode,$instcode);

							// $sqlresults = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newstoreqty,$totalqty,$unit,$costprice=$zero,$newprice=$zero,$batchcode=$zero,$batchnumber=$zero,$insuranceprice=$zero,$dollarprice=$zero,$currentshift,$currentshiftcode,$expire,$type,$state='0',$value=$suppliervalue,$supplier,$description,$currentuser,$currentusercode,$instcode);
							//	$sqlresults = $stockadjustmenttable->returntosupplierbulkconsumable($type,$suppliedqty,$item,$itemcode,$itemnumber,$newstoreqty,$totalqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$batchnumber,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode);						
								$action = "Bulk consumable Return to supplier";									
								$result = $engine->getresults($sqlresults,$item,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=9886;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
							}
						}
					}
				}
		break;

		// 19 NOV 2023,   JOSEPH ADORBOE  
		case 'approvebulkconsumablereturntostores':
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
					$batchnumber = $kt['4'];
					$batchnumber = date('his').rand(1,100);
					$batchcode = md5(microtime());
					$costprice=$cashprice='0';
					$batchdescription = 'Automatic batch for return to stores';
					$expire = date('Y-m-d', strtotime($day. '+ 3 months'));

					$sqlresults = $consumablesetuptable->returnconsumabletostore($addqty,$itemcode,$instcode); 					
					if($sqlresults =='2'){		
						$stockadjustmenttable->approvebulkrestock($ajustcode,$instcode);
						$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item=$medication,$batchcategory=1,$costprice,$cashprice,$suppliedqty=$addqty,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);
					//	$batchestable->returntostoresreducebatchnumberqty($batchnumber,$addqty,$instcode);
					}
					$action = "Approve Return to stores consumable";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9887;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);			
				}
			}
		break;

		// 12 NOV 2023  JOSEPH ADORBOE  
		case 'deleteconsumablereturntostores':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					$sqlresults = $stockadjustmenttable->deletependingstockajustment($ekey,$currentusercode,$currentuser,$instcode);						
					$action = "Delete Return to stores consumable";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9888;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}				
			}
		break;

		// 12 NOV 2023 JOSEPH ADORBOE  
		case 'editconsumablereturntostores':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$oldqty = htmlspecialchars(isset($_POST['oldqty']) ? $_POST['oldqty'] : '');	
			$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
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
						$msg = "Quantity in Shelf NOT sufficent for this transfer ";
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
						$batchcode=$batchnumber='0';
					
					// batchnumber
					$sqlresults = $stockadjustmenttable->edittransfer($ekey,$suppliedqty,$batchcode,$batchnumber,$currentusercode,$currentuser,$instcode);;						
					$action = "Edit Return to stores consumable";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9889;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
						}				
				
		//	}
			}
			}
		break;

		// 18 NOV 2023  JOSEPH ADORBOE  
		case 'bulkconsumablereturntostores':										
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
					//	$cashprice = $kt['6'];
						
						if(!empty($suppliedqty) && !empty($itemcode)){

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
								$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
								if ($validateqty == '1') {
									$status = 'error';
									$msg = "Qty value is invalid";
									return '0';
								}

								if($suppliedqty>$itemqty){
									$status = 'error';
									$msg = "Qty Insufficent";
									return '0';
								}
								
								$type = 12;	
								$adjustmentnumber = 'AD'.date('His').rand(10,99);
								$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
								$expirycode = md5(microtime());
								$ajustcode = md5(microtime());
								$cashpricecode = md5(microtime());
							
								$category = 2;
								$newstoreqty = $storeqty + $suppliedqty;
								$newitemqty = $itemqty - $suppliedqty;
								$totalqty = $newstoreqty + $transferqty + $newitemqty; 
								$unit = 'Pack';							
								$zero = '0';	
								$description = 'Bulk Return to stores Consumables';
							//	$sqlresults = $stockadjustmenttable->returntostorebulkconsumable($type,$suppliedqty,$item,$itemcode,$itemnumber,$newstoreqty,$newitemqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$batchnumber,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode);
							$sqlresults =  $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newpharmacyqty=$newitemqty,$newstoreqty,$unit,$costprice=$zero,$newprice=$zero,$batchcode=$zero,$batchnumber=$zero,$insuranceprice=$zero,$dollarprice=$zero,$currentshift,$currentshiftcode,$expire,$type,$state='0',$stockvalue=$zero,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);						
								$action = "Bulk consumable Return to stores";									
								$result = $engine->getresults($sqlresults,$item,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=9890;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
							}
						}
					}
				}
		break;

		// 13 NOV 2023,   JOSEPH ADORBOE  
		case 'approvebulkconsumabletransfer':
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
					$batchnumber = $kt['4'];

					$sqlresults = $consumablesetuptable->transferconsumabletopharmacy($addqty,$itemcode,$instcode); 					
					if($sqlresults =='2'){		
						$stockadjustmenttable->approvebulkrestock($ajustcode,$instcode);
						$batchestable->reducebatchnumberqty($batchnumber,$addqty,$instcode);
					}
					$action = "Approve Transfer consumable";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9891;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}

		break;
		// 12 NOV 2023  JOSEPH ADORBOE  
		case 'deleteconsumabletransfer':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					$sqlresults = $stockadjustmenttable->deletependingstockajustment($ekey,$currentusercode,$currentuser,$instcode);						
					$action = "Delete Restock consumable";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9892;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}				
			}
		break;

		// 12 NOV 2023 JOSEPH ADORBOE  
		case 'editconsumabletransfer':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
			$oldqty = htmlspecialchars(isset($_POST['oldqty']) ? $_POST['oldqty'] : '');	
			$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');
			$batchcode = htmlspecialchars(isset($_POST['batchcode']) ? $_POST['batchcode'] : '');		
			$totalbatchqty = htmlspecialchars(isset($_POST['totalbatchqty']) ? $_POST['totalbatchqty'] : '');		
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
						if ($suppliedqty > $totalbatchqty) {
							$status = 'error';
							$msg = "Qty insufficent";
							return '0';
						}else{				
					$transferqty = 0;			
                	$newqty = $oldqty + $suppliedqty;
			
					// batchnumber
					$sqlresults = $stockadjustmenttable->edittransfer($ekey,$suppliedqty,$batchcode,$batchnumber,$currentusercode,$currentuser,$instcode);;						
					$action = "Edit Transfer consumable";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9893;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
						}				
					}
				}
			}
		break;

		// 12 NOV 2023  JOSEPH ADORBOE  
		case 'bulktransferconsumable':										
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
						
						if(!empty($suppliedqty) && !empty($itemcode)){

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
								$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
								if ($validateqty == '1') {
									$status = 'error';
									$msg = "Qty value is invalid";
									return '0';
								}
								
								$type = 11;	
								$transferqty = 0;
								$adjustmentnumber = 'AD'.date('His').rand(10,99);
								$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
								$expirycode = md5(microtime());
								$ajustcode = md5(microtime());
								$cashpricecode = md5(microtime());
							
								$category = 2;
								$newstoreqty = $storeqty - $suppliedqty;
								$newtransferqty = $transferqty + $suppliedqty;
								$totalqty = $newstoreqty + $newtransferqty + $itemqty; 
								$stockvalue = $totalqty * $cashprice; 
								$unit = 'Pack';							
							//	$batchnumber = '0';	
								$description = 'Bulk Transfer Consumables';
								$batchprocesscode = md5(microtime());
								$batchprocessnumber = rand(100,10000);
								$zero = '0';
								$batchtotalqty = $batchestable->gettotalbatchqty($days,$itemcode,$itemname=$item,$category=1,$qty=$storeqty,$expire,$stockvalue,$cashprice,$cashprice,$currentuser,$currentusercode,$instcode);

								$sqlresults = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newtransferqty,$storeqty,$unit,$costprice=$zero,$newprice=$zero,$batchcode=$batchprocesscode,$batchnumber=$batchprocessnumber,$insurancepric=$zero,$dollarprice=$zero,$currentshift,$currentshiftcode,$expire,$type,$state='0',$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);

							//	$sqlresults = $stockadjustmenttable->transferbulkconsumable($type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$batchprocessnumber,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode);						
								$action = "Bulk consumable transfer";									
								$result = $engine->getresults($sqlresults,$item,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=9894;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
							}
						}
					}
				}
		break;

		//12 NOV 2023 , JOSEPH ADORBOE  
		case 'approvebulkconsumablerestock':
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
					$newprice = $kt['4'];
					$costprice = $kt['5'];
					$insuranceprice = $kt['6'];
					$batchcode = $kt['7'];
					$alternateprice=$partnerprice=$dollarprice='0';
					
					$consu = $consumablesetuptable->updateconsumable($itemcode,$addqty,$costprice,$newprice,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode);
					$bat = $batchestable->approvebatch($batchcode,$instcode);
					$vt = $consumablesetuptable->calculatestockvalue($itemcode,$instcode);
					$exe = $stockadjustmenttable->approvebulkrestock($ajustcode,$instcode);				
					if($exe == '2' && $vt == '2' && $consu == '2'){	
						$sqlresults = '2';			
					}else{			
						$sqlresults = '0';			
					}				
						
					$action = "Approve Bulk Restock consumable";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9895;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);		
				}
			}

		break;

		// 12 NOV 2023  JOSEPH ADORBOE  
		case 'deleteconsumablerestocking':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
					$sqlresults = $stockadjustmenttable->deletependingstockajustment($ekey,$currentusercode,$currentuser,$instcode);						
					$action = "Delete Restock consumable";									
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9896;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}				
			}
		break;
		// 12 NOV 2023 JOSEPH ADORBOE  
		case 'editconsumablerestocking':
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
				if(empty($ekey) || empty($suppliedqty) || empty($oldqty) || empty($costprice) || empty($cashprice) ){
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
					$newqty = $oldqty + $suppliedqty;
					$xp = explode("-",$expiry);
					$fday = $xp[0];
					$fmonth = $xp[1];
					$fyear = $xp[2];
					$expiry = $fyear.'-'.$fmonth.'-'.$fday;
				
					if ($expiry < $day) {
						$status = "error";
						$msg = " Stock expiry date cannot be before $day  Unsuccessful";
					} else {
												
						$sqlresults  = $stockadjustmenttable->editstockadjustment($ekey,$suppliedqty,$costprice,$cashprice,$insuranceprice,$dollarprice,$expiry,$currentuser,$currentusercode,$instcode);
											
						if($sqlresults == '2'){			
							$bat = $batchestable->editbatchpending($batchcode,$suppliedqty,$expiry,$suppliedqty,$currentusercode,$currentuser,$instcode);
							$exp = $expirytable->editexpiry($batchcode,$suppliedqty,$expiry,$currentuser,$currentusercode,$instcode);					
							if($exp == '2' && $bat == '2'){
								$sqlresults = '2';
							}else{
								$sqlresults = '0';
							}						
						}		
							
						$action = "Edit Restock consumable";									
						$result = $engine->getresults($sqlresults,$item=$medication.' Batch NO: '.$batchnumber,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9897;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}
			}
			}
		break;

		// 11 NOV 2023  JOSEPH ADORBOE  
		case 'bulkrestockconsumable':											
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){														
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
								$msg = "Quantity cannot be zero or less";
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
								$type = 10;	
								$transferqty = 0;
								$adjustmentnumber = 'AD'.date("His").rand(10,99);
								$newqty = $storeqty + $suppliedqty;
								$totalqty = $newqty + $transferqty + $itemqty; 
								$stockvalue = $totalqty * $newprice;
								$expirycode = md5(microtime());
								$ajustcode = md5(microtime());
								$cashpricecode = md5(microtime());
								$alternateprice = $partnerprice = $newprice;
								$category = 5;

								$xp = explode("-",$expire);
								$fday = $xp[0];
								$fmonth = $xp[1];
								$fyear = $xp[2];
								$expire = $fyear.'-'.$fmonth.'-'.$fday;
								
								if ($expire < $day) {
									$status = "error";
									$msg = " Stock expiry date cannot be before $day  Unsuccessful";
								} else {
									
									$cash = 'Cash';
									$batchcode = md5(microtime());
									$batchnumber = 'BA'.date('His').rand(10,99);
									$unit = 'Pack';
									$description = 'Bulk Restock Consumable';
																	
									$sqlresults  = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$costprice,$newprice,$batchcode,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$type,$state='0',$stockvalue,$supplier='NA',$description='Bulk Consumable Restock',$currentuser,$currentusercode,$instcode);
									if($sqlresults == '2'){										
									//	$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item,$category=1,$costprice,$cashprice,$suppliedqty,$currentuser,$currentusercode,$instcode);
										$batch = $batchestable->newbatchespending($batchcode,$batchnumber,$days,$itemcode,$item,$batchcategory=1,$costprice,$cashprice,$suppliedqty,$batchdescription = "BULK RESTOCK",$expire,$currentuser,$currentusercode,$instcode);
										
										$expy = $expirytable->newexpiry($expirycode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$expire,$batchcode,$batchnumber,$currentuser,$currentusercode,$instcode);			
									}	
																				
									$action = "Restock consumable";									
									$result = $engine->getresults($sqlresults,$item=$item.' Batch NO: '.$batchnumber,$action);
									$re = explode(',', $result);
									$status = $re[0];					
									$msg = $re[1];
									$event= "$action: $form_key $msg";
									$eventcode=9898;
									$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
								}						
								
							}
						}
					}
				}
		break;


		// 11 NOV 2023 JOSPH ADORBOE 
		case 'modifyquantites':			
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');
			$pharmacyqty = htmlspecialchars(isset($_POST['pharmacyqty']) ? $_POST['pharmacyqty'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$itemname = htmlspecialchars(isset($_POST['itemname']) ? $_POST['itemname'] : '');
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');
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
						$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
					
						$sqlresults = $consumablesetuptable->changeqty($itemcode,$totalqty,$storeqty,$transferqty,$pharmacyqty,$stockvalue,$instcode);					
						$action = "Modify Quantity";					
						$result = $engine->getresults($sqlresults,$item=$itemname,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9899;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
					}			
			}	
		break;	

			

		// 10 NOV 2023  JOSEPH ADORBOE  
		case 'singleconsumablesreturntosupplier':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$itemnumber = htmlspecialchars(isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '');	
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');	
			$itemqty = htmlspecialchars(isset($_POST['itemqty']) ? $_POST['itemqty'] : '');	
			$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');	
			$unit = htmlspecialchars(isset($_POST['unit']) ? $_POST['unit'] : '');	
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');			
			$newprice = htmlspecialchars(isset($_POST['newprice']) ? $_POST['newprice'] : '');	
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');	
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');	
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');		
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');		
			$supplier = htmlspecialchars(isset($_POST['supplier']) ? $_POST['supplier'] : '');
			$returnstockvalue = htmlspecialchars(isset($_POST['returnstockvalue']) ? $_POST['returnstockvalue'] : '');	
			$batchtotalqty = htmlspecialchars(isset($_POST['batchtotalqty']) ? $_POST['batchtotalqty'] : '');		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty) || empty($description)  || empty($supplier) || empty($returnstockvalue)){
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
						$msg = "Quantity in Pharmacy NOT sufficent for this return ";
					}else{	
				//	$type = 6;	
					$adjustmentnumber = 'AD'.date("His").rand(10,99);
					$totalqty = $itemqty + $transferqty + $storeqty; 
					$newtotalqty = $totalqty - $suppliedqty;
					$newstoreqty = $storeqty - $suppliedqty;
					$stockvalue = $newtotalqty * $cashprice;
					$processbatchcode = md5(microtime());
					$processbatchnumber = rand(100,100000);

					// $bt = explode('@@', $batch);
					// $batchcode = $bt['0'];
					// $batchqty = $bt['1'];
					// $batchnumber = $bt['2'];
					
					$expire = date('Y-m-d', strtotime($day. '+ 6 months'));
					$expirycode = md5(microtime());
					$ajustcode = md5(microtime());
					if ($expire < $day) {
						$status = "error";
						$msg = " Stock expiry date cannot be before $day  Unsuccessful";
					}else if($suppliedqty>$batchtotalqty){
						$status = "error";
						$msg = " Insufficent batch qty to return ";						
					} else {

					$sqlresults = $consumablesetuptable->returnconsumabletosupplier($newstoreqty,$newtotalqty,$stockvalue,$itemcode,$instcode);
					if($sqlresults =='2'){	
						$trans  = $stockadjustmenttable->stockadjustmentsreturn($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty=$newtotalqty,$storeqty=$newstoreqty,$unit,$processbatchcode,$processbatchnumber,$currentshift,$currentshiftcode,$expire,$type,$state=1,$supplier,$description,$value=$returnstockvalue,$currentuser,$currentusercode,$instcode);
						$bal =  $suppliedqty;
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
							$consumablesetuptable->calculatestockvalue($itemcode,$instcode);	
							$bal= $rem;	
							if($bal == 0){
								break;	
							}								
						}		 
					//	$batch = $batchestable->returntosupplierbatchnumberqty($batchnumber,$suppliedqty,$instcode);											
					}	
										
					$action = "Return consumable to supplier";					
					$result = $engine->getresults($sqlresults,$item=$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9901;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
					}
				}
				}
			}
		break;

		// 10 NOV 2023  JOSEPH ADORBOE  
		case 'singleconsumablesreturntostores':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$suppliedqty = htmlspecialchars(isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '');
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');	
			$itemnumber = htmlspecialchars(isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '');	
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');	
			$itemqty = htmlspecialchars(isset($_POST['itemqty']) ? $_POST['itemqty'] : '');	
			$batch = htmlspecialchars(isset($_POST['batch']) ? $_POST['batch'] : '');	
			$unit = htmlspecialchars(isset($_POST['unit']) ? $_POST['unit'] : '');	
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');			
			$newprice = htmlspecialchars(isset($_POST['newprice']) ? $_POST['newprice'] : '');	
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');	
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');	
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');				
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
				//	$type = 6;	
					$adjustmentnumber = 'AD'.date("His").rand(10,99);
					$newqty = $itemqty - $suppliedqty;
					$newstoreqty =$storeqty + $suppliedqty;
					$totalqty = $newqty + $transferqty + $itemqty; 
					$stockvalue = $suppliedqty * $cashprice;
					$batchcode = md5(microtime());
					$batchnumber = 'BA'.date('His').rand(10,99);
					$description = 'Return to stores Consumable ';	

					// $bt = explode('@@', $batch);
					// $batchcode = $bt['0'];
					// $batchqty = $bt['1'];
					// $batchnumber = $bt['2'];
					
					$expire = date('Y-m-d', strtotime($day. '+ 6 months'));
					$expirycode = md5(microtime());
					$ajustcode = md5(microtime());					
					
					$sqlresults = $consumablesetuptable->returnconsumabletostore($suppliedqty,$itemcode,$instcode);
					if($sqlresults == '2' ){
						$sqlresults = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty=$newstoreqty,$unit,$costprice,$newprice,$batchcode,$batchnumber,$insuranceprice=0,$dollarprice=0,$currentshift,$currentshiftcode,$expire,$type,$state=1,$stockvalue,$supplier='NA',$description='Single Consumable Return to stores',$currentuser,$currentusercode,$instcode);
						$batch = $batchestable->addnewbatches($batchcode,$batchnumber,$days,$itemcode,$itemname=$item,$category=1,$qtysupplied=$suppliedqty,$qtyleft=$suppliedqty,$description,$expire,$currentuser,$currentusercode,$instcode);
						// $batch = $batchestable->increasebatchqty($batchcode,$suppliedqty,$instcode);	
						// if($trans  =='2' && $batch == '2'){
						// 	$sqlresults ='2';
						// }else{
						// 	$sqlresults ='0';
						// }		
					}
										
					$action = "Return consumable to store";					
					$result = $engine->getresults($sqlresults,$item=$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9902;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
					}
				}
			}
		break;

		// 10 oct 2023,  JOSEPH ADORBOE  
		case 'singleconsumabletransfertopharmacy':
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
					//	$type = 5;	
					//	$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
					$adjustmentnumber = date("His");
					$newstoreqty = $storeqty - $suppliedqty;
					$newtransferqty = $transferqty + $suppliedqty;
					// $totalqty = $newstoreqty + $newtransferqty + $itemqty; 
					$stockvalue = $suppliedqty * $cashprice;               
					$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
					// $expirycode = md5(microtime());
					$ajustcode = md5(microtime());
					$batchprocesscode = md5(microtime());
					$batchprocessnumber = rand(100,10000);

					$validatesuppliedqty = $engine->getnumbernonzerovalidation($suppliedqty);
					if ($validatesuppliedqty == '1') {
						$status = 'error';
						$msg = "Qty value is invalid";
						return '0';
					}

				// if ($expire < $day) {
				// 	$status = "error";
				// 	$msg = " Stock expiry date cannot be before $day Unsuccessful";
				// } else {

					// $bt = explode('@@', $batch);
					// $batchcode = $bt['0'];
					// $batchqty = $bt['1'];
					// $batchnumber = $bt['2'];

					// if($suppliedqty > $batchqty){
					// 	$status = "error";
					// 	$msg = " insufficent Qty";
					// }else{
						$description = 'Single Transfer Medication';
						$sqlresults = $consumablesetuptable->transferconsumabletopharmacy($suppliedqty,$itemcode,$instcode);
						if($sqlresults == '2' ){
						$sqlresults  = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty=$newstoreqty,$storeqty=$newtransferqty,$unit='NA',$costprice ='0.00',$newprice='0.00',$batchprocesscode,$batchprocessnumber,$insuranceprice=0,$dollarprice=0,$currentshift,$currentshiftcode,$expire,$type,$state=1,$stockvalue,$supplier='NA',$description='Single Consumable transfer',$currentuser,$currentusercode,$instcode);
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
						// $batch = $batchestable->reducebatchqty($batchcode,$suppliedqty,$instcode);	
						// if($trans  =='2' && $batch == '2'){
						// 	$sqlresults ='2';
						// }else{
						// 	$sqlresults = '0';
						// }		
					//	}
											
						$action = "Transfer consumable";					
						$result = $engine->getresults($sqlresults,$item=$item.' Batch NO: '.$batchnumber,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9903;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);		
					}			
				}
				}
			}
		break;

		// 9 NOV 2023 JOSEPH ADORBOE  
		case 'singlerestockconsumablestores':
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
			$expire = htmlspecialchars(isset($_POST['expire']) ? $_POST['expire'] : '');
			$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
			$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');
			$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');	
			$insuranceprice = htmlspecialchars(isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '');
			$batchdescription = htmlspecialchars(isset($_POST['batchdescription']) ? $_POST['batchdescription'] : '');	
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
				//	$type = 4;	
				//	$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
					$adjustmentnumber = 'AD'.date('His').rand(10,99);
					$newqty = $storeqty + $suppliedqty;
					$totalqty = $newqty + $transferqty + $itemqty; 
					$stockvalue = $totalqty * $newprice;				
					$expirycode = md5(microtime());
					$ajustcode = md5(microtime());
					$cashpricecode = md5(microtime());
					$partnerprice = $alternateprice = '0.00';
					$xp = explode("-",$expire);
					$fday = $xp[0];
					$fmonth = $xp[1];
					$fyear = $xp[2];
					$expire = $fyear.'-'.$fmonth.'-'.$fday;
					if ($expire < $day) {
						$status = "error";
						$msg = " Stock expiry date cannot be before $day Unsuccessful";
					} else {						
					$cash = 'Cash';
					$batchcode = md5(microtime());
					$batchnumber = 'BA'.date('His').rand(10,99);
					$description = "Single restock Consumable";
					
				$sqlresults  = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$costprice,$newprice,$batchcode,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$type,$state=1,$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);
			
				if($sqlresults == '2'){	
					$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item,$batchcategory=1,$costprice,$cashprice,$suppliedqty,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);				
					// $batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item,$category=1,$costprice,$cashprice,$suppliedqty,$currentuser,$currentusercode,$instcode);
					
					$consu = $consumablesetuptable->restockconsumable($itemcode,$newqty,$costprice,$newprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode);
					
					$expy = $expirytable->newexpiry($expirycode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$expire,$batchcode,$batchnumber,$currentuser,$currentusercode,$instcode);
					
					$cprice = $pricingtable->setcashprices($itemcode,$item,$newprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);
				}										
					$action = "Restock consumable";					
					$result = $engine->getresults($sqlresults,$item=$item.' Batch NO: '.$batchnumber,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9904;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);

						}
					}				
				}
			}
		break;

		// 9 NOV 2023 JOSPH ADORBOE
		case 'enableconsumable':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$consumable = htmlspecialchars(isset($_POST['consumable']) ? $_POST['consumable'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($consumable) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{				
					$sqlresults = $consumablesetuptable->enableconsumable($ekey,$days,$currentuser,$currentusercode,$instcode);						
					$action = "Enable consumable";
					if($sqlresults =='2'){
						$pricingtable->enablepriceing($ekey,$currentuser,$currentusercode,$instcode);
					}
					$result = $engine->getresults($sqlresults,$item=$consumable,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9908;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}
	
		break;
			
		// 9 NOV 2023 JOSPH ADORBOE
			case 'disableconsumable':
				$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
				$consumable = htmlspecialchars(isset($_POST['consumable']) ? $_POST['consumable'] : '');
				$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
				$disablereason = htmlspecialchars(isset($_POST['disablereason']) ? $_POST['disablereason'] : '');
				$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
				$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
				$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
				if($preventduplicate == '1'){
					if(empty($ekey) || empty($consumable) || empty($disablereason) ){
						$status = 'error';
						$msg = 'Required Field Cannot be empty';				
					}else{					
						
						$sqlresults = $consumablesetuptable->disableconsumable($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode);						
						$action = "Disable consumable";
						if($sqlresults =='2'){
							$pricingtable->disablepriceing($ekey,$currentuser,$currentusercode,$instcode);	
						}
						$result = $engine->getresults($sqlresults,$item=$consumable,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9909;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					
					}
				}
		
			break;
		// 9 NOV 2023,  JOSPH ADORBOE
		case 'editconsumable':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$consumable = htmlspecialchars(isset($_POST['consumable']) ? $_POST['consumable'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($consumable) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					if(empty($procedurenumber)){
						$procedurenumber = rand(1,100000);
					}					
					$consumable = strtoupper($consumable);
					$sqlresults = $consumablesetuptable->editconsumable($ekey,$consumable,$description,$currentuser,$currentusercode,$instcode);
					$action = "Edit consumable";
					$result = $engine->getresults($sqlresults,$item=$consumable,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9910;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}	
		break;
		
		// 5 NOV 2023,  JOSEPH ADORBOE 
		case 'addnewconsumablefully':			
			$consumable = htmlspecialchars(isset($_POST['consumable']) ? $_POST['consumable'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');
			$insuranceprice = htmlspecialchars(isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '');
			$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');
			$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$restock = htmlspecialchars(isset($_POST['restock']) ? $_POST['restock'] : '');
			$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
			$expire = htmlspecialchars(isset($_POST['expire']) ? $_POST['expire'] : '');
			$batchdescription = htmlspecialchars(isset($_POST['batchdescription']) ? $_POST['batchdescription'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($consumable) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$ajustcode = md5(microtime());
					$consumablenumber = date('His').rand(10,99);
					$consumable = strtoupper($consumable);	
					$alternateprice = $partnerprice	= $dollarprice = '0.00';
					$transferqty = $qty = 0;	
					$totalqty = $storeqty+$transferqty+$qty;
					$stockvalue = $totalqty*$cashprice;
					$cashpricecode = md5(microtime());
					$cash = 'cash';
					$batchcode = md5(microtime());
					$batchnumber = 'BA'.date('His').rand(10,99);
					$batchcategory= 3;
					$adjustmentnumber = 'AD'.date('His').rand(10,99);
				//	$devicenumber = rand(100,100000);
					$xp = explode("-",$expire);
					$fday = $xp[0];
					$fmonth = $xp[1];
					$fyear = $xp[2];
					$expire = $fyear.'-'.$fmonth.'-'.$fday;
					$sqlresults = $consumablesetuptable->newconsumable($form_key,$consumable,$consumablenumber,$restock,$days,$description,$storeqty,$costprice,$cashprice,$dollarprice,$partnerprice,$alternateprice,$insuranceprice,$transferqty,$qty,$totalqty,$stockvalue,$currentuser,$currentusercode,$instcode);									
					$action = "Add consumable";
					if($sqlresults =='2'){
						
						$itemcode=$form_key;
						$itemname=$consumable;

						//$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$itemname,$batchcategory=1,$costprice,$cashprice,$storeqty,$currentuser,$currentusercode,$instcode);

						$sj = $stockadjustmenttable->stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber=$consumablenumber,$item=$consumable,$suppliedqty=$storeqty,$newqty=$storeqty,$storeqty,$unit='NA',$costprice,$newprice=$cashprice,$batchcode,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$type=10,$state=1,$stockvalue,$supplier='NA',$description,$currentuser,$currentusercode,$instcode);	
						
						$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item=$consumable,$batchcategory=1,$costprice,$cashprice,$suppliedqty=$storeqty,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);

						$pricingtable->setcashprices($itemcode,$itemname,$cashprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);
						
						if($insuranceprice > '0'){						
							if (!empty($_POST["scheckbox"])) {
								foreach ($_POST["scheckbox"] as $schemes) {
									$pricecode = md5(microtime());	
									$req = explode('@@@', $schemes);
									$schemecode = $req['0'];
									$schemename = $req['1'];
									$insurancecode = $req['2'];
									$insurancename = $req['3'];                       
									$ins = $pricingtable->setinsuranceprices($pricecode,$category,$itemcode,$itemname,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);;
								}  
							}
						}
					}
					$result = $engine->getresults($sqlresults,$item=$consumable,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9911;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}	
		break;
		
	}
	
	// 18 NOV 2023 
	function consumablesetupmenu(){ ?>
	
	<div class="btn-group mt-2 mb-2">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					Bulk Action <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a class="dropdown-item" href="consumablerestock">Restock</a></li>
					<li><a class="dropdown-item" href="consumabletransfer">Transfer</a></li>
					<li><a class="dropdown-item" href="consumablereturntostores">Return to Stores</a></li>
					<li><a class="dropdown-item" href="consumablereturntosuppliers">Return to Supplier</a></li>					
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