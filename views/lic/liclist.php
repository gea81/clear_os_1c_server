<?php

/**
 * Server 1C view.
 *
 * @category   apps
 * @package    server-1c
 * @subpackage views
 * @author     Ivan Demidov <i.demidov@htlead.kz>
 * @copyright  2018 High Tech Lider ltd
 * @license    HTLEAD License
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
    lang('server_1c_lic_number'),
    lang('server_1c_lic_pin'),
    lang('server_1c_lic_work_places')
);

$items = array();
$summary_work_places=0;

foreach ($licenses as  $info) {
    
    $work_places = $config['licenses'][$info];
    $summary_work_places=$summary_work_places+$work_places;
    
    $lic=explode("-",$info);
    
    $item['title'] = $lic[0];
    $item['action'] = NULL;
    $item['anchors'] = button_set(array(anchor_custom('/app/server_1c/lic_1c/licedit/'.$info, lang('server_1c_lic_view'))));
    $item['details'] = array($lic[1],$lic[0],$work_places);

    $items[] = $item;
}



// Table output
//-------------


$options = array(
    'id' => lang('server_1c_lic_number'),
);

$anchors = array();

echo summary_table(
    lang('server_1c_lics'),
    $anchors,
    $headers,
    $items,
    $options
);

echo infobox_highlight(
        lang('server_1c_lic_summary_information'),
        lang('server_1c_lic_summary_work_places').': '.$summary_work_places
    );

echo form_close();
