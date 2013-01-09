<?php
class Controller_Achat_Productprice extends Controller_Template 
{

	public function action_index()
	{
		$data['achat_productprices'] = Model_Achat_Productprice::find('all');
		$this->template->title = "Achat_productprices";
		$this->template->content = View::forge('achat/productprice/index', $data);

	}

	public function action_view($id = null)
	{
		$data['achat_productprice'] = Model_Achat_Productprice::find($id);

		is_null($id) and Response::redirect('Achat_Productprice');

		$this->template->title = "Achat_productprice";
		$this->template->content = View::forge('achat/productprice/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Achat_Productprice::validate('create');
			
			if ($val->run())
			{
				$achat_productprice = Model_Achat_Productprice::forge(array(
					'product_id' => Input::post('product_id'),
					'country_code' => Input::post('country_code'),
					'taxed_price' => Input::post('taxed_price'),
					'discount' => Input::post('discount'),
				));

				if ($achat_productprice and $achat_productprice->save())
				{
					Session::set_flash('success', 'Added achat_productprice #'.$achat_productprice->id.'.');

					Response::redirect('achat/productprice');
				}

				else
				{
					Session::set_flash('error', 'Could not save achat_productprice.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Achat_Productprices";
		$this->template->content = View::forge('achat/productprice/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Achat_Productprice');

		$achat_productprice = Model_Achat_Productprice::find($id);

		$val = Model_Achat_Productprice::validate('edit');

		if ($val->run())
		{
			$achat_productprice->product_id = Input::post('product_id');
			$achat_productprice->country_code = Input::post('country_code');
			$achat_productprice->taxed_price = Input::post('taxed_price');
			$achat_productprice->discount = Input::post('discount');

			if ($achat_productprice->save())
			{
				Session::set_flash('success', 'Updated achat_productprice #' . $id);

				Response::redirect('achat/productprice');
			}

			else
			{
				Session::set_flash('error', 'Could not update achat_productprice #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$achat_productprice->product_id = $val->validated('product_id');
				$achat_productprice->country_code = $val->validated('country_code');
				$achat_productprice->taxed_price = $val->validated('taxed_price');
				$achat_productprice->discount = $val->validated('discount');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('achat_productprice', $achat_productprice, false);
		}

		$this->template->title = "Achat_productprices";
		$this->template->content = View::forge('achat/productprice/edit');

	}

	public function action_delete($id = null)
	{
		if ($achat_productprice = Model_Achat_Productprice::find($id))
		{
			$achat_productprice->delete();

			Session::set_flash('success', 'Deleted achat_productprice #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete achat_productprice #'.$id);
		}

		Response::redirect('achat/productprice');

	}


}