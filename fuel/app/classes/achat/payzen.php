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
    
    
    
    public function checkoutOrder($order) {
        $o = self::extractOrder($order);
    
        // Parameters general
        $params = Config::get('custom.payzen');
        
        // Parameters of this order
        $params['vads_currency'] = $o['currency']->iso_code_num;
        $params['vads_amount'] = $o['total_amt'];
        $params['vads_order_id'] = $order->reference;
        $params['vads_cust_name'] = Model_13user::find($o['user_id'])->pseudo;
        $params['vads_cust_country'] = $order->country_code;
        
        // Parameters addition
        $params['vads_trans_id'] = $order->id;
        $params['vads_trans_date'] = gmdate("YmdHis", time());
        $params['signature'] = self::get_Signature($params, $params['key']);
        
        // CURL don't work
        $curl = Request::forge('https://secure.payzen.eu/vads-payment/', 'curl');
        //$curl->set_method('post')->set_params($params);
        
        // Execute the request to uglifyjs
        //$curl->execute();
    }
    
    
    public function confirmPayment($order, $token, $supp) {
        // Collect items again for appling the micropayment discount
        $o = self::extractOrder($order);
        
        $data = array(
            'total' => $o['total_amt'],
            'ht' => $o['total_ht'],
            'tax' => $o['total_tax'],
            'tva' => $o['tva'],
            'products' => $o['products'],
            'currency' => $o['currency'],
            'user_id' => $o['user_id'],
        );
        
        
    }
    
}