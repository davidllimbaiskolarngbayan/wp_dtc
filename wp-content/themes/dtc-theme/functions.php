<?php


define('HATT_TEXTDOMAIN','dtc-theme');
load_theme_textdomain(HATT_TEXTDOMAIN, get_template_directory().'/languages/'.SITE_LANG.'/');
get_template_part('dtc_david_hattframework/class.hattFramework');
add_filter('ht_all_post_types', static function ($post_types) {
	foreach (['career', 'faq', 'ht_layout', 'learn', 'offer', 'size', 'store', 'tyres', 'video'] as $post_type) {
		unset($post_types[$post_type]);
	}
	return $post_types;
});
add_filter('ht_all_taxonomies', static function ($taxonomies) {
	foreach (['career_cat', 'learn_cat', 'offer_cat', 'store_cat', 'store_visib', 'vehicles_cat', 'video_cat', 'tyres_cat', 'tyres_feature'] as $taxonomy) {
		unset($taxonomies[$taxonomy]);
	}
	return $taxonomies;
});
require_once get_template_directory() . '/dtc-laravel.php';
require_once get_template_directory() . '/inc/dtc-claims.php';
require_once get_template_directory() . '/inc/home-page.php';
require_once get_template_directory() . '/inc/tyres.php';
require_once get_template_directory() . '/inc/tyre-import.php';
require_once get_template_directory() . '/inc/find-tyres.php';
require_once get_template_directory() . '/inc/autocare.php';
require_once get_template_directory() . '/inc/stores.php';
require_once get_template_directory() . '/inc/customer-guide.php';
require_once get_template_directory() . '/inc/promotions.php';
require_once get_template_directory() . '/inc/about.php';
require_once get_template_directory() . '/inc/accessibility.php';
require_once get_template_directory() . '/inc/contact-form.php';

