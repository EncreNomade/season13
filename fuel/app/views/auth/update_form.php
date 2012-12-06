<form method="post" action="<?php echo $remote_path; ?>base/update">
    <?php echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
    <div class="section">
        <div class="sep_line">
            <h1>MODIFIE TON COMPTE SEASON 13</h1>
        </div>
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
            <label>Nouveau mot de passe</label>
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
                <?php foreach (Controller_Base::$day as $i): ?>
                <option value="<?php echo $i; ?>" <?php if($d == $i) echo "selected"; ?>><?php echo $i; ?></option>
                <?php endforeach; ?>
            </select>
            <select id="updatebMonth">
                <?php foreach (Controller_Base::$month as $i=>$val): ?>
                <option value="<?php echo $i+1; ?>" <?php if($m == $i+1) echo "selected"; ?>><?php echo $val; ?></option>
                <?php endforeach; ?>
            </select>
            <select id="updatebYear">
                <?php foreach (Controller_Base::$year as $i): ?>
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
                <?php foreach (Controller_Base::$countries as $key => $value): ?>
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