<?php
/*
Plugin Name: BP Profile Completion Status
Plugin URI: http://www.vibethemes.com/
Description: Profile Completion status for BuddyPress
Version: 1.0
Author: vibethemes
License: GPLv2
Author URI: http://www.vibethemes.com/
Text Domain: bppcs
Domain Path: /languages/
*/
if ( !defined( 'ABSPATH' ) ) exit;

class bppcs{

	var $settings;
	var $temp;

	public static $instance;
	public static function init(){

        if ( is_null( self::$instance ) )
            self::$instance = new bppcs();
        return self::$instance;
    }

	private function __construct(){
		add_action('bp_before_member_header',array($this,'profile_completion_status'));
	}

	function profile_completion_status(){
		$total = 0;
		$filled = 0;
		$user_id = bp_displayed_user_id();
		if(bp_loggedin_user_id() !== $user_id || !current_user_can('edit_posts')){
			return;
		}
		global $wpdb,$bp;

		$where =  apply_filters('bppcs_field_query','');
		$field_ids_obj = $wpdb->get_results("SELECT id FROM {$bp->profile->table_name_fields} $where");
		$field_ids = array();
		if(!empty($field_ids_obj)){
			foreach($field_ids_obj as $field_id){
				$field_ids[]=$field_id->id;
			}
		}
		
		$filled = $wpdb->get_var("SELECT count(*) FROM {$bp->profile->table_name_data} WHERE field_id IN (".implode(',', $field_ids).") AND user_id = $user_id");
		?>
		<div class="width:100%;text-align:center;">
			<div class="bppcs_progressbar_wrapper" style="max-width:120px;display:inline-block;background:rgba(0,0,0,0.2);width: 100%; border-radius: 5px; overflow-x: hidden;">
				<div class="bppcs_progressbar" style="width:<?php echo round(100*$filled/count($field_ids)); ?>%;background:#52c9a5;height:5px;"><span style="position: absolute; margin-top: -25px; background: #222; padding: 2px 5px; border-radius: 5px;"><?php echo round(100*$filled/count($field_ids)); ?>%</span></div>
			</div>
			
		</div>
		<?php
	}
}

bppcs::init();