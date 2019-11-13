<?php
namespace WSPP;

/**
 * Class WSPP_ADMIN_NOTICES
 * @since 1.0.0
*/

class Admin_Notices {
  /**
   * show warning when woocommerce is not activated
   * @since 1.0.0
   * @access public
   * @return void
  */
  public function show_woocommerce_activation_warning() {
    var_dump($this);
    add_action('admin_notices', [ $this, 'admin_notice_missing_main_plugin']);
  }

  /**
   * show warning when the site doesn't have a minimum required PHP version.
   * @since 1.0.0
   * @access public
   * @return void
  */
  public function show_php_version_warning() {
    add_action('admin_notices', [ $this, 'admin_notice_minimum_php_version']);
  }

  /**
   * admin notice
   * woocomerce is not activated
   * @since 1.0.0
   * @access public
   * @return void
  */
  public function admin_notice_missing_main_plugin() {
    if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

    $message = sprintf(
      /* translators: 1: Plugin name 2: Elementor */
      esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'woocommerce-shipping-per-product' ),
      '<strong>' . esc_html__( 'Woocommerce Shipping Per Product', 'woocommerce-shipping-per-product' ) . '</strong>',
      '<strong>' . esc_html__( 'Woocommerce', 'woocommerce-shipping-per-product' ) . '</strong>'
    );

    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
  }

  /**
   * Admin notice
   *
   * PHP version
   *
   * @since 1.0.0
   * @access public
   * @return void
   */
  public function admin_notice_minimum_php_version($minimum_php_version) {
    if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

    $message = sprintf(
      /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
      esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'woocommerce-shipping-per-product' ),
      '<strong>' . esc_html__( 'Woocommerce Shipping Per Product', 'woocommerce-shipping-per-product' ) . '</strong>',
      '<strong>' . esc_html__( 'PHP', 'woocommerce-shipping-per-product' ) . '</strong>',
      $minimum_php_version
    );

    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
  }


}
