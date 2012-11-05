<style>
	.main_container > div {
		font: normal 14px/25px 'DroidSansRegular', Arial, Helvetica;
		margin: 30px 100px 30px 100px;
	}
	.main_container h1 {
	    font: normal 30px/45px 'DroidSansBold';
	}
	.main_container strong {
	    font: normal 20px/32px 'DroidSansBold';
	}
	.main_container h5.gris {
	    color: #686868;
	}
	
	.main_container ul {
	    width: 480px;
	    margin: 20px auto 10px auto;
	}
	.main_container ul li {
	    float: left;
	    width: 120px;
	    height: 120px;
	    margin: 20px 20px 10px 20px;
	}
	.main_container ul li a {
	    width: 100%;
	    height: 100%;
	}
	.main_container ul li img {
	    position: relative;
	    width: 120px;
	    height: auto;
	}
</style>

<div class="main_container">
<div>
    <h1>Remerciements</h1>
    
    <h5>Ils nous ont aidé et nous aident toujours:</h5>
    
    <ul>
        <li><a href="http://cre-innov.univ-lille1.fr" target="_blank"><?php echo Asset::img('season13/thanks/creinnov.jpeg', array('alt' => 'Season 13 merci à Cré\'Innov')); ?></a></li>
        <li><a href="http://www.furet.com" target="_blank"><?php echo Asset::img('season13/thanks/furet2.jpg', array('alt' => 'Season 13  merci au Furet du nord', 'style' => 'left:20px;top:12px;width:80px;height:95px;')); ?></a></li>
        <li><a href="http://www.lmi-innovation-creation.fr" target="_blank"><?php echo Asset::img('season13/thanks/lmi.jpeg', array('alt' => 'Season 13  merci à LMI', 'style' => 'left:13px;top:22px;width:95px;height:76px;')); ?></a></li>
        <li><a href="http://www.miti.fr" target="_blank"><?php echo Asset::img('season13/thanks/miti.jpeg', array('alt' => 'Season 13  merci à MITI')); ?></a></li>
        <li><a href="http://www.oseo.fr" target="_blank"><?php echo Asset::img('season13/thanks/oseo.jpeg', array('alt' => 'Season 13  merci à Oséo')); ?></a></li>
        <li><a href="http://www.plaine-images.fr/fr_FR/accueil.html#/accueil/" target="_blank"><?php echo Asset::img('season13/thanks/plaineimages.jpeg', array('alt' => 'Season 13  merci à la Plaine Images')); ?></a></li>
        <li><a href="http://www.pole-images-nordpasdecalais.com" target="_blank"><?php echo Asset::img('season13/thanks/poleimages.jpeg', array('alt' => 'Season 13  merci au Pôle Images')); ?></a></li>
        <li><a href="http://www.univ-lille1.fr" target="_blank"><?php echo Asset::img('season13/thanks/lille1.jpeg', array('alt' => 'Season 13  merci à l\'Université Lille 1')); ?></a></li>
        <li><a href="http://ureca.recherche.univ-lille3.fr" target="_blank"><?php echo Asset::img('season13/thanks/ureca.jpeg', array('alt' => 'Season 13  merci à URECA')); ?></a></li>
    </ul>
    
</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var imgs = $('.main_container div ul li a img');
        imgs.each(function() {
            $(this).load(function() {$(this).css('top', (120 - $(this).height())/2);});
        });
    });
</script>