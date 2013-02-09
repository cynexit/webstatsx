<?php
include('header.php');
?>


			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Dashboard</a>
					</li>
				</ul>
			</div>

			<div class="row-fluid">
				<a class="well span3 top-block" href="players.php">
					<span class="icon32 icon-color icon-users"></span>
					<div>Number of players with stats</div>
					<div><?php echo $stats_global->count_players(); ?></div>
				</a>

				<a class="well span3 top-block" href="#">
					<span class="icon32 icon-color icon-sent"></span>
					<div>Total distance travelled by players</div>
					<div><?php echo number_format($stats_global->get_total_distance_moved(), 2, '.', ''); ?></div>
				</a>

				<a class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-arrowthick-n"></span>
					<div>Total kills by players</div>
					<div><?php echo $stats_global->get_total_kills(); ?></div>
				</a>
				
				<a class="well span3 top-block" href="#">
					<span class="icon32 icon-red icon-arrowthick-s"></span>
					<div>Total deaths of players</div>
					<div><?php echo $stats_global->get_total_deaths(); ?></div>
				</a>
			</div>
			
			<div class="row-fluid">		
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top 10 by distance travelled</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Username</th>
									<th>Total distance</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
						 	$player = $stats_global->get_top_players_move('mysql', 10);
							while ($row = mysqli_fetch_row($player)){
								echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.number_format($row[1], 2, '.', '').'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top 10 by kills</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Username</th>
									<th>Total kills</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
						 	$player = $stats_global->get_top_players_kill('mysql', 10);
							while ($row = mysqli_fetch_row($player)){
								echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.$row[1].'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top 10 by deaths</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Username</th>
									<th>Total deaths</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
						 	$player = $stats_global->get_top_players_death('mysql', 10);
							while ($row = mysqli_fetch_row($player)){
								echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.$row[1].'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->


			<!-- row 2 -->
			<div class="row-fluid">		
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top 10 by blocks placed</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Username</th>
									<th>Total blocks placed</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
						 	$player = $stats_global->get_top_players_blocks_placed('mysql', 10);
							while ($row = mysqli_fetch_row($player)){
								echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.$row[1].'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top 10 by blocks broken</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Username</th>
									<th>Total blocks broken</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
						 	$player = $stats_global->get_top_players_blocks_broken('mysql', 10);
							while ($row = mysqli_fetch_row($player)){
								echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.$row[1].'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top 10 by playtime</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>
								  <th>Username</th>
								  <th>Playtime</th>
								  <th>Joins</th>
							  </tr>
						  </thead>
						  <tbody>
						  	<?php
							while ($player = $stats_global->get_players('playtime', 'desc', 10)){
            					echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$player->player.'">'.$player->player.'</a></td>';
            					echo '<td>'.$player->playtime.'</td>';
            					echo '<td>'.$player->joins.'</td>';
            				}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

<?php include('footer.php'); ?>