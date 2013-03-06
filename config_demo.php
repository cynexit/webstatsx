<?php
// necessary to work
$mysql_host = 'localhost'; // or 127.0.0.1
$mysql_user = 'MYSQL_USER';
$mysql_pass = 'MYSQL_PASSWORD';
$mysql_db = 'MYSQL_DATABASE_NAME';
$mysql_encoding = 'latin1';  // this is recommended because the plugin creates all its tables with latin1 encoding
$prefix = 'Stats_'; // [default=stats]



/*########################
 optional stuff
########################*/

//--- online/offline check
$server_ip = 'example.com'; // can be an real ip or an dns alias
$server_port = 25565; // [default=25565]

//--- add a link to the online map
$link_to_map = "http://".$server_ip . ":8123";
// Don't want the link to be displayed? Uncomment the next line!
//$link_to_map = ""

//--- add custom links to the menu
$custom_links = array(
  "Dynamap" => $link_to_map,
  "Mojang" => "http://mojang.com"
);

//--- enable the server stats page [beta]
$enable_server_page = false; //BETA!! Needs some special rights your webserver might not have on the host system
?>
