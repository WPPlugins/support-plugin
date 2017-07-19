<?php

// Option page

?>

	<?php
		
		if($_POST['oscimp_hidden'] == 'Y') {
			//Form data sent
			$server_url = $_POST['server_url'];
			update_option('server_url', $server_url);
			
			$username = $_POST['username'];
			update_option('username', $username);

			$apikey = $_POST['apikey'];
			update_option('apikey', $apikey);
			
			$sitename = $_POST['sitename'];
			update_option('sitename', $sitename);
			
			$support_text = $_POST['support_text'];
			update_option('support_text', $support_text);
			
			$admin_mail = $_POST['admin_mail'];
			update_option('admin_mail', $admin_mail);
			?>
			<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
			<?php
		} else {
			//Normal page display
			$server_url = get_option('server_url');
			$username = get_option('username');
			$apikey = get_option('apikey');
			$sitename = get_option('sitename');
			$admin_mail = get_option('admin_mail');
			$support_text = get_option('support_text');
			if($support_text == "")
				$support_text = "If you have a question or problem, please submit a ticket. Our support team will take care of your ticket and provide a solution as fast as possible.";
		}
	?>

<div class="wrap">  
    <?php    echo "<h2>" . __( 'Client settings', 'cedricve_trdom' ) . "</h2>"; ?>  
  	<p style='width:500px;'>The client settings can be found on the server. If you don't have the server yet, you first will need to install and configure the server before you can use this client plugin, you can download the server script <a href='http://www.cedricve.me'>here</a>.</p>
  	
    <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
        <input type="hidden" name="oscimp_hidden" value="Y">  
        <table>
        <tr><td><?php _e("Server url: " ); ?></td><td style='color:#aaa;'><input type="text" name="server_url" value="<?php echo $server_url; ?>" size="20"> (Url to the server.php file)</td></tr> 
        <tr><td><?php _e("Username: " ); ?></td><td style='color:#aaa;'><input type="text" name="username" value="<?php echo $username; ?>" size="20"> (Username created on the server admin panel)</td></tr>  
        <tr><td><?php _e("Api-key: " ); ?></td><td style='color:#aaa;'><input type="text" name="apikey" value="<?php echo $apikey; ?>" size="20"> (Api-key created on the server admin panel)</td></tr>  
<tr><td><?php _e("Admin e-mail: " ); ?></td><td style='color:#aaa;'><input type="text" name="admin_mail" value="<?php echo $admin_mail; ?>" size="20"> (Notification message will be sent to this e-mail)</td></tr>  
         <tr><td colspan="2"><?php    echo "<br><h2>Global Settings</h2><br>"; ?></td></tr>
         <tr><td><?php _e("Site name: " ); ?></td><td style='color:#aaa;'><input type="text" name="sitename" value="<?php echo $sitename; ?>" size="20"> (Header for the dashboard message plugin)</td></tr>  
        <tr><td style='vertical-align:top; margin-top:0;'><?php _e("Support text: " ); ?></td><td style='color:#aaa;vertical-align:top; margin-top:0; '><textarea cols="40" rows="5" name="support_text"><?php echo $support_text; ?></textarea> (Text displayed on the support tab)</td></tr>  
  
        <tr><td class="submit" colspan="2">  
        <input type="submit" name="Submit" value="<?php _e('Update Options', 'cedricve_trdom' ) ?>" />  
        </td></tr> 
        </table>
    </form>  
</div>  


	
<?php



?>