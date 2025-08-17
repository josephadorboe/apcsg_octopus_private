<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$setupbatchesmodel = htmlspecialchars(isset($_POST['setupbatchesmodel']) ? $_POST['setupbatchesmodel'] : '');
	
	// 2 JAN 2023 JOSEPH ADORBOE 
	switch ($setupbatchesmodel)
	{
	
		// 21 MAR 2024, 2 JAN 2023, JOSPH ADORBOE
		case 'editbatchsetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$qtysupplied = htmlspecialchars(isset($_POST['qtysupplied']) ? $_POST['qtysupplied'] : '');	
			$qtyleft = htmlspecialchars(isset($_POST['qtyleft']) ? $_POST['qtyleft'] : '');
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');
			$expiry = htmlspecialchars(isset($_POST['expiry']) ? $_POST['expiry'] : '');
			$batchdescription = htmlspecialchars(isset($_POST['batchdescription']) ? $_POST['batchdescription'] : '');
			$batchnumber = htmlspecialchars(isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($qtysupplied) || empty($expiry)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$xp = explode("-",$expiry);
					$fday = $xp[0];
					$fmonth = $xp[1];
					$fyear = $xp[2];
					$expiry = $fyear.'-'.$fmonth.'-'.$fday;
															
					$sqlresults = $batchestable->editbatch($batchcode=$ekey,$qtyleft,$batchdescription,$expiry,$qtysupplied,$currentusercode,$currentuser,$instcode);					
					if($sqlresults == '2'){
						$bat = $stockadjustmenttable->editstockadjustmentbybatchcode($batchcode,$qtysupplied,$expiry,$currentuser,$currentusercode,$instcode);
						$ep = $expirytable->editexpiry($batchcode,$qtysupplied,$expiry,$currentuser,$currentusercode,$instcode);
						if($ep == '2' && $bat == '2'){
							$sqlresults ='2';
						}else{
							$sqlresults == '0';
						}
					}
					$action = "Edit Batch $batchnumber - ";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9879;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}	
		break;

		// 2 JAN 2024,  JOSPH ADORBOE
		case 'enablebatchsetup':
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
					$sqlresults = $batchestable->enablebatch($batchcode=$ekey,$instcode);					
					$action = "Enable Batch";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9877;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}	
		break;

		// 2 JAN 2024 JOSPH ADORBOE
		case 'disablebatchsetup':
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
					$sqlresults = $batchestable->disablebatch($batchcode=$ekey,$instcode);					
					$action = "Disable Batch";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9878;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}
			}	
		break;

		// 22 MAR 2024, 2 JAN 2024,  JOSEPH ADORBOE 
		case 'addnewbatchsetup':			
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');		
			$qtysupplied = htmlspecialchars(isset($_POST['qtysupplied']) ? $_POST['qtysupplied'] : '');	
			$qtyleft = htmlspecialchars(isset($_POST['qtyleft']) ? $_POST['qtyleft'] : '');
			$batchcategory = htmlspecialchars(isset($_POST['batchcategory']) ? $_POST['batchcategory'] : '');
			$expire = htmlspecialchars(isset($_POST['expire']) ? $_POST['expire'] : '');
			$batchdescription = htmlspecialchars(isset($_POST['batchdescription']) ? $_POST['batchdescription'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($itemcode)  || empty($item)  || empty($qtysupplied)  || empty($qtyleft) || empty($expire) || empty($batchdescription)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$adnumber = rand(1,100);
					$batchnumber = 'BA'.date('His').rand(10,99);
					$batchcode = md5(microtime());	
					$xp = explode("-",$expire);
					$fday = $xp[0];
					$fmonth = $xp[1];
					$fyear = $xp[2];
					$expire = $fyear.'-'.$fmonth.'-'.$fday;
					$sqlresults = $batchestable->addnewbatches($batchcode,$batchnumber,$days,$itemcode,$itemname=$item,$category=$batchcategory,$qtysupplied,$qtyleft,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);			
					$action = "Add Batch $batchnumber -";
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9876;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}	
		break;
				

		// 2 JAN 2024,  JOSEPH ADORBOE 
		case 'addnewconsumablebatch':			
			$consumables = isset($_POST['consumables']) ? $_POST['consumables'] : '';
			$qtysupplied = htmlspecialchars(isset($_POST['qtysupplied']) ? $_POST['qtysupplied'] : '');	
			$qtyleft = htmlspecialchars(isset($_POST['qtyleft']) ? $_POST['qtyleft'] : '');
			$batchcategory = htmlspecialchars(isset($_POST['batchcategory']) ? $_POST['batchcategory'] : '');
			$expire = htmlspecialchars(isset($_POST['expire']) ? $_POST['expire'] : '');
			$batchdescription = htmlspecialchars(isset($_POST['batchdescription']) ? $_POST['batchdescription'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($consumables)  || empty($qtysupplied)  || empty($qtyleft)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$xp = explode("-",$expire);
					$fday = $xp[0];
					$fmonth = $xp[1];
					$fyear = $xp[2];
					$expire = $fyear.'-'.$fmonth.'-'.$fday;

					foreach ($consumables as $key) {
						$compl = explode('@@@', $key);
						$itemcode = $compl[0];
						$item = $compl[1];					
						
					$adnumber = rand(1,100);
					$batchnumber = 'BA'.date('His').rand(10,99);
					$batchcode = md5(microtime());	
					
					$sqlresults = $batchestable->addnewbatches($batchcode,$batchnumber,$days,$itemcode,$item,$batchcategory,$qtysupplied,$qtyleft,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);			
					$action = "Add Batch $batchnumber -";
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9875;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					}			
				}
			}	
		break;

		// 22 MAR 2024, 2 JAN 2024,  JOSEPH ADORBOE 
		case 'addnewgeneralitemsbatch':			
			$generalitems = isset($_POST['generalitems']) ? $_POST['generalitems'] : '';
			$qtysupplied = htmlspecialchars(isset($_POST['qtysupplied']) ? $_POST['qtysupplied'] : '');	
			$qtyleft = htmlspecialchars(isset($_POST['qtyleft']) ? $_POST['qtyleft'] : '');
			$batchcategory = htmlspecialchars(isset($_POST['batchcategory']) ? $_POST['batchcategory'] : '');
			$expire = htmlspecialchars(isset($_POST['expire']) ? $_POST['expire'] : '');
			$batchdescription = htmlspecialchars(isset($_POST['batchdescription']) ? $_POST['batchdescription'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($generalitems)  || empty($qtysupplied)  || empty($qtyleft)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$xp = explode("-",$expire);
					$fday = $xp[0];
					$fmonth = $xp[1];
					$fyear = $xp[2];
					$expire = $fyear.'-'.$fmonth.'-'.$fday;	

					foreach ($generalitems as $key) {
						$compl = explode('@@@', $key);
						$itemcode = $compl[0];
						$item = $compl[1];		
						
					$adnumber = rand(1,100);
					$batchnumber = 'BA'.date('His').rand(10,99);
					$batchcode = md5(microtime());

					$sqlresults = $batchestable->addnewbatches($batchcode,$batchnumber,$days,$itemcode,$item,$batchcategory,$qtysupplied,$qtyleft,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);			
					$action = "Add Batch $batchnumber -";
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9830;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					}			
				}
			}	
		break;

		// 22 MAR 2024, 2 JAN 2024,  JOSEPH ADORBOE 
		case 'addnewdevicebatch':			
			$devices = isset($_POST['devices']) ? $_POST['devices'] : '';
			$qtysupplied = htmlspecialchars(isset($_POST['qtysupplied']) ? $_POST['qtysupplied'] : '');	
			$qtyleft = htmlspecialchars(isset($_POST['qtyleft']) ? $_POST['qtyleft'] : '');
			$batchcategory = htmlspecialchars(isset($_POST['batchcategory']) ? $_POST['batchcategory'] : '');
			$expire = htmlspecialchars(isset($_POST['expire']) ? $_POST['expire'] : '');
			$batchdescription = htmlspecialchars(isset($_POST['batchdescription']) ? $_POST['batchdescription'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($devices)  || empty($qtysupplied)  || empty($qtyleft)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					foreach ($devices as $key) {
						$compl = explode('@@@', $key);
						$itemcode = $compl[0];
						$item = $compl[1];	

					$batchnumber = 'BA'.date('His').rand(10,99);
					$batchcode = md5(microtime());	
					$xp = explode("-",$expire);
					$fday = $xp[0];
					$fmonth = $xp[1];
					$fyear = $xp[2];
					$expire = $fyear.'-'.$fmonth.'-'.$fday;
					$sqlresults = $batchestable->addnewbatches($batchcode,$batchnumber,$days,$itemcode,$item,$batchcategory,$qtysupplied,$qtyleft,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);			
					$action = "Add Batch $batchnumber -";
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9874;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					}			
				}
			}	
		break;

		// 2 JAN 2024,  JOSEPH ADORBOE 
		case 'addnewmedicationbatch':			
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
			$qtysupplied = htmlspecialchars(isset($_POST['qtysupplied']) ? $_POST['qtysupplied'] : '');	
			$qtyleft = htmlspecialchars(isset($_POST['qtyleft']) ? $_POST['qtyleft'] : '');
			$batchcategory = htmlspecialchars(isset($_POST['batchcategory']) ? $_POST['batchcategory'] : '');
			$expire = htmlspecialchars(isset($_POST['expire']) ? $_POST['expire'] : '');
			$batchdescription = htmlspecialchars(isset($_POST['batchdescription']) ? $_POST['batchdescription'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($medication)  || empty($qtysupplied)  || empty($qtyleft)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$xp = explode("-",$expire);
					$fday = $xp[0];
					$fmonth = $xp[1];
					$fyear = $xp[2];
					$expire = $fyear.'-'.$fmonth.'-'.$fday;

					foreach ($medication as $key) {
						$compl = explode('@@@', $key);
						$itemcode = $compl[0];
						$item = $compl[1];					
						
					$batchnumber = 'BA'.date('His').rand(10,99);
					$batchcode = md5(microtime());	
					
					$sqlresults = $batchestable->addnewbatches($batchcode,$batchnumber,$days,$itemcode,$item,$batchcategory,$qtysupplied,$qtyleft,$batchdescription,$expire,$currentuser,$currentusercode,$instcode);			
					$action = "Add Batch $batchnumber - ";
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9873;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					}			
				}
			}	
		break;
			
	}

	// 16 APR 2024, JOSEPH ADORBOE 
	function batchessubmenu(){ ?>	
				<div class="btn-group mt-2 mb-2">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					Sub Menu<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#" data-toggle="modal" data-target="#largeModalconsumables">Consumables </a></li>
					<li><a href="#" data-toggle="modal" data-target="#largeModaldevices">Device </a></li>
					<li><a href="#" data-toggle="modal" data-target="#largeModalmedications">Medications</a></li>
					<li><a href="#" data-toggle="modal" data-target="#largeModalgeneralitems">General Items </a></li>
				</ul>
			</div>	
		<?php } 
	

?>
