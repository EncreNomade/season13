<div class="main_container">

    <br/>
    <br/>
    
    <div id="order-detail">
        <table border="1" class="products">
            <tr>
            	<th>Titre</th>
            	<th>Prix</th>
            	<th>Action</th>
            </tr>
            
    	    <?php foreach ($products as $p): ?>
    		<tr>
        		<td><strong><?php echo $p->product_title ;?></strong></td>
        		<td><?php echo $p->taxed_price . $currency->sign ;?></td>
        		<td><button class="remove_product" data-pid="<?php echo $p->product_id ;?>">Supprimer</button></td>
    		</tr>
    	    <?php endforeach; ?>
    	    
    	    <tr>
    	    	<td><strong>Total HT:</strong></td>
    	    	<td><?php echo $ht . $currency->sign; ?></td>
    	    </tr>
    	    <tr>
    	    	<td><strong>Total taxes:</strong></td>
    	    	<td><?php echo $tax . $currency->sign; ?></td>
    	    </tr>
    	    <tr>
    	    	<td><strong>Total produits TTC:</strong></td>
    	    	<td><?php echo $total . $currency->sign; ?></td>
    	    </tr>
    	</table>
    </div>

<?php if($current_user): ?>

    <div id="order-adresse">
        <?php echo View::forge('user/address/view')->render(); ?>
    </div>
    
    <div id="order-agreement">
        <h5>
            <input type="checkbox"/>J'ai lu les conditions générales de vente et j'y adhère sans réserve. (Lire les Conditions générales de vente)
        </h5>
    </div>
    
    <div id="order-payment">
    </div>
    
<?php else: ?>
    
    <div id="order-login">
        <h5>Tu dois te connecter ou t'inscrire d'abord avec les bouttons en haut à droite de la page.</h5>
        <script type="text/javascript">
            $(document).ready(showLogin);
        </script>
    </div>
    
<?php endif; ?>
    <br/>
    <br/>
    <br/>
    
</div>