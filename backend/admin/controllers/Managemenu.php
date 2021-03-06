<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 * Managemenu Controller
 * 
 * This class controller is used for manage menu.
 */
class Managemenu extends Backend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('zakode_menu_model');
        $this->load->library('form_builder');
    }

    /**
     * Menu
     * @param integer $top_menu_id
     * @return string
     */
    public function menu($top_menu_id = NULL) {
        $this->add_script('assets/js/quickmenu_manage_jquery.nestable.js','foot');        
        $data['top_menu'] = $top_menu = $this->zakode_menu_model->get_top_menu();
        
        if ($top_menu_id == NULL && $top_menu != NULL) {
            redirect(site_url("admin/managemenu/menu/" . $top_menu['0']->id));
        }

        $data['top_menu_id'] = $top_menu_id;
        $data['top_menu_detail'] = $this->zakode_menu_model->get_menu_detail($top_menu_id);
        $this->make('managemenu/manage', $data);
    }

    /**
     * add
     * add menu by post method
     * return string
     */
    public function add() {
        $data['m_groups'] = ($this->input->post('m_groups')) ? $this->input->post('m_groups') : NULL;
        if (isset($data['m_groups'])) {
//            $data['title'] = ($this->input->post('title')) ? $this->input->post('title') : 'untitled';
            $data['label'] = ($this->input->post('label')) ? $this->input->post('label') : 'unlabel';
            $data['url'] = ($this->input->post('url')) ? $this->input->post('url') : '#';
            $data['icon'] = ($this->input->post('icon')) ? $this->input->post('icon') : 'fa fa-ellipsis-v';
//            $data['new_tab'] = ($this->input->post('newtab')) ? $this->input->post('newtab') : '0';
//            $data['css'] = ($this->input->post('css')) ? $this->input->post('css') : NULL;
            $data['description'] = ($this->input->post('description')) ? $this->input->post('description') : '';
            $data['created_at'] = time();
            $data['updated_at'] = time();
            $this->zakode_menu_model->add_record($data);
            exit;
        }
        echo 'error';
        exit;
    }

    /**
     * reorder
     * reorder menu as show in front end 
     * return string
     */
    function reorder() {
        $source = $this->input->post('source');
        $destination = $this->input->post('destination');
        $update_reorder['parent_id'] = $destination;
        $update_reorder['menuFK'] = NULL;
        if (isset($destination) && $destination > '0') {
            $update_reorder['menuFK'] = $destination;
        }
        $this->zakode_menu_model->update_reorder_destination($source, $update_reorder);
        $ordering = json_decode($this->input->post('order'));
        $rootOrdering = json_decode($this->input->post('rootOrder'));
        if ($ordering) {
            foreach ($ordering as $order => $item_id) {
                $this->zakode_menu_model->update_reorder_ordering($item_id, $order);
            }
        } else {
            foreach ($rootOrdering as $order => $item_id) {
                $this->zakode_menu_model->update_reorder_root($item_id, $order);
            }
        }

        return "ok";
    }

    /**
     * edit
     * add menu by post method
     * return string
     */
    public function edit() {
        if ($this->input->post() && $this->input->post('edit_id')) {
            $id = $this->input->post('edit_id');
//            $data['title'] = ($this->input->post('edit_title')) ? $this->input->post('edit_title') : 'untitled';
            $data['label'] = ($this->input->post('edit_label')) ? $this->input->post('edit_label') : 'unlabel';
            $data['url'] = ($this->input->post('edit_url')) ? $this->input->post('edit_url') : '#';
            $data['icon'] = ($this->input->post('edit_icon')) ? $this->input->post('edit_icon') : 'fa fa-ellipsis-v';
//            $data['new_tab'] = ($this->input->post('edit_new_tab')) ? $this->input->post('edit_new_tab') : '0';
//            $data['css'] = ($this->input->post('edit_css')) ? $this->input->post('edit_css') : NULL;
            $data['description'] = ($this->input->post('edit_description')) ? $this->input->post('edit_description') : '';
            $data['updated_at'] = time();
            $this->zakode_menu_model->edit_record($id, $data);
            exit;
        }
        echo "error";
    }

    /**
     * delete
     * delete particular menu by id
     * return string
     */
    public function delete() {
        $id = $this->input->post('delete_id');
        $this->zakode_menu_model->delete_record($id);
    }

    /**
     * add_to_menu
     * add new menu by post method
     * @return string
     */
    public function add_to_menu() {
        $data['title'] = ($this->input->post('title')) ? $this->input->post('title') : 'Top Menu';
        $data['effect'] = $this->input->post('effect');
        $data['color'] = $this->input->post('color');
        $this->zakode_menu_model->add_to_menu_item($data);
    }

    /**
     * delete_top_menu
     * @param integer
     * delete top menu by particular id
     */
    public function delete_top_menu($id = NULL) {
        if ($id != NULL) {
            $this->zakode_menu_model->delete_top_menu_item($id);
        }
        redirect(site_url('managemenu/menu'));
    }

    /**
     * edit_top_menu
     * edit top menu by post method
     * @return string
     */
    public function edit_top_menu() {
        if ($this->input->post() && $this->input->post('top_menu_id')) {
            $id = $this->input->post('top_menu_id');
            $data['title'] = ($this->input->post('edit_top_menu_title')) ? $this->input->post('edit_top_menu_title') : 'untitled';
            $data['effect'] = $this->input->post('effect');
            $data['color'] = $this->input->post('color');
            $this->zakode_menu_model->edit_top_menu_record($id, $data);
        }
        echo "error";
    }

    /**
     * get_edit_top_menu_data
     * Get edit top menu detail and use in ajax
     * return string
     */
    public function get_edit_top_menu_data() {
        $edit_id = $this->input->post('edit_id');
        $record = $this->zakode_menu_model->get_menu_detail($edit_id);
        echo $record->title . "###" . $record->effect . "###" . $record->color;
    }
    
    /**
     * get_permissions_menu_data
     * Get permissions detail
     */
    public function setpermission() {
        $crud = $this->generate_crud('zakode_menus');
        $crud->columns('url', 'Permission');
        $crud->fields('Permission');
        $text_update = 'Your data has been successfully stored into the database.<br/>Please wait while you are redirecting to the list page.<script type="text/javascript">window.location = "admin/managemenu/menu/75";</script><div style="display:none">';
        $crud->set_lang_string('update_success_message',$text_update);
        $crud->set_relation_n_n('Permission', 'menus_permissions', 'admin_groups', 'menu_id', 'group_id', 'description', 'priority');
        $crud->unset_back_to_list();
        $crud->unset_list();
        $crud->unset_delete();
        $this->render_crud();
    } 

    
}

/* end of class Managemenu  */
/* end of file ..Inhouse/includes/classes/managemenu.php */