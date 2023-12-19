<?php namespace JPATHRU\Libraries\Fields\Field\UsersGroup;

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
use Joomla\CMS\Form\Field\ListField;
use stdClass;

class UsersgroupField extends ListField
{

	protected $type = 'usersgroup';


	protected $_options = null;


	protected function getOptions()
	{

		if ($this->_options === null)
		{
			// Get components
			$db     = Factory::getDbo();
			$query  = $db->getQuery(true)
				->select(['id', 'title'])
				->from($db->quoteName('#__usergroups'));
			$groups = $db->setQuery($query)->loadObjectList();

			foreach ($groups as $group)
			{
				$option        = new stdClass();
				$option->value = $group->id;
				$option->text  = $group->title;
				$options[]     = $option;
			}

			$this->_options = $options;
		}

		return $this->_options;
	}
}