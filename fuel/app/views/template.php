<?php 
    $year = array();
    for ($i = 2012; $i >= 1930; $i--) {
        array_push($year, $i);
    }
    $month = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    $day = array();
    for ($i = 1; $i <= 31; $i++) {
        array_push($day, $i);
    }
    
    $sections = array("accueil", "episode", "concept", "other");
    
    $section = $sections[0];
    if(isset($_GET['s'])) $section = $_GET['s'];
    // else $section = $sections[3];
    if( !in_array($section, $sections) )
        $section = "accueil";
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php
	    echo Asset::css('BebasNeue.css');
	    echo Asset::css('template.css');
	    echo Asset::css($css_supp);
	    echo Asset::js('lib/jquery-latest.js');
	    echo Asset::js('lib/jquery.scrollTo-1.4.2-min.js');
	    echo Asset::js('lib/jquery.parallax-1.1.3.js');
	    echo Asset::js('template.js');
	    echo Asset::js($js_supp);
	?>
</head>
<body>
    <div id="fb-root"></div>
    <script>
    // Load the SDK Asynchronously
    (function(d){
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/fr_FR/all.js";
        ref.parentNode.insertBefore(js, ref);
    }(document));


    // Init the SDK upon load
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '141570392646490', // App ID
            channelUrl : 'http://testfb.encrenomade.com/channelfile', // Path to your Channel File
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true  // parse XFBML
        });
    }

    </script>
    <script type="text/javascript">
        window.current_section = "<?php echo $section; ?>";
    </script>

    <header>
        <div id="logo"></div>
        <a href="/" id="logoLink"></a>
        
        <ul id="menu">
            <li section="accueil"><a href="/">ACCUEIL</a></li>
            <li class="text_sep_vertical"></li>
            <li section="episode"><a href="/?s=episode">LES ÉPISODES</a></li>
            <li class="text_sep_vertical"></li>
            <li section="concept"><a href="/?s=concept">LE CONCEPT</a></li>
            <li class="text_sep_vertical"></li>
            <li><a href="/season13/public/actu">L'ACTU</a></li>
        </ul>
    </header>
    
    <ul id="conn">
<?php if($current_user == null): ?>
        <li id="open_signup">S'INSCRIRE</li>
        <li class="text_sep_vertical"></li>
        <li id="open_login">SE CONNECTER</li>
<?php else: ?>
    <?php if(Auth::member(100)): ?>
        <li><a href="admin/">ADMIN</a></li>
    <?php endif; ?>
        <li id="user_id">BIENVENUE: <?php echo $current_user->pseudo ?></li>
        <li class="text_sep_vertical"></li>
        <li id="logout">LOGOUT</li>
<?php endif; ?>
    </ul>
    
<?php if($current_user == null): ?>
    <div id="signup_dialog" class="dialog">
        <div class="close"></div>
        <form method="post" action="base/signup">
            <div class="section">
                <h5>En t’inscrivant, tu recevras 2 fois par semaine, le mercredi et le samedi, un nouvel épisode de ta série Voodoo Connection !</h5>
            </div>
            <div class="section">
                <div class="sep_line"></div>
                <h1>AVEC TON COMPTE FACEBOOK</h1>
                <div class="fb_btn"></div>
                <?php
                //<h5 class="fb_help">Clique sur le bouton Facebook et accepte la demande de connexion. Ton compte sera directement relié à Season13. Dès que tu seras lié ton compte, tu pourras te connecter ici en 1 clic !</h5>
                ?>
            </div>
            <div class="section">
                <div class="sep_line"></div>
                <h1>AVEC UN COMPTE SEASON13</h1>
                <h5>Remplis ce petit formulaire et crée ton compte sur Season13. Tu pourras toujours lier ton compte à Facebook par la suite !</h5>
                <p>
                    <label>TU ES</label>
                    <select id="signupSex">
                        <option value="m">Un Garçon</option>
                        <option value="f">Une fille</option>
                    </select>
                </p>
                <p><label>Ton Pseudo</label><input type="text" size="18" maxlength="64" id="signupId"><cite>Au moins 6 caractères, sans espaces</cite></p>
                <p><label>Ton Mot de passe</label><input type="password" size="18" id="signupPass"><input type="password" size="18" id="signupConf"><cite>Tape 2 fois ton mot de passe pour être bien sûr !</cite></p>
                <p>
                    <label>Ta Date de naissance</label>
                    <select id="signupbDay">
<?php foreach ($day as $i): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php endforeach; ?>
                    </select>
                    <select id="signupbMonth">
<?php foreach ($month as $i=>$val): ?>
                        <option value="<?php echo $i+1; ?>"><?php echo $val; ?></option>
<?php endforeach; ?>
                    </select>
                    <select id="signupbYear">
<?php foreach ($year as $i): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php endforeach; ?>
                    </select>
                </p>
                <p><label>Ton Mail</label><input type="email" size="18" id="signupMail"></p>
                <p><label>Ton Code Postal</label><input type="text" size="18"  maxlength="5" id="signupCP"><cite>Optionnel</cite></p>
                <?php
                /*
                <p><label>Ton Numéro Portable</label><input type="text" size="18"  maxlength="20" id="signupPortable"><cite>Obligatoire si vous voulez la notification en sms</cite></p>
                <p>
                    <label>Choix Notification</label>
                    <select id="signupNotif">
                        <option value="mail">Mail</option>
                        <option value="sms">SMS</option>
                    </select>
                    <cite>On te notifie quand il y a des nouveautés</cite>
                </p>
                */
                ?>
                <? //<p><label id="signupBtn"></label></p> ?>
                <input type="hidden" id="signup_fbToken" value="empty" />
                <p><input type="submit" id="signupBtn" /></p>
            </div>
        </form>
    </div>
    <div id="login_dialog" class="dialog">
        <div class="close"></div>
        <form method="post" action="base/login">
            <div class="section">
                <div class="sep_line"></div>
                <h1>AVEC TON COMPTE FACEBOOK</h1>
                <div class="fb_btn"></div>
                <h5 class="fb_help">Ton compte est lié à ton compte Facebook. si tu es déjà connecté à Facebook dans une autre fenêtre, clique sur l’icone et tu es connecté !</h5>
            </div>
            <div class="section">
                <div class="sep_line"></div>
                <h1>AVEC TON COMPTE SEASON13</h1>
                <p><label>TON PSEUDO OU TON MAIL</label><input type="text" size="18" maxlength="64" id="loginId"></p>
                <p><label>TON MOT DE PASSE</label><input type="password" size="18" id="loginPass"></p>
                <p><input type="submit" id="loginBtn"/></p>
            </div>
        </form>
    </div>
<?php endif; ?>
    	    
<?php echo $content; ?>

	<footer>
	    <ul><li class="fb_btn"></li><li class="twitter_btn"></li></ul>
	    <div class="mask"></div>
		<p><label>Contacts</label> - <label>Mentions légales</label> - <label>Conditions générales de vente</label></p>
	</footer>
</body>
</html>
