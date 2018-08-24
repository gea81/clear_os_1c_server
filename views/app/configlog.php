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

echo form_open('server_1c/app_1c/config_log');
echo form_header(lang('server_1c_config_log'));

echo field_checkbox('ALL',       $ALL,         'ALL');
echo field_checkbox('ADMIN',     $ADMIN,       'ADMIN');
echo field_checkbox('CALL',      $CALL,        'CALL');
echo field_checkbox('CONN',      $CONN,        'CONN');
echo field_checkbox('CLSTR',     $CLSTR,       'CLSTR');
echo field_checkbox('EDS',       $EDS,         'EDS');
echo field_checkbox('DB2',       $DB2,         'DB2');
echo field_checkbox('DBMSSQL',   $DBMSSQL,     'DBMSSQL');
echo field_checkbox('DBPOSTGRS', $DBPOSTGRS,   'DBPOSTGRS');
echo field_checkbox('DBORACLE',  $DBORACLE,    'DBORACLE');
echo field_checkbox('DBV8DBEng', $DBV8DBEng,   'DBV8DBEng');
echo field_checkbox('EXCP',      $EXCP,        'EXCP');
echo field_checkbox('EXCPCNTX',  $EXCPCNTX,     'EXCPCNTX');
echo field_checkbox('HASP',      $HASP,        'HASP');
echo field_checkbox('LEAKS',     $LEAKS,       'LEAKS');
echo field_checkbox('MEM',       $MEM,         'MEM');
echo field_checkbox('PROC',      $PROC,        'PROC');
echo field_checkbox('QERR',      $QERR,        'QERR');
echo field_checkbox('SCALL',     $SCALL,       'SCALL');
echo field_checkbox('SCOM',      $SCOM,        'SCOM');
echo field_checkbox('SDBL',      $SDBL,        'SDBL');
echo field_checkbox('SRVC',      $SRVC,        'SRVC');
echo field_checkbox('TLOCK',     $TLOCK,       'TLOCK');
echo field_checkbox('TDEADLOCK', $TDEADLOCK,    'TDEADLOCK');
echo field_checkbox('TTIMEOUT',  $TTIMEOUT,    'TTIMEOUT');
echo field_checkbox('VRSCACHE',  $VRSCACHE,    'VRSCACHE');
echo field_checkbox('VRSREQUEST',$VRSREQUEST,  'VRSREQUEST');
echo field_checkbox('VRSRESPONSE',$VRSRESPONSE, 'VRSRESPONSE');
echo field_checkbox('SYSTEM',     $SYSTEM,     'SYSTEM');

echo field_button_set(array(form_submit_update('submit'), anchor_cancel('/app/server_1c')
));

echo form_footer();
echo form_close();

?>