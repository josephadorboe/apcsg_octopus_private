<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$alertmodel = isset($_POST['alertmodel']) ? $_POST['alertmodel'] : '';
	$dept = 'OPD';

	Global $instcode;
	
	// 20 FEB 2021 
	switch ($alertmodel)
	{
		
		
	}

	// 18 APR 2021 JOSEPH ADORBOE 
	function alerts($currentstaffpershift,$currentconsultationduration,$currentconsultationstart,$currentconsultationend){ ?>

		<?php if ($currentstaffpershift == '0'){ ?>
			<div class="alert alert-warning alert-dismissable">
		   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		   <i class="icon-exclamation-sign"></i><strong>WARNING! </strong> Please do Settings for Number of staff per shift.
		   </div>
	   <?php } ?>
	   <?php if ($currentconsultationduration == '1'){ ?>
			<div class="alert alert-warning alert-dismissable">
		   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		   <i class="icon-exclamation-sign"></i><strong>WARNING! </strong> Please do Settings duration per consultation .
		   </div>
	   <?php } ?>
	   <?php if ($currentconsultationstart == '0'){ ?>
			<div class="alert alert-warning alert-dismissable">
		   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		   <i class="icon-exclamation-sign"></i><strong>WARNING! </strong> Please do Settings start consultation time.
		   </div>
	   <?php } ?>
	   <?php if ($currentconsultationend == '0'){ ?>
			<div class="alert alert-warning alert-dismissable">
		   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		   <i class="icon-exclamation-sign"></i><strong>WARNING! </strong> Please do Settings end consultation time.
		   </div>
	   <?php } ?>

	<?php } 


?>
