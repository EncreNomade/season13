<?php

class Controller_Story extends Controller_Frontend
{
    public $template = 'story/template';
    
    public static function requestAccess($epid, $current_user, $ext = false, $episode = null) {
        $access = array('valid' => true);
        Config::load('errormsgs', true);
        $codes = (array) Config::get('errormsgs.story_access', array ());
        
        if($epid == 1)
            return $access;
            
        if(!$current_user) {
            $form = View::forge('story/access/auth')->render();
            
            if($epid == 2)
                return array('valid' => false, 'errorCode' => 302, 'errorMessage' => $codes[302], 'form' => $form);
            else 
                return array('valid' => false, 'errorCode' => 201, 'errorMessage' => $codes[201], 'form' => $form);
        }
        
        if( $current_user->group >= 10 )
            return $access;
            
        $access = array('valid' => false, 'errorCode' => 103, 'errorMessage' => $codes[103]);
        
        // Permission after first episode
        $existed = Model_Admin_13userpossesion::query()->where(
            array(
                'user_mail' => $current_user->email,
                'episode_id' => $epid
            )
        )->get_one();
        
        if( !is_null($existed) )
            return array('valid' => true);
            
        if($ext !== true) {
            // Check available
            if(is_null($episode)) 
                $episode = Model_Admin_13episode::find($epid);
            if(!$episode->isAvailable()) {
                return array('valid' => false, 'errorCode' => 101, 'errorMessage' => $codes[101]);
            }
            
            switch ($epid) {
            case 2:
                return array('valid' => true);
                break;
            case 3: 
                $data = array();
                $data['pseudo'] = $current_user->pseudo;
                $data['root_path'] = Fuel::$env == Fuel::DEVELOPMENT ? 'localhost:8888/season13/public' : "http://".$_SERVER['HTTP_HOST']."/";
                $data['price'] = "0,99";
                return array(
                    'valid' => false, 
                    'errorCode' => 303, 
                    'errorMessage' => $codes[303], 
                    'form' => View::forge('story/access/invitations', $data)->render()
                );
                break;
            case 4:
                $data = array();
                $data['root_path'] = Fuel::$env == Fuel::DEVELOPMENT ? '' : "http://".$_SERVER['HTTP_HOST']."/";
                $data['price'] = "0,99";
                return array(
                    'valid' => false, 
                    'errorCode' => 304, 
                    'errorMessage' => $codes[304], 
                    'form' => View::forge('story/access/like', $data)->render()
                );
                break;
            default:
                $pdt = $episode->getRelatProduct();
                if($pdt) {
                    $data = array();
                    $data['reference'] = $pdt->reference;
                    $data['price'] = $pdt->getLocalDiscountedPrice();
                    return array(
                        'valid' => false, 
                        'errorCode' => 202, 
                        'errorMessage' => $codes[202],
                        'form' => View::forge('story/access/buy', $data)->render()
                    );
                }
                else return $access;
                break;
            }
        }
        else return array('valid' => false, 'errorCode' => 202, 'errorMessage' => $codes[202]);
    }

