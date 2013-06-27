<?php

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 * 
 * @package  app
 * @extends  Controller
 */
class Controller_Welcomemobile extends Controller_Frontend
{
    public $template = 'template.mobi';

    public function before()
    {        
    	parent::before();
    	
    	if($_SERVER['HTTP_HOST'] == "www.season13.com" && Agent::browser() == "IE") {
    	    // Problem of session in IE, the login and inscription doesn't work on www.season13.com
    	    Response::redirect('http://season13.com');
    	}
    }
	
	/**
	 * The mobile story page
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
	    // Episodes
	    $data['episodes'] = Model_Admin_13episode::find('all');
	    
	    // Info supplementaire
	    $supp = array();
	    foreach ($data['episodes'] as $episode) {
	        $info = array();
	        
	        // Product
	        $info['product'] = Model_Achat_13product::getProductForEpisode($episode->id);
	        
	        // Disponibilite
	        $info['available'] = $episode->isAvailable();
	        
	        // Link
	        $info['link'] = $this->base_url . $episode->getRelatLink();
	        
	        // Access
	        $info['access'] = $episode->hasAccess($this->current_user);
	        
	        $supp[$episode->id] = $info;
	    }
	    $data['supp'] = $supp;
	
	    $this->template->title = 'SEASON 13 - Histoire Interactive | Voodoo Connection | Feuilleton Interactif | Livre Jeux';
	    // Set supplementation css and js file
	    $this->template->css_supp = 'welcome.mobi.css';
	    $this->template->js_supp = 'welcome.mobi.js';
	    $this->template->current_page = 'histoire';
	    
	    $this->template->content = View::forge('welcome/index.mobi', $data);
	}
	
	
	
	/**
	 * The mobile concept page
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_concept()
	{
	    $this->template->title = 'Concept - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	    // Set supplementation css and js file
	    $this->template->css_supp = 'concept.mobi.css';
	    $this->template->current_page = 'concept';
	    
	    $this->template->content = View::forge('welcome/concept.mobi');
	}
	
	
	
	/**
	 * The mobile index of games
	 * 
	 */
	public function action_games()
	{
	    $games = Model_Book_13game::query()->where('independant', 1)
	                                       ->get();
	    
	    foreach ($games as $game) {
	        if($this->current_user) {
	            if( $game->episode->hasAccess($this->current_user) ) {
	                if($this->current_user->havePlayed($game->id)) {
	                    $game->access = true;
	                    continue;
	                }
	            }
	        }
	        
	        $game->access = false;
	    }
	    
	    $data = array("games" => $games);
	    
	    $this->template->title = 'Jeux - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	    $this->template->css_supp = "gameview.mobi.css";
	    $this->template->js_supp = "gameview.mobi.js";
	    $this->template->current_page = 'jeux';
	    
	    $this->template->content = View::forge('book/13game/gameview_all.mobi', $data);
	}
	
	
	/**
	 * The mobile single game info page
	 *
	 */
    public function action_gameinfo($className = null) {
        $game = Model_Book_13game::find_by_class_name($className);
        $data = array();
        if(!$game)
            return Response::redirect('mobile/404');
        else {
            if($this->current_user && !$this->current_user->havePlayed($game->id)) {
                return Response::redirect('games');
            }
            else {
                $this->template->css_supp = "gameview.mobi.css";
                $this->template->js_supp = "game_runner.js";
                
                $data['game'] = $game;
    
                $gameInfos = Model_User_Gameinfo::highscores_by_game_id($game->id, 50);
                View::set_global('gameInfos', $gameInfos);        
    
                $this->template->title = 'SEASON 13 - jeux ' . $game->name;
                $this->template->current_page = 'jeux';
    
                $this->template->content = View::forge('book/13game/gameview_single.mobi', $data);
            }
        }
    }
}
