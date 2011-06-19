<?php
// If SSI.php is in the same place as this file, and SMF isn't defined, this is being run standalone.
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
// Hmm... no SSI.php and no SMF?
elseif (!defined('SMF'))
	die('<b>Error:</b> Cannot install - please verify you put this in the same place as SMF\'s index.php.');

$integration_function = (!empty($context['uninstalling'])) ? 'remove_integration_function' : 'add_integration_function';
$integration_function('integrate_pre_include', '$sourcedir/Subs-LoadBrowserLang.php');
$integration_function('integrate_pre_load', 'browserlang_check_n_load');
