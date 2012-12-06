<form method="post" action="<?php echo $remote_path; ?>base/reset_pass">
    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
    <div class="section">
        <div class="sep_line">
            <h1>Demander un nouveau mot de passe</h1>
        </div>
        <p></p>
        <p><label>TON MAIL D'INSCRIPTION</label><input type="text" size="18" maxlength="64" name="email" id="chpass_mail"><cite></cite></p>
        <h5>Tu vas recevoir un mail avec ton nouveau mot de passe.</h5>
        <p></p>
        <p><input type="submit" id="chPassBtn"></p>
    </div>
</form>