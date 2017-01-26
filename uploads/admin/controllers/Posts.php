<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends Backend_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Post');
        $this->load->model('Category');
        $this->load->model('Tag');
        $data['parent_menu'] = 'post';
        $data['page_title'] = 'Posts';
        $data['post_status'] = array(
            0 => 'Draft',
            1 => 'Publish',
            2 => 'Block'
        );
	}

    public function index(){
        $config['base_url'] = site_url('admin/posts/index/');
        $config['total_rows'] = count($this->Post->find());
        $config['per_page'] = 10;
        $config["uri_segment"] = 4;
        $user_id = null;
        $data['post_status'] = array(
            0 => 'Draft',
            1 => 'Publish',
            2 => 'Block'
        );

//        if(!in_array('admin', $this->current_groups)){
            $user_id = $this->session->userdata('user_id');
//        }


        if ($this->input->get('q')):
            $q = $this->input->get('q');
            $data['posts'] = $this->Post->find($config['per_page'], $this->uri->segment(4),$user_id, $q);
            if (empty($data['posts'])) {
                $this->session->set_flashdata('message', message_box('Data tidak ditemukan','danger'));
                redirect('admin/posts/index');
            }
            $config['total_rows'] = count($data['posts']);
        else:
            $data['posts'] = $this->Post->find($config['per_page'], $this->uri->segment(4),$user_id);
        endif;
//        $data['pagination'] = $this->bootstrap_pagination($config);
        
		$this->make('blog_posts',$data);
	}

	public function add(){
            $this->load->library('form_validation');
            $this->add_stylesheet('assets/css/select2.min.css');
            $this->add_stylesheet('assets/css/bootstrap3-wysihtml5.min.css');
            $this->add_stylesheet('assets/css/editor.css');
            $this->add_script('assets/js/bootstrap3-wysihtml5.all.min.js','foot');
            $this->add_script('assets/js/fullcalendar.min.js','foot');
            $this->add_script('assets/js/bootstrap-datepicker.js','foot');
            
            $this->add_script('assets/js/editor.js','foot');
            $this->add_script('assets/js/select2.min.js','foot');
            $this->form_validation->set_rules('title', 'title', 'required|is_unique[posts.title]');
            $this->form_validation->set_rules('body', 'body', 'required');
            if($this->ion_auth->is_admin()){        
                $this->form_validation->set_rules('status', 'status', 'required');
            }
            $this->form_validation->set_rules('published_at', 'date', '');
            $this->form_validation->set_error_delimiters('', '<br/>');
            if ($this->form_validation->run() == TRUE) {

                $data = $_POST;
                // print_data($data);exit;
                unset($data['category']);
                unset($data['tag']);
                $data['type'] = 'post';
                $data['created'] = date("Y-m-d H:i:s");
                $data['modified'] = date("Y-m-d H:i:s");
                $data['user_id'] = $this->session->userdata('user_id');

                if(!$this->ion_auth->is_admin()){
                    $data['status'] = 0;
                }

                $this->Post->create($data);

                $post_id = $this->db->insert_id();

                if(!empty($_POST['category'])){
                    foreach($_POST['category'] as $key => $cat_id){
                        $post_category = array(
                            'post_id' => $post_id,
                            'category_id' => $cat_id
                        );
                        $this->db->insert('posts_categories',$post_category);
                    }
                }

                if(!empty($_POST['tag'])){
                    foreach($_POST['tag'] as $key => $tag){
                        $existTag = $this->Tag->find_by_id($tag);
                        if(!empty($existTag)){
                            $post_tag = array(
                                'post_id' => $post_id,
                                'tag_id' => $tag
                            );
                            $this->db->insert('posts_tags',$post_tag);
                        }else{

                            $newTag = array(
                                'name' => $tag,
                                'slug' => url_title($tag,'-',true),
                                'status' => 1
                            );

                            $this->db->insert('tags',$newTag);
                            $tag_id = $this->db->insert_id();
                            $post_tag = array(
                                'post_id' => $post_id,
                                'tag_id' => $tag_id
                            );
                            $this->db->insert('posts_tags',$post_tag);
                        }
                    }
                }
                $this->session->set_flashdata('message', message_box('New post has been saved','success'));
                redirect('admin/posts');
            }
            $data['categories'] = $this->Category->find_list();
            $data['tags'] = $this->Tag->find_list();
            $this->make('blog_add', $data);
	}

	public function edit($id = null){
        if($id == null){
            $id = $this->input->post('id');
        }


        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('body', 'body', 'required');

        if($this->ion_auth->is_admin()){        
            $this->form_validation->set_rules('status', 'status', 'required');
        }
        
        $this->form_validation->set_rules('published_at', 'date', '');
        $this->form_validation->set_error_delimiters('', '<br/>');
        if ($this->form_validation->run() == TRUE) {
         
            $data = $_POST;
            unset($data['category']);
            unset($data['tag']);

            $data['modified'] = date("Y-m-d H:i:s");
            // $data['user_id'] = $this->session->userdata('user_id');

            $this->Post->update($data,$id);
      
            $post_id = $id;
      
            if(!empty($_POST['category'])){
                $this->db->where('post_id',$post_id);
                $this->db->where_not_in('category_id',$_POST['category']);
                $this->db->delete('posts_categories');

                foreach($_POST['category'] as $key => $cat_id){
                
                    if($this->db->where(array('post_id' => $post_id, 'category_id' => $cat_id))->get('posts_categories',1)->num_rows() < 1){
                        $post_category = array(
                            'post_id' => $post_id,
                            'category_id' => $cat_id
                        );
                        $this->db->insert('posts_categories',$post_category);
                    }
                }
            }

            if(!empty($_POST['tag'])){
                $this->db->where('post_id',$post_id);
                $this->db->where_not_in('tag_id',$_POST['tag']);
                $this->db->delete('posts_tags');

                foreach($_POST['tag'] as $key => $tag){
                    $existTag = $this->Tag->find_by_id($tag);
                    if(!empty($existTag)){
                        if($this->db->where(array('post_id' => $post_id, 'tag_id' => $tag))->get('posts_tags',1)->num_rows() < 1){
                            $post_tag = array(
                                'post_id' => $post_id,
                                'tag_id' => $tag
                            );
                            $this->db->insert('posts_tags',$post_tag);
                        }
                    }else{

                        $newTag = array(
                            'name' => $tag,
                            'slug' => url_title($tag,'-',true),
                            'status' => 1
                        );

                        $this->db->insert('tags',$newTag);
                        $tag_id = $this->db->insert_id();
                        $post_tag = array(
                            'post_id' => $post_id,
                            'tag_id' => $tag_id
                        );
                        $this->db->insert('posts_tags',$post_tag);
                    }
                }
            }
            $this->session->set_flashdata('message', message_box('Post has been saved','success'));
            redirect('admin/posts');
        }
        $data['post'] = $this->Post->find_by_id($id);
        $data['categories'] = $this->Category->find_list();
        $data['tags'] = $this->Tag->find_list();
        $current_category = $this->db->select('category_id')->where(array('post_id' => $data['post']['id']))->get('posts_categories')->result_array();
        $current_tag = $this->db->select('tag_id')->where(array('post_id' => $data['post']['id']))->get('posts_tags')->result_array();
        $category_ids = array();
        if(!empty($current_category)){
            foreach($current_category as $current){
                $category_ids[] = $current['category_id'];
            }
        }

        $tag_ids = array();
        if(!empty($current_tag)){
            foreach($current_tag as $cur_tag){
                $tag_ids[] = $cur_tag['tag_id'];
            }
        }

        $data['category_ids'] = $category_ids;
        $data['tag_ids'] = $tag_ids;

        $this->load_admin('posts/edit');
	}

	public function delete($id = null){
		if(!empty($id)){
            $this->Post->delete($id);
            $this->session->set_flashdata('message',message_box('Post has been deleted','success'));
            redirect('admin/posts/index');
        }else{
            $this->session->set_flashdata('message',message_box('Invalid id','danger'));
            redirect('admin/posts/index');
        }
	}
}
