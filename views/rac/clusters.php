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
    lang('server_1c_rac_server'),
    lang('server_1c_rac_port'),
    lang('server_1c_rac_name')
);

$items = array();

foreach ($clusters as $key => $cluster) {
    
    $rac=explode(":",$cluster);
    
    if(trim($rac[0])=='cluster'){ 
	$item['title'] = trim($rac[1]); 
    }

    if((trim($rac[0])=='host')||(trim($rac[0])=='port')||(trim($rac[0])=='name')){ 
	$item['details'][]=$rac[1];
    }

    if((($key!=0)&&($rac[0]=='cluster'))||($key==count($clusters)-1))
    {
	$item['action'] = NULL;
	$item['anchors'] = button_set(array(anchor_custom('/app/server_1c/rac_1c/infobaseslist/'.$item['title'], lang('server_1c_rac_infobases'))));
	$items[] = $item;
    }
}



// Table output
//-------------


$options = array(
    'id' => lang('server_1c_rac_name'),
);

$anchors = array();
if($running_state){ 
    $anchors[] = anchor_custom('/app/server_1c/rac_1c/stop', lang('server_1c_rac_stop')); 
}else{
    $anchors[] = anchor_custom('/app/server_1c/rac_1c/start', lang('server_1c_rac_start')); 
}

echo summary_table(
    lang('server_1c_rac_app_name'),
    $anchors,
    $headers,
    $items,
    $options
);

echo form_close();
