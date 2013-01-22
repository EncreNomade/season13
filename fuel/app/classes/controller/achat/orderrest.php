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

}