<?php
class Controller_Admin_Task extends Controller_Template 
{
    private static $whentodo_ptn = "/(?P<date>\d{2}[\/\.]\d{2}[\/\.]\d{4})(?P<time>\d{2}[\:hH]\d{2})/";

	public function action_index()
	{
		$data['admin_tasks'] = Model_Admin_Task::find('all');
		$this->template->title = "Admin_tasks";
		$this->template->content = View::forge('admin/task/index', $data);

	}

	public function action_view($id = null)
	{
		$data['admin_task'] = Model_Admin_Task::find($id);

		is_null($id) and Response::redirect('Admin_Task');

		$this->template->title = "Admin_task";
		$this->template->content = View::forge('admin/task/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Admin_Task::validate('create');
			
			if ($val->run())
			{
				$admin_task = Model_Admin_Task::forge(array(
					'creator' => Input::post('creator'),
					'type' => Input::post('type'),
					'parameters' => Input::post('parameters'),
					'whentodo' => Input::post('whentodo'),
					'done' => Input::post('done'),
					'whendone' => Input::post('whendone'),
				));

				if ($admin_task and $admin_task->save())
				{
					Session::set_flash('success', 'Added admin_task #'.$admin_task->id.'.');

					Response::redirect('admin/task');
				}

				else
				{
					Session::set_flash('error', 'Could not save admin_task.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Admin_Tasks";
		$this->template->content = View::forge('admin/task/create');

	}
	
	public function action_plannewsletter()
	{
		if (Input::method() == 'POST')
		{
		    $val = Validation::forge();
		    $val->add_field('type', 'Type', 'required');
		    $val->add_field('title', 'Title', 'required');
		    $val->add_field('content', 'Content', 'required');
		    $val->add_field('whentodo', 'When to do', 'required');
		    
		    if ($val->run())
		    {
    		    $params = array(
    		        'title' => Input::post('title'),
    		        'content' => Input::post('content')
    		    );
    		    $whentodo = Input::post('whentodo');
    		
    			$admin_task = Model_Admin_Task::forge(array(
    				'creator' => $this->current_user->id,
    				'type' => Input::post('type'),
    				'parameters' => $params,
    				'whentodo' => $whentodo,
    				'done' => 0,
    				'whendone' => 0,
    			));
    
    			if ($admin_task and $admin_task->save())
    			{
    				Session::set_flash('success', 'Added newsletter #'.$admin_task->id.'.');
    
    				Response::redirect('admin/task');
    			}
    
    			else
    			{
    				Session::set_flash('error', 'Could not save newsletter.');
    			}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Create a newsletter";
		$this->template->content = View::forge('admin/task/newsletter');

	}


	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Admin_Task');

		$admin_task = Model_Admin_Task::find($id);

		$val = Model_Admin_Task::validate('edit');

		if ($val->run())
		{
			$admin_task->creator = Input::post('creator');
			$admin_task->type = Input::post('type');
			$admin_task->parameters = Input::post('parameters');
			$admin_task->whentodo = Input::post('whentodo');
			$admin_task->done = Input::post('done');
			$admin_task->whendone = Input::post('whendone');

			if ($admin_task->save())
			{
				Session::set_flash('success', 'Updated admin_task #' . $id);

				Response::redirect('admin/task');
			}

			else
			{
				Session::set_flash('error', 'Could not update admin_task #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$admin_task->creator = $val->validated('creator');
				$admin_task->type = $val->validated('type');
				$admin_task->parameters = $val->validated('parameters');
				$admin_task->whentodo = $val->validated('whentodo');
				$admin_task->done = $val->validated('done');
				$admin_task->whendone = $val->validated('whendone');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('admin_task', $admin_task, false);
		}

		$this->template->title = "Admin_tasks";
		$this->template->content = View::forge('admin/task/edit');

	}

	public function action_delete($id = null)
	{
		if ($admin_task = Model_Admin_Task::find($id))
		{
			$admin_task->delete();

			Session::set_flash('success', 'Deleted admin_task #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete admin_task #'.$id);
		}

		Response::redirect('admin/task');

	}


}