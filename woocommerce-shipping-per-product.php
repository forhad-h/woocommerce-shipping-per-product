<?php
/*
Plugin Name: Woocommerce Shipping per product
Plugin URI: https://github.com/forhad-h/woocommerce-user-input-shipping
Description: Add a shipping option in Woocommerce where user can input standard shipping price.
Author: Forhad Hosain
Version: 1.0.0
Author URI: https://github.com/forhad-h/
*/

defined('ABSPATH') or die('Preventing to access file');

/*
   Check if Woocommerce is active
*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
//   add_action( 'woocommerce_product_options_shipping', 'misha_option_group' );
//
//   function misha_option_group() {
//      echo <<<FIELD
//      <p class="form-field standard_shipping_field">
//      			<label for="product_standard_shipping">Standard Shipping</label>
//      			<input type="text" name="product_standard_shipping" id="product_standard_shipping" class="select short" />
//     </p>
// FIELD;
//   }
/**
 * Display the standard shipping field text field
 */
function wspp_standard_shipping_field() {
   $args = array(
   'id' => 'wspp_standard_shipping_cost',
   'label' => __( 'Standard Shipping', 'wspp' ),
   'class' => 'wspp_standard_shipping_cost',
   'desc_tip' => true,
   'description' => __( 'Enter the standard shipping rate', 'wspp' ),
   );
   woocommerce_wp_text_input( $args );
  }
  add_action( 'woocommerce_product_options_shipping', 'wspp_standard_shipping_field' );
}

/**
 * Save the standard shipping field
 */
function wspp_save_shipping_cost( $post_id ) {
   $product = wc_get_product( $post_id );
   $cost = isset( $_POST['wspp_standard_shipping_cost'] ) ? $_POST['wspp_standard_shipping_cost'] : '';
   $product->update_meta_data( 'wspp_standard_shipping_cost', sanitize_text_field( $cost ) );
   $product->save();
}
add_action( 'woocommerce_process_product_meta', 'wspp_save_shipping_cost' );

/**
 * Display standard shipping field on the front end
 */
function wspp_display_custom_field() {
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
add_action( 'woocommerce_before_add_to_cart_button', 'wspp_display_custom_field' );
