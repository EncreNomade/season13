<?php

// !!! Script to modify !!!

class Controller_Upload extends Controller_Rest
{

	public function action_create_img($id = null)
	{
	
    	/**/
    	// Custom configuration for this upload
    	$config = array(
        	'path' => DOCROOT.DS.'files',
        	'randomize' => true,
        	'ext_whitelist' => array('jpg','jpeg','png','tiff','bmp','gif'),
    	);
    	
    	// process the uploaded files in $_FILES
    	Upload::process($config);
    	
    	// if there are any valid files
    	if (Upload::is_valid())
    	{
        	// save them according to the config
        	Upload::save();
        	
        	// call a model method to update the database
        	Model_Upload::add(Upload::get_files());
    	}
    	
    	// and process any errors
    	foreach (Upload::get_errors() as $file)
    	{
        	// $file is an array with all file information,
        	// $file['errors'] contains an array of all error occurred
        	// each array element is an an array containing 'error' and 'message'
    	}
    	/**/
    	
    	if (Input::method() == 'POST')
    	{
        	$val = Model_Newsrh::validate('create');
        	
        	if ($val->run())
        	{
            	$newsrh = Model_Newsrh::forge(array(
                	'titre' => Input::post('titre'),
                	'contenu' => Input::file&#40;'contenu'&#41;,
                	'dateupload' => Input::post('dateupload'),
            	));
            	
            	if ($newsrh and $newsrh->save())
            	{
                	Session::set_flash('success', 'Added post #'.$post->id.'.');
                	
                	Response::redirect('admin/newsrhs');
            	}
            	
            	else
            	{
            	    Session::set_flash('error', 'Could not save news rh.');
            	}
        	}
        	else
        	{
        	    Session::set_flash('error', $val->show_errors());
        	}
    	}
	
	}

}
