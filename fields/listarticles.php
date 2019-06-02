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

FormHelper::loadFieldClass('list');

/**
 * Form Field class for the Joomla Platform.
 * Supports an HTML select list of categories
 *
 * @since  1.6
 */
class JFormFieldListarticles extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.6
	 */
	public $type = 'ListArticles';

	/**
	 *
	 * @return string
	 *
	 * @since version
	 */
	public function getInput()
	{
		try {
			HTMLHelper::addIncludePath(JPATH_ROOT . '/libraries/lib_fields/helpers');

			$filters['filter.q'] = $this->getAttribute('q', '');
			$filters['filter.limit'] = $this->getAttribute('limit', '');
			$filters['filter.published'] = $this->getAttribute('published', '');
			$filters['filter.language'] = $this->getAttribute('language', '');
			$filters['filter.ids'] = $this->getAttribute('ids', '');
			$filters['filter.category'] = $this->getAttribute('category', '');
			$filtersClean = [];

			foreach ($filters as $key => $filter) {
				if (empty($filter)) {
					continue;
				}

				$value = $filter;
				if (in_array($key, ['filter.published', 'filter.ids'])) {
					$value = explode(',', $value);
				}

				$filtersClean[$key] = $value;
			}

			$options = HTMLHelper::_('articles.options', $filtersClean);

			foreach ($options as $option) {
				$this->addOption($option->text, ['value' => $option->key]);
			}

			return parent::getInput();
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}

}
