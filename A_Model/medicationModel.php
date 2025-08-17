<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$medmodel = isset($_POST['medmodel']) ? $_POST['medmodel'] : '';
	
	// 13 MAY 2023 JOSEPH ADORBOE 
	switch ($medmodel)
	{

		// 23 JULY 2023  JOSEPH ADORBOE  
		case 'approvebulkdevicetransfer':
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				foreach($_POST["scheckbox"] as $key){
					$kt = explode('@@@',$key);
					$ajustcode = $kt['0'];
					$medciationcode = $kt['1'];
					$medication = $kt['2'];
					$addqty = $kt['3'];
					$newprice = $kt['4'];

					$editpricing = $medsql->approvebulkdevicetransfer($ajustcode,$medciationcode,$addqty,$days,$currentusercode,$currentuser,$instcode);
					$title = "$medication Restock Stores ";
					if($editpricing == '0'){					
						$status = "error";					
						$msg = "$title Unsuccessful"; 
					}else if($editpricing == '1'){				
						$status = "error";					
						$msg = "$title  Exist"; 					
					}else if($editpricing == '2'){
						$event= " $title   successfully ";
						$eventcode= "230";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}						
					}else{					
						$status = "error";					
						$msg = "Unsuccessful source "; 					
					}
			
				}
			}

		break;
		// 22 JULY 2023  JOSEPH ADORBOE  
		case 'approvebulkdevicerestock':
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				foreach($_POST["scheckbox"] as $key){
					$kt = explode('@@@',$key);
					$ajustcode = $kt['0'];
					$medciationcode = $kt['1'];
					$medication = $kt['2'];
					$addqty = $kt['3'];
					$newprice = $kt['4'];

					$editpricing = $requestionsql->approvebulkdevicerestock($ajustcode,$medciationcode,$addqty,$days,$currentusercode,$currentuser,$instcode);
					$title = "$medication Restock Stores ";
					if($editpricing == '0'){					
						$status = "error";					
						$msg = "$title Unsuccessful"; 
					}else if($editpricing == '1'){				
						$status = "error";					
						$msg = "$title  Exist"; 					
					}else if($editpricing == '2'){
						$event= " $title   successfully ";
						$eventcode= "230";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}						
					}else{					
						$status = "error";					
						$msg = "Unsuccessful source "; 					
					}
			
				}
			}

		break;
		// 23 JULY 2023  JOSEPH ADORBOE  
		case 'approvebulkmedicationtransfer':
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				foreach($_POST["scheckbox"] as $key){
					$kt = explode('@@@',$key);
					$ajustcode = $kt['0'];
					$medciationcode = $kt['1'];
					$medication = $kt['2'];
					$addqty = $kt['3'];
					$newprice = $kt['4'];

					$editpricing = $medsql->approvebulkmedicationtransfer($ajustcode,$medciationcode,$addqty,$days,$currentusercode,$currentuser,$instcode);
					$title = "$medication Restock Stores ";
					if($editpricing == '0'){					
						$status = "error";					
						$msg = "$title Unsuccessful"; 
					}else if($editpricing == '1'){				
						$status = "error";					
						$msg = "$title  Exist"; 					
					}else if($editpricing == '2'){
						$event= " $title   successfully ";
						$eventcode= "230";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}						
					}else{					
						$status = "error";					
						$msg = "Unsuccessful source "; 					
					}
			
				}
			}

		break;
		// 23 JULY 2023  JOSEPH ADORBOE  
		case 'deletemedicationtransfer':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{				
					$editpricing = $requestionsql->deletetransfermedication($ekey,$days,$currentusercode,$currentuser,$instcode);
					$title = "$medication Transfer Delete ";
					if($editpricing == '0'){					
						$status = "error";					
						$msg = "$title Unsuccessful"; 
					}else if($editpricing == '1'){				
						$status = "error";					
						$msg = "$title  Exist"; 					
					}else if($editpricing == '2'){
						$event= " $title   successfully ";
						$eventcode= "230";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}						
					}else{					
						$status = "error";					
						$msg = "Unsuccessful source "; 					
					}
				}				
			}
		break;
		// 23 JULY 2023  JOSEPH ADORBOE  
		case 'deleterestocking':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{	
				
					$editpricing = $requestionsql->deleterestockmedication($ekey,$days,$currentusercode,$currentuser,$instcode);
					$title = "$medication Restock Delete ";
					if($editpricing == '0'){					
						$status = "error";					
						$msg = "$title Unsuccessful"; 
					}else if($editpricing == '1'){				
						$status = "error";					
						$msg = "$title  Exist"; 					
					}else if($editpricing == '2'){
						$event= " $title   successfully ";
						$eventcode= "230";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}						
					}else{					
						$status = "error";					
						$msg = "Unsuccessful source "; 					
					}
				}				
			}

		break;
		// 23 JULY 2023 JOSEPH ADORBOE  
		case 'edittransfer':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';				
			$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';
			$oldqty = isset($_POST['oldqty']) ? $_POST['oldqty'] : '';				
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($suppliedqty)  ){
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
						if($suppliedqty > $oldqty ){
							$status = 'error';
							$msg = "Transfer Qty $suppliedqty is greater than store value $oldqty";
							return '0';
						}

					$type = 2;		
					$editpricing = $requestionsql->edittransfermovement($ekey,$itemcode,$type,$suppliedqty,$oldqty,$days,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode);
					$title = "$medication Transfer from Stores";

					if($editpricing == "0"){					
						$status = "error";					
						$msg = "$title Unsuccessful"; 
					}else if($editpricing == "1"){				
						$status = "error";					
						$msg = "$title  Exist"; 					
					}else if($editpricing == "2"){
						$event= " $title Successfully ";
						$eventcode= "231";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == "2"){				
							$status = "success";
							$msg = "$title Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}						
					}else{					
						$status = "error";					
						$msg = "Unsuccessful source "; 					
					}
				}			
			}
			}
		break;

		// 22 JULY 2023  JOSEPH ADORBOE  
		case 'approvebulkmedicationrestock':
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){	
				foreach($_POST["scheckbox"] as $key){
					$kt = explode('@@@',$key);
					$ajustcode = $kt['0'];
					$medciationcode = $kt['1'];
					$medication = $kt['2'];
					$addqty = $kt['3'];
					$newprice = $kt['4'];

					$editpricing = $requestionsql->approvebulkmedicationrestock($ajustcode,$medciationcode,$addqty,$days,$currentusercode,$currentuser,$instcode);
					$title = "$medication Restock Stores ";
					if($editpricing == '0'){					
						$status = "error";					
						$msg = "$title Unsuccessful"; 
					}else if($editpricing == '1'){				
						$status = "error";					
						$msg = "$title  Exist"; 					
					}else if($editpricing == '2'){
						$event= " $title   successfully ";
						$eventcode= "230";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}						
					}else{					
						$status = "error";					
						$msg = "Unsuccessful source "; 					
					}
			
				}
			}

		break;

		// 22 JULY 2023 JOSEPH ADORBOE  
		case 'editrestocking':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';	
			$oldqty = isset($_POST['oldqty']) ? $_POST['oldqty'] : '';	
			$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';	
			$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';	
			$insuranceprice = isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '';	
			$dollarprice = isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '';	
			$expiry = isset($_POST['expiry']) ? $_POST['expiry'] : '';	
			$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';				
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
				$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
                $newqty = $oldqty + $suppliedqty;
			//	$totalqty = $newqty + $transferqty + $itemqty; 
			//	$stockvalue = $totalqty * $newprice;           

				//	$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
                // $expirycode = md5(microtime());
				// $ajustcode = md5(microtime());
				// $cashpricecode = md5(microtime());
				//$alternateprice = $partnerprice = $newprice;

                if ($expiry < $day) {
                    $status = "error";
                    $msg = " Stock expiry date cannot be before $day  Unsuccessful";
                } else {
						
					$editpricing = $requestionsql->editrestockstockmovement($ekey,$itemcode,$type,$suppliedqty,$newqty,$oldqty,$expiry,$days,$costprice,$cashprice,$dollarprice,$insuranceprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod);
					$title = "$medication Restock Stores ";

				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title  Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title   successfully ";
					$eventcode= "231";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
			}
			}
			}
		break;
		// 18 MAY 2023  JOSEPH ADORBOE  
		case 'singletransfermedicationstocks':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
			$item = isset($_POST['item']) ? $_POST['item'] : '';	
			$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';	
			$itemnumber = isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '';	
			$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';	
			$itemqty = isset($_POST['itemqty']) ? $_POST['itemqty'] : '';	
			$unit = isset($_POST['unit']) ? $_POST['unit'] : '';	
			$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';			
			$newprice = isset($_POST['newprice']) ? $_POST['newprice'] : '';	
			$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';	
			$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';	
			$type = isset($_POST['type']) ? $_POST['type'] : '';	
			$category = isset($_POST['category']) ? $_POST['category'] : '';		
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
					$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
					$newstoreqty = $storeqty - $suppliedqty;
					$newtransferqty = $transferqty + $suppliedqty;
					$totalqty = $newstoreqty + $newtransferqty + $itemqty; 
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

					if ($expire < $day) {
						$status = "error";
						$msg = " Stock expiry date cannot be before $day  Unsuccessful";
					} else {
					$editpricing = $requestionsql->singlemedicationtransferstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$newstoreqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode);
					$title = "$item Restock Stores ";
					if($editpricing == '0'){					
						$status = "error";					
						$msg = "$title Unsuccessful"; 
					}else if($editpricing == '1'){				
						$status = "error";					
						$msg = "$title  Exist"; 					
					}else if($editpricing == '2'){
						$event= " $title   successfully ";
						$eventcode= "230";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}						
					}else{					
						$status = "error";					
						$msg = "Unsuccessful source "; 					
					}
				}
				}
				}
			}

		break;

		// 18 MAY 2023  JOSEPH ADORBOE  
		case 'bulktransfermedicationstocks':
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
					$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
					$newstoreqty = $storeqty - $suppliedqty;
					$newtransferqty = $transferqty + $suppliedqty;
					$totalqty = $newstoreqty + $newtransferqty + $itemqty; 
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

					$editpricing = $medsql->transferbulkmedication($type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode);
					$title = "$item Restock Stores ";
					if($editpricing == '0'){					
						$status = "error";					
						$msg = "$title Unsuccessful"; 
					}else if($editpricing == '1'){				
						$status = "error";					
						$msg = "$title  Exist"; 					
					}else if($editpricing == '2'){
						$event= "$title  successfully ";
						$eventcode= "230";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "$title  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}						
					}else{					
						$status = "error";					
						$msg = "Unsuccessful source "; 					
					}
				}
				}
				}
			}

		break;

		// 15 MAY 2021 JOSPH ADORBOE
		case 'editpricesmedication':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$price = isset($_POST['price']) ? $_POST['price'] : '';
			$category = isset($_POST['category']) ? $_POST['category'] : '';
			$schemename = isset($_POST['schemename']) ? $_POST['schemename'] : '';
			$paycode = isset($_POST['paycode']) ? $_POST['paycode'] : '';
			$totalqty = isset($_POST['totalqty']) ? $_POST['totalqty'] : '';
			$item = isset($_POST['item']) ? $_POST['item'] : '';
			$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';			
			$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
			$partnerprice = isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '';
			$otherprice = isset($_POST['otherprice']) ? $_POST['otherprice'] : '';
			$dollarprice = isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($price) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$otherprice = '0';
					// $validatecostprice = $engine->getnumbernonzerovalidation($price);
					// if ($validatecostprice == '1') {
					// 	$status = 'error';
					// 	$msg = "New price value is invalid";
					// 	return '0';
					// }

					$validatecashprice = $engine->getnumbernonzerovalidation($price);
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

					// $validatepartnerprice = $engine->getnumbervalidation($partnerprice);
					// if ($validatepartnerprice == '1') {
					// 	$status = 'error';
					// 	$msg = "Partner Prices value is invalid";
					// 	return '0';
					// }

					$partnerprice = $alternateprice = $price;
					$stockvalue = $price*$totalqty;
					$edit = $medsql->editedprices($ekey,$price,$alternateprice,$otherprice,$partnerprice,$dollarprice,$currentuser,$currentusercode,$instcode,$category,$paycode,$cashpaymentmethodcode,$stockvalue,$itemcode);
					$title = 'Edit Prices';
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title $item Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title $item  Exist"; 					
					}else if($edit == '2'){
						$event= " $title $item successfully ";
						$eventcode= "216";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $item Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 16 MAY 2023  JOSEPH ADORBOE  
		case 'bulkrestockmedicationstores':
										
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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

								//

								$type = 1;	
								$transferqty = 0;
								$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
								$newqty = $storeqty + $suppliedqty;
								$totalqty = $newqty + $transferqty + $itemqty; 
								$stockvalue = $totalqty * $newprice;
								$expirycode = md5(microtime());
								$ajustcode = md5(microtime());
								$cashpricecode = md5(microtime());
								$alternateprice = $partnerprice = $newprice;
								$category = 2;
								
								if ($expire < $day) {
									$status = "error";
									$msg = " Stock expiry date cannot be before $day  Unsuccessful";
								} else {
											
								//	$editpricing = $requestionsql->restockstockmovement($form_key,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$itemqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$category,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cashpricecode,$insuranceprice);
									$editpricing = $requestionsql->restockstockmovementbulk($form_key,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$itemqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$category,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cashpricecode,$insuranceprice);
									$title = "$item Restock Stores ";
									if($editpricing == '0'){					
										$status = "error";					
										$msg = "$title Unsuccessful"; 
									}else if($editpricing == '1'){				
										$status = "error";					
										$msg = "$title  Exist"; 					
									}else if($editpricing == '2'){
										$event= " $title   successfully ";
										$eventcode= "231";
										$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
										if($audittrail == '2'){				
											$status = "success";
											$msg = " $title  Successfully";
										}else{
											$status = "error";
											$msg = "Audit Trail unsuccessful";	
										}						
									}else{					
										$status = "error";					
										$msg = "Unsuccessful source "; 					
									}
								}						
								
							}
						}
					}
				}
			}
		break;
		// 15 MAY 2023  JOSEPH ADORBOE  
		case 'singlerestockmedicationstores':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
			$item = isset($_POST['item']) ? $_POST['item'] : '';	
			$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';	
			$itemnumber = isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '';	
			$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';	
			$itemqty = isset($_POST['itemqty']) ? $_POST['itemqty'] : '';	
			$unit = isset($_POST['unit']) ? $_POST['unit'] : '';			
			$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';			
			$newprice = isset($_POST['newprice']) ? $_POST['newprice'] : '';
			$type = isset($_POST['type']) ? $_POST['type'] : '';	
			$category = isset($_POST['category']) ? $_POST['category'] : '';	
			$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';	
			$expire = isset($_POST['expire']) ? $_POST['expire'] : '';
			$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
			$insuranceprice = isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '';
			$partnerprice = isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '';
			$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';
			$dollarprice = isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '';							
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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

				$type = 1;	
				$transferqty = 0;
				$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
                $newqty = $storeqty + $suppliedqty;
				$totalqty = $newqty + $transferqty + $itemqty; 
				$stockvalue = $totalqty * $newprice;           

			//	$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
                $expirycode = md5(microtime());
				$ajustcode = md5(microtime());
				$cashpricecode = md5(microtime());
				$alternateprice = $partnerprice = $newprice;

                if ($expire < $day) {
                    $status = "error";
                    $msg = " Stock expiry date cannot be before $day  Unsuccessful";
                } else {
						
					$editpricing = $requestionsql->restockstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$itemqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$category,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cashpricecode,$insuranceprice);
					$title = "$item Restock Stores ";

				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title  Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title   successfully ";
					$eventcode= "231";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
			}
			}
			}
		break;
		// 15 MAY 2023  JOSEPH ADORBOE  
		case 'restockmedicationstores':
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
			$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
			$item = isset($_POST['item']) ? $_POST['item'] : '';	
			$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';	
			$itemnumber = isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '';	
			$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';	
			$itemqty = isset($_POST['itemqty']) ? $_POST['itemqty'] : '';	
			$unit = isset($_POST['unit']) ? $_POST['unit'] : '';			
			$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';			
			$newprice = isset($_POST['newprice']) ? $_POST['newprice'] : '';
			$type = isset($_POST['type']) ? $_POST['type'] : '';	
			$category = isset($_POST['category']) ? $_POST['category'] : '';	
			$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';	
			$expire = isset($_POST['expire']) ? $_POST['expire'] : '';
			$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
			$partnerprice = isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '';
			$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';
			$dollarprice = isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '';							
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($medication) || empty($suppliedqty) || empty($costprice) || empty($newprice) ){
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

					// $validatealternateprice = $engine->getnumbervalidation($alternateprice);
					// if ($validatealternateprice == '1') {
					// 	$status = 'error';
					// 	$msg = "Alternate Price value is invalid";
					// 	return '0';
					// }

					// $validatepartnerprice = $engine->getnumbervalidation($partnerprice);
					// if ($validatepartnerprice == '1') {
					// 	$status = 'error';
					// 	$msg = "Partner Price value is invalid";
					// 	return '0';
					// }

					$validatedollarprice = $engine->getnumbervalidation($dollarprice);
					if ($validatedollarprice == '1') {
						$status = 'error';
						$msg = "Dollar Price value is invalid";
						return '0';
					}

					$md = explode('@@@', $medication);
					$itemcode = $md['0'];
					$item = $md['1'];
					$itemnumber = $md['2'];
					$storeqty = $md['3'];
					$itemqty = $md['4'];
					$unit = $md['5']; 

			// 		$item = isset($_POST['item']) ? $_POST['item'] : '';	
			// $itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';	
			// $itemnumber = isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '';	
			// $storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';	
			// $itemqty = isset($_POST['itemqty']) ? $_POST['itemqty'] : '';	
			// $unit = isset($_POST['unit']) ? $_POST['unit'] : '';			

				$type = 1;	
				$transferqty = 0;
				$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
                $newqty = $storeqty + $suppliedqty;
				$totalqty = $newqty + $transferqty + $itemqty; 
				$stockvalue = $totalqty * $newprice;           

			//	$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
                $expirycode = md5(microtime());
				$ajustcode = md5(microtime());
				$cashpricecode = md5(microtime());
				$alternateprice = $partnerprice = $newprice;

                if ($expire < $day) {
                    $status = "error";
                    $msg = " Stock expiry date cannot be before $day  Unsuccessful";
                } else {
			//	$arrayparameters = array($ekey,$type,$suppliedqty,$currentusercode,$currentuser,$instcode);				
				$editpricing = $requestionsql->restockstockmovement($form_key,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$itemqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$category,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cashpricecode,$insuranceprice);
				$title = "$item Restock Stores ";
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title  Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title   successfully ";
					$eventcode= "231";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
			}
			}
			}
		break;

		// 14 DEC 2022  JOSPH ADORBOE 
		case 'addnewmedications':			
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
			$dosageform = isset($_POST['dosageform']) ? $_POST['dosageform'] : '';
			$unit = isset($_POST['unit']) ? $_POST['unit'] : '';
			$restock = isset($_POST['restock']) ? $_POST['restock'] : '';
			$brandname = isset($_POST['brandname']) ? $_POST['brandname'] : '';
			$medicationdose = isset($_POST['medicationdose']) ? $_POST['medicationdose'] : '';
			$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';
			$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';
			$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';
			$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';
			$insuranceprice = isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '';
			$dollarprice = isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '';
			$partnerprice = isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '';
			$category = isset($_POST['category']) ? $_POST['category'] : '';
			$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
			$expire = isset($_POST['expire']) ? $_POST['expire'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($medication) || empty($dosageform) || empty($restock) || empty($brandname) || empty($medicationdose) || empty($storeqty) || empty($costprice) || empty($cashprice) ){
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
						$medicationnumber = $setupsql->getlastmedicationcodenumber($instcode);
						$medication = strtoupper($medication);
						$brandname = strtoupper($brandname);
						$itemname = $medication = $medication.' - '.$dosageformname.' - '.$medicationdose.' - '.$brandname ;
					//	$storeqty = $storeqty - $transferqty;			
						$transferqty = 0;
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
						$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
						$ajustcode = md5(microtime());
						//$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
						$expirycode = md5(microtime());
						$cashpricecode = md5(microtime());

						$add = $medsql->setupnewmedication($form_key, $adjustmentnumber, $ajustcode, $medication, $medicationnumber, $dosageformcode, $dosageformname, $untcode, $untname, $restock, $storeqty, $brandname, $medicationdose, $transferqty, $costprice, $cashprice, $insuranceprice, $dollarprice, $days, $totalqty, $stockvalue, $expirycode, $expire, $category, $cashpricecode, $alternateprice, $cashpaymentmethodcode, $cashpaymentmethod, $cashschemecode, $partnerprice,$currentuser, $currentusercode, $instcode, $currentshift, $currentshiftcode);
						$title = 'Add Medication';
						if ($add == '0') {
							$status = "error";
							$msg = "$title $medication Unsuccessful";
						} elseif ($add == '1') {
							$status = "error";
							$msg = "$title $medication Exist";
						} elseif ($add == '2') {
							if ($insuranceprice > '0') {
								if (!empty($_POST["scheckbox"])) {
									foreach ($_POST["scheckbox"] as $schemes) {
										$pricecode = md5(microtime());
										$req = explode('@@@', $schemes);
										$schemecode = $req['0'];
										$schemename = $req['1'];
										$insurancecode = $req['2'];
										$insurancename = $req['3'];
										$ins = $setupsql->setinsuranceprices($pricecode, $category, $form_key, $itemname, $schemecode, $schemename, $insurancecode, $insurancename, $insuranceprice, $alternateprice, $dollarprice, $instcode, $days, $currentusercode, $currentuser);
									}
								}
							}
							$event= "$title $medication successfully ";
							$eventcode= "202";
							$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
							if ($audittrail == '2') {
								$status = "success";
								$msg = "$title $medication Successfully";
							} else {
								$status = "error";
								$msg = "Audit Trail unsuccessful";
							}
						} else {
							$status = "error";
							$msg = "Unknown source ";
						}
					}
			//	}
			}
	
		break;	

		// 29 DEC 2022 JOSPH ADORBOE
		case 'editadminmedication':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';	
			$dosageform = isset($_POST['dosageform']) ? $_POST['dosageform'] : '';
			$unit = isset($_POST['unit']) ? $_POST['unit'] : '';
			$restock = isset($_POST['restock']) ? $_POST['restock'] : '';
			$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
			$medicationbrand = isset($_POST['medicationbrand']) ? $_POST['medicationbrand'] : '';
			$medicationdose = isset($_POST['medicationdose']) ? $_POST['medicationdose'] : '';
			$medicationnumber = isset($_POST['medicationnumber']) ? $_POST['medicationnumber'] : '';
			$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';
			$pharmacyqty = isset($_POST['pharmacyqty']) ? $_POST['pharmacyqty'] : '';
			$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
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
						$medicationnumber = $setupsql->getlastmedicationcodenumber($instcode);
					}					
					$medication = strtoupper($medication);
					$medicationbrand = strtoupper($medicationbrand);
					$med = explode('-', $medication);
					$md = $med[0];
					// $mb = $med[1];
					// $mf = $med[2];
				//	$medication = $medication.' - '.$dosageformname.' - '.$medicationdose.' - '.$brandname ;
					$medication = $md.' - '.$dosageformname.' - '.$medicationdose.' - '.$medicationbrand ; 
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

					$totalqty = $storeqty + $pharmacyqty + $transferqty;
					$stockvalue = $totalqty*$cashprice;
					$edit = $medsql->editadminmedication($ekey,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$pharmacyqty,$storeqty,$transferqty,$mnum,$medicationbrand,$medicationdose,$totalqty,$stockvalue,$currentuser,$currentusercode,$instcode);
					$title = 'Edit Medication';
					if($edit == '0'){				
						$status = "error";					
						$msg = " $title $medication Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title $medication  Exist"; 					
					}else if($edit == '2'){
						$event= " $title $medication  successfully ";
						$eventcode= "204";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "$title $medication edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;
		// 11 JAN 2023 JOSPH ADORBOE
		case 'removemedications':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';	
			$category = isset($_POST['category']) ? $_POST['category'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$edit = $medsql->removemedications($ekey,$category,$currentuser,$currentusercode,$instcode);
					$title = 'Remove Medication ';
					if($edit == '0'){				
						$status = "error";					
						$msg = " $title $medication Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = " $title $medication Exist"; 					
					}else if($edit == '2'){
						$event= " $title $medication  successfully ";
						$eventcode= "203";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $medication Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}	
		break;

		
		// 25 DEC 2022  JOSPH ADORBOE
		case 'enablesetup':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$item = isset($_POST['item']) ? $_POST['item'] : '';	
			$category = isset($_POST['category']) ? $_POST['category'] : '';	
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$edit = $setupsql->enablesetup($ekey,$category,$currentuser,$currentusercode,$instcode);
					$title = 'Enable Setup';
					if($edit == '0'){				
						$status = "error";					
						$msg = " $title $item Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = " $title $item Exist"; 					
					}else if($edit == '2'){
						$event= " $title $item  successfully ";
						$eventcode= "223";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $item Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}	
		break;

		// 25 DEC 2022  JOSPH ADORBOE
		case 'disablesetup':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$item = isset($_POST['item']) ? $_POST['item'] : '';	
			$category = isset($_POST['category']) ? $_POST['category'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$edit = $setupsql->disablesetup($ekey,$category,$currentuser,$currentusercode,$instcode);
					$title = 'Disable Setup';
					if($edit == '0'){				
						$status = "error";					
						$msg = " $title $item Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = " $title $item Exist"; 					
					}else if($edit == '2'){
						$event= " $title $item  successfully ";
						$eventcode= "222";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $item Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}	
		break;


		// 13 MAY 2021 JOSPH ADORBOE
		case 'editmedication':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';	
			$dosageform = isset($_POST['dosageform']) ? $_POST['dosageform'] : '';
			$unit = isset($_POST['unit']) ? $_POST['unit'] : '';
			$restock = isset($_POST['restock']) ? $_POST['restock'] : '';
			$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
			$medicationbrand = isset($_POST['medicationbrand']) ? $_POST['medicationbrand'] : '';
			$medicationdose = isset($_POST['medicationdose']) ? $_POST['medicationdose'] : '';
			$medicationnumber = isset($_POST['medicationnumber']) ? $_POST['medicationnumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
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
						$medicationnumber = $medsql->getlastmedicationcodenumber($instcode);
					}					
					$medication = strtoupper($medication);
					$medicationbrand = strtoupper($medicationbrand);
					$med = explode('-', $medication);
					$md = $med[0];					
					$medication = $md.' - '.$dosageformname.' - '.$medicationdose.' - '.$medicationbrand ; 
					$edit = $medsql->editnewmedication($ekey,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$mnum,$medicationbrand,$medicationdose,$currentuser,$currentusercode,$instcode);
					$title = 'Edit Medication';
					if($edit == '0'){				
						$status = "error";					
						$msg = " $title $medication Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title $medication  Exist"; 					
					}else if($edit == '2'){
						$event= " $title $medication  successfully ";
						$eventcode= "204";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "$title $medication edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;	
			
	}	

?>
