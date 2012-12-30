<?php

class Controller_Story extends Controller_Template
{
    public $template = 'story/template';
    
    public static function requestAccess($epid, $current_user, $ext = false) {
        $access = array('valid' => true);
        Config::load('errormsgs', true);
        $codes = (array) Config::get('errormsgs.story_access', array ());
        
        if($epid == 1)
            return $access;
            
        if(!$current_user) 
            return array('valid' => false, 'errorCode' => 201, 'errorMessage' => $codes[201]);
            
        if( $current_user->group >= 10 )
            return $access;
            
        $access = array('valid' => false, 'errorCode' => 103, 'errorMessage' => $codes[103]);
        
        // Permission after first episode
        $result = DB::select('*')->from('admin_13userpossesions')
                                 ->where('user_id', $current_user->id)
                                 ->and_where('episode_id', $epid)
                                 ->execute();
        $num_rows = count($result);
        
        if($num_rows !== 0)
            return array('valid' => true);
            
        if($ext !== true) {
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
            case 5:
                return array('valid' => false, 'errorCode' => 202, 'errorMessage' => $codes[202]);
                break;
            case 6:
                return array('valid' => false, 'errorCode' => 202, 'errorMessage' => $codes[202]);
                break;
            default: return $access;
            }
        }
        else return array('valid' => false, 'errorCode' => 202, 'errorMessage' => $codes[202]);
    }
    
    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    	View::set_global('remote_path', Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/');
    	View::set_global('base_uri', Fuel::$env == Fuel::DEVELOPMENT ? 'http://localhost:8888/season13/public/' : 'http://'.$_SERVER['HTTP_HOST'].'/');
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
    	            $access = Controller_Story::requestAccess($this->episode->id, $this->current_user);
    	            View::set_global('accessible', $access['valid']);
    	            View::set_global('access', $access);
    	            
    	            if($access['valid'] === true) {
    	        	    $this->comments = Model_Admin_13comment::find_by_epid($this->episode->id);
    	            }
    	            else $this->template->accessfail = $access['errorCode'];
	            }
	        }
	        else {
	            Response::redirect('404');
	        }
	    
    	    $this->template->title = stripslashes( is_null($this->episode) ? "Episode Indisponible" : $this->episode->title );
    	}
    	else {
    	    Response::redirect('http://season13.com/upgradenav');
    	}
	}
	
	
	
	
	public function action_webservice($book = null, $season = null, $epid = null)
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
	            Response::redirect('404');
	        }
	        // Check token
	        $access_token = Input::param('access_token');
	        if(is_null($access_token)) {
	            Response::redirect('404');
	        }
	        
	        // Check token association
	        $tokenstr = Crypt::decode($access_token);
	        preg_match(Controller_Webservice_Wsbase::$access_token_ptn, $tokenstr, $result);
	        
	        $tokenverified = false;
	        if( array_key_exists('time', $result) && 
	            array_key_exists('email', $result) && 
	            array_key_exists('appid', $result) ) {
	            // Pattern match success
	            if($result['email'] == $mail) {
	                // Token user associated
	                $tokenverified = true;
	            }
	        }
	        
	        // Not associated or pattern match fail
	        if(!$tokenverified) {
	            Response::redirect('404');
	        }
	        
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
		            
		            $access = array('valid' => true);
		            View::set_global('accessible', $access['valid']);
		            View::set_global('access', $access);
		            $this->comments = Model_Admin_13comment::find_by_epid($this->episode->id);
	            }
	        }
	        else {
	            Response::redirect('404');
	        }
	    
		    $this->template->title = stripslashes( is_null($this->episode) ? "Episode Indisponible" : $this->episode->title );
		}
		else {
		    Response::redirect('http://'.$_SERVER['HTTP_HOST'].'/upgradenav');
		}
	}
}