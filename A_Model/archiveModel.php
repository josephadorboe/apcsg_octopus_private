<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$archivemodel = isset($_POST['archivemodel']) ? $_POST['archivemodel'] : '';
	
	// 13 MAR 2022 JOSEPH ADORBOE  
switch ($archivemodel)
{
	
	// 13 MAR 2022 JOSEPH ADORBOE 
	case 'archivesearch': 
		$searchfilter = isset($_POST['searchfilter']) ? $_POST['searchfilter'] : '';
		$searchitem = isset($_POST['searchitem']) ? $_POST['searchitem'] : '';
		$prescriptiondate = isset($_POST['prescriptiondate']) ? $_POST['prescriptiondate'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){			
			if(empty($searchfilter) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{					
				if($searchfilter == '1'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "prescriptionarchive?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '2'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "prescriptionarchive?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '3'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "prescriptionarchive?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '4'){
					if(empty($prescriptiondate) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$cdate = explode('/', $prescriptiondate);
						$mmd = $cdate[0];
						$ddd = $cdate[1];
						$yyy = $cdate[2];
						$prescriptiondate = $yyy.'-'.$mmd.'-'.$ddd;

						$value = $searchfilter.'@@@'.$prescriptiondate;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "prescriptionarchive?$form_key";
						$engine->redirect($url);
                    }
				}					
			}			
		}

	break;

	// 14 AUG 2021 2021 JOSEPH ADORBOE 
	case 'deviceprescriptionarchivesearch': 

		$searchfilter = isset($_POST['searchfilter']) ? $_POST['searchfilter'] : '';
		$searchitem = isset($_POST['searchitem']) ? $_POST['searchitem'] : '';
		$prescriptiondate = isset($_POST['prescriptiondate']) ? $_POST['prescriptiondate'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){			
			if(empty($searchfilter) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{					
				if($searchfilter == '1'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "deviceprescriptionarchive?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '2'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "deviceprescriptionarchive?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '3'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "deviceprescriptionarchive?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '4'){
					if(empty($prescriptiondate) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$cdate = explode('/', $prescriptiondate);
						$mmd = $cdate[0];
						$ddd = $cdate[1];
						$yyy = $cdate[2];
						$prescriptiondate = $yyy.'-'.$mmd.'-'.$ddd;

						$value = $searchfilter.'@@@'.$prescriptiondate;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "deviceprescriptionarchive?$form_key";
						$engine->redirect($url);
                    }
				}					
			}			
		}

	break;
	
}


?>
