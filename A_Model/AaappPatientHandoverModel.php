<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$nursepatienthandovermodel = htmlspecialchars(isset($_POST['nursepatienthandovermodel']) ? $_POST['nursepatienthandovermodel'] : '');
	
	// 27 JUNE 2023 
	switch ($nursepatienthandovermodel)
	{

		// 23 SEPT 2024, JOSEPH ADORBOE 
		case 'nursehandoveraddnew':
			$handovertitle = htmlspecialchars(isset($_POST['handovertitle']) ? $_POST['handovertitle'] : '');
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');
			$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
			$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');

			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($handovertitle) || empty($notes) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$handovertitle = strtoupper($handovertitle);
					$handovercode = rand(1,1000);
				//	$handovernotes = date('d M Y h:i:s a', strtotime($days))."\r\n".$notes;
					$sqlresults = $handovertable->insert_newhandovernotes($form_key,$handovercode,$day,$handovertitle,$notes,$type,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode);
					$action = "New Handover notes Added";							
					$result = $engine->getresults($sqlresults,$item=$handovertitle,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9769;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);  		 
				}
			}
		break;

		// 23 sept 2023, 1 JUL 2023 JOSEPH ADORBOE  
		case 'nursehandoveredit':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$handovertitle = htmlspecialchars(isset($_POST['handovertitle']) ? $_POST['handovertitle'] : '');
			$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
			$oldnotes = htmlspecialchars(isset($_POST['oldnotes']) ? $_POST['oldnotes'] : '');
			$oldshiftcode = htmlspecialchars(isset($_POST['oldshiftcode']) ? $_POST['oldshiftcode'] : '');
			$addnotes = htmlspecialchars(isset($_POST['addnotes']) ? $_POST['addnotes'] : '');
			$shiftnotes = htmlspecialchars(isset($_POST['shiftnotes']) ? $_POST['shiftnotes'] : '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($oldnotes) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{		
					$handovernotes = $shiftnotes;	
					if($currentshiftcode !== $oldshiftcode){
						$handovernotes = $addnotes."\r\n\r\n".$oldnotes;	
					}
					$sqlresults = $handovertable->edithandover($ekey,$handovertitle,$handovernotes,$currentusercode,$currentuser,$instcode);
					$action = "Edit Handover notes";							
					$result = $engine->getresults($sqlresults,$item=$handovertitle,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9768;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 				
				}
			}
		break;

		
			
	}
 
?>
