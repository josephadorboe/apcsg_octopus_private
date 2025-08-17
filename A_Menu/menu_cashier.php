
<div class="tab-menu-heading siderbar-tabs border-0  p-0">
		<div class="tabs-menu ">
			<!-- Tabs -->
			<ul class="nav panel-tabs">
					<li><a href="#index3a" <?php  if($sub == 1 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
					<!--
					<li class=""><a href="#index3b" <?php // if($sub == 2){ ?> class="active" <?php // } ?> data-toggle="tab"><i class="fa fa-user-times fs-17"></i></a></li>
					-->
					<li><a href="#index3c"  <?php  if($sub == 3 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user-md fs-17"></i></a></li>
				</ul>							
		</div> 
	</div>
	<div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
		<div class="tab-content">
				<div class="tab-pane <?php  if($sub == 1 ){ ?> active <?php } ?> " id="index3a">
					<ul class="side-menu toggle-menu">
						<li>
							<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
						</li>	
						<li>
							<a class="side-menu__item" href="cash__cashtransaction"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label">Transactions</span> <?php if($noninsurancecount > '0'){ ?> <span class="badge badge-primary"><?php echo $noninsurancecount ; ?></span> <?php } ?></a>
						</li>
						<?php if($prepaidchemecode !== '0'){ ?>
						<li>
							<a class="side-menu__item" href="wallet__filter"><i class="side-menu__icon typcn typcn-support"></i><span class="side-menu__label">Manage Wallet</span></a>
						</li>
						<li>
							<a class="side-menu__item" href="promotion__subscriptionpayment"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label"> Promotion Subscription</span> <?php if($promotioncount > '0'){ ?> <span class="badge badge-success"><?php echo $promotioncount ; ?></span> <?php } ?></a>
						</li>
						<?php } ?>
						<li>
							<a class="side-menu__item" href="managesalepoints?1"><i class="side-menu__icon typcn typcn-export"></i><span class="side-menu__label">Sale point</span></a>
						</li>
						<!--
						<li>
							<a class="side-menu__item" href="admin__managecreditorslist"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Manage Credit</span></a>
						</li>
						-->
						<li>
						<a class="side-menu__item" href="cashier__partnerpayments"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Partner Payments</span></a>
						</li>
						<li>
							<a class="side-menu__item" href="cashier__managerefunds"><i class="side-menu__icon typcn typcn-spanner-outline"></i><span class="side-menu__label">Refunds</span></a>
						</li>	
						<li>
							<a class="side-menu__item" href="cashier__manageendofday"><i class="side-menu__icon typcn typcn-chart-pie-outline"></i><span class="side-menu__label">End OF Day</span></a>
						</li>										
						<li>
							<a class="side-menu__item" href="admin__manageforex"><i class="side-menu__icon typcn typcn-chart-pie"></i><span class="side-menu__label">Manage Forex</span></a>
						</li>												
						<li>
							<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
						</li>					
					</ul>
				</div>
				<div class="tab-pane border-top <?php  if($sub == 2){ ?> active <?php } ?>" id="index3b">
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
				<div class="tab-pane border-top <?php   if($sub == 3){ ?> active  <?php  } ?> " id="index3c">
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
		
		</div>					
	</div>
</aside>
				