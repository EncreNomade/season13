<?php
use Orm\Model;

class Model_Admin_13contactmsg extends Model
{
	protected static $_properties = array(
		'id',
		'nom',
		'user',
		'email',
		'destination',
		'title',
		'message',
		'response',
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
	    
	    switch ($factory) {
	    case "send":
	        $val->add_field('nom', 'Nom', 'required|max_length[32]');
	        $val->add_field('user', 'User', 'valid_string[numeric]');
	        $val->add_field('email', 'Email', 'required|valid_email|max_length[255]');
	        $val->add_field('title', 'Title', 'max_length[255]');
	        $val->add_field('message', 'Message', 'required');
	        break;
	    default:
	        $val->add_field('nom', 'Nom', 'required|max_length[32]');
	        $val->add_field('user', 'User', 'required|valid_string[numeric]');
	        $val->add_field('email', 'Email', 'required|valid_email|max_length[255]');
	        $val->add_field('destination', 'Destination', 'required|max_length[255]');
	        $val->add_field('title', 'Title', 'required|max_length[255]');
	        $val->add_field('message', 'Message', 'required');
	        $val->add_field('response', 'Response', 'required|valid_string[numeric]');
	        break;
	    }

		return $val;
	}

}
