<?php
abstract class stats_settings {
	public $prefix;
	public $mysqli;

	function __construct(){
		if(!(@include __dir__.'/../config.php')){
			exit('config.php could not be loaded! Check if you inserted all necessary data in the config_demo.php and renamed it to config.php!');
		}
		
		$this->prefix = $prefix;

		//connect to mysql, select correct db
		$this->mysqli = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

		//set charset of tables (sadly not utf-8)
		if (!mysqli_set_charset($this->mysqli, $mysql_encoding)){
			printf('Error loading character set %s: %s<br/>mysqli_real_escape_string() might not work proper.', $mysql_encoding, $this->mysqli->error);
		}
		
		//no connection? End everything!
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	}
}

class stats_player extends stats_settings {
	public $counter;
	public $player;
	public $playtime;
	public $arrows;
	public $xpgained;
	public $joins;
	public $fishcatch;
	public $damagetaken;
	public $timeskicked;
	public $toolsbroken;
	public $eggsthrown;
	public $itemscrafted;
	public $omnomnom;
	public $onfire;
	public $wordssaid;
	public $commandsdone;

	function __construct($player){
		parent::__construct();

		$res = mysqli_query($this->mysqli, 'SELECT * FROM '.$this->prefix.'player WHERE player = "'.mysqli_real_escape_string($this->mysqli, $player).'"');

		if(mysqli_num_rows($res) < 1){
			echo 'Error! No user with given name "'.$player.'"!';
			return NULL;
		} else {
			$row = mysqli_fetch_row($res);
			$this->counter = $row[0];
			$this->player = $row[1];
			$this->playtime = $this->convert_playtime($row[2]);
			$this->arrows = $row[3];
			$this->xpgained = $row[4];
			$this->joins = $row[5];
			$this->fishcatch = $row[6];
			$this->damagetaken = $row[7];
			$this->timeskicked = $row[8];
			$this->toolsbroken = $row[9];
			$this->eggsthrown = $row[10];
			$this->itemscrafted = $row[11];
			$this->omnomnom = $row[12];
			$this->onfire = $row[13];
			$this->wordssaid = $row[14];
			$this->commandsdone = $row[15];
		}
	}

	public static function convert_playtime($pt){
		$days = floor($pt / 86400);
		$hours = floor(($pt - $days*86400) / 3600);
		$mins = floor(($pt - $hours*3600 - $days*86400) / 60);
		$secs = floor($pt - $hours*3600 - $days*86400 - $mins*60);
		return $days.'d:'.$hours.'h:'.$mins.'m:'.$secs.'s';
	}

	// moving
	public function get_movement($type = 0){
		if($type > 3 || $type < 0){
			return "Error! No movement of this type exists.";
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT distance FROM '.$this->prefix.'move WHERE player = "'.$this->player.'" AND type = '.$type);
			$row = mysqli_fetch_assoc($res);

			if(mysqli_num_rows($res) < 1){
				return 0;
			} else {
				return $row['distance'];
			}
		}
	}

	public function get_total_movement(){
		$res = mysqli_query($this->mysqli, 'SELECT SUM(distance) as dis FROM '.$this->prefix.'move WHERE player = "'.$this->player.'"');
		$row = mysqli_fetch_assoc($res);

		if(mysqli_num_rows($res) < 1){
			return 0;
		} else {
			return $row['dis'];
		}
	}

	// deaths
	public function get_deaths($cause = NULL){
		if(empty($cause)){
			$res = mysqli_query($this->mysqli, 'SELECT SUM(amount) as amn FROM '.$this->prefix.'death WHERE player = "'.$this->player.'"');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT SUM(amount) as amn FROM '.$this->prefix.'death WHERE player = "'.$this->player.'" and cause = "'.$cause.'"');
		}

		$row = mysqli_fetch_assoc($res);
		//prevent a "return NULL"
		if($row['amn'] > 0){
			return $row['amn'];
		} else {
			return 0;
		}
	}

	public function get_all_deaths($top = NULL){
		if(empty($top)){
			$res = mysqli_query($this->mysqli, 'SELECT cause, amount FROM '.$this->prefix.'death WHERE player = "'.$this->player.'"');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT cause, amount FROM '.$this->prefix.'death WHERE player = "'.$this->player.'" ORDER BY amount desc LIMIT 1');
		}
		
		if(mysqli_num_rows($res) <= 0){
			return array(array('NoDeaths', 1));
		}

		$return_arr = array();

		while($row = mysqli_fetch_assoc($res)){
				$return_arr[] = array($row['cause'], $row['amount']);
		}

		return $return_arr;
	}


	// kills
	public function get_kills($type = NULL){
		if(empty($type)){
			$res = mysqli_query($this->mysqli, 'SELECT SUM(amount) as amn FROM '.$this->prefix.'kill WHERE player = "'.$this->player.'"');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT SUM(amount) as amn FROM '.$this->prefix.'kill WHERE player = "'.$this->player.'" AND type = '.$type);
		}

		$row = mysqli_fetch_assoc($res);
		//prevent a "return NULL"
		if($row['amn'] > 0){
			return $row['amn'];
		} else {
			return 0;
		}
	}

