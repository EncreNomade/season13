<div class="main_container">
    <div id="order_container">
        <h1>Récapitulatif de la commande</h1>
        
        <div id="order-detail">
            <table border="1" class="products">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><strong><?php echo $p->product_title ;?></strong></td>
                        <td><?php echo $p->taxed_price . $currency->sign ;?></td>
                        <td><button class="remove_product"  data-productref="<?php echo $p->product->reference ;?>">Supprimer</button></td>
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

<?php if($current_user): ?>

    <div id="order-adresse">
        <?php echo View::forge('user/address/view')->render(); ?>
    </div>
    
    <div id="order-agreement">
        <h5>
            <label><input type="checkbox"/>J'ai lu les conditions générales de vente et j'y adhère sans réserve. (Lire les Conditions générales de vente)</label>
        </h5>
    </div>
    
    <div id="order-payment">
    
        <!-- INFO: The post URL "checkout.php" is invoked when clicked on "Pay with PayPal" button.-->
        
        <form action='<?php echo $base_url; ?>achat/order/paypalCheckout' METHOD='POST'>
        	<input type='image' name='paypal_submit' id='paypal_submit'  src='https://www.paypal.com/en_US/i/btn/btn_dg_pay_w_paypal.gif' border='0' align='top' alt='Pay with PayPal'/>
        </form>
        
        <!-- Add Digital goods in-context experience. Ensure that this script is added before the closing of html body tag -->
        
        <script src='https://www.paypalobjects.com/js/external/dg.js' type='text/javascript'></script>
        
        <script>
        
        	var dg = new PAYPAL.apps.DGFlow(
        	{
        		trigger: 'paypal_submit',
        		expType: 'instant'
        		//PayPal will decide the experience type for the buyer based on his/her 'Remember me on your computer' option.
        	});
        
        </script>
        
        <!--
        <a href="<?php echo $base_url; ?>achat/order/passCommande">
            <?php echo Asset::img('season13/btn_buynow_paypal.gif'); ?>
        </a>-->
    </div>
    
<?php else: ?>
    
    <div id="order-login">
        <h5>Tu dois <a href="javascript:showLogin()">te connecter</a> ou <a href="javascript:showSignup()">t'inscrire</a> d'abord avec les bouttons en haut à droite de la page.</h5>
        <script type="text/javascript">
            $(document).ready(showLogin);
        </script>
    </div>
    
<?php endif; ?>

    <br/>
    <br/>
    <br/>
    
</div>