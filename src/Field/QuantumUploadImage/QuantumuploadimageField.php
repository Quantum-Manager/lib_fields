<?php namespace JPATHRU\Libraries\Fields\Field\QuantumUploadImage;

defined('JPATH_PLATFORM') or die;

use Exception;
use Joomla\CMS\Layout\FileLayout;
use Joomla\Component\QuantumManager\Administrator\Field\QuantumuploadField;
use Joomla\Component\QuantumManager\Administrator\Helper\QuantummanagerLibsHelper;

/**
 * Form Field class for the Joomla Platform.
 * Supports an HTML select list of categories
 *
 * @since  1.6
 */
class QuantumuploadimageField extends QuantumuploadField
{

	/**
	 * @var string
	 */
	public $type = 'quantumuploadimage';

	public $render = '';

	protected $copy = false;

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
				QuantummanagerLibsHelper::includes([
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