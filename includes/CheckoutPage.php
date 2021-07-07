<?php


namespace Multipart\Checkout;

/**
 * Class CheckoutPage
 *
 * @package Multipart\Checkout
 */
class CheckoutPage {
    /**
     * CheckoutPage constructor.
     */
    public function __construct() {
        add_action( 'wp_head', [ $this, 'woo_font_load' ] );
        add_filter( 'gettext', [ $this, 'your_order_text_remove' ], 20, 3 );

        $this->remove_checkout_hook();
        $this->add_multipart_checkout_action();

        add_action( 'woocommerce_checkout_before_customer_details', [ $this, 'woo_multipart_checkout_template_render' ] );
    }

    /**
     * multipart form font-family file loaded
     */
    public function woo_font_load() {
        echo '<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">';
    }

    /**
     *  WooCommerce Multipart Checkout template file render
     *
     * @return void
     */
    public function woo_multipart_checkout_template_render() {
        // load necessary style and script file
        wp_enqueue_style('woo_multipart_checkout_style');
        wp_enqueue_script('woo_multipart_checkout_script');

        // load multipart checkout form
        include "template/multipart-checkout.php";
    }

    /**
     * Remove WooCommerce Checkout Hook
     *
     * @return void
     */
    public function remove_checkout_hook() {

        $instance = new \WC_Checkout();

        remove_action( 'woocommerce_checkout_billing', [ $instance::instance(), 'checkout_form_billing', 10 ] );
        remove_action( 'woocommerce_checkout_shipping', [ $instance::instance(), 'checkout_form_shipping', 10 ] );
        remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review');
        remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
    }

    /**
     * Add Custom WooCommerce Checkout page Hook
     *
     * @return void
     */
    public function add_multipart_checkout_action() {
        $instance = new \WC_Checkout();

        add_action( 'woocommerce_multipart_checkout_billing', [ $instance::instance(), 'checkout_form_billing' ] );
        add_action( 'woocommerce_multipart_checkout_shipping', [ $instance::instance(), 'checkout_form_shipping' ] );
        add_action( 'woocommerce_multipart_checkout_order_review', 'woocommerce_order_review' );
        add_action( 'woocommerce_multipart_checkout_order_review', 'woocommerce_checkout_payment', 20 );
    }

    /**
     * Your Order Text Remove From Checkout Page
     *
     * @param $translated_text
     * @param $text
     * @param $domain
     *
     * @return mixed|string
     */
    public function your_order_text_remove( $translated_text, $text, $domain ) {
        if ( $translated_text == 'Your order' ) {
            $translated_text = '';
        }

        return $translated_text;
    }
}