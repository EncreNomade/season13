<?php

class Controller_User_Data extends Controller_Restbase
{
	public function post_update()
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

		return true;
	}

	public function get_retrieve()
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

		return $result;
	}

	public function get_gameInfo()
	{
		$gameInfo = Model_User_GameInfo::get_by_user_and_game($this->current_user, Input::get('className'));

		// return $this->response(array('user null' => is_null($this->current_user), 'class null' => Input::get('className')));

		if($gameInfo) {
			return $this->response(array(
				'high_score' => (int) $gameInfo->high_score,
				'retry_count' => (int) $gameInfo->retry_count
			));
		}
			
		else
			return $this->response(null); // http code 204 == no content
	}

	public function post_gameInfo()
	{
		$uId = $this->current_user ? $this->current_user->id : null;
		$gameInfo = Model_User_GameInfo::get_by_user_and_game($this->current_user, Input::post('className'));

		if(is_null($gameInfo))
			return $this->response(false, 500); // 500 == server error

		$score = Input::post('score');
		if($gameInfo->isLowerThan($score))
			$gameInfo->high_score = $score;
		$gameInfo->retry_count++;

		$gameInfo->save();


		return $this->response(true);
	}
}