// Fallback so the tyre templates render even if inc/tyres.php does not define the icon.
if (!function_exists('dtc_icon_check')) {
    function dtc_icon_check(): string
    {
        return '<svg class="dtc-icon-check" width="16" height="16" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M3 8.5l3 3 7-7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    }
}

/* Apply secure headers */
header("X-XSS-Protection: 1; mode=block");
header("X-Permitted-Cross-Domain-Policies: none");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("X-Content-Type-Options: nosniff");
header("Permissions-Policy: microphone=(), camera=(), geolocation=(self), fullscreen=()"); 
header("Content-Security-Policy: block-all-mixed-content");

//Execute this function whenever a shortcode of "get-rfq-data" is seen in the page. Displays the list of tyres selected by the user
function get_rfq_function() {

   $return_string = '<ul class="rfq-selected-tyres">';
   
	if(!empty($_GET['item'])){

			unset($_SESSION['items']);

			$tyre_type = get_post( $_GET['item'] );

			$tarr = explode(",", $_GET['item']);
			// $output = "";

			foreach ($tarr as $tid) {
				$tyre = get_post($tid);
				// print_r($tyre);

				$return_string .= '<li class="" id="'.$tyre->ID.'">
										<div class="row">
											<div class="col-md-9 col-xs-9"><span>'.$tyre->post_title.'</span></div>
											<div class="col-md-3 col-xs-3 text-right"><span><img id="'.$tyre->ID.'" class="rfq-remove" src="'.home_url().'/wp-content/themes/dtc-theme/images/store-main-close.png" alt="remove"></span></div>
											</div>
										</li>';
			}

			// var_dump($tarr);

			// exit;
/*
			$return_string .= 	'<li class="" id="'.$tyre_type->ID.'">
									<div class="row">
										<div class="col-md-9"><span>'.$tyre_type->post_title.'</span></div>
										<div class="col-md-3"><span><img id="'.$tyre_type->ID.'" class="hidden-xs rfq-remove" src="'.home_url().'/wp-content/themes/dtc-theme/images/store-main-close.png" alt="remove"></span></div>
									</div>
								</li>';*/


	}else{
		
		if(isset($_COOKIE['items'])){
			$arr = array();
			$exploded = explode(',', rtrim($_COOKIE['items'],','));
			for($i = 0; $i < count($exploded); $i++) {
				$data = explode(':', $exploded[$i]);
				array_push($arr, array(
					'id' => $data[0],
					'name' =>  $data[1],
				));
			}
		   	foreach($arr as $key=>$value){
				   $return_string .= '<li class="" id="'.$value['id'].'">
									<div class="row">
										<div class="col-md-9 col-xs-9"><span>'.$value['name'].'</span></div>
										<div class="col-md-3 col-xs-3  text-right"><span><img id="'.$value['id'].'" class=" rfq-remove" src="'.home_url().'/wp-content/themes/dtc-theme/images/store-main-close.png" alt="remove"></span></div>
									</div>
								</li>';

		   }
		}

	}
	
   $return_string .= '</ul>';
	
   return $return_string;
}
add_shortcode('get-rfq-data', 'get_rfq_function');

function get_rfq_list_title(){
	session_start();
	$return_string = '';

	if(!empty($_SESSION['items']) && !isset($_GET['item'])) {

		if( isset($_SESSION['items']) ){
			foreach ( $_SESSION['items'] as $key => $value ) {
				if( $_SESSION['items'][$key]['set_list'] == 'on' ){
						 $compare_item_return =  $_SESSION['items'][$key]['id'];
					break;
				}
			}
		}


		$edit_url = ($_COOKIE['findtyre'] == 'vehicle') ? 'compare_item_return='.$compare_item_return.'&type=vehicle#tf' : '&type=size';

		if( isset($compare_item_return) && $_COOKIE['findtyre'] == 'vehicle' ){

			$tf = (empty($_COOKIE['rfq-vehicle-list']) ) ? '':   '#tf';
			 $edit_url = 'rfq_req_tyre='.$compare_item_return.'&type=vehicle'.$tf ;
		}

		if( isset($compare_item_return) && $_COOKIE['findtyre'] == 'size'  ){
			 $edit_url = 'compare_item_return='.$compare_item_return.'&type=size#tf';
		}

		$return_string = '<div class="right-box detail"><strong>'.__("Your Selected Tyres",HATT_TEXTDOMAIN).'</strong>�<span style="float: right;"><a class="edit-selected-tyres" href="'.home_url().'/filter-tyre/request-for-quote?'.$edit_url.'">Edit</a></span></div>';			}


	return $return_string;
}
add_shortcode('rfq-list-title','get_rfq_list_title');

function get_rfq_vehicle_list_title(){
	session_start();
	$return_string = '';
	if(!empty($_COOKIE['rfq-vehicle-list']) && empty($_GET['item'])){
		$type = ($_COOKIE['findtyre'] == 'vehicle') ? 'Vehicle' : 'Tyre Size';

		//$_SESSION['items'][$key]['id']

		if( isset($_SESSION['items']) ){
			foreach ( $_SESSION['items'] as $key => $value ) {
				if( $_SESSION['items'][$key]['set_list'] == 'on' ){
					$compare_item_return =  $_SESSION['items'][$key]['id'];
					break;
				}
			}
		}

		if($compare_item_return){
			$edit_url = ($_COOKIE['findtyre'] == 'vehicle') ? 'compare_item_return='.$compare_item_return.'&type=vehicle#tf' : '&type=size';
		}else{
			$edit_url = ($_COOKIE['findtyre'] == 'vehicle') ? 'type=vehicle#tf' : 'type=size#tf';
		}

		if( isset($compare_item_return) && $_COOKIE['findtyre'] == 'vehicle' ){
			$edit_url = 'rfq_req_tyre='.$compare_item_return.'&type=vehicle#tf';
		}

		if( isset($compare_item_return) && $_COOKIE['findtyre'] == 'size'  ){
			$edit_url = 'compare_item_return='.$compare_item_return.'&type=size#tf';
		}
				

		//$edit_url = ( isset($_SESSION['rfq-last-selected-id']) ) ? "compare_item_return=".$_SESSION['rfq-last-selected-id'] : "type=".$type;

		$return_string = '<p class="title"><strong>Your Selected '.$type.'</strong> <span style="float: right;"><a class="edit-selected-vehicle" href="'.home_url().'/filter-tyre/request-for-quote?'.$edit_url.'">Edit</a></span></p>';
	}

	if(!empty($_GET['item'])){

		unset($_SESSION['vehicle_term']);
		$_SESSION['items'] = array();

		$tyre_type = get_post( $_GET['item'] );
		$return_string = '<p class="title"><strong>Your Selected Tyre</strong> <span style="float: right;"><a class="edit-selected-vehicle" href="'.home_url().'/filter-tyre/request-for-quote?type=vehicle">Edit</a></span></p>';

		array_push($_SESSION['items'], array('id'=>$tyre_type->ID,'name'=>$tyre_type->post_title,'set_list'=>"on"));

	}
	
	return $return_string;
}
add_shortcode('get-rfq-vehicle-title','get_rfq_vehicle_list_title');

function get_rfq_filters(){
	session_start();
	$return_string = ''; 
	if(isset($_COOKIE['rfq-vehicle-list']) and !empty($_COOKIE['rfq-vehicle-list'])){
		$return_string = '<div class="selected-vehicle">'.$_COOKIE['rfq-vehicle-list'].'</div>';
	}

	
	return $return_string;
}
add_shortcode('get-rfq-filters-data','get_rfq_filters');


//set checkboxes to checked/uncheck if they are on the list of tyres selected
function checkifselected($id,$dom){
	$checked = "uncheck";
	

	if(isset($_SESSION['items'])){
		if($dom==1){
			foreach($_SESSION['items'] as $key => $value){
				if(in_array($id,$_SESSION['items'][$key]) and $_SESSION['items'][$key]['set_list']=="on"){
					$checked = "checked='checked'";
				}
			}
		}
		else{
			foreach($_SESSION['items'] as $key => $value){
				if(in_array($id,$_SESSION['items'][$key]) and $_SESSION['items'][$key]['set_list']=="on"){
					$checked = "checked";
				}
			}
		}
	}
		
	return $checked;
}

function add_tyre_on_list($tyre_name,$id){
	session_start();
		
	unset($_COOKIE['rfq-vehicle-list'] );
    
	if(!isset($_SESSION['items'])){
		$_SESSION['items'] = array();
	}

	$exists = false;

	foreach($_SESSION['items'] as $key => $value){
		if($value['id']==$id){
			$exists = true;
			$_SESSION['items'][$key]['set_list'] = 'on';
		}
	}

	//turn on set_list
	if(!$exists){
		array_push($_SESSION['items'], array('id'=>$id,'name'=>$tyre_name,'set_list'=>"on"));
	}
	
}

function get_tyre_list(){
	$num_items = count($_SESSION['items'] ?? []);
	$a = 0;
	$comma = ", ";
	$return_string = "";
	
	if(isset($_SESSION['items'])){
		foreach($_SESSION['items'] as $key => $value){
			
			if($a==($num_items-1)){
				$comma = "";
			}
			
			$return_string .= $_SESSION['items'][$key]['name'].$comma;
			
			$a++;
		}
	
	}	
	
	echo $return_string;
	wp_die();
}
add_action( 'wp_ajax_nopriv_get_tyre_list', 'get_tyre_list' );
add_action( 'wp_ajax_get_tyre_list', 'get_tyre_list' );

function get_vehicle_filters(){
	session_start();
	if(!empty($_COOKIE['rfq-vehicle-list'])){
		echo $_COOKIE['rfq-vehicle-list'];
	}
	
	wp_die();
}
add_action( 'wp_ajax_nopriv_get_vehicle_filters', 'get_vehicle_filters' );
add_action( 'wp_ajax_get_vehicle_filters', 'get_vehicle_filters' );

function unset_tyre_list(){
	unset($_SESSION['items']);
	
	echo "tyre list unset!";
	wp_die();
}
add_action( 'wp_ajax_nopriv_unset_tyre_list', 'unset_tyre_list' );
add_action( 'wp_ajax_unset_tyre_list', 'unset_tyre_list' );




//Sets the tyre to on or off if tyre is checked/unchecked by the user. The tyre will be added instead if still not part of the list.
function rfq_ajax_set_items() {
	try {
		$arr = array();
		if(!isset($_COOKIE['items'])){
			$arr = array();
		} else {
			echo $_COOKIE['items'];
			$exploded = explode(',', rtrim($_COOKIE['items'],','));
			for($i = 0; $i < count($exploded); $i++) {
				$data = explode(':', $exploded[$i]);
				array_push($arr, array(
					'id' => $data[0],
					'name' =>  $data[1],
				));
			}
			// $arr = json_decode(str_replace('\\','',$_COOKIE['items']), true);
		}
		if($_GET['set_list'] == 'on') {
			array_push($arr, array(
				'id' => $_GET['item_id'],
				'name' => $_GET['item_title'],
			));
		} else {
			for($i = 0; $i < count($arr); $i++) {
				if($arr[$i]['id'] == $_GET['item_id']) {
					unset($arr[$i]);
					break;
				}
			}
		}
		
		$str = '';
		for($i = 0; $i < count($arr); $i++) {
			$str .= $arr[$i]['id'] .':'.$arr[$i]['name'];
			$str .= ',';
		}
		setCookie('items', $str, time()+6000, '/', 'dtc.local', true, true);

		echo '<pre>';
		print_r($_COOKIE['items']);
		echo '</pre>';
		wp_die();
	}catch(Exception $e) {
		echo $e;
		wp_die();

	}
	
    
}

add_action( 'wp_ajax_nopriv_rfq_ajax_set_items', 'rfq_ajax_set_items' );
add_action( 'wp_ajax_rfq_ajax_set_items', 'rfq_ajax_set_items' );


//Sets the tyre to on or off if tyre is checked/unchecked by the user. The tyre will be added instead if still not part of the list.
function rfq_set_side_form() {
	session_start();

	$_COOKIE['rfq-vehicle-list'] = $_GET['last_selected_name'];
	$_SESSION['rfq-last-selected-id'] = $_GET['last_selected_id'];
    
  	wp_die();
}

add_action( 'wp_ajax_nopriv_rfq_set_side_form', 'rfq_set_side_form' );
add_action( 'wp_ajax_rfq_set_side_form', 'rfq_set_side_form' );


function state_form_handler($formData)
{
    $formName = 'Request For Quote'; // change this to your form's name
    $fieldName = 'state-133'; // change this to your field's name
    $newFieldName = $fieldName . '_email';
    return form_with_pipes_handler($formName, $fieldName, $newFieldName, $formData);
}
 
function form_with_pipes_handler($formName, $fieldName, $newFieldName, &$formData)
{
    if ($formData &&
            $formName == $formData->title &&
            property_exists($formData, 'WPCF7_ContactForm') &&
            method_exists($formData->WPCF7_ContactForm, 'form_scan_shortcode')) {
 
        $scanned_form_tags = $formData->WPCF7_ContactForm->form_scan_shortcode();
        $emailSelected = $formData->posted_data[$fieldName];
        $valueSelected = null;
        foreach ($scanned_form_tags as $tag) {
            if ($tag['name'] == $fieldName) {
                foreach ($tag['raw_values'] as $rawValue) {
                    // value|email
                    $valuesArray = explode('|', $rawValue);
                    if (count($valuesArray) == 2 && $valuesArray[1] == $emailSelected) {
                        $valueSelected = $valuesArray[0];
                        break;
                    }
                }
            }
            if ($valueSelected != null) {
                break;
            }
        }
        if ($valueSelected != null) {
            $formData->posted_data[$fieldName] = $valueSelected;
            $formData->posted_data[$newFieldName] = $emailSelected;
        }
    }
    return $formData;
}
 
add_filter('cfdb_form_data', 'state_form_handler');


function continue_to_rfq() {

	echo   ( isset($_COOKIE['rfq-vehicle-list']) && !empty($_COOKIE['rfq-vehicle-list']) ) ? 'true' : '';

	wp_die();

}

add_action( 'wp_ajax_nopriv_continue_to_rfq', 'continue_to_rfq' );
add_action( 'wp_ajax_continue_to_rfq', 'continue_to_rfq' );



if(SITE_LOCALE == 'in'){
	add_filter( 'wpseo_title', 'yoastMetatitle', 10, 1 );
	add_filter( 'wpseo_metadesc', 'yoastMetadesc', 10, 1 );
	add_filter( 'wpseo_canonical', 'yoastCanonical', 10, 1 );

	$current_uri =  $_SERVER['REQUEST_URI'] ;
	if( preg_match("/\/store/i", $current_uri) ){
		add_filter( 'wpseo_title', 'storeTitle', 10, 1 );
		add_filter( 'wpseo_metadesc', 'storeDesc', 10, 1 );
	}
}


function storeTitle($defaultMeta){
	return __("Tyre Store Locator | Find David Tyre Company Tyre Dealer in India", HATT_TEXTDOMAIN );
}
function storeDesc($defaultMeta){
	return __("David Tyre Company Tyre Store Locator - Locate our nearest Tyre shop & Dealer in India.  Get more information about our best tyres in India from our store locator", HATT_TEXTDOMAIN );
}



function yoastMetadesc($defaultMeta) {

   global $wp_query;

	switch ($wp_query->query_vars['category']) {
		case 'passenger-tyres':
			$desc = "Passenger Tyre - Checkout David Tyre Company Passenger Tyres Online in India. See David Tyre Company Passenger Tyre specifications, tyre sizes, features & benefits.";
			break;		

		case 'performance-tyres':
			$desc = "Performance Tyre - Checkout David Tyre Company Performance Tyres Online in India. See David Tyre Company Performance Tyre specifications, tyre sizes, features & benefits.";
			break;

		case 'suv-4x4-tyres':
			$desc = "SUV & 4x4 Tyre - Checkout David Tyre Company SUV & 4x4 Tyres Online in India. See David Tyre Company SUV & 4x4 Tyre specifications, tyre sizes, features & benefits.";
			break;
		
		default:
			$desc = $defaultMeta;
			break;
	}

	return $desc;
}


function yoastMetatitle($defaultMeta) {
   global $wp_query;

	switch ($wp_query->query_vars['category']) {
		case 'passenger-tyres':
			$title = "Passenger Tyre | David Tyre Company Passenger Tyres Online in India";
			break;		

		case 'performance-tyres':
			$title = "Performance Tyre | David Tyre Company Performance Tyres Online in India";
			break;

		case 'suv-4x4-tyres':
			$title = "SUV Tyre | 4x4 Tyre | David Tyre Company SUV & 4x4 Tyre Online in India";
			break;
		
		default:
			$title = $defaultMeta;
			break;
	}

	return $title;
}

function yoastCanonical($defaultCan) {
   global $wp_query;

	switch ($wp_query->query_vars['category']) {
		case 'passenger-tyres':
			$title = "http://dtc.local/tyre/passenger-tyres";
			break;		

		case 'performance-tyres':
			$title = "http://dtc.local/tyre/performance-tyres";
			break;

		case 'suv-4x4-tyres':
			$title = "http://dtc.local/tyre/suv-4x4-tyres";
			break;
		
		default:
			$title = $defaultMeta;
			break;
	}

	return $title;
}


// PII user role
// remove_role('pii_access');
$role = add_role( 'pii_access', 'PII', array() );
if (null !== $role) {
	$role->add_cap('read');
}

// Clean the search parameter
function clean_query_vars(){
	$rawvar = sanitize_text_field(get_query_var("s"));
	set_query_var("s",  $rawvar);
	
	$rawvar = sanitize_text_field(get_query_var("zpo"));
	set_query_var("zpo",  $rawvar);

	$rawvar = sanitize_text_field(get_query_var("uhp_rof"));
	set_query_var("uhp_rof",  $rawvar);
	
	if (isset($_POST["veh_cat[0]"])) $_POST["veh_cat[0]"] = sanitize_text_field($_POST["veh_cat[0]"]); 
	if (isset($_POST["veh_cat[1]"])) $_POST["veh_cat[1]"] = sanitize_text_field($_POST["veh_cat[1]"]);
	if (isset($_POST["veh_cat[2]"])) $_POST["veh_cat[2]"] = sanitize_text_field($_POST["veh_cat[2]"]);
	if (isset($_POST["veh_cat[3]"])) $_POST["veh_cat[3]"] = sanitize_text_field($_POST["veh_cat[3]"]);
	if (isset($_POST["veh_size_field_1"])) $_POST["veh_size_field_1"] = sanitize_text_field($_POST["veh_size_field_1"]);
	if (isset($_POST["range"])) $_POST["range"] = sanitize_text_field($_POST["range"]);
}
add_filter( 'pre_get_posts', 'clean_query_vars' );

/* check if user using smaller mobile device */
function my_wp_is_mobile() {
include_once ( get_template_directory() . '/Mobile_Detect.php');
$detect = new Mobile_Detect;
if( $detect->isMobile() && !$detect->isTablet() ) {
return true;
} else {
return false;
}
}
 
/* check if user using tablet device */
function my_wp_is_tablet() {
include_once ( get_template_directory() . '/Mobile_Detect.php');
$detect = new Mobile_Detect;
if( $detect->isTablet() ) {
return true;
} else {
return false;
}
}

/* check if user using iPhone device */
function my_wp_is_iPhone() {
include_once ( get_template_directory() . '/Mobile_Detect.php');
$detect = new Mobile_Detect;
if( $detect->isMobile() && !$detect->isTablet() && $detect->isiOS()) {
return true;
} else {
return false;
}
}
/* ./IN metadata */
/***** DTC ajax call *****/
add_action( 'wp_ajax_nopriv_dtc_get_store_area_state', 'dtc_get_store_area_state' );
add_action( 'wp_ajax_dtc_get_store_area_state', 'dtc_get_store_area_state' );

add_action( 'wp_ajax_nopriv_dtc_get_retailers', 'dtc_get_retailers' );
add_action( 'wp_ajax_dtc_get_retailers', 'dtc_get_retailers' );

add_action( 'wp_ajax_nopriv_dtc_submit', 'dtc_submit' );
add_action( 'wp_ajax_dtc_submit', 'dtc_submit' );

add_action( 'wp_ajax_nopriv_dtc_check_registry', 'dtc_check_registry' );
add_action( 'wp_ajax_dtc_check_registry', 'dtc_check_registry' );

// Add link rel="prev" and link rel="next tags within head tag
function rel_next_prev(){
	global $paged;
	global $query;

	if(basename( get_page_template() ) == 'template-news.php') {
		if ( get_previous_posts_link() ) {
			echo '<link rel="prev" href="' . get_pagenum_link( $paged - 1 ). '" />';
		}
		if ( get_next_posts_link('', $query->max_num_pages) ) {
			echo '<link rel="next" href="'. get_pagenum_link( $paged +1 ).'" />';
		}
	}
}
add_action( 'wp_head', 'rel_next_prev' );

// For subpages of archives, this adds noindex, follow robot tag within the head tag
add_filter( 'wpseo_robots', 'my_robots_func' );
function my_robots_func( $robotsstr ) {
	if ( is_page() && is_paged() ) {
		return 'noindex,follow';		
	}
	return $robotsstr;
}

// Add noindex, follow robot tag within the head tag if the querystring match
function add_noindex_match_page(){
	$query_string = $_SERVER['REQUEST_URI'];
	$query_string_array = array("/?taxonomy=&term=about-us");

	if (in_array($query_string, $query_string_array )) {	
		echo '<meta name="robots" content="noindex,follow"/>';
	}
}
add_action( 'wp_head', 'add_noindex_match_page' );

/* REMOVE WP EMOJI */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/* Prevent the caching of wp seo xml sitemap */
add_filter('wpseo_enable_xml_sitemap_transient_caching', '__return_false');

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
    "112.198.226.59"    => "DXC_Hannah",
    "112.206.71.165"    => "GY_Ernee",
    "128.77.24.192"    => "GY_Ernee2",
    "167.232.235.15"    => "GY_Ernee3",
    "112.206.97.57"    => "GY_Lance",
	"152.32.98.144"    => "DXC_David",
	"110.235.183.41" => "DXC_Lessa",
	"136.226.235.16" => "DXC_Lessa"
);

