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

$this->lang->load('server_1c');

///////////////////////////////////////////////////////////////////////////////
// Form
///////////////////////////////////////////////////////////////////////////////

if($errs)
	echo infobox_warning(lang('base_error'), implode("<br>", $errs));

echo form_open('server_1c/rac_1c/infobase_add');
echo form_header(lang('server_1c_rac_infobase_add'));

$DBMS = array('MSSQLServer' => 'MSSQLServer', 'PostgreSQL' => 'PostgreSQL', 'IBMDB2' => 'IBMDB2', 'OracleDatabase' => 'OracleDatabase');
$SJD  = array('on' => 'on', 'off' => 'off');

echo field_input    ('cluster',              $cluster,                                       lang('server_1c_rac_db_cluster'),     true);
echo field_input    ('name',                 $name,                                          lang('server_1c_rac_infobase'),        false);
echo field_dropdown ('dbms',                 $DBMS,              $dbms,                      lang('server_1c_rac_dbms'),           false);
echo field_input    ('db_server',            $db_server,                                     lang('server_1c_rac_db_server'),      false);
echo field_input    ('db_name',              $db_name,                                       lang('server_1c_rac_db_name'),        false);
echo field_input    ('db_user',              $db_user,                                       lang('server_1c_rac_db_user'),        false);
echo field_password ('db_pwd',               $db_pwd,                                        lang('server_1c_rac_db_pwd'),         false);
echo field_checkbox ('create_database',      $create_database,                               lang('server_1c_rac_create_database'),false);
echo field_dropdown ('locale',               $LOCALE,            $locale,                    lang('server_1c_rac_locale'),         false);
echo field_dropdown ('scheduled_jobs_deny',  $SJD,               $sjd,                       lang('server_1c_rac_scheduled_jobs'), false);

echo field_button_set(array(form_submit_add('submit'), anchor_cancel('/app/server_1c')));

echo form_footer();
echo form_close();

?>