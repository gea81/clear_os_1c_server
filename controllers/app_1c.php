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

class App_1c extends ClearOS_Controller
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
            $data['package_info']=$this->server_1c->get_info();
        } catch (Exception $e) {
            $this->page->set_message(clearos_exception_message($e));
        }	
	
        // Load views

        $this->page->view_form('app/applist', $data, lang('server_1c_app_name'));
        
        $software = new Software('postgresql96-server');
        if($software->is_installed()){
	    $this->page->view_form('app/pg_status', $data, lang('server_1c_app_name'));
        }else{
    	    $this->page->view_form('app/pg_notinstalled', $data, lang('server_1c_app_name'));
        }
    }
    
    function configlog()
    {
	$this->load->library('Server_1C');
		
	$data = array();
	$data = $this->server_1c->get_config_section('logcfg');
	$this->page->view_form('app/configlog', $data, lang('server_1c_web_app_name'));
    }
    
    function config_log()
    {
	$this->load->library('Server_1C');
	
	$data['ALL']     = (int)$this->input->post('ALL');
	$data['ADMIN']   = (int)$this->input->post('ADMIN');
	$data['CALL']    = (int)$this->input->post('CALL');
        $data['CONN']    = (int)$this->input->post('CONN');
	$data['CLSTR']   = (int)$this->input->post('CLSTR');
	$data['EDS']     = (int)$this->input->post('EDS');
	$data['DB2']     = (int)$this->input->post('DB2');
	$data['DBMSSQL'] = (int)$this->input->post('DBMSSQL');
	$data['DBPOSTGRS'] = (int)$this->input->post('DBPOSTGRS');
	$data['DBORACLE']  = (int)$this->input->post('DBORACLE');
	$data['DBV8DBEng'] = (int)$this->input->post('DBV8DBEng');
	$data['EXCP']      = (int)$this->input->post('EXCP');
	$data['EXCPCNTX']  = (int)$this->input->post('EXCPCNTX');
	$data['HASP']      = (int)$this->input->post('HASP');
	$data['LEAKS']     = (int)$this->input->post('LEAKS');
	$data['MEM']       = (int)$this->input->post('MEM');
	$data['PROC']      = (int)$this->input->post('PROC');
	$data['QERR']      = (int)$this->input->post('QERR');
	$data['SCALL']     = (int)$this->input->post('SCALL');
	$data['SCOM']      = (int)$this->input->post('SCOM');
	$data['SDBL']      = (int)$this->input->post('SDBL');
	$data['SRVC']      = (int)$this->input->post('SRVC');
	$data['TLOCK']     = (int)$this->input->post('TLOCK');
	$data['TDEADLOCK'] = (int)$this->input->post('TDEADLOCK');
	$data['TTIMEOUT']  = (int)$this->input->post('TTIMEOUT');
	$data['VRSCACHE']  = (int)$this->input->post('VRSCACHE');
	$data['VRSREQUEST']  = (int)$this->input->post('VRSREQUEST');
	$data['VRSRESPONSE'] = (int)$this->input->post('VRSRESPONSE');
	$data['SYSTEM']      = (int)$this->input->post('SYSTEM');
	if(!($err = $this->server_1c->update_cfg_log($data))) {
		    $srv1cv83=new Daemon('srv1cv83');
		    if($srv1cv83->get_running_state())$srv1cv83->restart();
		    redirect('/server_1c');
	    	    return;
	}
	
	$this->page->view_form('app/configlog', $data, lang('server_1c_web_app_name'));
    }
    
}