$current_uri =  $_SERVER['REQUEST_URI'];
if( preg_match("/\/secure_login_1223/i", $current_uri) ){
    $show_login = false;
    foreach($whitelist as $ip_to_check => $identifier){
        if (preg_match("/" . $ip_to_check . "/i", getRealIpAddr())) {
            $show_login = true;
            break; // No need to continue once a match is found
        }
    }
    if($show_login == false){
        wp_die("Access to this page is not allowed.");
    }   
}
/** End limit access to the login page to IP addresses in an array **/

/**
 * Redirect to the homepage all users trying to access feeds.
 */
function disable_feeds() {
	wp_redirect( home_url() );
	die;
}

// Disable global RSS, RDF & Atom feeds.
add_action( 'do_feed',      'disable_feeds', -1 );
add_action( 'do_feed_rdf',  'disable_feeds', -1 );
add_action( 'do_feed_rss',  'disable_feeds', -1 );
add_action( 'do_feed_rss2', 'disable_feeds', -1 );
add_action( 'do_feed_atom', 'disable_feeds', -1 );

// Disable comment feeds.
add_action( 'do_feed_rss2_comments', 'disable_feeds', -1 );
add_action( 'do_feed_atom_comments', 'disable_feeds', -1 );

// Prevent feed links from being inserted in the <head> of the page.
add_action( 'feed_links_show_posts_feed',    '__return_false', -1 );
add_action( 'feed_links_show_comments_feed', '__return_false', -1 );
remove_action( 'wp_head', 'feed_links',       2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );


