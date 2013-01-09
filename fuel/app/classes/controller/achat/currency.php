<?php
class Controller_Achat_Currency extends Controller_Template 
{

	public function action_index()
	{
		$data['achat_currencies'] = Model_Achat_Currency::find('all');
		$this->template->title = "Achat_currencies";
		$this->template->content = View::forge('achat/currency/index', $data);

	}

	public function action_view($id = null)
	{
		$data['achat_currency'] = Model_Achat_Currency::find($id);

		is_null($id) and Response::redirect('Achat_Currency');

		$this->template->title = "Achat_currency";
		$this->template->content = View::forge('achat/currency/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Achat_Currency::validate('create');
			
			if ($val->run())
			{
				$achat_currency = Model_Achat_Currency::forge(array(
					'name' => Input::post('name'),
					'iso_code' => Input::post('iso_code'),
					'iso_code_num' => Input::post('iso_code_num'),
					'sign' => Input::post('sign'),
					'active' => Input::post('active'),
					'conversion_rate' => Input::post('conversion_rate'),
					'supp' => Input::post('supp'),
				));

				if ($achat_currency and $achat_currency->save())
				{
					Session::set_flash('success', 'Added achat_currency #'.$achat_currency->id.'.');

					Response::redirect('achat/currency');
				}

				else
				{
					Session::set_flash('error', 'Could not save achat_currency.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Achat_Currencies";
		$this->template->content = View::forge('achat/currency/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Achat_Currency');

		$achat_currency = Model_Achat_Currency::find($id);

		$val = Model_Achat_Currency::validate('edit');

		if ($val->run())
		{
			$achat_currency->name = Input::post('name');
			$achat_currency->iso_code = Input::post('iso_code');
			$achat_currency->iso_code_num = Input::post('iso_code_num');
			$achat_currency->sign = Input::post('sign');
			$achat_currency->active = Input::post('active');
			$achat_currency->conversion_rate = Input::post('conversion_rate');
			$achat_currency->supp = Input::post('supp');

			if ($achat_currency->save())
			{
				Session::set_flash('success', 'Updated achat_currency #' . $id);

				Response::redirect('achat/currency');
			}

			else
			{
				Session::set_flash('error', 'Could not update achat_currency #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$achat_currency->name = $val->validated('name');
				$achat_currency->iso_code = $val->validated('iso_code');
				$achat_currency->iso_code_num = $val->validated('iso_code_num');
				$achat_currency->sign = $val->validated('sign');
				$achat_currency->active = $val->validated('active');
				$achat_currency->conversion_rate = $val->validated('conversion_rate');
				$achat_currency->supp = $val->validated('supp');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('achat_currency', $achat_currency, false);
		}

		$this->template->title = "Achat_currencies";
		$this->template->content = View::forge('achat/currency/edit');

	}

	public function action_delete($id = null)
	{
		if ($achat_currency = Model_Achat_Currency::find($id))
		{
			$achat_currency->delete();

			Session::set_flash('success', 'Deleted achat_currency #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete achat_currency #'.$id);
		}

		Response::redirect('achat/currency');

	}


}