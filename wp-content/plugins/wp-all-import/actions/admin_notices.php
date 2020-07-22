<?php 

function pmxi_admin_notices() {
	// notify user if history folder is not writable
	$uploads = wp_upload_dir();		

	// compare woocommerce add-on version	
	if ( class_exists( 'PMWI_Plugin' ) and ( defined('PMWI_VERSION') and version_compare(PMWI_VERSION, '2.1.4') < 0 and PMWI_EDITION == 'paid' or defined('PMWI_FREE_VERSION') and version_compare(PMWI_FREE_VERSION, '1.2.2') < 0 and PMWI_EDITION == 'free') ) {
		?>
		<div class="error"><p>
			<?php printf(
					__('<b>%s Plugin</b>: Please update your WP All Import WooCommerce add-on to the latest version', 'pmwi_plugin'),
					PMWI_Plugin::getInstance()->getName()
			) ?>
		</p></div>
		<?php
			
		if (defined('PMWI_EDITION') and PMWI_EDITION == 'paid')
		{
			deactivate_plugins( PMWI_ROOT_DIR . '/wpai-woocommerce-add-on.php');
		}
		else
		{	
			if (defined('PMWI_FREE_ROOT_DIR')){ 
				deactivate_plugins( PMWI_FREE_ROOT_DIR . '/plugin.php');		
			}
			else{
				deactivate_plugins( PMWI_ROOT_DIR . '/plugin.php');		
			}
		}
		
	}

	// compare ACF add-on
	if ( class_exists( 'PMAI_Plugin' ) and defined('PMAI_VERSION') and version_compare(PMAI_VERSION, '3.0.0-beta1') < 0 and PMAI_EDITION == 'paid' ) {
		?>
		<div class="error"><p>
			<?php printf(
					__('<b>%s Plugin</b>: Please update your WP All Import ACF add-on to the latest version', 'pmwi_plugin'),
					PMAI_Plugin::getInstance()->getName()
			) ?>
		</p></div>
		<?php
			
		if (defined('PMAI_EDITION') and PMAI_EDITION == 'paid')
		{
			deactivate_plugins( PMAI_ROOT_DIR . '/wpai-acf-add-on.php');
		}				
	}

	// compare Linkcloak add-on
	if ( class_exists( 'PMLCA_Plugin' ) and defined('PMLCA_VERSION') and version_compare(PMLCA_VERSION, '1.0.0-beta1') < 0 and PMLCA_EDITION == 'paid' ) {
		?>
		<div class="error"><p>
			<?php printf(
					__('<b>%s Plugin</b>: Please update your WP All Import Linkcloak add-on to the latest version', 'pmwi_plugin'),
					PMLCA_Plugin::getInstance()->getName()
			) ?>
		</p></div>
		<?php
			
		if (defined('PMLCA_EDITION') and PMLCA_EDITION == 'paid')
		{
			deactivate_plugins( PMLCA_ROOT_DIR . '/wpai-linkcloak-add-on.php');
		}				
	}

	// compare User add-on
	if ( class_exists( 'PMUI_Plugin' ) and defined('PMUI_VERSION') and version_compare(PMUI_VERSION, '1.0.0-beta1') < 0 and PMUI_EDITION == 'paid' ) {
		?>
		<div class="error"><p>
			<?php printf(
					__('<b>%s Plugin</b>: Please update your WP All Import User add-on to the latest version', 'pmwi_plugin'),
					PMUI_Plugin::getInstance()->getName()
			) ?>
		</p></div>
		<?php
			
		if (defined('PMUI_EDITION') and PMUI_EDITION == 'paid')
		{
			deactivate_plugins( PMUI_ROOT_DIR . '/wpai-user-add-on.php');
		}				
	}

	// compare WPML add-on
	if ( class_exists( 'PMLI_Plugin' ) and defined('PMLI_VERSION') and version_compare(PMLI_VERSION, '1.0.0-beta1') < 0 and PMLI_EDITION == 'paid' ) {
		?>
		<div class="error"><p>
			<?php printf(
					__('<b>%s Plugin</b>: Please update your WP All Import WPML add-on to the latest version', 'pmwi_plugin'),
					PMLI_Plugin::getInstance()->getName()
			) ?>
		</p></div>
		<?php
			
		if (defined('PMLI_EDITION') and PMLI_EDITION == 'paid')
		{
			deactivate_plugins( PMLI_ROOT_DIR . '/plugin.php');
		}				
	}

	$input = new PMXI_Input();
	$messages = $input->get('pmxi_nt', array());
	if ($messages) {
		is_array($messages) or $messages = array($messages);
		foreach ($messages as $type => $m) {
			in_array((string)$type, array('updated', 'error')) or $type = 'updated';
			?>
			<div class="<?php echo $type ?>"><p><?php echo $m ?></p></div>
			<?php 
		}
	}	
	$warnings = $input->get('warnings', array());
	if ($warnings) {
		is_array($warnings) or $warnings = explode(',', $warnings);
		foreach ($warnings as $code) {			
			switch ($code) {
				case 1:
					$m = __('<strong>Warning:</strong> your title is blank.', 'pmxi_plugin');
					break;
				case 2:
					$m = __('<strong>Warning:</strong> your content is blank.', 'pmxi_plugin');
					break;
				case 3:
					$m = __('<strong>Warning:</strong> You must <a href="http://www.wpallimport.com/upgrade-to-pro/?utm_source=free-plugin&utm_medium=in-plugin&utm_campaign=images" target="_blank">upgrade to the Pro edition of WP All Import</a> to import images. The settings you configured in the images section will be ignored.', 'pmxi_plugin');
					break;
				case 4:
					$m = __('<strong>Warning:</strong> You must <a href="https://www.wpallimport.com/checkout/?edd_action=add_to_cart&download_id=1748&edd_options%5Bprice_id%5D=0&utm_source=free-plugin&utm_medium=in-plugin&utm_campaign=custom-fields" target="_blank">upgrade to the Pro edition of WP All Import</a> to import data to Custom Fields. The settings you configured in the Custom Fields section will be ignored.', 'pmxi_plugin');
					break;					
				default:
					$m = false;
					break;
			}
			if ($m):
			?>
			<div class="error"><p><?php echo $m ?></p></div>
			<?php 
			endif;
		}
	}	
	wp_all_import_addon_notifications();	
}
