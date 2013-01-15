<?php
class Controller_Achat_13extorder extends Controller_Backend
{
    public $template = 'admin/template';

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
			    $valid = true;
			    $app = Model_Webservice_Plateformapp::find(Input::post('appid'));
			    if(!$app) {
			        Session::set_flash('error', 'App not exist.');
			        $valid = false;
			    }
			    $user = Model_13user::find_by_email(Input::post('owner'));
			    if(!$user) {
			        Session::set_flash('error', 'User not exist.');
			        $valid = false;
			    }
			    $product = Model_Achat_13product::find_by_reference(Input::post('reference'));
			    if(!$product) {
			        Session::set_flash('error', 'Product not exist.');
			        $valid = false;
			    }
			    
			    if($valid) {
    				$achat_13extorder = Model_Achat_13extorder::forge(array(
    					'reference' => Input::post('reference'),
    					'owner' => Input::post('owner'),
    					'order_source' => Input::post('order_source') ? Input::post('order_source') : "",
    					'appid' => Input::post('appid'),
    					'price' => Input::post('price'),
    					'app_name' => $app->appname,
    					'state' => "FINALIZE",
    				));
    
    				if ($achat_13extorder and $achat_13extorder->save())
    				{
    					Session::set_flash('success', 'Added external order #'.$achat_13extorder->id.'.');
    
    					Response::redirect('achat/13extorder');
    				}
    
    				else
    				{
    					Session::set_flash('error', 'Could not save external order.');
    				}
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
		    $valid = true;
		    $app = Model_Webservice_Plateformapp::find(Input::post('appid'));
		    if(!$app) {
		        Session::set_flash('error', 'App not exist.');
		        $valid = false;
		    }
		    $user = Model_13user::find_by_email(Input::post('owner'));
		    if(!$user) {
		        Session::set_flash('error', 'User not exist.');
		        $valid = false;
		    }
		    $product = Model_Achat_13product::find_by_reference(Input::post('reference'));
		    if(!$product) {
		        Session::set_flash('error', 'Product not exist.');
		        $valid = false;
		    }
		
		    if($valid) {
    			$achat_13extorder->reference = Input::post('reference');
    			$achat_13extorder->owner = Input::post('owner');
    			$achat_13extorder->order_source = Input::post('order_source') ? Input::post('order_source') : "";
    			$achat_13extorder->appid = Input::post('appid');
    			$achat_13extorder->price = Input::post('price');
    			$achat_13extorder->app_name = $app->appname;
    
    			if ($achat_13extorder->save())
    			{
    				Session::set_flash('success', 'Updated external order #' . $id);
    
    				Response::redirect('achat/13extorder');
    			}
    
    			else
    			{
    				Session::set_flash('error', 'Could not update external order #' . $id);
    			}
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

			Session::set_flash('success', 'Deleted external order #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete external order #'.$id);
		}

		Response::redirect('achat/13extorder');

	}


}