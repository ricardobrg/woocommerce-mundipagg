<?php
/**
 * Plugin Name: Claudio Sanches - MundiPagg for WooCommerce
 * Plugin URI: https://github.com/claudiosanches/woocommerce-mundipagg
 * Description: MundiPagg gateway for WooCommerce
 * Author: Claudio Sanches
 * Author URI: https://claudiosanches.com/
 * Version: 3.0.0
 * License: GPLv2 or later
 * Text Domain: woocommerce-mundipagg
 * Domain Path: /languages/
 *
 * @package WooCommerce_MundiPagg
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_Mundipagg' ) ) :

/**
 * Plugin's main class.
 */
class WC_Mundipagg {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '3.0.0';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin actions.
	 *
	 *
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		if (class_exists( 'WC_Payment_Gateway' ) && class_exists( 'Extra_Checkout_Fields_For_Brazil' ) ) {
			$this->includes();
			add_filter( 'woocommerce_payment_gateways', array( $this, 'add_gateway' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
		} else {
			add_action( 'admin_notices', array( $this, 'missing_dependencies_notice' ) );
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Get templates path.
	 *
	 * @return string
	 */
	public static function get_templates_path() {
		return plugin_dir_path( __FILE__ ) . 'templates/';
	}

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-mundipagg' );

		load_textdomain( 'woocommerce-mundipagg', trailingslashit( WP_LANG_DIR ) . 'woocommerce-mundipagg/woocommerce-mundipagg-' . $locale . '.mo' );
		load_plugin_textdomain( 'woocommerce-mundipagg', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Add the gateway to WooCommerce.
	 *
	 * @param  array $methods WooCommerce payment methods.
	 *
	 * @return array          Payment methods with MundiPagg.
	 */
	public function add_gateway( $methods ) {
		$methods[] = 'WC_Mundipagg_Banking_Ticket_Gateway';
		$methods[] = 'WC_Mundipagg_Credit_Card_Gateway';
		$methods[] = 'WC_Mundipagg_Debit_Card_Gateway';
		$methods[] = 'WC_Mundipagg_Voucher_Gateway';
		return $methods;
	}

	/**
	 * Includes.
	 */
	private function includes() {
		include_once 'includes/class-wc-mundipagg-api.php';
		include_once 'includes/class-wc-mundipagg-banking-ticket-gateway.php';
		include_once 'includes/class-wc-mundipagg-credit-card-gateway.php';
		include_once 'includes/class-wc-mundipagg-debit-gateway.php';
		include_once 'includes/class-wc-mundipagg-voucher-gateway.php';
	}

	/**
	 * Missing dependencies notice.
	 *
	 * @return string
	 */
	public function missing_dependencies_notice() {
		if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
			include_once 'includes/admin/views/html-notice-missing-woocommerce.php';
		}

		if ( ! class_exists( 'Extra_Checkout_Fields_For_Brazil' ) ) {
			include_once 'includes/admin/views/html-notice-missing-ecfb.php';
		}
	}

	/**
	 * Plugin activate method.
	 */
	public static function activate() {

		add_option( 'wc_mundipagg_version_on_install', WC_Mundipagg::VERSION );

		flush_rewrite_rules();
	}

	/**
	 * Plugin deactivate method.
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

	/**
	 * Action links.
	 *
	 * @param  array $links
	 *
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$plugin_links = array();
		$plugin_links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=checkout&section=wc_mundipagg_banking_ticket_gateway' ) ) . '">' . __( 'Banking Ticket Settings', 'woocommerce-mundipagg' ) . '</a>';
		$plugin_links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=checkout&section=wc_mundipagg_credit_card_gateway' ) ) . '">' . __( 'Credit Card Settings', 'woocommerce-mundipagg' ) . '</a>';
		$plugin_links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=checkout&section=wc_mundipagg_debit_card_gateway' ) ) . '">' . __( 'Debit Card Settings', 'woocommerce-mundipagg' ) . '</a>';
		$plugin_links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=checkout&section=wc_mundipagg_voucher_gateway' ) ) . '">' . __( 'Voucher Settings', 'woocommerce-mundipagg' ) . '</a>';

		return array_merge( $plugin_links, $links );
	}
}

/**
 * Plugin activation and deactivation methods.
 */
register_activation_hook( __FILE__, array( 'WC_Mundipagg', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WC_Mundipagg', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'WC_Mundipagg', 'get_instance' ) );

endif;
