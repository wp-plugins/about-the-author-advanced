<?php

class Acip_Edit_Options {


    function __construct(){
        add_action('admin_menu', array(&$this,'add_options_menu'));
		add_filter( 'user_contactmethods', array(&$this,'update_contactmethods') );     
    }	
	


	// Admin menu page 
	function add_options_menu() {
		add_submenu_page('options-general.php','About the Author Advanced', 'About the Author Advanced', 'edit_pages', 'ataa-settings',  array(&$this,'display_options_form'));
	}
	
	
	function display_options_form(){
		?>		
		<div class="wrap">
			<div id="icon-options-general" class="icon32"><br /></div>
			<h2>About the Author Advanced Settings</h2>
			<br/><br/>

		
			<form method="post" action="options.php">
			<?php settings_fields('ataa_plugin_options'); ?>
			<?php $options = get_option('ataa_options'); ?>				
			

			<table border="0" cellpadding="20">
			<tr valign="top">
			<td>
				<table class="widefat" cellspacing="10" style="width:500px;">
					<thead>
					<tr valign="top">
						<th colspan="2">
							General Settings
						</th>					
					</tr>					
					</thead>
					<tr valign="top">
					<td>Display if Author is Site Admin?</td>
					<td><select name="ataa_options[display_admin]"><option value="1" <?php selected($options['display_admin'], 1); ?>>Yes</option><option value="0" <?php selected($options['display_admin'], 0); ?>>No</option></select>
					</tr>	
					<tr valign="top">
					<td>Load CSS</td>
					<td><select name="ataa_options[css]"><option value="1" <?php selected($options['display_name'], 1); ?>>Yes</option><option value="0" <?php selected($options['display_name'], 0); ?>>No</option></select>
					</tr>					
				</table>		
			
				
				<table class="widefat" cellspacing="10" style="width:500px;margin-top:20px;">
					<thead>
					<tr valign="top">
						<th colspan="3">
							Widget Options
						</th>					
					</tr>
					
					</thead>
					<tr>
						<td colspan="3" style="border-bottom:0;">
							<strong>Display Options</strong>						
						</td>
					</tr>
					<tr valign="top">
						<td>
							<p><input type="checkbox" name="ataa_options[show_phone]" value="1" <?php checked($options['show_phone']); ?> id="ataa_show_phone" /> Phone</p>
							<p><input type="checkbox" name="ataa_options[show_email]" value="1" <?php checked($options['show_email']); ?> id="ataa_show_email" /> Email</p>
							<p><input type="checkbox" name="ataa_options[show_web]" value="1" <?php checked($options['show_web']); ?> id="ataa_show_website" /> Website</p>						
						</td>
						<td>
							<p><input type="checkbox" name="ataa_options[show_bio]" value="1" <?php checked($options['show_bio']); ?> id="ataa_show_bio" /> Bio</p>
							<p><input type="checkbox" name="ataa_options[show_company]" value="1" <?php checked($options['show_company']); ?> id="ataa_show_company" /> Company</p>
							<p><input type="checkbox" name="ataa_options[show_title]" value="1" <?php checked($options['show_title']); ?> id="ataa_show_title" /> Title</p>
						</td>
						<td>							
							<p><input type="checkbox" name="ataa_options[show_twitter]" value="1" <?php checked($options['show_twitter']); ?> id="ataa_show_twitter" /> Twitter</p>
							<p><input type="checkbox" name="ataa_options[show_facebook]" value="1" <?php checked($options['show_facebook']); ?> id="ataa_show_facebook" /> Facebook</p>
							<p><input type="checkbox" name="ataa_options[show_linkedin]" value="1" <?php checked($options['show_linkedin']); ?> id="ataa_show_linkedin" /> LinkedIn</p>
							<p><input type="checkbox" name="ataa_options[show_gplus]" value="1" <?php checked($options['show_gplus']); ?> id="ataa_show_linkedin" /> Google+</p>
						</td>
					</tr>	
					<tr valign="top">
					<td>Display Name</td>
					<td colspan="2"><select name="ataa_options[display_name]">
							<option value="1" <?php selected($options['display_name'], 1); ?>>Display Name</option>
							<option value="2" <?php selected($options['display_name'], 2); ?>>Username</option>
							<option value="3" <?php selected($options['display_name'], 3); ?>>First Name</option>
							<option value="4" <?php selected($options['display_name'], 4); ?>>Last Name</option>
							<option value="5" <?php selected($options['display_name'], 5); ?>>None</option>
						</select></td>
					</tr>
					<tr valign="top">
					<td>Display Gravatar</td>
					<td colspan="2"><select name="ataa_options[show_gravatar]">
							<option value="1" <?php selected($options['show_gravatar'], 1); ?>>Yes</option>
							<option value="0" <?php selected($options['show_gravatar'], 0); ?>>No</option>
						</select>
					</tr>
					<tr valign="top">
					<td>Gravatar Alignment</td>
					<td colspan="2"><select name="ataa_options[gravatar_align]">
							<option value="left" <?php selected($options['gravatar_align'], 'left'); ?>>Left</option>
							<option value="right" <?php selected($options['gravatar_align'], 'right'); ?>>Right</option>
						</select>
					</tr>
					<tr valign="top">
					<td>Gravatar Size</td>
					<td colspan="2"><select name="ataa_options[gravatar_size]">
							<option value="32" <?php selected($options['gravatar_size'], 32); ?>> 32px </option>
							<option value="48" <?php selected($options['gravatar_size'], 48); ?>> 48px </option>
							<option value="64" <?php selected($options['gravatar_size'], 64); ?>> 64px </option>
							<option value="80" <?php selected($options['gravatar_size'], 80); ?>> 80px </option>
						</select>
					</tr>
					<tr valign="top">
					<td>Social Links</td>
					<td colspan="2"><select name="ataa_options[social_link]">
							<option value="0" <?php selected($options['social_link'], 0); ?>> Link Only </option>
							<option value="16" <?php selected($options['social_link'], 16); ?>> 16px Icons </option>
							<option value="32" <?php selected($options['social_link'], 32); ?>> 32px Icons </option>
							<option value="48" <?php selected($options['social_link'], 48); ?>> 48px Icons </option>
							<option value="64" <?php selected($options['social_link'], 64); ?>> 64px Icons </option>
						</select>
					</tr>					
				</table>
										
				<p class="submit">
					<input type="submit" class="button-primary" value="Save Changes" />
				</p>
			
			</td>
			<td>
		
				<table class="widefat" cellspacing="10">
					<thead>
					<tr valign="top">
						<th colspan="2">
							Language Options
						</th>					
					</tr>					
					</thead>
					<tr valign="top">
					<td>Email Label</td>
					<td><input type="text" name="ataa_options[email_label]" value="<?php echo $options['email_label']; ?>" /></td>
					</tr>				
					<tr valign="top">
					<td>Phone Label</td>
					<td><input type="text" name="ataa_options[phone_label]" value="<?php echo $options['phone_label']; ?>" /></td>
					</tr>	
					<tr valign="top">
					<td>Web Label</td>
					<td><input type="text" name="ataa_options[web_label]" value="<?php echo $options['web_label']; ?>" /></td>
					</tr>	
					<tr valign="top">
					<td>Social Label</td>
					<td><input type="text" name="ataa_options[social_text]" value="<?php echo $options['social_text']; ?>" /></td>
					</tr>	
				</table>	

				
				<table class="widefat" cellspacing="10" style="margin-top:20px;">
					<thead>
					<tr valign="top">
						<th colspan="3">
							User Contact Fields
						</th>					
					</tr>
					<tr>
						<td>
							<strong>Contact Fields</strong>
						</td>
						<td>
							<strong>Instant Messaging</strong>
						</td>
						<td>
							<strong>Social Networking</strong>
						</td>
					</tr>
					</thead>
					<tr valign="top">
						<td>
							<p><input type="checkbox" name="ataa_options[phone]" value="1" <?php checked($options['phone']); ?> id="ataa_phone" /> Phone</p>
							<p><input type="checkbox" name="ataa_options[company]" value="1" <?php checked($options['company']); ?> id="ataa_company" /> Company</p>
							<p><input type="checkbox" name="ataa_options[title]" value="1" <?php checked($options['title']); ?> id="ataa_company_id" /> Title</p>
						</td>					
						<td>
							<p><input type="checkbox" name="ataa_options[aim]" value="1" <?php checked($options['aim']); ?> id="ataa_aim" /> AIM</p>
							<p><input type="checkbox" name="ataa_options[gchat]" value="1" <?php checked($options['gchat']); ?> id="ataa_gchat" /> gChat</p>
							<p><input type="checkbox" name="ataa_options[yim]" value="1" <?php checked($options['yim']); ?> id="ataa_yim" /> Yahoo IM</p>
						</td>					
						<td>
							<p><input type="checkbox" name="ataa_options[twitter]" value="1" <?php checked($options['twitter']); ?> id="ataa_twitter" /> Twitter</p>
							<p><input type="checkbox" name="ataa_options[facebook]" value="1" <?php checked($options['facebook']); ?> id="ataa_facebook" /> Facebook</p>
							<p><input type="checkbox" name="ataa_options[linkedin]" value="1" <?php checked($options['linkedin']); ?> id="ataa_linkedin" /> LinkedIn</p>
							<p><input type="checkbox" name="ataa_options[gplus]" value="1" <?php checked($options['gplus']); ?> id="ataa_linkedin" /> Google+</p>
						</td>
					</tr>				
				</table>
			</form>
			</td>
		</tr>
		</table>
		</div>
	  <?php 
	}

