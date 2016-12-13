<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		
		// only login users can access Account controller
//		$this->verify_login();
	}

	public function index()
	{
            if ( $this->ion_auth->logged_in() ){
                $data['user'] = $this->mUser;
		$this->make('account',$data);
            }else{
                
            }		
	}
        public function sidebar()
	{
            if ( $this->ion_auth->logged_in() ){
                $data['user'] = $this->mUser;
		$this->load->view('sidebar',$data);
            }else{
                
            }
		
	}
}