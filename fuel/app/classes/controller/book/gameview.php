<?php 

class Controller_Book_Gameview extends Controller_Frontend {

	public function action_index()
    {
        $games = Model_Book_13game::query()->where('independant', 1)
                                           ->get();
        $this->template->css_supp = "gameview.css";
    	
		$data = array("games" => $games);
        
        $this->template->title = 'SEASON 13 - Histoire Interactive | Voodoo Connection | Feuilleton Interactif | Livre Jeux';
        
        $this->template->content = View::forge('book/13game/gameview_all', $data);
    }

    public function action_info($className = null)
    {        
        $g = Model_Book_13game::find_by_class_name($className);
        $data = array();
        if(!$g) {
            return Response::redirect('404');
        }
        else {
            $this->template->css_supp = "gameview.css"; 
            $this->template->js_supp = "game_runner.js"; 
            
            $data['game'] = $g;

            $gameInfos = Model_User_Gameinfo::find_all_by_game_class($className, 50);
            View::set_global('gameInfos', $gameInfos);        

            $this->template->title = 'SEASON 13 - jeux ' . $g->name;

            $this->template->content = View::forge('book/13game/gameview_single', $data);
        }
    }

	public function action_play($className = null) {
        $g = Model_Book_13game::find_by_class_name($className);
        $data = array();
        if(!$g) {     
            return View::forge('book/13game/gameview_frame_error', array("message" => "Erreur : Jeux non trouvé."));
        }
        else {
            $data["className"] = $g->class_name ;
            $data["fileName"] = $g->file_name ;
            $data["path"] = $g->path ;
            $data['game'] = $g;

            return View::forge('book/13game/gameview_frame', $data);
        }
	}

    public function action_classement($gameClass = null) {
        $gameInfos = Model_User_Gameinfo::find_all_by_game_class($gameClass, 50);


        return View::forge('book/13game/classement', array('gameInfos' => $gameInfos));
    }
}