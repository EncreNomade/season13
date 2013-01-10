<?php

class Model_Achat_Cart extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'secure_key',
		'tax_rate',
		'country_code',
		'currency_code',
		'conversion_rate',
		'ordered',
		'supp'
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);
	
    public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('secure_key', 'Secure key', 'required');
		$val->add_field('tax_rate', 'Tax rate', 'required');
		$val->add_field('country_code', 'Country code', 'required|max_length[3]');
		$val->add_field('currency_code', 'Currency code', 'required|max_length[3]');
		$val->add_field('conversion_rate', 'Conversion rate', 'required');
		$val->add_field('ordered', 'Ordered tag', 'required');

		return $val;
	}
	
	
	public function getUser() {
	    if( is_null($this->user) )
	        $this->user = Model_13user::find($this->user_id);
	    
	    return $this->user;
	}
	
	
	private function addable($product_id) {
	    $existed = Model_Achat_Cartproduct::query()->where(
	        array(
	            'cart_id' => $this->id,
	            'product_id' => $product_id,
	            'offer' => 0,
	        )
	    )->count();
	    
	    if( $existed > 0 )
	        return false;
	    else return true;
	}
	
	public function addProduct($product_id, $is_offer = 0, $offer_tar = "") {
	    // Find product
	    $product = Model_Achat_13product::find($product_id);
	    if( is_null($product) ) {
	        return array('success' => false, 'errorCode' => 4001, 'errorMessage' => Config::get('errormsgs.payment.4001'));
	    }
	    
	    // Test addable
	    if( !$is_offer && !$this->addable($product_id) ) {
	        return array('success' => false, 'errorCode' => 4005, 'errorMessage' => Config::get('errormsgs.payment.4005'));
	    }
	
	    // Find taxed price and discount for the product
	    $localprice = Model_Achat_Productprice::query()->where(
	        array(
	            'product_id' => $product_id,
	            'country_code' => $this->country_code,
	        )
	    )->get_one();
	    
	    if( is_null($localprice) ) {
	        // Get default taxed price
	        $localprice = Model_Achat_Productprice::query()->where(
	            array(
	                'product_id' => $product_id,
	                'country_code' => Config::get('achat.default_country'),
	            )
	        )->get_one();
	        
	        if( is_null($localprice) ) {
	            return array('success' => false, 'errorCode' => 4002, 'errorMessage' => Config::get('errormsgs.payment.4002'));
	        }
	        
	        // Conversion default price to local price
	        // Suppose that default price has the currency conversion rate at 1.0
	        $localprice->taxed_price = $localprice->taxed_price * $this->conversion_rate;
	        $localprice->discount = 1;
	    }
	    
	    // Forge the cart product model
	    $cartProduct = Model_Achat_Cartproduct::forge(array(
	        "cart_id" => $this->id,
	        "product_id" => $product_id,
	        "taxed_price" => $localprice->taxed_price,
	        "discount" => $localprice->discount,
	        "offer" => $is_offer ? 1 : 0, 
	        "offer_target" => $offer_tar,
	    ));
	    
	    // Save product
	    if ($cartProduct and $cartProduct->save()) {
	        return array('success' => true);
	    }
	    else {
	        return array('success' => false, 'errorCode' => 4003, 'errorMessage' => Config::get('errormsgs.payment.4003'));
	    }
	}
	
	public function removeProduct($product_id) {
	    // Find product in cart
	    $cartproduct = Model_Achat_Cartproduct::query()->where(
	        array(
	            'cart_id' => $this->id,
	            'product_id' => $product_id,
	        )
	    )->get_one();
	    
	    if( is_null($cartproduct) ) {
	        return array('success' => false, 'errorCode' => 4004, 'errorMessage' => Config::get('errormsgs.payment.4004'));
	    }
	    else {
	        $cartproduct->delete();
	        return array('success' => true);
	    }
	}
	
	public function getProducts() {
	    // Find all products in cart
	    $cartproducts = Model_Achat_Cartproduct::find_by_cart_id($this->id);
	    return $cartproducts;
	}
}
