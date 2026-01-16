<?php

namespace JPATHRU\Libraries\Fields\SubformMore;

defined('_JEXEC') or die;

use Joomla\CMS\Form\Field\SubformField;
use Joomla\CMS\HTML\HTMLHelper;

class SubformmoreField extends SubformField
{

	protected $name = 'Subformmore';

	protected $layout = 'Subformmore';

	public function getLayoutPaths()
	{
		return array_merge([__DIR__ . '/layouts'], parent::getLayoutPaths());
	}

	public function getLayoutData()
	{
		return parent::getLayoutData();
	}

	public function getInput()
	{
		HTMLHelper::_('stylesheet', 'lib_fields/subformmore/subformmore.css', [
			'version' => filemtime(__FILE__),
			'relative' => true
		]);

		HTMLHelper::_('script', 'lib_fields/subformmore/subformmore.js', [
			'version' => filemtime(__FILE__),
			'relative' => true
		]);

		return parent::getInput();
	}

}