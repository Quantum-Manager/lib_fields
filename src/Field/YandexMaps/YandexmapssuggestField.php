<?php namespace JPATHRU\Libraries\Fields\Field\YandexMaps;

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\TextField;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;

/**
 * Form Field class for the Joomla Platform.
 * Supports an HTML select list of categories
 *
 * @since  1.6
 */
class YandexmapssuggestField extends TextField
{


	public $type = 'YandexMapSsuggest';


	protected function getInput()
	{
		Factory::getDocument()->addScript('https://api-maps.yandex.ru/2.1/?lang=ru_RU');

		HTMLHelper::script('lib_fields/yandexmaps/suggest.js', [
			'version'  => filemtime(__FILE__),
			'relative' => true,
		]);

		$id          = "in-yandex-maps-" . random_int(1111, 9999);
		$this->class = "in-yandex-maps span6 " . $this->class;
		$this->id    = $id;

		return '<div style="position: relative;">' . parent::getInput() . '</div>';
	}

}
