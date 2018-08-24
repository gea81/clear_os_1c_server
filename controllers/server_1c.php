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

use \clearos\apps\base\Daemon  as Daemon;
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

class Server_1C extends ClearOS_Controller
{
    /**
     * 1C Server default controller.
     *
     * @return view
     */

    function index()
    {
        // Load dependencies
        //------------------
	$this->lang->load('server_1c');
	
	$common_name = '1C_Enterprise83-server';
        $software= new Software($common_name);
        
    	if ($software->is_installed()){       
	    $options['type'] = MY_Page::TYPE_WIDE_CONFIGURATION;
	    $views = array('server_1c/server', 'server_1c/network', 'server_1c/app_1c', 'server_1c/rac_1c', 'server_1c/web_1c', 'server_1c/lic_1c');
    	    $this->page->view_forms($views, $data, lang('server_1c_app_name'), $options);
    	}else{
    	    $this->page->view_form('app/notinstalled', $data, lang('server_1c_app_name'));
    	}
    }
    
    function download1c()
    {
	redirect('https://releases.1c.ru');
    }
        
    function pginstall()
    {
	$this->load->library('Server_1C');
	$data['pg_installlog']=$this->server_1c->pg_install();
	$this->page->view_form('app/pg_installlog', $data, lang('server_1c_app_name'));
	return;
    }
    
    function pginitdb()
    {
	$this->load->library('Server_1C');
	$data['pg_installlog']=$this->server_1c->pg_initdb();
	$this->page->view_form('app/pg_installlog', $data, lang('server_1c_app_name'));
	return;
    }
    
}
