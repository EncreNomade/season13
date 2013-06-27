<?php

abstract class Payment {

    public $name = "Payment";

    public static function extractOrder($order) {
        if(get_class($order) != "Model_Achat_Order") {
            throw new CartException(Config::get('errormsgs.payment.4201'), 4201);
        }
        
        $cart = $order->getCart();
        $products = $cart->getProducts();
        $currency = $cart->getCurrency();
        $currencyCode = $currency->iso_code;
        $user_id = $order->user_id;
        
        //::ITEMS::
        // NOTE : sum of all the item amounts should be equal to payment  amount 
        
        //$items = array();
        $total_amount = 0;
        foreach ($products as $product) {
            $product_amt = $product->getRealPrice();
            
            /*
            array_push($items, array(
                'name' => $product->product_title, 
                'amt' => number_format($product_amt, 2, '.', ''),
                'qty' => 1
            ));*/
            
            $total_amount += $product_amt;
        }
        
        // Only one item to paypal
        $items = array(
            array(
                'name' => "Commande Season 13", 
                'amt' => number_format($total_amount, 2, '.', ''),
                'qty' => 1
            )
        );
        
        $ht = round($total_amount * (1 - $cart->tax_rate/100), 2);
        $tax = $total_amount - $ht;
        
        return array('products' => $products, 
                     'currency' => $currency, 
                     'currency_code' => $currencyCode,
                     'user_id' => $user_id, 
                     'items' => $items,
                     'total' => $total_amount,
                     'tva' => number_format($cart->tax_rate, 2, '.', '')."%",
                     'ht' => $ht,
                     'tax' => $tax);
    }
    
    protected static function save($payment, $token) {
        $payments = Session::get('payment');
        $payments[$token] = $payment;
        Session::set('payment', $payments);
    }
    
    protected static function close($token) {
        $payments = Session::get('payment');
        unset($payments[$token]);
        Session::set('payment', $payments);
    }
    
    public static function getByToken($token) {
        $payments = Session::get('payment');
        if(isset($payments[$token]))
            return $payments[$token];
        else return null;
    }
    
    abstract public function checkoutOrder($order, $token = null);
    abstract public function confirmPayment($order, $token, $supp);
}