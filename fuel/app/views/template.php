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
    
    $countries = array(
        "AU" => "Australia",
        "AF" => "Afghanistan",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua & Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia/Hercegovina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "IO" => "British Indian Ocean Territory",
        "BN" => "Brunei Darussalam",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CV" => "Cape Verde",
        "KY" => "Cayman Is",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China, People's Republic of",
        "CX" => "Christmas Island",
        "CC" => "Cocos Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo",
        "CD" => "Congo, Democratic Republic",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "CI" => "Cote d'Ivoire",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "TP" => "East Timor",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "FX" => "France, Metropolitan",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French South Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard Island And Mcdonald Island",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JT" => "Johnston Island",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KP" => "Korea, Democratic Peoples Republic",
        "KR" => "Korea, Republic of",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Lao People's Democratic Republic",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libyan Arab Jamahiriya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macau",
        "MK" => "Macedonia",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "MX" => "Mexico",
        "FM" => "Micronesia",
        "MD" => "Moldavia",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Union Of Myanmar",
        "NA" => "Namibia",
        "NR" => "Nauru Island",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "MP" => "Mariana Islands, Northern",
        "NO" => "Norway",
        "OM" => "Oman",
        "PK" => "Pakistan",
        "PW" => "Palau Islands",
        "PS" => "Palestine",
        "PA" => "Panama",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RE" => "Reunion Island",
        "RO" => "Romania",
        "RU" => "Russian Federation",
        "RW" => "Rwanda",
        "WS" => "Samoa",
        "SH" => "St Helena",
        "KN" => "St Kitts & Nevis",
        "LC" => "St Lucia",
        "PM" => "St Pierre & Miquelon",
        "VC" => "St Vincent",
        "SM" => "San Marino",
        "ST" => "Sao Tome & Principe",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia and South Sandwich",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "XX" => "Stateless Persons",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard and Jan Mayen",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syrian Arab Republic",
        "TW" => "Taiwan, Republic of China",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania",
        "TH" => "Thailand",
        "TL" => "Timor Leste",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad & Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks And Caicos Islands",
        "TV" => "Tuvalu",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "UM" => "US Minor Outlying Islands",
        "US" => "USA",
        "HV" => "Upper Volta",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VA" => "Vatican City State",
        "VE" => "Venezuela",
        "VN" => "Vietnam",
        "VG" => "Virgin Islands (British)",
        "VI" => "Virgin Islands (US)",
        "WF" => "Wallis And Futuna Islands",
        "EH" => "Western Sahara",
        "YE" => "Yemen Arab Rep.",
        "YD" => "Yemen Democratic",
        "YU" => "Yugoslavia",
        "ZR" => "Zaire",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe"
    );
    
    $sections = array("accueil", "episode", "other");
    
    $section = $sections[0];
    if(isset($_GET['s'])) $section = $_GET['s'];
    if( !in_array($section, $sections) )
        $section = "accueil";
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="Description" content="<?php if( isset($description) ) echo $description; else echo "Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web.";  ?>" />
	<title><?php echo $title; ?></title>
	<?php
	    echo Asset::css('BebasNeue.css');
	    echo Asset::css('DroidSans.css');
	    echo Asset::css('template.css');
	    echo Asset::css($css_supp);
	    echo Asset::js('lib/jquery-latest.js');
	    echo Asset::js('lib/jquery.scrollTo-1.4.2-min.js');
	    echo Asset::js('lib/jquery.parallax-1.1.3.js');
	    echo Asset::js('lib/jquery.form.js');
	    echo Asset::js('lib/fbapi.js');
	    echo Asset::js('config.js');
	    echo Asset::js('template.js');
	    echo Asset::js($js_supp);
	?>
	
	<?php if(!Auth::member(100) && !Auth::member(4)): ?>
	<script type="text/javascript">
	
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-35640835-1']);
	  _gaq.push(['_setDomainName', 'season13.com']);
	  _gaq.push(['_setAllowLinker', true]);
	  _gaq.push(['_trackPageview']);
	  
	  var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-36203496-1']);
      _gaq.push(['_setDomainName', 'season13.com']);
      _gaq.push(['_setAllowLinker', true]);
      _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>
	<?php endif; ?>
	
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
            channelUrl : 'http://season13.com/channelfile', // Path to your Channel File
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true  // parse XFBML
        });
    }

    </script>
    
    <script type="text/javascript">
        window.current_section = "<?php echo $section; ?>";
    </script>
    <?php 
        // output the javascript function
        echo Security::js_set_token(); 
    ?>

    <header>
        <div id="logo"></div>
        <a href="<?php echo $remote_path; ?>" id="logoLink" title="LOGO SEASON 13"></a>
        
        <ul id="menu">
            <li section="accueil"><a href="<?php echo $remote_path; ?>">ACCUEIL</a></li>
            <li class="text_sep_vertical"></li>
            <li section="episode"><a href="<?php echo $remote_path; ?>?s=episode">LES ÉPISODES</a></li>
            <li class="text_sep_vertical"></li>
            <li><a href="<?php echo $remote_path; ?>concept">LE CONCEPT</a></li>
            <li class="text_sep_vertical"></li>
            <li><a href="<?php echo $remote_path; ?>news">L'ACTU</a></li>
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
        <form method="post" action="<?php echo $remote_path; ?>base/signup_normal">
            <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
            <!--<div class="section">
                <h5>En t’inscrivant, tu recevras 2 fois par semaine, le mercredi et le samedi, un nouvel épisode de ta série Voodoo Connection !</h5>
            </div>-->
            <div class="section">
                <div class="sep_line"></div>
                <h1>AVEC TON COMPTE FACEBOOK</h1>
                <div class="fb_btn" title="Inscription via Facebook sur SEASON 13"></div>
            </div>
            <div class="section">
                <div class="sep_line"></div>
                <h1>AVEC UN COMPTE SEASON 13</h1>
                <!--<h5>Remplis ce petit formulaire et crée ton compte sur Season13. Tu pourras toujours lier ton compte à Facebook par la suite !</h5>-->
                <p>
                    <label>TU ES</label>
                    <select id="signupSex" name="sex">
                        <option value="f" selected>Une fille</option>
                        <option value="m">Un garçon</option>
                    </select>
                </p>
                <p><label>Ton Pseudo</label><input name="pseudo" type="text" size="18" maxlength="64" id="signupId"><cite>Au moins 6 caractères, sans espaces</cite></p>
                <p><label>Ton Mot de passe</label><input name="password" type="password" size="18" id="signupPass"><input name="password_repeat" type="password" size="18" id="signupConf"><cite>Tape 2 fois ton mot de passe pour être bien sûr !</cite></p>
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
                    <?php echo \Form::hidden('birthday', '', array('id' => 'signupBirthday')); ?>
                </p>
                <p><label>Ton Mail</label><input name="email" type="email" size="18" id="signupMail"></p>
                <p>
                    <label>Ton Pays</label>
                    <select name="pays" id="signupPays">
                        <option value="  " selected>Selectionnes ton pays</option>
                        <?php foreach ($countries as $key => $value): ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <cite>Facultatif</cite>
                </p>
                <p><label>Code Postal</label><input name="codpos" type="text" size="10"  maxlength="10" id="signupCP"><cite>Facultatif</cite></p>
                <?php
                /*
                <p><label>Ton Numéro Portable</label><input name="portable" type="text" size="18"  maxlength="20" id="signupPortable"><cite>Obligatoire si vous voulez la notification en sms</cite></p>
                <p>
                    <label>Choix Notification</label>
                    <select name="notif" id="signupNotif">
                        <option value="mail">Mail</option>
                        <option value="sms">SMS</option>
                    </select>
                    <cite>On te notifie quand il y a des nouveautés</cite>
                </p>
                */
                ?>
                <? //<p><label id="signupBtn"></label></p> ?>
                <input type="hidden" name="fbToken" id="signup_fbToken" value="empty" />
                <p><input type="submit" id="signupBtn" title="Inscription sur SEASON 13"/></p>
            </div>
        </form>
    </div>
    <div id="login_dialog" class="dialog">
        <div class="close"></div>
        <form method="post" action="base/login">
            <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
            <div class="section">
                <div class="sep_line"></div>
                <h1>AVEC TON COMPTE FACEBOOK</h1>
                <div class="fb_btn" title="Connexion via Facebook sur SEASON 13"></div>
            </div>
            <div class="section">
                <div class="sep_line"></div>
                <h1>AVEC TON COMPTE SEASON13</h1>
                <p><label>TON PSEUDO OU TON MAIL</label><input type="text" size="18" maxlength="64" id="loginId"></p>
                <p><label>TON MOT DE PASSE</label><input type="password" size="18" id="loginPass"></p>
                <p><input type="submit" id="loginBtn" title="Connexion sur SEASON 13"/></p>
            </div>
        </form>
    </div>
