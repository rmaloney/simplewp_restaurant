<?php

if (!defined('ABSPATH') || !defined('WP_UNINSTALL_PLUGIN'))
    exit('Invalid deletion.');

define('WOWSLIDER_PLUGIN_PATH', str_replace('\\', '/', dirname(__FILE__)) . '/');
require_once WOWSLIDER_PLUGIN_PATH . 'api.php';
wowslider_install('undo');
