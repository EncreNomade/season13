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
	
	private static $token_ptn = "/(?P<ip>[\d\.]+)\_(?P<cart>\d+)\_(?P<user>\d+)\_(?P<time>\d+)/";
	private static $token_expire_time = 86400; // 60*60*24
	
	private static function decryptToken($token) {
	    $tokenstr = Crypt::decode($token);
	    preg_match(self::$token_ptn, $tokenstr, $result);
	    
	    if( array_key_exists('ip', $result) && 
	        array_key_exists('cart', $result) && 
	        array_key_exists('user', $result) && 
	        array_key_exists('time', $result) ) {
	        return $result;
	    }
	    
	    return false;
	}
	private static function cryptToken($ip, $cart_id, $user_id = null) {
	    if(is_null($user_id))
	        $user_id = 0;
	    $token = Crypt::encode($ip."_".$cart_id."_".$user_id."_".time());
	    return $token;
	}
	private static function validateToken($tokenarr, $ip, $user_id = null) {
	    if(is_null($user_id))
	        $user_id = 0;
	        
	    if(is_array($tokenarr)) {
	        if( $ip == $tokenarr['ip'] && $user_id == $tokenarr['user'] ) {
	            $duration = time()-$tokenarr['time'];
	            if($duration > 0 && $duration < self::$token_expire_time) {
	                return true;
	            }
	        }
	    }
	    
	    return false;
	}
	
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
	
	public static function createCart($realip, $country_code, $user_id = null) {
	    if(is_null($realip) || $realip == '0.0.0.0') {
	        throw new CartException(Config::get('errormsgs.payment.4008'), 4008);
	    }
	    if(empty($country_code)) $country_code = "FR";
	    
	    // Find user
	    if(!is_null($user_id)) {
	        $user = Model_13user::find($user_id);
	        if(is_null($user)) {
	            throw new CartException(Config::get('errormsgs.payment.4009'), 4009);
	        }
	    }
	    
	    // Get existed cart with cookie
	    $token = Cookie::get('cart_token');
	    if($token) {
    	    // Decrypt
    	    $tokenarr = self::decryptToken($token);
    	    if($tokenarr) {
        	    // Validate token
        	    $valid = self::validateToken($tokenarr, $realip, $user_id);
        	    if($valid) {
        	        // Init cart
        	        $cart = self::find($tokenarr['cart']);
        	        if($cart) {
            	        // Update cookie
            	        Cookie::set('cart_token', $token, self::$token_expire_time);
            	        Session::set('current_cart', $cart);
            	        return $cart;
        	        }
        	    }
    	    }
	    }
	
	    // No existed valid cart found
	    // Find country
	    $country = Model_Achat_Country::getWithCurrency($country_code);
	    if(is_null($country)) {
	        throw new CartException(Config::get('errormsgs.payment.4006'), 4006);
	    }
	    
	    $cart = self::forge(array(
	        'user_id' => $user_id ? $user_id : "",
	        'secure_key' => Str::random('alnum', 16),
	        'tax_rate' => $country->tax_rate,
	        'country_code' => $country_code,
	        'currency_code' => $country->currency_code,
	        'conversion_rate' => $country->currency->conversion_rate,
	        'ordered' => 0,
	        'supp' => ""
	    ));

	    $cart->currency = $country->currency;
	    
	    if( $cart and $cart->save() ) {
	        $cookieValue = self::cryptToken($realip, $cart->id, $user_id);
	        Cookie::set('cart_token', $cookieValue, self::$token_expire_time);
	        Session::set('current_cart', $cart);
	    
	        return $cart;
	    }
	    else {
	        throw new CartException(Config::get('errormsgs.payment.4007'), 4007);
	    }
	}
	
	public static function getCurrentCart() {
	    $current_cart = Session::get('current_cart');
	    if($current_cart) {
	        return $current_cart;
	    }
	    else return false;
	}

	public function getCurrency() {
		if(empty($this->currency)) {
			$this->currency = Model_Achat_Currency::find_by_iso($this->currency_code);
		}
		return $this->currency;
	}
	
	
	public function getUser() {
	    if($this->user_id == "")
	        return null;
	        
	    if( is_null($this->user) )
	        $this->user = Model_13user::find($this->user_id);
	    
	    return $this->user;
	}
	
	public function setUser($user_id) {
	    // User id already exist
	    if(!empty($this->user_id))
	        return false;
	        
	    $user = Model_13user::find($user_id);
	    if(is_null($user)) {
	        throw new CartException(Config::get('errormsgs.payment.4010')." (Error code : 4010)");
	    }
	    $this->user = $user;
	    
	    return true;
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
	
	public function isEmpty() {
	    return (Model_Achat_Cartproduct::query()->where('cart_id', $this->id)->count() == 0);
	}
	
	public function addProduct($product_id, $is_offer = 0, $offer_tar = "") {
	    if($this->ordered) return false;
	    
	    // Find product
	    $product = Model_Achat_13product::find($product_id);
	    if( is_null($product) ) {
	        throw new CartException(Config::get('errormsgs.payment.4001'), 4001);
	    }
	    
	    // Test addable
	    if( !$is_offer && !$this->addable($product_id) ) {
	        throw new CartException(Config::get('errormsgs.payment.4005'), 4005);
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
	        throw new CartException(Config::get('errormsgs.payment.4003'), (4003));
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
	        throw new CartException(Config::get('errormsgs.payment.4004'), 4004);
	    }
	    else {
	        $cartproduct->delete();
	        return true;
	    }
	}
	
	public function getProducts() {
	    // Find all products in cart
	    $cartproducts = Model_Achat_Cartproduct::query()->where('cart_id', $this->id)->get();
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
