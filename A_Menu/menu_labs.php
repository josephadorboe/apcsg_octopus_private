<?php $radiologycount = $patientsInvestigationRequesttable->countradiologyrequest($type='IMAGING',$instcode);  ?>
<div class="tab-menu-heading siderbar-tabs border-0  p-0">
	<div class="tabs-menu ">
		<!-- Tabs -->		
		<ul class="nav panel-tabs">
			<li class=""><a href="#index6a" <?php  if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
			<li><a href="#index6b" <?php if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-cubes"></i></a></li>
			<!-- 
			<li><a href="#index13c" <?php //if($sub == 3){ ?> class="active" <?php // } ?> data-toggle="tab"><i class="fa fa-bank"></i></a></li>
			<li><a href="#index13d" <?php //if($sub == 4){ ?> class="active" <?php // } ?> data-toggle="tab"><i class="fa fa-bars"></i></a></li>	
		 -->
		</ul>							
	</div> 
</div>
<div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
	<div class="tab-content">
	
			<div class="tab-pane <?php   if($sub == 1){ ?> active  <?php  }  ?> " id="index6a">
				<ul class="side-menu toggle-menu">
					<li>
						<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="labs__managerequest"><i class="side-menu__icon typcn typcn-shopping-bag"></i><span class="side-menu__label">Manage Request</span> <?php if($radiologycount > 0){ ?> <span class="badge badge-primary"><?php echo $radiologycount ; ?></span> <?php } ?></a>
					</li>	
					<li>
						<a class="side-menu__item" href="labs__resultarchive"><i class="side-menu__icon typcn typcn-database" data-toggle="tooltip"> </i> <span class="side-menu__label"> Result Archive</span></a>
					</li>	
					<li>
						<a class="side-menu__item" href="walkin__filter"><i class="side-menu__icon typcn typcn-lightbulb"></i><span class="side-menu__label">Walk In</span></a>
					</li>
					<li>
					<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
				</li>								
				</ul>
			</div>
			<div class="tab-pane border-top <?php  if($sub == 2){ ?> active <?php } ?>" id="index6b">
					<ul class="side-menu toggle-menu">
						<li>
							<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
						</li>
						<li>
							<a class="side-menu__item" href="radiologysetup__test"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Radiology List</span></a>
						</li>
						<li>
							<a class="side-menu__item" href="investigationplansetup__radiology"><i class="side-menu__icon typcn typcn-dropbox"></i><span class="side-menu__label">Radiology Plan</span></a>
						</li>
						
						<li>
							<a class="side-menu__item" href="radiology__setupradiologyprice"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Pricing</span></a>
						</li>											
					</ul>
				</div>

			<div class="tab-pane border-top <?php  if($sub == 3 ){ ?> active <?php } ?> " id="index6c">
				<ul class="side-menu toggle-menu">
					<li>
						<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
					</li>
				</ul>
			</div>
			
	</div>					
</div>
</aside>			
				