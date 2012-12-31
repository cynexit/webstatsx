<?php include('header.php'); ?>

			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php" class="ajax-link">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Players</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Players</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Username</th>
								  <th>Playtime</th>
								  <th>Joins</th>
								  <th>EXP gained</th>
								  <th>Damage taken</th>
								  <th>Kicked</th>
								  <th>Items crafted</th>
							  </tr>
						  </thead>
						  <tbody>
						  	<?php
						  	while ($player = $stats_global->get_players()) {
            					echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$player->player.'">'.$player->player.'</a></td>';
            					echo '<td>'.$player->playtime.'</td>';
            					echo '<td>'.$player->joins.'</td>';
            					echo '<td>'.$player->xpgained.'</td>';
            					echo '<td>'.$player->damagetaken.'</td>';
            					echo '<td>'.$player->timeskicked.'</td>';
            					echo '<td>'.$player->itemscrafted.'</td></tr>';
            				}            				
							?>							
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
    
<?php include('footer.php'); ?>