<?php

class Controller_13comments extends Controller_Rest
{

    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    }

    public function get_comment_by_ep() {
        if(is_null($this->current_user)) {
            $this->response(array(
                'success' => false,
                'errorMessage' => 'You have to login'
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
                ),
                'order_by' => array('updated_at' => 'desc'),
                'limit' => $limit,
                'offset' => $offset,
            ));
            
            $res = array();
            foreach ($comments as $comment) {
                $user = Model_13user::find_by_id($comment->user);
                array_push($res, array(
                    'user' => $user->pseudo,
                    'avatar' => $user->avatar,
                    'content' => $comment->content,
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
                'errorMessage' => 'You have to login'
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
    				    'errorMessage' => 'Fail to save the comment'
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
