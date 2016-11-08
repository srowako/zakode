<?php
class Menu extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        Modules::run('auth/make_sure_is_logged_in');
    }
    public function index(){
        $this->mViewData['result'] = $this->db->from('navigations')
                        ->get();
        $this->mScripts['head'][] = base_url().'assets/js/jquery.nestable.js';
        $this->mStylesheets['head'][] = base_url().'assets/css/font-awesome.min.css';
        $this->render('v_menu');
//        $this->template->set_metadata('', base_url().'application/modules/options/_assets/css/style.css', 'css');
//        $this->template->set_metadata('', base_url().'application/modules/options/_assets/css/font-awesome.min.css', 'css');
//        $this->template->set_metadata('', base_url().'application/modules/options/_assets/js/jquery.nestable.js', 'js');
//        $this->template->build('v_menu', $data);
    }
    function get_menu($items, $class='dd-list') {
        $html = "<ol class=\"".$class."\" id=\"menu-id\">";
        foreach($items as $key=>$value) {
            $html.= '<li class="dd-item dd3-item" data-id="'.$value['id'].'" >
                        <div class="dd-handle dd3-handle"></div>
                        <div class="dd3-content"><span id="icon_show'.$value['id'].'" class="'.$value['icon'].'"></span><span id="label_show'.$value['id'].'"> '.$value['label'].'</span> 
                            <span class="span-right">/<span id="link_show'.$value['id'].'">'.$value['link'].'</span> &nbsp;&nbsp; 
                                <a class="edit-button" id="'.$value['id'].'" label="'.$value['label'].'" link="'.$value['link'].'" icon="'.$value['icon'].'" ><i class="fa fa-pencil"></i></a>
                                <a class="del-button" id="'.$value['id'].'"><i class="fa fa-trash-o"></i></a></span> 
                        </div>';
            if(array_key_exists('child',$value)) {
                $html .= $this->get_menu($value['child'],'child');
            }
                $html .= "</li>";
        }
        $html .= "</ol>";

        return $html;

    }
    function save_menu() {
        if($_POST['id'] != ''){
            $data = array(
                'title_en' => $_POST['label'],
                'url' => $_POST['link'],
                'icon' => $_POST['icon']
            );
            $this->db->where('id',$_POST['id']);
            $this->db->update('navigations',$data);
            $arr['type']  = 'edit';
            $arr['label'] = $_POST['label'];
            $arr['link']  = $_POST['link'];
            $arr['id']    = $_POST['id'];
            $arr['icon']    = $_POST['icon'];
        } else {
            $this->db->set('title_en',$_POST['label']);
            $this->db->set('url',$_POST['link']);
            $this->db->set('icon',$_POST['icon']);
            $this->db->insert('navigations');
            $last_id = $this->db->insert_id();            
            $arr['menu'] = '<li class="dd-item dd3-item" data-id="'.$last_id.'" >
                                    <div class="dd-handle dd3-handle"></div>
                                    <div class="dd3-content"><span class="'.$value['icon'].'"></span><span id="label_show'.$last_id.'">'.$_POST['label'].'</span>
                                        <span class="span-right">/<span id="link_show'.$last_id.'">'.$_POST['link'].'</span> &nbsp;&nbsp; 
                                                <a class="edit-button" id="'.$last_id.'" label="'.$_POST['label'].'" link="'.$_POST['link'].'" icon="'.$_POST['icon'].'" ><i class="fa fa-pencil"></i></a>
                                                <a class="del-button" id="'.$last_id.'"><i class="fa fa-trash-o"></i></a>
                                        </span> 
                                    </div>';
            $arr['type'] = 'add';
            $this->db->set('nav_id',$last_id);
            $this->db->set('group_id',1);
            $this->db->insert('nav_permissions');
        }
        print json_encode($arr);
    }
    
    function save(){
        $data = json_decode($_POST['data']);
        $readbleArray = $this->parseJsonArray($data);

        $i=0;
        foreach($readbleArray as $row){
            $i++;
            $data = array(
                'parent_id' => $row['parentID'],
                'order_c' => $i,
            );
            $this->db->where('id',$row['id']);
            $this->db->update('navigations',$data);            
        }

    }
    function parseJsonArray($jsonArray, $parentID = NULL) {
      $return = array();
      foreach ($jsonArray as $subArray) {
        $returnSubSubArray = array();
        if (isset($subArray->children)) {
                    $returnSubSubArray = $this->parseJsonArray($subArray->children, $subArray->id);
        }

        $return[] = array('id' => $subArray->id, 'parentID' => $parentID);
        $return = array_merge($return, $returnSubSubArray);
      }
      return $return;
    }
    
    function delete(){
        $id = $_POST['id'];
        $this->db->where('parent_id',$id);
        $this->db->from('navigations');
        $query = $this->db->count_all_results();
//        if ($query>0) {
//            foreach ($query as $delete){
            for ($i = 0; $i < $query; $i++){
                $this->db->delete('navigations',array('parent_id'=>$id));
           }
//        }
        $this->db->delete('navigations',array('id'=>$id));
        
        $this->db->where('nav_id',$id);
        $this->db->from('nav_permissions');
        $query_nav = $this->db->count_all_results();
            for ($n = 0; $n < $query_nav; $n++){
                $this->db->delete('nav_permissions',array('nav_id'=>$id));
           }
    }
}    