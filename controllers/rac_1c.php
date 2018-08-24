<?php

/**
 * Server 1C webapps controller.
 *
 * @category   apps
 * @package    server-1c
 * @subpackage controllers
 * @author     High Tech Lider ltd. <htlead@htlead.kz>
 * @copyright  2018 High Tech Lider
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       https://github.com/htlead/clear_os_1c_server
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// D E P E N D E N C I E S
///////////////////////////////////////////////////////////////////////////////

use \Exception as Exception;

use \clearos\apps\base\Daemon as Daemon;

clearos_load_library('base/Daemon');

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Server 1C webapps controller.
 *
 * @category   apps
 * @package    server-1c
 * @subpackage controllers
 * @author     High Tech Lider ltd. <htlead@htlead.kz>
 * @copyright  2018 High Tech Lider
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       https://github.com/htlead/clear_os_1c_server
 */

class Rac_1c extends ClearOS_Controller
{
    /**
     * Sites summary view.
     *
     * @return view
     */

    function index()
    {
        // Load libraries
        //---------------

        $this->load->library('server_1c/Server_1C');
        $this->lang->load('server_1c');
        
	$data['server_1c'] = $this->server_1c;

        // Handle form submit
        //-------------------


        // Load view data
        //---------------
        
	try {
	    $ras = new Daemon('ras');
	    $data['running_state'] = $ras->get_running_state();
	    if($data['running_state']){
		$data['clusters']      = $this->server_1c->get_clusters_list();
	    }else{
		$data['clusters'] = array();
	    }
        } catch (Exception $e) {
            $this->page->set_message('Remote Administrative Client: '.clearos_exception_message($e));
        }	
	
        // Load views
	$this->page->view_form('rac/clusters', $data, lang('server_1c_app_name'));

    }
    
    function infobaseslist($cluster)
    {    
	$this->load->library('server_1c/Server_1C');
	
	$data['infobases'] = $this->server_1c->get_infobases_list($cluster);	
	$data['cluster']   = $cluster;
	
	$this->page->view_form('rac/infobaseslist', $data, lang('server_1c_rac_app_name'));
    }
    
    function infobaseadd($cluster)
    {
	$this->load->library('server_1c/Server_1C');
	$this->load->library('base/Country');
	
	$data['LOCALE']          = $this -> country -> get_list();
	$data['locale']          = 'RU';
	$data['cluster']         = $cluster;
	$data['dbms']            = 'PostgreSQL';
	$data['sjd']             = 'off';
	$data['create_database'] = true;
	
	$this->page->view_form('rac/infobaseadd', $data, lang('server_1c_rac_app_name'));
    }
    
    function infobase_add()
    {
	$this->load->library('server_1c/Server_1C');
	
	$this->form_validation->set_policy('name',  'server_1c/Server_1C',     'validate_base',    TRUE);
	$this->form_validation->set_policy('db_server', 'server_1c/Server_1C', 'validate_server',   TRUE);
	$this->form_validation->set_policy('db_name',   'server_1c/Server_1C', 'validate_base',     TRUE);
	$this->form_validation->set_policy('db_user',   'server_1c/Server_1C', 'validate_base',     TRUE);
	
	$form_ok = $this->form_validation->run();
	
	$cluster          =   $this->input->post('cluster');
	$name             =   $this->input->post('name');
	$dbms             =   $this->input->post('dbms');  
	$db_server        =   $this->input->post('db_server');
	$db_name          =   $this->input->post('db_name');
	$db_user          =   $this->input->post('db_user');   
	$db_pwd           =   $this->input->post('db_pwd');    
	$create_database  =   $this->input->post('create_database');   
	$locale           =   $this->input->post('locale');    
	$SJD              =   $this->input->post('scheduled_jobs_deny');
	try{
	    if($form_ok)
	    {
		$output=$this->server_1c->add_infobase($cluster, $name, $dbms, $db_server, $db_name, $db_user, $db_pwd, $create_database, $locale, $SJD);
		if($output['exitcode']==0){
		    redirect('/server_1c/rac_1c/infobaseslist/'.$cluster);
		    return;
		}else{
		    $this->page->set_message('Remote Administrative Client: '.$output['output']);
		}
		
	    }
	}catch(Exception $e){
	    $this->page->set_message('Remote Administrative Client: '.clearos_exception_message($e));
	}
	
	$this->infobaseadd($cluster);
    }
    
    function infobasedrop($cluster, $infobase)
    {
	$this->load->library('server_1c/Server_1C');

        $confirm_uri = '/app/server_1c/rac_1c/infobase_drop/'.$cluster.'/'.$infobase;
        $cancel_uri =  '/app/server_1c/rac_1c/infobaseslist/'.$cluster;
        $items = array(lang('server_1c_rac_infobase_drop_confirm'));
    
        $this->page->view_confirm_delete($confirm_uri, $cancel_uri, $items);
    }
    
    function infobase_drop($cluster, $infobase)
    {
	$this->load->library('server_1c/Server_1C');
	
	$this->server_1c->drop_infobase($cluster, $infobase);
	redirect('/server_1c/rac_1c/infobaseslist/'.$cluster);
    }
    
    function sessionslist($cluster, $infobase)
    {
	$this->load->library('server_1c/Server_1C');
	
	$data['sessions'] = $this->server_1c->get_sessions_list($cluster, $infobase);
	$data['cluster']  = $cluster;
	$data['infobase'] = $infobase;
	
	$this->page->view_form('rac/sessionslist', $data, lang('server_1c_rac_app_name'));
    }
    
    function terminatesession($cluster, $infobase, $session)
    {
	$this->load->library('server_1c/Server_1C');

        $confirm_uri = '/app/server_1c/rac_1c/terminate_session/'.$cluster.'/'.$infobase.'/'.$session;
        $cancel_uri =  '/app/server_1c/rac_1c/sessionslist/'.$cluster.'/'.$infobase;
        $items = array(lang('server_1c_rac_session_drop_confirm'));
    
        $this->page->view_confirm_delete($confirm_uri, $cancel_uri, $items);
    
    }
    
    function terminate_session($cluster,$infobase, $session)
    {
	$this->load->library('server_1c/Server_1C');
	
	$this->server_1c->terminate_session($cluster, $session);
	redirect('/server_1c/rac_1c/sessionslist/'.$cluster.'/'.$infobase);
    }
    
    function stop()
    {
	$ras = new Daemon('srv1cv83.ras');
	$ras -> set_running_state(false);
	redirect('/server_1c');
    }
    
    function start()
    {
	$ras = new Daemon('srv1cv83.ras');
	$ras -> set_running_state(true);
	redirect('/server_1c');
    }
    

}
