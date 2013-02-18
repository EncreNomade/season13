<form id="signupForm" method="post" action="<?php echo $remote_path; ?>base/signup_normal">
    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
    <!--<div class="section">
        <h5>En t’inscrivant, tu recevras 2 fois par semaine, le mercredi et le samedi, un nouvel épisode de ta série Voodoo Connection !</h5>
    </div>-->
    <div class="section">
        <div class="sep_line">
            <h1>AVEC TON COMPTE FACEBOOK</h1>
        </div>
        <div class="fb_btn" title="Inscription via Facebook sur SEASON 13"></div>
    </div>
    <div class="section">
        <div class="sep_line">
            <h1>AVEC UN COMPTE SEASON 13</h1>
        </div>
        <!--<h5>Remplis ce petit formulaire et crée ton compte sur Season13. Tu pourras toujours lier ton compte à Facebook par la suite !</h5>-->
        <p>
            <label>TU ES</label>
            <select id="signupSex" name="sex">
                <option value="f" selected>Une fille</option>
                <option value="m">Un garçon</option>
            </select>
        </p>
        
        <p><label>Ton Pseudo</label><input name="pseudo" type="text" size="18" maxlength="64" id="signupId"><cite>Au moins 6 caractères, sans espaces</cite></p>
        
        <p><label>Ton Mot de passe</label><input name="password" type="password" size="18" id="signupPass"><input name="password_repeat" type="password" size="18" id="signupConf"><cite>Au moins 6 caractères, tape 2 fois ton mot de passe pour être bien sûr !</cite></p>
        
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
            <?php echo \Form::hidden('birthday', '', array('id' => 'signupBirthday')); ?>
        </p>
        
        <p><label>Ton Mail</label><input name="email" type="email" size="18" id="signupMail"></p>
        
        <p><label>Ton N° Portable</label><input name="portable" type="text" size="18"  maxlength="20" id="signupPortable"><!--<cite>Obligatoire si vous voulez la notification en sms</cite>--></p>
        
        <input type="hidden" name="notif" value="mail" />
        <!--
        <p>
            <label>Choix Notification</label>
            <select name="notif" id="signupNotif">
                <option value="mail">Mail</option>
                <option value="sms">SMS</option>
            </select>
            <cite>On te notifie quand il y a des nouveautés de ton choix</cite>
        </p>-->
        
        <p>
            <label>Ton Pays</label>
            <select name="pays" id="signupPays">
                <option value="  " selected>Selectionnes ton pays</option>
            </select>
            <cite>Facultatif</cite>
        </p>
        
        <p><label>Code Postal</label><input name="codpos" type="text" size="10"  maxlength="10" id="signupCP"><cite>Facultatif</cite></p>
        
        <?php //<p><label id="signupBtn"></label></p> ?>
        <input type="hidden" name="fbToken" id="signup_fbToken" value="empty" />
        <p><input type="submit" id="signupBtn" title="Inscription sur SEASON 13"/></p>
    </div>
</form>