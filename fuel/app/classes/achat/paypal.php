<?php

class Paypal extends Payment {
    public $name = "Paypal";
    
    public function checkoutOrder($order) {
        $o = self::extractOrder($order);
    
        require_once (APPPATH."classes/custom/paypalfunctions.php");
	    
	    // ==================================
        // PayPal Express Checkout Module
        // ==================================
	    
        //'------------------------------------
        //' The paymentAmount is the total value of 
        //' the purchase
        //'------------------------------------

        $paymentAmount = number_format($o['total_amt'], 2, '.', '');
        
        
        //'------------------------------------
        //' The currencyCodeType  
        //' is set to the selections made on the Integration Assistant
        //'------------------------------------
        $currencyCodeType = $o['currency_code'];
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

		$resArray = SetExpressCheckoutDG( $paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL, $o['items'] );
		
        $ack = strtoupper($resArray["ACK"]);
        if($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING")
        {
                $token = urldecode($resArray["TOKEN"]);
                
                $order->checkout($token);
                self::save($this, $token);
                
                RedirectToPayPalDG( $token );
        }
        else
        {
                //Display a user friendly Error on the page using any of the following error information returned by PayPal
                $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
                $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
                $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
                $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
                
                /*echo "SetExpressCheckout API call failed. ";
                echo "Detailed Error Message: " . $ErrorLongMsg;
                echo "Short Error Message: " . $ErrorShortMsg;
                echo "Error Code: " . $ErrorCode;
                echo "Error Severity Code: " . $ErrorSeverityCode;*/
                
                return array('success' => false, 'errorMessage' => 'Erreur: ' . $ErrorLongMsg);
        }
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
    	$res = GetExpressCheckoutDetails( $token );
    	
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
    	$token 				= $token;
    	$payerID 			= $supp['PayerID'];
    	$paymentType 		= 'Sale';
    	$currencyCodeType 	= $res['CURRENCYCODE'];
        
        
    	$resArray = ConfirmPayment ( $token, $paymentType, $currencyCodeType, $payerID, $finalPaymentAmount, $o['items'] );
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
    		
    		self::close($token);
    		
    		return array('success' => true, 'confirmData' => $data);
    	}
    	else
    	{
    	    $order->payfailed('paypal', $resArray);
    	    
    	    //Display a user friendly Error on the page using any of the following error information returned by PayPal
    		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
    		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
    		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
    		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
            
    		/*echo "DoExpressCheckoutDetails API call failed. ";
    		echo "Detailed Error Message: " . $ErrorLongMsg;
    		echo "Short Error Message: " . $ErrorShortMsg;
    		echo "Error Code: " . $ErrorCode;
    		echo "Error Severity Code: " . $ErrorSeverityCode;*/
    		
    		return array('success' => false, 'errorMessage' => $ErrorLongMsg);
    	}
    }
}