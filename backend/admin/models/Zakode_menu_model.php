<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 * Zakode_menu_model model
 * 
 * This class model is used for manage menu.
 */
class Zakode_menu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * get_menu
     * @param integer $top_menu_id
     * @return array
     */
    public function get_menu($top_menu_id) {
        $result = $this->db->from(ZAKODE_MENU)->order_by('order', 'asc')->where(array('m_groups' => $top_menu_id))->get();
        return $this->buildMenu($result->result());
    }

    /**
     * get_top_menu
     * @return array
     */
    public function get_top_menu() {
        $result = $this->db->from(ZAKODE_MENU)->order_by('order', 'asc')->where(array('m_groups' => '0'))->get();
        if ($result->num_rows() > '0')
            return $result->result();
        return NULL;
    }

    /**
     * buildMenu
     * @param array, integer
     * @return string
     * 
     */
    public function buildMenu($menu, $parentid = 0) {
        $result = null;
        foreach ($menu as $item) {
            if ($item->parent_id == $parentid) {
                $result .= "<li class='dd-item nested-list-item' data-order='$item->order' data-id='$item->id' id='$item->id'>
	      <div class='dd-handle nested-list-handle'>
	        <span class='glyphicon glyphicon-move'></span>
	      </div>
	      <div class='nested-list-content'><span id='menu_title_$item->id' class='".$item->icon."' > $item->label</span>
	        <div class='pull-right'>
                <input type='hidden' id='label_" . $item->id . "' value='" . $item->label . "'>
                <input type='hidden' id='url_" . $item->id . "' value='" . $item->url . "'>
                <input type='hidden' id='icon_" . $item->id . "' value='" . $item->icon . "'>
                <input type='hidden' id='description_" . $item->id . "' value='" . $item->description . "'>
                  <a href='".base_url()."admin/managemenu/setpermission/edit/".$item->id."'>Permission</a> |
	          <a href='javascript:;' class='edit_toggle' rel='$item->id'>Edit</a> |
	          <a href='javascript:;' class='delete_toggle' rel='$item->id'>Delete</a>
	        </div>
	      </div>" . $this->buildMenu($menu, $item->id) . "</li>";
            }
        }
        return $result ? "\n<ol id='top_ol' class=\"dd-list\">\n$result</ol>\n" : null;
    }
//    <input type='hidden' id='title_" . $item->id . "' value='" . $item->title . "'>
//    <input type='hidden' id='new_tab_" . $item->id . "' value='" . $item->new_tab . "'>
//    <input type='hidden' id='css_" . $item->id . "' value='" . $item->css . "'>

    /**
     * get_menu_detail
     * @param integer $id
     * @return array
     */
    public function get_menu_detail($id = NULL) {
        if ($id != NULL) {
            $result = $this->db->from(ZAKODE_MENU)->where(array('id' => $id))->get();
            if ($result->num_rows() > '0')
                return $result->row();
        }
        return NULL;
    }

    /**
     * add_record
     * @param array $data
     * @return string
     */
    public function add_record($data) {
        $this->db->select_max('order', 'max_order');
        $query = $this->db->get(ZAKODE_MENU)->row();
        $data['order'] = ($query->max_order + 1);
        $this->db->insert(ZAKODE_MENU, $data);
        $ins_id = $this->db->insert_id();
        $str = '<li class="dd-item nested-list-item" data-order="1" data-id="' . $ins_id . '" id="' . $ins_id . '">
                <div class="dd-handle nested-list-handle">
	        <span class="glyphicon glyphicon-move"></span>
                </div>
                <div class="nested-list-content"><span id="menu_title_' . $ins_id . '"  class="'.$data['icon'].'">' . $data['label'] . '</span>
	        <div class="pull-right">                
                <input type="hidden" id="label_' . $ins_id . '" value="' . $data['label'] . '">
                <input type="hidden" id="url_' . $ins_id . '" value="' . $data['url'] . '">
                <input type="hidden" id="icon_' . $ins_id . '" value="' . $data['icon'] . '">   
		<input type="hidden" id="description_' . $ins_id . '" value="' . $data['description'] . '">
                <a href="'.base_url().'"admin/managemenu/setpermission/edit/"'.$item->id.'">Permission</a> |
	        <a href="javascript:;" class="edit_toggle" rel="' . $ins_id . '">Edit</a> |
	        <a href="javascript:;" class="delete_toggle" rel="' . $ins_id . '">Delete</a>
	        </div>
                </div></li>';
        echo $str;
        $data_group = array(
            'menu_id'   => $ins_id,
            'group_id'  => 1
        );
        $this->db->insert('menus_permissions',$data_group);
    }
//<input type="hidden" id="title_' . $ins_id . '" value="' . $data['title'] . '">
//    <input type="hidden" id="new_tab_' . $ins_id . '" value="' . $data['new_tab'] . '">
//        <input type="hidden" id="css_' . $ins_id . '" value="' . $data['css'] . '">
    
    /**
     * edit_record
     * @param array $data,integer $id
     * @return string
     */
    public function edit_record($id, $data) {
        if ($this->db->where(array('id' => $id))->update(ZAKODE_MENU, $data)) {
            echo "ok";
        }
    }

    /**
     * delete_record
     * @param integer $id
     * @return string
     */
    public function delete_record($id) {
        if ($this->db->where(array('id' => $id))->delete(ZAKODE_MENU)) {
            echo "ok";
            $this->db->where('menu_id',$id)->delete('menus_permissions');            
        } else {
            echo 'error';
        }
    }

    /**
     * add_to_menu_item
     * @param array $data
     * @return string
     */
    public function add_to_menu_item($data) {
        if ($this->db->insert(ZAKODE_MENU, $data)) {
            echo $this->db->insert_id();
            exit;
        }
        echo 'error';
        exit;
    }

    /**
     * delete_top_menu_item
     * @param integer $id
     * @return null
     */
    public function delete_top_menu_item($id) {
        $this->db->or_where(array('m_groups' => $id, 'id' => $id))->delete(ZAKODE_MENU);
    }

    /**
     * edit_top_menu_record
     * @param integer $id, array $data
     * @return null
     */
    public function edit_top_menu_record($id, $data) {
        if ($this->db->where(array('id' => $id))->update(ZAKODE_MENU, $data)) {
            echo "ok";
            exit;
        }
    }

    /**
     * update_reorder_destination
     * @param string $source, array $update_reorder
     * @return null
     */
    public function update_reorder_destination($source, $update_reorder) {
        $this->db->where(array('id' => $source))->update(ZAKODE_MENU, $update_reorder);
    }

    /**
     * update_reorder_ordering
     * @param string $order, integer $item_id
     * @return null
     */
    public function update_reorder_ordering($item_id, $order) {
        $this->db->where(array('id' => $item_id))->update(ZAKODE_MENU, array('order' => $order));
    }

    /**
     * update_reorder_root
     * @param string $order, integer $item_id
     * @return null
     */
    public function update_reorder_root($item_id, $order) {
        $this->db->where(array('id' => $item_id))->update(ZAKODE_MENU, array('order' => $order));
    }

}

/* end of class Zakode_menu_model  */
/* end of file ..Inhouse/includes/classes/Zakode_menu_model.php */