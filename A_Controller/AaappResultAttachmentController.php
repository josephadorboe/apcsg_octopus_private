<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 5 JULY 2025
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

    class ResultAttachmentController Extends Engine
    {	        
        // 5 JULY 2025,  23 MAY 2021   JOSEPH ADORBOE
        public function attachepatientresults($ekey,$form_key,$patientnumbers,$patient,$patientcode,$day,$days,$requestcode,$testscode,$tests,$finame,$currentusercode,$currentuser,$instcode){		
            $sqlstmt = " Select RES_ID from octopus_patients_investigationrequest where MIV_CODE = ? and MIV_STATE != ? ";
            $st = $this->db->prepare($sqlstmt);
            $st->BindParam(1, $ekey);
            $st->BindParam(2, $this->theseven);
            if($sqlstmt){
                if($st->rowcount() > 0 ){
                    return $this->theexisted;
                }else{
                    $sqlstmt = "INSERT INTO octopus_patients_attachedresults(RES_CODE,RES_PATIENTCODE,RES_PATIENTNUMBER,RES_PATIENT,RES_DATE,RES_DATETIME,RES_REQUESTCODE,RES_TESTCODE,RES_TEST,RES_FILE,RES_ACTOR,RES_ACTORCODE,RES_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                    $st = $this->db->prepare($sqlstmt);   
                    $st->BindParam(1, $form_key);
                    $st->BindParam(2, $patientcode);
                    $st->BindParam(3, $patientnumbers);
                    $st->BindParam(4, $patient);
                    $st->BindParam(5, $day);
                    $st->BindParam(6, $days);
                    $st->BindParam(7, $requestcode);
                    $st->BindParam(8, $testscode);
                    $st->BindParam(9, $tests);
                    $st->BindParam(10, $finame);
                    $st->BindParam(11, $currentuser);
                    $st->BindParam(12, $currentusercode);
                    $st->BindParam(13, $instcode);
                    $exe = $st->execute();		
                    if($exe){                      							
                        $sql = "UPDATE octopus_patients_investigationrequest SET MIV_ATTACHED = ? , MIV_RESULTDATE = ?, MIV_RESULTACTOR = ?, MIV_RESULTACTORCODE = ?, MIV_STATE = ?, MIV_ATTACHEDFILE = ?, MIV_COMPLETE = ? WHERE MIV_REQUESTCODE = ? ";
                        $st = $this->db->prepare($sql);
                        $st->BindParam(1, $this->thetwo);
                        $st->BindParam(2, $days);
                        $st->BindParam(3, $currentuser);
                        $st->BindParam(4, $currentusercode);
                        $st->BindParam(5, $this->theseven);
                        $st->BindParam(6, $finame);
                        $st->BindParam(7, $this->thetwo);
                        $st->BindParam(8, $requestcode);
                        $ups = $st->Execute();	
                        if($ups){
                            return $this->thepassed;
                        }else{
                            return $this->thefailed;
                        }			
                    }else{			
                        return $this->thefailed;			
                    }				
                }
            }else{
                return $this->thefailed;
            }			

        }

    } 

    $resultattachmentcontroller =  new ResultAttachmentController();
?>