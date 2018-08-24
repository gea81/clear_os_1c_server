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
    lang('server_1c_rac_infobase')
);

$items = array();

foreach ($infobases as $key => $infobase) {
    
    $inf=explode(":",$infobase);
    
    if((trim($inf[0])=='infobase')&&($key==0)){ 
	$item['title'] = trim($inf[1]); 
    }

    if((trim($inf[0])=='name')||(trim($inf[0])=='descr')){ 
	$item['details'][]=$inf[1];
    }
    
    if((($key!=0)&&(trim($inf[0])=='infobase'))||($key==count($infobases)-1))
    {	
	$item['action'] = NULL;
	$item['anchors'] = button_set(array(anchor_custom('/app/server_1c/rac_1c/sessionslist/'.$cluster.'/'.$item['title'], lang('server_1c_rac_sessions')),
					    //anchor_custom('/app/server_1c/rac/infobaseedit/'.$cluster.'/'.$item['title'], lang('base_edit')),
					    anchor_custom('/app/server_1c/rac_1c/infobasedrop/'.$cluster.'/'.$item['title'], lang('base_delete'))));
	$items[] = $item;
	$item=array();
	$item['title']=trim($inf[1]);
    }
}

// Table output
//-------------


$options = array(
    'id' => lang('server_1c_rac_infobase'),
);

$anchors = array(anchor_custom('/app/server_1c/rac_1c/infobaseadd/'.$cluster, lang('base_add')), anchor_cancel('/app/server_1c'));

echo summary_table(
    lang('server_1c_rac_infobases_name'),
    $anchors,
    $headers,
    $items,
    $options
);

echo form_close();
