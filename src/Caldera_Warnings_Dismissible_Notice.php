<?php
/**
 * Creates a dismissible--via AJAX--admin nag
 *
 * @package   @Caldera_Warnings_Dismissible_Notice
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 Josh Pollock
 */
/**
 * Version 0.1.0
 */

if ( class_exists( 'Caldera_Warnings_Dismissible_Notice' ) ) {
	return;

}

/**
 * Class Caldera_Warnings_Dismissible_Notice
 *
 * @package   @Caldera_Warnings_Dismissible_Notice
 */
class Caldera_Warnings_Dismissible_Notice {

	/**
	 * The class attribute for notice toggles.
	 *
	 * @since 0.1.0
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected static $notice_class = "caldera_admin_nag";

	/**
	 * The action for the nonce
	 *
	 * @since 0.1.0
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected static $nonce_action = 'cal_war_dis';

	/**
	 * Output the message
	 *
	 * @since 0.1.0
	 *
	 * @param string $message The text of the message.
	 * @param bool $error Optional. Whether to show as error or update. Default is error.
	 * @param string $cap_check Optional. Minimum user capability to show nag to. Default is "update_options"
	 * @param string|bool $ignore_key Optional. The user meta key to use for storing if this message has been dismissed by current user or not. If false, it will be generated.
	 *
	 * @return string|void Admin notice if is_admin() and not dismissed.
	 */
	public static function notice( $message,  $error = true, $cap_check = 'update_options', $ignore_key = false ) {
		if ( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
			if ( current_user_can( $cap_check ) ) {
				$user_id = get_current_user_id();
				if ( ! is_string( $ignore_key ) ) {
					$ignore_key = substr( $message, 0, 5 );
					$ignore_key = 'cal_wd_ig_' . $ignore_key;
				}

				$ignore_key = 'cal_wd_ig_' . substr( $ignore_key, 0, 53 );

				$ignore_key = sanitize_key( $ignore_key );

				if ( ! get_user_meta( $user_id, $ignore_key, true ) ) {
					if ( $error ) {
						$class = 'error';
					} else {
						$class = 'updated';
					}

					$hide_attr = $ignore_key . '_id';

					$nonce = wp_create_nonce( self::$nonce_action );

					$dismiss = sprintf(
						'<a style="float:right;"  href="#" title="Hide This Warning" data-nag="%1s" class="%2s" data-nonce="3%s" id="%4s" data-hide="%5s"><span style="text-decoration: none;color: #000;" class="dashicons dashicons-no-alt" ></span></a>',
						$ignore_key, self::$notice_class, $nonce, $ignore_key, $hide_attr
					);

					$out[] = sprintf( '<div class="%1s" id="%2s"><p>', $class, $hide_attr );
					$out[] = $message . $dismiss;
					$out[] = "</p></div>";

					add_action( 'admin_footer', array( __CLASS__, 'js' ) );
					add_action( 'wp_ajax_caldera_warnings_dismissible_notice', array( __CLASS__, 'ajax_cb' ) );

					return implode( '', $out );

				}

			}

		}

	}

	/**
	 * JavaScript for click event.
	 *
	 * @since 0.1.0
	 *
	 * @uses "admin_footer"
	 */
	public static function js() {
		?>
		<script>
			jQuery(document).ready(function($) {
				var the_class = ".<?php echo self::$notice_class; ?>";

				$( the_class ).click( function ( event ) {
					var url = ajaxurl;
					event.preventDefault();
					var nag = $( this ).data( 'nag' );
					var nonce = $( this ).data( 'nonce' );
					var hide = $( this ).data( 'hide' );

					$.post( ajaxurl, {
						action: "caldera_warnings_dismissible_notice",
						url: url,
						nag: nag,
						nonce: nonce
					}).done( function( data ) {
						$( document.getElementById( hide ) ).slideUp();

					});

				} );
			});

		</script>

	<?php
	}

	/**
	 * AJAX callback to mark the message dismissed.
	 *
	 * @since 0.1.0
	 *
	 * @uses "wp_ajax_caldera_warnings_dismissible_notice"
	 *
	 * @return bool
	 */
	public static function ajax_cb() {
		if ( ! isset( $_POST[ 'nonce' ] ) || ! wp_verify_nonce( $_POST[ 'nonce' ], self::$nonce_action ) ) {
			return false;
		}

		$nag = sanitize_key( $_POST[ 'nag' ] );
		if ( $nag === $_POST[ 'nag' ] ) {
			update_post_meta( get_current_user_id(), $nag, true );
		}

	}

}



