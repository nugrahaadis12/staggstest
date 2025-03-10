<?php
namespace WooEasyDuplicateProduct;

/**
 * 
 */
class MetaBox
{
	
	function __construct()
	{
		$this->metaboxes();
	}

	function wedp_add_the_metabox($_post){
	
		global $post;	

		$post_type = $post->post_type;

		if('product' != $post_type){
			return ;//$_post;
		}

		add_meta_box( 'woocommerce-easy-product-duplicate', __( 'Duplicate this product', 'woocommerce' ), [$this, 'wedp_show_the_duplicate_link'], 'product', 'side', 'high' );

		return $_post;
	}

	function wedp_show_the_duplicate_link ($post){
		
		$url = '<a target="_blank" href="' . wp_nonce_url( admin_url( 'edit.php?post_type=product&action=duplicate_product&amp;post=' . $post->ID ), 'woocommerce-duplicate-product_' . $post->ID ) . '" aria-label="' . esc_attr__( 'Make a duplicate from this product', 'woocommerce' )
				. '" rel="permalink">' . __( 'Duplicate once', 'woocommerce' ) . '</a>';


		$multi_box = file_get_contents(WP_PLUGIN_DIR . '/woo-easy-duplicate-product/multi-box.php');
	 
		$meta_box = $url . $multi_box;

		echo '<script>
			var wedp_product_id = '. $post->ID .';

			var wedp_wp_nonce = "'.wp_create_nonce( 'wedp-duplicate-product-nonce' ).'";

		</script>';
		echo $meta_box;
	}
	
	public function metaboxes()
	{
		add_action( 'add_meta_boxes', [$this, 'wedp_add_the_metabox'], 30 );

	}
}