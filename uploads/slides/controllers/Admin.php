<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * For demo purpose only
 */
class Admin extends Backend_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $crud = $this->generate_image_crud('slides', 'image_url', SLIDE_PHOTO);
		$this->mTitle.= 'Cover Photos';
		$this->render_crud();
    }
}        