<?php

namespace JPATHRU\Libraries\Fields\SelectMenuItem;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;

class SelectmenuitemField extends FormField
{

	protected $name = 'Selectmenuitem';

	protected $layout = 'Selectmenuitem';

	public function getLayoutPaths()
	{
		return array_merge([__DIR__ . '/layouts'], parent::getLayoutPaths());
	}

	public function getLayoutData()
	{
		Factory::getApplication()->getLanguage()->load('com_modules');

		return parent::getLayoutData();
	}

	public function getInput()
	{

		HTMLHelper::_('stylesheet', 'lib_fields/selectmenuitem/selectmenuitem.css', [
			'version'  => filemtime(__FILE__),
			'relative' => true
		]);

		HTMLHelper::_('script', 'lib_fields/selectmenuitem/selectmenuitem.js', [
			'version'  => filemtime(__FILE__),
			'relative' => true
		]);

		return parent::getInput();
	}

}