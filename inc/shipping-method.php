<?php
/**
 * Standard Shipping Method
 * Admin can put shipping cost each producct
 * @since 1.0.0
*/


/**
 * initialize shipping method
 * @since 1.0.0
 * @return void
*/
function wspp_shipping_method_init() {
  if( !class_exists( 'WC_Standard_Shipping_Method' ) ) {

    class WC_Standard_Shipping_Method extends WC_Shipping_Method {

      /**
       * Constructor
       * @since 1.0.0
       * @access public
       * @return void
      */
      public function __construct() {
        /**
         * get the shipping value if exist otherwise make it 0
         * @since 1.0.0
         * @var number shipping cost
        */
        $shipping_cost = count(get_shipping_cost_arr()) > 0 ? max(get_shipping_cost_arr()) : 0;
        $this->id = 'wc_standard_shipping_method';
        $this->method_title = 'Standard Shipping';
        $this->method_description = 'Standard flat rate shipping per product';
        $this->title = "Standard Shipping";
        $this->enabled = $shipping_cost ? 'yes' : 'no'; // enabled if $shipping_cost exists
        $this->init();

      }

      /**
       * Initial Setting
       * @since 1.0.0
       * @access public
       * @return void
      */
      public function init() {

        // Load the settings API
        $this->init_form_fields(); // Override the method to add custom settings
        $this->init_settings(); // Loads previously initialized settings.

        // save defined setting in admin
        add_action('woocommerce_update_options_shipping_' . $this->id,
                   [$this, 'process_admin_options']);

      }

      /**
       * Calculate / Show shipping in frontend
       * @since 1.0.0
       * @param mixed $package
       * @return void
      */
      public function calculate_shipping( $package = array() ) {
        $rate = [
          'id' => $this->id,
          'label' => $this->title,
          'cost' => max(get_shipping_cost_arr()),
          'calc_tax' => 'per_order',
        ];

        // register the rate
        $this->add_rate($rate);
      }

    }

  }
}
add_action( 'woocommerce_shipping_init', 'wspp_shipping_method_init');


function add_wc_standard_shipping_method($methods) {

  $methods['wc_standard_shipping_method'] = 'WC_Standard_Shipping_Method';
  return $methods;
}
add_filter('woocommerce_shipping_methods', 'add_wc_standard_shipping_method');

function get_shipping_cost_arr() {
  global $woocommerce;

  if(!$woocommerce->cart) return [];
  $items = $woocommerce->cart->get_cart();

  $cost_arr = [];
  foreach($items as $item => $values) {
    $product = wc_get_product( $values[ 'data' ]->get_id() );
    $cost = ( float ) get_post_meta( $values['product_id'], 'wspp_standard_shipping_cost', true );
    array_push($cost_arr, $cost);
  }


  return $cost_arr;
}
