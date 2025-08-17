<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 05 APR 2018
 */
class userlogs Extends Engine{
	
	// 05 APR 2018
	public function userlog($typecode,$userlevel,$logactivity,$currentusername,$currentusercode,$currentuser,$days,$instcode){
		
		$sql = "INSERT INTO octopus_userlog (USLOG_USERCODE,USLOG_USERNAME,USLOG_FULLNAME,USLOG_LOGTYPECODE,USLOG_LEVEL,USLOG_DESC,USLOG_DATE,USLOG_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->Prepare($sql);
		$st->Bindparam(1, $currentusercode);
		$st->Bindparam(2, $currentusername);
		$st->Bindparam(3, $currentuser);
		$st->Bindparam(4, $currentusercode);
		$st->Bindparam(5, $typecode);
		$st->Bindparam(6, $userlevel);
		$st->Bindparam(7, $logactivity);
		$st->Bindparam(8, $days);
		$st->Bindparam(9, $instcode);
		$st->execute();
		
	}
	
	 
}

