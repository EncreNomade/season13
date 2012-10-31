<style>
    .main_container {
        background: #fff;
    }
	.main_container div {
		text-align: center;
		background: #fff;
	}
</style>

<div class="main_container">
    <div>
    	<p>Votre navigateur internet ne vous permet pas de lire le feuilleton.</p>
    <?php if($maj): ?>
    	<p>Vous pouvez le mettre à jour très facilement : </p>
    		<p><a href=
    		<?php 
    		if($browser == "IE")
    		    print("'http://www.microsoft.com/france/windows/internet-explorer/telecharger-ie9.aspx'");
    		else if($browser == "Firefox")
    		    print("'http://www.mozilla.org/fr/firefox/new/'");
    		 ?>
    		>MAJ</a></p>
    </div>
    <div>
        <p>Si vous voulez profiter de toutes les animations du feuilleton, nous vous conseillons d'installer :</p>
    <?php else: ?>
    	<p>Pour profiter de l'experience, nous vous conseillons d'installer :</p>
    <?php endif; ?>
    	<p>
    		<a href="https://www.google.com/chrome?hl=fr"><img src="assets/img/season13/chrome.png" height="60" width="60" alt="Chrome"/>Chrome</a>
    		<a href="http://www.apple.com/fr/safari/"><img src="assets/img/season13/safari.png" height="60" width="60" alt="Safari"/>Safari</a>
    	</p>
    </div>
</div>