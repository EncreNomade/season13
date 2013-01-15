<?php
class Controller_Admin_13users extends Controller_Backend 
{
    public $template = 'admin/template';
    
	public function action_index()
	{
		$data['users'] = Model_13user::find('all');
		$this->template->title = "Season 13 users";
		$this->template->content = View::forge('admin/13users/index', $data);

	}

	public function action_view($id = null)
	{
		$data['user'] = Model_13user::find($id);

		is_null($id) and Response::redirect('Admin_13users');

		$this->template->title = "Season 13 user";
		$this->template->content = View::forge('admin/13users/view', $data);

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Admin_13users');

        if ( Input::method() == 'POST' && ! \Security::check_token() ) {
            Session::set_flash('error', 'CSRF token error');
        }
        else {
    		$user = Model_13user::find($id);
    
    		$val = Model_13user::validate('edit');
    
    		if ($val->run())
    		{
    			$user->pseudo = Input::post('pseudo');
    			$user->group = Input::post('group');
    			$user->email = Input::post('email');
    			$user->portable = Input::post('portable') ? Input::post('portable') : "";
    			$user->avatar = Input::post('avatar');
    			$user->sex = Input::post('sex');
    			$user->birthday = Input::post('birthday');
    			$user->pays = Input::post('pays') ? Input::post('pays') : "";
    			$user->code_postal = Input::post('code_postal') ? Input::post('code_postal') : "";
    
    			if ($user->save())
    			{
    				Session::set_flash('success', 'Updated user #' . $user->pseudo);
    
    				Response::redirect('admin/13users');
    			}
    
    			else
    			{
    				Session::set_flash('error', 'Could not update user #' . $user->pseudo);
    			}
    		}
    
    		else
    		{
    			if (Input::method() == 'POST')
    			{
    			    $user->pseudo = $val->validated('pseudo');
    			    $user->group = $val->validated('group');
    			    $user->email = $val->validated('email');
    			    $user->portable = $val->validated('portable');
    			    $user->avatar = $val->validated('avatar');
    			    $user->sex = $val->validated('sex');
    			    $user->birthday = $val->validated('birthday');
    			    $user->pays = $val->validated('pays');
    			    $user->code_postal = $val->validated('code_postal');
    			        
    				Session::set_flash('error', $val->error());
    			}
    
    			$this->template->set_global('user', $user, false);
    		}
		}

        $this->template->title = "Season 13 user";
        $this->template->content = View::forge('admin/13users/edit', $data);
	}

	public function action_delete($id = null)
	{
		if ($user = Model_13user::find($id))
		{
		    $pseudo = $user->pseudo;
			$user->delete();

			Session::set_flash('success', 'Deleted user #' . $pseudo);
		}

		else
		{
			Session::set_flash('error', 'Could not delete user #'.$id);
		}

		Response::redirect('admin/13users');

	}


}