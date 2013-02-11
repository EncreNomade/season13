<?php
class Controller_User_Address extends Controller_Ajax
{
	private function getUserAdress($id) {
		if(is_null($id))
			return null;

		$user_address = Model_User_Address::find($id);
		if(is_null($this->current_user) || is_null($user_address) || $this->current_user->id != $user_address->user_id)
			return null;
		else
			return $user_address;
	}

	public function action_view($id = null)
	{
		$user_address = $this->getUserAdress($id);

		if(!$user_address) {
			Response::redirect('404');
		}

		$data['user_address'] = $user_address;
		return View::forge('user/address/view', $data);
	}

	

	public function action_edit($id = null)
	{
		$user_address = $this->getUserAdress($id);

		if(!$user_address) {
			Response::redirect('404');
		}

		$user_address = Model_User_Address::find($id);
		$val = Model_User_Address::validate('edit');
		$val->set_message('required', 'Tu dois indiquer :label');
		$val->set_message('max_length', ':label ne doit pas dépasser :param:1 caractères');
		$val->set_message('valid_email', 'Tu dois indiquer un adresse mail correct');

		if ($val->run())
		{
			$user_address->firstname = Input::post('firstname') ? Input::post('firstname') : "";
			$user_address->lastname = Input::post('lastname');
			$user_address->address = Input::post('address');
			$user_address->email = Input::post('email');
			$user_address->postcode = Input::post('postcode');
			$user_address->city = Input::post('city');
			$user_address->country_code = Input::post('country_code');
			$user_address->tel = Input::post('tel') ? Input::post('tel') : "";
			$user_address->title = 'defaut';
			$user_address->supp = '';

			if ($user_address->save())
			{
				Session::set_flash('success', 'Updated user_address #' . $id);

				Response::redirect('user/address/view/' . $id);
			}

			else
			{
				Session::set_flash('error', 'Could not update user_address #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$user_address->firstname = $val->validated('firstname') ? $val->validated('firstname') : "";
				$user_address->lastname = $val->validated('lastname');
				$user_address->address = $val->validated('address');
				$user_address->email = $val->validated('email');
				$user_address->postcode = $val->validated('postcode');
				$user_address->city = $val->validated('city');
				$user_address->country_code = $val->validated('country_code');
				$user_address->tel = $val->validated('tel') ? $val->validated('tel') : "";
				$user_address->title = $val->validated('title');
				$user_address->supp = $val->validated('supp');
		
				Session::set_flash('error', $val->error());
			}

			View::set_global('user_address', $user_address);
			return View::forge('user/address/edit');
		}

		View::set_global('user_address', $user_address);
		return View::forge('user/address/edit');
	}


	public function action_create()
	{
		if(isset($this->current_user)) {
			if (Input::method() == 'POST')
			{
				Input::post('user_id', $this->current_user->id);
				$val = Model_User_Address::validate('create');
				$val->set_message('required', 'Tu dois indiquer :label');
				$val->set_message('max_length', ':label ne doit pas dépasser :param:1 caractères');
				$val->set_message('valid_email', 'Tu dois indiquer un adresse mail correct');	
				
				if ($val->run())
				{
					$user_address = Model_User_Address::forge(array(
						'user_id' => $this->current_user->id,
						'firstname' => Input::post('firstname') ? Input::post('firstname') : "",
						'lastname' => Input::post('lastname'),
						'address' => Input::post('address'),
						'email' => Input::post('email'),
						'postcode' => Input::post('postcode'),
						'city' => Input::post('city'),
						'country_code' => Input::post('country_code'),
						'tel' => Input::post('tel') ? Input::post('tel') : "",
						'title' => 'defaut',
						'supp' => ''
					));

					if ($user_address and $user_address->save())
					{
						Session::set_flash('success', 'Added user_address #'.$user_address->id.'.');

						Response::redirect('user/address/view/'.$user_address->id);
					}

					else
					{
						Session::set_flash('error', 'Could not save user_address.');
					}
				}
				else
				{
					Session::set_flash('error', $val->error());
				}
			}
		}
		else {
			Session::set_flash('error', 'Tu dois être inscrit et connecté pour enregistré une adresse');
		}

		return View::forge('user/address/create');
	}

    /*
    * index, delete and create methode are disabled
 	*/

 	private function action_index()
	{	
		$data = array();
		$data['user_addresses'] = Model_User_Address::find('all');
		return View::forge('user/address/index', $data);
	}

	private function action_delete($id = null)
	{
		if ($user_address = Model_User_Address::find($id))
		{
			$user_address->delete();

			Session::set_flash('success', 'Deleted user_address #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete user_address #'.$id);
		}

		Response::redirect('user/address');

	}



}

