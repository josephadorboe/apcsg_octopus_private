<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class settings Extends Engine{
	
	public function Getinstutesettings($instcode){
		$sql = "SELECT * FROM octopus_admin_institution where CP_CODE = ? ";
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $instcode);
		$st->Execute();
		
		if($st->rowcount() > 0){
		
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$sets = $obj['CP_PAYSTATE'].'@@@'.$obj['CP_VITALSTATE'];
			
			return $sets;
			
		}else{
			
			return '-1';
			
		}
		
		
	}
	// 23 JULY 2018
	public function Getdentalservice($instcode){
		
		$nmt = '108';
		$sql = "SELECT SETSER_SERVICECODE FROM octopus_set_services WHERE SETSER_TYPECODE = ? AND  SETSER_INSTCODE = ?";
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $nmt);
		$st->BindParam(2, $instcode);
		$st->Execute();
		
		if($st->rowcount() > 0){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$value = $obj['SETSER_SERVICECODE'];
			return $value ;
			
		}else{
			
			return -1;
			
		}
		
		
	}
	
	
	public function Getadultservice($instcode){
		
		$nmt = '102';
		$sql = "SELECT SETSER_SERVICECODE FROM octopus_set_services WHERE SETSER_TYPECODE = ? AND  SETSER_INSTCODE = ?";
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $nmt);
		$st->BindParam(2, $instcode);
		$st->Execute();
		
		if($st->rowcount() > 0){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$value = $obj['SETSER_SERVICECODE'];
			return $value ;
			
		}else{
			
			return -1;
			
		}
		
		
	}
	
	
	public function Getchildservice($instcode){
		
		$nmt = '103';
		$sql = "SELECT SETSER_SERVICECODE FROM octopus_set_services WHERE SETSER_TYPECODE = ? AND  SETSER_INSTCODE = ?";
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $nmt);
		$st->BindParam(2, $instcode);
		$st->Execute();
		
		if($st->rowcount() > 0){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$value = $obj['SETSER_SERVICECODE'];
			return $value ;
			
		}else{
			
			return -1;
			
		}
		
		
	}
	
	
	public function Getreviewservice($instcode){
		
		$nmt = '104';
		$sql = "SELECT SETSER_SERVICECODE FROM octopus_set_services WHERE SETSER_TYPECODE = ? AND  SETSER_INSTCODE = ?";
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $nmt);
		$st->BindParam(2, $instcode);
		$st->Execute();
		
		if($st->rowcount() > 0){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$value = $obj['SETSER_SERVICECODE'];
			return $value ;
			
		}else{
			
			return -1;
			
		}
		
		
	}
	
	
	public function Getvitalsservice($instcode){
		
		$nmt = '106';
		$sql = "SELECT SETSER_SERVICECODE FROM octopus_set_services WHERE SETSER_TYPECODE = ? AND  SETSER_INSTCODE = ?";
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $nmt);
		$st->BindParam(2, $instcode);
		$st->Execute();
		
		if($st->rowcount() > 0){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$value = $obj['SETSER_SERVICECODE'];
			return $value ;
			
		}else{
			
			return -1;
			
		}
		
		
	}
	
	
	public function Getfirstaidservice($instcode){
		
		$nmt = '105';
		$sql = "SELECT SETSER_SERVICECODE FROM octopus_set_services WHERE SETSER_TYPECODE = ? AND  SETSER_INSTCODE = ?";
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $nmt);
		$st->BindParam(2, $instcode);
		$st->Execute();
		
		if($st->rowcount() > 0){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$value = $obj['SETSER_SERVICECODE'];
			return $value ;
			
		}else{
			
			return -1;
			
		}
		
		
	}
	
	public function Getnewfolderservice($instcode){
		
		$nmt = '101';
		$sql = "SELECT SETSER_SERVICECODE FROM octopus_set_services WHERE SETSER_TYPECODE = ? AND  SETSER_INSTCODE = ? ";
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $nmt);
		$st->BindParam(2, $instcode);
		$st->Execute();
		
		if($st->rowcount() > 0){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$value = $obj['SETSER_SERVICECODE'];
			return $value ;
			
		}else{
			
			return -1;
			
		}
		
		
	}
	
	
	 
}

