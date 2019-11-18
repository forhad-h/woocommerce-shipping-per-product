<?php
/*
Plugin Name: Woocommerce Shipping Per Product
Plugin URI: https://github.com/forhad-h/woocommerce-shipping-per-product
Description: Woocommerce Standard flat rate Shipping method Per Product
Author: Forhad Hosain
Version: 1.1.1
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


const VERSION = '1.1.1';

/**
 * PHP version
 * @since 1.0.0
 * @var string php version
*/
const MINIMUM_PHP_VERSION = '5.6';

// Initialization
add_action('init', 'wspp_init');

/**
 * Initialization
 * @since 1.0.0
 * @access public
 * @return void
*/
function wspp_init() {

  // load translator
  load_plugin_textdomain('woocommerce-shipping-per-product');

  // admin notices instance
  $admin_notices = new \WSPP\Admin_Notices();

  // Check if woocommerce is active
  if(
    !in_array( 'woocommerce/woocommerce.php',
        apply_filters('active_plugins', get_option( 'active_plugins' ) ) )
  ) $admin_notices->show_woocommerce_activation_warning();


  // Check PHP version
  if(
    version_compare(PHP_VERSION, MINIMUM_PHP_VERSION, '<')
  ) $admin_notices->show_php_version_warning(MINIMUM_PHP_VERSION);

  // Product data options
  new \WSPP\Product_Data();

  // shiping method
  include_once WSPP_BASE_PATH . 'inc/shipping-method.php';

}
