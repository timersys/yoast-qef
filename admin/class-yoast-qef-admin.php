<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://timersys.com
 * @since      1.0.0
 *
 * @package    Yoast_Qef
 * @subpackage Yoast_Qef/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Yoast_Qef
 * @subpackage Yoast_Qef/admin
 * @author     Damian Logghe <info@timersys.com>
 */
class Yoast_Qef_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/yoast-qef-admin.js', array( 'jquery', 'inline-edit-post' ), $this->version, false );

	}

	/**
	 * We add the custom boxes to WordPress
	 * @param $column_name string
	 * @param $post_type string
	 */
	public function quick_edit_custom_box( $column_name, $post_type ) {

		if ($column_name != 'wpseo-score') return;
		static $printNonce = TRUE;
		if ( $printNonce ) {
			$printNonce = FALSE;
			wp_nonce_field( plugin_basename( __FILE__ ), 'yoast_qef_edit_nonce' );
		}
		?>
		<fieldset class="inline-edit-col-left " style="clear: both;">
			<div class="inline-edit-col column-<?php echo $column_name; ?>">
				<label class="input-text-wrap">
					<span class=""><?php _e('Yoast SEO Focus Keyword', 'yoast_qef');?></span>
					<input type="text"  name="yoast_qef[keyword]" class="ptitle" autocomplete="off"/>
				</label>
			</div>
		</fieldset>
		<fieldset class="inline-edit-col-left " style="clear: both;">
			<div class="inline-edit-col column-<?php echo $column_name; ?>">
				<label class="input-text-wrap">
					<span class=""><?php _e('Yoast SEO Title', 'yoast_qef');?></span>
					<input type="text"  name="yoast_qef[title]" class="ptitle" autocomplete="off"/>
				</label>
			</div>
		</fieldset>
		<fieldset class="inline-edit-col-left " style="clear: both;">
			<div class="inline-edit-col column-<?php echo $column_name; ?>">
				<label class="inline-edit-group">
					<span class=""><?php _e('Yoast SEO Meta Description', 'yoast_qef');?></span>
					<textarea cols="22" rows="1" name="yoast_qef[description]" class="tax_input_post_tag" autocomplete="off"></textarea>
				</label>
			</div>
		</fieldset>
		<?php
	}

	public function save_quick_edit_custom_box( $post_id, $post ) {
		// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
		// to do anything
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return $post_id;
		// dont save for revisions
		if ( isset( $post->post_type ) && $post->post_type == 'revision' )
			return $post_id;

		// Check permissions
		if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) )
				return;
		} else {
			if ( !current_user_can( 'edit_post', $post_id ) )
				return;
		}

		$_POST += array("yoast_qef_edit_nonce" => '');
		if ( !wp_verify_nonce( $_POST["yoast_qef_edit_nonce"], plugin_basename( __FILE__ ) ) ) {
			return;
		}

		update_post_meta( $post_id, '_yoast_wpseo_focuskw', $_POST['yoast_qef']['keyword']);
		update_post_meta( $post_id, '_yoast_wpseo_title', $_POST['yoast_qef']['title']);
		update_post_meta( $post_id, '_yoast_wpseo_metadesc', $_POST['yoast_qef']['description']);

		return $post_id;
	}

	/**
	 * @return bool
	 */
	public function __return_true(){
		add_filter('wpseo_always_register_metaboxes_on_admin','__return_true');
	}
}
