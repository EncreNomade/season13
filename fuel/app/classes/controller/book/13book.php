<?php
class Controller_Book_13book extends Controller_Backend 
{
    public $template = 'admin/template';
    
	public function action_index()
	{
		$data['book_13books'] = Model_Book_13book::find('all');
		$this->template->title = "Book_13books";
		$this->template->content = View::forge('book/13book/index', $data);

	}

	public function action_view($id = null)
	{
		$data['book_13book'] = Model_Book_13book::find($id);

		is_null($id) and Response::redirect('Book_13book');

		$this->template->title = "Book_13book";
		$this->template->content = View::forge('book/13book/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
		    if ( ! \Security::check_token() ) {
		        Session::set_flash('error', 'CSRF token error');
		    }
		    else {
    			$val = Model_Book_13book::validate('create');
    			
    			if ($val->run())
    			{
    				$book_13book = Model_Book_13book::forge(array(
    					'reference' => Input::post('reference'),
    					'title' => Input::post('title'),
    					'sub_title' => Input::post('sub_title') ? Input::post('sub_title') : "",
    					'cover' => Input::post('cover'),
    					'author_id' => Input::post('author_id'),
    					'brief' => Input::post('brief') ? Input::post('brief') : "",
    					'tags' => Input::post('tags') ? Input::post('tags') : "",
    					'categories' => Input::post('categories') ? Input::post('categories') : "",
    					'extra_info' => Input::post('extra_info') ? Input::post('extra_info') : "",
    				));
    
    				if ($book_13book and $book_13book->save())
    				{
    					Session::set_flash('success', 'Added book_13book #'.$book_13book->id.'.');
    
    					Response::redirect('book/13book');
    				}
    
    				else
    				{
    					Session::set_flash('error', 'Could not save book_13book.');
    				}
    			}
    			else
    			{
    				Session::set_flash('error', $val->error());
    			}
    		}
		}

		$this->template->title = "Book_13Books";
		$this->template->content = View::forge('book/13book/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Book_13book');

        if ( Input::method() == 'POST' && ! \Security::check_token() ) {
            Session::set_flash('error', 'CSRF token error');
        }
        else {
    		$book_13book = Model_Book_13book::find($id);
    
    		$val = Model_Book_13book::validate('edit');
    
    		if ($val->run())
    		{
    			$book_13book->reference = Input::post('reference');
    			$book_13book->title = Input::post('title');
    			$book_13book->sub_title = Input::post('sub_title') ? Input::post('sub_title') : "";
    			$book_13book->cover = Input::post('cover');
    			$book_13book->author_id = Input::post('author_id');
    			$book_13book->brief = Input::post('brief') ? Input::post('brief') : "";
    			$book_13book->tags = Input::post('tags') ? Input::post('tags') : "";
    			$book_13book->categories = Input::post('categories') ? Input::post('categories') : "";
    			$book_13book->extra_info = Input::post('extra_info') ? Input::post('extra_info') : "";
    
    			if ($book_13book->save())
    			{
    				Session::set_flash('success', 'Updated book_13book #' . $id);
    
    				Response::redirect('book/13book');
    			}
    
    			else
    			{
    				Session::set_flash('error', 'Could not update book_13book #' . $id);
    			}
    		}
    
    		else
    		{
    			if (Input::method() == 'POST')
    			{
    				$book_13book->reference = $val->validated('reference');
    				$book_13book->title = $val->validated('title');
    				$book_13book->sub_title = $val->validated('sub_title');
    				$book_13book->cover = $val->validated('cover');
    				$book_13book->author_id = $val->validated('author_id');
    				$book_13book->brief = $val->validated('brief');
    				$book_13book->tags = $val->validated('tags');
    				$book_13book->categories = $val->validated('categories');
    				$book_13book->extra_info = $val->validated('extra_info');
    
    				Session::set_flash('error', $val->error());
    			}
    
    			$this->template->set_global('book_13book', $book_13book, false);
    		}
		}

		$this->template->title = "Book_13books";
		$this->template->content = View::forge('book/13book/edit');

	}

	public function action_delete($id = null)
	{
		if ($book_13book = Model_Book_13book::find($id))
		{
			$book_13book->delete();

			Session::set_flash('success', 'Deleted book_13book #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete book_13book #'.$id);
		}

		Response::redirect('book/13book');

	}


}