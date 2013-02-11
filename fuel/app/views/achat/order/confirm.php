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
    
    <h5>Un mail de confirmation avec la facture t'a été envoyé</h5>
    
    <div id="order-detail">
        <?php echo View::forge('achat/order/recaptulatif', array(
                                'total' => $total,
                                'ht' => $ht,
                                'tva' => $tva,
                                'tax' => $tax,
                                'products' => $products,
                                'currency' => $currency)
                              ); ?>
    </div>
    
    <br/>
    <?php if(isset($return_page)): ?>
        <a href="<?php echo $base_url."?s=episode"; ?>">Page d'accueil</a>
    <?php else: ?>
        <a href="javascript:window.close();">Ferme cette page</a>
    <?php endif; ?>
</body>

</html>