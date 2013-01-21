<?php 
	$flash = Session::get_flash('error');
	Session::delete_flash('error');
?>

<html>

<head>
    <meta charset="utf-8">

    <title>Paiement échoué - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5</title>
    
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
</head>

<body>
    <h1>Paiement échoué</h1>
    <h5>Le paiement a été refusé, recommandez si tu veux</h5>
    
    <?php if($flash): ?>
    	<div class="flash-alert">
    		<?php echo $flash; ?>
    	</div>
    <?php endif; ?>
    
    <br/>
    <a href="javascript:window.close();">Ferme cette page</a>
</body>

</html>