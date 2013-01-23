<?php

class Model_13user extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'pseudo',
		'password',
		'group',
		'email',
		'portable',
		'avatar',
		'sex',
		'birthday',
		'pays',
		'code_postal',
		'notif',
		'fbid',
		'profile_fields',
		'sns_links',
		'login_hash',
		'created_at',
		'updated_at'
	);

	/*
	* Relation 'has_many'
	* example : 
	*	$user = Model_13user::find_by_id(1);
	*
	* $user->gameInfo is an array containing all related gameInfo model	*
	* this example run 2 SQL queries, to make only 1 do :
	*	$user = Model_13user::query()->related('gameInfo')->where('id', 1)->get_one();
	*/
	protected static $_has_many = array(
		'gameInfos' => array(
			'key_from' => 'id',
			'model_to' => 'Model_User_GameInfo',
			'key_to' => 'user_id',
			'cascade_save' => true,
			'cascade_delete' => false
		),
		'configs' => array(
			'key_from' => 'id',
			'model_to' => 'Model_User_Config',
			'key_to' => 'user_id',
			'cascade_save' => true,
			'cascade_delete' => false
		),
		'episodeInfos' =>  array(
			'key_from' => 'id',
			'model_to' => 'Model_User_Episodeinfo',
			'key_to' => 'user_id',
			'cascade_save' => true,
			'cascade_delete' => false
		),
		'possessions' => array (
			'key_from' => 'email',
			'model_to' => 'Model_Admin_13userpossesion',
			'key_to' => 'user_mail',
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
		$val->add_field('pseudo', 'Pseudo', 'required');
		$val->add_field('group', 'Group', 'required|valid_string[numeric]');
		$val->add_field('email', 'Email', 'required|valid_email');
		$val->add_field('avatar', 'Avatar', 'required');
		$val->add_field('sex', 'Gender', 'required');
		$val->add_field('birthday', 'Birthday', 'required');

		return $val;
	}

	private function _saveOneConfig($key = null, $value = null)
	{
		if(is_null($key) || is_null($value))
			return $this;			

		$configs = $this->configs;			// first check if config exist
		foreach ($configs as $config) {
			if($config->key == $key){
				$config->value = $value; 	// config key is find change it, save it and return
				$config->save();
				return $this;
			}
		}

		Debug::dump($value);
		$config = Model_User_Config::forge();
		$config->user_id = $this->id;
		$config->key = $key;
		$config->value = $value;
		$config->supp = '';
		$config->save();
	}

	public function saveConfig($keyOrArr = null, $value = null)
	{
		if(is_array($keyOrArr)) {
			foreach ($keyOrArr as $confKey => $confValue) {
				$this->_saveOneConfig($confKey, $confValue);
			}
			return $this;
		}
		else return $this->_saveOneConfig($keyOrArr, $value);
	}

	/**
	 * Retrieve an existing episode info or create a new one
	 * @param int|string $episodeId
	 * @return Model_User_Episodeinfo 
	 */
	public function getEpisodeInfo($episodeId = null)
	{
		if(is_null($episodeId))
			return null;

		$epInfos = $this->episodeInfos;
		foreach ($epInfos as $epInfo) {
			if($epInfo->episode_id == $episodeId)
				return $epInfo;
		}

		$epInfo = Model_User_Episodeinfo::forge();
		$epInfo->user_id = $this->id;
		$epInfo->episode_id = $episodeId;

		return $epInfo;
	}

	/**
	 * Know if an episode is owned by this user
	 * @param int|string $episodeId the episode id
	 * @return bool
	 */
	public function ownEpisode($episodeId = null)
	{
		$possessions = $this->possessions;
		foreach ($possessions as $p) 
			if($p->episode_id == $episodeId) return true;

		return false;
	}

	/**
	 * Know if a user have ever played the game
	 * @param int|string $gameId the game id
	 * @return bool
	 */
	public function havePlayed($gameId = null) {
		$gameInfos = $this->gameInfos;

		foreach ($gameInfos as $g) {
			if($g->game_id == $gameId && $g->retry_count > 0)
				return true;
		}
		return false;
	}
}
