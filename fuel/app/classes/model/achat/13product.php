<?php
use Orm\Model;

class EpisodeNotFoundException extends FuelException {}
class CountryNotFoundException extends FuelException {}
class DefaultPriceNotFoundException extends FuelException {}


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

	protected static $_has_many = array(
	    'cartproduct' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Achat_Cartproduct',
	        'key_to' => 'product_id',
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
	
	
	public static function getProductForEpisode($ep) {
	    foreach (self::query()->where(array('pack' => 0))->get() as $product) {
	        $eps = Format::forge($product->content, 'json')->to_array();;
	        if(in_array($ep, $eps)) {
	            return $product;
	        }
	    }
	    return null;
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
				throw new EpisodeNotFoundException(Config::get('errormsgs.payment.4501') . " Error code : 4501, Episode ID: ".$episodeId);
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

	public function getLocalPrice($countryCode = 'FR')
	{
		$price = Model_Achat_Productprice::find_by_id_and_country($this->id, $countryCode);

		if ($price) { 						// a price is found for this product & this country
			return floatval($price->taxed_price);
		}
		else { 								// if not search for the french price and apply conversion
			$defaultPrice = Model_Achat_Productprice::find_by_id_and_country($this->id, 'FR');	
			$country = Model_Achat_Country::getWithCurrency($countryCode);

			if(!$defaultPrice) 
				throw new DefaultPriceNotFoundException(Config::get('errormsgs.payment.4502') . " Error code : 4502");					

			if(!$country) {
				throw new CountryNotFoundException(Config::get('errormsgs.payment.4503')." Error code : 4503, country : ".$countryCode);
			}
			else {							// we found a country and we have a default price => we can apply conversion rate
				$rate = floatval($country->currency->conversion_rate);
				$finalPrice = $rate * floatval($defaultPrice->taxed_price);
				return $finalPrice;			
			}
		}
	}

	public function getLocalDiscount($countryCode = null)
	{
		$price = Model_Achat_Productprice::find_by_id_and_country($this->id, $countryCode);
		if($price) 
			return floatval($price->discount);
		else
			return 0;		
	}
}




