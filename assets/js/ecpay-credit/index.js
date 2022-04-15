/**
 * External dependencies
 */
import { registerPaymentMethod } from '@woocommerce/blocks-registry';
import { __ } from '@wordpress/i18n';
import { getSetting } from '@woocommerce/settings';
import { decodeEntities } from '@wordpress/html-entities';


const settings = getSetting('ecpay_credit_data', {});
const defaultLabel = __(
	'ECPay Credit Card Payment',
	'TWPAYMENT'
);
const label = decodeEntities(settings.title) || defaultLabel;

/**
 * Content component
 */
const Content = () => {
	return decodeEntities(settings.description || '');
};

/**
 * Label component
 *
 * @param {*} props Props from payment API.
 */
const Label = (props) => {
	const { PaymentMethodLabel } = props.components;
	return <PaymentMethodLabel text={label} />;
};

/**
 * Bank transfer (BACS) payment method config object.
 */
const ecpayCreditPaymentMethod = {
	name: 'ry_ecpay_credit',
	label: <Label />,
	content: <Content />,
	edit: <Content />,
	canMakePayment: () => true,
	ariaLabel: label,
	supports: {
		features: settings?.supports ?? [],
	},
};

registerPaymentMethod(ecpayCreditPaymentMethod);