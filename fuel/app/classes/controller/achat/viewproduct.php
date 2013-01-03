<?php
class Controller_Achat_Viewproduct extends Controller_Template 
{
    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	$this->base_uri = Fuel::$env == Fuel::DEVELOPMENT ? 'localhost:8888/season13/public/' : "http://".$_SERVER['HTTP_HOST']."/";
    	$this->remote_path = Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/';
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    	View::set_global('remote_path', $this->remote_path);
    	View::set_global('base_url', $this->base_uri);
    }

    public function action_webservice($ref) {
        // Check ref
        if(!isset($ref)) {
            Response::redirect('404');
        }
    
        // Check user
        $user = Input::param('user');
        if(is_null($user)) {
            Response::redirect('404');
        }
        // Check token and token-email association
        $access_token = Input::param('access_token');
        if( is_null($access_token) || 
            !Controller_Webservice_Wsbase::checkAccessToken($access_token, $user, $ref) ) {
            Response::redirect('404');
        }
        
        // Check product existance
        $product = Model_Achat_13product::find_by_reference($ref);
        if(is_null($product)) {
            Response::redirect('404');
        }
        
        // Other type of content not supported yet
        if($product->type != 'episode') {
            Response::redirect('404');
        }
        
        // Retrieve content
        $arr = Format::forge($product->content, 'json')->to_array();
        // No content
        if(count($arr) == 0 || !isset($arr[0]))
            Response::redirect('404');
        
        // Single episode product
        if($product->pack == 0) {
            $epid = $arr[0];
            $ep = Model_Admin_13episode::find($epid);
            // Episode not found
            if(is_null($ep))
                Response::redirect('404');
            
            // Params    
            $story = str_replace(' ', '_', $ep->story);
            $result = Controller_Webservice_Wsbase::decryptAccessToken($access_token);
            $access_token = Controller_Webservice_Wsbase::cryptAccessToken($result['email'], $result['appid'], $story.$ep->season.$ep->episode);
            // Redirect to story
            Response::redirect('ws/'.$story.'/season'.$ep->season.'/episode'.$ep->episode.'?user='.$user.'&access_token='.$access_token);
        }
        
        // Package product, show package view
        $eps = array();
        foreach ($arr as $epid) {
            $ep = Model_Admin_13episode::find($epid);
            
            $story = str_replace(' ', '_', $ep->story);
            $result = Controller_Webservice_Wsbase::decryptAccessToken($access_token);
            $token = Controller_Webservice_Wsbase::cryptAccessToken($result['email'], $result['appid'], $story.$ep->season.$ep->episode);
            
            $link = $this->remote_path."ws/".$story."/season".$ep->season."/episode".$ep->episode."?user=".$user."&access_token=".$token;
            
            array_push($eps, array('obj' => $ep, 'link' => $link, 'token' => $token));
        }
        
        $data['product'] = $product;
        $data['episodes'] = $eps;
        $data['user'] = $user;
        $this->template->title = $product->title;
        $this->template->content = View::forge('achat/13product/package', $data);
    }
    
}