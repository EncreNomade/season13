<div class="main_container">
    <div id="order_container">
        <h1>Récapitulatif de la commande</h1>
        
        <div id="order-detail">
            <table border="1" class="products">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Description</th>
                        <th>Prix</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><strong><?php echo $p->product->reference ;?></strong></td>
                        <td><strong><?php echo $p->product_title ;?></strong><button class="remove_product" data-pid="<?php echo $p->product_id ;?>">Supprimer</button></td>
                        <td><?php echo $p->taxed_price . $currency->sign ;?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>                    
                    <tr>
                        <td colspan="2"><strong>Total HT:</strong></td>
                        <td><?php echo $ht . $currency->sign; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Total taxes:</strong></td>
                        <td><?php echo $tax . $currency->sign; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Total produits TTC:</strong></td>
                        <td><?php echo $total . $currency->sign; ?></td>
                    </tr>
                </tfoot>                
        	    
        	</table>
        </div>
        <br/>
        <a href="<?php echo $base_url; ?>">Je continue mes achat</a>

<?php if($current_user): ?>

    <div id="order-adresse">
        <?php echo View::forge('user/address/view')->render(); ?>
    </div>
    
    <div id="order-agreement">
        <h5>
            <input id="accept-cgv" type="checkbox"/>  J'ai lu les conditions générales de vente et j'y adhère sans réserve. (Lire les Conditions générales de vente)
        </h5>
    </div>
    
    <div id="order-payment">
    
        <!-- INFO: The post URL "checkout.php" is invoked when clicked on "Pay with PayPal" button.-->
        
        <form action='<?php echo $base_url; ?>achat/order/paypalCheckout' METHOD='POST'>
        	<input type='image' name='paypal_submit' id='paypal_submit'  src='https://www.paypal.com/en_US/i/btn/btn_dg_pay_w_paypal.gif' border='0' align='top' alt='Pay with PayPal'/>
        </form>
        
        <!-- Add Digital goods in-context experience. Ensure that this script is added before the closing of html body tag -->
        
        <script src='https://www.paypalobjects.com/js/external/dg.js' type='text/javascript'></script>
        
        <!--
        <a href="<?php echo $base_url; ?>achat/order/passCommande">
            <?php echo Asset::img('season13/btn_buynow_paypal.gif'); ?>
        </a>-->
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