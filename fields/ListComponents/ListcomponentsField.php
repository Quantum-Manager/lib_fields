<?php

namespace JPATHRU\Libraries\Fields\ListComponents;

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

use Joomla\CMS\Factory;
use Joomla\Filesystem\File;
use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Version;
use Joomla\Filesystem\Folder;
use Joomla\Filesystem\Path;
use Joomla\CMS\Language\Text;
use Joomla\Database\DatabaseDriver;
use stdClass;

class ListcomponentsField extends ListField
{

	protected $type = 'Listcomponents';

	protected $_options = null;

	protected function getOptions()
	{

		if ($this->_options === null)
		{
			/** @var DatabaseDriver $db */
			$db             = Factory::getContainer()->get(DatabaseDriver::class);
			$query          = $db->getQuery(true)
				->select(['e.element'])
				->from($db->quoteName('#__extensions', 'e'))
				->where($db->quoteName('e.type') . '=' . $db->quote('component'))
				->where('e.enabled = 1');
			$elements       = $db->setQuery($query)->loadColumn();
			$rootComponents = [JPATH_ROOT, JPATH_ADMINISTRATOR];

			$components = [];
			foreach ($elements as $component)
			{
				foreach ($rootComponents as $rootComponent)
				{
					$folder = $this->checkFolder($component, $rootComponent);
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
								$views[$component] = [];
							}
							$components[$component][$view] = [];
						}
					}
				}
			}

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
							$components[$component] = [];
						}
						if (!isset($components[$component][$view]))
						{
							$components[$component][$view] = [];
						}
						if ($layout && !in_array($layout, $components[$component][$view]))
						{
							$components[$component][$view][] = $layout;
						}

						unset($options[$key]);
					}
				}

			}

			$pluginConstant = 'LIB_FIELDS_FIELD_LIST_COMPONENTS';
			$language       = Factory::getApplication()->getLanguage();
			$language_tag   = $language->getTag();
			$language->load('lib_fields', JPATH_SITE, $language_tag, true);
			foreach ($components as $component => $views)
			{
				$componentValue    = $component;
				$componentConstant = $pluginConstant . '_' . str_replace('com_', '', $component);
				$componentText     = ($language->hasKey($componentConstant)) ? Text::_($componentConstant) :
					ucfirst(str_replace('com_', '', $component));

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
