<?php

class Controller_Achat_Orderrest extends Controller_Restbase
{

    public function post_can_be_paid() {
        
    }
    
    
    public function get_update() {
        $recent = Model_Achat_Order::getRecentCheckoutOrder();
        
        if(empty($recent['token'])) {
            return array('action' => 'NO_PAYMENT');
        }
        else {
            switch($recent['order']->state) { 
            case "FINALIZE":
                return array('action' => 'CONFIRM_PAYMENT');
                
            case "FAIL": 
            case "STARTPAY":
                $recent['order']->cancelPayment($recent['token']);
                
                return array('action' => 'CANCEL_PAYMENT');
            }
        }
    }
    
    public function post_payzenCheckout() {
        $order = Model_Achat_Order::getCurrentOrder();
        $signature = Input::post('signature');
        
        $resp = array('success' => true);
        
        if( !empty($signature) ) {
            if(!empty($order)) {
                try {
                    $result = $order->checkoutWith(new Payzen(), $signature);
                    
                    if(!$result['success'])
                        $resp = $result;
                }
                catch (FuelException $e) {
                    $resp = array('success' => false, 'errorCode' => 4203, 'errorMessage' => Config::get('errormsgs.payment.4203'));
                }
            }
            else {
                $resp = array('success' => false, 'errorCode' => 4201, 'errorMessage' => Config::get('errormsgs.payment.4201'));
            }
        }
        else {
            $resp = array('success' => false, 'errorCode' => 4204, 'errorMessage' => Config::get('errormsgs.payment.4204'));
        }
        
        return $resp;
    }

}