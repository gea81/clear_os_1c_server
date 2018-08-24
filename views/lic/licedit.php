<?php

/**
 * Server 1C view.
 *
 * @category   Apps
 * @package    Server_1C
 * @subpackage View
 * @author     Ivan Demidov <i.demidov@htlead.kz>
 * @copyright  2018 High Tech Lider ltd.
 * @license    HTLEAD license
 */

///////////////////////////////////////////////////////////////////////////////
// Load dependencies
///////////////////////////////////////////////////////////////////////////////

$this->lang->load('server_1c');

///////////////////////////////////////////////////////////////////////////////
// Form
///////////////////////////////////////////////////////////////////////////////

if($errs)
	echo infobox_warning(lang('base_error'), implode("<br>", $errs));

echo form_open('server_1c/lic_1c/lic_update/'.$license);
echo form_header(lang('server_1c_lic_info'));

$params = array();

foreach ($info as $param) {
    
    $lic=explode(":",$param);
    
    $params[trim($lic[0])]=trim($lic[1]);
}

echo field_input    ('company',         $params['Company'],                                   lang('server_1c_lic_company'),              true);
echo field_input    ('last_name',       $params['Last name'],                                 lang('server_1c_lic_last_name'),            true);
echo field_input    ('first_name',      $params['First name'],                                lang('server_1c_lic_first_name'),           true);
echo field_input    ('middle_name',     $params['Middle name'],                               lang('server_1c_lic_middle_name'),          true);
echo field_input    ('email',           $params['Email'],                                     lang('server_1c_lic_email'),                true);
echo field_input    ('country',         $params['Country'],                                   lang('server_1c_lic_country'),              true);
echo field_input    ('region',          $params['Region'],                                    lang('server_1c_lic_region'),               true);
echo field_input    ('zip_code',        $params['Zip code'],                                  lang('server_1c_lic_zip_code'),             true);
echo field_input    ('district',        $params['District'],                                  lang('server_1c_lic_district'),             true);
echo field_input    ('town',            $params['Town'],                                      lang('server_1c_lic_town'),                 true);
echo field_input    ('street',          $params['Street'],                                    lang('server_1c_lic_street'),               true);
echo field_input    ('house',           $params['House'],                                     lang('server_1c_lic_house'),                true);
echo field_input    ('building',        $params['Building'],                                  lang('server_1c_lic_building'),             true);
echo field_input    ('apartment',       $params['Apartment'],                                 lang('server_1c_lic_apartment'),            true);

echo field_input    ('work_places',     $work_places,                                         lang('server_1c_lic_work_places'),          false);

echo field_button_set(array(	form_submit_update('submit'), anchor_cancel('/app/server_1c')));

echo form_footer();
echo form_close();

?>