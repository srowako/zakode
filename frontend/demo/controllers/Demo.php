<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * For demo purpose only
 */
class Demo extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->push_breadcrumb('Demo');
	}

	public function index()
	{
		redirect('demo/item/1');
	}

	public function item($demo_id)
	{
		$data['demo_id'] = $demo_id;
		$this->make('demo/item',$data);
	}
	
	// Bootstrap Carousel
	public function carousel()
	{
		// grab records from database table "cover_photos"
		$this->load->model('demo_cover_photo_model', 'photos');
		$data['photos'] = $this->photos->get_all();
		$this->make('demo/carousel',$data);
	}
	
	// Blog Posts
	public function blog_posts()
	{
		$page = $this->input->get('p');
		$page = empty($page) ? 1 : $page;

		$this->load->model('demo_blog_post_model', 'posts');
		$results = $this->posts->with('category')->with('author')->paginate($page);
		$posts = $results['data'];
		$counts = $results['counts'];
		
		// call render() from MY_Pagination
		$this->load->library('pagination');
		$pagination = $this->pagination->render($counts['total_num'], $counts['limit']);

		$data['posts'] = $posts;
		$data['counts'] = $counts;
		$data['pagination'] = $pagination;
		$this->make('demo/blog_posts',$data);
	}
	
	// Blog Post
	public function blog_post($post_id)
	{
		$this->load->model('demo_blog_post_model', 'posts');
		$post = $this->posts->with('category')->with('author')->get($post_id);

		$this->push_breadcrumb('Blog Posts', 'demo/blog_posts');
		$this->mTitle = $post->title;
		$data['post'] = $post;
		$this->make('demo/blog_post',$data);
	}

	public function pagination()
	{
		// library from: application/libraries/MY_Pagination.php
		// config from: application/config/pagination.php
		$this->load->library('pagination');
		$data['pagination'] = $this->pagination->render(200, 20);
		$this->make('demo/pagination',$data);
	}

	// Form without Bootstrap theme
	// See views/demo/form_basic.php for sample code
	public function form_basic()
	{
		// library from: application/libraries/Form_builder.php
		$form = $this->form_builder->create_form();

		if ($form->validate())
		{
			$this->system_message->set_success('Success!');
			refresh();
		}

		// require reCAPTCHA script at page head
		$this->mScripts['head'][] = 'https://www.google.com/recaptcha/api.js';

		$this->mTitle = 'Form (Basic)';
		$data['form'] = $form;
		$this->make('demo/form_basic',$data);
	}
	
	public function form_bs3()
	{
		// library from: application/libraries/Form_builder.php
		$form = $this->form_builder->create_form();

		if ($form->validate())
		{
			$this->system_message->set_success('Success!');
			refresh();
		}

		// require reCAPTCHA script at page head
		$this->mScripts['head'][] = 'https://www.google.com/recaptcha/api.js';
		
		$this->mTitle = 'Form (Bootstrap 3)';
		$data['form'] = $form;
		$this->make('demo/form_bs3',$data);
	}
}
