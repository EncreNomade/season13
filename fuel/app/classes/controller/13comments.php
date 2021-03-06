<?php

class Controller_13comments extends Controller_Rest
{
    public function get_comment_by_ep() {
        $urlwhitelist = Config::get('custom.ajaxreq_url_white_list');
        $host = Input::server('HTTP_HOST');
        $appwhitelist = Config::get('custom.ajaxreq_app_white_list');
        $app = Input::get('appbundleprefix');
        if( !in_array($host, $urlwhitelist)
            && (!$app || !in_array($app, $appwhitelist)) ) {
            $this->response(array(
                'success' => false,
                'errorMessage' => ''
            ));
        }
        else {
            $epid = Input::get('ep');
            
// Verify access for user to this episode
            
            $offset = Input::get('start');
            $limit = 30;
            
            $comments = Model_Admin_13comment::find('all', array(
                'where' => array(
                    array('epid', $epid),
                    array('verified', 1),
                ),
                'order_by' => array('created_at' => 'desc'),
                'limit' => $limit,
                'offset' => $offset,
            ));
            
            $res = array();
            foreach ($comments as $comment) {
                if($comment->user == 0) {
                    $user = (object) array(
                        'pseudo' => $comment->position,
                        'avatar' => 'http://season13.com/assets/img/season13/avatar_default.png'
                    );
                }
                else $user = Model_13user::find_by_id($comment->user);
                
                array_push($res, array(
                    'user' => $user->pseudo,
                    'avatar' => $user->avatar,
                    'content' => stripslashes($comment->content),
                    'image' => $comment->image,
                    'fbpostid' => $comment->fbpostid,
                    'verified' => $comment->verified,
                    'epid' => $comment->epid,
                    'date' => $comment->updated_at
                ));
            }
            
            $this->response(array(
                'success' => true,
                'comments' => $res
            ));
        }
    }
    
    public function post_comment() {
        if(is_null($this->current_user)) {
            $this->response(array(
                'success' => false,
                'errorMessage' => 'Tu dois te connecter sur SEASON13.com'
            ));
        }
        else {
    
            // Get the Validation instance of the default Fieldset
            $val = Validation::instance();
            $val->add_field('message', 'Message Content', 'required');
            $val->add_field('ep', 'Episode', 'required');
    		
    		if ($val->run())
    		{
    			$admin_13comment = Model_Admin_13comment::forge(array(
    				'user' => $this->current_user->id,
    				'content' => Input::post('message'),
    				'image' => (Input::post('imgUrl') == null ? "" : Input::post('imgUrl')),
    				'fbpostid' => (Input::post('fbID') == null ? "" : Input::post('fbID')),
    				'position' => (Input::post('position') == null ? "" : Input::post('position')),
    				'verified' => 0,
    				'epid' => Input::post('ep'),
    			));
    
    			if ($admin_13comment and $admin_13comment->save())
    			{
    				$this->response(array(
    				    'success' => true,
    				    'posted' => array(
    				        'user' => $this->current_user->pseudo,
    				        'avatar' => $this->current_user->avatar, 
    				        'content' => $admin_13comment->content,
    				        'image' => $admin_13comment->image,
    				        'fbpostid' => $admin_13comment->fbpostid,
    				        'verified' => $admin_13comment->verified,
    				        'epid' => $admin_13comment->epid,
    				        'date' => $admin_13comment->created_at,
    				    )
    				));
    			}
    			else
    			{
    				$this->response(array(
    				    'success' => false,
    				    'errorMessage' => "Echec de publier ton message, réessayer ultérieurement"
    				));
    			}
    		}
    		else
    		{
    		    $this->response(array(
    		        'success' => false,
    		        'error' => $val->error()
    		    ));
    		}
		
		}
	}

}
