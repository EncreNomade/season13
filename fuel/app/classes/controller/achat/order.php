<?php

class Controller_Achat_Order extends Controller_Frontend
{
    public function action_view()
	{
        $this->template->js_supp = 'order.js';
        $this->template->css_supp = 'order.css';

	    if($this->cart) {
	        $products = $this->cart->getProducts();
	        $currency = $this->cart->getCurrency();
	        $total = $this->cart->addition();
	        $ht = round($total * (1 - $this->cart->tax_rate/100), 2);
	        $tax = $total - $ht;
	        
	        if($this->current_user) {
    	        // Order the cart
    	        $order = Model_Achat_Order::orderCart($this->cart);
    	        	        
    	        if(!$order || !$this->cart || count($products) == 0) {
    	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
    	            $this->template->content = View::forge('achat/order/empty');
    	        }
    	        else {
    	            $data = array(
    	                'order' => $order,
    	                'cart' => $this->cart,
    	                'total' => $total,
    	                'ht' => $ht,
    	                'tax' => $tax,
    	                'products' => $products,
    	                'currency' => $currency,
    	            );
    	            
    	            $user_address = Model_User_Address::query()->where('user_id', $this->current_user->id)->get_one();
    	            View::set_global('user_address', $user_address);
    	            
    	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
    	        	$this->template->content = View::forge('achat/order/view', $data);
    	        }
	        }
	        // Show user login
	        else {
	            $data = array(
	                'cart' => $this->cart,
	                'total' => $total,
	                'ht' => $ht,
	                'tax' => $tax,
	                'products' => $products,
	                'currency' => $currency,
	            );
	            
	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	            $this->template->content = View::forge('achat/order/view', $data);
	        }
	    }
	    else {
	        $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	        $this->template->content = View::forge('achat/order/empty');
	    }
	}
	
