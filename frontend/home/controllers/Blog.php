<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Blog extends Frontend_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->library('form_builder');
            $this->push_breadcrumb('Demo');
    }
    public function index()
    {
            $page = $this->input->get('p');
            $page = empty($page) ? 1 : $page;

            $this->load->model('Demo_blog_post_model', 'posts');
            $results = $this->posts->with('category')->with('author')->paginate($page);
            $posts = $results['data'];
            $counts = $results['counts'];

            // call render() from MY_Pagination
            $this->load->library('pagination');
            $pagination = $this->pagination->render($counts['total_num'], $counts['limit']);

            $data['posts'] = $posts;
            $data['counts'] = $counts;
            $data['pagination'] = $pagination;
            $this->load->view('blogs',$data);
    }
    public function test()
    {
        echo 'test 123';
    }
}
