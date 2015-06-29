<?php
/**
 * Make a dismissible notice.
 *
 * @package   Caldera_Warnings_Dismissible_Notice
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 Josh Pollock
 */
if ( ! function_exists( 'caldera_warnings_dismissible_notice_cb' ) ) {
	/**
	 * Hook to AJAX
	 *
	 * @since 0.2.0
	 */
	add_action( 'wp_ajax_caldera_warnings_dismissible_notice', 'caldera_warnings_dismissible_notice_cb' );
	function caldera_warnings_dismissible_notice_cb() {
		return Caldera_Warnings_Dismissible_Notice::ajax_cb();
	}
}

if ( ! function_exists( 'caldera_warnings_dismissible_notice' ) ) {
	/**
	 * Create a dismissible notice.
	 *
	 * @since 0.2.0
	 *
	 * @param string $message The text of the message.
	 * @param bool $error Optional. Whether to show as error or update. Default is error.
	 * @param string $cap_check Optional. Minimum user capability to show nag to. Default is "activate_plugins"
	 * @param string|bool $ignore_key Optional. The user meta key to use for storing if this message has been dismissed by current user or not. If false, it will be generated.
	 *
	 * @return string|void Admin notice if is_admin() and not dismissed.
	 */
	function caldera_warnings_dismissible_notice( $message,  $error = true, $cap_check = 'activate_plugins', $ignore_key = false ) {
		include_once dirname( __FILE__ ) . '/Caldera_Warnings_Dismissible_Notice.php';

		return Caldera_Warnings_Dismissible_Notice::notice( $message, $error, $cap_check, $ignore_key );
	}

}
