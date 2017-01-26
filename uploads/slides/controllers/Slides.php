<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * For demo purpose only
 */
class Slides extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // grab records from database table "cover_photos"
        $this->load->model('slides_model', 'photos');
        $data['photos'] = $this->photos->get_all();
        $this->load->view('slide',$data);
    }
}        