<?php

namespace Multipart\Checkout;

/**
 * Class Assets
 *
 * @package Multipart\Checkout
 */
class Assets {

    /**
     * Assets constructor.
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }

    /**
     * Get Scripts
     *
     * @return array[]
     */
    public function get_scripts() {
        return [
            'woo_multipart_checkout_script' => [
                'src'     => WOO_MULTIPART_CHECKOUT_ASSETS . '/js/woo_checkout.js',
                'version' => filemtime( WOO_MULTIPART_CHECKOUT_PATH . '/assets/js/woo_checkout.js' ),
                'deps'    => [  ],
            ]
        ];
    }

    /**
     * Get all Style file
     *
     * @return array[]
     */
    public function get_styles() {
        return [
            'woo_multipart_checkout_style' => [
                'src'     => WOO_MULTIPART_CHECKOUT_ASSETS . '/css/woo_checkout.css',
                'version' => filemtime( WOO_MULTIPART_CHECKOUT_PATH . '/assets/css/woo_checkout.css' ),
                'deps'    => [],
            ]
        ];
    }

    /**
     * Register Enqueue Assets
     *
     * @return void
     */
    public function enqueue_assets() {
        $scripts    = $this->get_scripts();

        foreach ($scripts as $handle => $script) {

            $deps = isset( $script[ 'deps' ] ) ? isset( $script[ 'deps' ] ) : false;

            wp_register_script( $handle, $script[ 'src' ], $deps, $script[ 'version' ], true );
        }

        $styles    = $this->get_styles();

        foreach ($styles as $handle => $style) {

            $deps = isset( $style[ 'deps' ] ) ? isset( $style[ 'deps' ] ) : false;

            wp_register_style( $handle, $style[ 'src' ], $deps, $style[ 'version' ] );
        }
    }
}