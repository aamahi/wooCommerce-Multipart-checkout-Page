<?php

namespace Multipart\Checkout;

/**
 * Plugin Name: WooCommerce Multipart Checkout Page
 * Plugin URI: https://woocommerce.com/
 * Description: WooCommerce Multipart Checkout page Plugin
 * Version: 1.01
 * Author: Abdullah Al Mahi
 * Author URI: https://woocommerce.com
 * Text Domain: woo-multipart-checkout
 * Requires at least: 5.5
 * Requires PHP: 7.0
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Class MultipartCheckout
 *
 * @package Multipart\Checkout
 */
final class MultipartCheckout {

    /**
     * Version of plugin
     *
     * @var String
     */
    const VERSION = 1.0;

    /**
     * Class constructor.
     */
    public function __construct() {
        $this->defined_constaned();

        register_activation_hook( __FILE__, [ $this, 'activate'] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initialize a Singleton instance.
     *
     * @return false|MultipartCheckout
     */
    public static  function init() {
        static $instance = false;

        if ( ! $instance  ) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function defined_constaned() {
        define( 'WOO_MULTIPART_CHECKOUT_VERSION', self::VERSION );
        define( 'WOO_MULTIPART_CHECKOUT_FILE', __FILE__ );
        define( 'WOO_MULTIPART_CHECKOUT_PATH', __DIR__ );
        define( 'WOO_MULTIPART_CHECKOUT_URL', plugins_url( '', WOO_MULTIPART_CHECKOUT_FILE ) );
        define( 'WOO_MULTIPART_CHECKOUT_ASSETS', WOO_MULTIPART_CHECKOUT_URL . '/assets' );
    }

    /**
     * initialize the  plugin
     *
     * @return void
     */
    public  function init_plugin() {
        /**
         * Check Current user can active plugins capability and is  WooCommerce plugin installed.
         */
        if ( current_user_can( 'activate_plugins' ) && ! class_exists( \WooCommerce::class ) ) {
            add_action( 'admin_init',  [$this, 'my_plugin_deactivate' ] );
            add_action( 'admin_notices', [ $this, 'my_plugin_admin_notice' ] );

        }
        /**
         * Initialize the plugin
         */
        new Assets();
        new CheckoutPage();
    }

    /**
     * Deactivate the Current Plugin
     */
    public function my_plugin_deactivate() {
        deactivate_plugins(plugin_basename( __FILE__ ) );
    }

    /**
     * Throw an Alert to tell the Admin why it didn't activate Current Plugin
     */
    public function my_plugin_admin_notice() {
        $dpa_child_plugin  = __( 'WooCommerce Multipart Checkout', 'woo-multipart-checkout' );
        $dpa_parent_plugin = __( 'WooCommerce', 'woo-multipart-checkout' );

        echo '<div class="notice notice-error is-dismissible"><p>'
             . sprintf( __( '%1$s requires %2$s to function correctly. Please activate %2$s before activating %1$s. For now, the plugin has been deactivated.', 'textdomain' ), '<strong>' . esc_html( $dpa_child_plugin ) . '</strong>', '<strong>' . esc_html( $dpa_parent_plugin ) . '</strong>' )
             . '</p></div>';

        if ( isset ( $_GET['activate'] ) )
            unset( $_GET['activate'] );
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installed = get_option( 'woo_multipart_checkout_installed' );

        if ( ! $installed  ) {
            update_option( 'woo_multipart_checkout_installed', time() );
        }
        update_option( 'woo_multipart_checkout_version', WOO_MULTIPART_CHECKOUT_VERSION );
    }
}

/**
 * Initializes the main plugin
 *
 * @return false|MultipartCheckout
 */
function woo_multiprt_checckout() {
    return MultipartCheckout::init();
}

/**
 * kick-off the plugin
 */
woo_multiprt_checckout();