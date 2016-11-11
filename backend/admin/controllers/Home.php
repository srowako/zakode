<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Backend_Controller {

	public function index()
	{
		$this->load->model('user_model', 'users');
		$data['count'] = array(
			'users' => $this->users->count_all(),
		);
		$this->make('home',$data);
	}
}
