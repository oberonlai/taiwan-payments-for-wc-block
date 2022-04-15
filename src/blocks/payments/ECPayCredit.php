<?php
namespace TWPAYMENT\Blocks\Payments;

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;
use Automattic\WooCommerce\Blocks\Assets\Api;

/**
 * Bank Transfer (BACS) payment method integration
 *
 * @since 3.0.0
 */
final class ECPayCredit extends AbstractPaymentMethodType {
	/**
	 * Payment method name/id/slug (matches id in WC_Gateway_BACS in core).
	 *
	 * @var string
	 */
	protected $name = 'ry_ecpay_credit';

	/**
	 * An instance of the Asset Api
	 *
	 * @var Api
	 */
	private $asset_api;

	/**
	 * Constructor
	 *
	 * @param Api $asset_api An instance of Api.
	 */
	//public function __construct( API $asset_api ) {
	//	$this->asset_api = $asset_api;
	//}

	/**
	 * Initializes the payment method type.
	 */
	public function initialize() {
		$this->settings = get_option( 'woocommerce_ecpay_credit_settings', array() );
	}

	/**
	 * Returns if this payment method should be active. If false, the scripts will not be enqueued.
	 *
	 * @return boolean
	 */
	public function is_active() {
		$payment_gateways_class = WC()->payment_gateways();
		$payment_gateways       = $payment_gateways_class->payment_gateways();

		return $payment_gateways['ry_ecpay_credit']->is_available();
	}

	/**
	 * Returns an array of scripts/handles to be registered for this payment method.
	 *
	 * @return array
	 */
	public function get_payment_method_script_handles() {
		$asset_path   = TWPAYMENT_PLUGIN_URL . '/build/wc-payment-method-ecpay-credit.asset.php';
		$dependencies = array();
		if ( file_exists( $asset_path ) ) {
			$asset        = require $asset_path;
			$version      = is_array( $asset ) && isset( $asset['version'] )
				? $asset['version']
				: $version;
			$dependencies = is_array( $asset ) && isset( $asset['dependencies'] )
				? $asset['dependencies']
				: $dependencies;
		}
		wp_register_script(
			'wc-ecpay-credit-blocks-integration',
			TWPAYMENT_PLUGIN_URL . 'dist/wc-payment-method-ecpay-credit.js',
			$dependencies,
			'1.0.0',
			true
		);
		return array( 'wc-ecpay-credit-blocks-integration' );
	}

	/**
	 * Returns an array of key=>value pairs of data made available to the payment methods script.
	 *
	 * @return array
	 */
	public function get_payment_method_data() {
		return array(
			'title'       => $this->get_setting( 'title' ),
			'description' => $this->get_setting( 'description' ),
			'supports'    => $this->get_supported_features(),
		);
	}
}
