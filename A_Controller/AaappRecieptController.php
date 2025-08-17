<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 22 JUNE 2025
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/


class ReceiptController Extends Engine
{

	// 30 OCT 2021  2021  JOSEPH ADORBOE
	public function generatecopaymentreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalgeneratedamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$billingcode)
	{		
		$sqlstmt = ("SELECT BP_ID FROM octopus_patients_reciept where BP_CODE = ? AND BP_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
        if ($details) {
            if ($st->rowcount() =='0') {
                $sql = ("INSERT INTO octopus_patients_reciept (BP_CODE,BP_DATE,BP_PATIENTCODE,BP_PATIENTNUMBER,BP_PATIENT,BP_BILLCODE,BP_DESC,BP_SHIFTCODE,BP_SHIFT,BP_CASHIERTILLSCODE,BP_SCHEME,BP_SCHEMCODE,BP_VISITCODE,BP_TOTAL,BP_AMTPAID,BP_ACTORCODE,BP_ACTOR,BP_INSTCODE,BP_CHANGE,BP_RECIEPTNUMBER,BP_METHOD,BP_METHODCODE,BP_STATE,BP_PHONENUMBER,BP_CHEQUENUMBER,BP_INSURANCEBAL,BP_BANKSCODE,BP_BANKS,BP_DT,BP_BILLINGCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $form_key);
                $st->BindParam(2, $day);
                $st->BindParam(3, $patientcode);
                $st->BindParam(4, $patientnumber);
                $st->BindParam(5, $patient);
                $st->BindParam(6, $billcode);
                $st->BindParam(7, $remarks);
                $st->BindParam(8, $currentshiftcode);
                $st->BindParam(9, $currentshift);
                $st->BindParam(10, $cashiertillcode);
                $st->BindParam(11, $payname);
                $st->BindParam(12, $paycode);
                $st->BindParam(13, $visitcode);
                $st->BindParam(14, $totalgeneratedamount);
                $st->BindParam(15, $amountpaid);
                $st->BindParam(16, $currentusercode);
                $st->BindParam(17, $currentuser);
                $st->BindParam(18, $instcode);
                $st->BindParam(19, $chang);
                $st->BindParam(20, $receiptnumber);
                $st->BindParam(21, $paymeth);
                $st->BindParam(22, $paymethcode);
                $st->BindParam(23, $state);
                $st->BindParam(24, $phonenumber);
                $st->BindParam(25, $chequenumber);
                $st->BindParam(26, $insurancebal);
                $st->BindParam(27, $bankcode);
                $st->BindParam(28, $bankname);
				$st->BindParam(29, $days);
				$st->BindParam(30, $billingcode);
                $genreceipt = $st->execute();
                if ($genreceipt) {
                    $a = '2';
                    $b = '3';
                    $c = '1';
                
                    $sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PAYDATE = ?, B_RECIPTNUM = ?, B_PAYACTOR = ?, B_PAYACTORCODE = ? , B_PAYSHIFTCODE = ? , B_PAYSHIFT = ?, B_COMPLETE = ?, B_PAYMETHODCODE = ?, B_PAYMETHOD = ? WHERE B_VISITCODE = ? AND B_STATE = ? ");
                    $st = $this->db->prepare($sql);
                    $st->BindParam(1, $this->thetwo);
                    $st->BindParam(2, $this->thethree);
                    $st->BindParam(3, $day);
                    $st->BindParam(4, $form_key);
                    $st->BindParam(5, $currentuser);
                    $st->BindParam(6, $currentusercode);
                    $st->BindParam(7, $currentshiftcode);
                    $st->BindParam(8, $currentshift);
                    $st->BindParam(9, $this->thetwo);
                    $st->BindParam(10, $paycode);
                    $st->BindParam(11, $payname);
                    $st->BindParam(12, $visitcode);
                    $st->BindParam(13, $this->thetwo);
                    //	$st->BindParam(14, $billcode);
                    $updtebilitems = $st->execute();
                    if ($updtebilitems) {
                        $vt = 2 ;
                        $sql = ("UPDATE octopus_patients_bills SET BILL_RECEIPTNUMBER = ?, BILL_ACTOR = ?, BILL_ACTORCODE = ?, BILL_STATUS = ? WHERE BILL_CODE = ?");
                        $st = $this->db->prepare($sql);
                        $st->BindParam(1, $form_key);
                        $st->BindParam(2, $currentuser);
                        $st->BindParam(3, $currentusercode);
                        $st->BindParam(4, $this->thetwo);
                        $st->BindParam(5, $billcode);
                        $updatebills = $st->execute();
                        if ($updatebills) {
                            $vt = 1;
							$nut = 2;
                            $sql = "UPDATE octopus_patients_discounts SET PDS_RECEIPTCODE = ? , PDS_STATUS = ?  WHERE PDS_PATIENTCODE = ? AND  PDS_STATUS = ? AND PDS_INSTCODE = ? ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $form_key);
                            $st->BindParam(2, $this->thetwo);
							$st->BindParam(3, $patientcode);
							$st->BindParam(4, $this->theone);
							$st->BindParam(5, $instcode);
							$recipt = $st->Execute();

							$nut = 2;
							$not = 1;
                            $sql = "UPDATE octopus_patients_billing SET BG_STATUS = ?, BG_RECEIPTNUMBER = ? WHERE BG_CODE = ? AND  BG_STATUS = ? AND BG_INSTCODE = ? ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $this->thetwo);
                            $st->BindParam(2, $receiptnumber);
							$st->BindParam(3, $billingcode);
							$st->BindParam(4, $this->theone);
							$st->BindParam(5, $instcode);
							$recipt = $st->Execute();

							$not = 1;
                            $sql = "UPDATE octopus_patients_billingpayments SET BPT_RECEIPTNUMBER = ? WHERE BPT_BILLINGCODE = ? AND  BPT_INSTCODE = ? ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $receiptnumber);
                            $st->BindParam(2, $billingcode);
							$st->BindParam(3, $instcode);
						//	$st->BindParam(4, $not);
						//	$st->BindParam(5, $instcode);
							$recipt = $st->Execute();


							$sql = "UPDATE octopus_current SET CU_RECEIPTNUMBER = CU_RECEIPTNUMBER + ?  WHERE CU_INSTCODE = ? ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $this->theone);
                            $st->BindParam(2, $instcode);
                            $recipt = $st->Execute();
                            if ($recipt) {
                                $selected = 2;
                                $unselected = 1;
                                $paid = 4;
                                $show = 7;
                                
                                // pay before service
                                if ($payingtype == 1) {
                                    $selected = 2;
                                    $unselected = 1;
                                    $paid = 4;
                                    $show = 7;

									$sqlmed = "UPDATE octopus_patients_medicalreports SET MDR_STATUS = ? , MDR_SELECTED = ?  WHERE MDR_PATIENTCODE = ? and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
                                    $st = $this->db->prepare($sqlmed);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $selected);
                                    $st->BindParam(3, $patientcode);
                                    $st->BindParam(4, $unselected);
                                    $st->BindParam(5, $instcode);
                                    $med = $st->Execute();
                                
                                    $sqlservice = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? , REQU_SHOW = ? , REQU_SELECTED = ?  WHERE REQU_VISITCODE = ? and REQU_SELECTED = ? and REQU_INSTCODE = ? AND  REQU_PATIENTCODE = ?";
                                    $st = $this->db->prepare($sqlservice);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $show);
                                    $st->BindParam(3, $selected);
                                    $st->BindParam(4, $visitcode);
                                    $st->BindParam(5, $unselected);
                                    $st->BindParam(6, $instcode);
									$st->BindParam(7, $patientcode);
                                    $servicerequest = $st->Execute();

									$sqllabs = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_STATUS = ? , MIV_SELECTED = ?  WHERE MIV_VISITCODE = ? and MIV_SELECTED = ? AND MIV_INSTCODE = ? AND MIV_PATIENTCODE =? ";
                                        $st = $this->db->prepare($sqllabs);
                                        $st->BindParam(1, $paid);
                                        $st->BindParam(2, $selected);
                                        $st->BindParam(3, $selected);
                                        $st->BindParam(4, $visitcode);
                                        $st->BindParam(5, $unselected);
                                        $st->BindParam(6, $instcode);
										$st->BindParam(7, $patientcode);
                                        $labs = $st->Execute();

										$sqlprescriptions = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_STATUS = ? , PRESC_SELECTED = ? , PRESC_DISPENSE = ?  WHERE PRESC_VISITCODE = ? and PRESC_SELECTED = ? AND PRESC_PATIENTCODE = ?";
										$st = $this->db->prepare($sqlprescriptions);
										$st->BindParam(1, $paid);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $selected);
										$st->BindParam(4, $unselected);
										$st->BindParam(5, $visitcode);
										$st->BindParam(6, $unselected);
										$st->BindParam(7, $patientcode);
										$prescriptions = $st->Execute();

										$sqldevices = "UPDATE octopus_patients_devices SET PD_STATE = ? , PD_STATUS = ? , PD_SELECTED = ?, PD_DISPENSE = ?  WHERE PD_VISITCODE = ? and PD_SELECTED = ? AND PD_PATIENTCODE = ?";
										$st = $this->db->prepare($sqldevices);
										$st->BindParam(1, $paid);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $selected);
										$st->BindParam(4, $unselected);
										$st->BindParam(5, $visitcode);
										$st->BindParam(6, $unselected);
										$st->BindParam(7, $patientcode);
										$devices = $st->Execute();

										$sqlprocedure = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_STATUS = ? , PPD_SELECTED = ? , PPD_DISPENSE = ?  WHERE  PPD_VISITCODE = ? and  PPD_SELECTED = ? AND PPD_PATIENTCODE = ? ";
										$st = $this->db->prepare($sqlprocedure);
										$st->BindParam(1, $paid);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $selected);
										$st->BindParam(4, $unselected);
										$st->BindParam(5, $visitcode);
										$st->BindParam(6, $unselected);
										$st->BindParam(7, $patientcode);
										$procedure = $st->Execute();

										return $this->thepassed;

                                                                      

                                    // pay after service
                                } elseif ($payingtype == 7) {

									$sqlmed = "UPDATE octopus_patients_medicalreports SET MDR_STATUS = ? , MDR_SELECTED = ?  WHERE MDR_PATIENTCODE = ? and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
                                    $st = $this->db->prepare($sqlmed);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $selected);
                                    $st->BindParam(3, $patientcode);
                                    $st->BindParam(4, $unselected);
                                    $st->BindParam(5, $instcode);
                                //    $st->BindParam(6, $instcode);
                                    $med = $st->Execute();
									
                                    $sqlservice = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? , REQU_SHOW = ? , REQU_SELECTED = ?  WHERE REQU_VISITCODE = ? and  REQU_SELECTED = ? and REQU_INSTCODE = ?  AND  REQU_PATIENTCODE = ?";
                                    $st = $this->db->prepare($sqlservice);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $show);
                                    $st->BindParam(3, $selected);
                                    $st->BindParam(4, $visitcode);
                                    $st->BindParam(5, $unselected);
                                    $st->BindParam(6, $instcode);
									$st->BindParam(7, $patientcode);
                                    $servicerequest = $st->Execute();

									$sqllabs = "UPDATE octopus_patients_investigationrequest SET MIV_STATUS = ? , MIV_SELECTED = ? WHERE MIV_VISITCODE = ? and MIV_SELECTED = ? AND MIV_INSTCODE = ? AND MIV_PATIENTCODE =?";
									$st = $this->db->prepare($sqllabs);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $selected);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $unselected);
									$st->BindParam(5, $instcode);
									$st->BindParam(6, $patientcode);
									$labs = $st->Execute();

									$sqlprescriptions = "UPDATE octopus_patients_prescriptions SET  PRESC_STATUS = ? , PRESC_SELECTED = ? WHERE PRESC_VISITCODE = ? and PRESC_SELECTED = ? and PRESC_INSTCODE = ? AND PRESC_PATIENTCODE = ?";
									$st = $this->db->prepare($sqlprescriptions);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $selected);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $unselected);
									$st->BindParam(5, $instcode);
									$st->BindParam(6, $patientcode);
									$prescriptions = $st->Execute();

									$sqldevices = "UPDATE octopus_patients_devices SET PD_STATUS = ? , PD_SELECTED = ? WHERE PD_VISITCODE = ? and PD_SELECTED = ? and PD_INSTCODE = ? AND PD_PATIENTCODE = ?";
									$st = $this->db->prepare($sqldevices);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $selected);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $unselected);
									$st->BindParam(5, $instcode);
									$st->BindParam(6, $patientcode);
									$devices = $st->Execute();

									$sqlprocedure = "UPDATE octopus_patients_procedures SET PPD_STATUS = ? , PPD_SELECTED = ? WHERE PPD_VISITCODE = ? and PPD_SELECTED = ? and PPD_PATIENTCODE = ? AND PPD_PATIENTCODE = ?";
									$st = $this->db->prepare($sqlprocedure);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $selected);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $unselected);
									$st->BindParam(5, $instcode);
									$st->BindParam(6, $patientcode);
									$procedure = $st->Execute();
									return $this->thepassed;
                                    
                                } else {   
									$selected = 2;
                                    $unselected = 1;
                                    $paid = 4;
                                    $show = 7;

									$sqlmed = "UPDATE octopus_patients_medicalreports SET MDR_STATUS = ? , MDR_SELECTED = ?  WHERE MDR_PATIENTCODE = ? and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
                                    $st = $this->db->prepare($sqlmed);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $selected);
                                    $st->BindParam(3, $patientcode);
                                    $st->BindParam(4, $unselected);
                                    $st->BindParam(5, $instcode);
                                    $med = $st->Execute();
                                
                                    $sqlservice = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? , REQU_SHOW = ? , REQU_SELECTED = ?  WHERE REQU_VISITCODE = ? and REQU_SELECTED = ? and REQU_INSTCODE = ? AND  REQU_PATIENTCODE = ?";
                                    $st = $this->db->prepare($sqlservice);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $show);
                                    $st->BindParam(3, $selected);
                                    $st->BindParam(4, $visitcode);
                                    $st->BindParam(5, $unselected);
                                    $st->BindParam(6, $instcode);
									$st->BindParam(7, $patientcode);
                                    $servicerequest = $st->Execute();

									$sqllabs = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_STATUS = ? , MIV_SELECTED = ?  WHERE MIV_VISITCODE = ? and MIV_SELECTED = ? AND MIV_INSTCODE = ? AND MIV_PATIENTCODE =? ";
                                        $st = $this->db->prepare($sqllabs);
                                        $st->BindParam(1, $paid);
                                        $st->BindParam(2, $selected);
                                        $st->BindParam(3, $selected);
                                        $st->BindParam(4, $visitcode);
                                        $st->BindParam(5, $unselected);
                                        $st->BindParam(6, $instcode);
										$st->BindParam(7, $patientcode);
                                        $labs = $st->Execute();

										$sqlprescriptions = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_STATUS = ? , PRESC_SELECTED = ? , PRESC_DISPENSE = ?  WHERE PRESC_VISITCODE = ? and PRESC_SELECTED = ? AND PRESC_PATIENTCODE = ?";
										$st = $this->db->prepare($sqlprescriptions);
										$st->BindParam(1, $paid);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $selected);
										$st->BindParam(4, $unselected);
										$st->BindParam(5, $visitcode);
										$st->BindParam(6, $unselected);
										$st->BindParam(7, $patientcode);
										$prescriptions = $st->Execute();

										$sqldevices = "UPDATE octopus_patients_devices SET PD_STATE = ? , PD_STATUS = ? , PD_SELECTED = ?, PD_DISPENSE = ?  WHERE PD_VISITCODE = ? and PD_SELECTED = ? AND PD_PATIENTCODE = ?";
										$st = $this->db->prepare($sqldevices);
										$st->BindParam(1, $paid);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $selected);
										$st->BindParam(4, $unselected);
										$st->BindParam(5, $visitcode);
										$st->BindParam(6, $unselected);
										$st->BindParam(7, $patientcode);
										$devices = $st->Execute();

										$sqlprocedure = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_STATUS = ? , PPD_SELECTED = ? , PPD_DISPENSE = ?  WHERE  PPD_VISITCODE = ? and  PPD_SELECTED = ? AND PPD_PATIENTCODE = ? ";
										$st = $this->db->prepare($sqlprocedure);
										$st->BindParam(1, $paid);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $selected);
										$st->BindParam(4, $unselected);
										$st->BindParam(5, $visitcode);
										$st->BindParam(6, $unselected);
										$st->BindParam(7, $patientcode);
										$procedure = $st->Execute();

										return $this->thepassed;                                   
                                }
                            } else {
                                return $this->thefailed;
                            }
                        } else {
                            return $this->thefailed;
                        }
                    } else {
                        return $this->thefailed;
                    }
                } else {
                    return $this->thefailed;
                }
            } else {
                return $this->thefailed;
            }
        }else{
			return $this->thefailed;
		}
	}



	
} 

$receiptcontroller =  new ReceiptController();
?>