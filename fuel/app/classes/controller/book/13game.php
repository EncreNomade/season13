<?php
class Controller_Book_13game extends Controller_Backend 
{
    public $template = 'admin/template';

	public function action_index()
	{
		$data['book_13games'] = Model_Book_13game::find('all');
		$this->template->title = "Book_13games";
		$this->template->content = View::forge('book/13game/index', $data);

	}

	public function action_view($id = null)
	{
		$data['book_13game'] = Model_Book_13game::find($id);

		is_null($id) and Response::redirect('Book_13game');

		$this->template->title = "Book_13game";
		$this->template->content = View::forge('book/13game/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
		    if ( ! \Security::check_token() ) {
		        Session::set_flash('error', 'CSRF token error');
		    }
		    else {
    			$val = Model_Book_13game::validate('create');
    			
    			if ($val->run())
    			{
    				$book_13game = Model_Book_13game::forge(array(
    					'name' => Input::post('name'),
    					'epid' => Input::post('epid'),
    					'class_name' => Input::post('class_name'),
    					'expo' => Input::post('expo'),
    					'instruction' => Input::post('instruction') ? Input::post('instruction') : "",
    					'presentation' => Input::post('presentation') ? Input::post('presentation') : "",
    					'independant' => Input::post('idependant') ? Input::post('idependant') : 0,
    					'categories' => Input::post('categories') ? Input::post('categories') : "",
    					'path' => Input::post('path'),
    					'file_name' => Input::post('file_name'),
    					'metas' => Input::post('metas') ? Input::post('metas') : "",
    				));
    
    				if ($book_13game and $book_13game->save())
    				{
    					Session::set_flash('success', 'Added book_13game #'.$book_13game->id.'.');
    
    					Response::redirect('book/13game');
    				}
    
    				else
    				{
    					Session::set_flash('error', 'Could not save book_13game.');
    				}
    			}
    			else
    			{
    				Session::set_flash('error', $val->error());
    			}
    		}
		}

		$this->template->title = "Book_13Games";
		$this->template->content = View::forge('book/13game/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Book_13game');
        
        if ( Input::method() == 'POST' && ! \Security::check_token() ) {
            Session::set_flash('error', 'CSRF token error');
        }
        else {
    		$book_13game = Model_Book_13game::find($id);
    
    		$val = Model_Book_13game::validate('edit');
    
    		if ($val->run())
    		{
    			$book_13game->name = Input::post('name');
    			$book_13game->epid = Input::post('epid');
    			$book_13game->class_name = Input::post('class_name');
    			$book_13game->expo = Input::post('expo');
    			$book_13game->instruction = Input::post('instruction') ? Input::post('instruction') : "";
    			$book_13game->presentation = Input::post('presentation') ? Input::post('presentation') : "";
    			$book_13game->indenpendant = Input::post('indenpendant');
    			$book_13game->categories = Input::post('categories') ? Input::post('categories') : "";
    			$book_13game->path = Input::post('path');
    			$book_13game->file_name = Input::post('file_name');
    			$book_13game->metas = Input::post('metas') ? Input::post('metas') : "";
    
    			if ($book_13game->save())
    			{
    				Session::set_flash('success', 'Updated book_13game #' . $id);
    
    				Response::redirect('book/13game');
    			}
    
    			else
    			{
    				Session::set_flash('error', 'Could not update book_13game #' . $id);
    			}
    		}
    
    		else
    		{
    			if (Input::method() == 'POST')
    			{
    				$book_13game->name = $val->validated('name');
    				$book_13game->epid = $val->validated('epid');
    				$book_13game->class_name = $val->validated('class_name');
    				$book_13game->expo = $val->validated('expo');
    				$book_13game->instruction = $val->validated('instruction');
    				$book_13game->presentation = $val->validated('presentation');
    				$book_13game->indenpendant = $val->validated('indenpendant');
    				$book_13game->categories = $val->validated('categories');
    				$book_13game->path = $val->validated('path');
    				$book_13game->file_name = $val->validated('file_name');
    				$book_13game->metas = $val->validated('metas');
    
    				Session::set_flash('error', $val->error());
    			}
    
    			$this->template->set_global('book_13game', $book_13game, false);
    		}
		}

		$this->template->title = "Book_13games";
		$this->template->content = View::forge('book/13game/edit');

	}

	public function action_delete($id = null)
	{
		if ($book_13game = Model_Book_13game::find($id))
		{
			$book_13game->delete();

			Session::set_flash('success', 'Deleted book_13game #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete book_13game #'.$id);
		}

		Response::redirect('book/13game');

	}


}