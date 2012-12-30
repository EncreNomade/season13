<?php

class Controller_Webservice_Wsbase extends Controller_Rest
{
    public static $access_token_ptn = "/(?P<time>\d+)\+\^\_\^\+(?P<email>\S+)\+\^\_\^\+(?P<appid>\w+)/";

    public static function checkAppAccess($action, $method, $msgs = null) {
        if(is_null($msgs)) {
            Config::load('errormsgs', true);
            $msgs = (array) Config::get('errormsgs.webservice', array ());
        }
        
        // Check app access
        // Get time stamp
        $microtime = Input::param('microtime');
        if(is_null($microtime)) {
            return array('success' => false, 'errorCode' => 3003, 'errorMessage' => $msgs[3003]);
        }
        // Get App
        $appid = Input::param('appid');
        if(is_null($appid)) {
            return array('success' => false, 'errorCode' => 3001, 'errorMessage' => $msgs[3001]);
        }
        $app = Model_Webservice_Plateformapp::find_by_appid($appid);
        if(is_null($app)) {
            return array('success' => false, 'errorCode' => 3001, 'errorMessage' => $msgs[3001]);
        }
        // Get Token
        $token = Input::param('token');
        if(is_null($token)) {
            return array('success' => false, 'errorCode' => 3002, 'errorMessage' => $msgs[3002]);
        }
        
        // Check access token
        $tokenvalue = md5($app->appid.$app->appsecret.$microtime);
        if($token != $tokenvalue) {
            return array('success' => false, 'errorCode' => 3002, 'errorMessage' => $msgs[3002]);
        }
        
        // Check action accessibility
        $permission = Model_Webservice_Appermission::query()->where(
            array(
                'appid' => $app->appid,
                'action' => $action
            )
        )->get_one();
        
        if(is_null($permission)) {
            return array('success' => false, 'errorCode' => 3004, 'errorMessage' => $msgs[3004]);
        }
        
        $accessible = false;
        switch (strtolower($method)) {
        case "post":
            if($permission->can_post) $accessible = true;
            break;
        case "get":
            if($permission->can_get) $accessible = true;
            break;
        }
        
        if(!$accessible) {
            return array('success' => false, 'errorCode' => 3004, 'errorMessage' => $msgs[3004]);
        }
        else {
            return array('success' => true, 'app' => $app);
        }
    }

    public function before()
    {
    	parent::before();
    	
    	
    }
    
    public function post_order() {
        Config::load('errormsgs', true);
        $msgs = (array) Config::get('errormsgs.webservice', array ());
    
        // App authentification
        $access = self::checkAppAccess("order", "post", $msgs);
        if(!is_array($access))
            return $this->response(array('success' => false, 'errorCode' => 3999, 'errorMessage' => $msgs[3999]), 200);
        else if($access['success'] == false)
            return $this->response($access, 200);
        else $app = $access['app'];
        
        // The request record
        $record = Model_Webservice_Requestrecord::forge(array(
        	'appid' => $app->appid,
        	'service_requested' => "order",
        	'params' => json_encode(Input::post()),
        	'token' => Input::post('token'),
        	'extra' => "",
        ));
        $record and $record->save();
        
        $val = Model_Achat_13extorder::validate('create');
		
		if ($val->run())
		{	
		    $user = Model_13user::find_by_email(Input::post('owner'));
		    if(is_null($user)) {
		        return $this->response(array('success' => false, 'errorCode' => 3101, 'errorMessage' => $msgs[3101]), 200);
		    }
		    $product = Model_Achat_13product::find_by_reference(Input::post('reference'));
		    if(is_null($product)) {
		        return $this->response(array('success' => false, 'errorCode' => 3102, 'errorMessage' => $msgs[3102]), 200);
		    }
		    if(!Str::is_json($product->content)) {
		        return $this->response(array('success' => false, 'errorCode' => 3105, 'errorMessage' => $msgs[3105]), 200);
		    }
		    
		    $achat_13extorder = Model_Achat_13extorder::forge(array(
				'reference' => Input::post('reference'),
				'owner' => Input::post('owner'),
				'order_source' => Input::post('order_source') ? Input::post('order_source') : "",
				'appid' => $app->appid,
				'price' => Input::post('price'),
				'app_name' => $app->appname,
			));

			if ($achat_13extorder and $achat_13extorder->save())
			{
				// Update user possesion
                $eps = json_decode($product->content);
                
                $fails = array();
                foreach ($eps as $episode) {
                    $existed = Model_Admin_13userpossesion::query()->where(
                        array(
                            'user_id' => $user->id,
                            'episode_id' => $episode
                        )
                    )->get_one();
				
				    if(is_null($existed)) {
		                $userpossesion = Model_Admin_13userpossesion::forge(array(
							'user_id' => $user->id,
							'episode_id' => $episode,
							'source' => 7, // 7 means external order
						));
		
						if ($userpossesion and $userpossesion->save())
						{
							;
						}
						else {
						    array_push($fails, $episode);
						}
				    }
				}
				
				// Successfully set the user possesion
				if(count($fails) == 0) {
				    $record->extra = json_encode(array('success' => true));
				    $record->save();
				    return $this->response(array('success' => true, 'order_id' => $achat_13extorder->id), 200);
				}
				else {
				    $record->extra = json_encode(array('success' => false, 'episode_fails' => json_encode($fails)));
				    $record->save();
				    return $this->response(array('success' => false, 'errorCode' => 3106, 'errorMessage' => $msgs[3106], 'fails_count' => count($fails)), 200);
				}
			}

			else
			{
				return $this->response(array('success' => false, 'errorCode' => 3103, 'errorMessage' => $msgs[3103]), 200);
			}
		}
		else
		{
			return $this->response(array('success' => false, 'errorCode' => 3104, 'errorMessage' => $msgs[3104]), 200);
		}
    }
    
