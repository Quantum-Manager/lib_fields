<?php defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Layout\FileLayout;

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


	public $render = '';

	/**
	 * @return array
	 */
	protected function getLayoutData()
	{
		$layout     = new FileLayout('pickimage', __DIR__ . DIRECTORY_SEPARATOR . 'layouts');
		$parentData = parent::getLayoutData();

		if (isset($this->dropAreaHidden) && (int) $this->dropAreaHidden)
		{
			$parentData['cssClass'] .= ' quantumuploadimage-field-preview-hidden';
		}

		if (empty($this->render))
		{
			$this->render = $layout->render(array_merge($parentData, [
				'copy' => $this->copy
			]));
		}

		$other                  = $this->render;
		$parentData['cssClass'] .= ' quantumuploadimage-field';

		return array_merge($parentData,
			[
				'other' => $other,
			]
		);
	}

	public function getInput()
	{
		try
		{
			$this->__set('dropAreaHidden', $this->getAttribute('dropAreaHidden', true));
			$this->__set('copy', $this->getAttribute('copy', true));

			if ($this->copy)
			{
				JLoader::register('QuantummanagerLibs', JPATH_SITE . '/administrator/components/com_quantummanager/helpers/quantumlibs.php');

				QuantummanagerLibs::includes([
					'utils',
					'notify',
					'clipboard'
				]);
			}

			return parent::getInput();
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}

}