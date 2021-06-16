<?php
/**
 * @package     Joomla.Legacy
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;

defined('JPATH_PLATFORM') or die;

FormHelper::loadFieldClass('text');

/**
 * Form Field class for the Joomla Platform.
 * Supports an HTML select list of categories
 *
 * @since  1.6
 */
class JFormFieldYandexmapfield extends JFormFieldText
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.6
	 */
	public $type = 'YandexMapField';


	protected $id_for_maps = '';

	/**
	 *
	 * @return string
	 *
	 * @since version
	 */
	protected function getInput()
	{
		HTMLHelper::_( 'jquery.framework' );
		Factory::getDocument()->addScript('https://api-maps.yandex.ru/2.1/?lang=ru_RU');
		Factory::getDocument()->addScript('/plugins/fields/yandexmapfield/assets/js/yandexmapfield.js');

		$id = "in-yandex-maps-" . rand(1111, 9999);
		$this->class = "in-yandex-maps span6 " . $this->class;
		$this->id = $id;
		return parent::getInput();
	}


	/**
	 * Method to get the data to be passed to the layout for rendering.
	 *
	 * @return  array
	 *
	 * @since 3.5
	 */
	protected function getLayoutData()
	{
		// Label preprocess
		$label = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];
		$label = $this->translateLabel ? \JText::_($label) : $label;

		// Description preprocess
		$description = !empty($this->description) ? $this->description : null;
		$description = !empty($description) && $this->translateDescription ? \JText::_($description) : $description;

		$alt = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname);

		return array(
			'autocomplete'   => $this->autocomplete,
			'autofocus'      => $this->autofocus,
			'class'          => $this->class,
			'description'    => $description,
			'disabled'       => $this->disabled,
			'field'          => $this,
			'group'          => $this->group,
			'hidden'         => $this->hidden,
			'hint'           => $this->translateHint ? \JText::alt($this->hint, $alt) : $this->hint,
			'id'             => $this->id,
			'label'          => $label,
			'labelclass'     => $this->labelclass,
			'multiple'       => $this->multiple,
			'name'           => $this->name,
			'onchange'       => $this->onchange,
			'onclick'        => $this->onclick,
			'pattern'        => $this->pattern,
			'validationtext' => $this->validationtext,
			'readonly'       => $this->readonly,
			'repeat'         => $this->repeat,
			'required'       => (bool) $this->required,
			'size'           => $this->size,
			'spellcheck'     => $this->spellcheck,
			'validate'       => $this->validate,
			'value'          => $this->value,
		);
	}

}
