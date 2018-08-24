<?php

/**
 * Server 1C view.
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
// Load dependencies
///////////////////////////////////////////////////////////////////////////////

$this->load->helper('number');
$this->lang->load('base');
$this->lang->load('server_1c');

///////////////////////////////////////////////////////////////////////////////
// Settings form
///////////////////////////////////////////////////////////////////////////////

$items = array();

foreach ($vhosts as $key => $vhost) {

    	$buttons = array();
	
	$state = $vhost['Require'] == 'all granted' ? 'disable' : 'enable';
	$state_anchor = 'anchor_' . $state;
	$buttons[] = $state_anchor('/app/server_1c/web_1c/webchangestate/' .$vhost['Alias'], 'high');
	$buttons[] = anchor_custom('/app/server_1c/web_1c/webedit/' . $vhost['Alias'], lang('base_edit'));
	$buttons[] = anchor_custom('/app/server_1c/web_1c/webdelete/' . $vhost['Alias'], lang('base_delete'));

	$item['title'] = $vhost['Alias'];
	$item['current_state'] = $vhost['Require'] == 'all granted' ? TRUE : FALSE;
	$item['action'] = NULL;
	$item['anchors'] = button_set($buttons);
	$item['details'] = array($vhost['Alias'],$vhost['Srvr'],$vhost['Base']);
	
	$items[]=$item;
}


$options = array (
    'row-enable-disable' => TRUE,
    'responsive' => [
    2 => 'none',
    3 => 'none'
    ],
    'default_rows' => 50
    );

echo summary_table(
    lang('server_1c_web_app_name'),
    array(anchor_custom('/app/server_1c/web_1c/webadd', lang('base_add'))),
    array(lang('server_1c_web_alias'), lang('server_1c_web_server'), lang('server_1c_web_base')),
    $items,
    $options
);

echo form_close();
