<?php
class Controller_Admin_13contactmsgs extends Controller_Season13 
{
    public $template = 'admin/template';

    public function action_index()
	{
		if ( ! Auth::member(100) and Request::active()->action != 'login')
		{
			Response::redirect('404');
		}
		
		$data['admin_13contactmsgs'] = Model_Admin_13contactmsg::find('all');
		$this->template->title = "Admin_13contactmsgs";
		$this->template->content = View::forge('admin/13contactmsgs/index', $data);

	}

	public function action_view($id = null)
	{
	    if ( ! Auth::member(100) and Request::active()->action != 'login')
	    {
	    	Response::redirect('404');
	    }
	
		$data['admin_13contactmsg'] = Model_Admin_13contactmsg::find($id);

		is_null($id) and Response::redirect('Admin_13contactmsgs');

		$this->template->title = "Admin_13contactmsg";
		$this->template->content = View::forge('admin/13contactmsgs/view', $data);

	}

	public function action_send()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Admin_13contactmsg::validate('send');
			
			if ($val->run())
			{
			    if( preg_match('#SPAM#i', Input::post('message')) || preg_match('#SPAM#i', Input::post('title')) ) {
			        Response::redirect('contact');
			    }
			
				$admin_13contactmsg = Model_Admin_13contactmsg::forge(array(
					'nom' => Input::post('nom'),
					'user' => $this->current_user ? $this->current_user->id : 0,
					'email' => Input::post('email'),
					'destination' => "contact@encrenomade.com",
					'title' => Input::post('title'),
					'message' => Input::post('message'),
					'response' => 0,
				));

				if ($admin_13contactmsg and $admin_13contactmsg->save())
				{
				    \Package::load('email');
				    // Create an instance
				    $email = Email::forge();
				    
				    // Set the from address
				    $email->from(Input::post('email'), Input::post('nom'));
				    
				    // Set the to address
				    $email->to('contact@encrenomade.com', 'Season 13');
				    
				    // Set a subject
				    $email->subject(Input::post('title')=="" ? 'Sujet vide' : Input::post('title'));
				    
				    // And set the body.
				    $email->body(Input::post('message'));
				    
				    $fail = false;
				    try
				    {
				        $email->send();
				    }
				    catch(\EmailValidationFailedException $e)
				    {
				        // The validation failed
				        Session::set_flash('error', 'Echec de validation du mail.');
				        $fail = true;
				    }
				    catch(\EmailSendingFailedException $e)
				    {
				        // The driver could not send the email
				        Session::set_flash('error', 'Echec d\'envoie du mail.');
				        $fail = true;
				    }
				    
					if(!$fail) Session::set_flash('success', 'Ton message a été bien envoyé.');
				}

				else
				{
					Session::set_flash('error', 'Désolé, une erreur inconnue s\'est produite, tu peux nous contacter par mail: contact@encrenomade.com .');
				}
			}
			else
			{
				Session::set_flash('error', 'Le formule de message est incomplète ou ton mail est invalide, veuille réessayer.');
			}
		}

        Response::redirect('contact');
	}

	public function action_edit($id = null)
	{
	    Response::redirect('404');
	
		is_null($id) and Response::redirect('Admin_13contactmsgs');

		$admin_13contactmsg = Model_Admin_13contactmsg::find($id);

		$val = Model_Admin_13contactmsg::validate('edit');

		if ($val->run())
		{
			$admin_13contactmsg->nom = Input::post('nom');
			$admin_13contactmsg->user = Input::post('user');
			$admin_13contactmsg->email = Input::post('email');
			$admin_13contactmsg->destination = Input::post('destination');
			$admin_13contactmsg->title = Input::post('title');
			$admin_13contactmsg->message = Input::post('message');
			$admin_13contactmsg->response = Input::post('response');

			if ($admin_13contactmsg->save())
			{
				Session::set_flash('success', 'Updated admin_13contactmsg #' . $id);

				Response::redirect('admin/13contactmsgs');
			}

			else
			{
				Session::set_flash('error', 'Could not update admin_13contactmsg #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$admin_13contactmsg->nom = $val->validated('nom');
				$admin_13contactmsg->user = $val->validated('user');
				$admin_13contactmsg->email = $val->validated('email');
				$admin_13contactmsg->destination = $val->validated('destination');
				$admin_13contactmsg->title = $val->validated('title');
				$admin_13contactmsg->message = $val->validated('message');
				$admin_13contactmsg->response = $val->validated('response');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('admin_13contactmsg', $admin_13contactmsg, false);
		}

		$this->template->title = "Admin_13contactmsgs";
		$this->template->content = View::forge('admin/13contactmsgs/edit');

	}

	public function action_delete($id = null)
	{
	    if ( ! Auth::member(100) and Request::active()->action != 'login')
	    {
	    	Response::redirect('404');
	    }
	
		if ($admin_13contactmsg = Model_Admin_13contactmsg::find($id))
		{
			$admin_13contactmsg->delete();

			Session::set_flash('success', 'Deleted admin_13contactmsg #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete admin_13contactmsg #'.$id);
		}

		Response::redirect('admin/13contactmsgs');

	}


}