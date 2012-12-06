<?php
class Controller_Achat_13extorder extends Controller_Template 
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
		$data['achat_13extorders'] = Model_Achat_13extorder::find('all');
		$this->template->title = "Achat_13extorders";
		$this->template->content = View::forge('achat/13extorder/index', $data);

	}

	public function action_view($id = null)
	{
		$data['achat_13extorder'] = Model_Achat_13extorder::find($id);

		is_null($id) and Response::redirect('Achat_13extorder');

		$this->template->title = "Achat_13extorder";
		$this->template->content = View::forge('achat/13extorder/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Achat_13extorder::validate('create');
			
			if ($val->run())
			{
				$achat_13extorder = Model_Achat_13extorder::forge(array(
					'reference' => Input::post('reference'),
					'owner' => Input::post('owner'),
					'order_source' => Input::post('order_source'),
					'appid' => Input::post('appid'),
					'price' => Input::post('price'),
					'app_name' => Input::post('app_name'),
				));

				if ($achat_13extorder and $achat_13extorder->save())
				{
					Session::set_flash('success', 'Added achat_13extorder #'.$achat_13extorder->id.'.');

					Response::redirect('achat/13extorder');
				}

				else
				{
					Session::set_flash('error', 'Could not save achat_13extorder.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Achat_13Extorders";
		$this->template->content = View::forge('achat/13extorder/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Achat_13extorder');

		$achat_13extorder = Model_Achat_13extorder::find($id);

		$val = Model_Achat_13extorder::validate('edit');

		if ($val->run())
		{
			$achat_13extorder->reference = Input::post('reference');
			$achat_13extorder->owner = Input::post('owner');
			$achat_13extorder->order_source = Input::post('order_source');
			$achat_13extorder->appid = Input::post('appid');
			$achat_13extorder->price = Input::post('price');
			$achat_13extorder->app_name = Input::post('app_name');

			if ($achat_13extorder->save())
			{
				Session::set_flash('success', 'Updated achat_13extorder #' . $id);

				Response::redirect('achat/13extorder');
			}

			else
			{
				Session::set_flash('error', 'Could not update achat_13extorder #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$achat_13extorder->reference = $val->validated('reference');
				$achat_13extorder->owner = $val->validated('owner');
				$achat_13extorder->order_source = $val->validated('order_source');
				$achat_13extorder->appid = $val->validated('appid');
				$achat_13extorder->price = $val->validated('price');
				$achat_13extorder->app_name = $val->validated('app_name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('achat_13extorder', $achat_13extorder, false);
		}

		$this->template->title = "Achat_13extorders";
		$this->template->content = View::forge('achat/13extorder/edit');

	}

	public function action_delete($id = null)
	{
		if ($achat_13extorder = Model_Achat_13extorder::find($id))
		{
			$achat_13extorder->delete();

			Session::set_flash('success', 'Deleted achat_13extorder #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete achat_13extorder #'.$id);
		}

		Response::redirect('achat/13extorder');

	}


}