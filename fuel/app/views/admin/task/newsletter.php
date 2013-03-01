<!-- markItUp! skin -->
<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>assets/markitup/skins/markitup/style.css">
<!--  markItUp! toolbar skin -->
<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>assets/markitup/sets/default/style.css">
<!-- markItUp! -->
<script type="text/javascript" src="<?php echo $base_url; ?>assets/markitup/jquery.markitup.js"></script>
<!-- markItUp! toolbar settings -->
<script type="text/javascript" src="<?php echo $base_url; ?>assets/markitup/sets/default/set.js"></script>


<h2>New newsletter task</h2>
<br>

<?php 
    if(isset($admin_task)) {
        $params = $admin_task->getParameterArr();
        
        if($params && array_key_exists('content', $params)) 
            $content = $params['content'];
        if($params && array_key_exists('title', $params)) 
            $title = $params['title'];
    }
?>

<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Type', 'type'); ?>

			<div class="input">
				
				<?php 
				echo Form::select(
				    'type', 
				    Input::post('type', isset($admin_task) ? $admin_task->type : 'newsletter'), 
				    array('newsletter')
				); 
				?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Newsletter title', 'title'); ?>

			<div class="input">
				<?php 
				    echo Form::input('title', Input::post('title', isset($title) ? $title : ''), array('class' => 'span8', 'rows' => 8)); 
				?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Newsletter content', 'content'); ?>

			<div class="input">
				<?php 
				    echo Form::textarea('content', Input::post('content', isset($content) ? $content : ''), array('class' => 'span8', 'rows' => 8, 'id' => 'markItUp')); 
				?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Newsletter sms content', 'smscontent'); ?>

			<div class="input">
				<?php 
				    echo Form::textarea('smscontent', Input::post('smscontent', isset($smscontent) ? $smscontent : ''), array('class' => 'span8', 'rows' => 8)); 
				?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('When to do (dd/mm/yyyy hh:mm)', 'whentodo'); ?>

			<div class="input">
				
				<?php echo Form::input('whentodo', Input::post('whentodo', isset($admin_task) ? $admin_task->whentodo : Date::time()->format("%d/%m/%Y %H:%M")), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>

<p><?php echo Html::anchor('admin/task', 'Back'); ?></p>



<script type="text/javascript">
$(function() {
	// Add markItUp! to your textarea in one line
	// $('textarea').markItUp( { Settings }, { OptionalExtraSettings } );
	$('#markItUp').markItUp(mySettings);
});
</script>