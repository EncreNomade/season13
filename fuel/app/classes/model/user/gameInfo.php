<?php

class Model_User_Gameinfo extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'game_id',
		'high_score',
		'retry_count',
		'supp',
		'created_at',
		'updated_at'
	);

	protected static $_belongs_to = array(
	    'user' => array(
	        'key_from' => 'user_id',
	        'model_to' => 'Model_13user',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false
	    ),
	    'game' =>  array(
	        'key_from' => 'game_id',
	        'model_to' => 'Model_Book_13game',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
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

	public static function get_by_user_and_game($user = null, $gameClass = null)
	{
		if(is_null($user) || is_null($gameClass))
			return null;

		$gameInfo = self::query()
			->related('game')
			->where('game.class_name', $gameClass)
			->where('user_id', $user->id)
			->get_one();

		if($gameInfo)
			return $gameInfo;

		$game = Model_Book_13game::find_by_class_name($gameClass);
		if($game) {
			$gameInfo = self::forge();
			$gameInfo->game_id = $game->id;
			$gameInfo->user_id = $user->id;
			$gameInfo->high_score = 0;
			$gameInfo->retry_number = 0;
			$gameInfo->supp = '';

			return $gameInfo;
		}	
		else return null;	
	}
	/**
	 * Get all game info for a game as array (ordered by high score)
	 * @param string $gameClass the name of the javascript game class
	 * @param int $limit OPTIONAL number of max gameinfo in returned array
	 * @return Model_User_Gameinfo[]|null array is ordered by high_score
	 */
	public static function find_all_by_game_class($gameClass = null, $limit = null)
	{
		if(is_null($gameClass)) return null;

		if(is_null($limit)) {			
			$gameInfos = self::query()
				->related('game')
				->related('user')
				->where('game.class_name', $gameClass)
				->order_by('high_score', 'desc')
				->get();
		}
		else {
			$gameInfos = self::query()
				->related('game')
				->related('user')
				->where('game.class_name', $gameClass)
				->order_by('high_score', 'desc')
				->limit( (int)$limit )
				->get();
		}

		return empty($gameInfos) ? null : $gameInfos;
	}

	public function isLowerThan($score = null)
	{
		return (int)$this->high_score < (int)$score;
	}

	public function setHighScore($score = null)
	{
		if( (int)$score > (int)$this->high_score )
			$this->high_score = $score;
	}
}


