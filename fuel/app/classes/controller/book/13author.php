<?php
class Controller_Book_13author extends Controller_Backend 
{
    public $template = 'admin/template';

	public function action_index()
	{
		$data['book_13authors'] = Model_Book_13author::find('all');
		$this->template->title = "Book_13authors";
		$this->template->content = View::forge('book/13author/index', $data);

	}

	public function action_view($id = null)
	{
		$data['book_13author'] = Model_Book_13author::find($id);

		is_null($id) and Response::redirect('Book_13author');

		$this->template->title = "Book_13author";
		$this->template->content = View::forge('book/13author/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
		    if ( ! \Security::check_token() ) {
		        Session::set_flash('error', 'CSRF token error');
		    }
		    else {
    			$val = Model_Book_13author::validate('create');
    			
    			if ($val->run())
    			{
    				$book_13author = Model_Book_13author::forge(array(
    					'firstname' => Input::post('firstname'),
    					'lastname' => Input::post('lastname'),
    					'nickname' => Input::post('nickname') ? Input::post('nickname') : "",
    					'biographie' => Input::post('biographie'),
    					'photo' => Input::post('photo'),
    					'author_slogan' => Input::post('author_slogan') ? Input::post('author_slogan') : "",
    					'metas' => Input::post('metas') ? Input::post('metas') : "",
    				));
    
    				if ($book_13author and $book_13author->save())
    				{
    					Session::set_flash('success', 'Added book_13author #'.$book_13author->id.'.');
    
    					Response::redirect('book/13author');
    				}
    
    				else
    				{
    					Session::set_flash('error', 'Could not save book_13author.');
    				}
    			}
    			else
    			{
    				Session::set_flash('error', $val->error());
    			}
    		}
		}

		$this->template->title = "Book_13Authors";
		$this->template->content = View::forge('book/13author/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Book_13author');

        if ( Input::method() == 'POST' && ! \Security::check_token() ) {
            Session::set_flash('error', 'CSRF token error');
        }
        else {
    		$book_13author = Model_Book_13author::find($id);
    
    		$val = Model_Book_13author::validate('edit');
    
    		if ($val->run())
    		{
    			$book_13author->firstname = Input::post('firstname');
    			$book_13author->lastname = Input::post('lastname');
    			$book_13author->nickname = Input::post('nickname') ? Input::post('nickname') : "";
    			$book_13author->biographie = Input::post('biographie');
    			$book_13author->photo = Input::post('photo');
    			$book_13author->author_slogan = Input::post('author_slogan') ? Input::post('author_slogan') : "";
    			$book_13author->metas = Input::post('metas') ? Input::post('metas') : "";
    
    			if ($book_13author->save())
    			{
    				Session::set_flash('success', 'Updated book_13author #' . $id);
    
    				Response::redirect('book/13author');
    			}
    
    			else
    			{
    				Session::set_flash('error', 'Could not update book_13author #' . $id);
    			}
    		}
    
    		else
    		{
    			if (Input::method() == 'POST')
    			{
    				$book_13author->firstname = $val->validated('firstname');
    				$book_13author->lastname = $val->validated('lastname');
    				$book_13author->nickname = $val->validated('nickname');
    				$book_13author->biographie = $val->validated('biographie');
    				$book_13author->photo = $val->validated('photo');
    				$book_13author->author_slogan = $val->validated('author_slogan');
    				$book_13author->metas = $val->validated('metas');
    
    				Session::set_flash('error', $val->error());
    			}
    
    			$this->template->set_global('book_13author', $book_13author, false);
    		}
		}

		$this->template->title = "Book_13authors";
		$this->template->content = View::forge('book/13author/edit');

	}

	public function action_delete($id = null)
	{
		if ($book_13author = Model_Book_13author::find($id))
		{
			$book_13author->delete();

			Session::set_flash('success', 'Deleted book_13author #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete book_13author #'.$id);
		}

		Response::redirect('book/13author');

	}


}