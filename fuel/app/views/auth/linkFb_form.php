<form method="post" action="<?php echo $remote_path; ?>base/link_fb">
    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
    <?php echo Form::hidden('fb_token', Input::post('fb_token', ''), array('id' => 'linkfbToken')); ?>
    <div class="section">
        <h5>
            Ton compte Facebook n'est pas encore associé à un compte Season 13.<br/>
            Si tu n'as pas encore créé de compte Season 13, clique sur "CRÉER UN COMPTE".<br/>
            Si tu as déjà un compte Season 13. Tu peux te connecter pour l'associer avec ton compte Facebook:<br/>
            <br/>
        </h5>
    </div>
    <div class="section">
        <p><label>TON PSEUDO OU TON MAIL</label><input type="text" size="18" maxlength="64" id="linkfbId" name="identifiant"></p>
        <p><label>TON MOT DE PASSE</label><input type="password" size="18" id="linkfbPass" name="password"><span><a href="javascript:showChPass();">Mot de passe oublié ?</a></span></p>
        <p><input type="submit" id="linkfbBtn" title="Associer ton compte Facebook avec SEASON 13"/></p>
    </div>
</form>