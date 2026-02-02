<?php

namespace JPATHRU\Libraries\Fields\QuantumUploadImage;

defined('_JEXEC') or die;

use Exception;
use Joomla\CMS\Layout\FileLayout;
use Joomla\Component\QuantumManager\Administrator\Field\QuantumuploadField;
use Joomla\Component\QuantumManager\Administrator\Helper\QuantummanagerLibsHelper;

class QuantumuploadimageField extends QuantumuploadField
{

	public $type = 'Quantumuploadimage';

	public $render = '';

	protected $copy = false;

	protected function getLayoutData(): array
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

	public function getInput(): string
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