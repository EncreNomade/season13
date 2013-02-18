<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Confirmation de commande: <?php echo $ref; ?></title>
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
    	    
    	        <h5 style="position: relative; top: 0px; left: 0px; width: 440px; height: 40px; text-align: left; color: #444; padding: 0; margin: 0; font: bold 16px/30px Arial; ">
    	            <strong>Bonjour <?php echo $addr->firstname." ".$addr->lastname; ?>,</strong>
    	        </h5>
    	        
    	        <h5 style="position: relative; text-align: left; color: #202020; font: normal 16px/25px Arial, Helvetica; margin: 5px 0 10px 0;">
    	            <p>
    	                Nous avons bien enregistré le paiement de votre commande N° <?php echo $ref; ?> et nous vous en remercions.<br/>
    	                Lancez-vous dans l’aventure <a href="http://season13.com/?s=episode&utm_source=facture_mail&utm_medium=email">en cliquant ici</a>.
    	            </p>
    	            
    	            <p>
    	                Vous trouverez ci-dessous la facture correspondant à votre achat.
    	            </p>
    	            
    	            <p style="height: 60px; line-height: 50px;">
    	                <span style="position: relative; float: left; height: 50px; font-size-adjust: 50px; line-height: 50px;">A bientôt sur </span>
    	                <a style="position: relative; float: left; width: 50px; height: 50px;" href="http://season13.com/?utm_source=facture_mail&utm_medium=email">
    	                    <?php echo Asset::img('season13/logo_black.png', array('style'=>'width: 50px; height: 50px')); ?>
    	                </a>
    	            </p>
    	            
    	            <p>Vous désirez nous contacter : <a href="mailto:contact@encrenomade.com">contact@encrenomade.com</a></p>
    	            
    	            
    	            <table border="1" style="width: 100%; border-collapse: collapse; border-spacing: 0;">
    	                <thead>
    	                    <tr style="text-align: center;">
    	                        <th colspan="3" style="line-height: 35px;">
        	                        <strong>FACTURE N° <?php echo $ref; ?></strong>  Tourcoing, le <?php echo Date::forge($cmdtime)->format("%d/%m/%Y"); ?><br/>
    	                        </th>
    	                    </tr>
    	                    <tr style="text-align: center; font-weight: bold;">
    	                        <th style="color: white; text-shadow: 1px 1px 4px #333; height: 35px; text-transform: uppercase; background-color: rgb(146, 146, 146); border-top: 1px solid #000;">ISBN</th>
    	                        <th style="color: white; text-shadow: 1px 1px 4px #333; height: 35px; text-transform: uppercase; background-color: rgb(146, 146, 146); border-top: 1px solid #000;">Description</th>
    	                        <th style="color: white; text-shadow: 1px 1px 4px #333; height: 35px; text-transform: uppercase; background-color: rgb(146, 146, 146); border-top: 1px solid #000;">Montant</th>
    	                    </tr>
    	                </thead>
    	                <tbody>
    	                    <?php foreach ($products as $p): ?>
    	                    <tr style="text-align: center;">
    	                        <td style="padding: 5px; border-color: rgb(184, 184, 184);"><strong><?php echo $p->product->reference ;?></strong></td>
    	                        <td style="padding: 5px; border-color: rgb(184, 184, 184);">
    	                            <strong><?php echo $p->product_title ;?></strong>
	                            <?php if ($p->offer): ?>
	                                <br/>
	                                <i style="font-size: 12px;">Cadeau pour <?php echo $p->offer_target; ?></i>
	                            <?php endif; ?>
    	                        </td>
    	                        <td style="padding: 5px; border-color: rgb(184, 184, 184);"><?php echo number_format($p->getRealPrice(), 2, ',', '') . $currency->sign ;?></td>
    	                    </tr>
    	                    <?php endforeach; ?>
    	                </tbody>
    	                <tfoot>
    	                    <tr>
    	                        <td colspan="2" style="padding: 5px; border-color: rgb(184, 184, 184);"><strong>Montant total HT:</strong></td>
    	                        <td style="text-align: center; padding: 5px; border-color: rgb(184, 184, 184);"><?php echo number_format($ht, 2, ',', '') . $currency->sign; ?></td>
    	                    </tr>
    	                    <tr>
    	                        <td colspan="2" style="padding: 5px; border-color: rgb(184, 184, 184);"><strong>TVA 19,60%:</strong></td>
    	                        <td style="text-align: center; padding: 5px; border-color: rgb(184, 184, 184);"><?php echo number_format($tax, 2, ',', '') . $currency->sign; ?></td>
    	                    </tr>
    	                    <tr>
    	                        <td colspan="2" style="padding: 5px; border-color: rgb(184, 184, 184);"><strong>Montant total TTC:</strong></td>
    	                        <td style="text-align: center; padding: 5px; border-color: rgb(184, 184, 184);"><?php echo number_format($total, 2, ',', '') . $currency->sign; ?></td>
    	                    </tr>
    	                </tfoot>
    	                
    	            </table>
    	            
    	            
    	            <p>
    	                <?php echo $addr->firstname." ".$addr->lastname; ?><br/>
    	                <?php echo $addr->address; ?><br/>
    	                <?php echo $addr->postcode." ".$addr->city; ?><br/>
    	                Facture réglée le <?php echo Date::forge($cmdtime)->format("%d/%m/%Y"); ?>, à conserver.
    	            </p>
    	            
    	            <p>Consulter les conditions générales de vente, <a href="http://season13.com/cgv?utm_source=facture_mail&utm_medium=email">cliquez ici</a></p>
    	        </h5>
    	    </div>
    	    
    	    <div style="position: relative; margin: 0; float: left; left: 0px; width: 538px; height: auto; padding: 10px 30px; background: transparent; border: 1px solid #aaa;">
    	        <h5 class="outer_msg" style="position: relative; float: left; width: 100%; text-align: center; font: normal 12px/20px Arial, Helvetica; margin: 0; padding: 0; color: #777;">
    	            ENCRE NOMADE 99, boulevard Descat. 59200 TOURCOING<br/>
    	            Tel: 33 (0)3 20 24 79 56. E-mail : mseygnerole@encrenomade.com<br/>
    	            SAS au capital de 115 000€.R.C.S. ROUBAIX-TOURCOING 533 792 545.<br/>
    	            N° TVA intracommunautaire : FR88533792545<br/>
    	        </h5>
    	    </div>
    	</div>
    	
    	        </td>
    	    </tr>
    	</tbody>
    </table>
</body>