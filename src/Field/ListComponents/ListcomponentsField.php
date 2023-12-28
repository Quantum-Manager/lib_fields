<?php namespace JPATHRU\Libraries\Fields\Field\ListComponents;

/**
 * @package     Joomla! fields library
 * @subpackage  Components list field
 * @version     1.1.0
 * @since       1.1.0
 * @author      Septdir Workshop - www.septdir.com
 * @copyright   Copyright (c) 2018 - 2019 Septdir Workshop. All rights reserved.
 * @copyright   Copyright (c) 2020 Webmasterskaya. All rights reserved.
 * @copyright   Copyright (c) 2020 JPathRu. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://www.septdir.com/
 * @link        https://webmasterskaya.xyz/
 * @link        https://jpath.ru/
 */

defined('_JEXEC') or die;

use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Version;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Language\Text;
use stdClass;

class ListcomponentsField extends ListField
{
	/**
	 * The form field type.
	 *
	 * @var  string
	 *
	 * @since  1.1.0
	 */
	protected $type = 'ListComponents';


	/**
	 * Field options array.
	 *
	 * @var  array
	 *
	 * @since  1.1.0
	 */
	protected $_options = null;


	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @throws  Exception
	 *
	 * @since  1.1.0
	 */
	protected function getOptions()
	{

		if ($this->_options === null)
		{
			// Get components
			$db             = Factory::getDbo();
			$query          = $db->getQuery(true)
				->select(array('e.element'))
				->from($db->quoteName('#__extensions', 'e'))
				->where($db->quoteName('e.type') . '=' . $db->quote('component'))
				->where('e.enabled = 1');
			$elements       = $db->setQuery($query)->loadColumn();
			$rootComponents = JPATH_ROOT;
			$client         = $this->getAttribute('client', 'site');

			if ($client === 'administrator')
			{
				$rootComponents = JPATH_ADMINISTRATOR;
			}

			$components = array();
			foreach ($elements as $component)
			{
				$folder = $this->checkFolder($component, $rootComponents);
				if ($folder !== false && Folder::exists($folder))
				{
					foreach (Folder::folders($folder) as $view)
					{
						if (dirname($folder, 1) === 'tmpl' && $this->checkEditOption($folder, $view) === false)
						{
							continue;
						}

						if (!isset($views[$component]))
						{
							$views[$component] = array();
						}
						$components[$component][$view] = array();
					}
				}
			}


			// Convert options
			$options = parent::getOptions();

			foreach ($options as $key => $option)
			{
				if (!empty($option->value))
				{
					$explode   = explode('.', $option->value, 2);
					$component = (!empty($explode[0])) ? $explode[0] : false;
					$view      = (!empty($explode[1])) ? $explode[1] : false;
					if ($component && $view && in_array($component, $elements))
					{
						$explode = explode(':', $view, 2);
						$view    = $explode[0];
						$layout  = (!empty($explode[1])) ? $explode[1] : false;

						if (!isset($components[$component]))
						{
							$components[$component] = array();
						}
						if (!isset($components[$component][$view]))
						{
							$components[$component][$view] = array();
						}
						if ($layout && !in_array($layout, $components[$component][$view]))
						{
							$components[$component][$view][] = $layout;
						}

						unset($options[$key]);
					}
				}

			}

			// Prepare options
			$pluginConstant = 'LIB_FIELDS_FIELD_LIST_COMPONENTS';
			$language       = Factory::getLanguage();
			$language_tag   = $language->getTag();
			$language->load('lib_fields', JPATH_SITE, $language_tag, true);
			foreach ($components as $component => $views)
			{
				$componentValue    = $component;
				$componentConstant = $pluginConstant . '_' . str_replace('com_', '', $component);
				$componentText     = ($language->hasKey($componentConstant)) ? Text::_($componentConstant) :
					ucfirst(str_replace('com_', '', $component));

				// Add views
				foreach ($views as $view => $layouts)
				{
					$viewValue    = $componentValue . '.' . $view;
					$viewConstant = $componentConstant . '_' . $view;
					$viewText     = $componentText . ': ';
					$viewText     .= ($language->hasKey($viewConstant)) ? Text::_($viewConstant) : ucfirst($view);

					$option        = new stdClass();
					$option->value = $viewValue;
					$option->text  = $viewText;
					$options[]     = $option;

					// Add layouts
					foreach ($layouts as $layout)
					{
						$layoutValue    = $viewValue . ':' . $layout;
						$layoutConstant = $viewConstant . '_' . $layout;
						$layoutText     = $viewText . ' (';
						$layoutText     .= ($language->hasKey($layoutConstant)) ? Text::_($layoutConstant) : ucfirst($layout);
						$layoutText     .= ')';

						$option        = new stdClass();
						$option->value = $layoutValue;
						$option->text  = $layoutText;
						$options[]     = $option;
					}
				}
			}

			$this->_options = $options;
		}

		return $this->_options;
	}

	/**
	 * Check if relevant folder exists with different paths for J3 and J4
	 *
	 * @param   string  $component
	 * @param   string  $rootComponents
	 *
	 * @return string|bool
	 */
	private static function checkFolder(string $component, string $rootComponents = JPATH_ROOT)
	{
		$jversion = new Version();
		$folder   = Path::clean($rootComponents . '/components/' . $component . '/views');
		if (Folder::exists($folder))
		{
			return $folder;
		}
		elseif (version_compare($jversion->getShortVersion(), '4.0', '>='))
		{
			$folder = Path::clean($rootComponents . '/components/' . $component . '/tmpl');
			if (Folder::exists($folder))
			{
				return $folder;
			}
		}

		return false;
	}

	/**
	 * Check if there is an edit option in views for J4
	 *
	 * @param   string  $folder
	 * @param   string  $view
	 *
	 * @return bool
	 */
	private static function checkEditOption(string $folder, string $view)
	{
		$editFile = $folder . DIRECTORY_SEPARATOR . $view . DIRECTORY_SEPARATOR . 'edit.php';
		if (File::exists($editFile))
		{
			return true;
		}

		return false;

	}
}
