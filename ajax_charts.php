<?php
include 'stats_web_core/classes.php';
$player = new stats_player(htmlentities($_GET['p'], ENT_QUOTES, 'UTF-8'));
?>
	var all_kills_data = [
	<?php
	$all_kills = $player->get_all_kills();
	echo '{ label: "'.$all_kills[0][0].'",  data: '.$all_kills[0][1].'}'; unset($all_kills[0]);
	foreach($all_kills as $kill){
		echo ',{ label: "'.$kill[0].'",  data: '.$kill[1].'}';
	}
	?>
	];

	var all_deaths_data = [
	<?php
	$all_deaths = $player->get_all_deaths();
	echo '{ label: "'.$all_deaths[0][0].'",  data: '.$all_deaths[0][1].'}'; unset($all_deaths[0]);
	foreach($all_deaths as $death){
		echo ',{ label: "'.$death[0].'",  data: '.$death[1].'}';
	}
	?>
	];

	if($("#piechart_kills").length)
	{
		$.plot($("#piechart_kills"), all_kills_data,
		{
			series: {
					pie: {
							show: true
					}
			},
			grid: {
					hoverable: true,
					clickable: true
			},
			legend: {
				show: false
			}
		});
		
		function pieHover(event, pos, obj)
		{
			if (!obj)
					return;
			percent = parseFloat(obj.series.percent).toFixed(2);
			$("#hover").html('<span style="font-weight: bold; color: '+obj.series.color+'">'+obj.series.label+' ('+percent+'%)</span>');
		}
		$("#piechart").bind("plothover", pieHover);
	}

	if($("#piechart_deaths").length)
	{
		$.plot($("#piechart_deaths"), all_deaths_data,
		{
			series: {
					pie: {
							show: true
					}
			},
			grid: {
					hoverable: true,
					clickable: true
			},
			legend: {
				show: false
			}
		});
		
		function pieHover(event, pos, obj)
		{
			if (!obj)
					return;
			percent = parseFloat(obj.series.percent).toFixed(2);
			$("#hover").html('<span style="font-weight: bold; color: '+obj.series.color+'">'+obj.series.label+' ('+percent+'%)</span>');
		}
		$("#piechart").bind("plothover", pieHover);
	}