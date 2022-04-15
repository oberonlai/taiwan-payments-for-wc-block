<?php

/**
 * Taiwan Payments for WooCommerce Blocks
 *
 * @link              https://oberonlai.blog
 * @since             1.0.0
 * @package           TWPAYMENT
 *
 * @wordpress-plugin
 * Plugin Name:       Taiwan Payments for WooCommerce Blocks
 * Plugin URI:        https://oberonlai.blog
 * Description:       Add Taiwan payment methods for WooCommerce checkout blocks.
 * Version:           1.0.0
 * Author:            Oberon Lai
 * Author URI:        https://oberonlai.blog
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       twpayment
 * Domain Path:       /languages
 *
 * WC requires at least: 5.0
 * WC tested up to: 5.7.1
 */

defined( 'ABSPATH' ) || exit;

define( 'TWPAYMENT_VERSION', '1.0.0' );
define( 'TWPAYMENT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TWPAYMENT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TWPAYMENT_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Autoload
 */
require_once TWPAYMENT_PLUGIN_DIR . 'vendor/autoload.php';

add_action( 'woocommerce_blocks_loaded', 'woocommerce_ecpay_credit_woocommerce_blocks_support' );
function woocommerce_ecpay_credit_woocommerce_blocks_support() {
	if ( class_exists( 'Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType' ) ) {
		\A7\autoload( TWPAYMENT_PLUGIN_DIR . 'src' );
		add_action(
			'woocommerce_blocks_payment_method_type_registration',
			function( Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry ) {
				$payment_method_registry->register( new TWPAYMENT\Blocks\Payments\ECPayCredit() );
			}
		);
	}
}

/**
 * i18n
 */
add_action( 'plugin_loaded', 'load_twpayment_i18n' );
function load_twpayment_i18n() {
	load_plugin_textdomain( 'twpayment', false, TWPAYMENT_PLUGIN_BASENAME . '/languages' );
}
