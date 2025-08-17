<?php
	REQUIRE_ONCE (INTFILE);
	
	$storesnmodel = isset($_POST['storesnmodel']) ? $_POST['storesnmodel'] : '';

switch ($storesnmodel)
{
	

    // 16 APR 2022 JOSEPH ADORBOE 
	case 'restockrequestitems': 
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($form_number)  ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{		

				// assign services
                if (!empty($_POST["scheckboxserv"])) {
                    foreach ($_POST["scheckboxserv"] as $restockitem) {
                        $req = explode('@@@', $restockitem);
                        $requestcode = $req['0'];
                        $itemcode = $req['1'];
                        $itemqty = $req['2'];
                        $itemtype = $req['3'];                       
                        $items = $storessql->restock($requestcode, $itemcode, $itemqty, $itemtype, $instcode, $days, $currentusercode, $currentuser);
                    }                

                    if ($items == '0') {
                        $status = "error";
                        $msg = "Restock Unsuccessful";
                    } elseif ($items == '1') {
                        $status = "error";
                        $msg = "Restock Exist";
                    } elseif ($items == '2') {
                        $event= " Restocks : $form_key $currentusercode has been saved successfully ";
                        $eventcode= 70;
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = "Restock  Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail Failed!";
                        }
                    } else {
                        $status = "error";
                        $msg = "Add Facility Unsuccessful ";
                    }
                }else{
					$status = "error";
					$msg = "Add restock Unsuccessful. No item selected  ";
				}
			}
		}
	break;
    
	// 16 APR 2022  JOSEPH ADORBOE  
	case 'removerequestionitems':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$requestedqty = isset($_POST['requestedqty']) ? $_POST['requestedqty'] : '';
        $item = isset($_POST['item']) ? $_POST['item'] : '';
		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($requestedqty) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$editpricing = $storessql->removerequestitems($ekey,$currentusercode,$currentuser,$instcode);
				$title = 'Remove Requisition';
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title for $item Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title for $item Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title $item  successfully ";
					$eventcode= "74";
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
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;

    // 16 APR 2022  JOSEPH ADORBOE  
	case 'editrequestionitems':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$requestedqty = isset($_POST['requestedqty']) ? $_POST['requestedqty'] : '';
        $item = isset($_POST['item']) ? $_POST['item'] : '';
		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($requestedqty) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$editpricing = $storessql->editrequestitems($ekey,$requestedqty,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Requisition';
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title for $item Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title for $item Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title $item  successfully ";
					$eventcode= "74";
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
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;



	// 16 APR  2022 JOSEPH ADORBOE 
	case 'addrequestitems': 		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$desc = isset($_POST['desc']) ? $_POST['desc'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($form_number)  ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{		

				// assign services
                if (!empty($_POST["scheckboxserv"])) {
					$requestionnumber = $coder->getstoresrequestionnumber($instcode);
                    foreach ($_POST["scheckboxserv"] as $key => $value) {
						$requiredqty =$_POST['requriedqty'][$key];
						
                        $items = explode('@@@', $value);
                        $itemcode = $items['0'];
                        $itemname = $items['1'];
                        $itemqty = $items['2'];
                    	$itemnumber = $items['3'];  
                        $type = $items['4']; 
                        $requestitemcode = md5(microtime());
                        $itemrequested = $storessql->saverequestions($requestitemcode,$requestionnumber, $itemcode, $itemname, $itemnumber, $itemqty, $requiredqty,$type, $instcode, $desc,$day, $currentusercode, $currentuser);
                    }
                    if ($itemrequested == '0') {
                        $status = "error";
                        $msg = "Request $itemname Unsuccessful";
                    } elseif ($itemrequested == '1') {
                        $status = "error";
                        $msg = "Request $itemname";
                    } elseif ($itemrequested == '2') {
                        $event= " Request $itemname  $requestitemcode has been saved successfully ";
                        $eventcode= 70;
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = "Request $itemname Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail Failed!";
                        }
                    } else {
                        $status = "error";
                        $msg = "Add item Unsuccessful ";
                    }
                }else{
					$status = "error";
					$msg = "Add item  Unsuccessful. No item selected  ";
				}
			}
		}
	break;    
}
 

?>
