

<?php if(isset($user_address)): ?>

    <h2>Adresse de facturation</h2>

    <div class="addr_info">
        <p>
        	<label>Prénom</label>
        	<?php echo $user_address->firstname; ?>
        </p>
        <p>
            <label>Nom</label>
            <?php echo $user_address->lastname; ?>
        </p>
        <p>
            <label>E-mail</label>
            <?php echo $user_address->email; ?>
        </p>
        <p>
        	<label>Adresse</label>
        	<?php echo $user_address->address; ?>
        </p>
        <p>
        	<label>Code postal</label>
        	<?php echo $user_address->postcode; ?>
        </p>
        <p>
        	<label>Ville</label>
        	<?php echo $user_address->city; ?>
        </p>
        <p>
        	<label>Pays</label>
        	<?php echo Config::get("currencies." .$user_address->country_code. ".name"); ?>
        </p>
        <p>
        	<label>Téléphone</label>
        	<?php echo $user_address->tel; ?>
        </p>
        <div class="actions">
            <button id="askModifyAddress" data-addr_id="<?php echo $user_address->id ?>">Modifier</button>
        </div>
    </div>

<?php else: ?>

    <?php echo render('user/address/create'); ?>
    
<?php endif; ?>