/*
 * Add integrity hash on enqueued scripts
 */
add_filter('script_loader_tag', 'add_attribs_to_scripts', 10, 3);

function add_attribs_to_scripts($tag, $handle, $src)
{
     if ('videojs' == $handle) {
        if (!preg_match(":\sintegrity(=|>|\s):", $tag)) {
            $tag = preg_replace(':(?=></script>):', ' integrity="sha384-fHPlA4wkTwMGegxOCV51y+Mga852Y2645q0fL+qP5DzWYXAHN4Qfu1y0H0KcTGD5" crossorigin="anonymous"', $tag, 1);
        }
        return $tag;
    }

    return $tag;
}


//include_once ( get_template_directory() . '/acf-export.php');

    // Redirect to the new page URL

//add_action( 'template_redirect', 'custom_page_redirect' );

//	function custom_page_redirect() {
		
	//	if ( is_page( array( 'register-your-tyres', 'check-warranty' ) ) ) { 
			
		//	wp_safe_redirect( 'https://dtc.local/dtc-under-maintenance/', 301 );
		//	exit(); 
	//}
//}

/*
 * SMTP Mail sender help you to prevent mail goes to spam folder
 */
if ( !function_exists('sc_smtp_mail_sender') ) :
 
    add_action( 'phpmailer_init', 'sc_smtp_mail_sender' );
 
    function sc_smtp_mail_sender( $phpmailer ) {
        $settings = function_exists('dtc_contact_smtp_settings') ? dtc_contact_smtp_settings() : null;
        $phpmailer->isSMTP();

        if (!$settings) {
            $phpmailer->Host = '127.0.0.1';
            $phpmailer->Port = 1;
            $phpmailer->SMTPAuth = false;
            return;
        }

        $phpmailer->Host = $settings['host'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = (int) $settings['port'];
        $phpmailer->Username = $settings['username'];
        $phpmailer->Password = $settings['password'];
        $phpmailer->SMTPSecure = $settings['encryption'];
        $phpmailer->SMTPAutoTLS = true;
        $phpmailer->Timeout = 15;
        $phpmailer->SMTPDebug = 0;
        $phpmailer->CharSet = 'UTF-8';
        $phpmailer->From = $settings['from'];
        $phpmailer->FromName = $settings['from_name'];
        $phpmailer->Sender = $settings['from'];
    } 
 
endif;

// function add_custom_http_header($args, $url) {
//     // Add custom headers only for specific URLs
//     if (strpos($url, 'wp-admin') !== false) {
//         $args['headers']['apbswapaa'] = 'iZIRdZCc0tT7OyMsgMrCs25hWS8tlwHONX2XZPG3csHcJdXOon';
//     }

//     return $args;
// }
// add_filter('http_request_args', 'add_custom_http_header', 10, 2);

function add_custom_cookie_admin() {
	$cookie_expiry = time()+86400;
	$cookie_path = "/";
	$cookie_domain = $_SERVER['HTTP_HOST'];
	setcookie("apbswapaa", 'iZIRdZCc0tT7OyMsgMrCs25hWS8tlwHONX2XZPG3csHcJdXOon', ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
}
add_action('wp_login', 'add_custom_cookie_admin');

add_action('wp_logout', 'remove_custom_cookie_admin');
function remove_custom_cookie_admin() {
  setcookie('apbswapaa', '', time() - 3600);
}

/* Function for custom redirection
add_action('template_redirect', 'redirectBySlug');

function redirectBySlug() {
    $seo_jsonfile = __DIR__ . "/dtc_david_hattframework/helpers/custom-redirection/redirect_meta_data.json";

    if (file_exists($seo_jsonfile)) {
        $metadata_json = file_get_contents($seo_jsonfile);
		
        $metadata = json_decode($metadata_json, true);
        $current_url = $_SERVER['REQUEST_URI'];

	
        foreach ($metadata['metadata'] as $redirect_rule) {
			
            if ($redirect_rule['is_active'] && $redirect_rule['from_url'] === $current_url) {
				
                $error_code = isset($redirect_rule['error_code']) ? (int)$redirect_rule['error_code'] : 302; // Default to 302 if not set

                // Ensure the error_code is a valid redirect status code or handle 404
                if (in_array($error_code, [301, 302, 303, 307, 308])) {
                    wp_redirect($redirect_rule['to_url'], $error_code);
                    exit();
                } elseif ($error_code == 404) {
                    // Handle the 404 error
                    status_header(404);
                    wp_redirect($redirect_rule['to_url']);
                    exit();
                } else {
                    // Handle invalid error_code if needed
                    // Log the error, or set a default redirection status
                    wp_redirect($redirect_rule['to_url']); // Default to 302 if error_code is invalid
                    exit();
                }
            }
        }
    }
} */

/* Begin custom SEO 

add_action('wp_head', 'custom_output_meta_tags');

function custom_output_meta_tags() {
    // Constructing the file path to the JSON file
    $seo_jsonfile_path = __DIR__ . "/dtc_david_hattframework/helpers/custom_seo/seo_meta_data.json";

    // Check if the JSON file exists
    if (!file_exists($seo_jsonfile_path)) {
        echo "SEO JSON file does not exist.";
        return;
    }

    // Read and decode the JSON file
    $seo_jsonfile = file_get_contents($seo_jsonfile_path);
    if ($seo_jsonfile === false) {
        echo "Failed to read SEO JSON file.";
        return;
    }

    // Decode JSON data into a PHP array
    $seo_data = json_decode($seo_jsonfile, true);

    // Validate the JSON data structure
    if ($seo_data === null || !isset($seo_data['metadata']) || !is_array($seo_data['metadata'])) {
        echo "Invalid SEO JSON data format.";
        return;
    }

    // Get the current slug from the URL
    $current_slug = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    // Search for meta data for the current slug
    $meta_data = null;
    foreach ($seo_data['metadata'] as $metadata) {
        if ($current_slug === trim(parse_url($metadata['url'], PHP_URL_PATH), '/')) {
            $meta_data = $metadata;
            break;
        }
    }

    // Output meta tags if meta data found
    if ($meta_data !== null) {
        // Output title tag
        if (!empty($meta_data['title']) && $meta_data['title'] !== '') {
            echo '<title>' . esc_html($meta_data['title']) . '</title>' . "\n";
        }

        // Output description meta tag
        if (!empty($meta_data['description']) && $meta_data['description'] !== '') {
            echo '<meta name="description" content="' . esc_attr($meta_data['description']) . '" />' . "\n";
        }

        // Output keywords meta tag
        if (!empty($meta_data['keywords']) && $meta_data['keywords'] !== '') {
            echo '<meta name="keywords" content="' . esc_attr($meta_data['keywords']) . '" />' . "\n";
        }
    }
}


 End custom SEO */

add_filter( 'wp_sitemaps_post_types', function( $post_types ) {
    // Replace 'your_cpt_slug' with your actual post type slug
    unset( $post_types['ht_layout'] );
	unset( $post_types['size'] );
    return $post_types;
} );

add_filter( 'wp_sitemaps_add_provider', function( $provider, $name ) {
    // Check if the provider name is 'users'
    if ( 'users' === $name ) {
        return false; // Return false to disable this provider
    }
    return $provider;
}, 10, 2 );

//Hide WordPress-related metadata from HTML
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rest_output_link_wp_head');