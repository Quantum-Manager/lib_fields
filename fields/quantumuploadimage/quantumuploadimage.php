<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Uri\Uri;

defined('JPATH_PLATFORM') or die;

JLoader::register('JFormFieldQuantumupload', JPATH_ROOT . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, [
	'administrator', 'components', 'com_quantummanager', 'fields', 'quantumupload.php'
]));

/**
 * Form Field class for the Joomla Platform.
 * Supports an HTML select list of categories
 *
 * @since  1.6
 */
class JFormFieldQuantumuploadimage extends JFormFieldQuantumupload
{

	/**
	 * @var string
	 */
	public $type = 'QuantumUploadImage';

	/**
	 * @return array
	 */
	protected function getLayoutData()
	{
		$layout = new FileLayout('pickimage', __DIR__ . DIRECTORY_SEPARATOR . 'layouts');
		$other = $layout->render(array_merge(parent::getLayoutData(),
			[
				'uploadAreaHidden' => $this->uploadAreaHidden
			]));

		return array_merge(parent::getLayoutData(),
			[
				'other' => $other,
			]
		);
	}

	public function getInput()
	{
		try
		{
			$this->__set('uploadAreaHidden', $this->getAttribute('uploadAreaHidden', true));
			return parent::getInput();
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}

}