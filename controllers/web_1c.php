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
use \clearos\apps\base\Software as Software;

clearos_load_library('base/Daemon');
clearos_load_library('base/Software');

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

class Web_1c extends ClearOS_Controller
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
    
        // Load view data
        //---------------
        
        $software= new Software('httpd');
        
    	if ($software->is_installed()){       
    	    	try {
        	    $data['vhosts']        = $this->server_1c->web_get_vhosts();
    		} catch (Exception $e) {
        	    $this->page->set_message(clearos_exception_message($e));
    		}
    		// Load views
    		$this->page->view_form('web/weblist', $data, lang('server_1c_web_app_name'));
    	}else{
    	    $this->page->view_form('web/notinstalled', $data, lang('server_1c_web_app_name'));
    	}
    }
    
    function webadd()
    {
	$this->load->library('Server_1C');
		
	$data = array();
	$this->page->view_form('web/webadd', $data, lang('server_1c_web_app_name'));
    }
    
    function web_add() 
    {    
	$this->load->library('Server_1C');
	 
	$this->form_validation->set_policy('alias',  'server_1c/Server_1C', 'validate_alias',    TRUE);
	$this->form_validation->set_policy('server', 'server_1c/Server_1C', 'validate_server',   TRUE);
	$this->form_validation->set_policy('base',   'server_1c/Server_1C', 'validate_base',     TRUE);
	
	$form_ok = $this->form_validation->run();
	
	$data = array();
	$data['alias']       	     = $this->input->post('alias');
	$data['server']      	     = $this->input->post('server');
	$data['base']        	     = $this->input->post('base');
	$data['sslverifyclient']     = $this->input->post('sslverifyclient');
	
	try{
	    if($form_ok){
	       if(!($err = $this->server_1c->web_publish($data))) {
		$httpd = new Daemon('httpd');
		if($httpd->get_running_state())$httpd->restart();
		redirect('/server_1c');
		return;
		}
	    }
	}catch(Exception $e){
	    $this->page->set_message(clearos_exception_message($e));
	}
	
	$this->page->view_form('web/webadd', $data, lang('server_1c_web_app_name'));
    }
		
    function webedit($vhost)
    {
	$this->load->library('Server_1C');
	
	$data = $this->server_1c->get_vhost($vhost);
	$this->page->view_form('web/webedit', $data, lang('server_1c_web_app_name'));
    }
    
    function web_edit($vhost) 
    {
	$this->load->library('Server_1C');
	
	$data = array();
	$data['alias']       	 = $this->input->post('alias');
	$data['server']      	 = $this->input->post('server');
	$data['base']        	 = $this->input->post('base');
	$data['sslverifyclient']     = $this->input->post('sslverifyclient');
	
	if(!($err = $this->server_1c->update($data))) {
	    $httpd = new Daemon('httpd');
	    if($httpd->get_running_state())$httpd->restart();
	    redirect('/server_1c');
	    return;
	}
    }
				
    function webdelete($vhost)
    {
	$this->load->library('server_1c/Server_1C');

        $confirm_uri = '/app/server_1c/web_1c/web_delete/'.$vhost;
        $cancel_uri =  '/app/server_1c';
        $items = array(lang('server_1c_web_delete_confirm'));
    
        $this->page->view_confirm_delete($confirm_uri, $cancel_uri, $items);
    }
    
    function web_delete($vhost) 
    {
	$this->load->library('Server_1C');
	$this->server_1c->web_drop($vhost);
	$httpd = new Daemon('httpd');
	$httpd->restart();
	redirect('/server_1c');
    }
    
    function webchangestate($vhost) {
	$this->load->library('Server_1C');
	$this->server_1c->web_change_state($vhost);
	$httpd = new Daemon('httpd');
	$httpd->restart();
	redirect('/server_1c');
    }
}
