<?php
class Controller_Admin_13posts extends Controller_Template 
{
    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    	View::set_global('remote_path', Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/');
    	View::set_global('base_url', Fuel::$env == Fuel::DEVELOPMENT ? 'localhost:8888/season13/public' : "http://".$_SERVER['HTTP_HOST']."/");
    	
    	// Set supplementation css and js file
        $this->template->css_supp = '';
        $this->template->js_supp = '';
    }

	public function action_index()
	{
	    $result = DB::select('*')->from(Model_Admin_13post::table())
	                             ->order_by('created_at','desc')
	                             ->limit(20)
	                             ->execute()
	                             ->as_array();
		$data['admin_13posts'] = $result;
		
		$this->template->title = "L'actualité, Histoire Interactive | Voodoo Connection | Feuilleton Interactif | Livre Jeux - SEASON13";
		
		$this->template->css_supp = 'post_index.css';
		$this->template->content = View::forge('admin/13posts/index', $data);

	}

	public function action_view($id = null)
	{
		$data['admin_13post'] = Model_Admin_13post::find($id);

		is_null($id) and Response::redirect('Admin_13posts');

		$this->template->title = "Admin_13post";
		$this->template->content = View::forge('admin/13posts/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Admin_13post::validate('create');
			
			if ($val->run())
			{
				$admin_13post = Model_Admin_13post::forge(array(
					'title' => Input::post('title'),
					'slug' => Input::post('slug'),
					'user_id' => Input::post('user_id'),
					'summary' => Input::post('summary'),
					'body' => Input::post('body'),
					'categories' => Input::post('categories'),
				));

				if ($admin_13post and $admin_13post->save())
				{
					Session::set_flash('success', 'Added admin_13post #'.$admin_13post->id.'.');

					Response::redirect('admin/13posts');
				}

				else
				{
					Session::set_flash('error', 'Could not save admin_13post.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Admin_13Posts";
		$this->template->content = View::forge('admin/13posts/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Admin_13posts');

		$admin_13post = Model_Admin_13post::find($id);

		$val = Model_Admin_13post::validate('edit');

		if ($val->run())
		{
			$admin_13post->title = Input::post('title');
			$admin_13post->slug = Input::post('slug');
			$admin_13post->user_id = Input::post('user_id');
			$admin_13post->summary = Input::post('summary');
			$admin_13post->body = Input::post('body');
			$admin_13post->categories = Input::post('categories');

			if ($admin_13post->save())
			{
				Session::set_flash('success', 'Updated admin_13post #' . $id);

				Response::redirect('admin/13posts');
			}

			else
			{
				Session::set_flash('error', 'Could not update admin_13post #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$admin_13post->title = $val->validated('title');
				$admin_13post->slug = $val->validated('slug');
				$admin_13post->user_id = $val->validated('user_id');
				$admin_13post->summary = $val->validated('summary');
				$admin_13post->body = $val->validated('body');
				$admin_13post->categories = $val->validated('categories');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('admin_13post', $admin_13post, false);
		}

		$this->template->title = "Admin_13posts";
		$this->template->content = View::forge('admin/13posts/edit');

	}

	public function action_delete($id = null)
	{
		if ($admin_13post = Model_Admin_13post::find($id))
		{
			$admin_13post->delete();

			Session::set_flash('success', 'Deleted admin_13post #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete admin_13post #'.$id);
		}

		Response::redirect('admin/13posts');

	}


}