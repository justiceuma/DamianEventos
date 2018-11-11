<?php
/**
 * The Template for displaying product multivenor more offer single.
 *
 * @package WCfM Markeplace Views More Offer Single
 *
 * For edit coping this to yourtheme/wcfm/product_multivendor 
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $WCFM, $WCFMmp, $wpdb;

$_product_post = get_post($offer_product_id);
if( $_product_post->post_status != 'publish' ) return;

$_product         = wc_get_product( $offer_product_id );

if( $store_id ) {
	$store_user       = wcfmmp_get_store( $store_id );
	$store_info       = $store_user->get_shop_info();
}
?>

<div class="wcfmmp_product_mulvendor_row wcfmmp_product_mulvendor_rowbody">						
	<div class="wcfmmp_product_mulvendor_rowsub ">
		<div class="vendor_name">
			<?php 
			if( $store_id ) {
				echo $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_by_vendor( $store_id ); 
			} else {
				_e( 'Admin Product', 'wc-multivendor-marketplace' );
			}
			?>
		</div>
		<?php
		if( $store_id ) {
			$WCFMmp->wcfmmp_reviews->show_star_rating( 0, $store_id );
			do_action('after_wcfmmp_sold_by_label_product_page', $store_id );
		}
		?>
	</div>
	<div class="wcfmmp_product_mulvendor_rowsub">
		<?php echo $_product->get_price_html(); ?>
	</div>
	<div class="wcfmmp_product_mulvendor_rowsub">
		<?php if( $_product->get_type() == 'simple' ) { ?>
			<a href="<?php echo '?add-to-cart='.$offer_product_id; ?>" class="buttongap button wcfmmp_product_multivendor_action_button" ><?php echo apply_filters( 'add_to_cart_text', __( 'Add to Cart', 'wc-multivendor-marketplace') ); ?></a>
		<?php } ?>
		<a href="<?php echo get_permalink($offer_product_id); ?>" class="buttongap button wcfmmp_product_multivendor_action_button" ><?php echo __( 'Details', 'wc-multivendor-marketplace' ); ?></a>
	</div>
	<div class="wcfm_clearfix"></div>							
</div>