<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<style>
		body { margin: 50px; }
	</style>
	<?php echo Asset::js(array(
		'http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js',
		'bootstrap.js'
	)); ?>
	<script>
		$(function(){ $('.topbar').dropdown(); });
	</script>
</head>
<body>

	<?php if ($current_user): ?>
	<div class="navbar navbar-fixed-top">
	    <div class="navbar-inner">
	        <div class="container">
	            <a href="<?php echo $remote_path; ?>" class="brand">Home</a>
	            <ul class="nav">
					<li class="dropdown">
					    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Users <b class="caret"></b></a>
					    <ul class="dropdown-menu">
					        <li>
					            <?php echo Html::anchor('admin/13users', 'Tous les utilisateurs') ?>
					        </li>
					        <li>
					            <?php echo Html::anchor('admin/13userpossesion', 'Possession') ?>
					        </li>
					        <li>
					            <?php echo Html::anchor('admin/mails/promo_code', 'Envoyer des codes promos') ?>
					        </li>
					    </ul>
					</li>
					
					<li class="dropdown">
					    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Histoires <b class="caret"></b></a>
					    <ul class="dropdown-menu">
					        <li>
					            <?php echo Html::anchor('book/13author', 'Auteurs') ?>
					        </li>
					        <li>
					            <?php echo Html::anchor('book/13book', 'Livres') ?>
					        </li>
					        <li>
					            <?php echo Html::anchor('book/13season', 'Saisons') ?>
					        </li>
					        <li>
					            <?php echo Html::anchor('book/13episode', 'Episodes') ?>
					        </li>
					        <li>
					            <?php echo Html::anchor('book/13hierarchie', 'Relations') ?>
					        </li>
					        <li>
					            <?php echo Html::anchor('book/13game', 'Jeux') ?>
					        </li>
					    </ul>
					</li>
					
					<li class="dropdown">
					    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Achats <b class="caret"></b></a>
					    <ul class="dropdown-menu">
					        <li>
					            <?php echo Html::anchor('achat/13product', 'Produits') ?>
					        </li>
					        <li>
					            <?php echo Html::anchor('achat/productprice', 'Prix des produits') ?>
					        </li>
					        <li>
					            <?php echo Html::anchor('achat/13extorder', 'Achats externes') ?>
					        </li>
					        <li>
					            <?php echo Html::anchor('achat/country', 'Pays') ?>
					        </li>
					        <li>
					            <?php echo Html::anchor('achat/currency', 'Devis') ?>
					        </li>
					    </ul>
					</li>
					
					<li>
					    <?php echo Html::anchor('admin/13posts', 'Actualités') ?>
					</li>
					
					
					<li class="dropdown">
					    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Commentaire <b class="caret"></b></a>
					    <ul class="dropdown-menu">
						    <li>
						        <?php echo Html::anchor('admin/13comments', 'Commentaires') ?>
						    </li>
					        <li>
					            <?php echo Html::anchor('admin/13comments/moderator', 'Moderator') ?>
					        </li>
					    </ul>
					</li>
					
					<li class="dropdown">
					    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Webservice <b class="caret"></b></a>
					    <ul class="dropdown-menu">
						    <li>
						        <?php echo Html::anchor('webservice/plateformapp', 'Les applis') ?>
						    </li>
					        <li>
					            <?php echo Html::anchor('webservice/appermission', 'Permission d\'appli') ?>
					        </li>
					    </ul>
					</li>
					
					<li class="dropdown">
					    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Autres <b class="caret"></b></a>
					    <ul class="dropdown-menu">
						    <li>
						        <?php echo Html::anchor('admin/13contactmsgs', 'Messages') ?>
						    </li>
						    
						    <li>
						        <?php echo Html::anchor('admin/mails', 'Envoie des mails') ?>
						    </li>
					    </ul>
					</li>
					
					<li class="dropdown">
					    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Build <b class="caret"></b></a>
					    <ul class="dropdown-menu">
						    <li>
						        <?php echo Html::anchor($base_url.'admin/build/storyjs', 'Build story js') ?>
						    </li>
						    
						    <li>
						        <?php echo Html::anchor($base_url.'admin/build/templatejs', 'Build template js') ?>
						    </li>
					    </ul>
					</li>
	          </ul>

	          <ul class="nav pull-right">

	            <li class="dropdown">
	              <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $current_user->pseudo ?> <b class="caret"></b></a>
	              <ul class="dropdown-menu">
	               <li><?php echo Html::anchor('admin/logout', 'Logout') ?></li>
	              </ul>
	            </li>
	          </ul>
	        </div>
	    </div>
	</div>
	<?php endif; ?>

	<div class="container">
		<div class="row">
			<div class="span12">
				<h1><?php echo $title; ?></h1>
				<hr>
<?php if (Session::get_flash('success')): ?>
				<div class="alert alert-success">
					<button class="close" data-dismiss="alert">×</button>
					<p><?php echo implode('</p><p>', (array) Session::get_flash('success')); ?></p>
				</div>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert">×</button>
					<p><?php echo implode('</p><p>', (array) Session::get_flash('error')); ?></p>
				</div>
<?php endif; ?>
			</div>
			<div class="span12">
<?php echo $content; ?>
			</div>
		</div>
		<hr/>
		<footer>
			<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
			<p>
				<a href="http://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
				<small>Version: <?php echo e(Fuel::VERSION); ?></small>
			</p>
		</footer>
	</div>
</body>
</html>
