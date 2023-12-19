<?php namespace JPATHRU\Libraries\Fields\Field\SelectMenuItem;

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;

class SelectmenuitemField extends FormField
{

	protected $name = 'selectmenuitem';


	protected $layout = 'selectmenuitem';


	public function getLayoutPaths()
	{
		return array_merge([__DIR__ . '/layouts'], parent::getLayoutPaths());
	}


	public function getLayoutData()
	{
		Factory::getLanguage()->load('com_modules');
		return parent::getLayoutData();
	}


	public function getInput()
	{

		HTMLHelper::_('stylesheet', 'lib_fields/selectmenuitem/selectmenuitem.css', [
			'version' => filemtime(__FILE__),
			'relative' => true
		]);

		HTMLHelper::_('script', 'lib_fields/selectmenuitem/selectmenuitem.js', [
			'version' => filemtime(__FILE__),
			'relative' => true
		]);

		return parent::getInput();
	}


}