    public function get_order() {
        Config::load('errormsgs', true);
        $msgs = (array) Config::get('errormsgs.webservice', array ());
    
        // App authentification
        $access = self::checkAppAccess("order", "get", $msgs);
        if(!is_array($access))
            return $this->response(array('success' => false, 'errorCode' => 3999, 'errorMessage' => $msgs[3999]), 200);
        else if($access['success'] == false)
            return $this->response($access, 200);
        else $app = $access['app'];
        
        $order_id = Input::get('order_id');
        if(is_null($order_id)) {
            return $this->response(array('success' => false, 'errorCode' => 3107, 'errorMessage' => $msgs[3107]), 200);
        }
        
        $order = Model_Achat_13extorder::find($order_id);
        if(is_null($order)) {
            return $this->response(array('success' => false, 'errorCode' => 3108, 'errorMessage' => $msgs[3108]), 200);
        }
        if($order->appid != $app->appid) {
            return $this->response(array('success' => false, 'errorCode' => 3109, 'errorMessage' => $msgs[3109]), 200);
        }
        
        return $this->response(array(
            'success' => true, 
            'order' => array(
                'id' => $order->id,
                'reference' => $order->reference,
                'owner' => $order->owner,
                'order_source' => $order->order_source,
                'appid' => $order->appid,
                'price' => $order->price,
                'datetime' => $order->created_at
            )
        ), 200);
    }
    
    
    
    public function get_product() {
        Config::load('errormsgs', true);
        $msgs = (array) Config::get('errormsgs.webservice', array ());
    
        // App authentification
        $access = self::checkAppAccess("product", "get", $msgs);
        if(!is_array($access))
            return $this->response(array('success' => false, 'errorCode' => 3999, 'errorMessage' => $msgs[3999]), 200);
        else if($access['success'] == false)
            return $this->response($access, 200);
        else $app = $access['app'];
        
        $reference = Input::get('reference');
        if(is_null($reference)) {
            return $this->response(array('success' => false, 'errorCode' => 3201, 'errorMessage' => $msgs[3201]), 200);
        }
        
        $product = Model_Achat_13product::find_by_reference($reference);
        if(is_null($product)) {
            return $this->response(array('success' => false, 'errorCode' => 3202, 'errorMessage' => $msgs[3202]), 200);
        }
        
        return $this->response(array(
            'success' => true, 
            'product' => array(
                'reference' => $product->reference,
                'type' => $product->type,
                'pack' => $product->pack == 0 ? false : true,
                'content' => $product->content,
                'presentation' => $product->presentation,
                'title' => $product->title
            )
        ), 200);
    }
    
    
    public function get_episode_for_user() {
        Config::load('errormsgs', true);
        $msgs = (array) Config::get('errormsgs.webservice', array ());
    
        // App authentification
        $access = self::checkAppAccess("episode_for_user", "get", $msgs);
        if(!is_array($access))
            return $this->response(array('success' => false, 'errorCode' => 3999, 'errorMessage' => $msgs[3999]), 200);
        else if($access['success'] == false)
            return $this->response($access, 200);
        else $app = $access['app'];
        
        $mail = Input::get('user');
        if(is_null($mail)) {
            return $this->response(array('success' => false, 'errorCode' => 3301, 'errorMessage' => $msgs[3301]), 200);
        }
        $user = Model_13user::find_by_email($mail);
        if(is_null($user)) {
            return $this->response(array('success' => false, 'errorCode' => 3303, 'errorMessage' => $msgs[3303]), 200);
        }
        
        $epid = Input::get('epid');
        if(is_null($epid)) {
            return $this->response(array('success' => false, 'errorCode' => 3302, 'errorMessage' => $msgs[3302]), 200);
        }
        $ep = Model_Admin_13episode::find($epid);
        if(is_null($ep)) {
            return $this->response(array('success' => false, 'errorCode' => 3304, 'errorMessage' => $msgs[3304]), 200);
        }
        
        $access = Controller_Story::requestAccess($epid, $user, true);
        $access['success'] = $access['valid'];
        unset($access['valid']);
        // Send access token
        if($access['success']) {
            $accesstoken = Crypt::encode(time()."+^_^+".$mail."+^_^+".$app->appid);
            $access['access_token'] = $accesstoken;
        }
        return $this->response($access, 200);
    }
    
    public function get_episode_sav() {
        Config::load('errormsgs', true);
        $msgs = (array) Config::get('errormsgs.webservice', array ());
    
        // App authentification
        $access = self::checkAppAccess("episode_sav", "get", $msgs);
        if(!is_array($access))
            return $this->response(array('success' => false, 'errorCode' => 3999, 'errorMessage' => $msgs[3999]), 200);
        else if($access['success'] == false)
            return $this->response($access, 200);
        else $app = $access['app'];
        
        $epid = Input::get('epid');
        if(is_null($epid)) {
            return $this->response(array('success' => false, 'errorCode' => 3302, 'errorMessage' => $msgs[3302]), 200);
        }
        $ep = Model_Admin_13episode::find($epid);
        if(is_null($ep)) {
            return $this->response(array('success' => false, 'errorCode' => 3304, 'errorMessage' => $msgs[3304]), 200);
        }
        
        $access['success'] = array('success' => true);
        // Send access token
        if($access['success']) {
            $accesstoken = Crypt::encode(time()."+^_^+SAV+^_^+".$app->appid);
            $access['access_token'] = $accesstoken;
        }
        return $this->response($access, 200);
    }
	
}