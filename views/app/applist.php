<?php

/**
 * Server 1C view.
 *
 * @category   apps
 * @package    server-1c
 * @subpackage views
 * @author     High Tech Lider ltd. <htlead@htlead.kz>
 * @copyright  2018 High Tech Lider
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       https://github.com/htlead/clear_os_1c_server
 */


///////////////////////////////////////////////////////////////////////////////
// Load dependencies
///////////////////////////////////////////////////////////////////////////////

$this->load->helper('number');
$this->lang->load('base');
$this->lang->load('server_1c');

///////////////////////////////////////////////////////////////////////////////
// Settings form
///////////////////////////////////////////////////////////////////////////////

$headers = array(
    lang('server_1c_package_name'),
    lang('server_1c_version'),
    lang('server_1c_release'),
    lang('server_1c_install_size'),
    lang('server_1c_install_time')
);

$items = array();

foreach ($package_info as  $info) {

    $item['title'] = $info['package_name'];
    $item['action'] = NULL;
    $item['anchors'] = NULL;
    $item['details'] = array(
			    $info['package_name'],
			    $info['version'],
			    $info['release'],
			    $info['install_size'],
			    date("d-m-Y",$info['install_time'])
    );

    $items[] = $item;
}



// Table output
//-------------


$options = array(
    'id' => lang('package_name'),
    'no_action' => TRUE
);

$anchors = array();

if(count($package_info)>0){ $anchors[] = anchor_custom('/app/server_1c/app_1c/configlog', lang('server_1c_config_log')); }

echo summary_table(
    lang('server_1c_packages'),
    $anchors,
    $headers,
    $items,
    $options
);

echo form_close();
