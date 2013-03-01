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
			<?php echo Form::label('Newletter title', 'title'); ?>

			<div class="input">
				<?php 
				    echo Form::input('title', Input::post('title', isset($title) ? $title : ''), array('class' => 'span8', 'rows' => 8)); 
				?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Newletter content', 'content'); ?>

			<div class="input">
				<?php 
				    echo Form::textarea('content', Input::post('content', isset($content) ? $content : ''), array('class' => 'span8', 'rows' => 8)); 
				?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('When to do', 'whentodo'); ?>

			<div class="input">
				
				<?php echo Form::input('whentodo', Input::post('whentodo', isset($admin_task) ? $admin_task->whentodo : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>

<p><?php echo Html::anchor('admin/task', 'Back'); ?></p>
