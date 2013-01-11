<?php

class CartException extends \FuelException {}

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
	
	public static function createCart($user_id, $country_code) {
	    
	}
	
	
	public function getUser() {
	    if( is_null($this->user) )
	        $this->user = Model_13user::find($this->user_id);
	    
	    return $this->user;
	}
	
	public function refresh() {
	    if($this->ordered) return false;
	    
	    $cartproducts = $this->getProducts();
        $deleted = array();
        $modified = array();
        
	    foreach ($cartproducts as $cartproduct) {
	        $product = Model_Achat_13product::find($cartproduct->product_id);
	        $title = $cartproduct->product_title;
	        
	        if($product) {
	            $taxed_price = $product->getLocalPrice($this->country_code);
	            $discount = $product->getLocalDiscount($this->country_code);
	            if( $cartproduct->taxed_price != $taxed_price || $cartproduct->discount != $discount ) {
	                $cartproduct->taxed_price = $taxed_price;
	                $cartproduct->discount = $discount;
	                array_push($modified, $title);
	            }
	        }
	        else {
	            $cartproduct->delete();
	            array_push($deleted, $title);
	        }
	    }
	    
	    return array('deleted' => $deleted, 'modified' => $modified);
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
	    if($this->ordered) return false;
	    
	    // Find product
	    $product = Model_Achat_13product::find($product_id);
	    if( is_null($product) ) {
	        throw new CartException(Config::get('errormsgs.payment.4001')." (Error code : 4001)");
	    }
	    
	    // Test addable
	    if( !$is_offer && !$this->addable($product_id) ) {
	        throw new CartException(Config::get('errormsgs.payment.4005')." (Error code : 4005)");
	    }
	
	    // Find taxed price and discount for the product
	    $taxed_price = $product->getLocalPrice($this->country_code);
	    $discount = $product->getLocalDiscount($this->country_code);
	    
	    // Forge the cart product model
	    $cartProduct = Model_Achat_Cartproduct::forge(array(
	        "cart_id" => $this->id,
	        "product_id" => $product_id,
	        "product_title" => $product->title,
	        "taxed_price" => $taxed_price,
	        "discount" => $discount,
	        "offer" => $is_offer ? 1 : 0, 
	        "offer_target" => $offer_tar,
	    ));
	    
	    // Save product
	    if ($cartProduct and $cartProduct->save()) {
	        return true;
	    }
	    else {
	        throw new CartException(Config::get('errormsgs.payment.4003')." (Error code : 4003)");
	    }
	}
	
	public function removeProduct($product_id) {
	    if($this->ordered) return false;
	    
	    // Find product in cart
	    $cartproduct = Model_Achat_Cartproduct::query()->where(
	        array(
	            'cart_id' => $this->id,
	            'product_id' => $product_id,
	        )
	    )->get_one();
	    
	    if( is_null($cartproduct) ) {
	        throw new CartException(Config::get('errormsgs.payment.4004')." (Error code : 4004)");
	    }
	    else {
	        $cartproduct->delete();
	        return true;
	    }
	}
	
	public function getProducts() {
	    // Find all products in cart
	    $cartproducts = Model_Achat_Cartproduct::find_by_cart_id($this->id);
	    return $cartproducts;
	}
	
    public function clear() {
        if($this->ordered) return false;
        
        // Find products in cart
        $cartproducts = $this->getProducts();
        foreach ($cartproducts as $product) {
            $product->delete();
        }
        return true;
    }
    
    
    public function addition() {
        $cartproducts = $this->getProducts();
        $total = 0;
        foreach ($cartproducts as $product) {
            $total += $product->discount * $product->taxed_price;
        }
        return round($total, 2);
    }
}
