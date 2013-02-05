<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta charset="utf-8">
	<meta name="Description" content="<?php if( isset($description) ) echo $description; else echo "Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web: Voodoo Connection";  ?>" />
	
	<title><?php if(isset($title)) echo $title; ?></title>
	<?php
	    echo Asset::css('BebasNeue.css');
	    echo Asset::css('DroidSans.css');
	?>
	
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
    
<?php if(isset($content)) echo $content; ?>

</body>
</html>
