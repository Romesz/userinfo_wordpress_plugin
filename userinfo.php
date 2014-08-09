<?php
/*
  Plugin Name: User Info
  Description: User Information
  Version: 1.0
  Author: Romano Firtermaiszter
 */

class UserInfo extends WP_Widget 
{
	function __construct()
    {
		parent::__construct(
			'userinfo_widget', // Base ID
			__('UserInfo', 'text_domain'), // Name
			array( 'description' => __('User Information', 'text_domain'), ) // Args
		);
	}

    public function printUserInfo()
    {        
        $currUser = wp_get_current_user();
        //echo "<pre>";
        //print_r($currUser);
        //echo "</pre>";
        
        $userData       = $currUser->data;
        $userIsAdmin    = $currUser->caps["administrator"];
        
        echo "<p class='userInfoWidget'><span class='userInfoWidgetStaticText'>User Name:</span><span class='userInfoWidgetDynamicText'>" . $userData->user_login . "</span></p>";
        echo "<p class='userInfoWidget'><span class='userInfoWidgetStaticText'>User Email:</span><span class='userInfoWidgetDynamicText'>" . $userData->user_email . "</span></p>";
        echo "<p class='userInfoWidget'><span class='userInfoWidgetStaticText'>Register Date:</span><span class='userInfoWidgetDynamicText'>" . $userData->user_registered . "</span></p>";
        if($userIsAdmin == 1)
            echo "<p class='userInfoWidget'>" . $userData->user_login . " has admin rights!</p>";
        else
            echo "<p class='userInfoWidget'>" . $userData->user_login . " does not have admin rights!</p>";
    }

    public function widget($args, $instance) 
    {

        $title = apply_filters('widget_title', $instance['title']);

        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];
        
        $this->printUserInfo();

        echo $args['after_widget'];
    }

    public function form($instance)
    {
        if (isset($instance['title']))
        {
            $title = $instance['title'];
        }
        else
        {
            $title = __('User Info', 'text_domain');
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}

function register_UserInfo_widget() {
    register_widget('UserInfo');
}
add_action('widgets_init', 'register_UserInfo_widget');


function stylesAndScripts()
{
    wp_enqueue_style('user_info_style', plugins_url('css/user_info_style.css', __FILE__));
    //wp_enqueue_script('script', plugins_url('js/script.js', __FILE__));
}

add_action('wp_enqueue_scripts', 'stylesAndScripts');
// if there are some style and scripts that need to be included
