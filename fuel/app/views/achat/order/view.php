<article class="main_container text_selectable">
    <div id="order_container">
        <h1>Récapitulatif de la commande</h1>
        
        <?php if($current_user)  echo "<h5>Référence de commande : " . $order->reference . "</h5>"; ?>
        
        <div id="order-detail">
            <?php echo View::forge('achat/order/recaptulatif', array(
                                    'total' => $total,
                                    'ht' => $ht,
                                    'tva' => $tva,
                                    'tax' => $tax,
                                    'products' => $products,
                                    'currency' => $currency,
                                    'modifiable' => true)
                                  ); ?>
        </div>
        <br/>
        <a href="<?php echo $base_url; ?>"><strong>Je continue mes achat</strong></a>

    <?php if($current_user): ?>
    
        <div id="order-adresse">
            <?php echo View::forge('user/address/view')->render(); ?>
        </div>
        
        <div id="order-agreement">
            <h5>
                <label>
                    <input id="accept-cgv" type="checkbox"/>  J'ai lu <a id="show_cgv" href="#">les conditions générales de vente</a> et j'y adhère sans réserve.
                </label>
            </h5>
        </div>
        
        <div id="order-payment">
        
            <h2>Je règle mes achats:</h2>
        
        <?php if($total): ?>
            <!-- INFO: The post URL "checkout.php" is invoked when clicked on "Pay with PayPal" button.-->
            
            <form id='paypalBuyForm' action='<?php echo $base_url; ?>achat/order/paypalCheckout' METHOD='POST'>
            	<input type='image' name='paypal_submit' id='paypal_submit' src='https://www.paypal.com/en_US/i/btn/btn_dg_pay_w_paypal.gif' border='0' align='top' alt='Pay with PayPal'/>
            	<cite>En cliquant sur ce bouton, tu peux régler tes achats sans avoir de compte Paypal. Une carte bancaire suffit.</cite>
            </form>
            
            <!-- Add Digital goods in-context experience. Ensure that this script is added before the closing of html body tag -->
            
            <script src='https://www.paypalobjects.com/js/external/dg.js' type='text/javascript'></script>
            
        <?php else: ?>
            
            <a id='checkout' href="<?php echo $base_url; ?>achat/order/freeCheckout">
                <button>Confirme Commande</button>
            </a>
            <!--
            <a href="<?php echo $base_url; ?>achat/order/passCommande">
                <?php echo Asset::img('season13/btn_buynow_paypal.gif'); ?>
            </a>-->
        
        <?php endif; ?>
        
        </div>
        
    <?php else: ?>
        
        <div id="order-login">
            <h5>Tu dois <a href="javascript:showLogin()">te connecter</a> ou <a href="javascript:showSignup()">créer un compte</a> d'abord avec les boutons en haut à droite de la page.</h5>
            <script type="text/javascript">
                $(document).ready(showLogin);
            </script>
        </div>
        
    <?php endif; ?>
    
        <br/>
        <br/>
        <br/>
        
    </div>
</article>

<div class="topcenter text_selectable">
    <div id="cgv_dialog" class="dialog animate_medium hidden">
        <div class="close right"></div>
        <h1>Conditions générales de ventes</h1>
        <div class="sep_line"></div>
    </div>
</div>