	public function action_index($book = null, $season = null, $epid = null)
	{
	    $capable = false;
	    // Check user browser capacity
	    // Process based on the browser name
	    switch (Agent::browser())
	    {
	        case 'Firefox':
	            if(Agent::version() < 3.7)
	                $capable = false;
	            else 
	                $capable = true;
	            break;
	        case 'IE':
	            if(Agent::version() < 9)
	                $capable = false;
	            else 
	                $capable = true;
	            break;
	        case 'Chrome':
	            $capable = true;
	            break;
	        case 'Safari':
	            $capable = true;
	            break;
	        case 'Unknown':
	            $capable = false;
	            break;
	        default:
	            $capable = true;
	            break;
	    }
	
	    if($capable) {
	        $this->episode = null;
	        
	        if(!isset($epid) && Input::get('ep')) $epid = Input::get('ep');
	        
	        if( isset($book) && isset($season) && isset($epid) ) {
	            // Find the episode
	            $this->episode = Model_Admin_13episode::query()->where(
	                array(
    	                'story' => str_replace('_', ' ', $book),
    	                'season' => $season,
    	                'episode' => $epid,
	                )
	            )->get_one();
	            
	            if(is_null($this->episode)) {
	                Response::redirect('404');
	            }
	            else {
    	            View::set_global('episode', $this->episode);
    	            $access = Controller_Story::requestAccess($this->episode->id, $this->current_user, false, $this->episode);
    	            View::set_global('accessible', $access['valid']);
    	            View::set_global('extrait', false);
    	            View::set_global('access', $access);
    	            
    	            if($access['valid'] === true) {
    	        	    $this->comments = Model_Admin_13comment::find_by_epid($this->episode->id);
    	            }
    	            else $this->template->accessfail = $access['errorCode'];
	            }
	            
	            $this->template->title = stripslashes( is_null($this->episode) ? "Episode Indisponible" : $this->episode->title );
	        }
	        else {
	            Response::redirect('404');
	        }
    	}
    	else {
    	    Response::redirect('http://'.$_SERVER['HTTP_HOST'].'upgradenav');
    	}
	}
	
	
	public function action_extrait($book = null, $season = null, $episode = null) {
	    $capable = false;
        // Check user browser capacity
        // Process based on the browser name
        switch (Agent::browser())
        {
            case 'Firefox':
                if(Agent::version() < 3.7)
                    $capable = false;
                else 
                    $capable = true;
                break;
            case 'IE':
                if(Agent::version() < 9)
                    $capable = false;
                else 
                    $capable = true;
                break;
            case 'Chrome':
                $capable = true;
                break;
            case 'Safari':
                $capable = true;
                break;
            case 'Unknown':
                $capable = false;
                break;
            default:
                $capable = true;
                break;
        }
    
        if($capable) {
            $this->episode = null;
            
            if( isset($book) && isset($season) && isset($episode) ) {
                // Find the episode
                $this->episode = Model_Admin_13episode::query()->where(
                    array(
                        'story' => str_replace('_', ' ', $book),
                        'season' => $season,
                        'episode' => $episode,
                    )
                )->get_one();
                
                if(is_null($this->episode)) {
                    Response::redirect('404');
                }
                else {
                    View::set_global('episode', $this->episode);
                    View::set_global('accessible', true);
                    View::set_global('extrait', true);
                    View::set_global('access', array('valid' => true));
                    
                    $this->template->title = stripslashes( $this->episode->title );
                }
            }
            else {
                Response::redirect('404');
            }
        }
        else {
            Response::redirect('http://'.$_SERVER['HTTP_HOST'].'upgradenav');
        }
	}
	
	
	public function action_direct() {
	    $capable = false;
        // Check user browser capacity
        // Process based on the browser name
        switch (Agent::browser())
        {
            case 'Firefox':
                if(Agent::version() < 3.7)
                    $capable = false;
                else 
                    $capable = true;
                break;
            case 'IE':
                if(Agent::version() < 9)
                    $capable = false;
                else 
                    $capable = true;
                break;
            case 'Chrome':
                $capable = true;
                break;
            case 'Safari':
                $capable = true;
                break;
            case 'Unknown':
                $capable = false;
                break;
            default:
                $capable = true;
                break;
        }
    
        if($capable) {
            $this->episode = null;
            
            // Find the episode
            $this->episode = Model_Admin_13episode::find(1);
            
            if(is_null($this->episode)) {
                Response::redirect('404');
            }
            else {
                $data = array(
                    'episode' => $this->episode,
                    'accessible' => true,
                    'extrait' => false,
                    'access' => array('valid' => true),
                    'title' => stripslashes( $this->episode->title )
                );
	            
	            return Response::forge(View::forge('story/pub', $data));
            }
    	}
    	else {
    	    Response::redirect('http://'.$_SERVER['HTTP_HOST'].'upgradenav');
    	}
	}
	
	
	public function action_webservice($book = null, $season = null, $episode = null)
	{
	    $capable = false;
	    // Check user browser capacity
	    // Process based on the browser name
	    switch (Agent::browser())
	    {
	        case 'Firefox':
	            if(Agent::version() < 3.7)
	                $capable = false;
	            else 
	                $capable = true;
	            break;
	        case 'IE':
	            if(Agent::version() < 9)
	                $capable = false;
	            else 
	                $capable = true;
	            break;
	        case 'Chrome':
	            $capable = true;
	            break;
	        case 'Safari':
	            $capable = true;
	            break;
	        case 'Unknown':
	            $capable = false;
	            break;
	        default:
	            $capable = true;
	            break;
	    }
	
	    if($capable) {
	        $this->episode = null;
	        
	        // Check user
	        $mail = Input::param('user');
	        if(is_null($mail)) {
	            Response::redirect('ws404');
	        }
	        $user = Model_13user::find_by_email($mail);
	        if(!is_null($user)) {
	            $auth = Auth::instance();
	            $auth->force_login($user->id);
	            $this->current_user = $user;
	            View::set_global('current_user', $this->current_user);
	        }
	        
	        if( isset($book) && isset($season) && isset($episode) ) {
	            // Check token and token-email association
	            $access_token = Input::param('access_token');
	            if( is_null($access_token) || 
	                !Controller_Webservice_Wsbase::checkAccessToken($access_token, $mail, $book.$season.$episode) ) {
	                Response::redirect('ws404');
	            }
	        
	            $book = str_replace('_', ' ', $book);
	            // Find the episode
	            $this->episode = Model_Admin_13episode::query()->where(
	                array(
		                'story' => $book,
		                'season' => $season,
		                'episode' => $episode,
	                )
	            )->get_one();
	            
	            if(is_null($this->episode)) {
	                Response::redirect('ws404');
	            }
	            else {
	                $data = array(
	                    'title' => $this->episode->title,
	                    'episode' => $this->episode,
	                    'accessible' => true,
	                    'extrait' => false,
	                    'access' => array('valid' => true)
	                );
		            $this->comments = Model_Admin_13comment::find_by_epid($this->episode->id);
		            
		            return new Response(View::forge('story/ws_nolink', $data));
	            }
	        }
	        else {
	            Response::redirect('ws404');
	        }
		}
		else {
		    Response::redirect('http://'.$_SERVER['HTTP_HOST'].'wsupgradenav');
		}
	}
	
	
	
