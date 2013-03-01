<?php
use Orm\Model;

class Model_Admin_Task extends Model
{
	protected static $_properties = array(
		'id',
		'creator',
		'type',
		'parameters',
		'whentodo',
		'done',
		'whendone',
		'created_at',
		'updated_at',
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
		$val->add_field('creator', 'Creator', 'required|valid_string[numeric]');
		$val->add_field('type', 'Type', 'required|max_length[64]');
		$val->add_field('parameters', 'Parameters', 'required');
		$val->add_field('whentodo', 'Whentodo', 'required|max_length[64]');
		$val->add_field('done', 'Done', 'required|valid_string[numeric]');
		$val->add_field('whendone', 'Whendone', 'required');

		return $val;
	}
	
	public function hasdone() {
	    $this->done = 1;
	    $this->whendone = Date::time();
	    $this->save();
	}

}
