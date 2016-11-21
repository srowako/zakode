<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_m extends MY_Model {

	public $before_create = array('created_at');

	public function __construct()
	{
		parent::__construct();
		$this->_database   = $this->db;
	}

	// Get All Roles
	public function getRoles(){
		$roles = $this->role_m->order_by(['role_type'=>'ASC', 'created_at'=>'ASC'])->get_all();
		foreach ($roles as $k => $obj) {
			$roles[$k]->group_ids = unserialize($obj->group_ids);
		}

		return $roles;
	}
        
        public function get_all_roles($id=null){
		$user_roles = [];
		$this->load->model('role_m');
		$all_roles = $this->role_m->get_all();
		foreach ($all_roles as $role) {
			$groups = unserialize($role->group_ids);
			if(in_array($id, $groups))
				$user_roles[$role->id] = $role->role_name;
		}

		if(is_array($user_roles))
			return serialize($user_roles);

		return false;
	}
        
        public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('roles');
	}

}
