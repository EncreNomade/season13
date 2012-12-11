<?php
class Controller_Achat_13product extends Controller_Template 
{
    public $template = 'admin/template';
    
    public function before()
    {
    	parent::before();
    	
    	if(!Auth::check()) {
    	    Response::redirect('404');
    	}
    	
        // Assign current_user to the instance so controllers can use it
		$this->current_user = Model_13user::find_by_pseudo(Auth::get_screen_name());
		// Set a global variable so views can use it
		View::set_global('current_user', $this->current_user);
    }

	public function action_index()
	{
		$data['achat_13products'] = Model_Achat_13product::find('all');
		$this->template->title = "Achat_13products";
		$this->template->content = View::forge('achat/13product/index', $data);

	}

	public function action_view($id = null)
	{
		$data['achat_13product'] = Model_Achat_13product::find($id);

		is_null($id) and Response::redirect('Achat_13product');

		$this->template->title = "Achat_13product";
		$this->template->content = View::forge('achat/13product/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Achat_13product::validateWithMeta('create');
			
			if ($val->run())
			{
				$metas = $this->mergeMetasArrays(Input::post('meta_type_content'), Input::post('meta_value_content'));
				if($metas === FALSE) 
				{
					Session::set_flash('error', 'The number of metas type and metas content is not equal');
				}
				else 
				{					
					$metas = Format::forge($metas)->to_json();
					$achat_13product = Model_Achat_13product::forge(array(
						'reference' => Input::post('reference'),
						'type' => Input::post('type'),
						'pack' => Input::post('pack'),
						'content' => Input::post('content'),
						'presentation' => Input::post('presentation'),
						'tags' => Input::post('tags'),
						'title' => Input::post('title'),
						'category' => Input::post('category'),
						'metas' => $metas,
						'on_sale' => Input::post('on_sale'),
						'price' => Input::post('price'),
						'discount' => Input::post('discount'),
						'sales' => Input::post('sales'),
					));

					if ($achat_13product and $achat_13product->save())
					{
						Session::set_flash('success', 'Added achat_13product #'.$achat_13product->id.'.');

						Response::redirect('achat/13product');
					}

					else
					{
						Session::set_flash('error', 'Could not save achat_13product.');
					}
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Achat_13Products";
		$this->template->content = View::forge('achat/13product/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Achat_13product');

		$achat_13product = Model_Achat_13product::find($id);

		$val = Model_Achat_13product::validateWithMeta('create');

		$metas = $this->mergeMetasArrays(Input::post('meta_type_content'), Input::post('meta_value_content'));

		if ($val->run())
		{
			if($metas === FALSE) 
			{
				Session::set_flash('error', 'The number of metas type and metas content is not equal');
			}
			else 
			{				
				$metas = Format::forge($metas)->to_json();
				$achat_13product->reference = Input::post('reference');
				$achat_13product->type = Input::post('type');
				$achat_13product->pack = Input::post('pack');
				$achat_13product->content = Input::post('content');
				$achat_13product->presentation = Input::post('presentation');
				$achat_13product->tags = Input::post('tags');
				$achat_13product->title = Input::post('title');
				$achat_13product->category = Input::post('category');
				$achat_13product->metas = $metas;
				$achat_13product->on_sale = Input::post('on_sale');
				$achat_13product->price = Input::post('price');
				$achat_13product->discount = Input::post('discount');
				$achat_13product->sales = is_numeric(Input::post('sales')) ? Input::post('sales') : 0;

				if ($achat_13product->save())
				{
					Session::set_flash('success', 'Updated achat_13product #' . $id);

					Response::redirect('achat/13product');
				}

				else
				{
					Session::set_flash('error', 'Could not update achat_13product #' . $id);
				}				
			}

		}

		else
		{
			if (Input::method() == 'POST')
			{
				$achat_13product->reference = $val->validated('reference');
				$achat_13product->type = $val->validated('type');
				$achat_13product->pack = $val->validated('pack');
				$achat_13product->content = $val->validated('content');
				$achat_13product->presentation = $val->validated('presentation');
				$achat_13product->tags = $val->validated('tags');
				$achat_13product->title = $val->validated('title');
				$achat_13product->category = $val->validated('category');
				$achat_13product->metas = $metas ? $metas : false;
				$achat_13product->on_sale = $val->validated('on_sale');
				$achat_13product->price = $val->validated('price');
				$achat_13product->discount = $val->validated('discount');
				$achat_13product->sales = $val->validated('sales');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('achat_13product', $achat_13product, false);
		}

		$this->template->title = "Achat_13products";
		$this->template->content = View::forge('achat/13product/edit');

	}

	public function action_delete($id = null)
	{
		if ($achat_13product = Model_Achat_13product::find($id))
		{
			$achat_13product->delete();

			Session::set_flash('success', 'Deleted achat_13product #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete achat_13product #'.$id);
		}

		Response::redirect('achat/13product');

	}

	private function mergeMetasArrays($types = [], $values = []) {
		$res = [];
		if(!is_array($types) || !is_array($values))
			return FALSE;
		if(sizeof($types) != sizeof($values))
			return FALSE;

		foreach ($types as $i => $type) {
			$res[] = [  "type" => $type, 
						"value" => $values[$i]  ];
		}

		return $res;

	}


}