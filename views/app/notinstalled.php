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

$this->lang->load('base');

$options['buttons']  = array(
    anchor_custom('/app/server_1c/download1c', lang('base_download'), 'high'),
    anchor_cancel('/app/server_1c')
);

echo infobox_highlight(
    lang('server_1c_app_not_installed'),
    lang('server_1c_app_not_installed_help'),
    $options
);
