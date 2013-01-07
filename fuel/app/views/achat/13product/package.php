<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $product->title; ?></title>
	<?php 
		echo Asset::css('product_pack.css'); 
	    echo Asset::css('BebasNeue.css');
    ?>
	</head>
	<body>
		<header>			
            <?php echo Asset::img('season13/13logo.png'); ?>
		</header>
        <h1 class="main_title"><?php echo $product->title ; ?></h1>
		<div id="episodes">
		    <ul>
		    <?php foreach ($episodes as $ep): ?>
		        <li class="episode"> 
		        	<div class="thumb">
		        		<a href="<?php echo $ep['link']; ?>">
				            <?php echo Html::img($ep['obj']->image); ?>
				            <div class="title">
				            	<h2><?php echo '#'.$ep['obj']->episode.'  '.stripslashes($ep['obj']->title); ?></h2>
				            	<span class="voir">VOIR l'EPISODE</span>
				            </div>
		        		</a>
		        	</div>
		        	<?php if(trim($ep['obj']->bref) != ''): ?>
		    			<div class="desc"><p><?php echo $ep['obj']->bref; ?></p></div>
    				<?php endif; ?>
		        </li>
		    <?php endforeach; ?>
		    </ul>		    
		</div>
		<?php echo Asset::img('season13/illus/simonHD.png', array('id'=>'simon')) ?>
	</body>
</html>