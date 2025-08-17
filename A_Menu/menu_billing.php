	<div class="tab-menu-heading siderbar-tabs border-0  p-0">
		<div class="tabs-menu ">
			<ul class="nav panel-tabs">
				<li><a href="#index2a" <?php  if($sub == 1 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
				<li><a href="#index2c" <?php   if($sub == 3){ ?> class="active" <?php  } ?> data-toggle="tab"><i class="fa fa-user fs-17"></i></a></li>
			</ul>							
		</div> 
	</div>
<div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
	<div class="tab-content">		
		<div class="tab-pane <?php  if($sub == 1){ ?> active <?php } ?> " id="index2a">
			<ul class="side-menu toggle-menu">
				<li>
					<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
				</li>	
				<li>
					<a class="side-menu__item" href="claimbilling__noncashtransactions"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label">Transactions</span><?php if($insurancecount > '0'){ ?> <span class="badge badge-primary"><?php echo $insurancecount ; ?></span> <?php } ?></a>
				</li>
				<li>
					<a class="side-menu__item" href="claimbilling__transactionsbasket"><i class="side-menu__icon typcn typcn-dropbox"></i><span class="side-menu__label">Transactions Basket </span></a>
				</li>
				<li>
					<a class="side-menu__item" href="manageclaims"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Claims</span></a>
				</li>
				<li>
					<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
				</li>	
				<!--
				<li>
					<a class="side-menu__item" href="claimbilling__managelegacydetails"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label">Legacy </span></a>
				</li>
				<li>
					<a class="side-menu__item" href="claimbilling__billingtransactionsprocessed"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Processed </span></a>
				</li>	
				-->															
			</ul>
		</div>

		<div class="tab-pane border-top <?php  if($sub == 2 ){ ?> active <?php } ?>" id="index2b">
			<ul class="side-menu toggle-menu">
				<li>
					<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
				</li>
				<li>
					<a class="side-menu__item" href="admin__manageprice"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Pricing</span></a>
				</li>
				<li>
					<a class="side-menu__item" href="admin__managepaymentmethod"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label">Payment Method</span></a>
				</li>
				<li>
					<a class="side-menu__item" href="admin__managepaymentpartners"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Payment Partners</span></a>
				</li>
				<li>
					<a class="side-menu__item" href="admin__managepaymentscheme"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Payment Schemes</span></a>
				</li>																
			</ul>
		</div>

		<div class="tab-pane border-top <?php   if($sub == 3){ ?> active  <?php  } ?> " id="index2c">
				<ul class="side-menu toggle-menu">
						<li>
							<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
						</li>
						<li>
							<a class="side-menu__item" href="receiptsearchfilter"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Receipts Issued </span></a>
						</li>								
						
						<li>
							<a class="side-menu__item" href="cashier__shifttransactions"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Shift Transaction </span></a>
						</li>
						<li>
							<a class="side-menu__item" href="cashier__cashierpatientfolderfilter"><i class="side-menu__icon typcn typcn-document-add"></i><span class="side-menu__label">Patient Folder</span></a>
						</li>								
					
					<li>
						<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
					</li>			
					
				</ul>
			</div>
			<!--
		<div class="tab-pane border-top <?php   //if($sub == 3 ){ ?> active  <?php  //} ?> " id="index2c">
				<ul class="side-menu toggle-menu">
				<li>
					<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
				</li>							
				
				<li>
					<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
				</li>
				<li>
					<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
				</li>			
				
			</ul>
		</div>	-->
											
		</div>					
	</div>
</aside>
