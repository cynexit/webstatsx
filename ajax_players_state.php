<?php
$player_list = explode(', ', $_POST['player_list']);
array_pop($player_list);

if(count($player_list) > 0){
	include 'stats_web_core/classes.php';
	$stats_global = new stats_global();

	echo json_encode($stats_global->get_players_state($player_list));
}
?>