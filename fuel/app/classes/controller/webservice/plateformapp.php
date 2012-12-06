<?php
class Controller_Webservice_Plateformapp extends Controller_Template 
{
    public $template = 'admin/template';
    
    public function before()
    {
    	parent::before();
    	
        // Assign current_user to the instance so controllers can use it
		$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
		// Set a global variable so views can use it
		View::set_global('current_user', $this->current_user);
    }

	public function action_index()
	{
		$data['webservice_plateformapps'] = Model_Webservice_Plateformapp::find('all');
		$this->template->title = "Webservice_plateformapps";
		$this->template->content = View::forge('webservice/plateformapp/index', $data);

	}

	public function action_view($id = null)
	{
		$data['webservice_plateformapp'] = Model_Webservice_Plateformapp::find($id);

		is_null($id) and Response::redirect('Webservice_Plateformapp');

		$this->template->title = "Webservice_plateformapp";
		$this->template->content = View::forge('webservice/plateformapp/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Webservice_Plateformapp::validate('create');
			
			if ($val->run())
			{
				$webservice_plateformapp = Model_Webservice_Plateformapp::forge(array(
					'appid' => Input::post('appid'),
					'appsecret' => Input::post('appsecret'),
					'appname' => Input::post('appname'),
					'description' => Input::post('description'),
					'active' => Input::post('active'),
					'ip' => Input::post('ip'),
					'host' => Input::post('host'),
					'extra' => Input::post('extra'),
				));

				if ($webservice_plateformapp and $webservice_plateformapp->save())
				{
					Session::set_flash('success', 'Added webservice_plateformapp #'.$webservice_plateformapp->id.'.');

					Response::redirect('webservice/plateformapp');
				}

				else
				{
					Session::set_flash('error', 'Could not save webservice_plateformapp.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Webservice_Plateformapps";
		$this->template->content = View::forge('webservice/plateformapp/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Webservice_Plateformapp');

		$webservice_plateformapp = Model_Webservice_Plateformapp::find($id);

		$val = Model_Webservice_Plateformapp::validate('edit');

		if ($val->run())
		{
			$webservice_plateformapp->appid = Input::post('appid');
			$webservice_plateformapp->appsecret = Input::post('appsecret');
			$webservice_plateformapp->appname = Input::post('appname');
			$webservice_plateformapp->description = Input::post('description');
			$webservice_plateformapp->active = Input::post('active');
			$webservice_plateformapp->ip = Input::post('ip');
			$webservice_plateformapp->host = Input::post('host');
			$webservice_plateformapp->extra = Input::post('extra');

			if ($webservice_plateformapp->save())
			{
				Session::set_flash('success', 'Updated webservice_plateformapp #' . $id);

				Response::redirect('webservice/plateformapp');
			}

			else
			{
				Session::set_flash('error', 'Could not update webservice_plateformapp #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$webservice_plateformapp->appid = $val->validated('appid');
				$webservice_plateformapp->appsecret = $val->validated('appsecret');
				$webservice_plateformapp->appname = $val->validated('appname');
				$webservice_plateformapp->description = $val->validated('description');
				$webservice_plateformapp->active = $val->validated('active');
				$webservice_plateformapp->ip = $val->validated('ip');
				$webservice_plateformapp->host = $val->validated('host');
				$webservice_plateformapp->extra = $val->validated('extra');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('webservice_plateformapp', $webservice_plateformapp, false);
		}

		$this->template->title = "Webservice_plateformapps";
		$this->template->content = View::forge('webservice/plateformapp/edit');

	}

	public function action_delete($id = null)
	{
		if ($webservice_plateformapp = Model_Webservice_Plateformapp::find($id))
		{
			$webservice_plateformapp->delete();

			Session::set_flash('success', 'Deleted webservice_plateformapp #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete webservice_plateformapp #'.$id);
		}

		Response::redirect('webservice/plateformapp');

	}


}