	public function action_wsextrait($book = null, $season = null, $episode = null) {
	    $capable = false;
	    // Check user browser capacity
	    // Process based on the browser name
	    switch (Agent::browser())
	    {
	        case 'Firefox':
	            if(Agent::version() < 3.7)
	                $capable = false;
	            else 
	                $capable = true;
	            break;
	        case 'IE':
	            if(Agent::version() < 9)
	                $capable = false;
	            else 
	                $capable = true;
	            break;
	        case 'Chrome':
	            $capable = true;
	            break;
	        case 'Safari':
	            $capable = true;
	            break;
	        case 'Unknown':
	            $capable = false;
	            break;
	        default:
	            $capable = true;
	            break;
	    }
	
	    if($capable) {
	        $this->episode = null;
	        
	        if( isset($book) && isset($season) && isset($episode) ) {
	            // Find the episode
	            $this->episode = Model_Admin_13episode::query()->where(
	                array(
	                    'story' => str_replace('_', ' ', $book),
	                    'season' => $season,
	                    'episode' => $episode,
	                )
	            )->get_one();
	            
	            if(is_null($this->episode)) {
	                Response::redirect('ws404');
	            }
	            else {
	                $data = array(
	                    'title' => $this->episode->title,
	                    'episode' => $this->episode,
	                    'accessible' => true,
	                    'extrait' => true,
	                    'access' => array('valid' => true)
	                );
	                
	                return new Response(View::forge('story/ws_nolink', $data));
	            }
	        }
	        else {
	            Response::redirect('ws404');
	        }
	    }
	    else {
	        Response::redirect('http://'.$_SERVER['HTTP_HOST'].'wsupgradenav');
	    }
	}
	
	public function action_download() {
	    if( !Input::get('epid') )
	        Response::redirect($this->base_url.'?inscription=true');
	        
	    $episode = Model_Admin_13episode::find(Input::get('epid'));
	    if(!$episode)
	        return Response::redirect('404');
	        
	    $filename = 'S0'.$episode->season.'E0'.$episode->episode.'.pdf';
	    if(file_exists(DOCROOT . 'voodoo/pdf/' . $filename)) {
	        http_response_code(200);
	        
	        File::download(DOCROOT . '/voodoo/pdf/' . $filename, "Voodoo Connection " . $filename, 'application/pdf');
	    }
	    else return Response::redirect('404');
	}
	
	public function action_download404test() {
	    File::download(DOCROOT . '/voodoo/pdf/S01E01.pdf', "Voodoo Connection S01E01.pdf", 'application/pdf');
	}
}