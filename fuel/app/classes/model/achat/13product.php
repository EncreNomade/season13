<?php
use Orm\Model;

class Model_Achat_13product extends Model
{
	protected static $_properties = array(
		'id',
		'reference',
		'type',
		'pack',
		'content',
		'presentation',
		'tags',
		'title',
		'category',
		'metas',
		'on_sale',
		'price',
		'discount',
		'sales',
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
		$val->add_field('reference', 'Reference', 'required');
		$val->add_field('type', 'Type', 'required');
		$val->add_field('pack', 'Pack', 'required|valid_string[numeric]');
		$val->add_field('content', 'Content', 'required');
		$val->add_field('presentation', 'Presentation', 'required');
		$val->add_field('tags', 'Tags', 'required|max_length[255]');
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('category', 'Category', 'required');
		$val->add_field('metas', 'Metas', 'required');
		$val->add_field('on_sale', 'On Sale', 'required|valid_string[numeric]');
		$val->add_field('price', 'Price', 'required');
		$val->add_field('discount', 'Discount', 'required');
		$val->add_field('sales', 'Sales', 'valid_string[numeric]');

		return $val;
	}

}
