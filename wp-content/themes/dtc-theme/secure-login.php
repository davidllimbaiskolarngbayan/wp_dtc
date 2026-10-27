<?php
/* Hide the WP version */
function wpsecuritypolicy_remove_version() {return '';}
add_filter('the_generator', 'wpsecuritypolicy_remove_version');

/** Begin limit access to the login page to IP addresses in an array **/
function getRealIpAddr(){
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
$whitelist = array(
	"192.46.82.5$",
	"192.46.82.36$",
	"192.46.82.7$",
	"^66\.96\.204\.[0-90-90-9]",
	"^167\.232\.\d{3}\.\d+",	
);

$current_uri =  $_SERVER['REQUEST_URI'];
if( preg_match("/\/wp-login/i", $current_uri) ){
	$show_login = false;
	foreach($whitelist as $ip_to_check){
		if (preg_match("/" . $ip_to_check . "/i", getRealIpAddr())) {
			$show_login = true;
		}
	}
	if($show_login == false){
		wp_die("Access to this page is not allowed.");
	}	
}
/** End limit access to the login page to IP addresses in an array **/

//flush_rewrite_rules();