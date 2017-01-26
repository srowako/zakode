<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Home extends Frontend_Controller {

	public function index()
	{
	$this->template->title(t('Home'));
        $data['text'] = 'homepage';
        $this->make('home', $data);
	}
}
