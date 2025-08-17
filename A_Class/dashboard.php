<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */	
class dashboard Extends Engine{
	
	// 26 JUNE 2018
	public function Getpatientqueue($instcode,$nowday){		
		$sql = 'select distinct REQU_VISITCODE from octopus_patient_servicerequest where REQU_DATE = ? and REQU_INSTCODE = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nowday);
		$st->BindParam(2, $instcode);
		$st->Execute();		
		$value =  $st->rowcount();		
		return $value ;	
	}
	
	// 24 JUNE 2018
	public function Gettodaypatient($instcode,$nowday){
		
		$sql = 'select * from octopus_patients where PATIENT_DATE = ? and PATIENT_INSTCODE = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nowday);
		$st->BindParam(2, $instcode);
		$st->Execute();
		
		$value =  $st->rowcount();
		
		return $value ;
	
	}
	
	// 24 june 2018
	public function gettodayvisit($instcode,$nowday){
		
		$sql = 'Select VISIT_ID from octopus_patient_visit WHERE VISIT_DATE = ? AND VISIT_INSTCODE = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nowday);
		$st->BindParam(2, $instcode);
		$st->Execute();
		
		$value = $st->rowcount();
		
		return $value;
	}
	
	
	// 24 june 2018
	public function gettotalpatient($instcode){
		$alive = '1';
		$sql = 'Select PATIENT_ID from octopus_patients WHERE PATIENT_STATUS = ? AND PATIENT_INSTCODE = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $alive);
		$st->BindParam(2, $instcode);
		$st->Execute();
		
		$value = $st->rowcount();
		
		return $value;
	}
	
	
	
	// 24 JUNE 2017
	public function Getpatientnextnumber($instcode,$year){
		$sql = "SELECT PS_SERIAL FROM octopus_patient_serial where PS_YEAR = ?  and PS_INSTCODE = ?";
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $year);
		$st->BindParam(2, $instcode);
		$st->Execute();
		
		if($st->rowcount() > 0){
		
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$sets = $obj['PS_SERIAL'];
			return $sets;
			
		}else{
			
			return '-1';
			
		}
		
		
	}
	
	 
}

