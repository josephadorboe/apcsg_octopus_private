<?php
	REQUIRE_ONCE (CONNECTIONFILE);
	REQUIRE_ONCE (ENGINEFILE);
	REQUIRE_ONCE (CONTROLLERSQLFOLDER.'octopus_userformlog.php');
	REQUIRE_ONCE (CONTROLLERSQLFOLDER.'octopus_user.php');
	REQUIRE_ONCE (CONTROLLERSQLFOLDER.'octopus_usereventlog.php');
	REQUIRE_ONCE (LOGINFOLDER.'A_LoginModel.php');
	
	if(empty($msg)){	
		$msg = $status = '';
	}  
    
	function msgBox($msg,$status){
		if(!empty($status)){
			
			if($status == "success"){
				echo '
				<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				echo '<i class="icon-exclamation-sign"></i><strong>SUCCESS!</strong> '.$msg.'';
				}
				
			if ($status == "error"){
					echo '<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				echo '<i class="icon-exclamation-sign"></i><strong>ERROR! </strong> '.$msg.'';
			}
			if ($status == "warning"){
					echo ' <div class="alert alert-warning alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				echo '<i class="icon-exclamation-sign"></i><strong>WARNING! </strong> '.$msg.'';
			}
			if ($status == "info"){
					echo ' <div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				echo '<i class="icon-exclamation-sign"></i><strong>INFO! </strong> '.$msg.'';
			}
			echo ' </div>';
		}
   }