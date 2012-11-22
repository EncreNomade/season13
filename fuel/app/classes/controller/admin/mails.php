<?php

class Controller_Admin_Mails extends Controller_Template
{
    private static $other_valid_destination = array('everyone');

    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    	View::set_global('remote_path', Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/');
    	
    	if ( ! Auth::member(100) and Request::active()->action != 'login')
    	{
    		Response::redirect('404');
    	}
    	
    	// Set supplementation css and js file
        $this->template->css_supp = 'mail_index.css';
        $this->template->js_supp = 'mails.js';
    }

	public function action_index()
	{
		$this->template->title = 'Admin mails &raquo; Send';
		$this->template->content = View::forge('admin/mails/index');
	}
	
	
	public function action_send() {
	
	    if (Input::method() == 'POST')
	    {
    	    $val = Validation::forge();
        
            $val->add('mail_template', 'Model d\'email')
                ->add_rule('required');
            $val->add('from', 'Expediteur')
                ->add_rule('required')
                ->add_rule('valid_email');
            $val->add('cc', 'CC')
                ->add_rule('valid_emails');
            $val->add('title', 'Le sujet')
                ->add_rule('required');
            $val->add('image_attach', 'Image attachée')
                ->add_rule('valid_url');
            $val->add('alternatif', 'Alternatif link')
                ->add_rule('valid_url');
            $val->add('message', 'Message')
                ->add_rule('required');
            
            $val->set_message('required', 'Vous devez remplir :label pour envoyer');
            $val->set_message('valid_email', ':label n\'est pas valid');
            $val->set_message('valid_emails', ':label n\'est pas valid, pour envoyer à plusieurs destinateur, sépare avec des virgules');
            $val->set_message('valid_url', 'Lien :label n\'est pas valid');
            
            $toemails = null;
            $other_mail_dest = false;
            if(Input::post('to') != "") {
                $toemails = explode(",", Input::post('to'));
                $other_mail_dest = false;
                if(count($toemails) == 1) {
                    if(in_array($toemails[0], self::$other_valid_destination)) {
                        $other_mail_dest = true;
                    }
                }
                
                if(!$other_mail_dest)
                    $val->add('to', 'Destinateur')
                        ->add_rule('required')
                        ->add_rule('valid_emails');
                else 
                    $val->add('to', 'Destinateur')
                        ->add_rule('required');
            }
            
            if ($val->run())
    		{
    		    // Pretraitement
    		    if($other_mail_dest) {
    		        $toemails = array();
    		        switch (Input::post('to')) {
    		        case 'everyone':
    		            $users = Model_13user::find('all');
    		            foreach ($users as $user) {
    		                array_push($toemails, $user->email);
    		            }
    		            break;
    		        }
    		    }
    		    foreach ($toemails as $id => $mail) {
    		        $toemails[$id] = trim($mail);
    		    }
    		
    		    \Package::load('email');
    		    // Create an instance
    		    $email = Email::forge();
    		    
    		    // Set the from address
    		    $email->from(Input::post('from'), Input::post('SEASON13.com'));
    		    
    		    // Set the to address
    		    $email->to($toemails);
    		    
    		    // Set a subject
    		    $email->subject(Input::post('title'));
    		    
    		    // And set the html body.
    		    $data = array();
    		    if(Input::post('image_attach') != "") $data['img'] = Input::post('image_attach');
    		    if(Input::post('alternatif') != "") $data['link'] = Input::post('alternatif');
    		    $data['subject'] = Input::post('title');
    		    $data['content'] = Input::post('message');
    		    //$data['content'] = str_replace("\n", "<br/>", $data['content']);
    		    
    		    $email->html_body(View::forge('admin/mails/'.Input::post('mail_template'), $data));
    		    
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
    		else {
    		    Session::set_flash('error', $val->error());
    		}
    		
    		$this->template->title = 'Admin mails &raquo; Send';
    		$this->template->content = View::forge('admin/mails/index');
		}
		else {
		    Response::redirect('/admin/mails');
		}
		
	}
	
	public function action_news() {
	    $data['title'] = 'Newsletter';
	    $data['img'] = 'season13/illus/bande4.png';
	    $data['link'] = 'http://season13.com';
	    $data['subject'] = 'What the fuck!';
	    $data['content'] = "What the fuck! What the fuck! What the fuck! What the fuck! What the fuck! What the fuck!";
	    
	    return Response::forge(View::forge('admin/mails/newsletter', $data));
	}

}
