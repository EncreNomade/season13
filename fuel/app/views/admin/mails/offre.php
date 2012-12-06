<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $subject; ?></title>
    <?php echo Asset::css('newsletter.css'); ?>
</head>

<body style="width: 100%;height: 100%;background-color: #ccc; margin: 0; padding: 0;">
    
    <table style="width: 100%;height: 100%;" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" >
        <tbody>
        
            <tr>
                <td align="center" valign="top">
    	<div style="position: relative; margin: 0; top: 50px; width: 600px; height: auto;">
    	    
    	    <div style="position: relative; float: left; width: 600px; height: 100px; border-bottom: 6px solid rgb(246, 168, 0);">
    	        <?php echo Asset::img('season13/mail/simple_head.jpg', array('style'=>'position: absolute; left: 0px; top: 0px; width: 600px; height: 100px;')); ?>
    	    </div>
    	    
    	    <div style="position: relative; float: left; left: 0px; width: 438px; height: auto; padding: 20px 80px; background: #fff; border-left: 1px solid #aaa; border-right: 1px solid #aaa;">
    	    
    	        <h1 style="position: relative; top: 0px; left: 0px; width: 440px; height: 60px; text-align: center; font: bold 40px/60px Arial; color: #000; padding: 0; margin: 0;"><?php echo $subject; ?></h1>
    	        <h5 style="position: relative; top: 0px; left: 0px; width: 440px; height: 40px; text-align: center; color: #444; padding: 0; margin: 0; font: bold 16px/30px Arial; ">
    	            <strong>Pour te remercier de ton aide</strong>
    	        </h5>
    	        
    	        <h5 style="position: relative; text-align: left; color: #202020; font: normal 16px/25px Arial, Helvetica; margin: 5px 0 10px 0;">
    	            <?php //echo html_entity_decode($content); ?>
    	            Tu vas pouvoir découvrir gratuitement les 6 épisodes de la saison 1 de Voodoo Connection.<br/>
    	            Dès que la saison 2 sera disponible, nous t'offrirons aussi les 6 épisodes !<br/>
    	        </h5>
    	        
    	        <h5 style="position: relative; text-align: center; color: #202020; font: normal 16px/25px Arial, Helvetica; margin: 5px 0 10px 0;">
    	            Pour découvrir l'aventure de Simon, connecte-toi ou inscris-toi sur <a href="http://season13.com/">season13.com</a> et
    	        </h5>
    	        
    	        <a style="position: relative; float: left; left: 0px; width: 220px; height: 50px; margin: 10px 110px 20px 110px; background: rgb(246, 168, 0); border-radius: 10px; text-decoration: none; color: #fff; font: bold 18px/50px sans-serif; text-align: center;" href="<?php echo $codelink; ?>">
    	            ACTIVE TON CADEAU
    	        </a>
    	        
    	        <h5 style="position: relative; text-align: left; color: #a9a9a9; font: normal 16px/25px Arial, Helvetica; margin: 5px 0 10px 0;">
    	            Code cadeau: <?php echo $code; ?><br/>
    	        </h5>
    	    </div>
    	    
    	    <div style="position: relative; margin: 0; float: left; left: 0px; width: 538px; height: auto; padding: 10px 30px; background: transparent; border-left: 1px solid #aaa; border-right: 1px solid #aaa; border-bottom: 1px solid #aaa;">
    	        <h5 class="outer_msg" style="position: relative; float: left; width: 440px; text-align: left; font: normal 12px/20px Arial, Helvetica; margin: 0; padding: 0;">
    	            L’équipe de <a href="http://season13.com">Season13</a><br/>
    	            Téléphone: 03 20 24 79 56<br/>
    	            Mail: <a href="mailto:contact@encrenomade.com">contact@encrenomade.com</a><br/>
    	            Adresse: 99A bld Descat 59200 Tourcoing<br/>
    	        </h5>
    	        
    	        <div style="position: relative; float: right; right: 0px; top: 20px; width: 40px; height: 40px;">
    	            <?php echo Asset::img('season13/fb_btn.jpg', array('style'=>'position: absolute; left: 0px; top: 0px; width: 100%; height: 100%;')); ?>
    	            <a href="http://www.facebook.com/season13officiel" style="position: absolute; left: 0px; top: 0px; width: 100%; height: 100%; background: transparent url('http://season13.com/assets/img/season13/fb_btn.jpg') no-repeat left top;"></a>
    	        </div>
    	    </div>
    	</div>
    	
    	        </td>
    	    </tr>
    	</tbody>
    </table>
</body>