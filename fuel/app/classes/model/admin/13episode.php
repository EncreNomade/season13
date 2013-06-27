<?php
use Orm\Model;

class Model_Admin_13episode extends Model
{
	protected static $_properties = array(
		'id',
		'title',
		'story',
		'season',
		'episode',
		'path',
		'bref',
		'image',
		'dday',
		'price',
		'info_supp',
		'created_at',
		'updated_at',
	);

	protected static $_has_many = array(
		'games' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Book_13game',
			'key_to' => 'epid',
			'cascade_save' => true,
			'cascade_delete' => false
		),
		'comments' => array(
		    'key_from' => 'id',
		    'model_to' => 'Model_Admin_13comment',
		    'key_to' => 'epid',
		    'cascade_save' => true,
		    'cascade_delete' => false
		)
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('story', 'Story', 'required|max_length[255]');
		$val->add_field('season', 'Season', 'required|valid_string[numeric]');
		$val->add_field('episode', 'Episode', 'required|valid_string[numeric]');
		$val->add_field('path', 'Path', 'required|max_length[255]');
		$val->add_field('bref', 'Bref', 'required');
		$val->add_field('image', 'Image', 'required|max_length[255]');
		$val->add_field('dday', 'Dday', 'required');
		$val->add_field('price', 'Price', 'required|max_length[10]');
		$val->add_field('info_supp', 'Info Supp', 'required');

		return $val;
	}



    public function isAvailable() {
        return (time() > Date::create_from_string($this->dday, '%Y-%m-%d')->get_timestamp());
    }
    
    public function getRelatLink() {
        return str_replace(' ', '_', $this->story) . "/season" . $this->season . "/episode" . $this->episode;
    }
    
    public function getRelatPdtRef() {
        $info = Format::forge($this->info_supp, 'json')->to_array();
        $reference = array_key_exists("reference", $info) ? $info["reference"] : false;
        return $reference;
    }
    
    public function getRelatProduct() {
        $reference = $this->getRelatPdtRef();
        if($reference) {
            return Model_Achat_13product::find_by_reference($reference);
        }
        else return false;
    }
    
    public function hasAccess($user) {
        // Episode 1 free for public
        if($this->id == 1)
            return true;
            
        if(!$user) 
            return false;
            
        // Free for all important user
        if( $user->group >= 10 )
            return true;
            
        // Not available
        if(!$this->isAvailable())
            return false;
            
        // Episode 2 free for all user
        if($this->id == 2)
            return true;
            
        // Permission after first episode
        $existed = Model_Admin_13userpossesion::query()->where(
            array(
                'user_mail' => $user->email,
                'episode_id' => $this->id
            )
        )->count();
        
        if( $existed > 0 )
            return true;
        else return false;
    }

}
