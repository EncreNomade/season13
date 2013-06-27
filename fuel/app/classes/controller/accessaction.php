<?php

class Controller_Accessaction extends Controller_Rest
{

    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	$this->remote_path = Config::get('custom.remote_path');
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    }
    
    public function post_buy_episode() {
        if( Input::post('epid') ) {
            // Set possesion of episode 4
            $admin_13userpossesion = Model_Admin_13userpossesion::forge(array(
				'user_mail' => $this->current_user->email,
				'episode_id' => Input::post('epid'),
				'source' => 5, // offer_nopayment
				'source_ref' => "",
			));

			if ($admin_13userpossesion and $admin_13userpossesion->save())
			{
				$this->response(array('valid' => true), 200);
			}
			else
			{
				$this->response(array('valid' => false, 'errorMessage' => "La mise à jour de profile a échoué"), 200);
			}
        }
    }
    
    public function post_liked() {
        $fields = @unserialize($this->current_user->get('profile_fields'));
        if(!array_key_exists('site_liked', $fields) || !$fields['site_liked']) {
            $fields['site_liked'] = true;
            $this->current_user->profile_fields = serialize($fields);
            $updated = $this->current_user->save();
        }
        
        // Set possesion of episode 4
        $admin_13userpossesion = Model_Admin_13userpossesion::forge(array(
			'user_mail' => $this->current_user->email,
			'episode_id' => 4,
			'source' => 6, // fblike
			'source_ref' => "",
		));

		if ($admin_13userpossesion and $admin_13userpossesion->save())
		{
			$this->response(array('valid' => true), 200);
		}
		else
		{
			$this->response(array('valid' => false, 'errorMessage' => "La mise à jour de profile a échoué"), 200);
		}
    }
    
    public function post_no_like() {
        $fields = @unserialize($this->current_user->get('profile_fields'));
        if(!array_key_exists('site_liked', $fields) || $fields['site_liked']) {
            $fields['site_liked'] = false;
            $this->current_user->profile_fields = serialize($fields);
            $updated = $this->current_user->save();
        }
        
        // Set possesion of episode 4
        $admin_13userpossesion = Model_Admin_13userpossesion::forge(array(
			'user_mail' => $this->current_user->email,
			'episode_id' => 4,
			'source' => 5, // offer_nopayment
			'source_ref' => "",
		));

		if ($admin_13userpossesion and $admin_13userpossesion->save())
		{
			$this->response(array('valid' => true), 200);
		}
		else
		{
			$this->response(array('valid' => false, 'errorMessage' => "La mise à jour d'achat a échoué"), 200);
		}
    }
    
    public function post_no_invitation() {
        if (Input::method() == 'POST')
        {
            $fields = @unserialize($this->current_user->get('profile_fields'));
            if(!array_key_exists('invitation_sent', $fields) || $fields['invitation_sent']) {
                $fields['invitation_sent'] = false;
                $this->current_user->profile_fields = serialize($fields);
                $updated = $this->current_user->save();
            }
            
            // Set possesion of episode 3
            
            $admin_13userpossesion = Model_Admin_13userpossesion::forge(array(
				'user_mail' => $this->current_user->email,
				'episode_id' => 3,
				'source' => 5, // offer_nopayment
				'source_ref' => "",
			));

			if ($admin_13userpossesion and $admin_13userpossesion->save())
			{
				$this->response(array('valid' => true), 200);
			}
			else
			{
				$this->response(array('valid' => false, 'errorMessage' => "La mise à jour d'achat a échoué"), 200);
			}
		}
    }
    
    public function post_invitation_fb() {
        $fields = @unserialize($this->current_user->get('profile_fields'));
        if(!array_key_exists('site_liked', $fields) || !$fields['site_liked']) {
            $fields['invitation_sent'] = true;
            $this->current_user->profile_fields = serialize($fields);
            $updated = $this->current_user->save();
        }
        
        // Set possesion of episode 4
        $admin_13userpossesion = Model_Admin_13userpossesion::forge(array(
			'user_mail' => $this->current_user->email,
			'episode_id' => 3,
			'source' => 2, // fblike
			'source_ref' => "",
		));

		if ($admin_13userpossesion and $admin_13userpossesion->save())
		{
			$this->response(array('valid' => true), 200);
		}
		else
		{
			$this->response(array('valid' => false, 'errorMessage' => "La mise à jour de profile a échoué"), 200);
		}
    }
    
    public function post_invitation_mail() {
        if (Input::method() == 'POST' && Security::check_token())
        {
            $val = Validation::forge();
            
            $val->add('to1', 'Adresse mail d\'ami 1')
                ->add_rule('required')
                ->add_rule('valid_emails');
            $val->add('to2', 'Adresse mail d\'ami 2')
                ->add_rule('required')
                ->add_rule('valid_emails');
            $val->add('to3', 'Adresse mail d\'ami 3')
                ->add_rule('required')
                ->add_rule('valid_emails');
            $val->add('to4', 'Adresse mail d\'ami 4')
                ->add_rule('required')
                ->add_rule('valid_emails');
            $val->add('to5', 'Adresse mail d\'ami 5')
                ->add_rule('required')
                ->add_rule('valid_emails');
            $val->set_message('valid_emails', ':label erronée');
            $val->set_message('required', ':label erronée');
        
            if ($val->run())
    		{
    		    // Mail list
    		    $tomails = array(Input::post('to1'));
    		    for ($i = 2; $i <= 5; $i++) {
    		        $mail = Input::post('to'.$i);
    		        if(in_array($mail, $tomails)) {
    		            $csrfkey = Config::get('security.csrf_token_key');
    		            $csrftoken = Security::fetch_token();
    		            return $this->response(array('valid' => false, 'errorMessage' => "Erreur: il y a plusieurs adresses mails identiques", 'key' => $csrfkey, 'value' => $csrftoken), 200);
    		        }
    		        else array_push($tomails, $mail);
    		    }
    		
    		    // Send mails
    		    \Package::load('email');
    		    // Create an instance
    		    $email = Email::forge();
    		    
    		    // Set the from address
    		    $email->from('no-reply@encrenomade.com', Input::post('from'));
    		    
    		    // Set the to address
    		    $email->to( $tomails );
    		    
    		    // Set a subject
    		    $email->subject('Invitation');
    		    
    		    // And set the html body.
    		    $data = array();
    		    $data['content'] = "Invitation from season13.com";
    		    $data['from'] = Input::post('from');
    		    
    		    $email->html_body(View::forge('admin/mails/invitations', $data));
    		    
    		    $fail = false;
    		    try
    		    {
    		        $email->send();
    		    }
    		    catch(\EmailValidationFailedException $e)
    		    {
    		        // The validation failed
    		        $this->response(array('valid' => false, 'errorMessage' => "Emails ne sont pas valid"), 200);
    		        $fail = true;
    		    }
    		    catch(\EmailSendingFailedException $e)
    		    {
    		        // The driver could not send the email but we don't want to distube our clients
    		        $this->response(array('valid' => true), 200);
    		        $fail = true;
    		    }
    		    
    		    if(!$fail) {
    		        Session::set_flash('success', 'Ton message a été bien envoyé.');
        		
        			$fields = @unserialize($this->current_user->get('profile_fields'));
        			$fields['invitation_sent'] = true;
        			$this->current_user->profile_fields = serialize($fields);
        			$updated = $this->current_user->save();
        			
		            $admin_13userpossesion = Model_Admin_13userpossesion::forge(array(
						'user_mail' => $this->current_user->email,
						'episode_id' => 3,
						'source' => 2, // invitation
						'source_ref' => Format::forge($tomails)->to_json(),
					));
		
					if ($admin_13userpossesion and $admin_13userpossesion->save())
					{
						$this->response(array('valid' => true), 200);
					}
					else
					{
						$this->response(array('valid' => false, 'errorMessage' => "Mise à jour de possesion échoué"), 200);
					}
    			}
    		}
    		else {
    		    $errs = $val->error();
    		    $msg = "";
    		    foreach ($errs as $field => $err) {
    		        $msg .= $err->get_message()."\n";
    		    }
    		    $csrfkey = Config::get('security.csrf_token_key');
    		    $csrftoken = Security::fetch_token();
    		    $this->response(array('valid' => false, 'errorMessage' => $msg, 'key' => $csrfkey, 'value' => $csrftoken), 200);
    		}
        }
    }
    
}