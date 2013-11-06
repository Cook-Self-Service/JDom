<?php
/**
 * @copyright	Copyright (C) 2013 G. Tomaselli, Inc. All rights reserved.
 * @author		G. Tomaselli - http://bygiro.com - girotomaselli@gmail.com
 * @license     GNU General Public License version 2 or later.
 * JDOM library by j-cook service http://j-cook.pro
 */
 
defined('_JEXEC') or die;

@define("DS", DIRECTORY_SEPARATOR);
@define('PATH_LIBRARY_JDOM', JPATH_SITE . DS . 'libraries' . DS . 'jdom');

// workaround for CkJLoader
class CkJLoader extends JLoader{}
jimport('joomla.version');
$version = new JVersion();

if (!class_exists('CkJLoader'))
{
	// Joomla! 1.6 - 1.7
	if (version_compare($version->RELEASE, '2.5', '<'))
	{
		// Load the missing class file
		require_once(PATH_LIBRARY_JDOM .DS. 'legacy' .DS. 'loader.php');
				
		// Register the autoloader functions.
		CkJLoader::setup();
	}
	
	
	//Joomla! 2.5 and later
	else
	{	
		class CkJLoader extends JLoader{}
	}
}



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
		JLoader::register('JDom', JPATH_SITE . DS . 'media' . DS . 'jdom' . DS . 'dom.php');
    }
}