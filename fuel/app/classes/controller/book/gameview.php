<?php 

class Controller_Book_Gameview extends Controller_Template {
	public function before()
    {
        parent::before();
        
        if($_SERVER['HTTP_HOST'] == "www.season13.com" && Agent::browser() == "IE") {
            // Problem of session in IE, the login and inscription doesn't work on www.season13.com
            Response::redirect('http://season13.com');
        }
        
        // Assign current_user to the instance so controllers can use it
        $this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
        
        // Set a global variable so views can use it
        View::set_global('current_user', $this->current_user);
        View::set_global('remote_path', Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/');
        View::set_global('base_url', Fuel::$env == Fuel::DEVELOPMENT ? 'localhost:8888/season13/public/' : "http://".$_SERVER['HTTP_HOST']."/");
        
        // Set supplementation css and js file
        $this->template->css_supp = '';
        $this->template->js_supp = '';
    }

    public function action_index()
    {

        $games = Model_Book_13game::find('all');
        $this->template->js_supp = "game_runner.js"; 
    	
		$data = array("games" => $games);
    
        $this->template->title = 'SEASON 13 - Histoire Interactive | Voodoo Connection | Feuilleton Interactif | Livre Jeux';
        // Set supplementation css and js file
        
        $this->template->content = View::forge('book/13game/gameview_all', $data);

    }

	public function action_playGame($id = null) {

        $g = Model_Book_13game::find_by_id($id);
        $data = array();
        if(!$g) {     
            return View::forge('book/13game/gameview_frame_error', array("message" => "Erreur : Jeux non trouvé."));
        }
        else {
            $data["className"] = $g->class_name ;
            $data["fileName"] = $g->file_name ;
            $data["path"] = $g->path ;

            return View::forge('book/13game/gameview_frame', $data);
        }
	}
}