<?php

namespace JPATHRU\Libraries\Fields\Modal;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\WebAsset\WebAssetManager;
use Joomla\Database\DatabaseDriver;
use RuntimeException;

class ModuleidField extends FormField
{

	const BTN_VALUE = 'Выбери модуль';

	protected static $declareScriptFlag = true;

	protected $name = 'Moduleid';

	public function getInput()
	{

		HTMLHelper::_('behavior.modal', 'a.modal');

		/** @var DatabaseDriver $db */
		$db = Factory::getContainer()->get(DatabaseDriver::class);
		$db->setQuery('SELECT id, title FROM #__modules');

		try
		{
			$data  = $db->loadObjectList('id');
			$title = $data[$this->value]->title;
		}
		catch (RuntimeException $e)
		{
			throw new \RuntimeException($e->getMessage(), 500);
		}

		if (self::$declareScriptFlag)
		{
			$script   = array();
			$script[] = '	function jInsertEditorText(text, elementId) {';
			$script[] = '       var moduleData = ' . json_encode($data) . ';';
			$script[] = '       text = text.replace( /^\D+|[{}]/g, \'\'); ';
			$script[] = '		document.id(elementId+"_id").value = text;';
			$script[] = '		document.id(elementId+"_name").value = moduleData[text]["title"];';
			$script[] = '		SqueezeBox.close();';
			$script[] = '	}';

			/** @var WebAssetManager $wa */
			$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
			$wa->addInlineScript(implode("\n", $script));

			self::$declareScriptFlag = false;
		}


		if (empty($title))
		{
			$title = Text::_('JSELECT');
		}
		$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

		$value = (int) $this->value ? (int) $this->value : '';
		$class = $this->required ? ' class="required modal-value"' : '';

		$link = 'index.php?option=com_modules&view=modules&layout=modal&tmpl=component&function=jInsertEditorText&editor=' . $this->id;

		$html   = [];
		$html[] = '<span class="input-append">';
		$html[] =
			'<input type="text" class="input-medium" id="' . $this->id . '_name" value="' . $title . '" disabled="disabled" size="35" />
        <a class="modal btn" title="' . Text::_('COM_HZCATALOG_CHANGE_BID') . '"  href="' . $link . '&amp;' . Factory::getApplication()->getSession()->getFormToken() . '=1" rel="{handler: \'iframe\', size: {x: 800, y: 450}}">
        <i class="icon-file"></i> ' . Text::_(self::BTN_VALUE) . '
        </a>';
		$html[] = '</span>';
		$html[] = '<input type="hidden" id="' . $this->id . '_id"' . $class . ' name="' . $this->name . '" value="' . $value . '" />';

		return implode("\n", $html);
	}

}
