<?php
	REQUIRE_ONCE (INTFILE);	
	$patientconsultationreportmodel = isset($_POST['patientconsultationreportmodel']) ? $_POST['patientconsultationreportmodel'] : '';

	switch ($patientconsultationreportmodel)
	{

	// 21 FEB 2025,  1 DEC 2021 JOSPH ADORBOE
	case 'consultationreports': 			
		//	$complainsearch = isset($_POST['complainsearch']) ? $_POST['complainsearch'] : '';
			$statstype = isset($_POST['statstype']) ? $_POST['statstype'] : '';	
			$statsmonth = isset($_POST['statsmonth']) ? $_POST['statsmonth'] : '';	
			$reportdate = isset($_POST['reportdate']) ? $_POST['reportdate'] : '';
			$diagnosissearch = trim(isset($_POST['diagnosissearch']) ? $_POST['diagnosissearch'] : '');
			$diagnosisfromdate = isset($_POST['diagnosisfromdate']) ? $_POST['diagnosisfromdate'] : '';
			$diagnosistodate = isset($_POST['diagnosistodate']) ? $_POST['diagnosistodate'] : '';
			$fromdate = isset($_POST['fromdate']) ? $_POST['fromdate'] : '';
			$todate = isset($_POST['todate']) ? $_POST['todate'] : '';		
			$sdoctor = isset($_POST['sdoctor']) ? $_POST['sdoctor'] : '';
			$complainsearch = isset($_POST['complainsearch']) ? $_POST['complainsearch'] : '';		
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){			
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($statstype)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{					
							if($statstype == 1){
								if(empty($fromdate) ||empty($todate)){
									$status = "error";
									$msg = "Required Fields Month cannot be empty ";
								}else{
									$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
									$msql->passingvalues($pkey=$form_key,$value);					
									$url = "consultationreport?$form_key";
									$engine->redirect($url);	
								}
							}else if($statstype == 2){
								if(empty($sdoctor) ||empty($fromdate) ||empty($todate)){
									$status = "error";
									$msg = "All Fields are Required";
								}else{
									$value = $statstype.'@@@'.$fromdate.'@@@'.$todate.'@@@'.$sdoctor;
									$passvaluestable->passingvalues($pkey=$form_key,$value);					
									$url = "consultationreportdoctor?$form_key";
									$engine->redirect($url);	
								}								
							}else if($statstype == 5){
								if(empty($diagnosissearch) ||empty($diagnosisfromdate) ||empty($diagnosistodate)){
									$status = "error";
									$msg = "All Fields are Required";
								}else{
									$value = $statstype.'@@@'.$diagnosisfromdate.'@@@'.$diagnosistodate.'@@@'.$diagnosissearch;
									$passvaluestable->passingvalues($pkey=$form_key,$value);					
									$url = "consultationreportdiagnosis?$form_key";
									$engine->redirect($url);	
								}
							}else if($statstype == 6){
								if(empty($complainsearch) ||empty($fromdate) ||empty($todate)){
									$status = "error";
									$msg = "All Fields are Required";
								}else{
									$value = $statstype.'@@@'.$fromdate.'@@@'.$todate.'@@@'.$complainsearch;
									$passvaluestable->passingvalues($pkey=$form_key,$value);					
									$url = "consultationreportcomplain?$form_key";
									$engine->redirect($url);	
								}
							}
						}
					}
			}
	
	break;

	} 
?>
