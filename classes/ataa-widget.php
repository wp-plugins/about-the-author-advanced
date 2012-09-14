<?php

class Ataa_Widget extends WP_Widget{


    function __construct(){
		$widget_ops = array( 'classname' => 'Ataa_Widget', 'description' => __( "Displays information about the author of a post/page." ));
		$this->WP_Widget( 'author_contact_info', __( 'About the Author' ), $widget_ops);
    }	
	

	function form( $instance ){
		global $wpdb;
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'exclude' => '', 'displayOn' => 1 ) );
		
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($instance['title']); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('exclude'); ?>">Exclude pages/posts: <input class="widefat" id="<?php echo $this->get_field_id('exclude'); ?>" name="<?php echo $this->get_field_name('exclude'); ?>" type="text" value="<?php echo attribute_escape($instance['exclude']); ?>" /></label><br/><small>Page IDs, separated by commas.</small></p>
		<p><label for="<?php echo $this->get_field_id('displayOn'); ?>">Display on:</label>
			<select id="<?php echo $this->get_field_id('displayOn'); ?>" name="<?php echo $this->get_field_name('displayOn'); ?>">
				<option value="1" <?php selected($instance['displayOn'],1); ?>>Posts &amp; Pages</option>
				<option value="2" <?php selected($instance['displayOn'],2); ?>>Pages</option>
				<option value="3" <?php selected($instance['displayOn'],3); ?>>Posts</option>
			</select>
		</p>
				
		<?php
		
	}
	
	// saves widgets settings.
	function update( $new_instance, $old_instance ){
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['exclude'] = strip_tags($new_instance['exclude']);
		$instance['displayOn'] = $new_instance['displayOn'];
		return $instance;
	}

	
	function widget( $args, $instance ){
		extract($args, EXTR_SKIP);
		global $wp_query;
		$options = get_option('ataa_options');
		

		
		
		$thePostID = $wp_query->post->ID;
		$theAuthorID = $wp_query->post->post_author;
		
		//Get options
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);		
		$exclude_list = empty($instance['exclude']) ? ' ' : apply_filters('widget_title', $instance['exclude']);

		
		$excluded = explode(',', $exclude_list); //convert list of excluded pages to array 
		if ( in_array($thePostID,$excluded) || is_home() ) return false;  //don't show widget if page is excluded
		if ( is_numeric($theAuthorID) && user_can( $theAuthorID, 'administrator' ) && !$options['display_admin']) return false;
		
		if( (is_single() && ($instance['displayOn'] == 2)) || (is_page() && ($instance['displayOn'] == 3 ))) return false;
		
		if(is_numeric($theAuthorID)){
					
			echo $before_widget;
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
			echo '<ul class="ataa-widget"><li>';	
				
				echo "<span class='name-title'>";
				if($options['display_name'] != 5){
					echo '<span class="name">';
						if($options['display_name'] == 2 && get_the_author_meta('user_login', $theAuthorID) != null):  echo get_the_author_meta('user_login', $theAuthorID); 
							elseif($options['display_name'] == 3 && get_the_author_meta('user_firstname', $theAuthorID) != null):  echo get_the_author_meta('user_firstname', $theAuthorID); 
							elseif($options['display_name'] == 4 && get_the_author_meta('user_lastname', $theAuthorID) != null):  echo get_the_author_meta('user_lastname', $theAuthorID); 
							else: echo get_the_author_meta('display_name', $theAuthorID); 
						endif;
					echo '</span>';
				}
				if($options['show_gravatar']){
					echo '<span class="gravatar '. $options['gravatar_align'] .'">' . get_avatar( get_the_author_meta('user_email', $theAuthorID), $size = $options['gravatar_size']) . '</span>'; 
				}	
				if($options['show_title'] && get_the_author_meta('title', $theAuthorID) != null)echo '<span class="title">'. get_the_author_meta('title', $theAuthorID) . '</span>';
				
				if($options['show_company'] && get_the_author_meta('company', $theAuthorID) != null)echo '<span class="company">'. get_the_author_meta('company', $theAuthorID) . '</span>';
				echo "</span>";
				if($options['show_bio'] && get_the_author_meta('user_description', $theAuthorID) != null) echo '<p class="bio">'.get_the_author_meta('user_description', $theAuthorID).'</p>';
				
				if($options['show_phone'] || $options['show_email'] || $options['show_web']){
					echo "<p class='contact'>";
					if($options['show_phone'] && get_the_author_meta('phone', $theAuthorID) != null){
						$phone_label = empty($options['phone_label']) ? '' : '<strong>'.$options['phone_label'].'</strong>';
						echo '<span class="phone">'. $phone_label . get_the_author_meta('phone', $theAuthorID) . '</span>';
					}
					if($options['show_email'] && get_the_author_meta('email', $theAuthorID) != null){
						$email_label = empty($options['email_label']) ? '' : '<strong>'.$options['email_label'].'</strong>';
						echo '<span class="email">'. $email_label . '<a href="mailto:'.get_the_author_meta('user_email', $theAuthorID).'">' . get_the_author_meta('user_email', $theAuthorID) . '</a></span>';
					}
					if($options['show_web'] && get_the_author_meta('user_url', $theAuthorID) != null){
						$web_label = empty($options['web_label']) ? '' : '<strong>'.$options['web_label'].'</strong>';
						echo '<span class="web">' . $web_label . '<a href="'.get_the_author_meta('user_url', $theAuthorID).'">'.get_the_author_meta('user_url', $theAuthorID).'</a></span>';
					}
					echo "</p>";
				}
				
				
				if(($options['show_twitter'] && get_the_author_meta('twitter', $theAuthorID) != null) || ($options['show_facebook'] && get_the_author_meta('facebook', $theAuthorID) != null) || ($options['show_linkedin'] && get_the_author_meta('linkedin', $theAuthorID) != null) || ($options['show_gplus'] && get_the_author_meta('gplus', $theAuthorID) != null)){
					echo "<p class='social'>";
					if($options['social_text'] != null){ echo $options['social_text'] ."<br/>"; }
					if($options['social_link']){
						if($options['show_twitter'] && get_the_author_meta('twitter', $theAuthorID) != null)echo '<span class="twitter"><a href="'.get_the_author_meta('twitter', $theAuthorID).'"><img src="'. ATAA_PLUGIN_URL .'/images/icons/'. $options['social_link'] .'/twitter.png"/></a></span>';
						if($options['show_facebook'] && get_the_author_meta('facebook', $theAuthorID) != null)echo '<span class="facebook"><a href="'.get_the_author_meta('facebook', $theAuthorID).'"><img src="'. ATAA_PLUGIN_URL .'/images/icons/'. $options['social_link'] .'/facebook.png"/></a></span>';
						if($options['show_linkedin'] && get_the_author_meta('linkedin', $theAuthorID) != null)echo '<span class="linkedin"><a href="'.get_the_author_meta('linkedin', $theAuthorID).'"><img src="'. ATAA_PLUGIN_URL .'/images/icons/'. $options['social_link'] .'/linkedin.png"/></a></span>';
						if($options['show_gplus'] && get_the_author_meta('gplus', $theAuthorID) != null)echo '<span class="gplus"><a href="'.get_the_author_meta('gplus', $theAuthorID).'"><img src="'. ATAA_PLUGIN_URL .'/images/icons/'. $options['social_link'] .'/gplus.png"/></a></span>';					
					}else{
						if($options['show_twitter'] && get_the_author_meta('twitter', $theAuthorID) != null)echo '<span class="twitter"><a href="'.get_the_author_meta('twitter', $theAuthorID).'">Twitter</a></span>';
						if($options['show_facebook'] && get_the_author_meta('facebook', $theAuthorID) != null)echo '<span class="facebook"><a href="'.get_the_author_meta('facebook', $theAuthorID).'">Facebook</a></span>';
						if($options['show_linkedin'] && get_the_author_meta('linkedin', $theAuthorID) != null)echo '<span class="linkedin"><a href="'.get_the_author_meta('linkedin', $theAuthorID).'">LinkedIn</a></span>';
						if($options['show_gplus'] && get_the_author_meta('gplus', $theAuthorID) != null)echo '<span class="gplus"><a href="'.get_the_author_meta('gplus', $theAuthorID).'">Google+</a></span>';
					}
					echo "</p>";
				}
				
			echo '</li></ul>'; 
			echo $after_widget;
		}
		

	}
	
	
	
}	




?>