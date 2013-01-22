

<?php if(isset($user_address)): ?>

    <h2>Adresse</h2>

    <div class="addr_info">
        <p>
        	<strong>Prénom</strong>
        	<?php echo $user_address->firstname; ?>
        </p>
        <p>
            <strong>Nom</strong>
            <?php echo $user_address->lastname; ?>
        </p>
        <p>
            <strong>E-mail</strong>
            <?php echo $user_address->email; ?>
        </p>
        <p>
        	<strong>Adresse</strong>
        	<?php echo $user_address->address; ?>
        </p>
        <p>
        	<strong>Code postal</strong>
        	<?php echo $user_address->postcode; ?>
        </p>
        <p>
        	<strong>Ville</strong>
        	<?php echo $user_address->city; ?>
        </p>
        <p>
        	<strong>Pays</strong>
        	<?php echo Config::get("currencies." .$user_address->country_code. ".name"); ?>
        </p>
        <p>
        	<strong>Téléphone</strong>
        	<?php echo $user_address->tel; ?>
        </p>
        <div class="actions">
            <button id="askModifyAddress" data-addr_id="<?php echo $user_address->id ?>">Modifier</button>
        </div>
    </div>

<?php else: ?>

    <?php echo render('user/address/create'); ?>
    
<?php endif; ?>