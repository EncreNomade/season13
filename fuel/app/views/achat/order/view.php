<div class="main_container">

<?php if($current_user): ?>
    
    <div id="order-detail">
        <table border="1" class="products">
            <th>
            	<td>Titre</td>
            	<td>Prix</td>
            	<td>Action</td>
            </th>
            
    	    <?php foreach ($products as $p): ?>
    		<tr>
        		<td><strong><?php echo $p->product_title ;?></strong></td>
        		<td><?php echo $p->taxed_price . $currency->sign ;?></td>
        		<td><button class="remove_product" data-pid="<?php echo $p->product_id ;?>">Supprimer</button></td>
    		</tr>
    	    <?php endforeach; ?>
    	</table>
    </div>
    
    <div id="order-adresse">
        <?php View::forge('user/adresse/view', $user_adresse); ?>
    </div>
    
<?php else: ?>
    
    <div id="order-login">
        <?php echo View::forge('auth/login_form')->render(); ?>
    </div>
    
<?php endif; ?>
    
    <div id="order-payment">
    </div>
    
</div>