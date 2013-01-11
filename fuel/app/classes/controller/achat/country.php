<?php
class Controller_Achat_Country extends Controller_Template 
{

	public function action_index()
	{
		$data['achat_countries'] = Model_Achat_Country::find('all');
		$this->template->title = "Achat_countries";
		$this->template->content = View::forge('achat/country/index', $data);

	}

	public function action_view($id = null)
	{
		$data['achat_country'] = Model_Achat_Country::find($id);

		is_null($id) and Response::redirect('Achat_Country');

		$this->template->title = "Achat_country";
		$this->template->content = View::forge('achat/country/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Achat_Country::validate('create');
			
			if ($val->run())
			{
				$achat_country = Model_Achat_Country::forge(array(
					'name' => Input::post('name'),
					'iso_code' => Input::post('iso_code'),
					'language' => Input::post('language'),
					'tax_rate' => Input::post('tax_rate'),
					'currency_code' => Input::post('currency_code'),
					'active' => Input::post('active'),
				));

				if ($achat_country and $achat_country->save())
				{
					Session::set_flash('success', 'Added achat_country #'.$achat_country->id.'.');

					Response::redirect('achat/country');
				}

				else
				{
					Session::set_flash('error', 'Could not save achat_country.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Achat_Countries";
		$this->template->content = View::forge('achat/country/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Achat_Country');

		$achat_country = Model_Achat_Country::find($id);

		$val = Model_Achat_Country::validate('edit');

		if ($val->run())
		{
			$achat_country->name = Input::post('name');
			$achat_country->iso_code = Input::post('iso_code');
			$achat_country->language = Input::post('language');
			$achat_country->tax_rate = Input::post('tax_rate');
			$achat_country->currency_code = Input::post('currency_code');
			$achat_country->active = Input::post('active');

			if ($achat_country->save())
			{
				Session::set_flash('success', 'Updated achat_country #' . $id);

				Response::redirect('achat/country');
			}

			else
			{
				Session::set_flash('error', 'Could not update achat_country #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$achat_country->name = $val->validated('name');
				$achat_country->iso_code = $val->validated('iso_code');
				$achat_country->language = $val->validated('language');
				$achat_country->tax_rate = $val->validated('tax_rate');
				$achat_country->currency_code = $val->validated('currency_code');
				$achat_country->active = $val->validated('active');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('achat_country', $achat_country, false);
		}

		$this->template->title = "Achat_countries";
		$this->template->content = View::forge('achat/country/edit');

	}

	public function action_delete($id = null)
	{
		if ($achat_country = Model_Achat_Country::find($id))
		{
			$achat_country->delete();

			Session::set_flash('success', 'Deleted achat_country #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete achat_country #'.$id);
		}

		Response::redirect('achat/country');

	}


}