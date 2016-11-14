<?php
/**
 * @copyright	Copyright (C) 2013 Cook Self Service. All rights reserved.
 * @author		J. HUARD (http://j-cook.pro) - G. Tomaselli (http://bygiro.com)
 * @license     MIT License (MIT)
 */

defined('_JEXEC') or die;

defined('DS') or define('DS',DIRECTORY_SEPARATOR);
defined('BR') or define("BR", "<br />");
defined('LN') or define("LN", "\n");

if(!defined('PATH_LIBRARY_JDOM'))  define('PATH_LIBRARY_JDOM', JPATH_SITE . '/libraries/jdom');

jimport('joomla.version');
$version = new JVersion();


/**
 * Jdom plugin class.
 *
 * @package     Joomla.plugin
 * @subpackage  System.jdom
 */
class plgSystemJdom extends JPlugin
{
    public function onAfterInitialise()
    {
		// load plugin language file
		$language = JFactory::getLanguage();
		$language->load('plg_system_jdom', JPATH_ADMINISTRATOR);

		JLoader::register('JDom', JPATH_SITE . '/libraries/jdom/dom.php');
    }
}