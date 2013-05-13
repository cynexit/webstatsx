<?php
include('header.php');

$player = new stats_player(htmlentities($_GET['p'], ENT_QUOTES, 'UTF-8'));
?>


			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php" class="ajax-link">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="players.php" class="ajax-link">Players</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#" id="player_id"><?php echo $player->player; ?></a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid">
				<div class="span6">
					<div class="row-fluid">
						<div class="box span12">
							<div class="box-header well" data-original-title>
								<h2><i class="icon-user"></i> <?php echo $player->player; ?></h2>
								<!--
								<div class="box-icon">
									<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
									<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
									<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
								</div>
								-->
							</div>
							<div class="box-content">
								<table class="table table-bordered table-striped table-condensed">
									  <tbody>
										<tr>
											<td>Playtime:</td>
											<td><?php echo $player->playtime; ?></td>
											<td>Arrows:</td>
											<td><?php echo $player->arrows; ?></td>
										</tr>
										<tr>
											<td>XP gained:</td>
											<td><?php echo $player->xpgained; ?></td>
											<td>Joins:</td>
											<td><?php echo $player->joins; ?></td>
										</tr>
										<tr>
											<td>Fish caught:</td>
											<td><?php echo $player->fishcatch; ?></td>
											<td>Damage taken:</td>
											<td><?php echo $player->damagetaken; ?></td>
										</tr>
										<tr>
											<td>Times kicked:</td>
											<td><?php echo $player->timeskicked; ?></td>
											<td>Tools broken:</td>
											<td><?php echo $player->toolsbroken; ?></td>
										</tr>
										<tr>
											<td>Eggs thrown:</td>
											<td><?php echo $player->eggsthrown; ?></td>
											<td>Items crafted:</td>
											<td><?php echo $player->itemscrafted; ?></td>
										</tr>
										<tr>
											<td>Omnomnom:</td>
											<td><?php echo $player->omnomnom; ?></td>
											<td>Was on fire:</td>
											<td><?php echo $player->onfire; ?></td>
										</tr>
										<tr>
											<td>Words said:</td>
											<td><?php echo $player->wordssaid; ?></td>
											<td>Commands done:</td>
											<td><?php echo $player->commandsdone; ?></td>
										</tr>
										<tr>
											<td>Last join:</td>
											<td><?php echo $player->lastjoin; ?></td>
											<td>Last leave:</td>
											<td><?php echo $player->lastleave; ?></td>
										</tr>

										<tr>
											<td>Votes:</td>
											<td><?php echo $player->votes; ?></td>
											<td>Teleports:</td>
											<td><?php echo $player->teleports; ?></td>
										</tr>
										<tr>
											<td>Items picked up:</td>
											<td><?php echo $player->itempickups; ?></td>
											<td>Items dropped:</td>
											<td><?php echo $player->itemdrops; ?></td>
										</tr>
										<tr>
											<td>Entered a bed:</td>
											<td><?php echo $player->bedenter; ?></td>
											<td>Switched world:</td>
											<td><?php echo $player->worldchange; ?></td>
										</tr>
										<tr>
											<td>Filled a bucket:</td>
											<td><?php echo $player->bucketfill; ?></td>
											<td>Emptied a bucket:</td>
											<td><?php echo $player->bucketempty; ?></td>
										</tr>
										<tr>
											<td>Sheared:</td>
											<td><?php echo $player->shear; ?></td>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div><!--/span-->
					</div>

					<div class="row-fluid">
						<div class="box span12">
							<div class="box-header well" data-original-title>
								<h2><i class="icon-th-large"></i> Blocks</h2>
								<!--
								<div class="box-icon">
									<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
									<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
									<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
								</div>
								-->
							</div>
							<div class="box-content">
								<!--<table class="table table-bordered table-striped table-condensed">-->
								<table class="table table-striped table-bordered bootstrap-datatable datatable">
									<thead>
										<tr>
											<th>Block</th>
											<th>BlockID</th>
											<th>Placed</th>
											<th>Broken</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$blocks = $player->get_all_blocks('mysql');
										while ($row = mysqli_fetch_assoc($blocks)){
											echo '<tr><td class="centered"><img src="img/blocks/'.$row['blockID'].'.png" height="32" width="32" alt="Block '.$row['blockID'].'" /></td>';
											echo '<td>'.$row['blockID'].'</td>';
											echo '<td>'.$row['amn'].'</td>';
											echo '<td>'.$row['brk'].'</td></tr>';
										}
										?>
									</tbody>
								</table>      
							</div>
						</div><!--/span-->
					</div>

				</div>

				<div class="span6">
					<div class="row-fluid">
						<div class="box span6">
							<div class="box-header well" data-original-title>
								<h2><i class="icon-road"></i> Movement</h2>
								<!--
								<div class="box-icon">
									<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
									<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
									<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
								</div>
								-->
							</div>
							<div class="box-content">
								<?php
								$foot = $player->get_movement(0);
								$boat = $player->get_movement(1);
								$cart = $player->get_movement(2);
								$pig = $player->get_movement(3);
								?>
								<table class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th>Total:</th>
											<th><?php echo number_format(($foot+$boat+$pig+$cart), 2, '.', ''); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>By foot:</td>
											<td><?php echo number_format($foot, 2, '.', ''); ?></td>
										</tr>
										<tr>
											<td>By boat:</td>
											<td><?php echo number_format($boat, 2, '.', ''); ?></td>
										</tr>
										<tr>
											<td>By minecart:</td>
											<td><?php echo number_format($cart, 2, '.', ''); ?></td>
										</tr>
										<tr>
											<td>By pig:</td>
											<td><?php echo number_format($pig, 2, '.', ''); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div><!--/span-->

						<div class="box span6">
							<div class="box-header well" data-original-title>
								<h2><i class="icon-fire"></i> Fighting</h2>
								<!--
								<div class="box-icon">
									<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
									<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
									<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
								</div>
								-->
							</div>
							<div class="box-content">
								<?php
								$kills = $player->get_kills();
								$deaths = $player->get_deaths();
								$kills_player = $player->get_kills('player');
								$deaths_player = $player->get_deaths('player');
								
								// prevent div. by zero
								if($deaths > 0){
									$kd = number_format(($kills/$deaths), 2, '.', '');
								} else {
									$kd = 'Immortal';
								}
								?>
								<table class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
									  		<th class="centered" colspan="2">K/D ratio:</th><th colspan="2"><?php echo $kd; ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Kills total:</td>
											<td><?php echo  $kills; ?></td>
											<td>Deaths total:</td>
											<td><?php echo $deaths; ?></td>
										</tr>
										<tr>
											<td>Players:</td>
											<td><?php echo $kills_player; ?></td>
											<td>Players:</td>
											<td><?php echo $deaths_player; ?></td>
										</tr>
										<tr>
											<td>Entities:</td>
											<td><?php echo $kills-$kills_player; ?></td>
											<td>Entities:</td>
											<td><?php echo $deaths-$deaths_player; ?></td>
										</tr>
										<tr>
											<td>Server avg:</td>
											<td><?php echo number_format($stats_global->get_kill_average(), 2, '.', ''); ?></td>
											<td>Server avg:</td>
											<td><?php echo number_format($stats_global->get_death_average(), 2, '.', ''); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div><!--/span-->			

					</div>



					<!-- second row, right-->
					<div class="row-fluid" id="load_charts">
						<div class="box span6">
							<div class="box-header well" data-original-title>
								<h2><i class="icon-arrow-up"></i> Stuff you killed</h2>
								<!--
								<div class="box-icon">
									<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
									<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
									<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
								</div>
								-->
							</div>
							<div class="box-content centered">
								<div id="hover_kills" class="chart_hover_box">Move your mouse over chart!</div>
								<div id="piechart_kills" style="height:300px"></div>
								<?php $top = $player->get_all_kills(1); ?>
								<img height="200" src="img/entities/<?php echo $top[0][0]; ?>.png" alt="Top killed" />
							</div>
						</div><!--/span-->

						<div class="box span6">
							<div class="box-header well" data-original-title>
								<h2><i class="icon-arrow-down"></i> Stuff that killed you</h2>
								<!--
								<div class="box-icon">
									<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
									<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
									<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
								</div>
								-->
							</div>
							<div class="box-content centered">
								<div id="hover_deaths" class="chart_hover_box">Move your mouse over chart!</div>
								<div id="piechart_deaths" style="height:300px"></div>
								<?php $top = $player->get_all_deaths(1); ?>
								<img height="200" src="img/entities/<?php echo $top[0][0]; ?>.png" alt="Top killer" />
							</div>
						</div><!--/span-->


					</div>

				</div>
			</div>
    
<?php include('footer.php'); ?>
