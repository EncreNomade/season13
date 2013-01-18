<?php

class Controller_User_Data extends Controller_Ajax
{
	public function action_update()
	{
		Log::write('AJAX', 'Ajax a été appelé');
		if(Input::method() != 'POST' || is_null($this->current_user))
			Response::redirect('404');

		$this->current_user->saveConfig(array(
			'speed' => Input::post('speed'),
			'fbShareEnabled' => Input::post('fbShareEnabled'),
			'volume'=> Input::post('volume')
		));

		$epInfo = $this->current_user->getEpisodeInfo(Input::post('epId'));
		if($epInfo) {
			$epInfo->position = Format::forge( Input::post('position', $epInfo->position) )->to_json();
			$epInfo->started = Input::post('started') && Input::post('started') != 'false' ? 1 : 0;
			$epInfo->completed = Input::post('completed') && Input::post('completed') != 'false' ? 1 : 0;
			$epInfo->save();
		}

		return 'user config & episode info updated';
	}

	public function action_retrieve()
	{
		if(!Input::is_ajax())
			Response::redirect('404');
		if(is_null($this->current_user))
			return Format::forge(array())->to_json();

		$result = array('epInfo' => array(), 'config' => array());

		$epInfo = $this->current_user->getEpisodeInfo(Input::get('epId'));
		if($epInfo) {
			$result['epInfo']= $epInfo->to_array();
		}

		$configs = $this->current_user->configs;

		foreach ($configs as $c) {
			$result['config'][$c->key] = $c->value;
		}

		return Format::forge($result)->to_json();
	}
}
