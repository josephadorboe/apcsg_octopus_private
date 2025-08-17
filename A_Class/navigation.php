<?php
/*
AUTHOR: JOSEPH ADORBOE
DATE: 30 MAR 2023
PURPOSE: nagigation class 
*/

class navigation Extends Engine{

    // 30 MAR 2023 JOSEPH ADORBOE 
	public function getclaimssubmen(){          
		echo 
        '<a href="manageclaims" class="btn btn-primary">Manage Claims</a>
        <a href="claimbilling__manageprocessedclaimsmonthly" class="btn btn-secondary">Processed Claims Monthly</a>
        <a href="claimbilling__manageprocessedclaimsscheme" class="btn btn-warning">Processed Claims Scheme</a>
        <a href="claimbilling__manageclaimsreports?1" class="btn btn-info">Claims Reports</a>';
	}

	// 30 MAR 2023 JOSEPH ADORBOE 
	public function getreturnmenu($returncount){
        $pc = explode('@' , $returncount);
		$returnmedicationcount = $pc[0];
		$returndevicecount = $pc[1];
		$returnprocedurecount = $pc[2];
		$returnservicecount = $pc[3];
		$returninvestigationcount = $pc[4];
   
		echo '<a href="cashier__managerreturns" class="btn btn-primary">Medication <span>'.$returnmedicationcount.'</span>	</a>	
        <a href="cashier__managereturnsdevices" class="btn btn-secondary">Devices <span> '.$returndevicecount.' </span></a>	
        <a href="cashier__managereturnsprocedures" class="btn btn-success">Procedures <span> '.$returnprocedurecount.' </span></a>
        <a href="cashier__managereturnservice" class="btn btn-warning">Service <span> '. $returnservicecount.' </span></a>	
        <a href="cashier__managereturninvestigations" class="btn btn-info">Investigations <span> '.$returninvestigationcount.' </span></a>	
        <a href="#?1" class="btn btn-light">Return  Reports</a>	';
	}

    

    
	
}
