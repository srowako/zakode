<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demo extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->mTitle = 'Demo - ';
		$this->push_breadcrumb('Demo');
	}

	public function index()
	{
		redirect('demo/item/1');
	}

	// AdminLTE Components
	public function adminlte()
	{
		$this->mTitle.= 'AdminLTE Components';
		$this->make('demo/adminlte');
	}

	// Grocery CRUD - Blog Posts
	public function blog_post()
	{
		$crud = $this->generate_crud('demo_blog_posts');
		$crud->columns('author_id', 'category_id', 'title', 'image_url', 'tags', 'publish_time', 'status');
		$crud->set_field_upload('image_url', UPLOAD_DEMO_BLOG_POST);
		$crud->set_relation('category_id', 'demo_blog_categories', 'title');
		$crud->set_relation_n_n('tags', 'demo_blog_posts_tags', 'demo_blog_tags', 'post_id', 'tag_id', 'title');
		
		$state = $crud->getState();
		if ($state==='add')
		{
			$crud->field_type('author_id', 'hidden', $this->mUser->id);
			$this->unset_crud_fields('status');
		}
		else
		{
			$crud->set_relation('author_id', 'admin_users', '{first_name} {last_name}');
		}

		$this->mTitle.= 'Blog Posts';
		$this->render_crud();
	}

	// Grocery CRUD - Blog Categories
	public function blog_category()
	{
		$crud = $this->generate_crud('demo_blog_categories');
		$crud->columns('title');
		$this->mTitle.= 'Blog Categories';
		$data['crud_note'] = modules::run('adminlte/widget/btn', 'Sort Order', 'demo/blog_category_sortable');
		$this->render_crud();
	}
	
	// Sortable - Blog Categories
	public function blog_category_sortable()
	{
		$this->load->library('sortable');
		$this->sortable->init('demo_blog_category_model');
		$data['content'] = $this->sortable->render('{title}', 'demo/blog_category');
		$this->mTitle.= 'Blog Categories';
		$this->make('general',$data);
	}

	// Grocery CRUD - Blog Tags
	public function blog_tag()
	{
		$crud = $this->generate_crud('demo_blog_tags');
		$this->mTitle.= 'Blog Tags';
		$this->render_crud();
	}

	// Image CRUD - Cover Photos
	public function cover_photo()
	{
		$crud = $this->generate_image_crud('demo_cover_photos', 'image_url', UPLOAD_DEMO_COVER_PHOTO);
		$this->mTitle.= 'Cover Photos';
		$this->render_crud();
	}
	
	// Simple page with parameter
	public function item($demo_id)
	{
		$this->mTitle.= 'Item '.$demo_id;
		$data['demo_id'] = $demo_id;
		$this->make('demo/item',$data);
	}
	
	// Pagination widget
	public function pagination()
	{
		$this->load->library('pagination');
		$data['pagination'] = $this->pagination->render(200, 20);
		$this->mTitle.= 'Pagination';
		$this->make('demo/pagination',$data);
	}
	
	// Sortable widget
	public function sortable()
	{
		$data['entries'] = array(
			'Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5'
		);
		$this->mTitle.= 'Sortable';
		$this->make('demo/sortable',$data);
	}
}
