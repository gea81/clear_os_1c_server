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

use \clearos\apps\base\Software as Software;

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

class Lic_1c extends ClearOS_Controller
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
        
        $software= new Software('1c-enterprise-ring');
        
    	if ($software->is_installed()){
	    try {
		$data['config']   =  $this->server_1c->load_config();
        	$data['licenses'] =  $this->server_1c->get_licenses();
    	    } catch (Exception $e) {
        	$this->page->set_message('License Viewing Utility: '.clearos_exception_message($e));
    	    }
    	    // Load views
	    $this->page->view_form('lic/liclist', $data, lang('server_1c_app_name'));
	}else{
    	    $this->page->view_form('lic/notinstalled', $data, lang('server_1c_app_name'));
    	}
    }
    
    function licedit($lic)
    {
	$this->load->library('server_1c/Server_1C');
	
	$data['info']        = $this->server_1c->get_license_info($lic);
	$data['work_places'] = $this->server_1c->get_license_work_places($lic);
	$data['license']     = $lic;
	
	$this->page->view_form('lic/licedit', $data, lang('server_1c_lics'));	
    }
    
    function lic_update($lic)
    {
	$this->load->library('server_1c/Server_1C');
	$work_places = (int)$this->input->post('work_places');

	$this->server_1c->set_license_work_places($work_places, $lic);
	redirect('/server_1c');
    }
}
