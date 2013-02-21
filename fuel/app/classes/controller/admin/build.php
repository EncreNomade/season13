<?php

class Controller_Admin_Build extends Controller_Backend
{
    public function action_storyjs()
    {
        // Build js files with uglify
        $arr = array(
            'lib/Tools.js',
            'lib/Interaction.js',
            'lib/fbapi.js',
            'cart.js',
            'auth.js',
            'story/msg_center.js',
            'story/gui.js',
            'story/gameinfo.js',
            'story/tuto.js',
        );
        
        $compressed = "";
        foreach ($arr as $file) {
            $js_code = File::read(DOCROOT.'assets/js/'.$file, true);
            
            // Uglify
            $curl = Request::forge('http://marijnhaverbeke.nl/uglifyjs', 'curl');
            $curl->set_method('post')->set_params(array('js_code' => $js_code));
    
            // Execute the request to uglifyjs
            $curl->execute();
            
            // fetch the result compressed code
            $compressed .= $curl->response()->body() . "\n";
        }
        
        File::update(DOCROOT, 'assets/js/story/lib.min.js', $compressed);
        
        // Build pre compressed core js files
        File::update(DOCROOT, 'assets/js/story/core.min.js', "");
        $precomp = array(
            'story/scriber.min.js',
            'story/events.min.js',
            'story/mse.min.js',
            'story/effet_mini.js',
            'story/mdj.min.js'
        );
        
        foreach ($precomp as $file) {
            File::append(DOCROOT, 'assets/js/story/core.min.js', File::read(DOCROOT.'assets/js/'.$file, true) . ";\n");
        }
    
    	$this->template->title = 'Build';
    	$this->template->content = View::forge('admin/build/build_story_js', array('success' => true));
    }
    
    public function action_templatejs()
    {
        // Build js files with uglify
        $arr = array(
            'lib/fbapi.js',
            'template.js',
            'cart.js',
            'auth.js'
        );
        
        $compressed = "";
        foreach ($arr as $file) {
            $js_code = File::read(DOCROOT.'assets/js/'.$file, true);
            
            // Uglify
            $curl = Request::forge('http://marijnhaverbeke.nl/uglifyjs', 'curl');
            $curl->set_method('post')->set_params(array('js_code' => $js_code));
    
            // Execute the request to uglifyjs
            $curl->execute();
            
            // fetch the result compressed code
            $compressed .= $curl->response()->body() . "\n";
        }
        
        File::update(DOCROOT, 'assets/js/template_main.min.js', $compressed);
    
    	$this->template->title = 'Build';
    	$this->template->content = View::forge('admin/build/build_template_js', array('success' => true));
    }
}

?>