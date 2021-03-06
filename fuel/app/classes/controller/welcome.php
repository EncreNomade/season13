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
class Controller_Welcome extends Controller_Frontend
{
    public function before()
    {        
    	parent::before();
    	
    	if($_SERVER['HTTP_HOST'] == "www.season13.com" && Agent::browser() == "IE") {
    	    // Problem of session in IE, the login and inscription doesn't work on www.season13.com
    	    Response::redirect('http://season13.com');
    	}
    }
    
    public function action_concept() {
        $this->template->title = 'Concept - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
        // Set supplementation css and js file
        $this->template->css_supp = 'concept.css';
        $this->template->description = "Concept de SEASON 13 - Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web: Voodoo Connection";
        
        $this->template->content = View::forge('welcome/concept');
    }

	/**
	 * The basic welcome message
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
	    if( Cookie::get('already_visited', 'false') != "true" ) {
	        $expire = 2147295600 - time(); // 17/01/2038 00:00
	        Cookie::set('already_visited', 'true', $expire);
	        Response::redirect('http://season13.com/bienvenue');
	    }
	    
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
	    $this->template->css_supp = 'welcome.css';
	    $this->template->js_supp = 'welcome.js';
	    
	    $this->template->content = View::forge('welcome/index', $data);
	}

	/**
	 * The 404 action for the application.
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		$this->template->title = 'Page inconnu - SEASON 13';
		$this->template->description = "Page inconnu de SEASON 13 - Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web: Voodoo Connection";
		
		$this->template->content = View::forge('welcome/404');
	}
	
	/**
	 * The 404 action for webservice application.
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_ws404()
	{
	    $data = array(
	        'title'         => 'Page inconnu - SEASON 13',
	        'description'   => "Page inconnu de SEASON 13 - Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web: Voodoo Connection",
	        'content'       => View::forge('welcome/404')
	    );
		
		return new Response(View::forge('template_ws', $data));
	}
	
	/**
	 * The upgrade navigator action for the application.
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_upgradenav() {
	    // Init data
	    $data['change']  = false;
	    $data['maj'] = false;
	    $data['browser'] = '';
	    
	    $capable = true;
	    
	    // Check user browser capacity
	    // Process based on the browser name
	    switch (Agent::browser())
	    {
	        case 'Firefox':
	            if(Agent::version() < 3.7) {
	                $capable = false;
	                $data['maj'] = true;
	                $data['browser'] = 'Firefox';
	            }
	            else 
	                $capable = true;
	            break;
	        case 'IE':
	            if(Agent::version() < 9) {
	                $capable = false;
	                if(Agent::platform() == 'Win7') {
	                    $data['maj'] = true;
	                    $data['browser'] = 'IE';
	                }
	                else {
	                    $data['change'] = true;
	                }
	            }
	            else 
	                $capable = true;
	            break;
	        case 'Chrome':
	            $capable = true;
	            break;
	        case 'Safari':
	            $capable = true;
	            break;
	        case 'Unknown':
	            $data['change'] = true;
	            $capable = false;
	            break;
	        default:
	            $capable = true;
	            break;
	    }
	
	    $this->template->title = 'Mise à Jour du Navigateur - SEASON 13';
	    $this->template->description = "Les histoires de SEASON 13 utilise les nouvelles fonctionnalités de HTML5, un navigateur moderne est indispensable.";
	    $this->template->content = View::forge('welcome/upgradenav', $data);
	}
	
	/**
	 * The upgrade navigator action for the application.
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_wsupgradenav() {
	    // Init data
	    $data['change']  = false;
	    $data['maj'] = false;
	    $data['browser'] = '';
	    
	    $capable = true;
	    
	    // Check user browser capacity
	    // Process based on the browser name
	    switch (Agent::browser())
	    {
	        case 'Firefox':
	            if(Agent::version() < 3.7) {
	                $capable = false;
	                $data['maj'] = true;
	                $data['browser'] = 'Firefox';
	            }
	            else 
	                $capable = true;
	            break;
	        case 'IE':
	            if(Agent::version() < 9) {
	                $capable = false;
	                if(Agent::platform() == 'Win7') {
	                    $data['maj'] = true;
	                    $data['browser'] = 'IE';
	                }
	                else {
	                    $data['change'] = true;
	                }
	            }
	            else 
	                $capable = true;
	            break;
	        case 'Chrome':
	            $capable = true;
	            break;
	        case 'Safari':
	            $capable = true;
	            break;
	        case 'Unknown':
	            $data['change'] = true;
	            $capable = false;
	            break;
	        default:
	            $capable = true;
	            break;
	    }
	
	    $templatedata = array(
	        'title'         => 'Mise à Jour du Navigateur - SEASON 13',
	        'description'   => "Les histoires de SEASON 13 utilise les nouvelles fonctionnalités de HTML5, un navigateur moderne est indispensable",
	        'content'       => View::forge('welcome/upgradenav', $data)
	    );
	    
	    return new Response(View::forge('template_ws', $templatedata));
	}
	
	
	public function action_aboutus() {
	    $this->template->title = 'Équipe - SEASON 13, Histoire Interactive | Voodoo Connection | Feuilleton Interactif | Livre Jeux';
	    
	    $this->template->css_supp = 'aboutus.css';
	    $this->template->description = "L'équipe de SEASON 13 - Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web: Voodoo Connection";
	    $this->template->content = View::forge('welcome/aboutus');
	}
	
	
	public function action_mentionslegales() {
	    $this->template->title = 'Mention Légales - SEASON 13';
	    $this->template->description = "Mention Légales de SEASON 13 - Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web: Voodoo Connection";
	    
	    $this->template->content = View::forge('welcome/mentionslegales');
	}
	
	
	public function action_contact() {
	    $this->template->title = 'Contact - SEASON 13';
	    
	    $this->template->css_supp = 'contact.css';
	    $this->template->description = "Contact de SEASON 13 - Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web: Voodoo Connection";
	    $this->template->content = View::forge('welcome/contact');
	}
	
	
	public function action_thanksto() {
	    $this->template->title = 'Remerciement - SEASON 13';
	    
	    $this->template->description = "SEASON 13 remercie... - Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web: Voodoo Connection";
	    $this->template->content = View::forge('welcome/thanksto');
	}
	
	public function action_cgv() {
	    $this->template->title = 'Conditions générales de ventes - SEASON 13';
	    
	    $this->template->description = "Conditions générales de ventes - Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web: Voodoo Connection";
	    $this->template->content = View::forge('achat/order/cgv');
	}
	
	public function action_welcome() {
	    return Response::forge(View::forge('welcome/welcome'), 200);
	}
	
	
	/**
	 * The cadeau action
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_cadeau()
	{
	    $this->template->title = 'SEASON 13 Offre - Histoire Interactive | Voodoo Connection | Feuilleton Interactif | Livre Jeux';
	    
	    $data = array();
	    $data['code'] = Input::method() == 'POST' ? Input::post('code') : Input::get('code');
	    
	    $this->template->content = View::forge('welcome/cadeau', $data);
	    
	    if (Input::method() == 'POST'){
	        if(!Security::check_token()) {
	            Session::set_flash('error', 'Veuille recharger la page et puis réessayer.');
	            return;
	        }
	        
	        if($this->current_user == null) {
	            Session::set_flash('error', 'Connecte-toi ou inscris-toi d\'abord en haut à droite de la page et réessaye ensuite.');
	            return;
	        }
	        
	        $val = Validation::forge();
	        
            $val->add('code', 'code cadeau')
                ->add_rule('required')
                ->add_rule('exact_length', 32);
                
            $val->set_message('required', 'Tu dois remplir :label');
            $val->set_message('exact_length', 'Ton :label n\'est pas valide, retourne dans ton mail pour retrouver le bon code.');
            
            if ($val->run()){
                $promocodemodel = Model_Admin_Promocode::find_by_code(Input::post('code'));
                
                if(!$promocodemodel) {
                    Session::set_flash('error', 'Ton code cadeau n\'a pas été accepté');
                    return;
                }
                else if($promocodemodel->used == 1) {
                    Session::set_flash('error', 'Ton code cadeau est refusé car il a déjà été utilisé');
                    return;
                }
                
                $offer = json_decode($promocodemodel->offer);
                foreach ($offer as $key => $ep) {
                    if(is_numeric($ep)) {
                        // Check possesion already set
                        $result = Model_Admin_13userpossesion::query()->where(
                            array(
                                'user_mail' => $this->current_user->email,
                                'episode_id' => $episode,
                                'source' => 7,
                            )
                        )->get_one();
                        
                        if(is_null($result)) {
                            $admin_13userpossesion = Model_Admin_13userpossesion::forge(array(
                            	'user_mail' => $this->current_user->email,
                            	'episode_id' => $ep,
                            	'source' => 4, // code_promo
                            	'source_ref' => $promocodemodel->code,
                            ));
                            
                            if ($admin_13userpossesion and $admin_13userpossesion->save())
                            {
                            	;
                            }
                            else
                            {
                            	Session::set_flash('error', 'Ton code cadeau n\'a pas été accepté, contacte-nous par mail: contact@encrenomade.com');
                            	break;
                            }
                        }
                    }
                }
                
                $promocodemodel->used = 1;
                $promocodemodel->used_by = $this->current_user->id;
                
                if($promocodemodel->save()) {
                    //Session::set_flash('success', 'Ton code de cadeau est accepté, commence à profiter <a href="http://season13.com/?s=episode">nos histoires</a>!');
                    Response::redirect('/?s=episode');
                }
            }
            else {
                Session::set_flash('error', $val->error());
            }
	    }
	}
	
}
