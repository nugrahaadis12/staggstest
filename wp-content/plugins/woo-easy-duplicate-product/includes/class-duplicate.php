<?php
namespace WooEasyDuplicateProduct;

/**
 * 
 */
class Duplicate
{
	
	function __construct()
	{
		$this->filters();
		$this->actions();
	}

	function wedb_duplicate_product_bulk_action($bulk_actions)
	{	
		$bulk_actions['wedp_duplicate_product'] = 'Duplicate product';

		return $bulk_actions;

	}

	function wedb_handle_duplicate_product_bulk_action($redirect_to, $doaction, $post_ids)
	{	

		if($doaction != 'wedp_duplicate_product'){
			return $redirect_to;
		} 

		$duplicated = [];
		

		foreach ($post_ids as $product_id) {
			
			$duplicate_product = $this->duplicate_product ($product_id);

			if($duplicate_product){
				$duplicate[] = $duplicate_product;
			}
		}

		$total_updated = count($duplicated);

		$redirect_to .= '&wedp_duplicated='.$total_updated;


		return $redirect_to;

	}

	function wedp_duplicate_product_action(){

	if(isset($_POST['wedp_multiple_product_duplicate'])){
		//Let's verify our nonce
		$nonce = $_REQUEST['_wp_nonce'];
		if(! wp_verify_nonce($nonce, 'wedp-duplicate-product-nonce')){
			die("Why oh why you do me dat? Why?");
		}
		$product_id = $_POST['product_id'];
		$multiple_products_number = $_POST['multiple_products_number'];

		$duplicated = [];

		for($i=0; $i<$multiple_products_number; $i++){

				// We will duplicate each product here.
			
			$duplicate_product = $this->duplicate_product($product_id);

			if($duplicate_product){
				$duplicated[] = $duplicate_product;
			}

		}

		$total_updated = count($duplicated);

		if ($total_updated >= 2) {
			$status = 'success';
		} else {
			$status = 'error';
		}

		$message = [

			'status' => $status,
			'total_updated' => $total_updated

		];

		print_r(json_encode($message));


	} else {

		echo "Why you do me dat?";
	}

	die();
}

	public function filters()
	{
		add_filter('bulk_actions-edit-product', [$this, 'wedb_duplicate_product_bulk_action']);
		add_filter('handle_bulk_actions-edit-product', [$this, 'wedb_handle_duplicate_product_bulk_action'],10, 3);
	}

	public function actions()
	{
		//Let's add admin-ajax to handle the multiple duplications.

		add_action('wp_ajax_wedp_duplicate_product', [$this, 'wedp_duplicate_product_action']);

	}
	/**
	 * If there is no product, it returns false;
	 */
	public function duplicate_product( $product_id )
	{			
				//Consider adding a number to each duplicate for easy identification
		
				$WC_Duplicate = new \WC_Admin_Duplicate_Product;
				$product = wc_get_product( $product_id ); 

				if($product){
					
					//Let's see if we can add some kind of identifier to the product name.


					$duplicate = $WC_Duplicate->product_duplicate( $product );
					do_action( 'woocommerce_product_duplicate', $duplicate, $product );

					unset($WC_Duplicate);// A bit of memory management, just in case.

					return $product;
				} else {
					return false;
				}
	}
}
