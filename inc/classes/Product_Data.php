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

    // display data
    add_action( 'woocommerce_before_add_to_cart_button',
                [$this, 'wspp_display_custom_field'] );
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
     'label' => __( 'Standard Shipping', 'wspp' ),
     'class' => 'wspp_standard_shipping_cost',
     'desc_tip' => true,
     'description' => __( 'Enter the standard shipping rate', 'wspp' ),
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

    /**
     * Display product data in front-end
     * @since 1.0.0
     * @access public
     * @return void
    */
   public function wspp_display_custom_field() {
      global $post;
      // Check for the custom field value
      $product = wc_get_product( $post->ID );
      $cost = $product->get_meta( 'wspp_standard_shipping_cost' );
      if( $cost ) {
        // Only display our field if we've got a value for the field title
        printf(
        '<div class="wspp-custom-field-wrapper">The Value is - %s</div>',
        esc_html( $cost )
        );
      }
   }

}
