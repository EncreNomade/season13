<?php

class Controller_Upload extends Controller_Rest
{
    private static $img_ext_whitelist = array('jpg','jpeg','png','tiff','bmp','gif');

    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    }
    
    private static function site_root() {
        return 'http://'.$_SERVER['SERVER_NAME'].(Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/');
    }
    
    private static function saveBase64Src($name, $encodedStr, $path, $ext_whitelist = false) {
        // Pattern regexp for get type, extension, codage of file
        $pattern = "/data:\s*(?P<type>\w+)\/(?P<ext>\w+);\s*(?P<codage>\w+),/";
        preg_match($pattern, $encodedStr, $res);
        // Data of Base64 coded content
        $pos = strrpos($encodedStr,',');
        if($pos !== false) $res['data'] = substr($encodedStr, $pos+1);
        else return false;
        // Type of file
        $type = $res['type'];
        if($type != 'image' && $type != 'audio' && $type != 'game') return false;
        // Extension check
        if( $ext_whitelist && !in_array($res['ext'], $ext_whitelist) ) return false;
        // Add extension to filename
        $filename = $name.'.'.$res['ext'];
    
        // Decode data
        if($res['codage'] == 'base64') {
            $temp = str_replace(' ','+',$res['data']);
            $content = base64_decode($temp);
        }
        
        if($content) {
            $success = false;
            try {
                $success = File::create($path, $filename, $content);
            }
            catch (Exception $exception) {
                return false;
            }
            
            if($success) 
                return $filename;
            else return false;
        }
        else
            return false;
    }
    
    public static function saveUploadImage($savepath, $userid, $id, $access=1) {
        Config::load('errormsgs', true);
        $codes = (array) Config::get('errormsgs.upload', array ());
    
        // Custom configuration for this upload
        $config = array(
        	'path' => DOCROOT.$savepath,
        	'prefix' => $userid.'_',
        	'randomize' => true,
        	'max_size' => 512000,
        	'ext_whitelist' => self::$img_ext_whitelist,
        );
        
        // process the uploaded files in $_FILES
        Upload::process($config);
        
        // if there are any valid files
        if (Upload::is_valid())
        {
        	// save them according to the config
        	Upload::save(0);
        	
        	$uploaded = Upload::get_files($id);
        	
        	if( !$uploaded ) {
        	    return array(
        	        'success' => false,
        	        'errorCode' => 1101,
        	        'errorMessage' => $codes[1101]
        	    );
        	}
        	else {
        	    $fullpath = Controller_Upload::site_root().$savepath.DS.$uploaded['saved_as'];
            	// call a model method to update the database
            	$uploadRecord = Model_Upload::forge(array(
            		'created_by' => $userid,
            		'type' => 'img',
            		'path' => $fullpath,
            		'access' => $access
            	));
            	
            	if($uploadRecord and $uploadRecord->save()) {
            	    return array(
                        'success' => true,
                        'path' => $fullpath
                    );
            	}
            	else {
            	    return array(
            	        'success' => false,
            	        'errorCode' => 1201,
            	        'errorMessage' => $codes[1201]
            	    );
            	}
        	}
        }
        else {
        	// and process any errors
        	// $file is an array with all file information,
        	// $file['errors'] contains an array of all error occurred
        	// each array element is an an array containing 'error' and 'message'
        	foreach(Upload::get_errors() as $file) {
        	    return array(
        	        'success' => false,
        	        'errorCode' => $file['error'],
        	        'errorMessage' => $file['message']
        	    );
        	}
        	
    	    return array(
    	        'success' => false,
    	        'errorCode' => 1101,
    	        'errorMessage' => $codes[1101]
    	    );
        }
    }

	public function post_create_img($id = null)
	{
	    if(is_null($this->current_user)) {
	        $this->response(array(
	            'success' => false,
	            'errorMessage' => 'Connecte-toi sur la page d\'Accueil'
	        ));
	    }
	    else {
    	
    	    $this->response(Controller_Upload::saveUploadImage('custom_files'.DS.'uploads', $this->current_user->id, 'upload_pic'));
    	    
	    }
	}
	
	
	public function post_create_mail_attachment($id = null)
	{
	    if(is_null($this->current_user)) {
	        $this->response(array(
	            'success' => false,
	            'errorMessage' => 'Connecte-toi sur la page d\'Accueil'
	        ));
	    }
	    else {
		
		    $this->response(Controller_Upload::saveUploadImage('mail_attachments'.DS.'uploads', $this->current_user->id, 'upload_pic'));
		    
	    }
	}
	
	public function post_create_drawing($id = null) {
	    if(is_null($this->current_user)) {
	        $this->response(array(
	            'success' => false,
	            'errorMessage' => 'Connecte-toi sur la page d\'Accueil'
	        ));
	    }
	    else {
	    
    	    $name = $this->current_user->id.'_'.Str::random('unique');
    	    
    	    $content = Input::post('imgData64');
    	    
    	    $filename = Controller_Upload::saveBase64Src($name, $content, DOCROOT.'custom_files/drawings/', self::$img_ext_whitelist);
    	    
    	    if(!$filename) {
    	        $this->response(array(
    	            'success' => false,
    	            'errorMessage' => 'Echec à sauvegarder ton dessin',
    	        ));
    	    }
    	    else {
    	        // call a model method to update the database
    	        $uploadRecord = Model_Upload::forge(array(
    	        	'created_by' => $this->current_user->id,
    	        	'type' => 'img',
    	        	'path' => Controller_Upload::site_root().'custom_files/drawings/'.$filename,
    	        	'access' => 1
    	        ));
    	        
    	        if($uploadRecord and $uploadRecord->save()) {
    	            $this->response(array(
    	                'success' => true,
    	                'path' => Controller_Upload::site_root().'custom_files/drawings/'.$filename
    	            ));
    	        }
    	        else {
    	            $this->response(array(
    	                'success' => false,
    	                'errorMessage' => 'Echec à enregisterer le téléchargement'
    	            ));
    	        }
    	    }
	    
	    }
	}
}