	public function action_paypalCheckout()
	{
	    $order = Model_Achat_Order::getCurrentOrder();
	    
	    if(!empty($order)) {
    	    $products = $order->getCart()->getProducts();
    	    $currency = $order->currency_code;
    	    $user_id = $order->user_id;
    	    
    	    //::ITEMS::
    	    // NOTE : sum of all the item amounts should be equal to payment  amount 
    	    
    	    $items = array();
    	    $total_amount = 0;
    	    foreach ($products as $product) {
    	        $product_amt = $product->getRealPrice();
    	        
    	        array_push($items, array(
    	            'name' => $product->product_title, 
    	            'amt' => number_format($product_amt, 2, '.', ''),
    	            'qty' => 1
    	        ));
    	        
    	        $total_amount += $product_amt;
    	    }
    	    
    	    require_once (APPPATH."classes/custom/paypalfunctions.php");
    	    
    	    // ==================================
            // PayPal Express Checkout Module
            // ==================================
    
    	
    	    
            //'------------------------------------
            //' The paymentAmount is the total value of 
            //' the purchase
            //'------------------------------------
    
            $paymentAmount = number_format($total_amount, 2, '.', '');
            
            
            //'------------------------------------
            //' The currencyCodeType  
            //' is set to the selections made on the Integration Assistant 
            //'------------------------------------
            $currencyCodeType = $currency;
            $paymentType = "Sale";
    
            //'------------------------------------
            //' The returnURL is the location where buyers return to when a
            //' payment has been succesfully authorized.
            //'
            //' This is set to the value entered on the Integration Assistant 
            //'------------------------------------
            $returnURL = Config::get('custom.paypal.return_url');
    
            //'------------------------------------
            //' The cancelURL is the location buyers are sent to when they hit the
            //' cancel button during authorization of payment during the PayPal flow
            //'
            //' This is set to the value entered on the Integration Assistant 
            //'------------------------------------
            $cancelURL = Config::get('custom.paypal.cancel_url');
    
            //'------------------------------------
            //' Calls the SetExpressCheckout API call
            //'
            //' The CallSetExpressCheckout function is defined in the file PayPalFunctions.php,
            //' it is included at the top of this file.
            //'-------------------------------------------------
    
    		$resArray = SetExpressCheckoutDG( $paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL, $items );
    		
            $ack = strtoupper($resArray["ACK"]);
            if($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING")
            {
                    $token = urldecode($resArray["TOKEN"]);
                    try {
                        $order->checkout($token);
                    }
                    catch (FuelException $e) {
                        
                    }
                    RedirectToPayPalDG( $token );
            }
            else
            {
                    //Display a user friendly Error on the page using any of the following error information returned by PayPal
                    $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
                    $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
                    $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
                    $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
                    
                    echo "SetExpressCheckout API call failed. ";
                    echo "Detailed Error Message: " . $ErrorLongMsg;
                    echo "Short Error Message: " . $ErrorShortMsg;
                    echo "Error Code: " . $ErrorCode;
                    echo "Error Severity Code: " . $ErrorSeverityCode;
            }
        }
	}
	
	public function action_paypalConfirm()
	{
	    // Get order
	    $order = Model_Achat_Order::getCheckoutOrder($_REQUEST['token']);
	    
	    if(!empty($order)) {
	        // Collect items again for appling the micropayment discount
	        $cart = $order->getCart();
	        $products = $cart->getProducts();
	        
	        //::ITEMS::
	        // NOTE : sum of all the item amounts should be equal to payment  amount 
	        
	        $items = array();
	        $total_amount = 0;
	        foreach ($products as $product) {
	            $product_amt = $product->getRealPrice();
	            
	            array_push($items, array(
	                'name' => $product->product_title, 
	                'amt' => number_format($product_amt, 2, '.', ''),
	                'qty' => 1
	            ));
	            
	            $total_amount += $product_amt;
	        }
	        
	        $ht = round($total_amount * (1 - $cart->tax_rate/100), 2);
	        $tax = $total_amount - $ht;
	        
	        $data = array(
	            'total' => $total_amount,
	            'ht' => $ht,
	            'tax' => $tax,
	            'products' => $products,
	            'currency' => $cart->getCurrency(),
	        );
	    
    	    /* =====================================
    	     *	 PayPal Express Checkout Call
    	     * =====================================
    	     */
    	    require_once (APPPATH."classes/custom/paypalfunctions.php");
    	    
    	    /*
        	 '------------------------------------
        	 ' this  step is required to get parameters to make DoExpressCheckout API call, 
        	 ' this step is required only if you are not storing the SetExpressCheckout API call's request values in you database.
        	 ' ------------------------------------
        	 */
        	$res = GetExpressCheckoutDetails( $_REQUEST['token'] );
        	
        	/*
        	 '------------------------------------
        	 ' The paymentAmount is the total value of
        	 ' the purchase. 
        	 '------------------------------------
        	 */
        
        	$finalPaymentAmount =  $res["AMT"];
        
        	/*
        	 '------------------------------------
        	 ' Calls the DoExpressCheckoutPayment API call
        	 '
        	 ' The ConfirmPayment function is defined in the file PayPalFunctions.php,
        	 ' that is included at the top of this file.
        	 '-------------------------------------------------
        	 */
        
        	//Format the parameters that were stored or received from GetExperessCheckout call.
        	$token 				= $_REQUEST['token'];
        	$payerID 			= $_REQUEST['PayerID'];
        	$paymentType 		= 'Sale';
        	$currencyCodeType 	= $res['CURRENCYCODE'];
        
        
        	$resArray = ConfirmPayment ( $token, $paymentType, $currencyCodeType, $payerID, $finalPaymentAmount, $items );
        	$ack = strtoupper($resArray["ACK"]);
        	if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" )
        	{
        		
        		/*
        	     '********************************************************************************************************************
        		 '
        		 ' THE PARTNER SHOULD SAVE THE KEY TRANSACTION RELATED INFORMATION LIKE
        		 '                    transactionId & orderTime
        		 '  IN THEIR OWN  DATABASE
        		 ' AND THE REST OF THE INFORMATION CAN BE USED TO UNDERSTAND THE STATUS OF THE PAYMENT
        		 '
        		 '********************************************************************************************************************
        		 */
        
        		$transactionId		= $resArray["PAYMENTINFO_0_TRANSACTIONID"]; // Unique transaction ID of the payment.
        		$transactionType 	= $resArray["PAYMENTINFO_0_TRANSACTIONTYPE"]; // The type of transaction Possible values: l  cart l  express-checkout
        		$paymentType		= $resArray["PAYMENTINFO_0_PAYMENTTYPE"];  // Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant
        		$orderTime 			= $resArray["PAYMENTINFO_0_ORDERTIME"];  // Time/date stamp of payment
        		$amt				= $resArray["PAYMENTINFO_0_AMT"];  // The final amount charged, including any  taxes from your Merchant Profile.
        		$currencyCode		= $resArray["PAYMENTINFO_0_CURRENCYCODE"];  // A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD.
        		$feeAmt				= $resArray["PAYMENTINFO_0_FEEAMT"];  // PayPal fee amount charged for the transaction
        	    //	$settleAmt			= $resArray["PAYMENTINFO_0_SETTLEAMT"];  // Amount deposited in your PayPal account after a currency conversion.
        		$taxAmt				= $resArray["PAYMENTINFO_0_TAXAMT"];  // Tax charged on the transaction.
        	    //	$exchangeRate		= $resArray["PAYMENTINFO_0_EXCHANGERATE"];  // Exchange rate if a currency conversion occurred. Relevant only if your are billing in their non-primary currency. If the customer chooses to pay with a currency other than the non-primary currency, the conversion occurs in the customer's account.
        
        		/*
        		 ' Status of the payment:
        		 'Completed: The payment has been completed, and the funds have been added successfully to your account balance.
        		 'Pending: The payment is pending. See the PendingReason element for more information.
        		 */
        
        		$paymentStatus = $resArray["PAYMENTINFO_0_PAYMENTSTATUS"];
        
        		/*
        		 'The reason the payment is pending:
        		 '  none: No pending reason
        		 '  address: The payment is pending because your customer did not include a confirmed shipping address and your Payment Receiving Preferences is set such that you want to manually accept or deny each of these payments. To change your preference, go to the Preferences section of your Profile.
        		 '  echeck: The payment is pending because it was made by an eCheck that has not yet cleared.
        		 '  intl: The payment is pending because you hold a non-U.S. account and do not have a withdrawal mechanism. You must manually accept or deny this payment from your Account Overview.
        		 '  multi-currency: You do not have a balance in the currency sent, and you do not have your Payment Receiving Preferences set to automatically convert and accept this payment. You must manually accept or deny this payment.
        		 '  verify: The payment is pending because you are not yet verified. You must verify your account before you can accept this payment.
        		 '  other: The payment is pending for a reason other than those listed above. For more information, contact PayPal customer service.
        		 */
        
        		$pendingReason = $resArray["PAYMENTINFO_0_PENDINGREASON"];
        
        		/*
        		 'The reason for a reversal if TransactionType is reversal:
        		 '  none: No reason code
        		 '  chargeback: A reversal has occurred on this transaction due to a chargeback by your customer.
        		 '  guarantee: A reversal has occurred on this transaction due to your customer triggering a money-back guarantee.
        		 '  buyer-complaint: A reversal has occurred on this transaction due to a complaint about the transaction from your customer.
        		 '  refund: A reversal has occurred on this transaction because you have given the customer a refund.
        		 '  other: A reversal has occurred on this transaction due to a reason not listed above.
        		 */
        
        		$reasonCode	= $resArray["PAYMENTINFO_0_REASONCODE"];
        
        		// Add javascript to close Digital Goods frame. You may want to add more javascript code to
        		// display some info message indicating status of purchase in the parent window
        		
        		$order->finalize('paypal', $resArray, $amt + $taxAmt);
        		
        		return Response::forge(View::forge('achat/order/confirm', $data));
        	}
        	else
        	{
        	    $order->payfailed('paypal', $resArray);
        	    
        	    //Display a user friendly Error on the page using any of the following error information returned by PayPal
        		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
        		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
        		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
        		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
                
        		echo "DoExpressCheckoutDetails API call failed. ";
        		echo "Detailed Error Message: " . $ErrorLongMsg;
        		echo "Short Error Message: " . $ErrorShortMsg;
        		echo "Error Code: " . $ErrorCode;
        		echo "Error Severity Code: " . $ErrorSeverityCode;
        		
        		return Response::forge(View::forge('achat/order/cancel'));
        	}
    	}
    	else {
    	    return Response::forge(View::forge('achat/order/cancel'));
    	}
	}
	
	public function action_cancel()
	{
	    $token = $_REQUEST['token'];
	    if(isset($token)) {
	        // Get order
	        $order = Model_Achat_Order::getCheckoutOrder($token);
	        if(!empty($order)) 
	            $order->cancelPayment($token);
	    }
	    
	    return Response::forge(View::forge('achat/order/cancel'));
	}
}
