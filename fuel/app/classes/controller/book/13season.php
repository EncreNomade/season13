<?php
class Controller_Book_13season extends Controller_Template 
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
		$data['book_13seasons'] = Model_Book_13season::find('all');
		$this->template->title = "Book_13seasons";
		$this->template->content = View::forge('book/13season/index', $data);

	}

	public function action_view($id = null)
	{
		$data['book_13season'] = Model_Book_13season::find($id);

		is_null($id) and Response::redirect('Book_13season');

		$this->template->title = "Book_13season";
		$this->template->content = View::forge('book/13season/view', $data);

	}

	public function action_create()
	{
	    if (Input::method() == 'POST')
	    {
            if ( ! \Security::check_token() ) {
                Session::set_flash('error', 'CSRF token error');
            }
            else {
    			$val = Model_Book_13season::validate('create');
    			
    			if ($val->run())
    			{
    				$book_13season = Model_Book_13season::forge(array(
    					'reference' => Input::post('reference') ? Input::post('reference') : "",
    					'book_id' => Input::post('book_id'),
    					'season_id' => Input::post('season_id'),
    					'title' => Input::post('title'),
    					'cover' => Input::post('cover'),
    					'extra_info' => Input::post('extra_info') ? Input::post('extra_info') : "",
    				));
    
    				if ($book_13season and $book_13season->save())
    				{
    					Session::set_flash('success', 'Added book_13season #'.$book_13season->id.'.');
    
    					Response::redirect('book/13season');
    				}
    
    				else
    				{
    					Session::set_flash('error', 'Could not save book_13season.');
    				}
    			}
    			else
    			{
    				Session::set_flash('error', $val->error());
    			}
    		}
		}

		$this->template->title = "Book_13Seasons";
		$this->template->content = View::forge('book/13season/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Book_13season');
		
		if ( Input::method() == 'POST' && ! \Security::check_token() ) {
		    Session::set_flash('error', 'CSRF token error');
		}
		else {
    		$book_13season = Model_Book_13season::find($id);
    
    		$val = Model_Book_13season::validate('edit');
    
    		if ($val->run())
    		{
    			$book_13season->reference = Input::post('reference') ? Input::post('reference') : "";
    			$book_13season->book_id = Input::post('book_id');
    			$book_13season->season_id = Input::post('season_id');
    			$book_13season->title = Input::post('title');
    			$book_13season->cover = Input::post('cover');
    			$book_13season->extra_info = Input::post('extra_info') ? Input::post('extra_info') : "";
    
    			if ($book_13season->save())
    			{
    				Session::set_flash('success', 'Updated book_13season #' . $id);
    
    				Response::redirect('book/13season');
    			}
    
    			else
    			{
    				Session::set_flash('error', 'Could not update book_13season #' . $id);
    			}
    		}
    
    		else
    		{
    			if (Input::method() == 'POST')
    			{
    				$book_13season->reference = $val->validated('reference');
    				$book_13season->book_id = $val->validated('book_id');
    				$book_13season->season_id = $val->validated('season_id');
    				$book_13season->title = $val->validated('title');
    				$book_13season->cover = $val->validated('cover');
    				$book_13season->extra_info = $val->validated('extra_info');
    
    				Session::set_flash('error', $val->error());
    			}
    
    			$this->template->set_global('book_13season', $book_13season, false);
    		}
		}

		$this->template->title = "Book_13seasons";
		$this->template->content = View::forge('book/13season/edit');

	}

	public function action_delete($id = null)
	{
		if ($book_13season = Model_Book_13season::find($id))
		{
			$book_13season->delete();

			Session::set_flash('success', 'Deleted book_13season #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete book_13season #'.$id);
		}

		Response::redirect('book/13season');

	}


}