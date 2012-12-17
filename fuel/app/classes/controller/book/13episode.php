<?php
class Controller_Book_13episode extends Controller_Template 
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
		$data['admin_13episodes'] = Model_Admin_13episode::find('all');
		$this->template->title = "Book_13episodes";
		$this->template->content = View::forge('book/13episode/index', $data);

	}

	public function action_view($id = null)
	{
		$data['admin_13episode'] = Model_Admin_13episode::find($id);

		is_null($id) and Response::redirect('Book_13episode');

		$this->template->title = "Admin_13episode";
		$this->template->content = View::forge('book/13episode/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Admin_13episode::validate('create');
			
			if ($val->run())
			{
				$admin_13episode = Model_Admin_13episode::forge(array(
					'title' => Input::post('title'),
					'story' => Input::post('story'),
					'season' => Input::post('season'),
					'episode' => Input::post('episode'),
					'path' => Input::post('path'),
					'bref' => Input::post('bref'),
					'image' => Input::post('image'),
					'dday' => Input::post('dday'),
					'price' => Input::post('price'),
					'info_supp' => Input::post('info_supp'),
				));

				if ($admin_13episode and $admin_13episode->save())
				{
					Session::set_flash('success', 'Added admin_13episode #'.$admin_13episode->id.'.');

					Response::redirect('book/13episode');
				}

				else
				{
					Session::set_flash('error', 'Could not save admin_13episode.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "13Episodes";
		$this->template->content = View::forge('book/13episode/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Book_13episode');

		$admin_13episode = Model_Admin_13episode::find($id);

		$val = Model_Admin_13episode::validate('edit');

		if ($val->run())
		{
			$admin_13episode->title = Input::post('title');
			$admin_13episode->story = Input::post('story');
			$admin_13episode->season = Input::post('season');
			$admin_13episode->episode = Input::post('episode');
			$admin_13episode->path = Input::post('path');
			$admin_13episode->bref = Input::post('bref');
			$admin_13episode->image = Input::post('image');
			$admin_13episode->dday = Input::post('dday');
			$admin_13episode->price = Input::post('price');
			$admin_13episode->info_supp = Input::post('info_supp');

			if ($admin_13episode->save())
			{
				Session::set_flash('success', 'Updated admin_13episode #' . $id);

				Response::redirect('book/13episode');
			}

			else
			{
				Session::set_flash('error', 'Could not update admin_13episode #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$admin_13episode->title = $val->validated('title');
				$admin_13episode->story = $val->validated('story');
				$admin_13episode->season = $val->validated('season');
				$admin_13episode->episode = $val->validated('episode');
				$admin_13episode->path = $val->validated('path');
				$admin_13episode->bref = $val->validated('bref');
				$admin_13episode->image = $val->validated('image');
				$admin_13episode->dday = $val->validated('dday');
				$admin_13episode->price = $val->validated('price');
				$admin_13episode->info_supp = $val->validated('info_supp');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('admin_13episode', $admin_13episode, false);
		}

		$this->template->title = "13episode";
		$this->template->content = View::forge('book/13episode/edit');

	}

	public function action_delete($id = null)
	{
		if ($admin_13episode = Model_Admin_13episode::find($id))
		{
			$admin_13episode->delete();

			Session::set_flash('success', 'Deleted admin_13episode #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete admin_13episode #'.$id);
		}

		Response::redirect('book/13episode');

	}


}