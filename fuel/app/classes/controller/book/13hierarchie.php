<?php
class Controller_Book_13hierarchie extends Controller_Template 
{
    public $template = 'admin/template';
    
    public function before()
    {
    	parent::before();
    	
        // Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	if( !Auth::member(100) ) {
    	    Response::redirect('404');
    	}
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    	View::set_global('remote_path', Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/');
    	View::set_global('base_url', Fuel::$env == Fuel::DEVELOPMENT ? 'localhost:8888/season13/public' : "http://".$_SERVER['HTTP_HOST']."/");
    }

	public function action_index()
	{
		$data['book_13hierarchies'] = Model_Book_13hierarchie::find('all');
		$this->template->title = "Book_13hierarchies";
		$this->template->content = View::forge('book/13hierarchie/index', $data);

	}

	public function action_view($id = null)
	{
		$data['book_13hierarchie'] = Model_Book_13hierarchie::find($id);

		is_null($id) and Response::redirect('Book_13hierarchie');

		$this->template->title = "Book_13hierarchie";
		$this->template->content = View::forge('book/13hierarchie/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
		    if ( ! \Security::check_token() ) {
		        Session::set_flash('error', 'CSRF token error');
		    }
		    else {
    			$val = Model_Book_13hierarchie::validate('create');
    			
    			if ($val->run())
    			{
    				$book_13hierarchie = Model_Book_13hierarchie::forge(array(
    					'epid' => Input::post('epid'),
    					'belongto' => Input::post('belongto'),
    					'relation_type' => Input::post('relation_type') ? Input::post('relation_type') : "",
    					'extra' => Input::post('extra') ? Input::post('extra') : "",
    				));
    
    				if ($book_13hierarchie and $book_13hierarchie->save())
    				{
    					Session::set_flash('success', 'Added book_13hierarchie #'.$book_13hierarchie->id.'.');
    
    					Response::redirect('book/13hierarchie');
    				}
    
    				else
    				{
    					Session::set_flash('error', 'Could not save book_13hierarchie.');
    				}
    			}
    			else
    			{
    				Session::set_flash('error', $val->error());
    			}
			}
		}

		$this->template->title = "Book_13Hierarchies";
		$this->template->content = View::forge('book/13hierarchie/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Book_13hierarchie');
		
		if (Input::method() == 'POST' && ! \Security::check_token() ) {
		    Session::set_flash('error', 'CSRF token error');
		}
        else {
    		$book_13hierarchie = Model_Book_13hierarchie::find($id);
    
    		$val = Model_Book_13hierarchie::validate('edit');
    
    		if ($val->run())
    		{
    			$book_13hierarchie->epid = Input::post('epid');
    			$book_13hierarchie->belongto = Input::post('belongto');
    			$book_13hierarchie->relation_type = Input::post('relation_type') ? Input::post('relation_type') : "";
    			$book_13hierarchie->extra = Input::post('extra') ? Input::post('extra') : "";
    
    			if ($book_13hierarchie->save())
    			{
    				Session::set_flash('success', 'Updated book_13hierarchie #' . $id);
    
    				Response::redirect('book/13hierarchie');
    			}
    
    			else
    			{
    				Session::set_flash('error', 'Could not update book_13hierarchie #' . $id);
    			}
    		}
    		else
    		{
    			if (Input::method() == 'POST')
    			{
    				$book_13hierarchie->epid = $val->validated('epid');
    				$book_13hierarchie->belongto = $val->validated('belongto');
    				$book_13hierarchie->relation_type = $val->validated('relation_type');
    				$book_13hierarchie->extra = $val->validated('extra');
    
    				Session::set_flash('error', $val->error());
    			}
    
    			$this->template->set_global('book_13hierarchie', $book_13hierarchie, false);
    		}
		}

		$this->template->title = "Book_13hierarchies";
		$this->template->content = View::forge('book/13hierarchie/edit');

	}

	public function action_delete($id = null)
	{
		if ($book_13hierarchie = Model_Book_13hierarchie::find($id))
		{
			$book_13hierarchie->delete();

			Session::set_flash('success', 'Deleted book_13hierarchie #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete book_13hierarchie #'.$id);
		}

		Response::redirect('book/13hierarchie');

	}


}