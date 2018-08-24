<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'server_1c';
$app['version'] = '1.0.1';
$app['release'] = '1';
$app['vendor'] = 'High Tech Lider';
$app['packager'] = 'High Tech Lider';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('server_1c_app_description');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('server_1c_app_name');
$app['category'] = lang('base_category_server');
$app['subcategory'] = lang('base_subcategory_applications');

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['core_directory_manifest'] = array(
    '/var/clearos/server_1c' => array(),
    '/var/clearos/server_1c/backup' => array()
);

$app['core_file_manifest'] = array(
    'srv1cv83.php'     => array('target' => '/var/clearos/base/daemon/srv1cv83.php'),
    'srv1cv83.ras.php' => array('target' => '/var/clearos/base/daemon/srv1cv83.ras.php'),
    'srv1cv83.ras.service' => array('target' => '/etc/systemd/system/srv1cv83.ras.service')
);