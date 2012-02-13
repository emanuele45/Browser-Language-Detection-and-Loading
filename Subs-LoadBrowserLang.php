<?php
/**
 * Browser Language Detection and Loading (BLDL)
 *
 * @package BLDL
 * @author emanuele
 * @copyright 2012 emanuele, Simple Machines
 * @license http://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 0.1.0
 */

if (!defined('SMF'))
	die('Hacking attempt...');

function browserlang_check_n_load ()
{
	global $settings, $languages_array;

	$languages_array = array(
			'sq-al' => 'Albanian',
			'sq' => 'Albanian',
			'ar-ar' => 'Arabic',
			'bn-bd' => 'Bangla',
			'bn' => 'Bangla',
			'bg-bg' => 'Bulgarian',
			'ca-es' => 'Catalan',
			'ca' => 'Catalan',
			'zh-cn' => 'Chinese-simplified',
			'zh-tw' => 'Chinese-traditional',
			'hr-hr' => 'Croatian',
			'cs-cz' => 'Czech', // 'Czech_informal',
			'cs' => 'Czech', // 'Czech_informal',
			'da-dk' => 'Danish',
			'da' => 'Danish',
			'nl-nl' => 'Dutch',
			'en' => 'English',
			'en-us' => 'English',
			'en-gb' => 'English_british',
			'fi-fi' => 'Finnish',
			'fr-fr' => 'French',
			'gl-es' => 'Galician',
			'gl' => 'Galician',
			'de-de' => 'German',// 'German_informal',
			'el-gr' => 'Greek',
			'el' => 'Greek',
			'he-il' => 'Hebrew',
			'he' => 'Hebrew',
			'hi-in' => 'Hindi',
			'hi' => 'Hindi',
			'hu-hu' => 'Hungarian',
			'id-id' => 'Indonesian',
			'it-it' => 'Italian',
			'ja-jp' => 'Japanese',
			'ja' => 'Japanese',
			'ku' => 'Kurdish_kurmanji',
			'ku-tr' => 'Kurdish_kurmanji',
			'ku-ir' => 'Kurdish_sorani',
			'lt-lt' => 'Lithuanian',
			'mk-mk' => 'Macedonian',
			'ms-my' => 'Malay',
			'ms' => 'Malay',
			'no-no' => 'Norwegian',
			'fa-ir' => 'Persian',
			'fa' => 'Persian',
			'pl-pl' => 'Polish',
			'pt-br' => 'Portuguese_brazilian',
			'pt-pt' => 'Portuguese_pt',
			'pt' => 'Portuguese_pt',
			'ro-ro' => 'Romanian',
			'ru-ru' => 'Russian',
			'sr-rs' => 'Serbian_cyrillic',
			'sr' => 'Serbian_cyrillic',
			'sr-yu' => 'Serbian_latin',
			'sk-sk' => 'Slovak',
			'sl-sl' => 'Slovenian',
			'es-es' => 'Spanish_es',
			'es' => 'Spanish_es',
			'es-ar' => 'Spanish_latin',
			'sv-se' => 'Swedish',
			'sv' => 'Swedish',
			'th-th' => 'Thai',
			'tr-tr' => 'Turkish',
			'uk-ua' => 'Ukrainian',
			'uk' => 'Ukrainian',
			'ur-pk' => 'Urdu',
			'ur' => 'Urdu',
			'uz-uz' => 'Uzbek_latin',
			'vi-vn' => 'Vietnamese',
			'vi' => 'Vietnamese',
	);

	// en,en-us;q=0.8,it-it;q=0.5,it;q=0.3
	$browser_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

	foreach ($browser_langs as &$lang)
	{
		$lang = strtolower(substr($lang, 0, strstr($lang, ';') ? strpos($lang, ';') : strlen($lang)));

		$lang_check = array_key_exists($lang, $languages_array) ? $lang : (array_key_exists($lang . '-' . $lang, $languages_array) ? $lang . '-' . $lang : false);
		if (!empty($lang_check) && browserlang_file_exists($lang_check, strtolower($languages_array[$lang_check])))
				break;
	}
}

function browserlang_file_exists ($lang, $lang_name)
{
	global $cookiename, $modSettings, $language, $settings, $txt;

	$character_set = empty($modSettings['global_character_set']) ? (empty($txt['lang_character_set']) ? 'ISO-8859-1' : $txt['lang_character_set']) : $modSettings['global_character_set'];
	$utf8 = $character_set == 'UTF-8' ? true : false;
	$lang_name =  $lang_name . ($utf8 ? '-utf8' : '');
	$informal = ($lang=='cs' || $lang=='cs-cz' || $lang=='de-de') ? '_informal' : '';

	if (empty($settings['default_theme_dir']))
		loadTheme(0, false);

	if (file_exists($settings['default_theme_dir'] . '/languages/index.' . $lang_name . $informal .'.php') || (($lang = 'en' || $lang = 'en-us' || $lang = 'en-gb') && file_exists($settings['default_theme_dir'] . '/languages/index.english.php')))
	{
		if (isset($_SESSION['login_' . $cookiename]))
			$session_data = unserialize($_SESSION['login_' . $cookiename]);
		if (empty($session_data[0]) && empty($_SESSION['language']))
		{
			$language = $lang_name;
			return true;
		}
	}

	return false;
}
?>