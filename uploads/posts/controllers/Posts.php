<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends Frontend_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Post');
		$this->load->model('Category');
		$this->load->model('Tag');
                $this->load->helper('text');
	}

	public function index()
	{
            $data['page_layout'] = 'archive';
            $config['total_rows'] = count($this->Post->find_active());
            $config['per_page'] = 5;
            $config["uri_segment"] = 2;
            $data['posts'] = $this->Post->find_active($config['per_page'], $this->uri->segment(2));
            $this->load->view('posts',$data);
	}
        public function sidebar(){
            $data['posts'] = $this->Post->find_active(5, $this->uri->segment(2));
            $data['getRecentPosts'] = $this->Post->find_active(5);
            $data['getCategories'] = $this->Category->find_active(5);
            $data['getTags'] = $this->Tag->find_active(5);
            $this->load->view('right_sidebar',$data);
	}

	public function read($slug){
		$data['page_layout'] = 'single'; 
		$data['post'] = $this->Post->find_by_slug($slug);
		$data['page_title'] = $data['post']['title'];
		$this->make('read',$data);
	}

	public function category($slug = null){
            $data['page_layout'] = 'archive';
            $config['total_rows'] = count($this->Post->find_by_category($slug));
            $config['per_page'] = 5;
            $config["uri_segment"] = 3;
            $data['posts'] = $this->Post->find_by_category($slug,$config['per_page'], $this->uri->segment(3));
//            $data['pagination'] = $this->bootstrap_pagination($config);
            $data['category'] = $this->Category->find_by_slug($slug);
            $this->make('posts',$data);
	}

	public function tag($slug = null){
		$data['page_layout'] = 'archive';
		$config['base_url'] = site_url('tag/'.$slug.'/');
		$config['total_rows'] = count($this->Post->find_by_tag($slug));
		$config['per_page'] = 5;
		$config["uri_segment"] = 3;     
        $data['posts'] = $this->Post->find_by_tag($slug,$config['per_page'], $this->uri->segment(3));
        
        $data['pagination'] = $this->bootstrap_pagination($config);

      	$data['tag'] = $this->Tag->find_by_slug($slug);

        $data['header'] = $this->load->view('themes/'.$this->theme.'/posts/header',$data, TRUE);
        
		$this->load_theme('posts/index');
	}
}
