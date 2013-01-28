<?php
// use Orm\Model;

class Model_Book_13game extends Orm\Model
{
	protected static $_properties = array(
		'id',
		'name',
		'epid',
		'expo',
		'instruction',
		'presentation',
		'categories',
		'metas',
		'created_at',
		'updated_at',
		'class_name',
		'path',
		'file_name',
		'created_at',
		'updated_at'
	);

	protected static $_belongs_to = array(
	    'episode' => array(
	        'key_from' => 'epid',
	        'model_to' => 'Model_Admin_13episode',
	        'key_to' => 'id',
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
		$val->add_field('name', 'Name', 'required|max_length[64]');
		$val->add_field('epid', 'Epid', 'required|valid_string[numeric]');
		$val->add_field('expo', 'Expo', 'required|max_length[255]');
		//$val->add_field('instruction', 'Instruction', 'required');
		//$val->add_field('presentation', 'Presentation', 'required');
		$val->add_field('categories', 'Categories', 'max_length[255]');
		//$val->add_field('metas', 'Metas', 'required');

		return $val;
	}

}