	public function get_all_kills($top = NULL){
		if(empty($top)){
			$res = mysqli_query($this->mysqli, 'SELECT type, amount FROM '.$this->prefix.'kill WHERE player = "'.$this->player.'"');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT type, amount FROM '.$this->prefix.'kill WHERE player = "'.$this->player.'" ORDER BY amount desc LIMIT 1');
		}

		if(mysqli_num_rows($res) <= 0){
			return array(array('NoKills', 1));
		}

		$return_arr = array();

		while($row = mysqli_fetch_assoc($res)){
				$return_arr[] = array($row['type'], $row['amount']);
		}

		return $return_arr;
	}

	//blocks
	public function get_all_blocks($res_type = NULL){
		$res = mysqli_query($this->mysqli, 'SELECT sbo.blockID, q1.amn, q2.brk FROM (SELECT blockID FROM '.$this->prefix.'block WHERE player = "'.$this->player.'" GROUP BY blockID ORDER BY blockID asc) as sbo LEFT JOIN (SELECT blockID, SUM(amount) as amn FROM '.$this->prefix.'block WHERE player = "'.$this->player.'" AND break = 0 GROUP BY blockID ORDER BY blockID asc) as q1 ON sbo.blockID = q1.blockID LEFT JOIN (SELECT blockID, SUM(amount) as brk FROM '.$this->prefix.'block WHERE player = "'.$this->player.'" AND break = 1 GROUP BY blockID ORDER BY blockID asc) as q2 ON sbo.blockID = q2.blockID');

		if($res_type == 'mysql'){
			return $res;
		} else {
			$return_arr = array();

			while($row = mysqli_fetch_assoc($res)){
					$return_arr[] = array($row['blockID'], $row['amn'], $row['brk']);
			}

			return $return_arr;
		}
		
	}
	
}

class stats_global extends stats_settings {
	private $gp_res = false;

	public function get_players($by = NULL, $order = NULL, $limit = NULL){
		if($this->gp_res === false){
			if(empty($order)){
				$s = 'ORDER BY player ';
			} else {
				$s = 'ORDER BY '.mysqli_real_escape_string($this->mysqli, $by).' ';
			}

			if(!empty($order)){
				$s .= mysqli_real_escape_string($this->mysqli, $order);
			} else {
				$s .= 'asc';
			}

			if(!empty($limit)){
				$s .= ' LIMIT '.mysqli_real_escape_string($this->mysqli, $limit);
			}

			$this->gp_res = mysqli_query($this->mysqli, 'SELECT player FROM '.$this->prefix.'player '.$s);
		}

		if($row = mysqli_fetch_assoc($this->gp_res)){
		   	return new stats_player($row['player']);
		} else {
			$this->gp_res = false;
			return false;
		}
	}

	public function count_players(){
		$resource = mysqli_query($this->mysqli, 'SELECT COUNT(counter) as c FROM '.$this->prefix.'player');
		$count = mysqli_fetch_assoc($resource);
		return $count['c'];
	}

	public function get_total_distance_moved(){
		$res = mysqli_query($this->mysqli, 'SELECT SUM(distance) as dis FROM '.$this->prefix.'move');
		$row = mysqli_fetch_assoc($res);
		return $row['dis'];
	}

	public function get_total_kills(){
		$res = mysqli_query($this->mysqli, 'SELECT SUM(amount) as amn FROM '.$this->prefix.'kill');
		$row = mysqli_fetch_assoc($res);
		return $row['amn'];
	}

	public function get_total_deaths(){
		$res = mysqli_query($this->mysqli, 'SELECT SUM(amount) as amn FROM '.$this->prefix.'death');
		$row = mysqli_fetch_assoc($res);
		return $row['amn'];
	}

	public function get_kill_average(){
		$res = mysqli_query($this->mysqli, 'SELECT AVG(sk1.sumam) as amn FROM (SELECT SUM(amount) as sumam FROM '.$this->prefix.'kill GROUP BY player) as sk1');

		$row = mysqli_fetch_assoc($res);
		return $row['amn'];
	}

	public function get_death_average(){
		$res = mysqli_query($this->mysqli, 'SELECT AVG(sk1.sumam) as amn FROM (SELECT SUM(amount) as sumam FROM '.$this->prefix.'death GROUP BY player) as sk1');

		$row = mysqli_fetch_assoc($res);
		return $row['amn'];
	}


	// top functions
	public function get_top_players_move($res_type = NULL, $limit = NULL){
		if(empty($limit) || !is_integer($limit)){
			$res = mysqli_query($this->mysqli, 'SELECT player, SUM(distance) as dis FROM '.$this->prefix.'move GROUP BY player ORDER BY dis desc');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT player, SUM(distance) as dis FROM '.$this->prefix.'move GROUP BY player ORDER BY dis desc LIMIT '.$limit);			
		}

		if($res_type == 'mysql'){
			return $res;
		} else {
			$return_arr = array();

			while($row = mysqli_fetch_assoc($res)){
					$return_arr[] = array($row['player'], $row['dis']);
			}

			return $return_arr;
		}
	}

