<?php 
    // Variable required by auth view
    $remote_path = Config::get('custom.remote_path');
    $base_url = Config::get('custom.base_url');
    $isiPad = Config::get('custom.isiPad');
?>

<div class="section">
    <div class="sep_line">
        <h1>AVEC TON COMPTE FACEBOOK</h1>
    </div>
    <div class="fb_btn form_fb_btn" title="Inscription via Facebook sur SEASON 13"></div>
</div>

<form id="epSignupForm" method="post" action="<?php echo $remote_path; ?>base/signup_normal">
    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
    <div class="section">
        <div class="sep_line">
            <h1>AVEC UN COMPTE SEASON 13</h1>
        </div>
        <!--<p>
            <label>TU ES</label>
            <select id="signupSex" name="sex">
                <option value="f" selected>Une fille</option>
                <option value="m">Un garçon</option>
            </select>
        </p>
        -->
        <p><label>Ton Mail</label><input name="email" type="email" size="18" id="signupMail"></p>
        
        <p><label>Ton Pseudo</label><input name="pseudo" type="text" size="18" maxlength="64" id="signupId"><cite>Au moins 6 caractères, sans espaces</cite></p>
        
        <p>
            <label>Ton Mot de passe</label>
            <input name="password" type="password" size="18" id="signupPass">
    <?php if(Agent::is_mobiledevice() && !$isiPad): ?>
        </p>
        <p>
            <label>Confirme mot de passe</label>
    <?php endif; ?>
            <input name="password_repeat" type="password" size="18" id="signupConf">
            <cite>Au moins 6 caractères, tape 2 fois ton mot de passe pour être bien sûr !</cite>
        </p>
        
        <!--
        <p>
            <label>Ta Date de naissance</label>
            <select id="signupbDay">
                <?php foreach (Controller_Base::$day as $i): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endforeach; ?>
            </select>
            <select id="signupbMonth">
                <?php foreach (Controller_Base::$month as $i=>$val): ?>
                <option value="<?php echo $i+1; ?>"><?php echo $val; ?></option>
                <?php endforeach; ?>
            </select>
            <select id="signupbYear">
                <?php foreach (Controller_Base::$year as $i): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endforeach; ?>
            </select>
        </p>-->
        
        <!--
        <p><label>Ton N° Portable</label><input name="portable" type="text" size="18"  maxlength="20" id="signupPortable"></p>
        
        <p>
            <label>Notification</label>
            <span>Tenez-moi au courant des news par</span><br/>
            <input id="notif_mail" type="checkbox"/> <span>Email</span>
            <input id="notif_sms" type="checkbox"/> <span>SMS</span>
        </p>
        
        <p>
            <label>Ton Pays</label>
            <select name="pays" id="signupPays">
                <option value="  " selected>Selectionnes ton pays</option>
            </select>
            <cite>Facultatif</cite>
        </p>
        
        <p><label>Code Postal</label><input name="codpos" type="text" size="10"  maxlength="10" id="signupCP"><cite>Facultatif</cite></p>-->
        
        <input type="hidden" name="sex" id="signupSex" value="f">
        <input type="hidden" id="signupbDay" value="1">
        <input type="hidden" id="signupbMonth" value="2">
        <input type="hidden" id="signupbYear" value="1930">
        <input type="hidden" name="birthday" id="signupBirthday" value="1/1/1930">
        <input type="hidden" name="portable" id="signupPortable" value="">
        <input type="hidden" name="pays" id="signupPays" value="">
        <input type="hidden" name="codpos" id="signupCP" value="">
        <input type="hidden" name="notif" value="mail" />
        
        <?php //<p><label id="signupBtn"></label></p> ?>
        <input type="hidden" name="fbToken" id="signup_fbToken" value="empty" />
        <p><input type="submit" id="signupBtn" title="Inscription sur SEASON 13"/></p>
    </div>
</form>

<form id="epLoginForm" method="post" action="<?php echo $remote_path; ?>base/login">
    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
    <div class="section">
        <div class="sep_line">
            <h1>Déjà Client</h1>
        </div>
        <p><label>TON PSEUDO OU TON MAIL</label><input type="text" size="18" maxlength="64" id="loginId" name="identifiant"></p>
        <p>
            <label>TON MOT DE PASSE</label>
            <input type="password" size="18" id="loginPass" name="password">
            <cite>
                <a href="<?php if(Agent::is_mobiledevice() && !$isiPad) echo $base_url."?chpass=true"; else echo "javascript:showChPass();"; ?>">Mot de passe oublié ?</a>
            </cite>
        </p>
        <p><input type="submit" id="loginBtn" title="Connexion sur SEASON 13"/></p>
    </div>
</form>