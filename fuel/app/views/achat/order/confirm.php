<html>

<head>
    <meta charset="utf-8">
    
    <title>Commande confirmée - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5</title>
    
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
    
    <?php echo Asset::css('order.css'); ?>
</head>

<body>
    <h1>Commande confirmée</h1>
    
    <h5>un mail de confirmation t'a été envoyé</h5>
    
    <div id="order-detail">
        <table border="1" class="products">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Description</th>
                    <th>Prix</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><strong><?php echo $p->product->reference ;?></strong></td>
                    <td><strong><?php echo $p->product_title ;?></strong></td>
                    <td><?php echo $p->getRealPrice() . $currency->sign ;?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>TVA:</strong></td>
                    <td><?php echo $tva; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Montant total TVA:</strong></td>
                    <td><?php echo $tax . $currency->sign; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Montant total TTC:</strong></td>
                    <td><?php echo $total . $currency->sign; ?></td>
                </tr>
            </tfoot>
    	</table>
    </div>
    
    <br/>
    <?php if(isset($return_page)): ?>
        <a href="<?php echo $base_url."?s=episode"; ?>">Page d'accueil</a>
    <?php else: ?>
        <a href="javascript:window.close();">Ferme cette page</a>
    <?php endif; ?>
</body>

</html>