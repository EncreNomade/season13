<?php

class Payzen extends Payment {

    public $name = "Payzen";
    
    
    /*--------------------------------------------------------------------------------------------------------------------
    
    FONCTION => CALCUL DE LA SIGNATURE
    -------------------------------------------------------------------------------------------------------------------*/
    private static function get_Signature($fields, $key) {
        
        ksort($fields); // tri des paramétres par ordre alphabétique
        $contenu_signature = "";
        foreach ($fields as $nom => $valeur)
        {
        	if(substr($nom, 0, 5) == 'vads_') {
        	    $contenu_signature .= $valeur."+";
        	}
        }
        $contenu_signature .= $key;	// On ajoute le certificat à la fin de la chaîne.
        $signature = sha1($contenu_signature);
        return($signature);
        
    }
    
    /*--------------------------------------------------------------------------------------------------------------------
    
    FONCTION => CONTROLE DE LA SIGNATURE RECUE
    -------------------------------------------------------------------------------------------------------------------*/
    private static function Check_Signature($fields, $key) {
        $result = 'false';
        
        $signature = get_Signature($fields, $key);
        
        if(isset($fields['signature']) && ($signature == $fields['signature']))
        {
        	$result='true';
        	
        }
        return ($result);
    }
    
    private static function update_session($transid, $order) {
        // Get payzen orders
        $orders = Session::get('payzen_order', false);
        if(!$orders) {
            $orders = array();
            Session::set('payzen_order', $orders);
        }
        
        // Update
        $orders[$transid] = $order->reference;
        Session::set('payzen_order', $orders);
    }
    
    private static function gene_trans_id($orderid) {
        $id = sprintf("%04s", $orderid);
        
        // Get canceled payzen orders
        $orders = Session::get('payzen_order');
        if(!$orders) {
            $orders = array();
            Session::set('payzen_order', $orders);
        }
        // Check existance
        for ($i = 0; $i < 100; $i++) {
            $transid = sprintf("%02s", $i).$id;
            if(!array_key_exists($transid, $orders)) {
                return $transid;
            }
        }
        
        return $transid;
    }
    
    
    
    public static function getCheckoutForm($order) {
        $o = self::extractOrder($order);
        
        // Parameters general
        $params = Config::get('custom.payzen');
        
        // Parameters of this order
        $params['vads_currency'] = $o['currency']->iso_code_num;
        $params['vads_amount'] = number_format($o['total'], 2, '', '');
        $params['vads_order_id'] = $order->reference;
        $params['vads_cust_name'] = Model_13user::find($o['user_id'])->pseudo;
        $params['vads_cust_country'] = $order->country_code;
        
        // Parameters addition
        $params['vads_trans_id'] = self::gene_trans_id($order->id);
        $params['vads_trans_date'] = gmdate("YmdHis", time());
        $params['signature'] = self::get_Signature($params, $params['key']);
        
        self::update_session($params['vads_trans_id'], $order);
        
        return View::forge('achat/order/payzen_payment', $params)->render();
    }
    
    
    
    public function checkoutOrder($order, $token = null) {
        $order->checkout($token);
        self::save($this, $token);
        return array('success' => true);
    }
    
    
    public function confirmPayment($order, $token, $supp) {
        
    }
    
}