	public function get_top_players_kill($res_type = NULL, $limit = NULL){
		if(empty($limit) || !is_integer($limit)){
			$res = mysqli_query($this->mysqli, 'SELECT player, SUM(amount) as amn FROM '.$this->prefix.'kill GROUP BY player ORDER BY amn desc');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT player, SUM(amount) as amn FROM '.$this->prefix.'kill GROUP BY player ORDER BY amn desc LIMIT '.$limit);			
		}

		if($res_type == 'mysql'){
			return $res;
		} else {
			$return_arr = array();

			while($row = mysqli_fetch_assoc($res)){
					$return_arr[] = array($row['player'], $row['amn']);
			}

			return $return_arr;
		}
	}

	public function get_top_players_death($res_type = NULL, $limit = NULL){
		if(empty($limit) || !is_integer($limit)){
			$res = mysqli_query($this->mysqli, 'SELECT player, SUM(amount) as amn FROM '.$this->prefix.'death GROUP BY player ORDER BY amn desc');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT player, SUM(amount) as amn FROM '.$this->prefix.'death GROUP BY player ORDER BY amn desc LIMIT '.$limit);			
		}

		if($res_type == 'mysql'){
			return $res;
		} else {
			$return_arr = array();

			while($row = mysqli_fetch_assoc($res)){
					$return_arr[] = array($row['player'], $row['amn']);
			}

			return $return_arr;
		}
	}

	public function get_top_players_blocks_placed($res_type = NULL, $limit = NULL){
		if(empty($limit) || !is_integer($limit)){
			$res = mysqli_query($this->mysqli, 'SELECT player, SUM(amount) as amn FROM '.$this->prefix.'block WHERE break = 0 GROUP BY player ORDER BY amn desc');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT player, SUM(amount) as amn FROM '.$this->prefix.'block WHERE break = 0 GROUP BY player ORDER BY amn desc LIMIT '.$limit);			
		}

		if($res_type == 'mysql'){
			return $res;
		} else {
			$return_arr = array();

			while($row = mysqli_fetch_assoc($res)){
					$return_arr[] = array($row['player'], $row['amn']);
			}

			return $return_arr;
		}
	}

	public function get_top_players_blocks_broken($res_type = NULL, $limit = NULL){
		if(empty($limit) || !is_integer($limit)){
			$res = mysqli_query($this->mysqli, 'SELECT player, SUM(amount) as amn FROM '.$this->prefix.'block WHERE break = 1 GROUP BY player ORDER BY amn desc');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT player, SUM(amount) as amn FROM '.$this->prefix.'block WHERE break = 1 GROUP BY player ORDER BY amn desc LIMIT '.$limit);			
		}

		if($res_type == 'mysql'){
			return $res;
		} else {
			$return_arr = array();

			while($row = mysqli_fetch_assoc($res)){
					$return_arr[] = array($row['player'], $row['amn']);
			}

			return $return_arr;
		}
	}


}


class bonus_methods {
	public $map_link;
	public $tmotd;
	public $tmotd_headline;
	public $server_ip;
	public $custom_links;
	private $server_port;

	function __construct(){
		//include __dir__.'/../config_bonus.php';
		include __dir__.'/../config.php';

		//$this->tmotd = $motd;
		//$this->tmotd_headline = $motd_headline;

    if(empty($link_to_map)){
      $this->map_link = '#';
    } else {
      $this->map_link = $link_to_map;
    }

    $this->custom_links = $custom_links;
    $this->server_ip = $server_ip;
    $this->server_port = $server_port;

  }

  public function get_custom_links(){
    $links = $this->custom_links;
    $prepared_links = "";
    foreach ($links as $name => $url) {
      $prepared_links .= "<li><a href='". $url ."'><i class='icon-arrow-left'></i><span class='hidden-tablet'> ". $name ."</span></a></li>" ;
    }
    return $prepared_links;
  }

	public function check_server(){
		if(empty($this->server_ip)){
			return NULL;
		}

		if(@$fp = fsockopen($this->server_ip,$this->server_port,$errCode,$errStr,1)){
			//online
			return true;
		} else {
			//offline
			return false;
		}
		fclose($fp);
	}

	// ----------- everything below this line is not ready in this version ;)
	public function get_map(){
		if($this->map_link == '#'){
			return '<div class="alert alert-info"><strong>No map!</strong> There is no link to a map in the config, so I can\'t include one. :(</div>';
		} else {
			return '<div id="map_frame"><iframe seamless="seamless" style="width:100%;height:100%;" src="'.$this->map_link.'"></iframe></div>';
		}
	}

	public function get_motd(){
		if(!empty($this->tmotd)){
			return '<div class="row-fluid"><div class="box span12"><div class="box-header well"><h2><i class="icon-info-sign"></i> Motd</h2><div class="box-icon"><a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a><a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a></div></div><div class="box-content"><h1>'.$this->tmotd_headline.'</h1>'.$this->tmotd.'<div class="clearfix"></div></div></div></div>';
		}
	}
}
?>