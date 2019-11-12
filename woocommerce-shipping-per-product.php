<?php
/*
Plugin Name: Woocommerce Shipping Per Product
Plugin URI: https://github.com/forhad-h/woocommerce-shipping-per-product
Description: Add a shipping option in Woocommerce where user can input standard shipping price.
Author: Forhad Hosain
Version: 1.0.0
Author URI: https://github.com/forhad-h/
Text Domain: woocommerce-shipping-per-product
*/

defined('ABSPATH') or die('Preventing direct access');

// define base url of this plugin
if(!defined('WSPP_BASE_PATH')) {
   define('WSPP_BASE_PATH', plugin_dir_path(__FILE__));
}

// autoloader
require_once WSPP_BASE_PATH . 'inc/autoloader.php';

/**
 * check if Class - Woocommerce_Shipping_Per_Product exists
 * @since 1.0.0
*/


  const VERSION = '1.0.0';

  /**
   * PHP version
   * @since 1.0.0
   * @var string php version
  */
  const MINIMUM_PHP_VERSION = '5.6';

  /**
   * Constructor
   * @since 1.0.0
   * @access public
  */

  // Initialization
  add_action('init', 'init');

  /**
   * Load text domain
   * @since 1.0.0
   * @access public
  */
  function i18n() {
  }

  /**
   * Initialization
   * @since 1.0.0
   * @access public
  */
  function init() {

    // load translator
    load_plugin_textdomain('woocommerce-shipping-per-product');

    // Check if woocommerce is active
    if(
      !in_array( 'woocommerce/woocommerce.php',
          apply_filters('active_plugins', get_option( 'active_plugins' ) ) )
    ) \WSPP\Admin_Notices::show_woocommerce_activation_warning();


    // Check PHP version
    if(
      version_compare(PHP_VERSION, MINIMUM_PHP_VERSION, '<')
    ) \WSPP\Admin_Notices::show_php_version_warning(MINIMUM_PHP_VERSION);

    // Product data options
    new \WSPP\Product_Data();
  }
