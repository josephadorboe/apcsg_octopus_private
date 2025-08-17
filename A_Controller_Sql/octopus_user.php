<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 24 DEC 2024
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_users
	$usertable->getdoctorslov($instcode)
*/

class OctopusUserClass Extends Engine{
	public $logcount;

	// 4 APRIL 2019
	public function checkloginstatus(String $loginkey,String $userkey) : Int{		
		if(empty($loginkey) || empty($userkey)){			
			return $this->thefailed;			
		}else{			
			$sql= 'SELECT USER_CODE FROM octopus_users where USER_USERKEY = ? and USER_LOGINKEY  = ? and  USER_LOGINSTATE = ? ';
			$st = $this->db->Prepare($sql);
			$st->BindParam(1, $userkey);
			$st->BindParam(2, $loginkey);
			$st->BindParam(3, $this->theone);
			$st->execute();			
			if($st->rowcount() > $this->thezero){				
				return $this->theexisted;				
			}else{				
				return $this->thefailed;				
			}		
			
		}
		
	}

	// 02 JAN 2021
	public function update_switchuserlevel($ulevcode,$ulevname,$currentusercode,$instcode) : Int{		
		$sql = "UPDATE octopus_users SET USER_LEVEL = ?, USER_LEVELNAME = ? WHERE USER_CODE = ? AND USER_INSTCODE  = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $ulevcode);
		$st->BindParam(2, $ulevname);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $instcode);		
		$exe = $st->execute();		
		if($exe){
			$_SESSION['logcount'] = 3 ;
			return $this->thepassed;			
		}else{			
			return $this->thefailed;			
		}
	}

	// 22 NOV 2021 JOSEPH ADORBOE 
	public function getdoctorslov($instcode) : void
	{
		$one = '1';
		$sql = " SELECT USER_CODE, USER_FULLNAME FROM octopus_users WHERE  USER_INSTCODE = '$instcode' and USER_STATUS = '$one' AND USER_LEVEL = '5' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['USER_CODE'].'@@@'.$obj['USER_FULLNAME'].'">'.$obj['USER_FULLNAME'].' </option>';
		}
	}
	// 02 JAN 2021
	public function update_disable( String $userusername, String $currentusercode, String $currentuser, String $ekey, String $instcode) : Int{		
		$sql = "UPDATE octopus_users SET USER_STATUS = ?, USER_ACTORCODE = ? , USER_ACTOR = ?, USER_USERNAME = ? WHERE USER_CODE = ? AND USER_INSTCODE  = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thezero);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $userusername);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();		
		if($exe){			
			return $this->thepassed;			
		}else{			
			return $this->thefailed;			
		}
	}

	// 15 JAN 2025, 02 JAN 2021 , JOSEPH ADORBOE
	public function update_user($ekey,$fullname,$ulevcode,$ulevname,$slevcode,$slevname,$currentusercode,$currentuser,$instcode,$phonenumber,$altphonenumber,$useremailaddress) : int{		
		$sql = "UPDATE octopus_users SET USER_FULLNAME = ?, USER_LEVEL = ? ,  USER_LEVELNAME = ? , USER_ACTORCODE = ? , USER_ACTOR = ?, USER_SPEC = ? , USER_SPECCODE = ? ,USER_PHONENUM = ? ,USER_ALTPHONENUM = ? ,USER_EMAIL = ?  WHERE USER_CODE = ? AND USER_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $fullname);
		$st->BindParam(2, $ulevcode);
		$st->BindParam(3, $ulevname);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $slevname);
		$st->BindParam(7, $slevcode);
		$st->BindParam(8, $phonenumber);
		$st->BindParam(9, $altphonenumber);
		$st->BindParam(10, $useremailaddress);
		$st->BindParam(11, $ekey);
		$st->BindParam(12, $instcode);		
		$exe = $st->execute();		
		if($exe){			
			return $this->thepassed;	
		}else{			
			return $this->thefailed;			
		}
	}

	// 15 JAN 2025, 02 JAN 2021, JOSEPH ADORBOE
	public function update_resetpassword($pwd,$userusername,$currentusercode,$currentuser,$ekey,$instcode) : int{	
		$sql = "UPDATE octopus_users SET USER_PWD = ?, USER_ACTORCODE = ? , USER_ACTOR = ? , USER_USERNAME = ? , USER_STATUS = ? WHERE USER_CODE = ? AND USER_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $pwd);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $userusername);
		$st->BindParam(5, $this->theone);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();		
		if($exe){			
			return $this->thepassed;		
		}else{			
			return $this->thefailed;
		}
	}
	// 15 JAN 2025,  JOSEPH ADORBOE
    public function insert_newusers($form_key,$inputusername,$fullname,$pwd,$newuserkey,$currentusershortcode,$currentusercode,$currentuser,$instcode,$userlecode,$userlename,$currentuserinst,$specscode,$specsname,$phonenumber,$altphonenumber,$useremailaddress) : int{	
		$sqlstmt = ("SELECT USER_ID FROM octopus_users where USER_USERNAME = ? AND USER_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $inputusername);
		$st->BindParam(2, $instcode);
		$st->execute();		
		if($st->rowcount() > $this->thezero){			
			return $this->theexisted;
		}else{				
			$sqlstmt = "INSERT INTO octopus_users(USER_CODE,USER_USERNAME,USER_PWD,USER_FULLNAME,USER_INSTCODE,USER_SHORTCODE,USER_USERKEY,USER_ACTOR,USER_ACTORCODE,USER_LEVEL,USER_LEVELNAME,USER_INSTNAME,USER_SPEC,USER_SPECCODE,USER_PHONENUM,USER_ALTPHONENUM,USER_EMAIL) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $inputusername);
			$st->BindParam(3, $pwd);
			$st->BindParam(4, $fullname);
			$st->BindParam(5, $instcode);
			$st->BindParam(6, $currentusershortcode);
			$st->BindParam(7, $newuserkey);
			$st->BindParam(8, $currentuser);
			$st->BindParam(9, $currentusercode);
			$st->BindParam(10, $userlecode);
			$st->BindParam(11, $userlename);
			$st->BindParam(12, $currentuserinst);	
			$st->BindParam(13, $specsname);	
			$st->BindParam(14, $specscode);
			$st->BindParam(15, $phonenumber);
			$st->BindParam(16, $altphonenumber);
			$st->BindParam(17, $useremailaddress);		
			$exe = $st->execute();
			if($exe){				
				return $this->thepassed;		
			}else{				
				return $this->thefailed;				
			}	
		}
	}
	// 27 JAN 2025 , JSOEPH ADORBOE 
	public function querygetdisableuserlist($instcode) : String{
		$list = "SELECT USER_CODE,USER_USERNAME,USER_FULLNAME,USER_LEVEL,USER_SHORTCODE,USER_USERKEY,USER_LOGINKEY,USER_CHG,USER_SPEC,USER_LOGINSTATE,USER_INSTCODE,USER_INSTNAME,USER_LEVELNAME,USER_ACCESSLEVEL,USER_PHONENUM,USER_EMAIL,USER_SPECCODE,USER_ALTPHONENUM,USER_STATUS from octopus_users where  USER_INSTCODE ='$instcode' AND USER_STATUS = '0' ORDER BY USER_STATUS DESC, USER_FULLNAME ASC ";
		return $list;
	}

	// 27 JAN 2025 , JSOEPH ADORBOE 
	public function querygetuserlist($instcode) : String{
		$list = "SELECT USER_CODE,USER_USERNAME,USER_FULLNAME,USER_LEVEL,USER_SHORTCODE,USER_USERKEY,USER_LOGINKEY,USER_CHG,USER_SPEC,USER_LOGINSTATE,USER_INSTCODE,USER_INSTNAME,USER_LEVELNAME,USER_ACCESSLEVEL,USER_PHONENUM,USER_EMAIL,USER_SPECCODE,USER_ALTPHONENUM,USER_STATUS from octopus_users where  USER_INSTCODE ='$instcode' AND USER_STATUS = '1' ORDER BY USER_STATUS DESC, USER_FULLNAME ASC ";
		return $list;
	}

	// 24 DEC 2024, JOSEPH  ADORBOE
    public function Logout($userkey,$loginkey) : void {		
		if(!empty($userkey) && !empty($loginkey)) {			
			$nnd = '0';
			$ndk = '';
			$st = $this->db->prepare("UPDATE octopus_users SET USER_LOGINSTATE = ? , USER_LOGINKEY = ? WHERE USER_USERKEY = ? ");   
			$st->BindParam(1, $this->thezero);
			$st->BindParam(2, $ndk);
			$st->BindParam(3, $userkey);
			$st->execute();	
		}							
	}	

	// 24 DEC 2024, JOSEPH ADORBOE 
	Public function Updateuserloging($sqlresults, $loginkey) : int{
		$one = '1';
		$st = $this->db->prepare("UPDATE octopus_users SET USER_LOGINSTATE = ? , USER_LASTLOGINCHECK = ?, USER_LOGINKEY = ? WHERE USER_CODE = ? ");   
		$st->BindParam(1, $this->theone);
		$st->BindParam(2, $this->thedays);
		$st->BindParam(3, $loginkey);
		$st->BindParam(4, $sqlresults);
		$exe = $st->execute();
		if($exe){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}			
	}
	// 24 DEC 2024 ,  JOSEPH ADORBOE 
	public function processuserlogin($name, $pass) {				
		if(!empty($name) && !empty($pass)){			
			$pwd = md5($name.$pass);
			// echo $pwd ;
			// die;
			$st = $this->db->prepare("SELECT USER_CODE,USER_INSTCODE FROM octopus_users WHERE USER_USERNAME = ? AND USER_PWD = ? AND USER_STATUS = ? ");   
			$st->BindParam(1, $name);
			$st->BindParam(2, $pwd);
			$st->BindParam(3, $this->theone);				
			$ext = $st->execute();			
			if($ext){				
				if($st->rowCount() == $this->theone){					
					$obj = $st->fetch(PDO::FETCH_ASSOC);						
						$resultlog = $obj['USER_CODE'];	
						$_SESSION['usercode'] = $obj['USER_CODE'];
						$_SESSION['instcode'] = $obj['USER_INSTCODE'];
						$_SESSION['login'] = 1;										
				}else{
					$resultlog = $this->thefailed;
				}
			}else{
				$resultlog = $this->thefailed;
			}
			return $resultlog;
		}
	}
	// 15 JAN 2020, JOSEPH ADORBOE 
	public function getcurrentuserdetails(){
		if(empty($_SESSION['userdetails']) || $_SESSION['logcount'] == 3){
			
			$one = '1';
			$st = $this->db->prepare("SELECT USER_CODE,USER_USERNAME,USER_FULLNAME,USER_LEVEL,USER_SHORTCODE,USER_USERKEY,USER_LOGINKEY,USER_CHG,USER_SPEC,USER_LOGINSTATE,USER_INSTCODE,USER_INSTNAME,USER_LEVELNAME,USER_ACCESSLEVEL FROM octopus_users where USER_CODE = ? AND USER_STATUS = ? AND USER_INSTCODE = ?");   
			$st->BindParam(1, $_SESSION['usercode']);
			$st->BindParam(2, $one);
			$st->BindParam(3, $_SESSION['instcode']);
			$st->execute();
			if($st->rowcount()>0){
				$_SESSION['logcount'] = 1;
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			//       							0							1							2						3							4							5						6							7							8							9							10							11
			$_SESSION['userdetails'] = $obj['USER_CODE'].'@@@'.$obj['USER_USERNAME'].'@@@'.$obj['USER_FULLNAME'].'@@@'.$obj['USER_LEVEL'].'@@@'.$obj['USER_SHORTCODE'].'@@@'.$obj['USER_CHG'].'@@@'.$obj['USER_USERKEY'].'@@@'.$obj['USER_LOGINKEY'].'@@@'.$obj['USER_INSTCODE'].'@@@'.$obj['USER_LOGINSTATE'].'@@@'.$obj['USER_INSTNAME'].'@@@'.$obj['USER_LEVELNAME'].'@@@'.$obj['USER_ACCESSLEVEL'].'@@@'.$obj['USER_SPEC'];			
				return $_SESSION['userdetails'].'@@@'.$this->logcount ;			
			}else{				
				return '-1';				
			}			
		}else{
			$_SESSION['logcount'] = 2;
			return $_SESSION['userdetails'];
		}		
	} 
		
	
} 
	$usertable = new OctopusUserClass();
?>