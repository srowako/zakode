<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
	
class Module extends Backend_Controller {
    var $data = array();
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->helper('xml');
        $this->db->order_by('type','ordering');
        $query = $this->db->get('modules');

        if($rows = $query->result_array())
        {
            $modules = array();
            foreach ( $rows as $module ) 
            {
                $modules[ $module['name'] ] = $module;
            }
        }
        /*
        Check if all physical modules are installed
        */
        unset( $module );
        $handle = opendir(APPPATH.'../zakode/uploads/');
        if ($handle)
        {
            while ( false !== ($module = readdir($handle)) )
            {
                // make sure we don't map silly dirs like .svn, or . or .. 
                //APPPATH.'../zakode/uploads/' => '../../zakode/uploads/'
                if ( (substr($module, 0, 1) != ".") && file_exists(APPPATH.'../zakode/uploads/' .$module. '/setup.xml') )
                {
                    if ( !isset($modules[$module]))
                    {
                        $modules[$module] = array(
                                'name' => $module,
                                'type' => null,
                                'status' => -1,
                                'description' => null,
                                'version' => null
                        );
                    }
                    else
                    {
                        //get physical version from xml for eventual update
                        $xmldata = join('', file(APPPATH.'../zakode/uploads/' .$module. '/setup.xml'));
                        $xmlarray = xmlize($xmldata);
                        if (isset($xmlarray['module']['#']['name'][0]['#']) && trim($xmlarray['module']['#']['name'][0]['#']) == $module)
                        {

                            $modules[$module]['nversion'] = isset($xmlarray['module']['#']['version'][0]['#']) ? trim($xmlarray['module']['#']['version'][0]['#']) : '';							}
                    }
                }
//                    $modserver = Modules::run('admin/get_modules'); //Release New Modules from Repository
            }
        }
        $this->data['modules'] = $modules;
//        $this->data['modserver'] = $modserver;
        $this->make('module',$this->data);
    }

    function wget()
    {
        $this->load->helper('xml');
        $this->db->order_by('type','ordering');
        $query = $this->db->get_where('modules', array('type =' => 'Frontend wiget'));
        if($rows = $query->result_array())
        {
            $modules = array();
            foreach ( $rows as $module ) 
            {
                $modules[ $module['name'] ] = $module;
            }
        }
        /*
        Check if all physical modules are installed
        */
        unset( $module );
        $handle = opendir(APPPATH.'../zakode/uploads/');
        if ($handle)
        {
            while ( false !== ($module = readdir($handle)) )
            {
                // make sure we don't map silly dirs like .svn, or . or .. 
                //APPPATH.'../zakode/uploads/' => '../../zakode/uploads/'
                if ( (substr($module, 0, 1) != ".") && file_exists(APPPATH.'../zakode/uploads/' .$module. '/setup.xml') )
                {
                    if ( !isset($modules[$module]))
                    {
                        $modules[$module] = array(
                                'name' => $module,
                                'type' => null,
                                'status' => -1,
                                'description' => null,
                                'version' => null
                        );
                    }
                    else
                    {
                        //get physical version from xml for eventual update
                        $xmldata = join('', file(APPPATH.'../zakode/uploads/' .$module. '/setup.xml'));
                        $xmlarray = xmlize($xmldata);
                        if (isset($xmlarray['module']['#']['name'][0]['#']) && trim($xmlarray['module']['#']['name'][0]['#']) == $module)
                        {

                            $modules[$module]['nversion'] = isset($xmlarray['module']['#']['version'][0]['#']) ? trim($xmlarray['module']['#']['version'][0]['#']) : '';							}
                    }
                }
//                    $modserver = Modules::run('admin/get_modules'); //Release New Modules from Repository
            }
        }
        $this->data['modules'] = $modules;
//        $this->data['modserver'] = $modserver;
        $this->make('module',$this->data);
    }
    
    function activate($module = null)
    {
        if (is_null($module))
        {
            m('m', t('Please select a module'));
            redirect('admin/module');
        }
        $data = array('status' => 1);
        $this->db->where(array('name'=> $module, 'ordering >=' => 100));
        $this->db->update('modules', $data);
        m('s',t('The module is activated'));
        redirect('admin/module');
    }

    function deactivate($module = null)
    {
        if (is_null($module))
        {
            redirect('admin/module');
        }
        $data = array('status' => 0);
        $this->db->where(array('name'=> $module, 'ordering >=' => 100));
        $this->db->update('modules', $data);
        m('s',t('The module is deactivated'));
        redirect('admin/module');
    }

    function move($direction = null, $module = null)
    {
        if (is_null($module) || is_null($direction))
        {
            redirect('admin/module');
        }

        $move = ($direction == 'up') ? -1 : 1;
        $this->db->where(array('name' => $module, 'ordering >=' => 100));
        $this->db->set('ordering', 'ordering+'.$move, FALSE);
        $this->db->update('modules');

        $this->db->where(array('name' => $module, 'ordering >=' => 100));
        $query = $this->db->get('modules');
        $row = $query->row();
        $new_ordering = $row->ordering;

        if ( $move > 0 )
        {
            $this->db->set('ordering', 'ordering-1', FALSE);
            $this->db->where(array('ordering <=' => $new_ordering, 'name <>' => $module));
            $this->db->update('modules');
        }
        else
        {
            $this->db->set('ordering', 'ordering+1', FALSE);
            $this->db->where(array('ordering >=' => $new_ordering, 'name <>' => $module));
            $this->db->update('modules');			
        }
        //reordinate
        $i = 101;
        $this->db->order_by('ordering');
        $this->db->where(array('ordering >=' => 100) );
        $query = $this->db->get('modules');
        if ($rows = $query->result())
        {
            foreach ($rows as $row)
            {
                $this->db->set('ordering', $i);
                $this->db->where('name', $row->name);
                $this->db->update('modules');
                $i++;
            }
        }

        redirect('admin/module');
    }

    /*
    this is to update the module table 
    it just includes the file <module>_update.php in each module dir
    */
    function update($module = null)
    {
        if (is_null($module))
        {
            redirect('admin/module');
        }
        if (is_readable(APPPATH.'../zakode/uploads/' .$module. '/' . $module .'_update.php'))
        {
            include( APPPATH.'../zakode/uploads/' .$module. '/' . $module .'_update.php' );
            m('s',t('The module is update'));
            redirect('admin/module');		
        }
        else
        {
            redirect('admin/module');		
        }

    }

    function uninstall($module = null)
    {
        if (is_null($module))
        {
            redirect('admin/module');
        }
        if (is_readable(APPPATH.'../zakode/uploads/' .$module. '/setup.xml'))
        {
            $this->load->helper('xml');
            $xmldata = join('', file(APPPATH.'../zakode/uploads/' .$module. '/setup.xml'));
            $xmlarray = xmlize($xmldata);
            if (isset($xmlarray['module']['#']['name'][0]['#']) && trim($xmlarray['module']['#']['name'][0]['#']) == $module){
                if (isset($xmlarray['module']['#']['uninstall'][0]['#']['query']))
                {
                    $queries = $xmlarray['module']['#']['uninstall'][0]['#']['query'];
                    foreach ($queries as $query)
                    {
                        $this->db->query( $query['#'] );
                    }
                }
            }
        }
        
        $this->db->where(array('name'=> $module, 'ordering >=' => 100));
        $this->db->delete('modules');
        if (is_file(APPPATH.'../zakode/uploads/' .$module. '/'.$module.'_uninstall.php'))
        {
            @include(APPPATH.'../zakode/uploads/' .$module. '/'.$module.'_uninstall.php');
        }
        m('s',t('The module is uninstall'));
        redirect('admin/module');
    }

    function install($module = null)
    {
        if (is_null($module)) 
        {
            redirect('admin/module');
        }

        if ($this->_is_installed($module))
        {
            redirect('admin/module');
        }

        //now install it
        if (is_readable(APPPATH.'../zakode/uploads/' .$module. '/setup.xml'))
        {
            $this->load->helper('xml');
            $xmldata = join('', file(APPPATH.'../zakode/uploads/' .$module. '/setup.xml'));
            $xmlarray = xmlize($xmldata);
            if (isset($xmlarray['module']['#']['name'][0]['#']) && trim($xmlarray['module']['#']['name'][0]['#']) == $module)
            {
                $data['name'] = trim($xmlarray['module']['#']['name'][0]['#']);
                $data['type'] = trim($xmlarray['module']['#']['type'][0]['#']);
                $data['description'] = isset($xmlarray['module']['#']['description'][0]['#']) ? trim($xmlarray['module']['#']['description'][0]['#']): '';
                $data['version'] = isset($xmlarray['module']['#']['version'][0]['#']) ? trim($xmlarray['module']['#']['version'][0]['#']) : '';
                $data['status'] = 0;
                $data['ordering'] = 1000;
                $info['date'] = $xmlarray['module']['#']['date'][0]['#'];
                $info['author'] = $xmlarray['module']['#']['author'][0]['#'];
                $info['email'] = $xmlarray['module']['#']['email'][0]['#'];
                $info['url'] = $xmlarray['module']['#']['url'][0]['#'];
                $info['copyright'] = $xmlarray['module']['#']['copyright'][0]['#'];

                $data['info'] = json_encode($info);

                if (file_exists(APPPATH.'../zakode/uploads/' .$module. '/controllers/admin.php') || file_exists(APPPATH.'../modules/uploads/' .$module. '/controllers/admin/admin.php'))
                {
                    $data['with_admin'] = 1;
                }
                //execute queries
                if (isset($xmlarray['module']['#']['install'][0]['#']['query']))
                {
                    $queries = $xmlarray['module']['#']['install'][0]['#']['query'];
                    foreach ($queries as $query)
                    {
                        $this->db->query( $query['#'] );
                    }
                }                

                if (is_file(APPPATH.'../zakode/uploads/' .$module. '/'.$module.'_install.php'))
                {
                    @include(APPPATH.'../zakode/uploads/' .$module. '/'.$module.'_install.php');
                }

                $this->db->insert('modules', $data);
                m('s',t('The module is instaled'));
                redirect($_SERVER['REQUEST_URI'], 'refresh');
            }
            else
            {
                redirect($_SERVER['REQUEST_URI'], 'refresh');
            }

        }
        else
        {
            redirect($_SERVER['REQUEST_URI'], 'refresh');
        }
    }

    function _is_installed($module)
    {
        $query = $this->db->get_where('modules', array('name' => $module), 1);
        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get(){
        $this->load->library('rest');
        $config = array('server'    => 'http://aapialang.co.id/api');
        $this->rest->initialize($config); 
        $result = $this->rest->get('license/modules', array('code' => '123321'), 'json');
        return $result;
    }

}

?>