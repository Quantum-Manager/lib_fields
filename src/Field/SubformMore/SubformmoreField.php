<?php namespace JPATHRU\Libraries\Fields\Field\SubformMore;

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\Field\SubformField;
use Joomla\CMS\HTML\HTMLHelper;

class SubformmoreField extends SubformField
{

	protected $name = 'subformmore';


	protected $layout = 'subformmore';


	public function getLayoutPaths()
	{
		return array_merge([__DIR__ . '/layouts'], parent::getLayoutPaths());
	}


	public function getLayoutData()
	{
		return parent::getLayoutData(); // TODO: Change the autogenerated stub
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

		return parent::getInput(); // TODO: Change the autogenerated stub
	}


}