<?php else: ?>
    
    <div id="update_dialog" class="dialog">
        <div class="close"></div>
        <form method="post" action="<?php echo $remote_path; ?>base/update">
            <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
            <div class="section">
                <div class="sep_line"></div>
                <h1>MODIFIE TON COMPTE SEASON 13</h1>
                <p>
                    <label>TU ES</label>
                    <select name="sex" id="updateSex">
                        <option value="f" <?php if($current_user->sex=="f") echo "selected"; ?>>Une fille</option>
                        <option value="m" <?php if($current_user->sex=="m") echo "selected"; ?>>Un garçon</option>
                    </select>
                </p>
                <p>
                    <label>Ton Pseudo</label>
                    <span><?php echo $current_user->pseudo; ?></span>
                    <cite>Tu ne peux pas modifier ton pseudo</cite>
                </p>
                <p>
                    <label>Ton mot de passe</label>
                    <input name="newPass" type="password" size="18" id="updatePass">
                    <input type="password" size="18" id="updateConf">
                    <cite>Tape 2 fois ton mot de passe pour être bien sûr !</cite>
                </p>
                <p>
                    <?php 
                        $birth = date_timestamp_get(date_create_from_format('Y-m-d', $current_user->birthday));
                        $d = false;
                        $m = false;
                        $y = false;
                        if($birth) {
                            $d = intval(date('d', $birth));
                            $m = intval(date('m', $birth));
                            $y = intval(date('Y', $birth));
                        }
                    ?>
                    <label>Ta date de naissance</label>
                    <select id="updatebDay">
                        <?php foreach ($day as $i): ?>
                        <option value="<?php echo $i; ?>" <?php if($d == $i) echo "selected"; ?>><?php echo $i; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="updatebMonth">
                        <?php foreach ($month as $i=>$val): ?>
                        <option value="<?php echo $i+1; ?>" <?php if($m == $i+1) echo "selected"; ?>><?php echo $val; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="updatebYear">
                        <?php foreach ($year as $i): ?>
                        <option value="<?php echo $i; ?>" <?php if($y == $i) echo "selected"; ?>><?php echo $i; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo \Form::hidden('birthday', '', array('id' => 'updateBirthday')); ?>
                </p>
                <p>
                    <label>Ton Mail</label>
                    <span><?php echo $current_user->email; ?></span>
                    <cite>Tu ne peux pas modifier ton mail</cite>
                </p>
                <p>
                    <label>Ton Pays</label>
                    <select name="pays" id="updatePays">
                        <option value="  " selected>Selectionnes ton pays</option>
                        <?php foreach ($countries as $key => $value): ?>
                        <option value="<?php echo $key; ?>" <?php if($current_user->pays == $key) echo "selected"; ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <cite>Facultatif</cite>
                </p>
                <p>
                    <label>Code Postal</label>
                    <input name="codpos" type="text" size="10" maxlength="10" id="updateCP" value="<?php echo $current_user->code_postal; ?>">
                    <cite>Facultatif</cite>
                </p>
                <p>
                    <label>Ancien mot de passe</label>
                    <input type="password" size="18" name="oldPass" id="updateOldPass">
                    <cite>Tape ton ancien mot de passe pour pouvoir modifier !</cite>
                </p>
                <p><input type="submit" id="updateBtn" value="Mettre à jour" title="Update ton compte sur SEASON 13"/></p>
            </div>
        </form>
    </div>

<?php endif; ?>
    	    
<?php echo $content; ?>

	<footer>
	    <ul>
	        <li class="fb_btn">
                <div class="fb-like" data-href="<?php echo Uri::base(false).Uri::string(); ?>" data-send="false" data-layout="box_count" data-width="450" data-show-faces="false"></div>
	        </li>
	        <!--<li class="twitter_btn"></li>--></ul>
	    <div class="mask"></div>
		<p><a href="<?php echo $remote_path; ?>aboutus">Équipe</a> - <a href="<?php echo $remote_path; ?>thanksto">Remerciements</a> - <a href="<?php echo $remote_path; ?>contact">Contact</a> - <a href="<?php echo $remote_path; ?>mentionslegales">Mentions légales</a><!-- - <label>Conditions générales de vente</label>--></p>
	</footer>
</body>
</html>
