<?php
use Orm\Model;

class EpisodeNotFoundExeption extends FuelException {}

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
		'author',
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


	public static function validateWithMeta($factory)
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
		$val->add_field('on_sale', 'On Sale', 'required|valid_string[numeric]');
		$val->add_field('price', 'Price', 'required');
		$val->add_field('discount', 'Discount', 'required');
		$val->add_field('sales', 'Sales', 'valid_string[numeric]');


		
		$val->add_field('meta_type_content', 'Metas types ', 'required|is_array');
		$val->add_field('meta_value_content', 'Metas values', 'required|is_array');

		return $val;
	}

	public function getContent()
	{
		$content = Format::forge($this->content, 'json')->to_array();

		$episodes = array();

		foreach ($content as $episodeId) {
			$ep = Model_Admin_13episode::find_by_id($episodeId);
			if ($ep)
				$episodes[] = $ep;
			else
				throw new EpisodeNotFoundExeption(Config::get('errormsgs.payment.4006') . " Error code : 4006, Episode ID: ".$episodeId);
				
		}

		return $episodes;
	}

	public function getImages()
	{
		$metas = Format::forge($this->metas, 'json')->to_array();

		$imagesUrl = array();

		foreach ($metas as $m) {
			if ($m["type"] == "image")
				$imagesUrl[] = $m["value"];
		}

		return $imagesUrl;
	}

	public function getExtrait()
	{		
		$metas = Format::forge($this->metas, 'json')->to_array();

		$extraits = array();

		foreach ($metas as $m) {
			if ($m["type"] == "extrait")
				$extraits[] = $m["value"];
		}

		return $extraits;
	}

	public function getLocalPrice($countryCode = null)
	{
		$price = Model_Achat_Productprice::find_by_product_country($this->id, $countryCode);

		if ($price) {
			return $price->taxed_price;
		}
		else { // apply default price calculte with currency
			// search if currency exist in table
			$defaultPrice = Model_Achat_Productprice::find_by_product_country($this->id, "FR");
			$isoCode = Config::get("currencies.$countryCode.currency");
			$currency = Model_Achat_Currency::find_by_iso($isoCode);
			if($currency) {
				$finalPrice = floatval($defaultPrice) * floatval($currency->conversion_rate);
			}
		}
	}

	public function getLocalDiscount($country = null)
	{
		
	}
}




