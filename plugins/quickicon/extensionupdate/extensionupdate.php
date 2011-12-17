<?php
/**
 * @version		$Id$
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Joomla! udpate notification plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	Quickicon.Joomla
 * @since		1.7.1
 */
class plgQuickiconExtensionupdate extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 * @since       1.7.1
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}
	
	/**
	 * Returns an icon definition for an icon which looks for extensions updates
	 * via AJAX and displays a notification when such updates are found.
	 * 
	 * @return array An icon definition associative array, consisting of the
	 *				 keys link, image, text and access.
	 */
	public function onGetIcon()
	{
		$cur_template = JFactory::getApplication()->getTemplate();
		$ajax_url = JURI::base().'index.php?option=com_installer&view=update&task=update.ajax';
		$script = "var plg_quickicon_extensionupdate_ajax_url = '$ajax_url';\n";
		$script .= 'var plg_quickicon_extensionupdate_text = {"UPTODATE" : "'.
			JText::_('PLG_QUICKICON_EXTENSIONUPDATE_UPTODATE').'", "UPDATEFOUND": "'.
			JText::_('PLG_QUICKICON_EXTENSIONUPDATE_UPDATEFOUND').'", "ERROR": "'.
			JText::_('PLG_QUICKICON_EXTENSIONUPDATE_ERROR')."\"};\n";
		$document = JFactory::getDocument();
		$document->addScriptDeclaration($script);
		$document->addScript(JURI::base().'../media/plg_quickicon_extensionupdate/extensionupdatecheck.js');
		
		return array(
			'link' => 'index.php?option=com_installer&view=update',
			'image' => 'header/icon-48-extension.png',
			'text' => JText::_('PLG_QUICKICON_EXTENSIONUPDATE_CHECKING'),
			'access' => array('core.manage', 'com_installer'),
			'id' => 'plg_quickicon_extensionupdate'
		);
	}
}