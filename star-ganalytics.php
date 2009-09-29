<?php
/*
Plugin Name: star-ganalytics
Plugin URI: http://liuchangjun.com/tag/star-ganalytics/
Version: 0.1
Author: Star
Author URI: http://liuchangjun.com/
Description: Simplest Google Analytics plugin. Add Google Analytics into the WordPress.
*/

/* Add Google Analytics option */
add_action('admin_menu','star_ganalytics_admin');
if(!function_exists("star_ganalytics_admin")){
	function star_ganalytics_admin(){
		if(function_exists('add_options_page')){
			$page_title='Star Google Analytics Settings';
			$menu_title='Star Google Analytics';
			$access_level=8;
			$function_name='star_ganalytics_options';
			add_options_page($page_title,$menu_title,$access_level,basename(__FILE__),$function_name);
		}
	}
}
if(!function_exists("star_ganalytics_options")){
	function star_ganalytics_options(){
		global $wpdb;
		$option_name='_star_ganalytics_key';
		if (isset($_REQUEST['star-ganalytics-key-action']) && !is_null($_REQUEST['star-ganalytics-key-action'])) {
			$g_action=$_REQUEST['star-ganalytics-key-action'];
		} else {
			$g_action='';
		}
		switch($g_action){
			case 'update':
				if (isset($_REQUEST['star-ganalytics-key']) && !is_null($_REQUEST['star-ganalytics-key'])) {
					$g_key=$_REQUEST['star-ganalytics-key'];
				} else {
					$g_key='';
				}
				$wpdb->escape($g_key);
				if(get_option($option_name)){
					update_option($option_name,$g_key);
				}else{
					add_option($option_name,$g_key);
				}
				break;
			case 'remove':
				delete_option($option_name);
				break;
			default:
		}
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	function updatekey(){
		if(confirm("Do you really want to update the key?")){
			document.getElementById('star-ganalytics-key-update').value = 'Please wait...';
			var action=document.getElementById('star-ganalytics-key-action');
			action.value="update";
			document.getElementById("star-ganalytics-form").submit();
		}
	}
	function removeall(){
		if(confirm("Do you really want to remove all Star Ganalytics configurations?")){
			document.getElementById('star-ganalytics-key-remove').value = 'Please wait...';
			var action=document.getElementById('star-ganalytics-key-action');
			action.value="remove";
			document.getElementById("star-ganalytics-form").submit();
		}
	}
	//-->
	</SCRIPT>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
<h2>Star Google Analytics Settings</h2>
<form id="star-ganalytics-form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<input type="hidden" id="star-ganalytics-key-action" name="star-ganalytics-key-action" value="">

<div id='dashboard-widgets' class='metabox-holder'>
<div class='postbox-container'  style='width:100%;'>
<div id="settings_star_ganalytics" class="postbox " style='margin:2pt 0pt'>
	<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Web Property ID</span></h3>
	<div class="inside">
	<div style='margin:10pt 2pt'>
	<label for="star-ganalytics-key">Please input Web Property ID:</label>
	<input type="text" name="star-ganalytics-key" id="star-ganalytics-key"  class="regular-text" value="<?php echo get_option('_star_ganalytics_key'); ?>">
	<input type="button" value="Update Key" id="star-ganalytics-key-update" name="star-ganalytics-key-update" onclick="updatekey()" />
	</div>
	</div>
</div>
</div>
</div>

<div id='dashboard-widgets' class='metabox-holder'>
<div class='postbox-container'  style='width:100%;'>
<div id="settings_star_ganalytics" class="postbox " style='margin:2pt 0pt'>
	<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Remove Star Ganalytics Settings</span></h3>
	<div class="inside">
	<div style='margin:10pt 2pt'>
	<label for="star-ganalytics-key-remove">Remove all Star Ganalytics Settings:</label>
	<input type="button" value="Remove all" id="star-ganalytics-key-remove" name="star-ganalytics-key-remove" onclick="return removeall(); " />
	</div>
	</div>
</div>
</div>
</div>

</form>
</div>
<?php
	}
}

/* Add Google Analytics code */
add_filter('wp_footer', 'googel_analytics');
function googel_analytics(){
	ob_start();
?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("<?php echo get_option('_star_ganalytics_key'); ?>");
pageTracker._trackPageview();
} catch(err) {}</script>
<?php
	$content = ob_get_contents().$content;
	ob_end_clean();
	echo $content;
}
?>
