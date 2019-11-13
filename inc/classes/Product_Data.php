<?php
namespace WSPP;

/**
 * Class Plugin
 * All functionality of this plugin goes here
 * @since 1.0.0
*/
class Product_Data {
  /**
   * Constructor
   * @since 1.0.0
   * @access public
   * @return void
  */
  public function __construct() {

    // text field to get input
    add_action( 'woocommerce_product_options_shipping',
                [$this, 'wspp_standard_shipping_field'] );

    // save input filed value
    add_action( 'woocommerce_process_product_meta',
                [$this, 'wspp_save_shipping_cost'] );

  }

  /**
   * Add text field option in Product data panel
   * @since 1.0.0
   * @access public
   * @return void
  */
  public function wspp_standard_shipping_field() {
     $args = array(
     'id' => 'wspp_standard_shipping_cost',
     'type' => 'number',
     'label' => __( 'Standard Shipping Rate', 'wspp' ),
     'class' => 'wspp_standard_shipping_cost',
     'desc_tip' => true,
     'description' => __( 'Enter the standard shipping rate', 'wspp' ),
     'custom_attributes' => [
           'step' => 'any',
           'min' => 0,
       ],
     );
     woocommerce_wp_text_input( $args );
   }

   /**
    * Save product data
    * @since 1.0.0
    * @access public
    * @return void
   */
   public function wspp_save_shipping_cost( $post_id ) {
      $product = wc_get_product( $post_id );
      $cost = isset( $_POST['wspp_standard_shipping_cost'] ) ? $_POST['wspp_standard_shipping_cost'] : '';
      $product->update_meta_data( 'wspp_standard_shipping_cost', sanitize_text_field( $cost ) );
      $product->save();
   }


}
