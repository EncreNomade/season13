<?php

class Controller_DailyUpdate extends Controller
{
	private $insertInBase = true;
	private $output = true;
	
	public function action_currency($action = "")
	{	
		if($action =$ 'reset')
			return $this->reset();


		$ret = '';

	    $XML = simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
	    //the file is updated daily between 2.15 p.m. and 3.00 p.m. CET
	            
	    foreach($XML->Cube->Cube->Cube as $data) {
	        $isoCode = $data["currency"];
	        $rate = $data["rate"];

	    	$obj = Model_Achat_Currency::find_by_iso($isoCode);
	    	if($obj) {
		    	$obj->conversion_rate = $rate;
		    	$obj->save();

		    	$ret .= 'saving for existing ISO = '.$isoCode .'<br>';
		    }
		    elseif ($this->insertInBase) {
		    	$obj = Model_Achat_Currency::forge();
		    	$obj->iso_code = $isoCode;
		    	$obj->conversion_rate = $rate;
		    	$obj->name = 'test';
		    	$obj->iso_code_num = 0;
		    	$obj->sign = '€';
		    	$obj->active = 1;
		    	$obj->supp = '';
		    	$obj->save();
		    	
		    	$ret .= 'insert new currency, ISO = '.$isoCode.' | rate = '.$rate.'<br>';
		    }
	    }

	    if ($this->output) 
	    	return $ret;
	}

	private function action_reset()
	{
		$obs = Model_Achat_Currency::find('all');

		foreach ($obs as $price) {
			$price->conversion_rate = 0;
			$price->save();
		}
	}



}


