<?php 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// init process for registering our button
 add_action('init', 'wpse72394_shortcode_button_init');
 function wpse72394_shortcode_button_init() {

      //Abort early if the user will never see TinyMCE
      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
           return;

      //Add a callback to regiser our tinymce plugin   
      add_filter("mce_external_plugins", "wpse72394_register_tinymce_plugin"); 

      // Add a callback to add our button to the TinyMCE toolbar
      add_filter('mce_buttons', 'wpse72394_add_tinymce_button');
}


//This callback registers our plug-in
function wpse72394_register_tinymce_plugin($plugin_array) {
    $plugin_array['wpse72394_button'] = get_bloginfo('template_url') .'/inc/admin/tinyMCE/js/eminds-tinymce.js';
    $plugin_array['wpse72394_button2'] = get_bloginfo('template_url') .'/inc/admin/tinyMCE/js/eminds-tinymce.js';
//	$plugin_array['wpse72394_button3'] = get_bloginfo('template_url') .'/inc/admin/tinyMCE/js/eminds-tinymce.js'; 
    return $plugin_array;
}

//This callback adds our button to the toolbar
function wpse72394_add_tinymce_button($buttons) {
            //Add the button ID to the $button array
    $buttons[] = "wpse72394_button";
    $buttons[] = "wpse72394_button2";
	//$buttons[] = "wpse72394_button3";
    return $buttons;
}

//********************************************** Testing ************************
/*
Plugin Name: Shortcode TinyMCE Plugin
Description: A WordPress plugin that will add a button to the tinyMCE editor to add shortcodes
Plugin URI: http://www.paulund.co.uk
Author: Paulund
Author URI: http://www.paulund.co.uk
Version: 1.0
License: GPL2
*/

/*
Ref : http://www.paulund.co.uk/add-button-tinymce-shortcodes
    Copyright (C) Year  Author  Email

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
new Shortcode_Tinymce();
class Shortcode_Tinymce
{
    public function __construct()
    {
        add_action('admin_init', array($this, 'pu_shortcode_button'));
        add_action('admin_footer', array($this, 'pu_get_shortcodes'));
    }

    /**
     * Create a shortcode button for tinymce
     *
     * @return [type] [description]
     */
    public function pu_shortcode_button()
    {
        if( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
        {
            add_filter( 'mce_external_plugins', array($this, 'pu_add_buttons' ));
            add_filter( 'mce_buttons', array($this, 'pu_register_buttons' ));
        }
    }

    /**
     * Add new Javascript to the plugin scrippt array
     *
     * @param  Array $plugin_array - Array of scripts
     *
     * @return Array
     */
    public function pu_add_buttons( $plugin_array )
    {
        $plugin_array['pushortcodes'] = get_bloginfo('template_url') .'/inc/admin/tinyMCE/js/eminds-tinymce.js';

        return $plugin_array;
    }

    /**
     * Add new button to tinymce
     *
     * @param  Array $buttons - Array of buttons
     *
     * @return Array
     */
    public function pu_register_buttons( $buttons )
    {
        array_push( $buttons, 'separator', 'pushortcodes' );
        return $buttons;
    }

    /**
     * Add shortcode JS to the page
     *
     * @return HTML
     */
    public function pu_get_shortcodes()
    {
        global $shortcode_tags;
		
	//output array
	$output = array();	
		
		$argssectionNo = array(
					'post_type' => 'companies_act',
					'posts_per_page' => -1,
				);
				$query = new WP_Query( $argssectionNo );
		if($query->have_posts()) :
			while($query->have_posts()): $query->the_post();
			 $output[] = get_post_meta(get_the_ID(),'enter_the_section_no_ca_post',TRUE);
			endwhile;
		endif;
		wp_reset_query();
		
		//sort the array
		if(count($output)>1)
		sort($output);
		
       $i=1;
        echo '<script type="text/javascript">
        var shortcodes_button = new Array();';

        $count = 0;

        for($i=0;$i<=470;$i++)
        {
        	/*
			 *specially for the oth position 
			 */
			 if($i == 0){
			 echo "shortcodes_button[{$i}] = '';";	
			 }else{
			 $url ="#";	
			global $wpdb;
			$sql_section_pid = "SELECT post_id FROM `".$wpdb->prefix."postmeta` WHERE meta_key='enter_the_section_no_ca_post' AND meta_value='".$i."'";
			$arr_section_pid = $wpdb->get_row($sql_section_pid); 
            //print_r($arr_section_pid);
			//condition to check the content.
			if(count($arr_section_pid)>0){
			$id_section_pid  = $arr_section_pid->post_id;
			$url             = get_permalink($id_section_pid);
			}			
			 	echo "shortcodes_button[{$i}] = '{$url}';";
			 }
			
            //echo "shortcodes_button[{$i}] = '{$i}';";
            //$count++;
        }

        echo '</script>';
    }
}
?>
