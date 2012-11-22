<?php
class Controller_Admin_13userpossesion extends Controller_Template 
{
    public $template = 'admin/template';
    
    public function before()
    {
    	parent::before();
    	
        // Assign current_user to the instance so controllers can use it
		$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
		
		// Set a global variable so views can use it
		View::set_global('current_user', $this->current_user);

		if ( ! Auth::member(100) and Request::active()->action != 'login')
		{
			Response::redirect('404');
		}
    }

	public function action_index()
	{
		$data['admin_13userpossesions'] = Model_Admin_13userpossesion::find('all');
		$this->template->title = "Admin_13userpossesions";
		$this->template->content = View::forge('admin/13userpossesion/index', $data);

	}

	public function action_view($id = null)
	{
		$data['admin_13userpossesion'] = Model_Admin_13userpossesion::find($id);

		is_null($id) and Response::redirect('Admin_13userpossesion');

		$this->template->title = "Admin_13userpossesion";
		$this->template->content = View::forge('admin/13userpossesion/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Admin_13userpossesion::validate('create');
			
			if ($val->run())
			{
				$admin_13userpossesion = Model_Admin_13userpossesion::forge(array(
					'user_id' => Input::post('user_id'),
					'episode_id' => Input::post('episode_id'),
					'source' => Input::post('source'),
				));

				if ($admin_13userpossesion and $admin_13userpossesion->save())
				{
					Session::set_flash('success', 'Added admin_13userpossesion #'.$admin_13userpossesion->id.'.');

					Response::redirect('admin/13userpossesion');
				}

				else
				{
					Session::set_flash('error', 'Could not save admin_13userpossesion.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Admin_13Userpossesions";
		$this->template->content = View::forge('admin/13userpossesion/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Admin_13userpossesion');

		$admin_13userpossesion = Model_Admin_13userpossesion::find($id);

		$val = Model_Admin_13userpossesion::validate('edit');

		if ($val->run())
		{
			$admin_13userpossesion->user_id = Input::post('user_id');
			$admin_13userpossesion->episode_id = Input::post('episode_id');
			$admin_13userpossesion->source = Input::post('source');

			if ($admin_13userpossesion->save())
			{
				Session::set_flash('success', 'Updated admin_13userpossesion #' . $id);

				Response::redirect('admin/13userpossesion');
			}

			else
			{
				Session::set_flash('error', 'Could not update admin_13userpossesion #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$admin_13userpossesion->user_id = $val->validated('user_id');
				$admin_13userpossesion->episode_id = $val->validated('episode_id');
				$admin_13userpossesion->source = $val->validated('source');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('admin_13userpossesion', $admin_13userpossesion, false);
		}

		$this->template->title = "Admin_13userpossesions";
		$this->template->content = View::forge('admin/13userpossesion/edit');

	}

	public function action_delete($id = null)
	{
		if ($admin_13userpossesion = Model_Admin_13userpossesion::find($id))
		{
			$admin_13userpossesion->delete();

			Session::set_flash('success', 'Deleted admin_13userpossesion #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete admin_13userpossesion #'.$id);
		}

		Response::redirect('admin/13userpossesion');

	}


}