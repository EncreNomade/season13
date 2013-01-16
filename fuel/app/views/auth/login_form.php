<form id="loginForm" method="post" action="<?php echo $remote_path; ?>base/login">
    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
    <div class="section">
        <div class="sep_line">
            <h1>AVEC TON COMPTE FACEBOOK</h1>
        </div>
        <div class="fb_btn" title="Connexion via Facebook sur SEASON 13"></div>
    </div>
    <div class="section">
        <div class="sep_line">
            <h1>AVEC TON COMPTE SEASON13</h1>
        </div>
        <p><label>TON PSEUDO OU TON MAIL</label><input type="text" size="18" maxlength="64" id="loginId" name="identifiant"></p>
        <p><label>TON MOT DE PASSE</label><input type="password" size="18" id="loginPass" name="password"><span><a href="javascript:showChPass();">Mot de passe oublié ?</a></span></p>
        <p><input type="submit" id="loginBtn" title="Connexion sur SEASON 13"/></p>
    </div>
</form>