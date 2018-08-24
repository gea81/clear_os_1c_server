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
    lang('server_1c_rac_user-name'),
    lang('server_1c_rac_started-at'),
    lang('server_1c_rac_last-active-at')
);

$items = array();

foreach ($sessions as $key => $session) {
    
    $ses=explode(":",$session);
    
    if((trim($ses[0])=='session')&&($key==0)){ 
	$item['title'] = trim($ses[1]); 
    }

    if((trim($ses[0])=='user-name')||(trim($ses[0])=='started-at')||(trim($ses[0])=='last-active-at')){ 
	$item['details'][]=$ses[1];
    }
    
    if((($key!=0)&&(trim($ses[0])=='session'))||($key==count($sessions)-1)){
	$item['action'] = NULL;
	$item['anchors'] = button_set(array(anchor_custom('/app/server_1c/rac_1c/terminatesession/'.$cluster.'/'.$infobase.'/'.$item['title'], lang('base_delete'))));
	$items[] = $item;
	$item = array();
	$item['title'] = trim($ses[1]); 
    }
}



// Table output
//-------------


$options = array(
    'id' => lang('server_1c_rac_name'),
);

$anchors = array(anchor_cancel('/app/server_1c/rac_1c/infobaseslist/'.$cluster));

echo summary_table(
    lang('server_1c_rac_sessions'),
    $anchors,
    $headers,
    $items,
    $options
);

echo form_close();
