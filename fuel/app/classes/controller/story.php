<?php

class Controller_Story extends Controller_Template
{
    public $template = 'story/template';
    
    public static function requestAccess($epid, $current_user) {
        $access = array('valid' => true);
        Config::load('errormsgs', true);
        $codes = (array) Config::get('errormsgs.story_access', array ());
        
        if($epid == 1)
            return $access;
            
        if( Auth::member(50) || Auth::member(100) )
            return $access;
            
        // Inscription after first episode
        if($epid >= 2) {
            if(!Auth::check()) return array('valid' => false, 'errorCode' => 201, 'errorMessage' => $codes[201]);
            
            switch ($epid) {
            case 3: 
                $result = DB::select('*')->from('admin_13userpossesions')
                                         ->where('user_id', $current_user->id)
                                         ->and_where('episode_id', $epid)
                                         ->execute();
                $num_rows = count($result);
                
                if($num_rows !== 0)
                    return $access;
                else {
                    $data = array();
                    $data['pseudo'] = $current_user->pseudo;
                    $data['root_path'] = Fuel::$env == Fuel::DEVELOPMENT ? '' : 'http://season13.com/';
                    $data['price'] = "0,99";
                    return array(
                        'valid' => false, 
                        'errorCode' => 303, 
                        'errorMessage' => $codes[303], 
                        'form' => View::forge('story/access/invitations', $data)->render()
                    );
                }
                break;
            default: return $access;
            }
        }
        else return $access;
    }
    
    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    	View::set_global('remote_path', Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/');
    	
    	$this->episode = null;
    	$epid = Input::get('ep') ? Input::get('ep') : null;
    	
    	if(!is_null($epid)) {
    	    $access = self::requestAccess($epid, $this->current_user);
    	    
    	    if($access['valid'] === true) {
        	    $this->episode = Model_Admin_13episode::find($epid);
        	    $this->comments = Model_Admin_13comment::find_by_epid($epid);
        	    
        	    View::set_global('episode', $this->episode);
    	    }
    	    else $this->template->accessfail = $access['errorCode'];
    	}
    	else {
    	    $this->template->accessfail = 101;
    	}
    }

	public function action_index()
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
    	    $this->template->title = stripslashes( is_null($this->episode) ? "Episode Indisponible" : $this->episode->title );
    	}
    	else {
    	    Response::redirect('http://season13.com/upgradenav');
    	}
	}
}