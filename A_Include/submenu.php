<?php
	function consultationsubmenu(){ ?>		
		<div class="btn-group mt-2 mb-2">
			<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
				Sub Menu <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="patientconsultationgp"> Pending Consultations</a></li>
				<li><a href="consultationcompletedtoday"> Completed Consultations </a></li>
				<li><a href="pastconsultation"> Past Consultations </a></li>					
			</ul>
		</div>	
<?php } ?>
<?php 
	function pastedconsultationmenu($patient,$patientnumber,$paymentmethod,$scheme,$gender,$age,$consultationdate,$servicerequested,$vitals,$consultationpaymenttype){
?>
<div class="card">
	<div class="card-header">
	<div class="card-title">Detail: <b><?php echo $patientnumber; ?> - <?php echo $patient; ?> </b> - <?php echo $age; ?> Years - <?php echo $gender; ?> <br /> <?php echo $scheme; ?> -  <?php echo (($consultationpaymenttype == '1')?'PAY BEFORE':'PAY AFTER'); ?> - <?php echo date('d M Y H:i:s a', strtotime($consultationdate)); ?> <br />  <?php echo $servicerequested; ?> 
	 </div>	
	</div>
	<div class="card-body">		
		<?php 
			if(!empty($vitals) && $vitals ==! 1){
				$vt = explode('@', $vitals);
				$bp = $vt[0];
				$temp = $vt[1];
				$height = $vt[2];
				$weight = $vt[3];
				$fbs = $vt[4];
				$pulse = $vt[7];
				$remarks = $vt[9];
				$vitalsby = $vt[11];
				
			}else{
				$bp = $temp = $height = $weight = $fbs = $pulse = 'NA';
			}	
		?>
		<div class="card-title">Vitals : BP - <?php echo $bp??'NA'; ?> , Temperature - <?php echo $temp??'NA'; ?> , Pulse - <?php echo $pulse??'NA'; ?> , Height - <?php echo $height??'NA'; ?> , Weight - <?php echo $weight??'NA'; ?> , FBS - <?php echo $fbs??'NA'; ?> <br /> </div>
		 <div class="card-title"> Medical Condition - <?php echo $remarks??'NA'; ?> , by: <?php echo $vitalsby??'NA'; ?>   </div>									
	</div>					
</div>

<?php } 

function physioconsultationmenu($patient,$patientnumber,$scheme,$gender,$age,$consultationdate,$servicerequested,$consultationpaymenttype){
?>
<div class="card">
	<div class="card-header">
	<div class="card-title">Detail: <b><?php echo $patientnumber; ?> - <?php echo $patient; ?> </b> - <?php echo $age; ?> - <?php echo $gender; ?> <?php echo $scheme; ?> -  <?php echo (($consultationpaymenttype == '1')?'PAY BEFORE':'PAY AFTER'); ?> - <?php echo date('d M Y H:i:s a', strtotime($consultationdate)); ?> <br />  <?php echo $servicerequested; ?> 
	 </div>	
	</div>
						
</div>

<?php } ?>
		