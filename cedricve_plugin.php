<?php  
/* 
    Plugin Name: Support plugin (client)
    Description: This plugin allows you to communicate with the Support plugin (server). You can send Support tickets, receive global messages and personal messages from/to the Support plugin (server). The plugin uses XMLRPC to transfer (secured) information to the server. To make use of this plugin you will first need to set up the Support plugin (server). The Support plugin (server) can be downloaded <a href='http://www.cedricve.me/index.php/plugins/id/3'>here</a> and you can get more information about how it works and how you need to install it <a href=''http://www.cedricve.me/blog/2011/08/23/wordpress-support-plugin-1-0/'>here</a>.
    Author: Cédric Verstraeten
    Version: 2.0 
    Author URI: http://www.cedricve.me
    Plugin URI: http://www.cedricve.me/blog/2011/08/23/wordpress-support-plugin-1-0/
	License: GPLv2 or later
*/  



/*






 XMLRPC
 
 
 
 
 
 */
 
 
 

function display_error($r)
{
		echo "Connection failed: Make sure the settings for this client are set correctly (you can configre your client <a href='options-general.php?page=support_settings'>here</a>).";
}

function getValue($name,$data)
{
	return $data->me['struct'][$name]->me['string'];
}
	

function cedricve_news_dashboard_widget() {

    include("xmlrpc/lib/xmlrpc.inc");
	
	// Credentials
	$username = get_option('username');
	$apikey = get_option('apikey');
	
	// Client
	$c = new xmlrpc_client(get_option('server_url'));
	// Method
	$m = new xmlrpcmsg('examples.ping');
	
	// Params
	$m->addParam(new xmlrpcval($username,"string"));
	$m->addParam(new xmlrpcval(serialize(sha1($apikey)),"string"));
	
	// Send request to server
	$r =& $c->send($m);
	
	if($r->faultCode())
	{
		display_error($r);
	}
	else
	{
		$xmlstring = (htmlentities($r->serialize()));
		
		 $v=$r->value(); 
		 $max=$v->arraysize();  

		 if($max == 0)
		 	echo "No messages";
		 	
		 for($i=0; $i<$max; $i++) {    
		 	$rec=$v->arraymem($i);
		 	$id=getValue("id",$rec);
		 	$date=getValue("date",$rec);
		 	$client_id=getValue("client_id",$rec);
		 	$message=getValue("message",$rec);
		 	$border = "border-bottom:1px solid #ccc;";
		 	if($max==$i+1)
		 	$border = "";
		 	
		 	if($i==0)
		 	echo "<div style='padding:0px 0 12px 0;$border'><div style='padding-bottom:7px;'><span style='color:#666;font-size:18px;'>" . date("d",$date) . "</span> <span style='color:#666;font-size:15px;'>" . date("F Y (H:i)",$date) . "</span></div> <div>" . $message . "</div></div><div style='clear:both;'></div>";
		 	else
		 	echo "<div style='padding:12px 0 12px 0;$border'><div style='padding-bottom:7px;'><span style='color:#666;font-size:18px;'>" . date("d",$date) . "</span> <span style='color:#666;font-size:15px;'>" . date("F Y (H:i)",$date) . "</span></div> <div>" . $message . "</div></div><div style='clear:both;'></div>";
		 } 

	}

}

function cedricve_news_widget() {
	$sitename = get_option('sitename');
    wp_add_dashboard_widget( 'cedricve-news-custom-widget', "$sitename » Latest News", 'cedricve_news_dashboard_widget' );
}

add_action( 'wp_dashboard_setup', 'cedricve_news_widget' );



/*







 Admin menu item
 
 
 
 
 
 
 */
 
 
 
function cedricve_plugin_menu() {  
     add_submenu_page("options-general.php","Support settings", "Support settings", 1, "support_settings", "cedricve_xmlrpc");  
}  
  
add_action('admin_menu', 'cedricve_plugin_menu');  


function cedricve_xmlrpc()
{
	include('cedricve_xmlrpc.php');
}


function cedricve_ticket_menu() {  
     add_object_page("Support", "Support", 1, "ticket_support", "cedricve_ticket");  
}  
  
add_action('admin_menu', 'cedricve_ticket_menu');  


function cedricve_ticket()
{
	include('cedricve_ticket.php');
}



/*









 Dashboard Layout
 
 
 
 
 
 
 
*/


/*function remove_screen_options_tab()
{
    return false;
}
add_filter('screen_options_show_screen', 'remove_screen_options_tab');*/


/*function remove_menus () {
global $menu;
	//$restricted = array(__('Dashboard'), __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));
	$restricted = array( __('Appearance'), __('Tools'), __('Links'), __('Pages'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');

function filter_footer_admin() { 
	return false;
}

add_filter('admin_footer_text', 'filter_footer_admin');

function hide_help() {
    echo '<style type="text/css">
            #contextual-help-link-wrap { display: none !important; }
          </style>';
}
add_action('admin_head', 'hide_help');

add_action('admin_head', 'my_custom_logo');

function my_custom_logo() {
echo '
<style type="text/css">
#header-logo { background-image: url('.get_bloginfo('template_directory').'/images/favicon.ico) !important; }
</style>
';
}
*/
?>
