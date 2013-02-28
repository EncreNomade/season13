<!-- markItUp! skin -->
<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>assets/markitup/skins/markitup/style.css">
<!--  markItUp! toolbar skin -->
<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>assets/markitup/sets/default/style.css">
<!-- markItUp! -->
<script type="text/javascript" src="<?php echo $base_url; ?>assets/markitup/jquery.markitup.js"></script>
<!-- markItUp! toolbar settings -->
<script type="text/javascript" src="<?php echo $base_url; ?>assets/markitup/sets/default/set.js"></script>

<?php echo Form::open(); ?>

    <?php echo Form::hidden('user_id', isset($admin_13post) ? $admin_13post->user_id : $current_user->id); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($admin_13post) ? $admin_13post->title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Slug', 'slug'); ?>

			<div class="input">
				<?php echo Form::input('slug', Input::post('slug', isset($admin_13post) ? $admin_13post->slug : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Summary', 'summary'); ?>

			<div class="input">
				<?php echo Form::textarea('summary', Input::post('summary', isset($admin_13post) ? $admin_13post->summary : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Body', 'body'); ?>

			<div class="input">
				<?php echo Form::textarea('body', Input::post('body', isset($admin_13post) ? stripslashes($admin_13post->body) : ''), array('class' => 'span8', 'rows' => 8, 'id' => 'markItUp', 'col' => '80', 'row' => '20')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Categories', 'categories'); ?>

			<div class="input">
				<?php echo Form::input('categories', Input::post('categories', isset($admin_13post) ? $admin_13post->categories : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>

<script type="text/javascript">
$(function() {
	// Add markItUp! to your textarea in one line
	// $('textarea').markItUp( { Settings }, { OptionalExtraSettings } );
	$('#markItUp').markItUp(mySettings);
});
</script>