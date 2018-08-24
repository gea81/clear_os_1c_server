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

$this->lang->load('server_1c');

///////////////////////////////////////////////////////////////////////////////
// Form
///////////////////////////////////////////////////////////////////////////////

if($errs)
	echo infobox_warning(lang('base_error'), implode("<br>", $errs));

echo form_open('server_1c/web_1c/web_add');
echo form_header(lang('server_1c_web_add'));

echo field_input    ('alias',      $alias,                                                   lang('server_1c_web_alias'),        false);
echo field_input    ('server',     $server,                                                  lang('server_1c_web_server'),       false);
echo field_input    ('base',       $base,                                                    lang('server_1c_web_base'),         false);
;

echo field_button_set(array(
	form_submit_add('submit'),
	anchor_cancel('/app/server_1c')
));

echo form_footer();
echo form_close();

?>