		// Update contact methods based on admin settings --
		function update_contactmethods( $contactmethods ) {		
			$options = get_option('ataa_options');
			
			if($options['phone']){ $contactmethods['phone'] = 'Phone' ; }else{ unset($contactmethods['phone']); unset($options['show_phone']);}
			if($options['aim']){ $contactmethods['aim'] = 'AIM' ; }else{ unset($contactmethods['aim']);}
			if($options['gchat']){ $contactmethods['gchat'] = 'gChat' ; }else{ unset($contactmethods['gchat']);}
			if($options['yim']){ $contactmethods['yim'] = 'Yahoo IM' ; }else{ unset($contactmethods['yim']);}
			if($options['twitter']){ $contactmethods['twitter'] = 'Twitter URL' ; }else{ unset($contactmethods['twitter']); unset($options['show_twitter']);}
			if($options['facebook']){ $contactmethods['facebook'] = 'Facebook URL' ; }else{ unset($contactmethods['facebook']); unset($options['show_facebook']);}
			if($options['linkedin']){ $contactmethods['linkedin'] = 'LinkedIn URL' ; }else{ unset($contactmethods['linkedin']); unset($options['show_linkedin']);}
			if($options['gplus']){ $contactmethods['gplus'] = 'Google+ URL' ; }else{ unset($contactmethods['gplus']); unset($options['show_gplus']);}
			if($options['company']){ $contactmethods['company'] = 'Company Name' ; }else{ unset($contactmethods['company']); unset($options['show_company']);}
			if($options['title']){ $contactmethods['title'] = 'Title' ; }else{ unset($contactmethods['title']); unset($options['show_title']);}
						
			unset($contactmethods['jabber']);		
			
	
			return $contactmethods;
		}	
		
}	

add_action('plugins_loaded', create_function('','new Acip_Edit_Options();'));

?>